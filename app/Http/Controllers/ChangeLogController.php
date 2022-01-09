<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
            $data = ChangeLog::select('id','release_date','release_str','data');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                if(Auth::user()->level == 1){
                    $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="delete" id="'.$data->id.'" class="delete"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                }
                else{
                    $button = '<button title="Show Details" name="show" id="'.$data->id.'" class="details btn btn-sm btn-info">Show</button>';
                }
                return $button;
            })
            ->editColumn('data', function($data){
                $data = json_decode($data->data);
                $name = $data->title;
                if(strlen($name) > 30) {
                    $name = substr($name, 0, 26);
                    $name = str_pad($name,  30, ".");
                    return "<span data-toggle='tooltip' title='$data->title'>$name</span>";
                }
                else{
                    return $name;
                }
            })
            ->filterColumn('release_str', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(release_str, release_date) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'data'])
            ->make(true);
        }
        Session::put('lastPlace', 'changelogs');
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
            $release = Carbon::parse($request->release)->format('d-m-Y H:i:s');
            $valid['release'] = $release;
            Validator::make($valid, [
                'release' => 'required|date_format:d-m-Y H:i:s',
            ])->validate();

            $request->validate([
                'title' => 'required|max:100',
                'data' => 'required',
            ]);

            $title = $request->title;
            $data = $request->data;

            $json = json_encode([
                'title' => $title,
                'data' => $data,
                'created_by_id' => Auth::user()->id,
                'created_by_name' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_by_id' => Auth::user()->id,
                'updated_by_name' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['release_date'] = $release;
            $dataset['release_str'] = strtotime($release);
            $dataset['data'] = $json;

            try{
                Changelog::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $release;

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
                $data = ChangeLog::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $release = $data->release_date;
            $data = json_decode($data->data);
            $data->release = $release;

            return response()->json(['success' => 'Fetching data success.', 'changelog' => $data]);
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
                $data = ChangeLog::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $date = Carbon::parse($data->release_date)->format('Y-m-d');
            $time = Carbon::parse($data->release_date)->format('H:i:s');
            $release = $date.'T'.$time;
            $data = json_decode($data->data);
            $data->release = $release;

            return response()->json(['success' => 'Data deleted.', 'changelog' => $data, 'description' => $release]);
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
            $release = Carbon::parse($request->release)->format('d-m-Y H:i:s');
            $valid['release'] = $release;
            Validator::make($valid, [
                'release' => 'required|date_format:d-m-Y H:i:s',
            ])->validate();

            $request->validate([
                'title' => 'required|max:100',
                'data' => 'required',
            ]);

            try{
                $dataset = ChangeLog::findOrFail($id);
            } catch(ModelNotFoundException $e){
                return response()->json(['error' => "Data not found.", 'description' => $e]);
            }

            $json = json_decode($dataset->data);
            $json->title = $request->title;
            $json->data = $request->data;
            $json->updated_by_id = Auth::user()->id;
            $json->updated_by_name = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $data = json_encode($json);

            $dataset->release_date = $release;
            $dataset->release_str = strtotime($release);
            $dataset->data = $data;

            try{
                $dataset->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            $searchKey = $release;

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
                $data = ChangeLog::findOrFail($id);
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
