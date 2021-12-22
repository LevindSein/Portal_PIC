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
                $button = '';
                if($data->stt_publish == 1){
                    if($data->stt_bayar == 1){
                        if($data->stt_lunas == 1){
                            $button .= '<span style="color:#36bea6;">Lunas</span>';
                        }
                        else{
                            $button .= '<span style="color:#e74a3b;">Belum Lunas</span>';
                        }
                    }
                    else{
                        $button .= '<a type="button" data-toggle="tooltip" title="Unpublish" name="unpublish" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="unpublish"><i class="fas fa-undo" style="color:#e74a3b;"></i></a>';
                    }
                }
                else{
                    $button .= '<a type="button" data-toggle="tooltip" title="Publish" name="publish" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="publish"><i class="fas fa-check" style="color:#36bea6;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
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
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $listrik = "<a type='button' data-container='body' data-trigger='click' data-toggle='popover' data-html='true' title='Listrik' data-content='Daya: $daya<br>Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br>Tagihan: $tagihan' class='mr-1'><i class='fas fa-bolt' style='color:#fd7e14;'></i></a>";
                }

                $airbersih = '';
                if($data->b_airbersih){
                    $json = json_decode($data->b_airbersih);
                    $awal = number_format($json->awal, 0, '', '.');
                    $akhir = number_format($json->akhir, 0, '', '.');
                    $pakai = number_format($json->pakai, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $airbersih = "<a type='button' data-container='body' data-trigger='click' data-toggle='popover' data-html='true' title='Air Bersih' data-content='Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br>Tagihan: $tagihan' class='mr-1'><i class='fas fa-tint' style='color:#36b9cc;'></i></a>";
                }

                $keamananipk = '';
                if($data->b_keamananipk){
                    $json = json_decode($data->b_keamananipk);
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $keamananipk = "<a type='button' data-container='body' data-trigger='click' data-toggle='popover' data-html='true' title='Keamanan IPK' data-content='Jml Los: $jml_los<br>Tagihan: $tagihan' class='mr-1'><i class='fas fa-lock' style='color:#e74a3b;'></i></a>";
                }

                $kebersihan = '';
                if($data->b_kebersihan){
                    $json = json_decode($data->b_kebersihan);
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $kebersihan = "<a type='button' data-container='body' data-trigger='click' data-toggle='popover' data-html='true' title='Kebersihan' data-content='Jml Los: $jml_los<br>Tagihan: $tagihan' class='mr-1'><i class='fas fa-leaf' style='color:#1cc88a;'></i></a>";
                }

                $airkotor = '';
                if($data->b_airkotor){
                    $json = json_decode($data->b_airkotor);
                    $tagihan = number_format($json->ttl_tagihan, 0, '', '.');
                    $airkotor = "<a type='button' data-container='body' data-trigger='click' data-toggle='popover' data-html='true' title='Air Kotor' data-content='Tagihan: $tagihan' class='mr-1'><i class='fad fa-burn' style='color:#000000;'></i></a>";
                }

                $lain = '';
                if($data->b_lain){
                    $json = json_decode($data->b_lain);
                    $tagihan = 0;
                    foreach($json as $d => $ttl){
                        $tagihan += $ttl->ttl_tagihan;
                    }
                    $tagihan = number_format($tagihan, 0, '', '.');
                    $lain = "<a type='button' data-container='body' data-trigger='click' data-toggle='popover' data-html='true' title='Lainnya' data-content='Tagihan: $tagihan' class='mr-1'><i class='fas fa-chart-pie' style='color:#c5793a;'></i></a>";
                }

                return $listrik.$airbersih.$keamananipk.$kebersihan.$airkotor.$lain;
            })
            ->editColumn('b_tagihan', function($data){
                $json = json_decode($data->b_tagihan);
                return number_format($json->ttl_tagihan);
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'fasilitas'])
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
                $digit = $request->inputlistrik0;

                $valid['dayaListrik'] = $daya;
                $valid['awalMeterListrik'] = $awal;
                $valid['akhirMeterListrik'] = $akhir;
                Validator::make($valid, [
                    'dayaListrik' => 'required|numeric|lte:999999999',
                    'awalMeterListrik' => 'required|numeric|lte:999999999',
                    'akhirMeterListrik' => 'required|numeric|lte:999999999',
                ])->validate();

                $kontrol = Store::where('kd_kontrol', $request->kontrol)->select('id_tlistrik')->first();
                if($kontrol->id_tlistrik){
                    $data['code_tlistrik'] = TListrik::find($kontrol->id_tlistrik)->code;
                }

                if($request->checklistrik0){
                    if($digit < strlen($awal)){
                        $digit = strlen($awal);
                        return response()->json(['info' => "Alat Listrik minimal $digit digit."]);
                    }
                    $digit = str_repeat("9",$digit);
                    $pakai = PListrik::pakai($awal, $digit + $akhir);
                    $akhir_temp = $digit + $akhir;
                }
                else{
                    if($awal > $akhir){
                        return response()->json(['info' => "Akhir Meter harus lebih besar dari Awal Meter."]);
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
                        'dendaListrik' => 'required|numeric|lte:999999999',
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
                $digit = $request->inputairbersih0;

                $valid['awalMeterAirBersih'] = $awal;
                $valid['akhirMeterAirBersih'] = $akhir;
                Validator::make($valid, [
                    'awalMeterAirBersih' => 'required|numeric|lte:999999999',
                    'akhirMeterAirBersih' => 'required|numeric|lte:999999999',
                ])->validate();

                $kontrol = Store::where('kd_kontrol', $request->kontrol)->select('id_tairbersih')->first();
                if($kontrol->id_tairbersih){
                    $data['code_tairbersih'] = TAirBersih::find($kontrol->id_tairbersih)->code;
                }

                if($request->checkairbersih0){
                    if($digit < strlen($awal)){
                        $digit = strlen($awal);
                        return response()->json(['info' => "Alat Air Bersih minimal $digit digit."]);
                    }
                    $digit = str_repeat("9",$digit);
                    $pakai = PAirBersih::pakai($awal, $digit + $akhir);
                    $akhir_temp = $digit + $akhir;
                }
                else{
                    if($awal > $akhir){
                        return response()->json(['info' => "Akhir Meter harus lebih besar dari Awal Meter."]);
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
                        'dendaAirBersih' => 'required|numeric|lte:999999999',
                    ])->validate();

                    $denda = $diff * $tarif_data->denda;
                }

                $total = $sub - $diskon + $denda;

                $data['b_airbersih'] = json_encode([
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
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
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
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
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
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'price' => $tarif->price,
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
                        'tarif_id' => $tarif_id,
                        'tarif_nama' => $tarif_nama,
                        'price' => $tarif->price,
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
                'sub_tagihan' => $sub_tagihan,
                'denda' => $den_tagihan,
                'diskon' => $dis_tagihan,
                'ttl_tagihan' => $ttl_tagihan,
                'rea_tagihan' => 0,
                'sel_tagihan' => $sel_tagihan,
            ]);

            $data['data'] = json_encode([
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
        //
    }

    public function publish($id){
        $tagihan = Bill::select('id', 'stt_publish', 'stt_bayar')->find($id);

        $stt_publish = $tagihan->stt_publish;
        $stt_bayar = $tagihan->stt_bayar;

        if($stt_bayar == 1){
            return response()->json(['error' => 'Data failed to unpublish.', 'info' => 'Tagihan sudah dibayar.']);
        }
        else{
            if($stt_publish == 1){
                $tagihan->stt_publish = 0;
            }
            else{
                $tagihan->stt_publish = 1;
            }

            try{
                $tagihan->save();
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to save.', 'description' => $e]);
            }

            return response()->json(['success' => 'Data updated.']);
        }
    }
}
