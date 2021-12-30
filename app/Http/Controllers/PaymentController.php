<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Bill;
use App\Models\Group;
use App\Models\Payment;

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
            $data = Payment::select('id', 'kd_kontrol', 'nicename','pengguna', 'ids_tagihan', 'tagihan');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<button nama="'.$data->kd_kontrol.'" id="'.Crypt::encrypt($data->id).'" class="btn btn-sm btn-rounded btn-success bayar">Bayar</button>';
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
            ->editColumn('tagihan', function($data){
                return number_format($data->tagihan, 0, '', '.');
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'pengguna'])
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
        //
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

                if($bill->b_listrik){
                    $bill_listrik = json_decode($bill->b_listrik);
                    if($bill_listrik->lunas == 0){
                        $listrik[] = [
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
