<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\TListrik;
use App\Models\TAirBersih;
use App\Models\Identity;
use App\Models\Store;

use DataTables;
use Carbon\Carbon;

class ToolsController extends Controller
{
    public function listrik(){
        if(request()->ajax()){
            $data = TListrik::select('id','code','name','power','meter','stt_available');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->code.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="delete" id="'.$data->id.'" nama="'.$data->code.'" class="delete"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->code.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('code', function($data){
                if($data->stt_available == 1){
                    $color = 'text-success';
                }
                else{
                    $color = 'text-danger';
                }
                return "<span class='$color'>$data->code</span>";
            })
            ->editColumn('power', function($data){
                return number_format($data->power,0,'','.');
            })
            ->editColumn('meter', function($data){
                return number_format($data->meter,0,'','.');
            })
            ->rawColumns(['action', 'code'])
            ->make(true);
        }
        Session::put('lastPlace', 'point/tools/listrik');
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

            $json = json_encode([
                'created_by_id' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_by_id' => Auth::user()->id,
                'updated_by_name' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            $code = Identity::listrikCode();

            $dataset['code'] = $code;
            $dataset['name'] = strtoupper($request->name);
            $dataset['power'] = str_replace('.','',$request->power);
            $dataset['meter'] = str_replace('.','',$request->meter);
            $dataset['stt_available'] = 1;
            $dataset['data'] = $json;

            try{
                TListrik::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $code;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
    }

    public function listrikEdit($id){
        if(request()->ajax()){
            try{
                $data = TListrik::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
    }

    public function listrikUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['power'] = str_replace('.','',$request->power);
            $data['meter'] = str_replace('.','',$request->meter);

            Validator::make($data, [
                'name' => 'required|max:30|unique:App\Models\TListrik,name,'.$id,
                'power' => 'required|numeric|lte:999999999',
                'meter' => 'required|numeric|lte:999999999',
            ])->validate();

            try{
                $data = TListrik::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->updated_by_id = Auth::user()->id;
            $json->updated_by_name = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->name = strtoupper($request->name);
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
    }

    public function listrikShow($id){
        if(request()->ajax()){
            try{
                $data = TListrik::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $kontrol = Store::where('id_tlistrik', $id)->select('kd_kontrol')->first();
            if($kontrol){
                $data['kontrol'] = $kontrol->kd_kontrol;
            }
            else{
                $data['kontrol'] = '';
            }

            $json = json_decode($data->data);
            $data['data'] = $json;

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
    }

    public function listrikDestroy($id){
        if(request()->ajax()){
            try{
                $data = TListrik::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            if($data->stt_available == 0){
                return response()->json(['error' => "Tools currently use."]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
    }

    public function airbersih(){
        if(request()->ajax()){
            $data = TAirBersih::select('id','code','name','meter','stt_available');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->code.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="delete" id="'.$data->id.'" nama="'.$data->code.'" class="delete"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->code.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('meter', function($data){
                return number_format($data->meter,0,'','.');
            })
            ->editColumn('code', function($data){
                if($data->stt_available == 1){
                    $color = 'text-success';
                }
                else{
                    $color = 'text-danger';
                }
                return "<span class='$color'>$data->code</span>";
            })
            ->rawColumns(['action', 'code'])
            ->make(true);
        }
        Session::put('lastPlace', 'point/tools/airbersih');
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

            $json = json_encode([
                'created_by_id' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_by_id' => Auth::user()->id,
                'updated_by_name' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            $code = Identity::airbersihCode();

            $dataset['code'] = $code;
            $dataset['name'] = strtoupper($request->name);
            $dataset['meter'] = str_replace('.','',$request->meter);
            $dataset['stt_available'] = 1;
            $dataset['data'] = $json;

            try{
                TAirBersih::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $code;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
    }

    public function airbersihEdit($id){
        if(request()->ajax()){
            try{
                $data = TAirBersih::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
    }

    public function airbersihUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['meter'] = str_replace('.','',$request->meter);

            Validator::make($data, [
                'name' => 'required|max:30|unique:App\Models\TAirBersih,name,'.$id,
                'meter' => 'required|numeric|lte:999999999',
            ])->validate();

            try{
                $data = TAirBersih::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->updated_by_id = Auth::user()->id;
            $json->updated_by_name = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->name = strtoupper($request->name);
            $data->meter = str_replace('.','',$request->meter);
            $data->data = $json;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
    }

    public function airbersihShow($id){
        if(request()->ajax()){
            try{
                $data = TAirBersih::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $kontrol = Store::where('id_tairbersih', $id)->select('kd_kontrol')->first();
            if($kontrol){
                $data['kontrol'] = $kontrol->kd_kontrol;
            }
            else{
                $data['kontrol'] = '';
            }

            $json = json_decode($data->data);
            $data['data'] = $json;

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
    }

    public function airbersihDestroy($id){
        if(request()->ajax()){
            try{
                $data = TAirBersih::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            if($data->stt_available == 0){
                return response()->json(['error' => "Tools currently use."]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
    }
}
