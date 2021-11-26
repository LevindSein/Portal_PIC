<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;
use App\Models\Country;

use Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('portal.profile.index');
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
                'uid' => 'required|max:50|alpha_dash|unique:App\Models\User,uid,'.Auth::user()->id,
                'email' => 'required|max:200|email|unique:App\Models\User,email,'.Auth::user()->id,
                'name' => 'required|max:100',
                'ktp' => 'required|numeric|digits_between:7,16|unique:App\Models\User,ktp,'.Auth::user()->id,
                'npwp' => 'nullable|numeric|digits_between:15,15|unique:App\Models\User,npwp,'.Auth::user()->id,
                'country' => 'required|string|min:2|max:2',
                'phone' => 'required|numeric|digits_between:8,15|unique:App\Models\User,phone,'.Auth::user()->id,
                'address' => 'required|max:255',
                'password' => 'required|min:6|alpha_dash',
                'passwordNew' => 'nullable|min:6|alpha_dash',
            ]);

            $uid = strtolower($request->uid);
            $name = $request->name;
            $email = strtolower($request->email);

            $country = $request->country;
            $country = Country::where('iso', $country)->first();
            if(!is_null($country)){
                $country = $country->id;
            }
            else{
                return response()->json(['error' => "Country code not found."]);
            }

            $phone = $request->phone;
            if(substr($phone,0,1) == "0"){
                return response()->json(['warning' => "Whatsapp number incorrect."]);
            }

            $ktp = $request->ktp;
            $npwp = $request->npwp;
            $address = $request->address;
            $password = $request->password;
            $passwordNew = $request->passwordNew;

            try{
                $user = User::findOrFail(Auth::user()->id);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => "User not found."]);
            }

            $user->uid = $uid;
            $user->name = $name;
            if($user->email != $email){
                $user->email_verified_at = NULL;
            }
            $user->email = $email;
            $user->country_id = $country;
            $user->phone = $phone;
            $user->ktp = $ktp;
            $user->npwp = $npwp;
            $user->address = $address;

            if (Hash::check(sha1(md5(hash('gost',$password))), $user->password)) {
                if(!is_null($passwordNew)){
                    $user->password = Hash::make(sha1(md5(hash('gost',$passwordNew))));
                    $user->save();
                }
                else{
                    $user->save();
                }
            }
            else{
                return response()->json(['error' => 'Password incorrect.']);
            }

            return response()->json(['success' => 'Data saved.', 'description' => 'success']);
        }
        else{
            abort(404);
        }
    }

    public function picture(Request $request){
        $request->validate([
            'pictureInput' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        try{
            $user = User::find(Auth::user()->id);
        }catch(ModelNotFoundException $e){
            return redirect('profile')->with('error', "User not found.");
        }

        if($request->hasFile('pictureInput')){
            cache()->flush();

            $image = $request->file('pictureInput');

            $image = Image::make($image)->resize(500,500)->encode('png', 75);

            $image_name = Auth::user()->id;
            $image_full_name = "users/" . $image_name . '.png';
            $location = storage_path('app/public/' . $image_full_name);
            $image->save($location);

            $data = $image_full_name;
            $user->photo = "storage/" . $data;
            $user->save();

            return redirect('profile')->with('success', 'Profile picture changed.');
        }
        else{
            return redirect('profile')->with('error', 'File not detected.');
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
