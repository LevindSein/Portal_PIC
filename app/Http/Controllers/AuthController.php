<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

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
            Session::put('level', Auth::user()->level);
            return redirect('dashboard')->with('success',"Selamat Datang.");
        }
        else{
            return view('welcome')->with('info', 'Silakan Login.');
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
        if($request->ajax()){
            $input['username'] = strtolower($request->username);
            $input['password'] = $request->password;

            Validator::make($input, [
                'username' => 'required|max:100|exists:users,username',
                'password' => 'required|min:6',
            ])->validate();

            $credentials['username'] = $input['username'];
            $credentials['password'] = sha1(md5(hash('gost', $input['password'])));
            $credentials['status']   = 1;

            if(Auth::attempt($credentials)) {
                $user = Auth::user();
                if (($user->level == (1 || 2 || 3 || 4 || 5))){
                    return response()->json(['success' => "Akses Sukses."]);
                }

                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return response()->json(['error' => "Akses Gagal."]);
            }
            else{
                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return response()->json(['error' => "Username / Password Salah."]);
            }
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


    public function logout()
    {
        $temp = Session::get("_token");
        Session::flush();
        Session::put('_token', $temp);
        Auth::logout();
        return response()->json(['success' => 'Logout berhasil.']);
    }

    public function check(){
        if(! Auth::check()){
            return response()->json(['logout' => 'y']);
        }

        return response()->json(['success' => '.']);
    }
}
