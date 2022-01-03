<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\Income;
use App\Models\Receipt70mm;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\EscposImage;

use DataTables;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $level = 1;
            if(Session::get('paymentLevel')){
                $level = Session::get('paymentLevel');
            }

            if($level == 3){
                $data = Income::whereIn('active', [0,1]);
            }
            else if($level == 2){
                $data = Income::where('active', 1);
            }
            else{
                $data = Payment::select('id','kd_kontrol','nicename','pengguna','info','ids_tagihan','tagihan');
            }

            return DataTables::of($data)
            ->addColumn('action', function($data) use ($level){
                if($level == 3){
                    $button = '<button nama="'.$data->kd_kontrol." ".$data->code.'" id="'.Crypt::encrypt($data->id).'" class="btn btn-sm btn-rounded btn-danger cetak">Cetak</button>';
                }
                else if($level == 2){
                    $button = '<button nama="'.$data->kd_kontrol." ".$data->code.'" id="'.Crypt::encrypt($data->id).'" class="btn btn-sm btn-rounded btn-info restore">Restore</button>';
                }
                else{
                    $button = '<button nama="'.$data->kd_kontrol.'" id="'.Crypt::encrypt($data->id).'" class="btn btn-sm btn-rounded btn-success bayar">Bayar</button>';
                }
                return $button;
            })
            ->editColumn('kd_kontrol', function($data) use ($level){
                if($level == 2 || $level == 3){
                    $button = "<span>$data->kd_kontrol<br>$data->code</span>";
                }
                else{
                    $button = $data->kd_kontrol;
                }
                return $button;
            })
            ->editColumn('pengguna', function($data){
                $name = $data->pengguna;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                    return "<span data-toggle='tooltip' title='$data->pengguna'>$name</span>";
                }
                else{
                    return $name;
                }
            })
            ->editColumn('info', function($data){
                $name = $data->info;
                if(strlen($name) > 20) {
                    $name = substr($name, 0, 16);
                    $name = str_pad($name,  20, ".");
                    return "<span data-toggle='tooltip' title='$data->info'>$name</span>";
                }
                else{
                    return $name;
                }
            })
            ->editColumn('tagihan', function($data){
                return number_format($data->tagihan, 0, '', '.');
            })
            ->filterColumn('kd_kontrol', function ($data, $keyword) use ($level) {
                $keywords = trim($keyword);
                if($level == 2 || $level == 3){
                    $data->whereRaw("CONCAT(code, kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
                }
                else{
                    $data->whereRaw("CONCAT(kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
                }
            })
            ->rawColumns(['action', 'kd_kontrol', 'pengguna', 'info'])
            ->make(true);
        }
        Session::put('lastPlace', 'payment');
        return view('portal.payment.index');
    }

    public function paymentLevel(){
        Session::put('paymentLevel', 1);
        $level = 1;

        return response()->json(['success' => $level]);
    }

    public function paymentChange($level){
        Session::put('paymentLevel', $level);
        return response()->json(['success' => $level]);
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
            $code = Income::make('code');
            $faktur = Income::make('faktur');
            $period = Income::make('period');

            $tagihan = 0;
            $i = 0;
            $ids_tagihan = [];

            if($request->bayarlistrik){
                $ids = $request->bulanlistrik;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::find($decrypted);
                        if($bill->b_listrik){
                            $json = json_decode($bill->b_listrik);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $json->sel_tagihan = 0;
                            $bill->b_listrik = json_encode($json);
                            $bill->save();
                        }
                    }
                }
            }

            if($request->bayarairbersih){
                $ids = $request->bulanairbersih;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::find($decrypted);
                        if($bill->b_airbersih){
                            $json = json_decode($bill->b_airbersih);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $json->sel_tagihan = 0;
                            $bill->b_airbersih = json_encode($json);
                            $bill->save();
                        }
                    }
                }
            }

            if($request->bayarkeamananipk){
                $ids = $request->bulankeamananipk;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::find($decrypted);
                        if($bill->b_keamananipk){
                            $json = json_decode($bill->b_keamananipk);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $json->sel_tagihan = 0;
                            $bill->b_keamananipk = json_encode($json);
                            $bill->save();
                        }
                    }
                }
            }

            if($request->bayarkebersihan){
                $ids = $request->bulankebersihan;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::find($decrypted);
                        if($bill->b_kebersihan){
                            $json = json_decode($bill->b_kebersihan);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $json->sel_tagihan = 0;
                            $bill->b_kebersihan = json_encode($json);
                            $bill->save();
                        }
                    }
                }
            }

            if($request->bayarairkotor){
                $ids = $request->bulanairkotor;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::find($decrypted);
                        if($bill->b_airkotor){
                            $json = json_decode($bill->b_airkotor);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $json->sel_tagihan = 0;
                            $bill->b_airkotor = json_encode($json);
                            $bill->save();
                        }
                    }
                }
            }

            if($request->bayarlain){
                $ids = $request->bulanlain;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::find($decrypted);
                        if($bill->b_lain){
                            $json = json_decode($bill->b_lain);
                            $sel_tagihan = 0;
                            foreach ($json as $i => $val) {
                                if($val->lunas == 0){
                                    $val->lunas = 1;
                                    $val->kasir = Auth::user()->name;
                                    $val->code = $code;
                                    $val->rea_tagihan += $val->sel_tagihan;

                                    $sel_tagihan += $val->sel_tagihan;

                                    $val->sel_tagihan = 0;
                                }
                            }
                            $bill->b_lain = json_encode($json);
                            $bill->save();

                            $tagihan += $sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;
                        }
                    }
                }
            }

            try {
                $decrypted = Crypt::decrypt($request->paymentId);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Decryption payment failed.']);
            }

            $payment = Payment::find($decrypted);
            $sync = explode(',', $payment->ids_tagihan);
            foreach($sync as $s){
                Bill::syncById($s);
            }

            $ids_tagihan = array_unique($ids_tagihan, SORT_NUMERIC);
            $ids_tagihan = implode(',', $ids_tagihan);


            $print = json_encode([
                'kd_kontrol' => $payment->kd_kontrol,
                'no_los' => $payment->no_los,
                'pengguna' => $payment->pengguna,
                'info' => $payment->info,
                'code' => $code,
                'faktur' => $faktur,
                'bayar' => Carbon::now()->format('d-m-Y H:i:s'),
                'kasir' => Auth::user()->name,
             ]);

            Income::create([
                'code' => $code,
                'faktur' => $faktur,
                'id_period' => $period,
                'kd_kontrol' => $payment->kd_kontrol,
                'nicename' => $payment->nicename,
                'no_los' => $payment->no_los,
                'pengguna' => $payment->pengguna,
                'info' => $payment->info,
                'ids_tagihan' => $ids_tagihan,
                'tagihan' => $tagihan,
                'active' => 1,
                'cetak' => 0,
                'data' => $print
            ]);

            $print = Crypt::encrypt($print);

            Payment::syncByKontrol($request->kontrol);

            return response()->json([
                'success' => 'Payment successful',
                'print' => $print
            ]);
        }
    }

    public function receipt($data){
        try {
            $decrypted = Crypt::decrypt($data);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Failed to decrypting receipt.']);
        }

        $data = json_decode($decrypted);

        $dirfile = storage_path('app/public/logo_struk.png');
        $logo = EscposImage::load($dirfile,false);

        $profile   = CapabilityProfile::load("POS-5890");
        $connector = new RawbtPrintConnector();
        $printer   = new Printer($connector,$profile);
        $i = 1;

        $nama = (strlen($data->pengguna) > 30) ? str_pad(substr($data->pengguna, 0, 26),  30, ".") : $data->pengguna;
        $kontrol = (strlen($data->kd_kontrol) > 30) ? str_pad(substr($data->kd_kontrol, 0, 26),  30, ".") : $data->kd_kontrol;
        $info = (strlen($data->info) > 30) ? str_pad(substr($data->info, 0, 26),  30, ".") : $data->info;
        $kasir = (strlen($data->kasir) > 25) ? str_pad(substr($data->kasir, 0, 21),  25, ".") : $data->kasir;
        if(strlen($data->no_los) > 30){
            $no_los = substr($data->no_los, 0, 28);
            $no_los = substr($no_los, 0, strrpos($no_los, ','));
            $no_los = $no_los . "," . "...";
        } else {
            $no_los = $data->no_los;
        }


        try{
            //Header
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> bitImageColumnFormat($logo, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> setEmphasis(true);
            $printer -> text("Nama    : $nama\n");
            $printer -> text("Kontrol : $kontrol\n");
            $printer -> text("Los     : $no_los\n");
            if($data->info){
                $printer -> text("Info    : $info\n");
            }
            $printer -> text("Code    : $data->code\n");
            $printer -> setEmphasis(false);
            $printer -> feed();
            $printer -> setFont(Printer::FONT_B);
            //End Header

            //Content
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> setEmphasis(true);
            $printer -> text("Items           JAN 2021             Rp.");
            $printer -> setEmphasis(false);
            $printer -> feed();
            $printer -> text("----------------------------------------");
            $printer -> feed();
            $printer -> text(new Receipt70mm("1. Listrik","3.143.283"));
            $printer -> setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text(new Receipt70mm("Daya","900",false));
            $printer -> text(new Receipt70mm("Awal","1.300",false));
            $printer -> text(new Receipt70mm("Akhir","1.500",false));
            $printer -> text(new Receipt70mm("Pakai","200",false));
            $printer -> feed();
            //End Content

            //Footer
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> text(new Receipt70mm("Total","3.143.283",true,true));
            $printer -> selectPrintMode();
            $printer -> setFont(Printer::FONT_B);
            $printer -> text("----------------------------------------\n");
            $printer -> text("Nomor : $data->faktur\n");
            $printer -> text("Dibayar pada $data->bayar\n");
            $printer -> text("Harap simpan tanda terima ini\nsebagai bukti pembayaran yang sah.\nTerimakasih.\nPembayaran sudah termasuk PPN\n");
            $printer -> text("Ksr : $kasir\n");
            $printer -> feed();
            $printer -> cut();
            //End Footer
        }catch(\Exception $e){
            return response()->json(['error' => 'Receipt failed to print.']);
        }finally{
            $printer->close();
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
        //
    }

    public function summary($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data = Payment::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $ids = explode(',', $data->ids_tagihan);

            $listrik = [];
            $airbersih = [];
            $keamananipk = [];
            $kebersihan = [];
            $airkotor = [];
            $lain = [];

            foreach ($ids as $id) {
                try{
                    $bill = Bill::with([
                        'period:id,nicename'
                    ])->findOrFail($id);
                }catch(ModelNotFoundException $e){
                    return response()->json(['error' => 'Malfunction payment.', 'info' => 'Can\'t find ID.']);
                }

                $bill_Id = Crypt::encrypt($id);

                if($bill->b_listrik){
                    $bill_listrik = json_decode($bill->b_listrik);
                    if($bill_listrik->lunas == 0){
                        $listrik[] = [
                            'id' => $bill_Id,
                            'period' => $bill->period->nicename,
                            'sub_tagihan' => $bill_listrik->sub_tagihan,
                            'den_tagihan' => $bill_listrik->denda,
                            'dis_tagihan' => $bill_listrik->diskon,
                            'ttl_tagihan' => $bill_listrik->ttl_tagihan,
                            'rea_tagihan' => $bill_listrik->rea_tagihan,
                            'sel_tagihan' => $bill_listrik->sel_tagihan,
                        ];
                    }
                }

                if($bill->b_airbersih){
                    $bill_airbersih = json_decode($bill->b_airbersih);
                    if($bill_airbersih->lunas == 0){
                        $airbersih[] = [
                            'id' => $bill_Id,
                            'period' => $bill->period->nicename,
                            'sub_tagihan' => $bill_airbersih->sub_tagihan,
                            'den_tagihan' => $bill_airbersih->denda,
                            'dis_tagihan' => $bill_airbersih->diskon,
                            'ttl_tagihan' => $bill_airbersih->ttl_tagihan,
                            'rea_tagihan' => $bill_airbersih->rea_tagihan,
                            'sel_tagihan' => $bill_airbersih->sel_tagihan,
                        ];
                    }
                }

                if($bill->b_keamananipk){
                    $bill_keamananipk = json_decode($bill->b_keamananipk);
                    if($bill_keamananipk->lunas == 0){
                        $keamananipk[] = [
                            'id' => $bill_Id,
                            'period' => $bill->period->nicename,
                            'sub_tagihan' => $bill_keamananipk->sub_tagihan,
                            'dis_tagihan' => $bill_keamananipk->diskon,
                            'ttl_tagihan' => $bill_keamananipk->ttl_tagihan,
                            'rea_tagihan' => $bill_keamananipk->rea_tagihan,
                            'sel_tagihan' => $bill_keamananipk->sel_tagihan,
                        ];
                    }
                }

                if($bill->b_kebersihan){
                    $bill_kebersihan = json_decode($bill->b_kebersihan);
                    if($bill_kebersihan->lunas == 0){
                        $kebersihan[] = [
                            'id' => $bill_Id,
                            'period' => $bill->period->nicename,
                            'sub_tagihan' => $bill_kebersihan->sub_tagihan,
                            'dis_tagihan' => $bill_kebersihan->diskon,
                            'ttl_tagihan' => $bill_kebersihan->ttl_tagihan,
                            'rea_tagihan' => $bill_kebersihan->rea_tagihan,
                            'sel_tagihan' => $bill_kebersihan->sel_tagihan,
                        ];
                    }
                }

                if($bill->b_airkotor){
                    $bill_airkotor = json_decode($bill->b_airkotor);
                    if($bill_airkotor->lunas == 0){
                        $airkotor[] = [
                            'id' => $bill_Id,
                            'period' => $bill->period->nicename,
                            'sub_tagihan' => $bill_airkotor->sub_tagihan,
                            'dis_tagihan' => $bill_airkotor->diskon,
                            'ttl_tagihan' => $bill_airkotor->ttl_tagihan,
                            'rea_tagihan' => $bill_airkotor->rea_tagihan,
                            'sel_tagihan' => $bill_airkotor->sel_tagihan,
                        ];
                    }
                }

                if($bill->b_lain){
                    $bill_lain = json_decode($bill->b_lain);
                    $lunas = 1;
                    $ttl = 0;
                    $rea = 0;
                    $sel = 0;
                    $fas = '';
                    foreach ($bill_lain as $i => $val) {
                        if($val->lunas == 0){
                            $lunas *= 0;
                            $fas = $fas . "$val->tarif_nama : " . number_format($val->ttl_tagihan, 0, '', '.') . " (+)<br>";
                            $ttl += $val->ttl_tagihan;
                            $rea += $val->rea_tagihan;
                            $sel += $val->sel_tagihan;
                        }
                    }

                    if($lunas == 0){
                        $lain[] = [
                            'id' => $bill_Id,
                            'period' => $bill->period->nicename,
                            'fasilitas' => rtrim($fas, "<br>"),
                            'ttl_tagihan' => $ttl,
                            'rea_tagihan' => $rea,
                            'sel_tagihan' => $sel,
                        ];
                    }
                }
            }

            $data['listrik'] = $listrik;
            $data['airbersih'] = $airbersih;
            $data['keamananipk'] = $keamananipk;
            $data['kebersihan'] = $kebersihan;
            $data['airkotor'] = $airkotor;
            $data['lain'] = $lain;
            $data['ttl_tagihan'] = $data->tagihan;

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
    }

    public function restore($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Failed to decrypt.', 'description' => $e]);
            }

            $data = Income::find($decrypted);

            $code = $data->code;

            $kontrol = $data->kd_kontrol;

            $ids = $data->ids_tagihan;
            $ids = explode(',', $ids);
            foreach($ids as $id){
                $bill = Bill::find($id);

                if($bill->b_listrik){
                    $json = json_decode($bill->b_listrik);
                    if($code == $json->code){
                        $json->lunas = 0;
                        $json->kasir = null;
                        $json->code = null;
                        $json->sel_tagihan = $json->rea_tagihan;
                        $json->rea_tagihan = 0;

                        $bill->b_listrik = json_encode($json);
                    }
                }

                if($bill->b_airbersih){
                    $json = json_decode($bill->b_airbersih);
                    if($code == $json->code){
                        $json->lunas = 0;
                        $json->kasir = null;
                        $json->code = null;
                        $json->sel_tagihan = $json->rea_tagihan;
                        $json->rea_tagihan = 0;

                        $bill->b_airbersih = json_encode($json);
                    }
                }

                if($bill->b_keamananipk){
                    $json = json_decode($bill->b_keamananipk);
                    if($code == $json->code){
                        $json->lunas = 0;
                        $json->kasir = null;
                        $json->code = null;
                        $json->sel_tagihan = $json->rea_tagihan;
                        $json->rea_tagihan = 0;

                        $bill->b_keamananipk = json_encode($json);
                    }
                }

                if($bill->b_kebersihan){
                    $json = json_decode($bill->b_kebersihan);
                    if($code == $json->code){
                        $json->lunas = 0;
                        $json->kasir = null;
                        $json->code = null;
                        $json->sel_tagihan = $json->rea_tagihan;
                        $json->rea_tagihan = 0;

                        $bill->b_kebersihan = json_encode($json);
                    }
                }

                if($bill->b_airkotor){
                    $json = json_decode($bill->b_airkotor);
                    if($code == $json->code){
                        $json->lunas = 0;
                        $json->kasir = null;
                        $json->code = null;
                        $json->sel_tagihan = $json->rea_tagihan;
                        $json->rea_tagihan = 0;

                        $bill->b_airkotor = json_encode($json);
                    }
                }

                if($bill->b_lain){
                    $json = json_decode($bill->b_lain);
                    foreach ($json as $i => $val) {
                        if($code == $val->code){
                            $val->lunas = 0;
                            $val->kasir = null;
                            $val->code = null;
                            $val->sel_tagihan = $val->rea_tagihan;
                            $val->rea_tagihan = 0;
                        }
                    }

                    $bill->b_lain = json_encode($json);
                }

                $bill->save();

                Bill::syncById($id);
            }

            Payment::syncByKontrol($kontrol);

            $data->delete();

            return response()->json(['success' => 'Data restored.']);
        }
    }
}
