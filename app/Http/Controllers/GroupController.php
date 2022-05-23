<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

use App\Models\Group;
use App\Exports\GroupExport;

use Carbon\Carbon;

use Excel;
use DataTables;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Group::select('id', 'name', 'nicename', 'data');

            if(Session::get('level') != 1){
                $json = json_decode(Auth::user()->otoritas);
                $data = Group::select('id', 'name', 'nicename', 'data')
                ->whereIn('name', $json->groups);
            }

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->addColumn('jum_los', function($data){
                if($data->data){
                    return count(json_decode($data->data));
                }
                return 0;
            })
            ->filterColumn('name', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(name, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('Services.Group.index');
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
            //Validator
            $input['nama_grup']  = strtoupper($request->tambah_name);
            $input['nicename']   = str_replace('-', '', $input['nama_grup']);
            $input['alamat_los'] = $request->tambah_los;

            Validator::make($input, [
                'nama_grup'  => 'required|string|max:10|unique:groups,name',
                'alamat_los' => 'nullable|string',
            ])->validate();
            //End Validator

            $los = $input['alamat_los'];

            if($los){
                $los = $los;
                $los = rtrim($input['alamat_los'], ',');
                $los = ltrim($los, ',');
                $los = explode(',', strtoupper($los));
                $los = array_unique($los);
                sort($los);
                $los = json_encode($los);
            }

            Group::create([
                'name'     => $input['nama_grup'],
                'nicename' => $input['nicename'],
                'data'     => $los
            ]);

            return response()->json(['success' => 'Data berhasil disimpan.', 'debug' => $los]);
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
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = Group::findOrFail($decrypted);

            $count = 0;
            $los = '';

            if($data->data){
                $count = count(json_decode($data->data));
                $los = json_decode($data->data);
                $los = implode(', ', $los);
                $los = rtrim($los, ', ');
            }

            $data['los'] = $los;
            $data['count'] = $count;

            return response()->json(['success' => $data]);
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
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = Group::findOrFail($decrypted);

            $los = '';

            if($data->data){
                $los = json_decode($data->data);
            }

            $data['los'] = implode(',', $los);

            return response()->json(['success' => $data]);
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
            //Validator
            $input['nama_grup']  = strtoupper($request->edit_name);
            $input['nicename']   = str_replace('-', '', $input['nama_grup']);
            $input['alamat_los'] = $request->edit_los;

            Validator::make($input, [
                'nama_grup'  => 'required|string|max:10|unique:groups,name,'.$id,
                'alamat_los' => 'nullable|string',
            ])->validate();
            //End Validator

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = Group::findOrFail($decrypted);

            $los = $input['alamat_los'];

            if($los){
                $los = $los;
                $los = rtrim($input['alamat_los'], ',');
                $los = ltrim($los, ',');
                $los = explode(',', strtoupper($los));
                $los = array_unique($los);
                sort($los);
                $los = json_encode($los);
            }

            $data->update([
                'name'     => $input['nama_grup'],
                'nicename' => $input['nicename'],
                'data'     => $los,
            ]);

            return response()->json(['success' => 'Data berhasil disimpan.']);
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
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = Group::findOrFail($decrypted);

            $data->delete();

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }
}
