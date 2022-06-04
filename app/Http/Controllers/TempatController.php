<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\Rule;

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
            ->filterColumn('name', function ($query, $keyword) {
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
            $diskon                = [];

            Validator::make($input, [
                'grup'         => 'required|exists:groups,name',
                'kode_kontrol' => 'required|max:25|unique:tempat,name',
                'pengguna'     => 'nullable|numeric|exists:users,id',
                'pemiik'       => 'nullable|numeric|exists:users,id',
                'status'       => 'required|numeric|in:2,1,0',
                'keterangan'   => 'nullable|string|max:255',
            ])->validate();

            if($request->tambah_listrik){
                $input['alat_listrik']   = $request->tambah_alat_listrik;
                $input['tarif_listrik']  = $request->tambah_trf_listrik;
                $input['diskon_listrik'] = $request->tambah_dis_listrik;

                Validator::make($input, [
                    'alat_listrik'   => ['required','numeric',
                                            Rule::exists('alat', 'id')
                                            ->where('level', 1)
                                            ->where('status', 1)
                                        ],
                    'tarif_listrik'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 1)
                                        ],
                    'diskon_listrik' => 'nullable|numeric|gte:0|lte:100',
                ])->validate();

                $data['alat_listrik_id'] = $input['alat_listrik'];
                $data['trf_listrik_id']  = $input['tarif_listrik'];
                $diskon['listrik']       = $input['diskon_listrik'];
            }

            if($request->tambah_airbersih){
                $input['alat_airbersih']   = $request->tambah_alat_airbersih;
                $input['tarif_airbersih']  = $request->tambah_trf_airbersih;
                $input['diskon_airbersih'] = $request->tambah_dis_airbersih;

                Validator::make($input, [
                    'alat_airbersih'   => ['required','numeric',
                                            Rule::exists('alat', 'id')
                                            ->where('level', 2)
                                            ->where('status', 1)
                                        ],
                    'tarif_airbersih'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 2)
                                        ],
                    'diskon_airbersih' => 'nullable|numeric|gte:0|lte:100',
                ])->validate();

                $data['alat_airbersih_id'] = $input['alat_airbersih'];
                $data['trf_airbersih_id']  = $input['tarif_airbersih'];
                $diskon['airbersih']       = $input['diskon_airbersih'];
            }

            if($request->tambah_keamananipk){
                $input['tarif_keamananipk']  = $request->tambah_trf_keamananipk;
                $input['diskon_keamananipk'] = $request->tambah_dis_keamananipk;

                Validator::make($input, [
                    'tarif_keamananipk'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 3)
                                        ],
                    'diskon_keamananipk' => 'nullable|numeric|gte:0|lte:999999999999',
                ])->validate();

                $data['trf_keamananipk_id']  = $input['tarif_keamananipk'];
                $diskon['keamananipk']       = $input['diskon_keamananipk'];
            }

            if($request->tambah_kebersihan){
                $input['tarif_kebersihan']  = $request->tambah_trf_kebersihan;
                $input['diskon_kebersihan'] = $request->tambah_dis_kebersihan;

                Validator::make($input, [
                    'tarif_kebersihan'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 4)
                                        ],
                    'diskon_kebersihan' => 'nullable|numeric|gte:0|lte:999999999999',
                ])->validate();

                $data['trf_kebersihan_id']  = $input['tarif_kebersihan'];
                $diskon['kebersihan']       = $input['diskon_kebersihan'];
            }

            if($request->tambah_airkotor){
                $input['tarif_airkotor']  = $request->tambah_trf_airkotor;
                $input['diskon_airkotor'] = $request->tambah_dis_airkotor;

                Validator::make($input, [
                    'tarif_airkotor'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 5)
                                        ],
                    'diskon_airkotor' => 'nullable|numeric|gte:0|lte:999999999999',
                ])->validate();

                $data['trf_airkotor_id']  = $input['tarif_airkotor'];
                $diskon['airkotor']       = $input['diskon_airkotor'];
            }

            if($request->tambah_lainnya){
                $lainnya = [];
                foreach ($request->tambah_lainnya as $key) {
                    $input['tarif_lainnya']  = $key;
                    Validator::make($input, [
                        'tarif_lainnya'
                        => ['required','numeric',
                            Rule::exists('tarif', 'id')
                            ->where('level', 6)
                        ]
                    ])->validate();

                    $lainnya[] = $key;
                }

                $data['trf_lainnya_id'] = json_encode($lainnya);
            }

            $los = $this->multipleSelect($request->tambah_los);
            sort($los, SORT_NATURAL);

            $no_los = Group::where('name', $request->tambah_group)->first();
            foreach($los as $l){
                $input['nomor_los'] = $l;
                Validator::make($input, [
                    'nomor_los' => 'required|in:' . implode(',', json_decode($no_los->data)),
                ])->validate();
            }

            $data['name']        = $input['kode_kontrol'];
            $data['nicename']    = str_replace('-', '', $input['kode_kontrol']);
            $data['group_id']    = Group::where('name',$input['grup'])->first()->id;
            $data['los']         = json_encode($los);
            $data['jml_los']     = count($los);
            $data['pengguna_id'] = $input['pengguna'];
            $data['pemilik_id']  = $input['pemilik'];
            $data['status']      = $input['status'];
            $data['ket']         = $input['keterangan'];
            $data['diskon']      = json_encode($diskon);

            DB::transaction(function() use ($data){
                Tempat::create($data);
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
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = Tempat::findOrFail($decrypted);

            return response()->json(['success' => $data]);
        }
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
        $temp = [];
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
    }
}
