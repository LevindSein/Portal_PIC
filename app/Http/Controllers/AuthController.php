<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\Identity;
use App\Models\LoginData;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->stt_aktif == 1){
                LoginData::success();
                if($user->level == 1 || $user->level == 2){
                    return redirect('dashboard')->with('success','Selamat datang.');
                }
                else{
                    return "level >2";
                }
            }
            else if($user->stt_aktif == 0){
                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return Redirect('login')->with('error','Akun sudah dinonaktifkan.');
            }
            else if($user->stt_aktif == 2){
                LoginData::success();
                $token = Crypt::encrypt($user->anggota);
                return redirect("register/$token");
            }
            else{
                return redirect('login')->with('warning', 'Silakan Login terlebih dahulu.');
            }
        }
        else{
            return view('portal.home.login');
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
        //stt_aktif : 1 = aktif, 2 = sudah mendaftar tapi belum dapat akses, 0 = nonaktif
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah

        $request->validate([
            'username' => 'required|max:100',
            'password' => 'required|min:6',
        ]);

        $username = strtolower($request->username);
        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $username;
        }
        else{
            $credentials['username'] = $username;
        }
        $credentials['password'] = sha1(md5(hash('gost',$request->password)));
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->stt_aktif == 2){
                LoginData::success();
                $token = Crypt::encrypt($user->anggota);
                return response()->json(['register' => $token]);
            }
            else if($user->stt_aktif == 1){
                if ($user->level == 1 || $user->level == 2){
                    return response()->json(['success' => "Akses berhasil."]);
                }
                else{
                    LoginData::error();
                    $temp = Session::get("_token");
                    Session::flush();
                    Session::put('_token', $temp);
                    Auth::logout();
                    return response()->json(['error' => "Tidak memiliki akses."]);
                }
            }
            else{
                LoginData::error();
                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return response()->json(['error' => "Akun sudah dinonaktifkan."]);
            }
        }
        else{
            if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $exist = User::where('email', $username)->first();
            }
            else{
                $exist = User::where('username', $username)->first();
            }

            if($exist != NULL){
                return response()->json(['error' => "Password salah."]);
            }
            else{
                LoginData::anonym();
                return response()->json(['error' => "Akun tidak ditemukan."]);
            }
        };
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

    public function register(Request $request){
        $request->validate([
            'email' => 'required|max:200|email|unique:App\Models\User,email',
            'password' => 'required|min:6',
            'ulangiPassword' => 'required|min:6',
        ]);

        $email = strtolower($request->email);
        $password = $request->password;
        $confirm = $request->ulangiPassword;

        if($password == $confirm){
            $username = Identity::make('username');
            $anggota = Identity::make('anggota');
            $data['username'] = $username;
            $data['name'] = $username;
            $data['email'] = $email;
            $data['anggota'] = $anggota;
            $data['stt_aktif'] = 2;
            $data['password'] = Hash::make(sha1(md5(hash('gost', $password))));

            try{
                User::create($data);
            }
            catch(\Exception $e){
                return response()->json(['exception' => $e]);
            }
            $token = Crypt::encrypt($anggota);
            return response()->json(['register' => $token]);
        }
        else{
            return response()->json(['error' => "Password tidak cocok."]);
        }
    }

    public function registrasiQR($token){
        $qr = QrCode::size(165)->margin(3)->eyeColor(0, 38,73,92, 196,163,90)->color(196,163,90)->backgroundColor(255,255,255)->generate($token);
        return view('portal.home.registrasi', [
            'qr' => $qr,
            'token' => $token
        ]);
    }

    public function registrasiDownload($token){
        $name = substr($token, 0, 20);
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
