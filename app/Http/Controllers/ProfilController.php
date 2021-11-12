<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Image;

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
        $request->validate([
            'fotoInput' => 'nullable|image|mimes:jpeg,png,jpg',
            'username' => 'required|max:50|alpha_dash',
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|max:100|email',
            'phone' => 'nullable|numeric|digits_between:10,15',
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
            return redirect('profil')->with('warning', 'Nomor diawali 62 atau kode negara.');
        }
        $alamat = $request->alamat;
        $password = $request->password;
        $passwordBaru = $request->passwordBaru;
        $konfirmasiPasswordBaru = $request->konfirmasiPasswordBaru;

        try{
            $user = User::find(Auth::user()->id);
            $user->username= $username;
            $user->name= $name;
            $user->email= $email;
            $user->phone= $phone;
            $user->alamat = $alamat;

            if($request->hasFile('fotoInput')){
                $image = $request->file('fotoInput');

                $image = Image::make($image)->resize(500,500)->encode('png', 75);

                $image_name = Auth::user()->id;
                $image_full_name = "users/" . $image_name . '.png';
                $location = storage_path('app/public/' . $image_full_name);
                $image->save($location);

                $data = $image_full_name;
                $user->foto = "storage/" . $data;
            }

            if (Hash::check(md5($password), $user->password)) {
                if($passwordBaru != NULL && $passwordBaru === $konfirmasiPasswordBaru){
                    $user->password = Hash::make(md5($passwordBaru));
                    $user->save();
                }
                else if($passwordBaru != $konfirmasiPasswordBaru){
                    return redirect('profil')->with('error','Konfirmasi Password baru tidak cocok.');
                }
                else{
                    $user->save();
                }
            }
            else{
                return redirect('profil')->with('error','Password saat ini salah.');
            }
        }
        catch(\Exception $e){
            return redirect('profil')->with('error','Update profil gagal.');
        }

        return redirect('profil')->with('success','Update profil berhasil.');
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
