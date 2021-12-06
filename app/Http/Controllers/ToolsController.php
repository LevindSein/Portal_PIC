<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\TListrik;
use App\Models\TAirBersih;
use App\Models\Identity;

use DataTables;
use Carbon\Carbon;

class ToolsController extends Controller
{
    public function listrik(){
        if(request()->ajax()){
            $data = TListrik::select('id','code','name','power','meter');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('power', function($data){
                return number_format($data->power);
            })
            ->editColumn('meter', function($data){
                return number_format($data->meter);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.point.tools.listrik.index');
    }

    public function listrikStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['power'] = str_replace('.','',$request->power);
            $data['meter'] = str_replace('.','',$request->meter);

            Validator::make($data, [
                'name' => 'required|max:30|unique:App\Models\TListrik,name',
                'power' => 'required|numeric|lte:999999999',
                'meter' => 'required|numeric|lte:999999999',
            ])->validate();

            $code = Identity::listrikCode();
            $json = json_encode([
                'stt_available' => 1,
                'stt_paid' => 0,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['code'] = $code;
            $dataset['name'] = $request->name;
            $dataset['power'] = str_replace('.','',$request->power);
            $dataset['meter'] = str_replace('.','',$request->meter);
            $dataset['data'] = $json;

            try{
                TListrik::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $code;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
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

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
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

            $data = $request->all();
            $data['power'] = str_replace('.','',$request->power);
            $data['meter'] = str_replace('.','',$request->meter);

            Validator::make($data, [
                'name' => 'required|max:30|unique:App\Models\TListrik,name,'.$decrypted,
                'power' => 'required|numeric|lte:999999999',
                'meter' => 'required|numeric|lte:999999999',
            ])->validate();

            try{
                $data = TListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->name = $request->name;
            $data->power = str_replace('.','',$request->power);
            $data->meter = str_replace('.','',$request->meter);
            $data->data = $json;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

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

            $json = json_decode($data->data);
            $data['data'] = $json;

            $data['available'] = Identity::available($json->stt_available);
            $data['paid'] = Identity::paid($json->stt_paid);

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

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function airbersih(){
        if(request()->ajax()){
            $data = TAirBersih::select('id','code','name','meter');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('meter', function($data){
                return number_format($data->meter);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.point.tools.air-bersih.index');
    }

    public function airbersihStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['meter'] = str_replace('.','',$request->meter);

            Validator::make($data, [
                'name' => 'required|max:30|unique:App\Models\TAirBersih,name',
                'meter' => 'required|numeric|lte:999999999',
            ])->validate();

            $code = Identity::airbersihCode();
            $json = json_encode([
                'stt_available' => 1,
                'stt_paid' => 0,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['code'] = $code;
            $dataset['name'] = $request->name;
            $dataset['meter'] = str_replace('.','',$request->meter);
            $dataset['data'] = $json;

            try{
                TAirBersih::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $code;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function airbersihEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = TAirBersih::findOrFail($decrypted);
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

    public function airbersihUpdate(Request $request, $id){
        if($request->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            $data = $request->all();
            $data['meter'] = str_replace('.','',$request->meter);

            Validator::make($data, [
                'name' => 'required|max:30|unique:App\Models\TAirBersih,name,'.$decrypted,
                'meter' => 'required|numeric|lte:999999999',
            ])->validate();

            try{
                $data = TAirBersih::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->name = $request->name;
            $data->meter = str_replace('.','',$request->meter);
            $data->data = $json;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function airbersihShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = TAirBersih::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);
            $data['data'] = $json;

            $data['available'] = Identity::available($json->stt_available);
            $data['paid'] = Identity::paid($json->stt_paid);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function airbersihDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = TAirBersih::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }
}
