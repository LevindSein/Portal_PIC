<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Commodity;

use DataTables;
use Carbon\Carbon;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Commodity::select('id','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->editColumn('name', function($data){
                return substr($data->name,0,30);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.point.commodity.index');
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
                'name' => 'required|max:100',
            ]);

            $name = $request->name;

            $json = json_encode([
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['name'] = $name;
            $dataset['data'] = $json;

            try{
                Commodity::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = substr($name, 0, 10);

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
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
                $data = Commodity::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
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
                $data = Commodity::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
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
                'name' => 'required|max:100',
            ]);

            try{
                $dataset = Commodity::findOrFail($id);
            } catch(ModelNotFoundException $e){
                return response()->json(['error' => "Data not found.", 'description' => $e]);
            }

            $data = json_decode($dataset->data);
            $data->user_update = Auth::user()->id;
            $data->username_update = Auth::user()->name;
            $data->updated_at = Carbon::now()->toDateTimeString();

            $data = json_encode($data);

            $dataset->name = $request->name;
            $dataset->data = $data;

            try{
                $dataset->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            $searchKey = substr($request->name, 0, 10);

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
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
                $data = Commodity::findOrFail($id);
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
    }
}
