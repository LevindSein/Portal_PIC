<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Tempat;
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
    public function index()
    {
        if(request()->ajax()){
            $data = Group::orderBy('blok', 'asc')->orderByRaw('LENGTH(nicename), nicename')->orderBy('nomor', 'asc');

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
            $input['blok']       = strtoupper($request->tambah_blok);
            $input['nomor']      = strtoupper($request->tambah_nomor);
            $input['nama_grup']  = $input['blok'] . '-' . $input['nomor'];
            $input['nicename']   = str_replace('-', '', $input['nama_grup']);
            $input['alamat_los'] = $request->tambah_los;

            Validator::make($input, [
                'blok'       => 'required|max:10|alpha',
                'nomor'      => 'required|max:10|alpha_num',
                'nama_grup'  => 'required|string|max:10|unique:groups,name',
                'alamat_los' => 'nullable|string|regex:/^[a-zA-Z0-9\,]+$/',
            ])->validate();
            //End Validator

            $los = $input['alamat_los'];

            if($los){
                $los = $los;
                $los = rtrim($input['alamat_los'], ',');
                $los = ltrim($los, ',');
                $los = explode(',', strtoupper($los));
                $los = array_unique($los);
                sort($los, SORT_NATURAL);
                $los = json_encode($los);
            }

            DB::transaction(function() use ($input, $los){
                Group::create([
                    'name'      => $input['nama_grup'],
                    'nicename'  => $input['nicename'],
                    'blok'      => $input['blok'],
                    'nomor'     => $input['nomor'],
                    'data'      => $los,
                ]);
            });

            return response()->json(['success' => 'Data berhasil disimpan.']);
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
                $data['los'] = implode(',', $los);
            }

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
            $input['blok']       = strtoupper($request->edit_blok);
            $input['nomor']      = strtoupper($request->edit_nomor);
            $input['nama_grup']  = $input['blok'] . '-' . $input['nomor'];
            $input['nicename']   = str_replace('-', '', $input['nama_grup']);
            $input['alamat_los'] = $request->edit_los;

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            Validator::make($input, [
                'blok'       => 'required|max:10|alpha',
                'nomor'      => 'required|max:10|alpha_num',
                'nama_grup'  => 'required|string|max:10|unique:groups,name,'.$decrypted,
                'alamat_los' => 'nullable|string|regex:/^[a-zA-Z0-9\,]+$/',
            ])->validate();
            //End Validator

            DB::transaction(function() use ($input, $decrypted){
                $data = Group::lockForUpdate()->findOrFail($decrypted);

                $los = $input['alamat_los'];
                $groupOld = $data->name;

                if($los){
                    $los = $los;
                    $los = rtrim($input['alamat_los'], ',');
                    $los = ltrim($los, ',');
                    $los = explode(',', strtoupper($los));
                    $los = array_unique($los);
                    sort($los, SORT_NATURAL);
                    $los = json_encode($los);
                }

                $data->update([
                    'name'     => $input['nama_grup'],
                    'nicename' => $input['nicename'],
                    'blok'     => $input['blok'],
                    'nomor'    => $input['nomor'],
                    'data'     => $los
                ]);

                if($groupOld != $input['nama_grup']){
                    //Perubahan Nama Grup mempengaruhi Tempat
                    foreach(Tempat::where('group_id', $decrypted)->get() as $d){
                        $d->name = preg_replace('/'.$groupOld.'/i', $input['nama_grup'], $d->name);
                        $d->nicename = str_replace('-', '', $d->name);
                        $d->save();
                    }
                }
            });

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

            DB::transaction(function() use ($decrypted){
                $data = Group::lockForUpdate()->findOrFail($decrypted);

                $data->delete();
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }

    public function print(){
        $data = Group::orderBy('blok', 'asc')->orderByRaw('LENGTH(nicename), nicename')->orderBy('nomor', 'asc')->get();

        return view('Services.Group.Pages._print', [
            'data' => $data
        ]);
    }

    public function excel(){
        return Excel::download(new GroupExport, 'Data_Grup_Tempat_' . Carbon::now() . '.xlsx');
    }
}
