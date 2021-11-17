<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Carbon\Carbon;

class EmailController extends Controller
{
    public function resend(Request $request)
    {
        if(request()->ajax()){
            $user = Auth::user();
            $id = $user->id;
            $emailExist = User::find($id)->email;
            if($emailExist == NULL){
                return response()->json(['warning' => "Email belum tersedia."]);
            }
            else{
                try{
                    $details = [
                        'sender' => "Admin dari PIC",
                        'header' => "Silakan Verifikasi Email Anda",
                        'subject' => "Resend Email Verification",
                        'name' => $user->name,
                        'email' => $user->email,
                        'type' => "verifikasi",
                        'button' => "Verifikasi",
                        'url' => url('email/verify/resend/'.$user->level.'/'.$user->stt_aktif.'/'.Crypt::encrypt($user->anggota . "+" . Carbon::now()->addDays(2)->toDateTimeString())),
                        'regards' => "Selamat Berniaga (PIC BDG Team)",
                        'timestamp' => Carbon::now()->toDateTimeString(),
                        'value' => 'resend',
                    ];
                    dispatch(new \App\Jobs\VerifyEmailJob($details));
                }
                catch(\Exception $e){
                    return response()->json(['exception' => $e]);
                }
            }

            return response()->json(['success' => "Silakan perikasa email anda."]);
        }
        else{
            abort(404);
        }
    }

    public function verifyResend($level, $aktif, $anggota){
        try {
            $anggota = Crypt::decrypt($anggota);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        $explode = explode("+",$anggota);
        $anggota = $explode[0];
        $expired = $explode[1];

        $now = Carbon::now()->toDateTimeString();

        if($now > $expired){
            abort(404);
        }
        else{
            $user = User::where('anggota', $anggota)->first();

            if($user != NULL){
                if($user->level == $level && $user->stt_aktif == $aktif){
                    $user->email_verified_at = Carbon::now()->toDateTimeString();
                    $user->save();
                }
                else{
                    abort(404);
                }
                return view('email.verified');
            }
            else{
                abort(404);
            }
        }
    }

    public function verify($level, $anggota){
        try {
            $anggota = Crypt::decrypt($anggota);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        $explode = explode("+",$anggota);
        $anggota = $explode[0];
        $expired = $explode[1];

        $now = Carbon::now()->toDateTimeString();

        if($now > $expired){
            abort(404);
        }
        else{
            $user = User::where("anggota", $anggota)->first();

            if($user != NULL){
                if($user->level == $level){
                    $user->email_verified_at = Carbon::now()->toDateTimeString();
                    $user->save();
                }
                else{
                    abort(404);
                }
                return view('email.verified');
            }
            else{
                abort(404);
            }
        }
    }

    public function forgot(){
        return view('email.forgot');
    }

    public function forgotStore(Request $request, $data){
        if($request->ajax()){
            if($data == 'email'){
                $request->validate([
                    'email' => 'required|max:100|email',
                ]);

                $email = $request->email;

                $user = User::where('email', $email)->first();

                if($user != NULL){
                    try{
                        $details = [
                            'sender' => "Admin dari PIC",
                            'header' => "Recover Password",
                            'subject' => "Recover Password",
                            'name' => $user->name,
                            'role' => User::level($user->level),
                            'type' => "pemulihan",
                            'button' => "Pulihkan",
                            'url' => url('email/forgot-password/'.$user->level.'/'.Crypt::encrypt($user->anggota . "+" . Carbon::now()->addDays(2)->toDateTimeString())),
                            'regards' => "Selamat Berniaga (PIC BDG Team)",
                            'email' => $email,
                            'timestamp' => Carbon::now()->toDateTimeString(),
                            'value' => 'forgot',
                        ];
                        dispatch(new \App\Jobs\VerifyEmailJob($details));
                    }
                    catch(\Exception $e){
                        return response()->json(['exception' => $e]);
                    }
                    return response()->json(['success' => 'Silakan periksa email Anda.']);
                }
                else{
                    return response()->json(['error' => "Akun tidak ditemukan."]);
                }
            }
            else{
                $request->validate([
                    'password' => 'required|min:6',
                ]);

                $password = $request->password;
                $hidden = $request->password_hidden;

                try {
                    $data = Crypt::decrypt($hidden);
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    return response()->json(['error' => 'Data tidak valid.']);
                }

                $explode = explode("+",$data);
                $anggota = $explode[0];
                $expired = $explode[1];

                $now = Carbon::now()->toDateTimeString();

                if($now > $expired){
                    return response()->json(['error' => 'Data expired.']);
                }
                else{
                    $user = User::where('anggota', $anggota)->first();

                    if($user != NULL){
                        $user->password = Hash::make(sha1(md5(hash('gost', $password))));
                        $user->save();
                    }
                    else{
                        return response()->json(['error' => 'Akun tidak ditemukan.']);
                    }
                }

                return response()->json(['success' => 'Akun berhasil dipulihkan.']);
            }
        }
        else{
            abort(404);
        }
    }

    public function forgotVerify($level, $anggota){
        return view('email.forgot-recover',[
            'anggota' => $anggota
        ]);
    }
}
