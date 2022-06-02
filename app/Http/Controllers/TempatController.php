<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Tempat;
use App\Models\Group;
use App\Models\Tarif;
use App\Models\Periode;
use App\Models\Alat;

use Carbon\Carbon;

use Excel;
use DataTables;

class TempatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Tempat::with('pengguna:id,name');

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->addColumn('fasilitas', function($data){
                $listrik = ($data->trf_listrik_id) ? '<a type="button" data-toggle="tooltip" title="Listrik"><i class="fas fa-bolt" style="color:#fd7e14;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-bolt" style="color:#d7d8cc;"></i></a>';
                $airbersih = ($data->trf_airbersih_id) ? '<a type="button" data-toggle="tooltip" title="Air Bersih"><i class="fas fa-tint" style="color:#36b9cc"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-tint" style="color:#d7d8cc;"></i></a>';;
                $keamananipk = ($data->trf_keamananipk_id) ? '<a type="button" data-toggle="tooltip" title="Keamanan IPK"><i class="fas fa-lock" style="color:#e74a3b;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-lock" style="color:#d7d8cc;"></i></a>';
                $kebersihan = ($data->trf_kebersihan_id) ? '<a type="button" data-toggle="tooltip" title="Kebersihan"><i class="fas fa-leaf" style="color:#1cc88a;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-leaf" style="color:#d7d8cc;"></i></a>';
                $airkotor = ($data->trf_airkotor_id) ? '<a type="button" data-toggle="tooltip" title="Air Kotor"><i class="fad fa-burn" style="color:#000000;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-burn" style="color:#d7d8cc;"></i></a>';
                $lainnya = ($data->trf_lainnya_id) ? '<a type="button" data-toggle="tooltip" title="Lainnya"><i class="fas fa-chart-pie" style="color:#c5793a;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip"><i class="fas fa-chart-pie" style="color:#d7d8cc;"></i></a>';
                return $listrik."&nbsp;&nbsp;".$airbersih."&nbsp;&nbsp;".$keamananipk."&nbsp;&nbsp;".$kebersihan."&nbsp;&nbsp;".$airkotor."&nbsp;&nbsp;".$lainnya;
            })
            ->editColumn('name', function($data){
                if($data->status == 2){
                    $button = 'text-primary';
                }
                else if($data->status == 1){
                    $button = 'text-success';
                }
                else{
                    $button = 'text-danger';
                }
                return "<span class='$button'><b>$data->name</b></span>";
            })
            ->editColumn('jml_los', function($data){
                return number_format($data->jml_los);
            })
            ->editColumn('pengguna.name', function($data){
                $name = $data->pengguna->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='" . $data->pengguna->name . "'>$name</span>";
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(name, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'fasilitas', 'name', 'pengguna.name'])
            ->make(true);
        }
        return view('Services.Place.index');
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
            $input['grup']         = $request->tambah_group;
            $input['kode_kontrol'] = strtoupper($request->tambah_name);
            $input['pengguna']     = $request->tambah_pengguna;
            $input['pemilik']      = $request->tambah_pemilik;
            $input['status']       = $request->tambah_status;
            $input['keterangan']   = $request->tambah_ket;

            Validator::make($input, [
                'grup'         => 'required|exists:groups,name',
                'kode_kontrol' => 'required|max:25|unique:tempat,name',
                'pengguna'     => 'nullable|numeric|exists:users,id',
                'pemiik'       => 'nullable|numeric|exists:users,id',
                'status'       => 'required|numeric|in:2,1,0',
                'keterangan'   => 'nullable|string|max:255',
            ])->validate();

            $los = $this->multipleSelect($request->tambah_los);
            sort($los, SORT_NATURAL);

            $no_los = Group::where('name', $request->tambah_group)->first()->data;
            foreach($los as $l){
                $valid['nomor_los'] = $l;
                Validator::make($valid, [
                    'nomor_los' => 'required|in:'.$no_los,
                ])->validate();
            }

            DB::transaction(function() use ($input, $los){
                Tempat::create([
                    'name'        => $input['kode_kontrol'],
                    'nicename'    => str_replace('-', '', $input['kode_kontrol']),
                    'group_id'    => Group::where('name',$input['grup'])->first()->id,
                    'los'         => implode(',', $los),
                    'jml_los'     => count($los),
                    'pengguna_id' => $input['pengguna'],
                    'pemilik_id'  => $input['pemilik'],
                    'status'      => $input['status'],
                ]);
            });

            return response()->json(['success' => 'Data berhasil disimpan.']);
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
                $data = Tempat::lockForUpdate()->findOrFail($decrypted);

                //Ganti Status Alat

                $data->delete();
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }

    public function generate(Request $request){
        $group = $request->group;
        $los = $this->multipleSelect($request->los);
        sort($los, SORT_NATURAL);

        $los = $los[0];
        $data = Tempat::generate($group,$los);
        return response()->json(['success' => $data]);
    }

    public function multipleSelect($data){
        $temp = array();
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
    }
}
