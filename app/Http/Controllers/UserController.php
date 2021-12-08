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
use App\Models\Country;
use App\Models\Store;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah
        if(request()->ajax())
        {
            $level = $request->lev;
            $active = $request->data;

            if(Auth::user()->level > 1){
                $level = 3;
            }

            $data = User::where([['level',$level],['active',$active]])->select('id','uid','name','active');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '';
                    if(Auth::user()->id != $data->id){
                        if($data->active == 2){
                            $button = '<a type="button" data-toggle="tooltip" title="Activate" name="activate" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="activateUser"><i class="fas fa-shield-check" style="color:#36bea6;"></i></a>';
                            $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="Delete Permanent" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="deletePermanently"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                        }
                        else if($data->active == 1){
                            $button .= '<a type="button" data-toggle="tooltip" title="Reset Password" name="reset" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                            $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                            $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                        }
                        else{
                            $button = '<a type="button" data-toggle="tooltip" title="Restore" name="restore" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="restore"><i class="fas fa-undo" style="color:#4e73df;"></i></a>';
                            $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete Permanent" name="Delete Permanent" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="deletePermanently"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                        }
                    }
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                    return $button;
                })
                ->editColumn('name', function($data){
                    return substr($data->name, 0, 15);
                })
                ->editColumn('active', function($data){
                    if($data->active == 0){
                        $button = '<span style="color:#e74a3b;">Nonaktif</span>';
                    }
                    if($data->active == 1){
                        $button = '<span style="color:#36bea6;">Aktif</span>';
                    }
                    else if($data->active == 2){
                        $button = '<span style="color:#2962FF;">Pendaftaran</span>';
                    }
                    return $button;
                })
                ->rawColumns(['action','active'])
                ->make(true);
        }
        return view('portal.user.index');
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
                'name' => 'required|max:100',
                'ktp' => 'required|numeric|digits_between:7,16|unique:App\Models\User,ktp',
                'npwp' => 'nullable|numeric|digits:15|unique:App\Models\User,npwp',
                'phone' => 'required|numeric|digits_between:8,15|unique:App\Models\User,phone',
                'address' => 'required|max:255'
            ]);

            $uid = Identity::make('uid');
            $data['uid'] = $uid;
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

            $country = $request->country;
            $country = Country::where('iso', $country)->first();
            if(!is_null($country)){
                $country = $country->id;
            }
            else{
                return response()->json(['error' => "Country code not found."]);
            }
            $data['country_id'] = $country;

            $phone = $request->phone;
            if(substr($phone,0,1) == "0"){
                return response()->json(['warning' => "Whatsapp number incorrect."]);
            }
            $data['phone'] = $request->phone;
            $email = $request->email;
            $data['email'] = $email;
            $member = Identity::make('member');
            $data['member'] = $member;
            $data['ktp'] = $request->ktp;
            $data['npwp'] = $request->npwp;
            $data['address'] = $request->address;
            $data['active'] = 1;
            $password = Identity::make('password');
            $data['password'] = Hash::make(sha1(md5(hash('gost', $password))));

            if(isset($request->checkEmail)){
                try{
                    $details = [
                        'sender' => Auth::user()->name." dari PIC",
                        'header' => "Harap Setting Profil & Password Anda setelah verifikasi",
                        'subject' => "Email Verification",
                        'name' => $name,
                        'role' => User::level($level),
                        'type' => "verifikasi",
                        'uid' => $uid,
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
            }

            try{
                User::create($data);
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $uid;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
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
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $user['level'] = User::level($user->level);
            $user['active'] = User::active($user->active);

            $country = Country::find($user->country_id);
            if(!is_null($country)){
                $user['phone'] = $country->phonecode.$user->phone;
            }
            else{
                $user['phone'] = $user->phone;
                return response()->json([
                    'success' => 'Retrieve data success.',
                    'user' => $user,
                    'warning' => 'Phone number failure.'
                ]);
            }

            $user['create'] = Carbon::parse($user->created_at)->toDateTimeString();
            $user['update'] = Carbon::parse($user->updated_at)->toDateTimeString();

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
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $country = Country::find($user->country_id);
            if(!is_null($country)){
                $user['iso'] = $country->iso;
            }
            else{
                $user['iso'] = "";
                return response()->json([
                    'success' => 'Retrieve data success.',
                    'user' => $user,
                    'warning' => 'Phone number failure.'
                ]);
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
            $request->validate([
                'level' => 'required|numeric',
                'email' => 'required|max:200|email|unique:App\Models\User,email,'.$id,
                'name' => 'required|max:100',
                'ktp' => 'required|numeric|digits_between:7,16|unique:App\Models\User,ktp,'.$id,
                'npwp' => 'nullable|numeric|digits:15|unique:App\Models\User,npwp,'.$id,
                'phone' => 'required|numeric|digits_between:8,15|unique:App\Models\User,phone,'.$id,
                'address' => 'required|max:255',
            ]);

            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
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

            $country = $request->country;
            $country = Country::where('iso', $country)->first();
            if(!is_null($country)){
                $country = $country->id;
            }
            else{
                return response()->json(['error' => "Country code not found."]);
            }
            $user->country_id = $country;

            $user->phone = $request->phone;
            $email = $request->email;
            if($user->email != $email){
                $user->email_verified_at = NULL;
            }
            $user->email = $email;
            $user->ktp = $request->ktp;
            $user->npwp = $request->npwp;
            $user->address = $request->address;

            try{
                $user->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }
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
            'group' => $group,
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
    public function destroy($id) //Review Ulang
    {
        if(request()->ajax()){
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
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
                    return response()->json(['error' => 'Data not found.', 'description' => $e]);
                }
            }

            try{
                $user->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function permanent($id) //Review Ulang
    {
        if(request()->ajax()){
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            if($user->id == Auth::user()->id){
                return response()->json(['error' => 'Data currently.']);
            }

            $data = User::with(['pengguna:id,id_pengguna', 'pemilik:id,id_pemilik'])->find($id);
            foreach($data->pengguna as $d => $key){
                Store::penggunaDeletePermanent($key->id);
            }
            foreach($data->pemilik as $d => $key){
                Store::pemilikDeletePermanent($key->id);
            }

            try{
                $user->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function restore($id)
    {
        if(request()->ajax()){
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
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
                return response()->json(['error' => 'Data failed to restore.', 'description' => $e]);
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
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }
            $pass = str_shuffle('00112233445566778899');
            $pass = substr($pass,0,7);

            $user->password = Hash::make(sha1(md5(hash('gost', $pass))));

            try{
                $user->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Password failed to reset.", 'description' => $e]);
            }

            return response()->json(['success' => 'Password resetted.', 'pass' => $pass]);
        }
        else{
            abort(404);
        }
    }

    public function activate(){
        if(request()->ajax()){
            $now = Carbon::now()->toDateTimeString();
            $code = ActivationCode::where([
                ['user_id', Auth::user()->id],
                ['submit', 0],
                ['available', '>', $now],
            ])->first();

            if(!is_null($code)){
                $data = $code;

                //disini baca waktu
                $from = new Carbon($data->available);
                $end = Carbon::now()->toDateTimeString();
                $remain = $from->diffInSeconds($end);
                $data['time'] = gmdate("i:s", $remain);
            }
            else{
                $time = Carbon::now()->addMinutes(5);
                $data['code'] = mt_rand(111111,999999);
                $data['available'] = $time->toDateTimeString();
                $data['user_id'] = Auth::user()->id;
                $data['submit'] = 0;

                $from = new Carbon($time->toDateTimeString());
                $end = Carbon::now()->toDateTimeString();

                $remain = $from->diffInSeconds($end);

                $data['time'] = gmdate("i:s", $remain);

                try{
                    ActivationCode::create($data);
                } catch(\Exception $e){
                    return response()->json(['error' => 'Failed to retrieve activation code.', 'description' => $e]);
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
                    'description' => "Activation code active."
                ]);
            }
        }
    }
}
