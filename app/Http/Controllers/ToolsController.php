<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\TListrik;
use App\Models\TAirBersih;

use DataTables;
use Carbon\Carbon;

class ToolsController extends Controller
{
    public function listrik(){
        if(request()->ajax()){
            $data = TListrik::select('id','code','name');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.tools.listrik.index');
    }

    public function listrikStore(Request $request){
        if($request->ajax()){
            //

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function listrikEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = TListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            //

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function listrikUpdate(Request $request, $id){
        if($request->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            try{
                $data = TListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            //

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function listrikShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = TListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            //

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function listrikDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = TListrik::findOrFail($decrypted);
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
