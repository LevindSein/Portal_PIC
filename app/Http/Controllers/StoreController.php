<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Payment;
use App\Models\Group;
use App\Models\Store;
use App\Models\Commodity;
use App\Models\TListrik;
use App\Models\TAirBersih;
use App\Models\PKeamananIpk;
use App\Models\PKebersihan;
use App\Models\PAirKotor;
use App\Models\PLain;
use DataTables;
use Carbon\Carbon;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Store::
            with('pengguna:id,name')
            ->select(
                'id',
                'kd_kontrol',
                'jml_los',
                'id_pengguna',
                'nicename',
                'status',
                'fas_listrik',
                'fas_airbersih',
                'fas_keamananipk',
                'fas_kebersihan',
                'fas_airkotor',
                'fas_lain',
            );
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="edit pointera"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="delete" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="delete"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->addColumn('fasilitas', function($data){
                $listrik = ($data->fas_listrik != NULL) ? '<a type="button" data-toggle="tooltip" title="Listrik" class="pointera"><i class="fas fa-bolt" style="color:#fd7e14;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip" title="<del>Listrik</del>"><i class="fas fa-bolt" style="color:#d7d8cc;"></i></a>';
                $airbersih = ($data->fas_airbersih != NULL) ? '<a type="button" data-toggle="tooltip" title="Air Bersih" class="pointera"><i class="fas fa-tint" style="color:#36b9cc;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip" title="<del>Air Bersih</del>"><i class="fas fa-tint" style="color:#d7d8cc;"></i></a>';
                $keamananipk = ($data->fas_keamananipk != NULL) ? '<a type="button" data-toggle="tooltip" title="Keamanan IPK" class="pointera"><i class="fas fa-lock" style="color:#e74a3b;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip" title="<del>Keamanan IPK</del>"><i class="fas fa-lock" style="color:#d7d8cc;"></i></a>';
                $kebersihan = ($data->fas_kebersihan != NULL) ? '<a type="button" data-toggle="tooltip" title="Kebersihan" class="pointera"><i class="fas fa-leaf" style="color:#1cc88a;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip" title="<del>Kebersihan</del>"><i class="fas fa-leaf" style="color:#d7d8cc;"></i></a>';
                $airkotor = ($data->fas_airkotor != NULL) ? '<a type="button" data-toggle="tooltip" title="Air Kotor" class="pointera"><i class="fad fa-burn" style="color:#000000;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip" title="<del>Air Kotor</del>"><i class="fas fa-burn" style="color:#d7d8cc;"></i></a>';
                $lain = ($data->fas_lain != NULL) ? '<a type="button" data-toggle="tooltip" title="Lainnya" class="pointera"><i class="fas fa-chart-pie" style="color:#c5793a;"></i></a>' : '<a type="button" data-html="true" data-toggle="tooltip" title="<del>Lainnya</del>"><i class="fas fa-chart-pie" style="color:#d7d8cc;"></i></a>';
                return $listrik."&nbsp;&nbsp;".$airbersih."&nbsp;&nbsp;".$keamananipk."&nbsp;&nbsp;".$kebersihan."&nbsp;&nbsp;".$airkotor."&nbsp;&nbsp;".$lain;
            })
            ->editColumn('kd_kontrol', function($data){
                if($data->status == 2){
                    $button = "<span class='text-info'>$data->kd_kontrol</span>";
                }
                else if($data->status == 1){
                    $button = "<span class='text-success'>$data->kd_kontrol</span>";
                }
                else{
                    $button = "<span class='text-danger'>$data->kd_kontrol</span>";
                }
                return $button;
            })
            ->editColumn('jml_los', function($data){
                return number_format($data->jml_los);
            })
            ->editColumn('pengguna.name', function($data){
                $name = $data->pengguna->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                    $nama = $data->pengguna->name;
                    return "<span data-toggle='tooltip' title='$nama'>$name</span>";
                }
                else{
                    return $name;
                }
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'fasilitas', 'kd_kontrol', 'pengguna.name'])
            ->make(true);
        }
        Session::put('lastPlace', 'point/stores');
        return view('portal.point.store.index');
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
            $valid['blok'] = $request->group;
            $valid['kodeKontrol'] = $request->kontrol;
            $valid['pengguna'] = $request->pengguna;
            $valid['pemilik'] = $request->pemilik;
            $valid['status'] = $request->status;
            $valid['keterangan'] = $request->ket;
            $valid['infoTambahan'] = $request->info;

            Validator::make($valid, [
                'blok' => 'required|exists:App\Models\Group,name',
                'kodeKontrol' => 'required|max:20|unique:App\Models\Store,kd_kontrol',
                'pengguna' => 'nullable|numeric|exists:App\Models\User,id',
                'pemiik' => 'nullable|numeric|exists:App\Models\User,id',
                'status' => 'required|in:2,1,0',
                'keterangan' => 'nullable|max:255',
                'infoTambahan' => 'nullable|max:255',
            ])->validate();

            $data['group'] = $request->group;

            $los = $this->multipleSelect($request->los);
            sort($los, SORT_NATURAL);

            $no_los = json_decode(Group::where('name', $request->group)->first()->data)->data;
            foreach($los as $l){
                $valid['nomorLos'] = $l;
                Validator::make($valid, [
                    'nomorLos' => 'required|in:'.$no_los,
                ])->validate();
            }

            $data['no_los'] = implode(',', $los);
            $jml_los = count($los);
            $data['jml_los'] = $jml_los;

            $data['kd_kontrol'] = strtoupper($request->kontrol);
            $data['nicename'] = str_replace('-','',$request->kontrol);
            $kd_kontrol = strtoupper($request->kontrol);

            $data['id_pengguna'] = $request->pengguna;
            $data['id_pemilik'] = $request->pemilik;

            $data['status'] = $request->status;
            $data['ket'] = $request->ket;

            if($request->commodity){
                $commodity = $this->multipleSelect($request->commodity);
                $commodities = array();
                for($i = 0; $i < count($commodity); $i++){
                    $valid['kategoriKomoditi'] = $commodity[$i];

                    Validator::make($valid, [
                        'kategoriKomoditi' => 'required|numeric|exists:App\Models\Commodity,id'
                    ])->validate();

                    $com = Commodity::find($commodity[$i]);
                    $commodities[$i] = [
                        'id' => $com->id,
                        'name' => $com->name,
                    ];
                }

                $data['komoditi'] = json_encode($commodities);
            }

            $data['info'] = $request->info;

            $diskon = array();

            //Listrik
            if($request->fas_listrik){
                $valid['alatListrik'] = $request->tlistrik;
                $valid['tarifListrik'] = $request->plistrik;
                $valid['diskonListrik'] = str_replace('.','',$request->dlistrik);

                Validator::make($valid, [
                    'alatListrik' => 'required|numeric|exists:App\Models\TListrik,id',
                    'tarifListrik' => 'required|numeric|exists:App\Models\PListrik,id',
                    'diskonListrik' => 'nullable|numeric|lte:100',
                ])->validate();

                $tools = TListrik::find($request->tlistrik);
                $tools->stt_available = 0;
                $tools->save();

                $data['id_tlistrik'] = $request->tlistrik;
                $data['fas_listrik'] = $request->plistrik;

                if($request->dlistrik){
                    $diskon['listrik'] = str_replace('.','',$request->dlistrik);
                }
            }

            //Air Bersih
            if($request->fas_airbersih){
                $valid['alatAirBersih'] = $request->tairbersih;
                $valid['tarifAirBersih'] = $request->pairbersih;
                $valid['diskonAirBersih'] = str_replace('.','',$request->dairbersih);

                Validator::make($valid, [
                    'alatAirBersih' => 'required|numeric|exists:App\Models\TAirBersih,id',
                    'tarifAirBersih' => 'required|numeric|exists:App\Models\PAirBersih,id',
                    'diskonAirBersih' => 'nullable|numeric|lte:100',
                ])->validate();

                $tools = TAirBersih::find($request->tairbersih);
                $tools->stt_available = 0;
                $tools->save();

                $data['id_tairbersih'] = $request->tairbersih;
                $data['fas_airbersih'] = $request->pairbersih;

                if($request->dairbersih){
                    $diskon['airbersih'] = str_replace('.','',$request->dairbersih);
                }
            }

            //Keamanan IPK
            if($request->fas_keamananipk){
                $valid['tarifKeamananIpk'] = $request->pkeamananipk;

                Validator::make($valid, [
                    'tarifKeamananIpk' => 'required|numeric|exists:App\Models\PKeamananIpk,id'
                ])->validate();

                $price = PKeamananIpk::find($request->pkeamananipk);
                if($request->dkeamananipk){
                    $max_disc = $price->price * $jml_los;

                    $valid['diskonKeamananIpk'] = str_replace('.','',$request->dkeamananipk);

                    Validator::make($valid, [
                        'diskonKeamananIpk' => 'nullable|numeric|lte:'.$max_disc,
                    ])->validate();
                }

                $data['fas_keamananipk'] = $request->pkeamananipk;

                if($request->dkeamananipk){
                    $diskon['keamananipk'] = str_replace('.','',$request->dkeamananipk);
                }
            }

            //Kebersihan
            if($request->fas_kebersihan){
                $valid['tarifKebersihan'] = $request->pkebersihan;

                Validator::make($valid, [
                    'tarifKebersihan' => 'required|numeric|exists:App\Models\PKebersihan,id'
                ])->validate();

                $price = PKebersihan::find($request->pkebersihan);
                if($request->dkebersihan){
                    $max_disc = $price->price * $jml_los;

                    $valid['diskonKebersihan'] = str_replace('.','',$request->dkebersihan);

                    Validator::make($valid, [
                        'diskonKebersihan' => 'nullable|numeric|lte:'.$max_disc,
                    ])->validate();
                }

                $data['fas_kebersihan'] = $request->pkebersihan;

                if($request->dkebersihan){
                    $diskon['kebersihan'] = str_replace('.','',$request->dkebersihan);
                }
            }

            //Air Kotor
            if($request->fas_airkotor){
                $valid['tarifAirKotor'] = $request->pairkotor;

                Validator::make($valid, [
                    'tarifAirKotor' => 'required|numeric|exists:App\Models\PAirKotor,id'
                ])->validate();

                $price = PAirKotor::find($request->pairkotor);
                if($request->dairkotor){
                    $valid['diskonAirKotor'] = str_replace('.','',$request->dairkotor);

                    Validator::make($valid, [
                        'diskonAirKotor' => 'nullable|numeric|lte:'.$price->price,
                    ])->validate();
                }

                $data['fas_airkotor'] = $request->pairkotor;

                if($request->dairkotor){
                    $diskon['airkotor'] = str_replace('.','',$request->dairkotor);
                }
            }

            //Lainnya
            if($request->plain){
                $plain = $request->plain;
                $prices = array();
                for($i = 0; $i < count($plain); $i++){
                    $valid['tarifLainnya'] = $plain[$i];

                    Validator::make($valid, [
                        'tarifLainnya' => 'required|numeric|exists:App\Models\PLain,id'
                    ])->validate();

                    $price = PLain::find($plain[$i]);
                    $prices[$i] = [
                        'id' => "$price->id",
                        'name' => $price->name,
                        'price' => $price->price,
                        'satuan_id' => $price->satuan,
                        'satuan_name' => PLain::satuan($price->satuan),
                    ];
                }

                $data['fas_lain'] = json_encode($prices);
            }

            $data['data'] = json_encode([
                'diskon' => $diskon,
                'created_by_id' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_by_id' => Auth::user()->id,
                'updated_by_name' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            try{
                Store::create($data);
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            Payment::syncByKontrol($kd_kontrol);

            $searchKey = str_replace('-','',$request->kontrol);

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
    }

    public function gKontrol(Request $request){
        $group = $request->group;
        $los = $this->multipleSelect($request->los);
        sort($los, SORT_NATURAL);

        $los = $los[0];
        $data = Store::kontrol($group,$los);
        return response()->json(['success' => $data]);
    }

    public function multipleSelect($data){
        $temp = array();
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()){
            try{
                $data = Store::with([
                    'pengguna:id,name,uid,ktp,phone,email,country_id',
                    'pengguna.country:id,phonecode',
                    'pemilik:id,name,uid,ktp,phone,email,country_id',
                    'pemilik.country:id,phonecode',
                    'tlistrik:id,code,name,meter,power',
                    'plistrik:id,name',
                    'tairbersih:id,code,name,meter',
                    'pairbersih:id,name',
                    'pkeamananipk:id,name,price',
                    'pkebersihan:id,name,price',
                    'pairkotor:id,name,price',
                ])
                ->findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            $explode = explode(',', $data->no_los);
            $implode = implode(', ', $explode);
            $data['no_los'] = rtrim($implode, ', ');

            $data['status'] = Store::status($data->status);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
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
            try{
                $data = Store::with([
                    'pengguna:id,name,ktp',
                    'pemilik:id,name,ktp',
                    'tlistrik:id,code,name,meter,power',
                    'plistrik:id,name',
                    'tairbersih:id,code,name,meter',
                    'pairbersih:id,name',
                    'pkeamananipk:id,name,price',
                    'pkebersihan:id,name,price',
                    'pairkotor:id,name,price',
                ])
                ->findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);
            $data['no_los'] = explode(',', $data->no_los);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
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
        if($request->ajax()){
            $valid['blok'] = $request->group;
            $valid['kodeKontrol'] = $request->kontrol;
            $valid['pengguna'] = $request->pengguna;
            $valid['pemilik'] = $request->pemilik;
            $valid['status'] = $request->status;
            $valid['keterangan'] = $request->ket;
            $valid['infoTambahan'] = $request->info;

            Validator::make($valid, [
                'blok' => 'required|exists:App\Models\Group,name',
                'kodeKontrol' => 'required|max:20|unique:App\Models\Store,kd_kontrol,'.$id,
                'pengguna' => 'nullable|numeric|exists:App\Models\User,id',
                'pemiik' => 'nullable|numeric|exists:App\Models\User,id',
                'status' => 'required|in:2,1,0',
                'keterangan' => 'nullable|max:255',
                'infoTambahan' => 'nullable|max:255',
            ])->validate();

            try{
                $data = Store::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data->group = $request->group;

            $los = $this->multipleSelect($request->los);
            sort($los, SORT_NATURAL);

            $no_los = json_decode(Group::where('name', $request->group)->first()->data)->data;
            foreach($los as $l){
                $valid['nomorLos'] = $l;
                Validator::make($valid, [
                    'nomorLos' => 'required|in:'.$no_los,
                ])->validate();
            }

            $data->no_los = implode(',', $los);
            $jml_los = count($los);
            $data->jml_los = $jml_los;

            $data->kd_kontrol = strtoupper($request->kontrol);
            $data->nicename = str_replace('-','',$request->kontrol);
            $kd_kontrol = strtoupper($request->kontrol);

            $data->id_pengguna = $request->pengguna;
            $data->id_pemilik = $request->pemilik;

            $data->status = $request->status;
            $data->ket = $request->ket;

            if($request->commodity){
                $commodity = $this->multipleSelect($request->commodity);
                $commodities = array();
                for($i = 0; $i < count($commodity); $i++){
                    $valid['kategoriKomoditi'] = $commodity[$i];

                    Validator::make($valid, [
                        'kategoriKomoditi' => 'required|numeric|exists:App\Models\Commodity,id'
                    ])->validate();

                    $com = Commodity::find($commodity[$i]);
                    $commodities[$i] = [
                        'id' => $com->id,
                        'name' => $com->name,
                    ];
                }

                $data->komoditi = json_encode($commodities);
            }
            else{
                $data->komoditi = NULL;
            }

            $data->info = $request->info;

            $diskon = array();

            //Listrik
            if($request->fas_listrik){
                $valid['alatListrik'] = $request->tlistrik;
                $valid['tarifListrik'] = $request->plistrik;
                $valid['diskonListrik'] = str_replace('.','',$request->dlistrik);

                Validator::make($valid, [
                    'alatListrik' => 'required|numeric|exists:App\Models\TListrik,id',
                    'tarifListrik' => 'required|numeric|exists:App\Models\PListrik,id',
                    'diskonListrik' => 'nullable|numeric|lte:100',
                ])->validate();

                $tools = TListrik::find($request->tlistrik);
                $tools->stt_available = 0;
                $tools->save();

                $data->id_tlistrik = $request->tlistrik;
                $data->fas_listrik = $request->plistrik;

                if($request->dlistrik){
                    $diskon['listrik'] = str_replace('.','',$request->dlistrik);
                }
            }
            else{
                if($data->fas_listrik){
                    $tools = TListrik::find($data->id_tlistrik);
                    $tools->stt_available = 1;
                    $tools->save();
                }

                $data->fas_listrik = NULL;
                $data->id_tlistrik = NULL;
            }

            //Air Bersih
            if($request->fas_airbersih){
                $valid['alatAirBersih'] = $request->tairbersih;
                $valid['tarifAirBersih'] = $request->pairbersih;
                $valid['diskonAirBersih'] = str_replace('.','',$request->dairbersih);

                Validator::make($valid, [
                    'alatAirBersih' => 'required|numeric|exists:App\Models\TAirBersih,id',
                    'tarifAirBersih' => 'required|numeric|exists:App\Models\PAirBersih,id',
                    'diskonAirBersih' => 'nullable|numeric|lte:100',
                ])->validate();

                $tools = TAirBersih::find($request->tairbersih);
                $tools->stt_available = 0;
                $tools->save();

                $data->id_tairbersih = $request->tairbersih;
                $data->fas_airbersih = $request->pairbersih;

                if($request->dairbersih){
                    $diskon['airbersih'] = str_replace('.','',$request->dairbersih);
                }
            }
            else{
                if($data->fas_airbersih){
                    $tools = TAirBersih::find($data->id_tairbersih);
                    $tools->stt_available = 1;
                    $tools->save();
                }

                $data->fas_airbersih = NULL;
                $data->id_tairbersih = NULL;
            }

            //Keamanan IPK
            if($request->fas_keamananipk){
                $valid['tarifKeamananIpk'] = $request->pkeamananipk;

                Validator::make($valid, [
                    'tarifKeamananIpk' => 'required|numeric|exists:App\Models\PKeamananIpk,id'
                ])->validate();

                $price = PKeamananIpk::find($request->pkeamananipk);
                if($request->dkeamananipk){
                    $max_disc = $price->price * $jml_los;

                    $valid['diskonKeamananIpk'] = str_replace('.','',$request->dkeamananipk);

                    Validator::make($valid, [
                        'diskonKeamananIpk' => 'nullable|numeric|lte:'.$max_disc,
                    ])->validate();
                }

                $data->fas_keamananipk = $request->pkeamananipk;

                if($request->dkeamananipk){
                    $diskon['keamananipk'] = str_replace('.','',$request->dkeamananipk);
                }
            }
            else{
                $data->fas_keamananipk = NULL;
            }

            //Kebersihan
            if($request->fas_kebersihan){
                $valid['tarifKebersihan'] = $request->pkebersihan;

                Validator::make($valid, [
                    'tarifKebersihan' => 'required|numeric|exists:App\Models\PKebersihan,id'
                ])->validate();

                $price = PKebersihan::find($request->pkebersihan);
                if($request->dkebersihan){
                    $max_disc = $price->price * $jml_los;

                    $valid['diskonKebersihan'] = str_replace('.','',$request->dkebersihan);

                    Validator::make($valid, [
                        'diskonKebersihan' => 'nullable|numeric|lte:'.$max_disc,
                    ])->validate();
                }

                $data->fas_kebersihan = $request->pkebersihan;

                if($request->dkebersihan){
                    $diskon['kebersihan'] = str_replace('.','',$request->dkebersihan);
                }
            }
            else{
                $data->fas_kebersihan = NULL;
            }

            //Air Kotor
            if($request->fas_airkotor){
                $valid['tarifAirKotor'] = $request->pairkotor;

                Validator::make($valid, [
                    'tarifAirKotor' => 'required|numeric|exists:App\Models\PAirKotor,id'
                ])->validate();

                $price = PAirKotor::find($request->pairkotor);
                if($request->dairkotor){
                    $valid['diskonAirKotor'] = str_replace('.','',$request->dairkotor);

                    Validator::make($valid, [
                        'diskonAirKotor' => 'nullable|numeric|lte:'.$price->price,
                    ])->validate();
                }

                $data->fas_airkotor = $request->pairkotor;

                if($request->dairkotor){
                    $diskon['airkotor'] = str_replace('.','',$request->dairkotor);
                }
            }
            else{
                $data->fas_airkotor = NULL;
            }

            //Lainnya
            if($request->plain){
                $plain = $request->plain;
                $prices = array();
                for($i = 0; $i < count($plain); $i++){
                    $valid['tarifLainnya'] = $plain[$i];

                    Validator::make($valid, [
                        'tarifLainnya' => 'required|numeric|exists:App\Models\PLain,id'
                    ])->validate();

                    $price = PLain::find($plain[$i]);
                    $prices[$i] = [
                        'id' => "$price->id",
                        'name' => $price->name,
                        'price' => $price->price,
                        'satuan_id' => $price->satuan,
                        'satuan_name' => PLain::satuan($price->satuan),
                    ];
                }

                $data->fas_lain = json_encode($prices);
            }
            else{
                $data->fas_lain = NULL;
            }

            $json = json_decode($data->data);

            $json->diskon = $diskon;
            $json->updated_by_id = Auth::user()->id;
            $json->updated_by_name = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->data = $json;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            Payment::syncByKontrol($kd_kontrol);

            $searchKey = str_replace('-','',$request->kontrol);

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
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
            try{
                $data = Store::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            if($data->fas_listrik){
                try{
                    $tools = TListrik::findOrFail($data->id_tlistrik);
                } catch(ModelNotFoundException $e){
                    return response()->json(['error' => 'Data Tools Listrik not found','description' => $e]);
                }

                $tools->stt_available = 1;

                try{
                    $tools->save();
                } catch(\Exception $e){
                    return response()->json(['error' => "Data failed to save.", 'description' => $e]);
                }
            }

            if($data->fas_airbersih){
                try{
                    $tools = TAirBersih::findOrFail($data->id_tairbersih);
                } catch(ModelNotFoundException $e){
                    return response()->json(['error' => 'Data Tools Air Bersih not found','description' => $e]);
                }

                $tools->stt_available = 1;

                try{
                    $tools->save();
                } catch(\Exception $e){
                    return response()->json(['error' => "Data failed to save.", 'description' => $e]);
                }
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
    }
}
