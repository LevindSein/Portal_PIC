<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Group;

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
                $button = '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.group.index');
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
                'group' => 'required|max:10|alpha_dash|unique:App\Models\Group,name',
                'los' => 'nullable',
            ]);

            $group = strtoupper($request->group);
            $los = null;
            if(!is_null($request->los)){
                $los = rtrim(strtoupper($request->los), ',');
                $los = explode(',', $los);
                $los = array_unique($los);
                sort($los);
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
                $id = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

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
            try {
                $id = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

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
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            $request->validate([
                'group' => 'required|max:10|alpha_dash|unique:App\Models\Group,name,'.$decrypted,
                'los' => 'nullable',
            ]);

            $group = strtoupper($request->group);
            $los = null;
            if(!is_null($request->los)){
                $los = rtrim(strtoupper($request->los), ',');
                $los = explode(',', $los);
                $los = array_unique($los);
                sort($los);
                $los = implode(',', $los);
            }

            try{
                $data = Group::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
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

            $data->save();

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
                $data = Group::findOrFail($decrypted);
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
