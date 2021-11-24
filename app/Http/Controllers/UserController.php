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
use App\Models\ActivationCode;

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
            $data = User::where([['level',$level],['active','!=','0']])->select('id','username','name','active');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '';
                    if(Auth::user()->id != $data->id){
                        $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" name="reset" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    }
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('active', function($data){
                    if($data->active == 1){
                        $button = '<span style="color:#36bea6;">Active</span>';
                    }
                    else if($data->active == 2){
                        $button = '<span style="color:#2962FF;">Register</span>';
                    }
                    return $button;
                })
                ->rawColumns(['action','show','active'])
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
            $data = User::where([['level',$level],['active','1']])->select('id','username','name','active');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '';
                    if(Auth::user()->id != $data->id){
                        $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" name="reset" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                        $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    }
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('active', function($data){
                    if($data->active == 1){
                        $button = '<span style="color:#36bea6;">Active</span>';
                    }
                    else if($data->active == 2){
                        $button = '<span style="color:#2962FF;">Register</span>';
                    }
                    return $button;
                })
                ->rawColumns(['action','show','active'])
                ->make(true);
        }
    }

    public function deleted($level)
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            if(Auth::user()->level > 1){
                $level = 3;
            }
            $data = User::where([['level', $level],['active','0']])->select('id','username','name','active');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" title="Restore" name="restore" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="restore"><i class="fas fa-undo" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="Delete Permanent" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="deletePermanently"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('active', function($data){
                    $button = '<span style="color:#e74a3b;">nonactive</span>';
                    return $button;
                })
                ->rawColumns(['action','show','active'])
                ->make(true);
        }
    }

    public function registered($level)
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            if(Auth::user()->level > 1){
                $level = 3;
            }
            $data = User::where([['level', $level],['active','2']])->select('id','username','name','active');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" title="Activate" name="activate" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="activateUser"><i class="fas fa-shield-check" style="color:#36bea6;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="Delete Permanent" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="deletePermanently"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('active', function($data){
                    $button = '<span style="color:#2962FF;">Register</span>';
                    return $button;
                })
                ->rawColumns(['action','show','active'])
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
                'address' => 'nullable|max:255',
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
                $data['authority'] = $this->authorityCheck($request);
            }
            $data['phone'] = $request->phone;
            $email = $request->email;
            $data['email'] = $email;
            $member = 'BP3C'.Identity::make('member');
            $data['member'] = $member;
            $data['ktp'] = $request->ktp;
            $data['npwp'] = $request->npwp;
            $data['address'] = $request->address;
            $data['active'] = 1;
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
                    'url' => url('email/verify/'.$level.'/'.Crypt::encrypt($member . "+" . Carbon::now()->addDays(2)->toDateTimeString())),
                    'regards' => "Selamat Berniaga (PIC BDG Team)",
                    'email' => $email,
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'value' => 'store',
                ];
                dispatch(new \App\Jobs\UserEmailJob($details));
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Email failed to send.', 'description' => $e]);
            }

            try{
                User::create($data);
            }
            catch(\Exception $e){
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
                return response()->json(['error' => 'Data invalid.']);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            $user['level'] = User::level($user->level);
            $user['active'] = User::active($user->active);

            return response()->json(['success' => 'Fetching data success.', 'user' => $user]);
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
                return response()->json(['error' => 'Data invalid.']);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            return response()->json(['success' => 'Fetching data success.', 'user' => $user]);
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
        if(request()->ajax()){
            //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
            try {
                $id = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.']);
            }

            $request->validate([
                'level' => 'required|numeric',
                'email' => 'required|max:200|email|unique:App\Models\User,email,'.$id,
                'name' => 'required|max:100|regex:/^[\pL\s\-]+$/u',
                'ktp' => 'nullable|numeric|digits_between:16,16|unique:App\Models\User,ktp,'.$id,
                'npwp' => 'nullable|numeric|digits_between:15,15|unique:App\Models\User,npwp,'.$id,
                'phone' => 'nullable|numeric|digits_between:10,12|unique:App\Models\User,phone,'.$id,
                'address' => 'nullable|max:255',
            ]);

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            $user->name = $request->name;
            $level = $request->level;
            if(Auth::user()->level > 1 && $level != 3){
                return response()->json(['error' => 'Something wrong.']);
            }
            $user->level = $level;
            if($level == 2){
                $user->authority = $this->authorityCheck($request);
            }
            else{
                $user->authority = NULL;
            }
            $user->phone = $request->phone;
            $email = $request->email;
            if($user->email != $email){
                $user->email_verified_at = NULL;
            }
            $user->email = $email;
            $user->ktp = $request->ktp;
            $user->npwp = $request->npwp;
            $user->address = $request->address;

            $user->save();
            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function authorityCheck($request){
        $request->validate([
            'group' => 'required',
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
            if(!is_null($request->kelola)){
                if(in_array($pilihanKelola[$i],$request->kelola)){
                    $kelola[$pilihanKelola[$i]] = true;
                }
                else{
                    $kelola[$pilihanKelola[$i]] = false;
                }
            }
        }

        if(is_null($kelola))
            $authority = [];
        else{
            $authority = $kelola;
        }

        $group = $request->group;
        $temp = [];
        for($i = 0; $i < count($group); $i++){
            $temp[$i] = $group[$i];
        }
        $group = $temp;

        $authority = [
            'group' => $temp,
            'authority' => $authority,
        ];

        return json_encode($authority);
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
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.']);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            if($user->id == Auth::user()->id){
                return response()->json(['error' => 'Data currently.']);
            }

            if(!is_null($user->nonactive)){
                $json = json_decode($user->nonactive, true);

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
                'photo' => $user->photo,
                'nama' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'member' => $user->member,
                'ktp' => $user->ktp,
                'npwp' => $user->npwp,
                'address' => $user->address,
                'authority' => $user->authority,
            ];

            $timestamp = Carbon::now()->toDateTimeString();
            $json[] = array(
                'id' => $id,
                'status' => 'nonactive',
                'active' => $user->active,
                'member' => Auth::user()->member,
                'timestamp' => $timestamp,
                'data' => $person,
            );
            $nonactive = json_encode($json);

            $user->active = 0;
            $user->nonactive = $nonactive;

            if(!is_null($user->email)){
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
                    return response()->json(['error' => 'User not found.', 'description' => $e]);
                }
            }

            $user->save();

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function permanent($id)
    {
        if(request()->ajax()){
            try {
                $id = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.']);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            if($user->id == Auth::user()->id){
                return response()->json(['error' => 'Data currently.']);
            }

            $user->delete();
            return response()->json(['success' => 'Data deleted.']);

        }
        else{
            abort(404);
        }
    }

    public function restore($id)
    {
        if(request()->ajax()){
            try {
                $id = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.']);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            if(!is_null($user->nonactive)){
                $json = json_decode($user->nonactive, true);

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
                $user->active = $index["active"];
                $user->phone = $index['data']['phone'];
                $user->email = $index['data']['email'];
                $user->email_verified_at = $index['data']['email_verified_at'];
                $user->ktp = $index['data']['ktp'];
                $user->npwp = $index['data']['npwp'];
                $user->address = $index['data']['address'];
                $user->authority = $index['data']['authority'];

                $id = ++$last_item_id;
            }
            else{
                $id = 1;
            }

            $person = [
                'photo' => $user->photo,
                'nama' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'member' => $user->member,
                'ktp' => $user->ktp,
                'npwp' => $user->npwp,
                'address' => $user->address,
                'authority' => $user->authority,
            ];

            $json[] = array(
                'id' => $id,
                'status' => 'aktivasi',
                'active' => $user->active,
                'member' => Auth::user()->member,
                'timestamp' => Carbon::now()->toDateTimeString(),
                'data' => $person,
            );
            $nonactive = json_encode($json);

            $user->nonactive = $nonactive;
            try{
                $user->save();
            } catch (\Exception $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            return response()->json(['success' => 'Data restored.']);
        }
        else{
            abort(404);
        }
    }

    public function reset($id)
    {
        if(request()->ajax()){
            try {
                $id = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.']);
            }

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }
            $pass = str_shuffle('00112233445566778899');
            $pass = substr($pass,0,7);

            $user->password = Hash::make(sha1(md5(hash('gost', $pass))));
            $user->save();

            return response()->json(['success' => 'Password resetted.', 'pass' => $pass]);
        }
        else{
            abort(404);
        }
    }

    public function activate(){
        //submit 0 = belum untuk aktivasi, 1 = sudah di submit belum di aktivasi, 2 = akun teraktivasi dan code di hapus;
        if(request()->ajax()){
            $now = Carbon::now()->toDateTimeString();
            $code = ActivationCode::where([
                ['user_id', Auth::user()->id],
                ['submit','<', 2],
                ['available', '>', $now],
            ])->first();

            if(!is_null($code)){
                $data = $code;
            }
            else{
                $data['code'] = rand(111111,999999);
                $data['available'] = Carbon::now()->addMinutes(15)->toDateTimeString();
                $data['user_id'] = Auth::user()->id;
                $data['submit'] = 0;
                try{
                    ActivationCode::create($data);
                } catch(\Exception $e){
                    return response()->json(['error' => 'Failed to retrieve activation code.']);
                }
            }

            return response()->json(['success' => 'Activation code success.', 'result' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function activateVerify(){
        //submit 0 = belum untuk aktivasi, 1 = sudah di submit belum di aktivasi, 2 = akun teraktivasi dan code di hapus;
        if(request()->ajax()){
            $now = Carbon::now()->toDateTimeString();
            $id = Auth::user()->id;

            $code = ActivationCode::where([
                ['user_id', $id],
                ['submit', 1],
                ['available', '>', $now],
            ])->first();

            if(!is_null($code)){
                $data = User::where('activation_code', $code->code)->first();

                $data = Crypt::encrypt($data->id);

                return response()->json([
                    'success' => "Please complete registration code : $code->code .",
                    'result' => $data
                ]);
            }
            else{
                return response()->json([
                    'error' => "Activation code not found."
                ]);
            }
        }
    }
}
