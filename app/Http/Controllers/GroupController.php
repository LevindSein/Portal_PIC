<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Group;
use App\Models\Store;

use DataTables;
use Carbon\Carbon;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Group::select('id','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->name.'" class="edit pointera"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->name.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.point.group.index');
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
                'blok' => 'required|max:10|alpha_dash|unique:App\Models\Group,name',
                'los' => 'nullable',
            ]);

            $group = strtoupper($request->blok);
            $los = null;
            if(!is_null($request->los)){
                $los = rtrim(strtoupper($request->los), ',');
                $los = explode(',', $los);
                $los = array_unique($los);
                natsort($los);
                $los = implode(',', $los);
            }

            $dataset['name'] = $group;
            $json = json_encode([
                'data' => $los,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['data'] = $json;

            try{
                Group::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->blok;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
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
            try{
                $data = Group::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            if(!is_null($data->data)){
                $json = json_decode($data->data);

                $count = 0;
                $long_data = '';
                if(!is_null($json->data)){
                    $explode = explode(',', $json->data);
                    $count = count($explode);
                    $long_data = implode(', ', $explode);
                    $long_data = rtrim($long_data, ', ');
                }

                $data['los'] = $json;
                $data['long'] = $long_data;
                $data['count'] = $count;
            }
            else
                $data['los'] = null;

            return response()->json(['success' => 'Fetching data success.', 'group' => $data]);
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
            try{
                $data = Group::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            if(!is_null($data->data)){
                $json = json_decode($data->data);

                $data['los'] = $json;
            }
            else
                $data['los'] = null;

            return response()->json(['success' => 'Fetching data success.', 'group' => $data]);
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
            $request->validate([
                'blok' => 'required|max:10|alpha_dash|unique:App\Models\Group,name,'.$id,
                'los' => 'nullable',
            ]);

            try{
                $data = Group::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $groupOld = $data->name;
            $group = strtoupper($request->blok);

            $los = null;
            if(!is_null($request->los)){
                $los = rtrim(strtoupper($request->los), ',');
                $los = explode(',', $los);
                $los = array_unique($los);
                natsort($los);
                $los = implode(',', $los);
            }

            $data->name = $group;
            if(!is_null($data->data)){
                $json = json_decode($data->data);
                $json->data = $los;
                $json->user_update = Auth::user()->id;
                $json->username_update = Auth::user()->name;
                $json->updated_at = Carbon::now()->toDateTimeString();
                $data->data = json_encode($json);
            }
            else{
                $json = json_encode([
                    'data' => $los,
                    'user_create' => Auth::user()->id,
                    'username_create' => Auth::user()->name,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'user_update' => Auth::user()->id,
                    'username_update' => Auth::user()->name,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                $data->data = $json;
            }

            // Mempengaruhi Data Tempat
            $stores = Store::where('group', $groupOld)->select('id','group', 'kd_kontrol', 'nicename')->get();
            $i = 0;
            foreach ($stores as $store) {
                $store->group = $group;
                $store->kd_kontrol = preg_replace('/'.$groupOld.'/i', $group, $store->kd_kontrol);
                $store->nicename = str_replace('-', '', $store->kd_kontrol);

                try{
                    $store->save();
                } catch(\Exception $e){
                    return response()->json(['error' => "Data failed to save.", 'description' => $e]);
                }

                $i++;
            }
            // End Data Tempat

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            $searchKey = $group;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey, 'info' => $i . " Data Tempat terpengaruh."]);
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
            try{
                $data = Group::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            if(!is_null(Store::where('group', $data->name)->first())){
                return response()->json(['error' => "Group currently use."]);
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
