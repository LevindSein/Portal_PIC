<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\Identity;
use App\Models\DataLogin;
use App\Models\Visitor;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Visitor::visitOnDay();
        if(Auth::check()){
            $user = Auth::user();
            if($user->active == 1){
                DataLogin::success();
                if($user->level == 1 || $user->level == 2){
                    $name = Auth::user()->name;
                    return redirect('production/dashboard')->with('success',"Welcome $name.");
                }
                else if($user->level == 3){
                    return "Dashboard Nasabah";
                }
                else{
                    abort(403);
                }
            }
            else if($user->active == 0){
                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return Redirect('login')->with('error','Account has been disabled.');
            }
            else if($user->active == 2){
                DataLogin::success();
                $token = Crypt::encrypt($user->member . '+' . $user->available);
                return redirect("register/$token");
            }
            else{
                return redirect('login')->with('warning', 'Please login.');
            }
        }

        return view('portal.home.login');
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
        //active : 1 = aktif, 2 = sudah mendaftar tapi belum dapat akses, 0 = nonaktif
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah
        if($request->ajax()){
            $request->validate([
                'uid' => 'required|max:100',
                'password' => 'required|min:6',
            ]);

            $uid = strtolower($request->uid);
            if(filter_var($uid, FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $uid;
            }
            else{
                $credentials['uid'] = $uid;
            }
            $credentials['password'] = sha1(md5(hash('gost',$request->password)));
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if($user->active == 2){
                    DataLogin::success();
                    $token = Crypt::encrypt($user->member . '+' . $user->available);
                    return response()->json(['description' => $token]);
                }
                else if($user->active == 1){
                    if ($user->level == 1 || $user->level == 2){
                        return response()->json(['success' => "Access successfully."]);
                    }
                    else{
                        DataLogin::error();
                        $temp = Session::get("_token");
                        Session::flush();
                        Session::put('_token', $temp);
                        Auth::logout();
                        return response()->json(['error' => "Access denied."]);
                    }
                }
                else{
                    DataLogin::error();
                    $temp = Session::get("_token");
                    Session::flush();
                    Session::put('_token', $temp);
                    Auth::logout();
                    return response()->json(['info' => "Account has been disabled."]);
                }
            }
            else{
                if(filter_var($uid, FILTER_VALIDATE_EMAIL)) {
                    $exist = User::where('email', $uid)->first();
                }
                else{
                    $exist = User::where('uid', $uid)->first();
                }

                if(!is_null($exist)){
                    return response()->json(['error' => "Password incorrect."]);
                }
                else{
                    DataLogin::anonym($request);
                    return response()->json(['error' => "Account not found."]);
                }
            };
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
        //
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

    public function register(){
        return view('portal.scan.register',[
            'nama' => session('nama'),
            'member' => session('member'),
            'data' => session('data'),
        ]);
    }

    public function registerStore(Request $request){
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|max:200|email|unique:App\Models\User,email',
            'password' => 'required|min:6',
        ]);

        $nama = $request->name;
        $email = strtolower($request->email);
        $password = $request->password;

        $uid = Identity::make('uid');
        $member = Identity::make('member');
        $data['uid'] = $uid;
        $data['name'] = $nama;
        $data['email'] = $email;
        $data['member'] = $member;
        $data['active'] = 2;
        $data['password'] = Hash::make(sha1(md5(hash('gost', $password))));
        $available = Carbon::now()->addDays(2)->toDateTimeString();
        $data['available'] = $available;

        try{
            User::create($data);
        }
        catch(\Exception $e){
            return response()->json(['error' => "Data failed to create.", 'description' => $e]);
        }
        $token = Crypt::encrypt($member . '+' . $available);
        return response()->json(['description' => $token]);
    }

    public function registerQr($token){
        $qr = url("/")."/scan/qr/register/".$token;
        $qr = QrCode::size(165)->margin(3)->eyeColor(0, 38,73,92, 196,163,90)->color(196,163,90)->backgroundColor(255,255,255)->generate($qr);
        try {
            $decrypted = Crypt::decrypt($token);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        };

        $explode = explode('+', $decrypted);
        $available = $explode[1];

        return view('portal.home.register', [
            'qr' => $qr,
            'token' => $token,
            'available' => $available,
        ]);
    }

    public function registerQrDownload($token){
        $name = substr($token, 0, 20);
        $token = url("/")."/scan/qr/register/".$token;
        QrCode::format('png')->size(300)->margin(3)->eyeColor(0, 38,73,92, 196,163,90)->color(196,163,90)->backgroundColor(255,255,255)->generate($token, public_path("storage/register/$name.png"));
        $filepath = public_path("storage/register/$name.png");
        return \Response::download($filepath);
    }

    public function logout(){
        $temp = Session::get("_token");
        Session::flush();
        Session::put('_token', $temp);
        Auth::logout();
        return Redirect('login');
    }
}
