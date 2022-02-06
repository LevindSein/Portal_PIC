<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Group;
use App\Models\Identity;
use App\Models\Country;
use App\Models\Store;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = NULL;
        if(request()->data){
            try{
                $user = User::findOrFail(request()->data);
            }catch(ModelNotFoundException $e){
                abort(404);
            }

            $data = $user;
        }
        return view('portal.service.register.index', [
            'data' => $data
        ]);
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
                return response()->json(['error' => 'Unknown level.']);
            }
            $data['level'] = $level;

            if($level == 2){
                $data['authority'] = User::authorityCheck($request->authority, $request->kelola);
            }

            $country = $request->country;
            $country = Country::where('iso', $country)->first();
            if($country){
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
            $data['password'] = Hash::make(sha1(md5($password)));

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

            try{
                User::create($data);
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            if($level == 3){
                switch ($request->tempatusahaChoose) {
                    case '1':
                        # Pilih yang tersedia
                        break;
                    case '2':
                        # Buat Tempat Baru
                        break;
                    default:
                        break;
                }
            }

            return response()->json(['success' => 'Data saved.']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
                return response()->json(['error' => 'Unknown level.']);
            }
            $user->level = $level;

            if($level == 2){
                $user->authority = User::authorityCheck($request->authority, $request->kelola);
            }
            else{
                $user->authority = NULL;
            }

            $country = $request->country;
            $country = Country::where('iso', $country)->first();
            if($country){
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
            $user->active = 1;
            $user->available = NULL;

            try{
                $user->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
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
        //
    }

    public function gKontrol(Request $request, $type){
        if($type == 'kontrol'){
            $group = $request->group;
            $los = $this->multipleSelect($request->los);
            sort($los, SORT_NATURAL);

            $los = $los[0];
            $data = Store::kontrol($group,$los);
        }
        else{
            $kontrol = $request->kd_kontrol;

            $store = Store::where([
                ['kd_kontrol', $kontrol],
                ['status', '!=', 0]
            ])->select('kd_kontrol')->first();

            $data['text'] = "Dibawah ini kode kontrol yang <b>terbentuk</b>. Sebelumnya kode kontrol <b>$kontrol</b> berstatus <b>nonaktif (tidak digunakan)</b>. Berikut adalah kode kontrol yang dijadikan identifikasi Tempat Usaha :";
            if($store){
                //Tambah Alfabet di Kode Kontrol, dan create Tempat Usaha
                $data['text'] = "Dibawah ini kode kontrol yang <b>terbentuk</b>. Sebelumnya kode kontrol <b>$kontrol</b> telah <b>tersedia</b> dan <b>digunakan</b>. Berikut adalah kode kontrol yang dijadikan identifikasi Tempat Usaha :";

                $suffix = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

                $i = 0;
                do {
                    if($suffix[$i] == 'Z'){
                        return response()->json(['warning' => "Suffix kode kontrol telah mencapai maksimal. Silakan membuat Tempat Usaha Baru."]);
                    }
                    $kode = $kontrol.$suffix[$i];
                    $i++;
                } while(
                    Store::where([
                        ['kd_kontrol', $kode],
                        ['status', '!=', 0]
                    ])->select('kd_kontrol')->first()
                );
                $kontrol = $kode;
            }

            $data['kontrol'] = $kontrol;
        }

        return response()->json(['success' => $data]);
    }
}
