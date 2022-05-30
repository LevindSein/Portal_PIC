<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Exports\UserExport;

use Carbon\Carbon;

use Excel;
use DataTables;

class PedagangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = User::where([['level',  6], ['status', $request->status]]);

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                if($data->status == 1){
                    $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                    $button .= '<a type="button" data-toggle="tooltip" title="Hapus" status="1" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                    $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="reset btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-key-skeleton"></i></a>';
                } else {
                    $button .= '<a type="button" data-toggle="tooltip" title="Aktifkan" status="0" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-check"></i></a>';
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->editColumn('name', function($data){
                $name = $data->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='$data->name'>$name</span>";
            })
            ->rawColumns(['action', 'username', 'name'])
            ->make(true);
        }
        return view('Services.Pedagang.index');
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
            $input['ktp']      = str_replace('.', '', $request->tambah_ktp);
            $input['email']    = $request->tambah_email;
            $input['whatsapp'] = str_replace('.', '', $request->tambah_phone);
            $input['npwp']     = str_replace('.', '', $request->tambah_npwp);
            $input['alamat']   = $request->tambah_alamat;

            Validator::make($input, [
                'username' => 'required|string|max:100|unique:users,username',
                'nama'     => 'required|string|max:100',
                'ktp'      => 'nullable|numeric|lte:99999999999999999',
                'email'    => 'nullable|email|max:255',
                'whatsapp' => 'nullable|numeric|lte:999999999999',
                'npwp'     => 'nullable|numeric|lte:99999999999999999',
                'alamat'   => 'nullable|string',
            ])->validate();
            //End Validator

            DB::transaction(function() use ($input){
                User::create([
                    'username' => $input['username'],
                    'name'     => $input['nama'],
                    'phone'    => $input['whatsapp'],
                    'member'   => User::code(),
                    'ktp'      => $input['ktp'],
                    'npwp'     => $input['npwp'],
                    'address'  => $input['alamat'],
                    'email'    => $input['email'],
                    'password' => Hash::make(sha1(md5(hash('gost', '123456')))),
                    'level'    => 6,
                    'status'   => 1
                ]);
            });

            return response()->json(['success' => 'Data berhasil ditambah.']);
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

            $data = User::findOrFail($decrypted);

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

            $data = User::findOrFail($decrypted);

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
            $input['nama']     = $request->edit_name;
            $input['ktp']      = str_replace('.', '', $request->edit_ktp);
            $input['email']    = $request->edit_email;
            $input['whatsapp'] = str_replace('.', '', $request->edit_phone);
            $input['npwp']     = str_replace('.', '', $request->edit_npwp);
            $input['alamat']   = $request->edit_alamat;

            Validator::make($input, [
                'nama'     => 'required|string|max:100',
                'ktp'      => 'nullable|numeric|lte:99999999999999999',
                'email'    => 'nullable|email|max:255',
                'whatsapp' => 'nullable|numeric|lte:999999999999',
                'npwp'     => 'nullable|numeric|lte:99999999999999999',
                'alamat'   => 'nullable|string',
            ])->validate();
            //End Validator

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            DB::transaction(function() use ($input, $decrypted){
                $data = User::lockForUpdate()->findOrFail($decrypted);

                $data->update([
                    'name'    => $input['nama'],
                    'phone'   => $input['whatsapp'],
                    'ktp'     => $input['ktp'],
                    'npwp'    => $input['npwp'],
                    'address' => $input['alamat'],
                    'email'   => $input['email'],
                ]);
            });

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

            DB::transaction(function() use ($decrypted){
                $data = User::lockForUpdate()->findOrFail($decrypted);

                if($data->status == 1){
                    $data->status = 0;
                } else {
                    $data->status = 1;
                }

                $data->save();
            });

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

            DB::transaction(function() use ($decrypted){
                $data = User::lockForUpdate()->findOrFail($decrypted);

                $data->password = Hash::make(sha1(md5(hash('gost', '123456'))));

                $data->save();
            });

            return response()->json(['success' => 'Password direset = <b>123456</b>.']);
        }
    }
}
