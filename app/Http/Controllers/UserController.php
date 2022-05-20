<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;
use App\Exports\UserExport;

use Carbon\Carbon;

use Excel;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()){
            $level = $request->level;
            $status = $request->status;

            if(is_numeric($level)){
                $level = ['level', $level];
            } else {
                $level = ['level', '<', 6];
            }

            $data = User::select('id', 'username', 'name', 'level', 'status')
            ->where([
                $level,
                ['status', $status],
                ['id', '!=', Auth::id()]
            ]);

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                if(Auth::user()->level == 1){
                    if($data->status == 1){
                        $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Hapus" status="1" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="reset btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-key-skeleton"></i></a>';
                    } else {
                        $button .= '<a type="button" data-toggle="tooltip" title="Aktifkan" status="0" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-check"></i></a>';
                    }
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->editColumn('username', function($data){
                $name = $data->username;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='$data->username'>$name</span>";
            })
            ->editColumn('name', function($data){
                $name = $data->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='$data->name'>$name</span>";
            })
            ->editColumn('level', function($data){
                $badge = User::badgeLevel($data->level);
                $button = '<span class="badge badge-md '. $badge . '">' . User::level($data->level) . '</span>';
                return $button;
            })
            ->rawColumns(['action', 'username', 'name', 'level'])
            ->make(true);
        }
        return view('Users.index');
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
            $input['username'] = strtolower($request->tambah_username);
            $input['nama']     = $request->tambah_name;
            $input['level']    = $request->tambah_level;

            Validator::make($input, [
                'username' => 'required|string|max:100|unique:users,username',
                'nama'     => 'required|string|max:100',
                'level'    => 'required|numeric|digits_between:1,5',
            ])->validate();
            //End Validator

            $otoritas = NULL;

            if($input['level'] == 2){
                $groups  = array();
                $choosed = array();

                if($request->groups){
                    foreach ($request->groups as $g) {
                        $groups[]  = Crypt::decrypt($g);
                    }
                }

                if($request->choosed){
                    foreach ($request->choosed as $c) {
                        $choosed[] = Crypt::decrypt($c);
                    }
                }

                $otoritas = json_encode([
                    'groups'  => $groups,
                    'choosed' => $choosed
                ]);
            }

            User::insert([
                'username' => $input['username'],
                'name'     => $input['nama'],
                'password' => Hash::make(sha1(md5(hash('gost', '123456')))),
                'level'    => $input['level'],
                'otoritas' => $otoritas,
                'status'   => 1
            ]);

            return response()->json(['success' => 'Data berhasil ditambah.', 'debug' => $input['level']]);
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

            try {
                $data = User::findOrFail($decrypted);
            } catch(ModelNotFoundException $err) {
                return response()->json(['error' => "Data lost."]);
            }

            $data['level'] = User::level($data->level);

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

            try {
                $data = User::findOrFail($decrypted);
            } catch(ModelNotFoundException $err) {
                return response()->json(['error' => "Data lost."]);
            }

            if($data->otoritas){
                $data['otoritas'] = json_decode($data->otoritas);
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
            $input['nama']  = $request->edit_name;
            $input['level'] = $request->edit_level;

            Validator::make($input, [
                'nama'     => 'required|string|max:100',
                'level'    => 'required|numeric|digits_between:1,5',
            ])->validate();
            //End Validator

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            try {
                $data = User::findOrFail($decrypted);
            } catch(ModelNotFoundException $err) {
                return response()->json(['error' => "Data lost."]);
            }

            $otoritas = NULL;

            if($input['level'] == 2){
                $groups  = array();
                $choosed = array();

                if($request->groups){
                    foreach ($request->groups as $g) {
                        $groups[]  = Crypt::decrypt($g);
                    }
                }

                if($request->choosed){
                    foreach ($request->choosed as $c) {
                        $choosed[] = Crypt::decrypt($c);
                    }
                }

                $otoritas = json_encode([
                    'groups'  => $groups,
                    'choosed' => $choosed
                ]);
            }

            $data->update([
                'name'     => $input['nama'],
                'level'    => $input['level'],
                'otoritas' => $otoritas
            ]);

            return response()->json(['success' => "Data berhasil disimpan."]);
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

            try {
                $data = User::findOrFail($decrypted);
            } catch(ModelNotFoundException $err) {
                return response()->json(['error' => "Data lost."]);
            }

            if($data->status == 1){
                $data->status = 0;
            } else {
                $data->status = 1;
            }

            $data->save();

            return response()->json(['success' => "Status pengguna berhasil diubah."]);
        }
    }

    public function reset($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            try {
                $data = User::findOrFail($decrypted);
            } catch(ModelNotFoundException $err) {
                return response()->json(['error' => "Data lost."]);
            }

            $data->password = Hash::make(sha1(md5(hash('gost', '123456'))));

            $data->save();

            return response()->json(['success' => 'Password direset = <b>123456</b>.']);
        }
    }

    public function print(Request $request){
        //Validator
        $input['level']  = $request->level;
        $input['status']  = $request->status;

        Validator::make($input, [
            'level'    => 'required|in:1,2,3,4,5,all',
            'status'   => 'required|in:0,1,all',
        ])->validate();
        //End Validator

        if(is_numeric($input['level']) && is_numeric($input['status'])){
            $dataset = User::where([['level', $input['level']], ['status', $input['status']]])->get();
        }
        else if(is_numeric($input['level'])){
            $dataset = User::where('level', $input['level'])->get();
        }
        else if(is_numeric($input['status'])){
            $dataset = User::where('status', $input['status'])->get();
        }
        else {
            $dataset = User::get();
        }

        return view('Users.Pages._print', [
            'level'   => User::level($input['level']),
            'status'  => User::status($input['status']),
            'dataset' => $dataset
        ]);
    }

    public function excel(Request $request){
        //Validator
        $input['level']  = $request->level;
        $input['status']  = $request->status;

        Validator::make($input, [
            'level'    => 'required|in:1,2,3,4,5,all',
            'status'   => 'required|in:0,1,all',
        ])->validate();
        //End Validator

        $level  = User::level($input['level']);
        $status = User::status($input['status']);

        return Excel::download(new UserExport($input['level'], $input['status']), 'Data_Pengguna_('. $level . '-' . $status . ')_' . Carbon::now() . '.xlsx');
    }
}
