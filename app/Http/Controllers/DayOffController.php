<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\DayOff;
use App\Models\IndoDate;

use DataTables;
use Carbon\Carbon;

class DayOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = DayOff::select('id','date','data');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->date.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.$data->date.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->date.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('data', function($data){
                return json_decode($data->data)->desc;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        Session::put('lastPlace', 'manage/dayoff');
        return view('portal.manage.day-off.index');
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
                'date' => 'required|date|unique:App\Models\DayOff,date',
                'desc' => 'required|max:255',
            ]);

            $dataset['date'] = $request->date;
            $json = json_encode([
                'desc' => $request->desc,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['data'] = $json;

            try{
                DayOff::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->date;

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
                $data = DayOff::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['date'] = IndoDate::tanggal($data->date, ' ');
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
                $data = DayOff::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
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
                'date' => 'required|date|unique:App\Models\DayOff,date,'.$id,
                'desc' => 'required|max:255',
            ]);

            try{
                $data = DayOff::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->desc = $request->desc;
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->data = $json;
            $data->date = $request->date;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            $searchKey = $request->date;

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
                $data = DayOff::findOrFail($id);
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
