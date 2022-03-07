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
use App\Models\Payment;
use App\Models\Commodity;
use App\Models\TListrik;
use App\Models\TAirBersih;
use App\Models\PKeamananIpk;
use App\Models\PKebersihan;
use App\Models\PAirKotor;
use App\Models\PLain;

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
                        $data['group'] = $request->group;

                        $los = $this->multipleSelect($request->los);
                        sort($los, SORT_NATURAL);

                        $no_los = json_decode(Group::where('name', $request->group)->first()->data)->data;
                        foreach($los as $l){
                            $valid['nomorLos'] = $l;
                            Validator::make($valid, [
                                'nomorLos' => 'required|in:'.$no_los,
                            ])->validate();
                        }

                        $data['no_los'] = implode(',', $los);
                        $jml_los = count($los);
                        $data['jml_los'] = $jml_los;

                        $data['kd_kontrol'] = strtoupper($request->kontrol);
                        $data['nicename'] = str_replace('-','',$request->kontrol);
                        $kd_kontrol = strtoupper($request->kontrol);

                        $user = User::where("uid", $uid)->select("id")->first();
                        $data['id_pengguna'] = $user->id;
                        if($request->pemilik){
                            $data['id_pemilik'] = $user->id;
                        }

                        $data['status'] = $request->status;
                        $data['ket'] = $request->ket;

                        if($request->commodity){
                            $commodity = $this->multipleSelect($request->commodity);
                            $commodities = array();
                            for($i = 0; $i < count($commodity); $i++){
                                $valid['kategoriKomoditi'] = $commodity[$i];

                                Validator::make($valid, [
                                    'kategoriKomoditi' => 'required|numeric|exists:App\Models\Commodity,id'
                                ])->validate();

                                $com = Commodity::find($commodity[$i]);
                                $commodities[$i] = [
                                    'id' => $com->id,
                                    'name' => $com->name,
                                ];
                            }

                            $data['komoditi'] = json_encode($commodities);
                        }

                        $data['info'] = $request->info;

                        $diskon = array();

                        //Listrik
                        if($request->fas_listrik){
                            $valid['alatListrik'] = $request->tlistrik;
                            $valid['tarifListrik'] = $request->plistrik;
                            $valid['diskonListrik'] = str_replace('.','',$request->dlistrik);

                            Validator::make($valid, [
                                'alatListrik' => 'required|numeric|exists:App\Models\TListrik,id',
                                'tarifListrik' => 'required|numeric|exists:App\Models\PListrik,id',
                                'diskonListrik' => 'nullable|numeric|lte:100',
                            ])->validate();

                            $tools = TListrik::find($request->tlistrik);
                            $tools->stt_available = 0;
                            $tools->save();

                            $data['id_tlistrik'] = $request->tlistrik;
                            $data['fas_listrik'] = $request->plistrik;

                            if($request->dlistrik){
                                $diskon['listrik'] = str_replace('.','',$request->dlistrik);
                            }
                        }

                        //Air Bersih
                        if($request->fas_airbersih){
                            $valid['alatAirBersih'] = $request->tairbersih;
                            $valid['tarifAirBersih'] = $request->pairbersih;
                            $valid['diskonAirBersih'] = str_replace('.','',$request->dairbersih);

                            Validator::make($valid, [
                                'alatAirBersih' => 'required|numeric|exists:App\Models\TAirBersih,id',
                                'tarifAirBersih' => 'required|numeric|exists:App\Models\PAirBersih,id',
                                'diskonAirBersih' => 'nullable|numeric|lte:100',
                            ])->validate();

                            $tools = TAirBersih::find($request->tairbersih);
                            $tools->stt_available = 0;
                            $tools->save();

                            $data['id_tairbersih'] = $request->tairbersih;
                            $data['fas_airbersih'] = $request->pairbersih;

                            if($request->dairbersih){
                                $diskon['airbersih'] = str_replace('.','',$request->dairbersih);
                            }
                        }

                        //Keamanan IPK
                        if($request->fas_keamananipk){
                            $valid['tarifKeamananIpk'] = $request->pkeamananipk;

                            Validator::make($valid, [
                                'tarifKeamananIpk' => 'required|numeric|exists:App\Models\PKeamananIpk,id'
                            ])->validate();

                            $price = PKeamananIpk::find($request->pkeamananipk);
                            if($request->dkeamananipk){
                                $max_disc = $price->price * $jml_los;

                                $valid['diskonKeamananIpk'] = str_replace('.','',$request->dkeamananipk);

                                Validator::make($valid, [
                                    'diskonKeamananIpk' => 'nullable|numeric|lte:'.$max_disc,
                                ])->validate();
                            }

                            $data['fas_keamananipk'] = $request->pkeamananipk;

                            if($request->dkeamananipk){
                                $diskon['keamananipk'] = str_replace('.','',$request->dkeamananipk);
                            }
                        }

                        //Kebersihan
                        if($request->fas_kebersihan){
                            $valid['tarifKebersihan'] = $request->pkebersihan;

                            Validator::make($valid, [
                                'tarifKebersihan' => 'required|numeric|exists:App\Models\PKebersihan,id'
                            ])->validate();

                            $price = PKebersihan::find($request->pkebersihan);
                            if($request->dkebersihan){
                                $max_disc = $price->price * $jml_los;

                                $valid['diskonKebersihan'] = str_replace('.','',$request->dkebersihan);

                                Validator::make($valid, [
                                    'diskonKebersihan' => 'nullable|numeric|lte:'.$max_disc,
                                ])->validate();
                            }

                            $data['fas_kebersihan'] = $request->pkebersihan;

                            if($request->dkebersihan){
                                $diskon['kebersihan'] = str_replace('.','',$request->dkebersihan);
                            }
                        }

                        //Air Kotor
                        if($request->fas_airkotor){
                            $valid['tarifAirKotor'] = $request->pairkotor;

                            Validator::make($valid, [
                                'tarifAirKotor' => 'required|numeric|exists:App\Models\PAirKotor,id'
                            ])->validate();

                            $price = PAirKotor::find($request->pairkotor);
                            if($request->dairkotor){
                                $valid['diskonAirKotor'] = str_replace('.','',$request->dairkotor);

                                Validator::make($valid, [
                                    'diskonAirKotor' => 'nullable|numeric|lte:'.$price->price,
                                ])->validate();
                            }

                            $data['fas_airkotor'] = $request->pairkotor;

                            if($request->dairkotor){
                                $diskon['airkotor'] = str_replace('.','',$request->dairkotor);
                            }
                        }

                        //Lainnya
                        if($request->plain){
                            $plain = $request->plain;
                            $prices = array();
                            for($i = 0; $i < count($plain); $i++){
                                $valid['tarifLainnya'] = $plain[$i];

                                Validator::make($valid, [
                                    'tarifLainnya' => 'required|numeric|exists:App\Models\PLain,id'
                                ])->validate();

                                $price = PLain::find($plain[$i]);
                                $prices[$i] = [
                                    'id' => "$price->id",
                                    'name' => $price->name,
                                    'price' => $price->price,
                                    'satuan_id' => $price->satuan,
                                    'satuan_name' => PLain::satuan($price->satuan),
                                ];
                            }

                            $data['fas_lain'] = json_encode($prices);
                        }

                        $data['data'] = json_encode([
                            'diskon' => $diskon,
                            'created_by_id' => Auth::user()->id,
                            'created_by_name' => Auth::user()->name,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_by_id' => Auth::user()->id,
                            'updated_by_name' => Auth::user()->name,
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ]);

                        try{
                            Store::create($data);
                        }
                        catch(\Exception $e){
                            return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
                        }

                        Payment::syncByKontrol($kd_kontrol);
                        break;
                    default:
                        break;
                }
            }

            return response()->json(['success' => 'Data saved.']);
        }
    }

    public function multipleSelect($data){
        $temp = array();
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
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

            $data['text'] = '';
            if($store){
                //Tambah Alfabet di Kode Kontrol, dan create Tempat Usaha
                $data['text'] = "Dibawah ini kode kontrol yang <b>terbentuk</b>. Sebelumnya kode kontrol <b>$kontrol</b> telah <b>tersedia</b> dan <b>digunakan</b>. Berikut adalah kode kontrol yang dijadikan identifikasi Tempat Usaha :";

                $suffix = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

                $i = 0;
                $kode = '';
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
