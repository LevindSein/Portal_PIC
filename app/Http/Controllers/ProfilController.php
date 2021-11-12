<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;

use Image;
use Carbon\Carbon;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('portal.profil.index');
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
            $request->validate([
                'username' => 'required|max:50|alpha_dash',
                'email' => 'required|max:100|email',
                'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
                'ktp' => 'required|numeric|digits_between:16,16',
                'npwp' => 'nullable|numeric|digits_between:15,15',
                'phone' => 'nullable|numeric|digits_between:12,15',
                'alamat' => 'required|max:255',
                'password' => 'required|min:6|alpha_dash',
                'passwordBaru' => 'nullable|min:6|alpha_dash',
                'konfirmasiPasswordBaru' => 'nullable|min:6|alpha_dash',
            ]);

            $username = strtolower($request->username);
            $name = $request->name;
            $email = strtolower($request->email);
            $phone = $request->phone;
            if(substr($phone,0,1) == "0"){
                return response()->json(['error' => "Nomor Whatsapp"]);
            }
            $ktp = $request->ktp;
            $npwp = $request->npwp;
            $alamat = $request->alamat;
            $password = $request->password;
            $passwordBaru = $request->passwordBaru;
            $konfirmasiPasswordBaru = $request->konfirmasiPasswordBaru;

            try{
                $user = User::findOrFail(Auth::user()->id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            $user->username = $username;
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->ktp = $ktp;
            $user->npwp = $npwp;
            $user->alamat = $alamat;

            if (Hash::check(sha1(md5(hash('gost',$password))), $user->password)) {
                if($passwordBaru != NULL && $passwordBaru === $konfirmasiPasswordBaru){
                    $user->password = Hash::make(sha1(md5(hash('gost',$passwordBaru))));
                    $user->save();
                }
                else if($passwordBaru != $konfirmasiPasswordBaru){
                    return response()->json(['error' => 'Password baru tidak cocok.']);
                }
                else{
                    $user->save();
                }
            }
            else{
                return response()->json(['error' => 'Password saat ini salah.']);
            }

            return response()->json(['success' => 'Data berhasil disimpan.']);
        }
        else{
            return response()->json(['error' => '404 Not Found.']);
        }
    }

    public function fotoProfil(Request $request){
        $request->validate([
            'fotoInput' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        try{
            $user = User::find(Auth::user()->id);
        }catch(ModelNotFoundException $e){
            return redirect('profil')->with('error', 'Profil tidak ditemukan.');
        }

        if($request->hasFile('fotoInput')){
            cache()->flush();

            $image = $request->file('fotoInput');

            $image = Image::make($image)->resize(500,500)->encode('png', 75);

            $image_name = Auth::user()->id;
            $image_full_name = "users/" . $image_name . '.png';
            $location = storage_path('app/public/' . $image_full_name);
            $image->save($location);

            $data = $image_full_name;
            $user->foto = "storage/" . $data;
            $user->save();

            return redirect('profil')->with('success', 'Foto profil diganti.');
        }
        else{
            return redirect('profil')->with('error', 'File tidak terdeteksi.');
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
}
