<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                if($data->status){
                    if($data->stt_publish){
                        $button .= '<a type="button" data-toggle="tooltip" title="Publish" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="publish btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-undo"></i></a>';
                    } else {
                        $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" status="" nama="'.$data->name.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Publish" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="publish btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-paper-plane"></i></a>';
                    }
                } else {
                    $button .= '<a type="button" data-toggle="tooltip" title="Hapus Permanen" id="'.Crypt::encrypt($data->id).'" status="Permanen " nama="'.$data->name.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash-alt"></i></a>';
                    $button .= '<a type="button" data-toggle="tooltip" title="Aktifkan" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="aktif btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-lightbulb-on"></i></a>';
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
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

            $diff_month = Periode::diffInMonth($periode);

            $input['tempat_usaha'] = $request->tambah_tempat;

            $los = $this->multipleSelect($request->tambah_los);
            sort($los, SORT_NATURAL);
            $input['nomor_los'] = $los;
            $jml_los = count($input['nomor_los']);

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

                $tagihan = Tarif::listrik($tarif->data, $pakai, $daya, $diff_month, $input['diskon_listrik']);

                $data['listrik'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'alat'          => $input['alat_listrik'],
                    'tarif'         => $input['tarif_listrik'],
                    'daya'          => (int)$daya,
                    'awal'          => (int)$awal,
                    'akhir'         => (int)$akhir,
                    'reset'         => (int)$reset,
                    'pakai'         => (int)$pakai,
                    'rekmin'        => (int)$tagihan['rekmin'],
                    'blok1'         => (int)$tagihan['blok1'],
                    'blok2'         => (int)$tagihan['blok2'],
                    'beban'         => (int)$tagihan['beban'],
                    'pju'           => (int)$tagihan['pju'],
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'ppn'           => (int)$tagihan['ppn'],
                    'denda'         => (int)$tagihan['denda'],
                    'denda_bulan'   => (int)$diff_month,
                    'diskon'        => (int)$tagihan['diskon'],
                    'diskon_persen' => (int)$input['diskon_listrik'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $ppn += $tagihan['ppn'];
                $denda += $tagihan['denda'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_airbersih){
                $input['alat_airbersih'] = $request->tambah_alat_airbersih;
                $input['tarif_airbersih'] = $request->tambah_trf_airbersih;
                $input['diskon_airbersih'] = $request->tambah_dis_airbersih;
                $input['awal_stand_airbersih'] = str_replace('.', '', $request->tambah_awal_airbersih);
                $input['akhir_stand_airbersih'] = str_replace('.', '', $request->tambah_akhir_airbersih);

                $tarif = Tarif::findOrFail($input['tarif_airbersih']);
                $alat = Alat::findOrFail($input['alat_airbersih']);

                $awal = $input['awal_stand_airbersih'];
                $akhir = $input['akhir_stand_airbersih'];

                $pakai = $akhir - $awal;
                $reset = 0;
                if($awal > $akhir){
                    $pakai = ($akhir + (str_repeat(9, strlen($awal)))) - $awal;
                    $reset = 1;
                }

                $tagihan = Tarif::airbersih($tarif->data, $pakai, $diff_month, $input['diskon_airbersih']);

                $data['airbersih'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'alat'          => $input['alat_airbersih'],
                    'tarif'         => $input['tarif_airbersih'],
                    'awal'          => (int)$awal,
                    'akhir'         => (int)$akhir,
                    'reset'         => (int)$reset,
                    'pakai'         => (int)$pakai,
                    'bayar'         => (int)$tagihan['bayar'],
                    'pemeliharaan'  => (int)$tagihan['pemeliharaan'],
                    'beban'         => (int)$tagihan['beban'],
                    'airkotor'      => (int)$tagihan['airkotor'],
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'ppn'           => (int)$tagihan['ppn'],
                    'denda'         => (int)$tagihan['denda'],
                    'denda_bulan'   => (int)$diff_month,
                    'diskon'        => (int)$tagihan['diskon'],
                    'diskon_persen' => (int)$input['diskon_airbersih'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $ppn += $tagihan['ppn'];
                $denda += $tagihan['denda'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_keamananipk){
                $input['tarif_keamananipk'] = $request->tambah_trf_keamananipk;
                $input['diskon_keamananipk'] = str_replace('.', '', $request->tambah_dis_keamananipk);

                $tarif = Tarif::findOrFail($input['tarif_keamananipk']);

                $tagihan = Tarif::keamananipk($tarif->data, $jml_los, $input['diskon_keamananipk']);

                $data['keamananipk'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'tarif'         => $input['tarif_keamananipk'],
                    'jml_los'       => (int)$jml_los,
                    'keamanan'      => (int)$tagihan['keamanan'],
                    'ipk'           => (int)$tagihan['ipk'],
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'diskon'        => (int)$tagihan['diskon'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_kebersihan){
                $input['tarif_kebersihan'] = $request->tambah_trf_kebersihan;
                $input['diskon_kebersihan'] = str_replace('.', '', $request->tambah_dis_kebersihan);

                $tarif = Tarif::findOrFail($input['tarif_kebersihan']);

                $tagihan = Tarif::kebersihan($tarif->data, $jml_los, $input['diskon_kebersihan']);

                $data['kebersihan'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'tarif'         => $input['tarif_kebersihan'],
                    'jml_los'       => (int)$jml_los,
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'diskon'        => (int)$tagihan['diskon'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_airkotor){
                $input['tarif_airkotor'] = $request->tambah_trf_airkotor;
                $input['diskon_airkotor'] = str_replace('.', '', $request->tambah_dis_airkotor);

                $tarif = Tarif::findOrFail($input['tarif_airkotor']);

                $tagihan = Tarif::airkotor($tarif->data, $jml_los, $tarif->status, $input['diskon_airkotor']);

                $data['airkotor'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'tarif'         => $input['tarif_airkotor'],
                    'jml_los'       => (int)$jml_los,
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'diskon'        => (int)$tagihan['diskon'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_lainnya){
                $lainnya = [];
                $subtotal_lainnya = 0;
                $total_lainnya = 0;
                foreach ($request->tambah_lainnya as $key) {
                    $input['tarif_lainnya']  = $key;
                    $tarif = Tarif::findOrFail($input['tarif_lainnya']);

                    $tagihan = Tarif::lainnya($tarif->data, $jml_los, $tarif->status);

                    $lainnya[] = [
                        'tarif'     => $input['tarif_lainnya'],
                        'subtotal'  => (int)$tagihan['subtotal'],
                        'total'     => (int)$tagihan['total']
                    ];

                    $subtotal_lainnya += $tagihan['subtotal'];
                    $total_lainnya += $tagihan['total'];
                }

                $data['lainnya'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'data'          => $lainnya,
                    'jml_los'       => $jml_los,
                    'subtotal'      => (int)$subtotal_lainnya,
                    'total'         => (int)$total_lainnya,
                    'realisasi'     => 0,
                    'selisih'       => (int)$total_lainnya,
                ]);

                $subtotal += $subtotal_lainnya;
                $total += $total_lainnya;
            }

            $tempat = Tempat::findOrFail($input['tempat_usaha']);
            $data['code'] = Tagihan::code();
            $data['periode_id'] = $input['periode'];
            $data['name'] = $tempat->name;
            $data['nicename'] = $tempat->nicename;
            $data['pengguna_id'] = $input['pengguna'];
            $data['group_id'] = $tempat->group_id;
            $data['los'] = json_encode($input['nomor_los']);
            $data['jml_los'] = $jml_los;
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
    public function destroy($id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            DB::transaction(function() use ($decrypted){
                $data = Tagihan::lockForUpdate()->findOrFail($decrypted);

                if($data->status){
                    $data->update([
                        'status' => 0
                    ]);
                } else {
                    $data->delete();
                }
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }

    public function publish($id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $message = DB::transaction(function() use ($decrypted){
                $data = Tagihan::lockForUpdate()->findOrFail($decrypted);

                if($data->stt_publish){
                    $publish = 0;
                    $message = 'Data Tagihan dibatalkan.';
                } else {
                    $publish = 1;
                    $message = 'Data Tagihan dipublish.';
                }

                $data->update([
                    'stt_publish' => $publish
                ]);

                return $message;
            });
            return response()->json(['success' => $message]);
        }
    }

    public function aktif($id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $message = DB::transaction(function() use ($decrypted){
                $data = Tagihan::lockForUpdate()->findOrFail($decrypted);

                $data->update([
                    'status' => 1
                ]);
            });
            return response()->json(['success' => 'Data berhasil diaktifkan.']);
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
