<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\DataLogin;
use App\Models\User;

use Carbon\Carbon;

use DataTables;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = DataLogin::select('id','uid','name','level','active','platform','status','updated_at','created_at');
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
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->rawColumns(['action','status'])
            ->make(true);
        }
        return view('portal.history.index');
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
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            try{
                $data = DataLogin::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['level'] = User::level($data->level);
            $data['active'] = User::active($data->active);
            $data['time'] = Carbon::parse($data->created_at)->toDateTimeString();

            if($data->status == 0){
                $data['status'] = '<span class="text-danger">Unaccessed</span>';
            }
            else{
                $data['status'] = '<span class="text-success">Accessed</span>';
            }

            return response()->json(['success' => 'Fetching data success.', 'user' => $data]);
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
