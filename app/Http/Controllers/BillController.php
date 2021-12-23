<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Group;
use App\Models\Bill;
use App\Models\IndoDate;
use App\Models\Period;
use App\Models\Identity;
use App\Models\PListrik;
use App\Models\PAirBersih;
use App\Models\PKeamananIpk;
use App\Models\PKebersihan;
use App\Models\PAirKotor;
use App\Models\PLain;
use App\Models\User;
use App\Models\Store;
use App\Models\TListrik;
use App\Models\TAirBersih;
use DataTables;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $id_period = Session::get('period');
            $valid['period'] = $id_period;
            $validator = Validator::make($valid, [
                'period' => 'exists:App\Models\Period,id'
            ]);

            if($validator->fails()){
                $id_period = Period::latest('name')->select('id')->first()->id;
            }

            $data = Bill::where('id_period', $id_period)
            ->whereIn('active', [1,2])
            ->select(
                'id',
                'code',
                'stt_publish',
                'stt_bayar',
                'stt_lunas',
                'kd_kontrol',
                'name',
                'nicename',
                'jml_los',
                'b_listrik',
                'b_airbersih',
                'b_keamananipk',
                'b_kebersihan',
                'b_airkotor',
                'b_lain',
                'b_tagihan',
            );
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';

                if($data->stt_lunas == 0){
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                }

                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->addColumn('publish', function($data){
                if($data->stt_publish == 1){
                    $button = '<button id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="unpublish btn btn-sm btn-rounded btn-danger">Unpublish</button>';
                }
                else{
                    $button = '<button id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="publish btn btn-sm btn-rounded btn-success">Publish</button>';
                }

                if($data->stt_lunas == 1){
                    $button = '<span style="color:#36bea6;">Lunas</span>';
                }

                return $button;
            })
            ->addColumn('fasilitas', function($data){
                $listrik = '';
                if($data->b_listrik){
                    $json = json_decode($data->b_listrik);
                    $daya = number_format($json->daya, 0, '', '.');
                    $awal = number_format($json->awal, 0, '', '.');
                    $akhir = number_format($json->akhir, 0, '', '.');
                    $pakai = number_format($json->pakai, 0, '', '.');
                    $subtotal = number_format($json->sub_tagihan, 0, '', '.');
                    $diskon = number_format($json->diskon, 0, '', '.');
                    $denda = number_format($json->denda, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $listrik = "<a type='button' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Listrik' data-content='Daya: $daya<br>Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br>Subtotal: $subtotal<br>Diskon: $diskon<br>Denda: $denda<br><b>Tagihan: $tagihan</b>' class='mr-1'><i class='fas fa-bolt' style='color:#fd7e14;'></i></a>";
                }

                $airbersih = '';
                if($data->b_airbersih){
                    $json = json_decode($data->b_airbersih);
                    $awal = number_format($json->awal, 0, '', '.');
                    $akhir = number_format($json->akhir, 0, '', '.');
                    $pakai = number_format($json->pakai, 0, '', '.');
                    $subtotal = number_format($json->sub_tagihan, 0, '', '.');
                    $diskon = number_format($json->diskon, 0, '', '.');
                    $denda = number_format($json->denda, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $airbersih = "<a type='button' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Air Bersih' data-content='Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br>Subtotal: $subtotal<br>Diskon: $diskon<br>Denda: $denda<br><b>Tagihan: $tagihan</b>' class='mr-1'><i class='fas fa-tint' style='color:#36b9cc;'></i></a>";
                }

                $keamananipk = '';
                if($data->b_keamananipk){
                    $json = json_decode($data->b_keamananipk);
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $subtotal = number_format($json->sub_tagihan, 0, '', '.');
                    $diskon = number_format($json->diskon, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $keamananipk = "<a type='button' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Keamanan IPK' data-content='Jml Los: $jml_los<br>Subtotal: $subtotal<br>Diskon: $diskon<br><b>Tagihan: $tagihan</b>' class='mr-1'><i class='fas fa-lock' style='color:#e74a3b;'></i></a>";
                }

                $kebersihan = '';
                if($data->b_kebersihan){
                    $json = json_decode($data->b_kebersihan);
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $subtotal = number_format($json->sub_tagihan, 0, '', '.');
                    $diskon = number_format($json->diskon, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $kebersihan = "<a type='button' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Kebersihan' data-content='Jml Los: $jml_los<br>Subtotal: $subtotal<br>Diskon: $diskon<br><b>Tagihan: $tagihan</b>' class='mr-1'><i class='fas fa-leaf' style='color:#1cc88a;'></i></a>";
                }

                $airkotor = '';
                if($data->b_airkotor){
                    $json = json_decode($data->b_airkotor);
                    $subtotal = number_format($json->sub_tagihan, 0, '', '.');
                    $diskon = number_format($json->diskon, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $airkotor = "<a type='button' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Air Kotor' data-content='Subtotal: $subtotal<br>Diskon: $diskon<br><b>Tagihan: $tagihan</b>' class='mr-1'><i class='fad fa-burn' style='color:#000000;'></i></a>";
                }

                $lain = '';
                if($data->b_lain){
                    $json = json_decode($data->b_lain);
                    $tagihan = 0;
                    $fasilitas = '';
                    foreach($json as $d => $b){
                        $fasilitas .= $b->tarif_nama.": ".number_format($b->ttl_tagihan, 0, '', '.')."<br>";
                        $tagihan += $b->ttl_tagihan;
                    }
                    $fasilitas = rtrim($fasilitas, '<br>');
                    $tagihan = number_format($tagihan, 0, '', '.');
                    $lain = "<a type='button' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Lainnya' data-content='$fasilitas<br><b>Tagihan: $tagihan</b>' class='mr-1'><i class='fas fa-chart-pie' style='color:#c5793a;'></i></a>";
                }

                return $listrik.$airbersih.$keamananipk.$kebersihan.$airkotor.$lain;
            })
            ->editColumn('b_tagihan', function($data){
                $json = json_decode($data->b_tagihan);
                return number_format($json->ttl_tagihan);
            })
            ->editColumn('name', function($data){
                $name = $data->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                    return "<span data-toggle='tooltip' title='$data->name'>$name</span>";
                }
                else{
                    return $name;
                }
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename, code) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'publish', 'fasilitas', 'name'])
            ->make(true);
        }
        return view('portal.manage.bill.index');
    }

    public function period(){
        if(request()->ajax()){
            $id = Session::get('period');

            if(is_null($id)){
                return response()->json(['success' => Period::latest('name')->first()]);
            }

            $period = Period::find($id);

            return response()->json(['success' => $period]);
        }
        else{
            abort(404);
        }
    }

    public function periodChange($id){
        Session::put('period', $id);
        return response()->json(['success' => $id]);
    }

    public function multipleSelect($data){
        $temp = array();
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
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
            $request->validate([
                'periode' => 'required|exists:App\Models\Period,id',
                'pengguna' => 'required|exists:App\Models\User,id',
                'kontrol' => 'required|exists:App\Models\Store,kd_kontrol',
                'group' => 'required|exists:App\Models\Group,name'
            ]);

            $data['code'] = Identity::billCode();

            $period = $request->periode;
            $data['id_period'] = $period;

            $data['stt_publish'] = 0;
            if($request->stt_publish){
                $data['stt_publish'] = 1;
            }
            $publish = Carbon::now()->toDateTimeString();
            $publish_by = Auth::user()->name;

            $data['stt_bayar'] = 0;
            $data['stt_lunas'] = 0;

            $data['name'] = User::find($request->pengguna)->name;

            $data['kd_kontrol'] = $request->kontrol;
            $data['nicename'] = str_replace('-','',$request->kontrol);
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

            $jml_los = count($los);
            $data['jml_los'] = $jml_los;
            $data['no_los'] = implode(',', $los);

            $data['active'] = 1;

            $sub_tagihan = 0;
            $den_tagihan = 0;
            $dis_tagihan = 0;
            $ttl_tagihan = 0;
            $sel_tagihan = 0;

            //Listrik
            if($request->fas_listrik){
                $tarif_id = $request->plistrik;

                $valid['tarifListrik'] = $tarif_id;
                Validator::make($valid, [
                    'tarifListrik' => 'required|exists:App\Models\PListrik,id',
                ])->validate();

                $tarif = PListrik::find($tarif_id);
                $tarif_data = json_decode($tarif->data);

                $daya = str_replace('.','',$request->dayalistrik);
                $awal = str_replace('.','',$request->awlistrik);
                $akhir = str_replace('.','',$request->aklistrik);
                $digit = null;

                $valid['dayaListrik'] = $daya;
                $valid['awalMeterListrik'] = $awal;
                $valid['akhirMeterListrik'] = $akhir;
                Validator::make($valid, [
                    'dayaListrik' => 'required|numeric|lte:999999999',
                    'awalMeterListrik' => 'required|numeric|lte:999999999',
                    'akhirMeterListrik' => 'required|numeric|lte:999999999',
                ])->validate();

                $kontrol = Store::where('kd_kontrol', $request->kontrol)->select('id_tlistrik')->first();
                if($kontrol){
                    $data['code_tlistrik'] = TListrik::find($kontrol->id_tlistrik)->code;
                }

                if($request->checklistrik0){
                    $digit = str_repeat("9",strlen($awal));
                    $pakai = PListrik::pakai($awal, $digit + $akhir);
                    $akhir_temp = $digit + $akhir;
                }
                else{
                    if($awal > $akhir){
                        return response()->json([
                            'info' => "Anda dapat mengaktifkan Meter kembali ke Nol.",
                            'warning' => "Akhir Listrik harus lebih besar dari Awal Listrik."
                        ]);
                    }
                    $pakai = PListrik::pakai($awal, $akhir);
                    $akhir_temp = $akhir;
                }

                $tarif_nama = $tarif->name;
                $standar = PListrik::standar($tarif_data->standar, $daya);
                $blok1 = PListrik::blok1($tarif_data->blok1, $standar);
                $blok2 = PListrik::blok2($tarif_data->blok2, $pakai, $standar);
                $beban = PListrik::beban($tarif_data->beban, $daya);
                $pju = PListrik::pju($tarif_data->pju, $blok1 + $blok2 + $beban);
                $ppn = PListrik::ppn($tarif_data->ppn, $blok1 + $blok2 + $beban + $pju);
                $sub = PListrik::tagihan($tarif_id, $awal, $akhir_temp, $daya);

                $diskon = 0;
                if($request->dlistrik){
                    $valid['diskonListrik'] = $request->dlistrik;
                    Validator::make($valid, [
                        'diskonListrik' => 'required|numeric|lte:100',
                    ])->validate();

                    $diskon = round((str_replace('.','',$request->dlistrik) / 100) * $sub);
                }

                $denda = 0;
                if($request->denlistrik){
                    $diff = $request->denlistrik;
                    $valid['dendaListrik'] = $request->denlistrik;
                    Validator::make($valid, [
                        'dendaListrik' => 'required|numeric|lte:9999',
                    ])->validate();

                    if($daya > 4400){
                        $denda = ceil($diff * ($tarif_data->denda2 / 100) * $sub);
                    }
                    else{
                        $denda = $diff * $tarif_data->denda1;
                    }
                }

                $total = $sub - $diskon + $denda;

                $data['b_listrik'] = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'daya' => $daya,
                    'awal' => $awal,
                    'akhir' => $akhir,
                    'reset' => $digit,
                    'pakai' => $pakai,
                    'blok1' => $blok1,
                    'blok2' => $blok2,
                    'beban' => $beban,
                    'pju' => $pju,
                    'ppn' => $ppn,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'denda' => $denda,
                    'denda_bulan' => $request->denlistrik,
                    'diskon' => $diskon,
                    'diskon_persen' => $request->dlistrik,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $den_tagihan += $denda;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $sel_tagihan += $total;
            }

            //Air Bersih
            if($request->fas_airbersih){
                $tarif_id = $request->pairbersih;

                $valid['tarifAirBersih'] = $tarif_id;
                Validator::make($valid, [
                    'tarifAirBersih' => 'required|exists:App\Models\PAirBersih,id',
                ])->validate();

                $tarif = PAirBersih::find($tarif_id);
                $tarif_data = json_decode($tarif->data);

                $awal = str_replace('.','',$request->awairbersih);
                $akhir = str_replace('.','',$request->akairbersih);
                $digit = null;

                $valid['awalMeterAirBersih'] = $awal;
                $valid['akhirMeterAirBersih'] = $akhir;
                Validator::make($valid, [
                    'awalMeterAirBersih' => 'required|numeric|lte:999999999',
                    'akhirMeterAirBersih' => 'required|numeric|lte:999999999',
                ])->validate();

                $kontrol = Store::where('kd_kontrol', $request->kontrol)->select('id_tairbersih')->first();
                if($kontrol){
                    $data['code_tairbersih'] = TAirBersih::find($kontrol->id_tairbersih)->code;
                }

                if($request->checkairbersih0){
                    $digit = str_repeat("9",strlen($awal));
                    $pakai = PAirBersih::pakai($awal, $digit + $akhir);
                    $akhir_temp = $digit + $akhir;
                }
                else{
                    if($awal > $akhir){
                        return response()->json([
                            'info' => "Anda dapat mengaktifkan Meter kembali ke Nol.",
                            'warning' => "Akhir Air Bersih harus lebih besar dari Awal Air Bersih."
                        ]);
                    }
                    $pakai = PAirBersih::pakai($awal, $akhir);
                    $akhir_temp = $akhir;
                }

                $tarif_nama = $tarif->name;
                $bayar = PAirBersih::bayar($pakai, $tarif_data->tarif1, $tarif_data->tarif2);
                $pemeliharaan = PAirBersih::pemeliharaan($tarif_data->pemeliharaan);
                $beban = PAirBersih::beban($tarif_data->beban);
                $arkot = PAirBersih::arkot($tarif_data->airkotor, $bayar);
                $ppn = PAirBersih::ppn($tarif_data->ppn, $bayar + $pemeliharaan + $beban + $arkot);
                $sub = PAirBersih::tagihan($tarif_id, $awal, $akhir_temp);

                $diskon = 0;
                if($request->dairbersih){
                    $valid['diskonAirBersih'] = $request->dairbersih;
                    Validator::make($valid, [
                        'diskonAirBersih' => 'required|numeric|lte:100',
                    ])->validate();

                    $diskon = round((str_replace('.','',$request->dairbersih) / 100) * $sub);
                }


                $denda = 0;
                if($request->denairbersih){
                    $diff = $request->denairbersih;
                    $valid['dendaAirBersih'] = $diff;
                    Validator::make($valid, [
                        'dendaAirBersih' => 'required|numeric|lte:9999',
                    ])->validate();

                    $denda = $diff * $tarif_data->denda;
                }

                $total = $sub - $diskon + $denda;

                $data['b_airbersih'] = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'awal' => $awal,
                    'akhir' => $akhir,
                    'reset' => $digit,
                    'pakai' => $pakai,
                    'bayar' => $bayar,
                    'pemeliharaan' => $pemeliharaan,
                    'beban' => $beban,
                    'arkot' => $arkot,
                    'ppn' => $ppn,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'denda' => $denda,
                    'denda_bulan' => $request->denairbersih,
                    'diskon' => $diskon,
                    'diskon_persen' => $request->dairbersih,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $den_tagihan += $denda;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $sel_tagihan += $total;
            }

            //Keamanan IPK
            if($request->fas_keamananipk){
                $tarif_id = $request->pkeamananipk;

                $valid['tarifKeamananIpk'] = $tarif_id;
                Validator::make($valid, [
                    'tarifKeamananIpk' => 'required|exists:App\Models\PKeamananIpk,id',
                ])->validate();

                $tarif = PKeamananIpk::find($tarif_id);
                $tarif_data = json_decode($tarif->data);

                $tarif_nama = $tarif->name;

                $sub = PKeamananIpk::tagihan($tarif_id, $jml_los);

                $diskon = 0;
                if($request->dkeamananipk){
                    $diskon = str_replace('.','',$request->dkeamananipk);

                    if($diskon > $sub){
                        return response()->json(['info' => "Diskon Keamanan IPK maksimal $sub."]);
                    }
                }

                $total = $sub - $diskon;

                $keamanan = round(($tarif_data->keamanan / 100) * $total);
                $ipk = $total - $keamanan;

                $data['b_keamananipk'] = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'diskon' => $diskon,
                    'keamanan' => $keamanan,
                    'ipk' => $ipk,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $sel_tagihan += $total;
            }

            //Kebersihan
            if($request->fas_kebersihan){
                $tarif_id = $request->pkebersihan;

                $valid['tarifKebersihan'] = $tarif_id;
                Validator::make($valid, [
                    'tarifKebersihan' => 'required|exists:App\Models\PKebersihan,id',
                ])->validate();

                $tarif = PKebersihan::find($tarif_id);

                $tarif_nama = $tarif->name;

                $sub = PKebersihan::tagihan($tarif_id, $jml_los);

                $diskon = 0;
                if($request->dkebersihan){
                    $diskon = str_replace('.','',$request->dkebersihan);

                    if($diskon > $sub){
                        return response()->json(['info' => "Diskon Kebersihan maksimal $sub."]);
                    }
                }

                $total = $sub - $diskon;

                $data['b_kebersihan'] = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'diskon' => $diskon,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $sel_tagihan += $total;
            }

            //Air Kotor
            if($request->fas_airkotor){
                $tarif_id = $request->pairkotor;

                $valid['tarifAirKotor'] = $tarif_id;
                Validator::make($valid, [
                    'tarifAirKotor' => 'required|exists:App\Models\PAirKotor,id',
                ])->validate();

                $tarif = PAirKotor::find($tarif_id);

                $tarif_nama = $tarif->name;

                $sub = PAirKotor::tagihan($tarif_id);

                $diskon = 0;
                if($request->dairkotor){
                    $diskon = str_replace('.','',$request->dairkotor);

                    if($diskon > $sub){
                        return response()->json(['info' => "Diskon Kebersihan maksimal $sub."]);
                    }
                }

                $total = $sub - $diskon;

                $data['b_airkotor'] = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'diskon' => $diskon,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $sel_tagihan += $total;
            }

            //Lainnya
            if($request->plain){
                $plain = $request->plain;
                $prices = array();
                for($i = 0; $i < count($plain); $i++){
                    $tarif_id = $request->plain[$i];

                    $valid['tarifLain'] = $tarif_id;
                    Validator::make($valid, [
                        'tarifLain' => 'required|exists:App\Models\PLain,id',
                    ])->validate();

                    $tarif = PLain::find($tarif_id);

                    $tarif_nama = $tarif->name;

                    $sub = PLain::tagihan($tarif_id, $jml_los);

                    $total = $sub;

                    $prices[$i] = [
                        'lunas' => 0,
                        'tarif_id' => $tarif_id,
                        'tarif_nama' => $tarif_nama,
                        'price' => $tarif->price,
                        'jml_los' => $jml_los,
                        'satuan_id' => $tarif->satuan,
                        'satuan_nama' => PLain::satuan($tarif->satuan),
                        'sub_tagihan' => $total,
                        'ttl_tagihan' => $total,
                        'rea_tagihan' => 0,
                        'sel_tagihan' => $total,
                    ];

                    $sub_tagihan += $sub;
                    $ttl_tagihan += $total;
                    $sel_tagihan += $total;
                }

                $data['b_lain'] = json_encode($prices);
            }

            $data['b_tagihan'] = json_encode([
                'lunas' => 0,
                'sub_tagihan' => $sub_tagihan,
                'denda' => $den_tagihan,
                'diskon' => $dis_tagihan,
                'ttl_tagihan' => $ttl_tagihan,
                'rea_tagihan' => 0,
                'sel_tagihan' => $sel_tagihan,
            ]);

            $data['data'] = json_encode([
                'lunas' => 0,
                'publish' => $publish,
                'publish_by' => $publish_by,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            try{
                Bill::create($data);
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            Session::put('period', $period);

            $searchKey = str_replace('-','',$request->kontrol);

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
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
        if(request()->ajax()){
            try{
                $data = Bill::with([
                    'period:id,nicename',
                ])
                ->findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $explode = explode(',', $data->no_los);
            $implode = implode(', ', $explode);
            $data['no_los'] = rtrim($implode, ', ');

            $json = json_decode($data->data);
            $data['data'] = $json;
            $data['publish'] = $json->publish;
            $data['stt_publish'] = Bill::publish($data->stt_publish);
            $data['stt_bayar'] = Bill::bayar($data->stt_bayar);
            $data['stt_lunas'] = Bill::lunas($data->stt_lunas);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
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
                $data = Bill::with([
                    'period:id,nicename',
                ])->findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['b_listrik'] = json_decode($data->b_listrik);
            $data['b_airbersih'] = json_decode($data->b_airbersih);
            $data['b_keamananipk'] = json_decode($data->b_keamananipk);
            $data['b_kebersihan'] = json_decode($data->b_kebersihan);
            $data['b_airkotor'] = json_decode($data->b_airkotor);
            $data['b_lain'] = json_decode($data->b_lain);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
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
            try{
                $data = Bill::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data->stt_publish = 0;
            if($request->stt_publish){
                $data->stt_publish = 1;
            }
            $publish = Carbon::now()->toDateTimeString();
            $publish_by = Auth::user()->name;

            $los = $this->multipleSelect($request->los);
            sort($los, SORT_NATURAL);

            $no_los = json_decode(Group::where('name', $request->group)->first()->data)->data;
            foreach($los as $l){
                $valid['nomorLos'] = $l;
                Validator::make($valid, [
                    'nomorLos' => 'required|in:'.$no_los,
                ])->validate();
            }

            $jml_los = count($los);
            $data->jml_los = $jml_los;
            $data->no_los = implode(',', $los);

            if($request->pengguna){
                $data->name = User::find($request->pengguna)->name;
            }

            $sub_tagihan = 0;
            $den_tagihan = 0;
            $dis_tagihan = 0;
            $ttl_tagihan = 0;
            $rea_tagihan = 0;
            $sel_tagihan = 0;

            $lunas = 1;

            //Listrik
            if($request->fas_listrik){
                $lunas *= 0;

                $tarif_id = $request->plistrik;

                $valid['tarifListrik'] = $tarif_id;
                Validator::make($valid, [
                    'tarifListrik' => 'required|exists:App\Models\PListrik,id',
                ])->validate();

                $tarif = PListrik::find($tarif_id);
                $tarif_data = json_decode($tarif->data);

                $daya = str_replace('.','',$request->dayalistrik);
                $awal = str_replace('.','',$request->awlistrik);
                $akhir = str_replace('.','',$request->aklistrik);
                $digit = null;

                $valid['dayaListrik'] = $daya;
                $valid['awalMeterListrik'] = $awal;
                $valid['akhirMeterListrik'] = $akhir;
                Validator::make($valid, [
                    'dayaListrik' => 'required|numeric|lte:999999999',
                    'awalMeterListrik' => 'required|numeric|lte:999999999',
                    'akhirMeterListrik' => 'required|numeric|lte:999999999',
                ])->validate();

                $kontrol = Store::where('kd_kontrol', $data->kd_kontrol)->select('id_tlistrik')->first();
                if($kontrol){
                    $data->code_tlistrik = TListrik::find($kontrol->id_tlistrik)->code;
                }

                if($request->checklistrik0){
                    $digit = str_repeat("9",strlen($awal));
                    $pakai = PListrik::pakai($awal, $digit + $akhir);
                    $akhir_temp = $digit + $akhir;
                }
                else{
                    if($awal > $akhir){
                        return response()->json([
                            'info' => "Anda dapat mengaktifkan Meter kembali ke Nol.",
                            'warning' => "Akhir Listrik harus lebih besar dari Awal Listrik."
                        ]);
                    }
                    $pakai = PListrik::pakai($awal, $akhir);
                    $akhir_temp = $akhir;
                }

                $tarif_nama = $tarif->name;
                $standar = PListrik::standar($tarif_data->standar, $daya);
                $blok1 = PListrik::blok1($tarif_data->blok1, $standar);
                $blok2 = PListrik::blok2($tarif_data->blok2, $pakai, $standar);
                $beban = PListrik::beban($tarif_data->beban, $daya);
                $pju = PListrik::pju($tarif_data->pju, $blok1 + $blok2 + $beban);
                $ppn = PListrik::ppn($tarif_data->ppn, $blok1 + $blok2 + $beban + $pju);
                $sub = PListrik::tagihan($tarif_id, $awal, $akhir_temp, $daya);

                $diskon = 0;
                if($request->dlistrik){
                    $valid['diskonListrik'] = $request->dlistrik;
                    Validator::make($valid, [
                        'diskonListrik' => 'required|numeric|lte:100',
                    ])->validate();

                    $diskon = round((str_replace('.','',$request->dlistrik) / 100) * $sub);
                }

                $denda = 0;
                if($request->denlistrik){
                    $diff = $request->denlistrik;
                    $valid['dendaListrik'] = $request->denlistrik;
                    Validator::make($valid, [
                        'dendaListrik' => 'required|numeric|lte:9999',
                    ])->validate();

                    if($daya > 4400){
                        $denda = ceil($diff * ($tarif_data->denda2 / 100) * $sub);
                    }
                    else{
                        $denda = $diff * $tarif_data->denda1;
                    }
                }

                $total = $sub - $diskon + $denda;

                $data->b_listrik = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'daya' => $daya,
                    'awal' => $awal,
                    'akhir' => $akhir,
                    'reset' => $digit,
                    'pakai' => $pakai,
                    'blok1' => $blok1,
                    'blok2' => $blok2,
                    'beban' => $beban,
                    'pju' => $pju,
                    'ppn' => $ppn,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'denda' => $denda,
                    'denda_bulan' => $request->denlistrik,
                    'diskon' => $diskon,
                    'diskon_persen' => $request->dlistrik,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $den_tagihan += $denda;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $rea_tagihan += 0;
                $sel_tagihan += $total;
            }
            else{
                if($data->b_listrik){
                    $json = json_decode($data->b_listrik);
                    if($json->lunas == 1){
                        $lunas *= 1;

                        $sub_tagihan += $json->sub_tagihan;
                        $den_tagihan += $json->denda;
                        $dis_tagihan += $json->diskon;
                        $ttl_tagihan += $json->ttl_tagihan;
                        $rea_tagihan += $json->rea_tagihan;
                        $sel_tagihan += $json->sel_tagihan;
                    }
                    else{
                        $data->code_tlistrik = NULL;
                        $data->b_listrik = NULL;
                    }
                }
                else{
                    $data->code_tlistrik = NULL;
                    $data->b_listrik = NULL;
                }
            }

            //Air Bersih
            if($request->fas_airbersih){
                $lunas *= 0;

                $tarif_id = $request->pairbersih;

                $valid['tarifAirBersih'] = $tarif_id;
                Validator::make($valid, [
                    'tarifAirBersih' => 'required|exists:App\Models\PAirBersih,id',
                ])->validate();

                $tarif = PAirBersih::find($tarif_id);
                $tarif_data = json_decode($tarif->data);

                $awal = str_replace('.','',$request->awairbersih);
                $akhir = str_replace('.','',$request->akairbersih);
                $digit = null;

                $valid['awalMeterAirBersih'] = $awal;
                $valid['akhirMeterAirBersih'] = $akhir;
                Validator::make($valid, [
                    'awalMeterAirBersih' => 'required|numeric|lte:999999999',
                    'akhirMeterAirBersih' => 'required|numeric|lte:999999999',
                ])->validate();

                $kontrol = Store::where('kd_kontrol', $data->kd_kontrol)->select('id_tairbersih')->first();
                if($kontrol){
                    $data->code_tairbersih = TAirBersih::find($kontrol->id_tairbersih)->code;
                }

                if($request->checkairbersih0){
                    $digit = str_repeat("9",strlen($awal));
                    $pakai = PAirBersih::pakai($awal, $digit + $akhir);
                    $akhir_temp = $digit + $akhir;
                }
                else{
                    if($awal > $akhir){
                        return response()->json([
                            'info' => "Anda dapat mengaktifkan Meter kembali ke Nol.",
                            'warning' => "Akhir Air Bersih harus lebih besar dari Awal Air Bersih."
                        ]);
                    }
                    $pakai = PAirBersih::pakai($awal, $akhir);
                    $akhir_temp = $akhir;
                }

                $tarif_nama = $tarif->name;
                $bayar = PAirBersih::bayar($pakai, $tarif_data->tarif1, $tarif_data->tarif2);
                $pemeliharaan = PAirBersih::pemeliharaan($tarif_data->pemeliharaan);
                $beban = PAirBersih::beban($tarif_data->beban);
                $arkot = PAirBersih::arkot($tarif_data->airkotor, $bayar);
                $ppn = PAirBersih::ppn($tarif_data->ppn, $bayar + $pemeliharaan + $beban + $arkot);
                $sub = PAirBersih::tagihan($tarif_id, $awal, $akhir_temp);

                $diskon = 0;
                if($request->dairbersih){
                    $valid['diskonAirBersih'] = $request->dairbersih;
                    Validator::make($valid, [
                        'diskonAirBersih' => 'required|numeric|lte:100',
                    ])->validate();

                    $diskon = round((str_replace('.','',$request->dairbersih) / 100) * $sub);
                }


                $denda = 0;
                if($request->denairbersih){
                    $diff = $request->denairbersih;
                    $valid['dendaAirBersih'] = $diff;
                    Validator::make($valid, [
                        'dendaAirBersih' => 'required|numeric|lte:9999',
                    ])->validate();

                    $denda = $diff * $tarif_data->denda;
                }

                $total = $sub - $diskon + $denda;

                $data->b_airbersih = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'awal' => $awal,
                    'akhir' => $akhir,
                    'reset' => $digit,
                    'pakai' => $pakai,
                    'bayar' => $bayar,
                    'pemeliharaan' => $pemeliharaan,
                    'beban' => $beban,
                    'arkot' => $arkot,
                    'ppn' => $ppn,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'denda' => $denda,
                    'denda_bulan' => $request->denairbersih,
                    'diskon' => $diskon,
                    'diskon_persen' => $request->dairbersih,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $den_tagihan += $denda;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $rea_tagihan += 0;
                $sel_tagihan += $total;
            }
            else{
                if($data->b_airbersih){
                    $json = json_decode($data->b_airbersih);
                    if($json->lunas == 1){
                        $lunas *= 1;

                        $sub_tagihan += $json->sub_tagihan;
                        $den_tagihan += $json->denda;
                        $dis_tagihan += $json->diskon;
                        $ttl_tagihan += $json->ttl_tagihan;
                        $rea_tagihan += $json->rea_tagihan;
                        $sel_tagihan += $json->sel_tagihan;
                    }
                    else{
                        $data->code_tairbersih = NULL;
                        $data->b_airbersih = NULL;
                    }
                }
                else{
                    $data->code_tairbersih = NULL;
                    $data->b_airbersih = NULL;
                }
            }

            //Keamanan IPK
            if($request->fas_keamananipk){
                $lunas *= 0;

                $tarif_id = $request->pkeamananipk;

                $valid['tarifKeamananIpk'] = $tarif_id;
                Validator::make($valid, [
                    'tarifKeamananIpk' => 'required|exists:App\Models\PKeamananIpk,id',
                ])->validate();

                $tarif = PKeamananIpk::find($tarif_id);
                $tarif_data = json_decode($tarif->data);

                $tarif_nama = $tarif->name;

                $sub = PKeamananIpk::tagihan($tarif_id, $jml_los);

                $diskon = 0;
                if($request->dkeamananipk){
                    $diskon = str_replace('.','',$request->dkeamananipk);

                    if($diskon > $sub){
                        return response()->json(['info' => "Diskon Keamanan IPK maksimal $sub."]);
                    }
                }

                $total = $sub - $diskon;

                $keamanan = round(($tarif_data->keamanan / 100) * $total);
                $ipk = $total - $keamanan;

                $data->b_keamananipk = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'diskon' => $diskon,
                    'keamanan' => $keamanan,
                    'ipk' => $ipk,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $rea_tagihan += 0;
                $sel_tagihan += $total;
            }
            else{
                if($data->b_keamananipk){
                    $json = json_decode($data->b_keamananipk);
                    if($json->lunas == 1){
                        $lunas *= 1;

                        $sub_tagihan += $json->sub_tagihan;
                        $dis_tagihan += $json->diskon;
                        $ttl_tagihan += $json->ttl_tagihan;
                        $rea_tagihan += $json->rea_tagihan;
                        $sel_tagihan += $json->sel_tagihan;
                    }
                    else{
                        $data->b_keamananipk = NULL;
                    }
                }
                else{
                    $data->b_keamananipk = NULL;
                }
            }

            //Kebersihan
            if($request->fas_kebersihan){
                $lunas *= 0;

                $tarif_id = $request->pkebersihan;

                $valid['tarifKebersihan'] = $tarif_id;
                Validator::make($valid, [
                    'tarifKebersihan' => 'required|exists:App\Models\PKebersihan,id',
                ])->validate();

                $tarif = PKebersihan::find($tarif_id);

                $tarif_nama = $tarif->name;

                $sub = PKebersihan::tagihan($tarif_id, $jml_los);

                $diskon = 0;
                if($request->dkebersihan){
                    $diskon = str_replace('.','',$request->dkebersihan);

                    if($diskon > $sub){
                        return response()->json(['info' => "Diskon Kebersihan maksimal $sub."]);
                    }
                }

                $total = $sub - $diskon;

                $data->b_kebersihan = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'diskon' => $diskon,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $rea_tagihan += 0;
                $sel_tagihan += $total;
            }
            else{
                if($data->b_kebersihan){
                    $json = json_decode($data->b_kebersihan);
                    if($json->lunas == 1){
                        $lunas *= 1;

                        $sub_tagihan += $json->sub_tagihan;
                        $dis_tagihan += $json->diskon;
                        $ttl_tagihan += $json->ttl_tagihan;
                        $rea_tagihan += $json->rea_tagihan;
                        $sel_tagihan += $json->sel_tagihan;
                    }
                    else{
                        $data->b_kebersihan = NULL;
                    }
                }
                else{
                    $data->b_kebersihan = NULL;
                }
            }

            //Air Kotor
            if($request->fas_airkotor){
                $lunas *= 0;

                $tarif_id = $request->pairkotor;

                $valid['tarifAirKotor'] = $tarif_id;
                Validator::make($valid, [
                    'tarifAirKotor' => 'required|exists:App\Models\PAirKotor,id',
                ])->validate();

                $tarif = PAirKotor::find($tarif_id);

                $tarif_nama = $tarif->name;

                $sub = PAirKotor::tagihan($tarif_id);

                $diskon = 0;
                if($request->dairkotor){
                    $diskon = str_replace('.','',$request->dairkotor);

                    if($diskon > $sub){
                        return response()->json(['info' => "Diskon Kebersihan maksimal $sub."]);
                    }
                }

                $total = $sub - $diskon;

                $data->b_airkotor = json_encode([
                    'lunas' => 0,
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
                    'jml_los' => $jml_los,
                    'sub_tagihan' => $sub,
                    'diskon' => $diskon,
                    'ttl_tagihan' => $total,
                    'rea_tagihan' => 0,
                    'sel_tagihan' => $total,
                ]);

                $sub_tagihan += $sub;
                $dis_tagihan += $diskon;
                $ttl_tagihan += $total;
                $rea_tagihan += 0;
                $sel_tagihan += $total;
            }
            else{
                if($data->b_airkotor){
                    $json = json_decode($data->b_airkotor);
                    if($json->lunas == 1){
                        $lunas *= 1;

                        $sub_tagihan += $json->sub_tagihan;
                        $dis_tagihan += $json->diskon;
                        $ttl_tagihan += $json->ttl_tagihan;
                        $rea_tagihan += $json->rea_tagihan;
                        $sel_tagihan += $json->sel_tagihan;
                    }
                    else{
                        $data->b_airkotor = NULL;
                    }
                }
                else{
                    $data->b_airkotor = NULL;
                }
            }

            //Lainnya
            if($request->plain){
                $plain = $request->plain;
                $prices = array();

                for($i = 0; $i < count($plain); $i++){
                    $lunas *= 0;

                    $tarif_id = $request->plain[$i];

                    $valid['tarifLain'] = $tarif_id;
                    Validator::make($valid, [
                        'tarifLain' => 'required|exists:App\Models\PLain,id',
                    ])->validate();

                    $tarif = PLain::find($tarif_id);

                    $tarif_nama = $tarif->name;

                    $sub = PLain::tagihan($tarif_id, $jml_los);

                    $total = $sub;

                    $prices[$i] = [
                        'lunas' => 0,
                        'tarif_id' => $tarif_id,
                        'tarif_nama' => $tarif_nama,
                        'price' => $tarif->price,
                        'jml_los' => $jml_los,
                        'satuan_id' => $tarif->satuan,
                        'satuan_nama' => PLain::satuan($tarif->satuan),
                        'sub_tagihan' => $total,
                        'ttl_tagihan' => $total,
                        'rea_tagihan' => 0,
                        'sel_tagihan' => $total,
                    ];
                }

                if($data->b_lain){
                    $json = json_decode($data->b_lain);
                    $lunas_lain = array();
                    foreach ($json as $d => $b) {
                        if($b->lunas == 1){
                            $lunas_lain[$d] = $json[$d];
                        }
                    }

                    $prices = array_merge($lunas_lain, $prices);
                }

                $data->b_lain = json_encode($prices);

                $json = json_decode($data->b_lain);
                foreach ($json as $d => $b) {
                    $lunas *= $b->lunas;

                    $sub_tagihan += $b->sub_tagihan;
                    $ttl_tagihan += $b->ttl_tagihan;
                    $rea_tagihan += $b->rea_tagihan;
                    $sel_tagihan += $b->sel_tagihan;
                }
            }
            else{
                if($data->b_lain){
                    $json = json_decode($data->b_lain);
                    foreach ($json as $d => $b) {
                        if($b->lunas == 1){
                            $lunas *= 1;

                            $sub_tagihan += $b->sub_tagihan;
                            $ttl_tagihan += $b->ttl_tagihan;
                            $rea_tagihan += $b->rea_tagihan;
                            $sel_tagihan += $b->sel_tagihan;
                        }
                        else{
                            unset($json[$d]);
                        }
                    }
                    $json = array_values($json);
                    $data->b_lain = json_encode($json);

                    if(empty($json)){
                        $data->b_lain = NULL;
                    }
                }
                else{
                    $data->b_lain = NULL;
                }
            }

            if($lunas == 1){
                $data->stt_lunas = 1;
                $data->stt_bayar = 1;
                $data->stt_publish = 1;
            }
            else{
                $data->stt_lunas = 0;
            }

            $json = json_decode($data->b_tagihan);
            $json->lunas = $lunas;
            $json->sub_tagihan = $sub_tagihan;
            $json->denda = $den_tagihan;
            $json->diskon = $dis_tagihan;
            $json->ttl_tagihan = $ttl_tagihan;
            $json->rea_tagihan = $rea_tagihan;
            $json->sel_tagihan = $sel_tagihan;
            $data->b_tagihan = json_encode($json);

            $json = json_decode($data->data);
            $json->lunas = $lunas;
            $json->publish = $publish;
            $json->publish_by = $publish_by;
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();
            $json = json_encode($json);
            $data->data = $json;

            $kontrol = $data->nicename;

            try{
                $data->save();
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = str_replace('-','',$kontrol);

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
        //
    }

    public function publish($id){
        $tagihan = Bill::select('id', 'stt_publish', 'data')->find($id);

        $stt_publish = $tagihan->stt_publish;
        $json = json_decode($tagihan->data);

        if($stt_publish == 1){
            $tagihan->stt_publish = 0;
            $update = 'Data Unpublished.';
        }
        else{
            $tagihan->stt_publish = 1;
            $update = 'Data Published.';
        }

        $json->publish = Carbon::now()->toDateTimeString();
        $json = json_encode($json);

        $tagihan->data = $json;

        try{
            $tagihan->save();
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Data failed to save.', 'description' => $e]);
        }

        return response()->json(['success' => $update]);
    }
}
