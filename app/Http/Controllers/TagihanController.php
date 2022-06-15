<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Tempat;
use App\Models\Group;
use App\Models\Tarif;
use App\Models\Periode;
use App\Models\Alat;
use App\Models\Tagihan;

use Carbon\Carbon;

use Excel;
use DataTables;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $status = $request->status;
            $periode = $request->periode;

            $data = Tagihan::with('pengguna:id,name')->where([
                ['status', $status],
                ['periode_id', $periode]
            ]);

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Publish" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="publlish btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-paper-plane"></i></a>';
                return $button;
            })
            ->addColumn('fasilitas', function($data){
                $listrik = ($data->listrik) ? '<a type="button" data-toggle="tooltip" title="Listrik"><i class="fas fa-bolt" style="color:#fd7e14;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-bolt" style="color:#d7d8cc;"></i></a>';
                $airbersih = ($data->airbersih) ? '<a type="button" data-toggle="tooltip" title="Air Bersih"><i class="fas fa-tint" style="color:#36b9cc"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-tint" style="color:#d7d8cc;"></i></a>';;
                $keamananipk = ($data->keamananipk) ? '<a type="button" data-toggle="tooltip" title="Keamanan IPK"><i class="fas fa-lock" style="color:#e74a3b;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-lock" style="color:#d7d8cc;"></i></a>';
                $kebersihan = ($data->kebersihan) ? '<a type="button" data-toggle="tooltip" title="Kebersihan"><i class="fas fa-leaf" style="color:#1cc88a;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-leaf" style="color:#d7d8cc;"></i></a>';
                $airkotor = ($data->airkotor) ? '<a type="button" data-toggle="tooltip" title="Air Kotor"><i class="fad fa-burn" style="color:#000000;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-burn" style="color:#d7d8cc;"></i></a>';
                $lainnya = ($data->lainnya) ? '<a type="button" data-toggle="tooltip" title="Lainnya"><i class="fas fa-chart-pie" style="color:#c5793a;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-chart-pie" style="color:#d7d8cc;"></i></a>';
                return $listrik."&nbsp;&nbsp;".$airbersih."&nbsp;&nbsp;".$keamananipk."&nbsp;&nbsp;".$kebersihan."&nbsp;&nbsp;".$airkotor."&nbsp;&nbsp;".$lainnya;
            })
            ->editColumn('pengguna.name', function($data){
                $name = $data->pengguna->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='" . $data->pengguna->name . "'>$name</span>";
            })
            ->editColumn('tagihan', function($data){
                return number_format($data->tagihan->total, 0, ',', '.');
            })
            ->filterColumn('name', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(name, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'fasilitas', 'name', 'pengguna.name', 'tagihan'])
            ->make(true);
        }
        return view('Tagihan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $input['periode'] = $request->tambah_periode;
            $periode = Periode::findOrFail($input['periode']);

            // PR MENCARI DIFF
            $due = new Carbon($periode->due);
            $now = Carbon::now()->format('Y-m-d');
            $diff_month = 0;
            if($now > $due){
                $diff_month = $due->diffInMonths($now);
                $diff_day   = $due->diffInDays($now);
                if($diff_day >= 1){
                    $diff_month++;
                }
            }
            // END DIFF

            $input['tempat_usaha'] = $request->tambah_tempat;

            $los = $this->multipleSelect($request->tambah_los);
            sort($los, SORT_NATURAL);
            $input['nomor_los'] = $los;

            $input['pengguna'] = $request->tambah_pengguna;

            $subtotal = 0;
            $denda = 0;
            $diskon = 0;
            $ppn = 0;
            $total = 0;

            if($request->tambah_listrik){
                $input['alat_listrik'] = $request->tambah_alat_listrik;
                $input['tarif_listrik'] = $request->tambah_trf_listrik;
                $input['diskon_listrik'] = $request->tambah_dis_listrik;
                $input['awal_stand_listrik'] = str_replace('.', '', $request->tambah_awal_listrik);
                $input['akhir_stand_listrik'] = str_replace('.', '', $request->tambah_akhir_listrik);

                $tarif = Tarif::findOrFail($input['tarif_listrik']);
                $alat = Alat::findOrFail($input['alat_listrik']);

                $daya = $alat->daya;
                $awal = $input['awal_stand_listrik'];
                $akhir = $input['akhir_stand_listrik'];

                $pakai = $akhir - $awal;
                $reset = 0;
                if($awal > $akhir){
                    $pakai = ($akhir + (str_repeat(9, strlen($awal)))) - $awal;
                    $reset = 1;
                }

                $tagihan = Tarif::tagihanL($tarif->data, $pakai, $daya, $diff_month, $input['diskon_listrik']);

                $data['listrik'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'alat'          => $input['alat_listrik'],
                    'tarif'         => $input['tarif_listrik'],
                    'daya'          => $daya,
                    'awal'          => $awal,
                    'akhir'         => $akhir,
                    'reset'         => $reset,
                    'pakai'         => $pakai,
                    'rekmin'        => $tagihan['rekmin'],
                    'blok1'         => $tagihan['blok1'],
                    'blok2'         => $tagihan['blok2'],
                    'beban'         => $tagihan['beban'],
                    'pju'           => $tagihan['pju'],
                    'subtotal'      => $tagihan['subtotal'],
                    'ppn'           => $tagihan['ppn'],
                    'denda'         => $tagihan['denda'],
                    'denda_bulan'   => $diff_month,
                    'diskon'        => $tagihan['diskon'],
                    'diskon_persen' => $input['diskon_listrik'],
                    'total'         => $tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => $tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $ppn += $tagihan['ppn'];
                $denda += 0;
                $diskon += 0;
                $total += $tagihan['total'];
            }

            if($request->tambah_airbersih){

            }

            if($request->tambah_keamananipk){

            }

            if($request->tambah_kebersihan){

            }

            if($request->tambah_airkotor){

            }

            if($request->tambah_lainnya){

            }

            $tempat = Tempat::findOrFail($input['tempat_usaha']);
            $data['code'] = Tagihan::code();
            $data['periode_id'] = $input['periode'];
            $data['name'] = $tempat->name;
            $data['nicename'] = $tempat->nicename;
            $data['pengguna_id'] = $input['pengguna'];
            $data['group_id'] = $tempat->group_id;
            $data['los'] = json_encode($input['nomor_los']);
            $data['jml_los'] = count($input['nomor_los']);
            $data['tagihan'] = json_encode([
                'subtotal'  => $subtotal,
                'ppn'       => $ppn,
                'denda'     => $denda,
                'diskon'    => $diskon,
                'total'     => $total,
                'realisasi' => 0,
                'selisih'   => $total
            ]);

            Tagihan::create($data);

            return response()->json(['success' => 'Data berhasil disimpan.', 'debug' => $input['periode']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $input['status'] = $request->del_status;
            Validator::make($input, [
                'status' => 'required|numeric|in:2,0'
            ])->validate();

            DB::transaction(function() use ($decrypted, $input){
                $data = Tagihan::lockForUpdate()->findOrFail($decrypted);

                $data->update([
                    'status' => $input['status']
                ]);
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }

    public function publish($id)
    {
        if(request()->ajax()){
            $message = '';
            return response()->json(['success' => "Data berhasil " . $message]);
        }
    }

    public function tempat($id)
    {
        if(request()->ajax()){
            $data = Tempat::with('group', 'pengguna')->findOrFail($id);

            if($data->trf_listrik_id){
                $data['trf_listrik_id']  = Tarif::findOrFail($data->trf_listrik_id);
                $data['alat_listrik_id'] = Alat::findOrFail($data->alat_listrik_id);
            }

            if($data->trf_airbersih_id){
                $data['trf_airbersih_id']  = Tarif::findOrFail($data->trf_airbersih_id);
                $data['alat_airbersih_id'] = Alat::findOrFail($data->alat_airbersih_id);
            }

            if($data->trf_keamananipk_id){
                $data['trf_keamananipk_id'] = Tarif::findOrFail($data->trf_keamananipk_id);
            }

            if($data->trf_kebersihan_id){
                $data['trf_kebersihan_id'] = Tarif::findOrFail($data->trf_kebersihan_id);
            }

            if($data->trf_airkotor_id){
                $data['trf_airkotor_id'] = Tarif::findOrFail($data->trf_airkotor_id);
            }

            if($data->trf_lainnya_id){
                $lainnya = [];
                foreach ($data->trf_lainnya_id as $key) {
                    $lainnya[] = Tarif::findOrFail($key);
                }
                $data['trf_lainnya'] = $lainnya;
            }

            return response()->json(['success' => $data]);
        }
    }

    public function multipleSelect($data){
        $temp = [];
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
    }
}
