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

            $data['ttl_tagihan'] = "Rp. " . number_format($data->tagihan, 0, '', '.');

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
    }
}
