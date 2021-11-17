<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Identity;
use App\Models\Blok;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            if(Auth::user()->level > 1){
                $level = 3;
            }
            else{
                $level = AUth::user()->level;
            }
            $data = User::where([['level',$level],['stt_aktif','!=','0']])->select('id','username','name','stt_aktif');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '';
                    if(Auth::user()->id != $data->id){
                        $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" name="reset" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Hapus" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    }
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('stt_aktif', function($data){
                    if($data->stt_aktif == 1){
                        $button = '<span style="color:#36bea6;">Aktif</span>';
                    }
                    else if($data->stt_aktif == 2){
                        $button = '<span style="color:#2962FF;">Terdaftar</span>';
                    }
                    return $button;
                })
                ->rawColumns(['action','show','stt_aktif'])
                ->make(true);
        }
        return view('portal.user.index');
    }

    public function level($level)
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            if(Auth::user()->level > 1){
                $level = 3;
            }
            $data = User::where([['level',$level],['stt_aktif','!=','0']])->select('id','username','name','stt_aktif');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '';
                    if(Auth::user()->id != $data->id){
                        $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" name="reset" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Hapus" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    }
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('stt_aktif', function($data){
                    if($data->stt_aktif == 1){
                        $button = '<span style="color:#36bea6;">Aktif</span>';
                    }
                    else if($data->stt_aktif == 2){
                        $button = '<span style="color:#2962FF;">Terdaftar</span>';
                    }
                    return $button;
                })
                ->rawColumns(['action','show','stt_aktif'])
                ->make(true);
        }
    }

    public function penghapusan($level)
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            if(Auth::user()->level > 1){
                $level = 3;
            }
            $data = User::where([['level', $level],['stt_aktif','0']])->select('id','username','name','stt_aktif');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" title="Restore" name="restore" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="restore"><i class="fas fa-undo" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanently" name="deletePermanently" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="deletePermanently"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('stt_aktif', function($data){
                    $button = '<span style="color:#e74a3b;">Nonaktif</span>';
                    return $button;
                })
                ->rawColumns(['action','show','stt_aktif'])
                ->make(true);
        }
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
        if(request()->ajax()){
            //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
            $request->validate([
                'level' => 'required|numeric',
                'email' => 'required|max:200|email|unique:App\Models\User,email',
                'name' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
                'ktp' => 'nullable|numeric|digits_between:16,16|unique:App\Models\User,ktp',
                'npwp' => 'nullable|numeric|digits_between:15,15|unique:App\Models\User,npwp',
                'phone' => 'nullable|numeric|digits_between:10,12|unique:App\Models\User,phone',
                'alamat' => 'nullable|max:255',
                'checkEmail' => 'required',
            ]);

            $username = Identity::make('username');
            $data['username'] = $username;
            $name = $request->name;
            $data['name'] = $name;
            $level = $request->level;
            if(Auth::user()->level > 1 && $level != 3){
                return response()->json(['error' => 'Something wrong.']);
            }
            $data['level'] = $level;
            if($level == 2){
                $data['otoritas'] = $this->checkOtoritas($request);
            }
            $data['phone'] = $request->phone;
            $email = $request->email;
            $data['email'] = $email;
            $anggota = 'BP3C'.Identity::make('anggota');
            $data['anggota'] = $anggota;
            $data['ktp'] = $request->ktp;
            $data['npwp'] = $request->npwp;
            $data['alamat'] = $request->alamat;
            $data['stt_aktif'] = 1;
            $password = Identity::make('password');
            $data['password'] = Hash::make(sha1(md5(hash('gost', $password))));

            try{
                $details = [
                    'sender' => Auth::user()->name." dari PIC",
                    'header' => "Harap Setting Profil & Password Anda setelah verifikasi",
                    'subject' => "Email Verification",
                    'name' => $name,
                    'role' => User::level($level),
                    'type' => "verifikasi",
                    'username' => $username,
                    'password' => $password,
                    'button' => "Verifikasi",
                    'url' => url('email/verify/'.$level.'/'.Crypt::encrypt($anggota)),
                    'regards' => "Selamat Berniaga (PIC BDG Team)",
                    'email' => $email,
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'value' => 'store',
                ];
                dispatch(new \App\Jobs\UserEmailJob($details));
            }
            catch(\Exception $e){
                return response()->json(['exception' => $e]);
            }

            try{
                User::create($data);
            }
            catch(\Exception $e){
                return response()->json(['exception' => $e]);
            }

            return response()->json(['success' => 'Data berhasil disimpan.']);
        }
        else{
            return response()->json(['error' => '404 Not Found']);
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
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            $user['level'] = User::level($user->level);
            $user['stt_aktif'] = User::sttAktif($user->stt_aktif);

            return response()->json(['success' => 'Berhasil mengambil data.', 'user' => $user]);
        }
        else{
            return response()->json(['error' => '404 Not Found']);
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
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            return response()->json(['success' => 'Berhasil mengambil data.', 'user' => $user]);
        }
        else{
            return response()->json(['error' => "404 Not Found"]);
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
        if(request()->ajax()){
            //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
            try {
                $id = Crypt::decrypt($id);
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            $request->validate([
                'level' => 'required|numeric',
                'email' => 'required|max:200|email|unique:App\Models\User,email,'.$id,
                'name' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
                'ktp' => 'nullable|numeric|digits_between:16,16|unique:App\Models\User,ktp,'.$id,
                'npwp' => 'nullable|numeric|digits_between:15,15|unique:App\Models\User,npwp,'.$id,
                'phone' => 'nullable|numeric|digits_between:10,12|unique:App\Models\User,phone,'.$id,
                'alamat' => 'nullable|max:255',
            ]);

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            $user->name = $request->name;
            $level = $request->level;
            if(Auth::user()->level > 1 && $level != 3){
                return response()->json(['error' => 'Something wrong.']);
            }
            $user->level = $level;
            if($level == 2){
                $user->otoritas = $this->checkOtoritas($request);
            }
            else{
                $user->otoritas = NULL;
            }
            $user->phone = $request->phone;
            $email = $request->email;
            if($user->email != $email){
                $user->email_verified_at = NULL;
            }
            $user->email = $email;
            $user->ktp = $request->ktp;
            $user->npwp = $request->npwp;
            $user->alamat = $request->alamat;

            $user->save();
            return response()->json(['success' => 'Data berhasil disimpan.']);
        }
        else{
            return response()->json(['error' => '404 Not Found']);
        }
    }

    public function checkOtoritas($request){
        $request->validate([
            'blok' => 'required',
        ]);

        $pilihanKelola = array(
            'registrasi',
            'pedagang',
            'tempatusaha',
            'pembongkaran',
            'tagihan',
            'simulasi',
            'pemakaian',
            'pendapatan',
            'tunggakan',
            'datausaha',
            'alatmeter',
            'tarif',
            'harilibur',
        );

        $kelola = NULL;

        for($i=0; $i<count($pilihanKelola); $i++){
            if($request->kelola != NULL){
                if(in_array($pilihanKelola[$i],$request->kelola)){
                    $kelola[$pilihanKelola[$i]] = true;
                }
                else{
                    $kelola[$pilihanKelola[$i]] = false;
                }
            }
        }

        if($kelola == NULL)
            $otoritas = [];
        else{
            $otoritas = $kelola;
        }

        $blok = $request->blok;
        $temp = [];
        for($i = 0; $i < count($blok); $i++){
            $temp[$i] = $blok[$i];
        }
        $blok = $temp;

        $otoritas = [
            'blok' => $temp,
            'otoritas' => $otoritas,
        ];

        return json_encode($otoritas);
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
                $id = Crypt::decrypt($id);
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            if($user->id == Auth::user()->id){
                return response()->json(['error' => 'Tidak dapat menghapus akun yang digunakan.']);
            }

            if($user->nonaktif != NULL){
                $json = json_decode($user->nonaktif, true);

                $history = count($json);
                if($history > 5){
                    $length = $history - 5;
                    array_splice($json, 0, $length);
                }

                // Get last id
                $last_item    = end($json);
                $last_item_id = $last_item['id'];

                $id = ++$last_item_id;
            }
            else{
                $id = 1;
            }

            $person = [
                'foto' => $user->foto,
                'nama' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'anggota' => $user->anggota,
                'ktp' => $user->ktp,
                'npwp' => $user->npwp,
                'alamat' => $user->alamat,
                'otoritas' => $user->otoritas,
            ];

            $timestamp = Carbon::now()->toDateTimeString();
            $json[] = array(
                'id' => $id,
                'status' => 'nonaktif',
                'stt_aktif' => $user->stt_aktif,
                'anggota' => Auth::user()->anggota,
                'timestamp' => $timestamp,
                'data' => $person,
            );
            $nonaktif = json_encode($json);

            $user->stt_aktif = 0;
            $user->nonaktif = $nonaktif;

            if($user->email != NULL){
                try{
                    $details = [
                        'sender' => Auth::user()->name." dari PIC",
                        'header' => "Harap hubungi Bagian Pelayanan Pedagang apabila ingin re-aktivasi",
                        'subject' => "Akun telah dinonaktifkan",
                        'name' => $user->name,
                        'role' => User::level($user->level),
                        'type' => "nonaktivasi",
                        'regards' => "Sampai Jumpa Kembali (PIC BDG Team)",
                        'timestamp' => Carbon::now()->toDateTimeString(),
                        'limit' => Carbon::now()->addDays(30)->toDateTimeString(),
                        'email' => $user->email,
                        'value' => 'destroy',
                    ];
                    dispatch(new \App\Jobs\UserEmailJob($details));
                }
                catch(\Exception $e){
                    return response()->json(['exception' => $e]);
                }
            }

            $user->save();

            return response()->json(['success' => 'Data berhasil dihapus.']);
        }
        else{
            return response()->json(['error' => '404 Not Found.']);
        }
    }

    public function permanen($id)
    {
        if(request()->ajax()){
            try {
                $id = Crypt::decrypt($id);
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            if($user->id == Auth::user()->id){
                return response()->json(['error' => 'Tidak dapat menghapus akun yang digunakan.']);
            }

            if($user->nonaktif != NULL){
                $json = json_decode($user->nonaktif, true);

                $history = count($json);
                if($history > 5){
                    $length = $history - 5;
                    array_splice($json, 0, $length);
                }

                // Get last id
                $last_item    = end($json);
                $last_item_id = $last_item['id'];

                $id = ++$last_item_id;
            }
            else{
                $id = 1;
            }

            $person = [
                'foto' => $user->foto,
                'nama' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'anggota' => $user->anggota,
                'ktp' => $user->ktp,
                'npwp' => $user->npwp,
                'alamat' => $user->alamat,
            ];

            $json[] = array(
                'id' => $id,
                'status' => 'delete permanently',
                'stt_aktif' => $user->stt_aktif,
                'anggota' => Auth::user()->anggota,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'data' => $person,
            );
            $nonaktif = json_encode($json);

            $user->phone = NULL;
            $user->email = NULL;
            $user->email_verified_at = NULL;
            $user->ktp = NULL;
            $user->npwp = NULL;
            $user->alamat = NULL;
            $user->otoritas = NULL;

            $user->stt_aktif = NULL;
            $user->nonaktif = $nonaktif;
            $user->save();

            return response()->json(['success' => 'Data berhasil dihapus.']);
        }
        else{
            return response()->json(['error' => '404 Not Found.']);
        }
    }

    public function restore($id)
    {
        if(request()->ajax()){
            try {
                $id = Crypt::decrypt($id);
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            if($user->nonaktif != NULL){
                $json = json_decode($user->nonaktif, true);

                $history = count($json);
                if($history > 5){
                    $length = $history - 5;
                    array_splice($json, 0, $length);
                }

                // Get last id
                $last_item    = end($json);
                $last_item_id = $last_item['id'];

                // get data for restore
                $index = $json[count($json) - 1];
                $user->stt_aktif = $index["stt_aktif"];
                $user->phone = $index['data']['phone'];
                $user->email = $index['data']['email'];
                $user->email_verified_at = $index['data']['email_verified_at'];
                $user->ktp = $index['data']['ktp'];
                $user->npwp = $index['data']['npwp'];
                $user->alamat = $index['data']['alamat'];
                $user->otoritas = $index['data']['otoritas'];

                $id = ++$last_item_id;
            }
            else{
                $id = 1;
            }

            $person = [
                'foto' => $user->foto,
                'nama' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'anggota' => $user->anggota,
                'ktp' => $user->ktp,
                'npwp' => $user->npwp,
                'alamat' => $user->alamat,
                'otoritas' => $user->otoritas,
            ];

            $json[] = array(
                'id' => $id,
                'status' => 'aktivasi',
                'stt_aktif' => $user->stt_aktif,
                'anggota' => Auth::user()->anggota,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'data' => $person,
            );
            $nonaktif = json_encode($json);

            $user->nonaktif = $nonaktif;
            try{
                $user->save();
            } catch (\Exception $e){
                return response()->json(['exception' => $e]);
            }

            return response()->json(['success' => 'Data berhasil dipulihkan.']);
        }
        else{
            return response()->json(['error' => '404 Not Found.']);
        }
    }

    public function reset($id)
    {
        if(request()->ajax()){
            try {
                $id = Crypt::decrypt($id);
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['exception' => $e]);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }
            $pass = str_shuffle('00112233445566778899');
            $pass = substr($pass,0,7);

            $user->password = Hash::make(sha1(md5(hash('gost', $pass))));
            $user->save();

            return response()->json(['success' => 'Reset password berhasil.', 'pass' => $pass]);
        }
        else{
            return response()->json(['error' => '404 Not Found']);
        }
    }
}
