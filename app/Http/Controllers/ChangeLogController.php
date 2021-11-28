<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\ChangeLog;

use DataTables;
use Carbon\Carbon;

class ChangeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = ChangeLog::select('id','data','updated_at');
            return DataTables::of($data)
                ->editColumn('updated_at', function ($data) {
                    return [
                        'display' => $data->updated_at->format('d-m-Y H:i:s'),
                        'timestamp' => $data->updated_at->timestamp
                    ];
                })
                ->addColumn('action', function($data){
                    $button = '';
                    if(Auth::user()->level == 1){
                        $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" class="details"><i class="fas fa-eye" style="color:#36bea6;"></i></a>';
                    }
                    else{
                        $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" class="details btn btn-sm btn-info">Show</button>';
                    }
                    return $button;
                })
                ->editColumn('data', function($data){
                    $data = json_decode($data->data);
                    return "<b>$data->title</b>";
                })
                ->rawColumns(['action', 'data'])
                ->make(true);
        }
        return view('portal.changelog.index');
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
                'title' => 'required',
                'data' => 'required',
            ]);

            $title = $request->title;
            $data = $request->data;

            $json = json_encode([
                'title' => $title,
                'data' => $data,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['data'] = $json;

            try{
                Changelog::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
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
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            try{
                $data = ChangeLog::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'changelog' => $data]);
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
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = ChangeLog::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data = json_decode($data->data);

            return response()->json(['success' => 'Data deleted.', 'changelog' => $data]);
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
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            $request->validate([
                'title' => 'required',
                'data' => 'required',
            ]);

            try{
                $dataset = ChangeLog::findOrFail($decrypted);
            } catch(ModelNotFoundException $e){
                return response()->json(['error' => "Data not found.", 'description' => $e]);
            }

            $data = json_decode($dataset->data);
            $data->title = $request->title;
            $data->data = $request->data;
            $data->user_update = Auth::user()->id;
            $data->username_update = Auth::user()->name;
            $data->updated_at = Carbon::now()->toDateTimeString();

            $data = json_encode($data);

            $dataset->data = $data;
            $dataset->save();

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
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
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = ChangeLog::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data->delete();

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }
}
