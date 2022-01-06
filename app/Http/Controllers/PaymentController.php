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
                //Cetak Pembayaran
                $data = Income::whereIn('active', [0,1])->orderBy('id','desc');
            }
            else if($level == 2){
                //Restore Pembayaran
                $data = Income::where('active', 1)->orderBy('id','desc');
            }
            else{
                //Pembayaran Utama
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

            $fasilitas = 0;

            $listrik = null;
            if($request->bayarlistrik){
                $ids = $request->bulanlistrik;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::with(['period:id,nicename'])->find($decrypted);
                        if($bill->b_listrik){
                            $json = json_decode($bill->b_listrik);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $listrik[] = [
                                'bulan' => $bill->period->nicename,
                                'daya' => $json->daya,
                                'awal' => $json->awal,
                                'akhir' => $json->akhir,
                                'pakai' => $json->pakai,
                                'denda' => $json->denda,
                                'tagihan' => $json->sel_tagihan
                            ];

                            $json->sel_tagihan = 0;
                            $bill->b_listrik = json_encode($json);
                            $bill->save();
                        }
                    }

                    $fasilitas++;
                }
            }

            $airbersih = null;
            if($request->bayarairbersih){
                $ids = $request->bulanairbersih;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::with(['period:id,nicename'])->find($decrypted);
                        if($bill->b_airbersih){
                            $json = json_decode($bill->b_airbersih);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $airbersih[] = [
                                'bulan' => $bill->period->nicename,
                                'awal' => $json->awal,
                                'akhir' => $json->akhir,
                                'pakai' => $json->pakai,
                                'denda' => $json->denda,
                                'tagihan' => $json->sel_tagihan
                            ];

                            $json->sel_tagihan = 0;
                            $bill->b_airbersih = json_encode($json);
                            $bill->save();
                        }
                    }

                    $fasilitas++;
                }
            }

            $keamananipk = null;
            if($request->bayarkeamananipk){
                $ids = $request->bulankeamananipk;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::with(['period:id,nicename'])->find($decrypted);
                        if($bill->b_keamananipk){
                            $json = json_decode($bill->b_keamananipk);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $keamananipk[] = [
                                'bulan' => $bill->period->nicename,
                                'tagihan' => $json->sel_tagihan
                            ];

                            $json->sel_tagihan = 0;
                            $bill->b_keamananipk = json_encode($json);
                            $bill->save();
                        }
                    }

                    $fasilitas++;
                }
            }

            $kebersihan = null;
            if($request->bayarkebersihan){
                $ids = $request->bulankebersihan;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::with(['period:id,nicename'])->find($decrypted);
                        if($bill->b_kebersihan){
                            $json = json_decode($bill->b_kebersihan);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $kebersihan[] = [
                                'bulan' => $bill->period->nicename,
                                'tagihan' => $json->sel_tagihan
                            ];

                            $json->sel_tagihan = 0;
                            $bill->b_kebersihan = json_encode($json);
                            $bill->save();
                        }
                    }

                    $fasilitas++;
                }
            }

            $airkotor = null;
            if($request->bayarairkotor){
                $ids = $request->bulanairkotor;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::with(['period:id,nicename'])->find($decrypted);
                        if($bill->b_airkotor){
                            $json = json_decode($bill->b_airkotor);
                            $json->lunas = 1;
                            $json->kasir = Auth::user()->name;
                            $json->code = $code;
                            $json->rea_tagihan += $json->sel_tagihan;

                            $tagihan += $json->sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $airkotor[] = [
                                'bulan' => $bill->period->nicename,
                                'tagihan' => $json->sel_tagihan
                            ];

                            $json->sel_tagihan = 0;
                            $bill->b_airkotor = json_encode($json);
                            $bill->save();
                        }
                    }

                    $fasilitas++;
                }
            }

            $lain = null;
            if($request->bayarlain){
                $ids = $request->bulanlain;
                if($ids){
                    foreach($ids as $id){
                        try {
                            $decrypted = Crypt::decrypt($id);
                        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                            return response()->json(['error' => 'Decryption payment failed.']);
                        }

                        $bill = Bill::with(['period:id,nicename'])->find($decrypted);
                        if($bill->b_lain){
                            $json = json_decode($bill->b_lain);
                            $sel_tagihan = 0;
                            foreach ($json as $j => $val) {
                                if($val->lunas == 0){
                                    $val->lunas = 1;
                                    $val->kasir = Auth::user()->name;
                                    $val->code = $code;
                                    $val->rea_tagihan += $val->sel_tagihan;

                                    $sel_tagihan += $val->sel_tagihan;

                                    $val->sel_tagihan = 0;
                                }
                            }

                            $tagihan += $sel_tagihan;
                            $ids_tagihan[$i] = $decrypted;
                            $i++;

                            $lain[] = [
                                'bulan' => $bill->period->nicename,
                                'tagihan' => $sel_tagihan
                            ];

                            $bill->b_lain = json_encode($json);
                            $bill->save();
                        }
                    }

                    $fasilitas++;
                }
            }

            if($fasilitas == 0){
                return response()->json(['warning' => "Transaction suspended."]);
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

            $ids_tagihan = array_unique($ids_tagihan);
            $ids_tagihan = implode(',', $ids_tagihan);

            $print = json_encode([
                'kd_kontrol' => $payment->kd_kontrol,
                'no_los' => $payment->no_los,
                'pengguna' => $payment->pengguna,
                'info' => $payment->info,
                'code' => $code,
                'faktur' => $faktur,
                'listrik' => $listrik,
                'airbersih' => $airbersih,
                'keamananipk' => $keamananipk,
                'kebersihan' => $kebersihan,
                'airkotor' => $airkotor,
                'lain' => $lain,
                'tagihan' => $tagihan,
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
                'shift' => Session::get('shift'),
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
        $this->print($data, 'print', '');
    }

    public function reprintReceipt($id){
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Failed to decrypting receipt.']);
        }

        $data = Income::find($decrypted);
        $data = json_decode($data->data);
        $this->print($data, 'reprint', $decrypted);
    }

    public function print($data, $type, $id){
        $dirfile = storage_path('app/public/logo_struk.png');
        $logo = EscposImage::load($dirfile,false);

        $profile   = CapabilityProfile::load("POS-5890");
        $connector = new RawbtPrintConnector();
        $printer   = new Printer($connector,$profile);

        $nama = (strlen($data->pengguna) > 30) ? str_pad(substr($data->pengguna, 0, 26),  30, ".") : $data->pengguna;
        $kontrol = (strlen($data->kd_kontrol) > 30) ? str_pad(substr($data->kd_kontrol, 0, 26),  30, ".") : $data->kd_kontrol;
        $info = (strlen($data->info) > 30) ? str_pad(substr($data->info, 0, 26),  30, ".") : $data->info;
        $kasir = (strlen($data->kasir) > 25) ? str_pad(substr($data->kasir, 0, 21),  25, ".") : $data->kasir;
        if(strlen($data->no_los) > 30){
            $no_los = substr($data->no_los, 0, 28);
            $no_los = substr($no_los, 0, strrpos($no_los, ','));
            $no_los = $no_los . "," . "...";
            $no_los = substr($no_los, 0, 30);
        } else {
            $no_los = $data->no_los;
        }

        try{
            //Header
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> bitImageColumnFormat($logo, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
            $printer -> setEmphasis(true);
            $printer -> text(str_pad("Nama    : $nama", 40).PHP_EOL);
            $printer -> text(str_pad("Kontrol : $kontrol", 40).PHP_EOL);
            $printer -> text(str_pad("Los     : $no_los", 40).PHP_EOL);
            if($data->info){
                $printer -> text(str_pad("Info    : $info", 40).PHP_EOL);
            }
            $printer -> text(str_pad("Kode    : $data->code", 40).PHP_EOL);
            $printer -> setEmphasis(false);
            $printer -> feed();
            $printer -> setFont(Printer::FONT_B);
            //End Header
            $i = 1;

            //Content
            if($data->listrik){
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setEmphasis(true);
                $printer -> text("LISTRIK                                 ");
                $printer -> setEmphasis(false);
                $printer -> feed();
                $printer -> textRaw(str_repeat(chr(196), 40).PHP_EOL);
                $denda = 0;
                foreach ($data->listrik as $j => $val) {
                    $denda += $val->denda;
                    $printer -> text(new Receipt70mm("$i. $val->bulan",number_format($val->tagihan - $val->denda, 0, '', '.')));

                    if ($j === array_key_last($data->listrik)) {
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text(new Receipt70mm("Daya",number_format($val->daya, 0, '', '.'),false));
                        $printer -> text(new Receipt70mm("Awal",number_format($val->awal, 0, '', '.'),false));
                        $printer -> text(new Receipt70mm("Akhir",number_format($val->akhir, 0, '', '.'),false));
                        $printer -> text(new Receipt70mm("Pakai",number_format($val->pakai, 0, '', '.'),false));
                    }

                    $i++;
                }

                if($denda > 0){
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text(new Receipt70mm("$i. Denda",number_format($denda, 0, '', '.')));
                    $i++;
                }

                $printer -> feed();
            }


            if($data->airbersih){
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setEmphasis(true);
                $printer -> text("AIR BERSIH                              ");
                $printer -> setEmphasis(false);
                $printer -> feed();
                $printer -> textRaw(str_repeat(chr(196), 40).PHP_EOL);
                $denda = 0;
                foreach ($data->airbersih as $j => $val) {
                    $denda += $val->denda;
                    $printer -> text(new Receipt70mm("$i. $val->bulan",number_format($val->tagihan - $val->denda, 0, '', '.')));

                    if ($j === array_key_last($data->airbersih)) {
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text(new Receipt70mm("Awal",number_format($val->awal, 0, '', '.'),false));
                        $printer -> text(new Receipt70mm("Akhir",number_format($val->akhir, 0, '', '.'),false));
                        $printer -> text(new Receipt70mm("Pakai",number_format($val->pakai, 0, '', '.'),false));
                    }

                    $i++;
                }

                if($denda > 0){
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text(new Receipt70mm("$i. Denda",number_format($denda, 0, '', '.')));
                    $i++;
                }

                $printer -> feed();
            }

            if($data->keamananipk){
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setEmphasis(true);
                $printer -> text("KEAMANAN IPK                            ");
                $printer -> setEmphasis(false);
                $printer -> feed();
                $printer -> textRaw(str_repeat(chr(196), 40).PHP_EOL);
                foreach ($data->keamananipk as $j => $val) {
                    $printer -> text(new Receipt70mm("$i. $val->bulan",number_format($val->tagihan, 0, '', '.')));
                    $i++;
                }
                $printer -> feed();
            }

            if($data->kebersihan){
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setEmphasis(true);
                $printer -> text("KEBERSIHAN                              ");
                $printer -> setEmphasis(false);
                $printer -> feed();
                $printer -> textRaw(str_repeat(chr(196), 40).PHP_EOL);
                foreach ($data->kebersihan as $j => $val) {
                    $printer -> text(new Receipt70mm("$i. $val->bulan",number_format($val->tagihan, 0, '', '.')));
                    $i++;
                }
                $printer -> feed();
            }

            if($data->airkotor){
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setEmphasis(true);
                $printer -> text("AIR KOTOR                               ");
                $printer -> setEmphasis(false);
                $printer -> feed();
                $printer -> textRaw(str_repeat(chr(196), 40).PHP_EOL);
                foreach ($data->airkotor as $j => $val) {
                    $printer -> text(new Receipt70mm("$i. $val->bulan",number_format($val->tagihan, 0, '', '.')));
                    $i++;
                }
                $printer -> feed();
            }

            if($data->lain){
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> setEmphasis(true);
                $printer -> text("LAINNYA                                 ");
                $printer -> setEmphasis(false);
                $printer -> feed();
                $printer -> textRaw(str_repeat(chr(196), 40).PHP_EOL);
                foreach ($data->lain as $j => $val) {
                    $printer -> text(new Receipt70mm("$i. $val->bulan",number_format($val->tagihan, 0, '', '.')));
                    $i++;
                }
                $printer -> feed();
            }
            //End Content

            //Footer
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer -> text(new Receipt70mm("Total",number_format($data->tagihan, 0, '', '.'),true,true));
            $printer -> selectPrintMode();
            $printer -> setFont(Printer::FONT_B);
            $printer -> text(str_repeat('-', 40).PHP_EOL);
            $printer -> text("Nomor : $data->faktur".PHP_EOL);
            $printer -> text("Dibayar pada $data->bayar".PHP_EOL);
            $printer -> text("Harap simpan tanda terima ini".PHP_EOL."sebagai bukti pembayaran yang sah.".PHP_EOL."Terimakasih.".PHP_EOL."Pembayaran sudah termasuk PPN".PHP_EOL);

            if($type == 'reprint'){
                $income = Income::find($id);
                $cetak = $income->cetak + 1;
                $income->update([
                    'cetak' => $cetak
                ]);
                $printer -> text("Duplikasi ke-$cetak".PHP_EOL);
            }

            $printer -> text("Ksr : $kasir".PHP_EOL);
            $printer -> text("https://picbdg.com".PHP_EOL);
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

            //Review Ulang
            Payment::syncByKontrol($kontrol);
            //End Review Ulang

            $data->delete();

            return response()->json(['success' => 'Data restored.']);
        }
    }
}
