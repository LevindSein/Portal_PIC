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
use App\Models\Tagihan;
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
                if(!Group::find($data->id)->tempat()->exists() || !Group::find($data->id)->tagihan()->exists()){
                    $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->filterColumn('name', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(name, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('MasterData.Group.index');
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

            Validator::make($input, [
                'blok'       => 'required|max:10|alpha',
                'nomor'      => 'required|max:10|alpha_num',
                'nama_grup'  => 'required|string|max:10|unique:groups,name'
            ])->validate();
            //End Validator

            DB::transaction(function() use ($input){
                Group::create([
                    'name'      => $input['nama_grup'],
                    'nicename'  => $input['nicename'],
                    'blok'      => $input['blok'],
                    'nomor'     => $input['nomor']
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

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            Validator::make($input, [
                'blok'       => 'required|max:10|alpha',
                'nomor'      => 'required|max:10|alpha_num',
                'nama_grup'  => 'required|string|max:10|unique:groups,name,'.$decrypted
            ])->validate();
            //End Validator

            DB::transaction(function() use ($input, $decrypted){
                $data = Group::lockForUpdate()->findOrFail($decrypted);

                $groupOld = $data->name;

                $data->update([
                    'name'     => $input['nama_grup'],
                    'nicename' => $input['nicename'],
                    'blok'     => $input['blok'],
                    'nomor'    => $input['nomor']
                ]);

                if($groupOld != $input['nama_grup']){
                    //Perubahan Nama Grup mempengaruhi Tempat
                    Tempat::where('group_id', $decrypted)->chunk(100, function ($tempat) use ($groupOld, $input) {
                        foreach ($tempat as $d) {
                            $d->name = preg_replace('/'.$groupOld.'/i', $input['nama_grup'], $d->name);
                            $d->nicename = str_replace('-', '', $d->name);
                            $d->save();
                        }
                    });

                    //Perubahan Nama Grup mempengaruhi Tagihan
                    Tagihan::where('group_id', $decrypted)->chunk(100, function ($tagihan) use ($groupOld, $input) {
                        foreach ($tagihan as $d) {
                            $d->name = preg_replace('/'.$groupOld.'/i', $input['nama_grup'], $d->name);
                            $d->nicename = str_replace('-', '', $d->name);
                            $d->save();
                        }
                    });
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

        return view('MasterData.Group.Pages._print', [
            'data' => $data
        ]);
    }

    public function excel(){
        return Excel::download(new GroupExport, 'Data_Grup_Tempat_' . Carbon::now() . '.xlsx');
    }
}
