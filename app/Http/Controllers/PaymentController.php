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
            $data = Payment::select('id','kd_kontrol','nicename','pengguna','info','ids_tagihan','tagihan');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<button nama="'.$data->kd_kontrol.'" id="'.Crypt::encrypt($data->id).'" class="btn btn-sm btn-rounded btn-success bayar">Bayar</button>';
                return $button;
            })
            ->editColumn('kd_kontrol', function($data){
                if($data->info){
                    return "<span data-toggle='tooltip' title='$data->kd_kontrol : $data->info'>$data->kd_kontrol</span>";
                }
                else{
                    return "<span data-toggle='tooltip' title='$data->kd_kontrol'>$data->kd_kontrol</span>";
                }
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
            ->editColumn('tagihan', function($data){
                return number_format($data->tagihan, 0, '', '.');
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename, info) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'kd_kontrol', 'pengguna'])
            ->make(true);
        }
        Session::put('lastPlace', 'payment');
        return view('portal.payment.index');
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
                            foreach ($json as $i => $val) {
                                if($val->lunas == 0){
                                    $val->lunas = 1;
                                    $val->kasir = Auth::user()->name;
                                    $val->code = $code;
                                    $val->rea_tagihan += $val->sel_tagihan;
                                    $val->sel_tagihan = 0;
                                }
                            }
                            $bill->b_lain = json_encode($json);
                            $bill->save();
                        }
                    }
                }
            }

            try {
                $decrypted = Crypt::decrypt($request->paymentId);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Decryption payment failed.']);
            }

            $sync = Payment::find($decrypted);
            $sync = explode(',', $sync->ids_tagihan);
            foreach($sync as $s){
                Bill::syncById($s);
            }

            Payment::syncByKontrol($request->kontrol);

            Income::create([
                'code' => $code,
                'faktur' => $faktur,
                'id_period' => $period,
            ]);

            return response()->json(['success' => 'Payment successful']);
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
}
