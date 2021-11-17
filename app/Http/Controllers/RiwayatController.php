<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\LoginData;
use App\Models\User;

use Carbon\Carbon;

use DataTables;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = LoginData::select('id','username','nama','level','stt_aktif','platform','status','updated_at','created_at');
            return DataTables::of($data)
            ->editColumn('created_at', function ($data) {
                return [
                    'display' => $data->created_at->format('d-m-Y H:i:s'),
                    'timestamp' => $data->created_at->timestamp
                ];
            })
            ->editColumn('level', function ($data){
                return User::level($data->level);
            })
            ->editColumn('status', function ($data){
                if($data->status == 0){
                    return '<span class="text-danger">Unaccessed</span>';
                }
                else{
                    return '<span class="text-success">Accessed</span>';
                }
            })
            ->addColumn('show', function($data){
                $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->nama.'" class="details btn btn-sm btn-info">Show</button>';
                return $button;
            })
            ->rawColumns(['show','status'])
            ->make(true);
        }
        return view('portal.riwayat.index');
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
        if(request()->ajax()){
            try {
                $id = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            try{
                $data = LoginData::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            $data['level'] = User::level($data->level);
            $data['stt_aktif'] = User::sttAktif($data->stt_aktif);
            $data['time'] = Carbon::parse($data->created_at)->toDateTimeString();

            if($data->status == 0){
                $data['status'] = '<span class="text-danger">Unaccessed</span>';
            }
            else{
                $data['status'] = '<span class="text-success">Accessed</span>';
            }

            return response()->json(['success' => 'Berhasil mengambil data.', 'user' => $data]);
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
}
