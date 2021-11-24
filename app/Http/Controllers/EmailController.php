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
            if(is_null($emailExist)){
                return response()->json(['warning' => "Please fill your email.", 'description' => 'warning']);
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
                        'url' => url('email/verify/resend/'.$user->level.'/'.$user->active.'/'.Crypt::encrypt($user->member . "+" . Carbon::now()->addDays(2)->toDateTimeString())),
                        'regards' => "Selamat Berniaga (PIC BDG Team)",
                        'timestamp' => Carbon::now()->toDateTimeString(),
                        'value' => 'resend',
                    ];
                    dispatch(new \App\Jobs\VerifyEmailJob($details));
                }
                catch(\Exception $e){
                    return response()->json(['error' => 'Email failed to send.', 'description' => $e]);
                }
                return response()->json(['success' => "Please check your email."]);
            }
        }
        else{
            abort(404);
        }
    }

    public function verifyResend($level, $aktif, $member){
        try {
            $decrypted = Crypt::decrypt($member);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        $explode = explode("+",$decrypted);
        $member = $explode[0];
        $expired = $explode[1];

        $now = Carbon::now()->toDateTimeString();

        if($now > $expired){
            abort(404);
        }
        else{
            $user = User::where('member', $member)->first();

            if(!is_null($user)){
                if($user->level == $level && $user->active == $aktif){
                    $user->email_verified_at = Carbon::now()->toDateTimeString();
                    $user->save();
                }
                else{
                    abort(404);
                }
                return redirect('email/verified');
            }
            else{
                abort(404);
            }
        }
    }

    public function verify($level, $member){
        try {
            $decrypted = Crypt::decrypt($member);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        $explode = explode("+",$decrypted);
        $member = $explode[0];
        $expired = $explode[1];

        $now = Carbon::now()->toDateTimeString();

        if($now > $expired){
            abort(404);
        }
        else{
            $user = User::where("member", $member)->first();

            if(!is_null($user)){
                if($user->level == $level){
                    $user->email_verified_at = Carbon::now()->toDateTimeString();
                    $user->save();
                }
                else{
                    abort(404);
                }
                return redirect('email/verified');
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

                if(!is_null($user)){
                    try{
                        $details = [
                            'sender' => "Admin dari PIC",
                            'header' => "Reset Password",
                            'subject' => "Reset Password",
                            'name' => $user->name,
                            'role' => User::level($user->level),
                            'type' => "reset password",
                            'button' => "Reset",
                            'url' => url('email/forgot/'.$user->level.'/'.Crypt::encrypt($user->member . "+" . Carbon::now()->addDays(2)->toDateTimeString())),
                            'regards' => "Selamat Berniaga (PIC BDG Team)",
                            'email' => $email,
                            'timestamp' => Carbon::now()->toDateTimeString(),
                            'value' => 'forgot',
                        ];
                        dispatch(new \App\Jobs\VerifyEmailJob($details));
                    }
                    catch(\Exception $e){
                        return response()->json(['error' => "Email failed to send", 'description' => $e]);
                    }
                    return response()->json(['success' => 'Please check your email.']);
                }
                else{
                    return response()->json(['error' => "Account not found."]);
                }
            }
            else{
                $request->validate([
                    'password' => 'required|min:6',
                ]);

                $password = $request->password;
                $hidden = $request->password_hidden;

                try {
                    $decrypted = Crypt::decrypt($hidden);
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    return response()->json(['error' => 'Data invalid.', 'description' => $e]);
                }

                $explode = explode("+",$decrypted);
                $member = $explode[0];
                $expired = $explode[1];

                $now = Carbon::now()->toDateTimeString();

                if($now > $expired){
                    return response()->json(['error' => 'Data expired.']);
                }
                else{
                    $user = User::where('member', $member)->first();

                    if(!is_null($user)){
                        $user->password = Hash::make(sha1(md5(hash('gost', $password))));
                        $user->save();
                    }
                    else{
                        return response()->json(['error' => 'Account not found.']);
                    }
                }

                return response()->json(['success' => 'Password has been changed.', 'description' => 'success']);
            }
        }
        else{
            abort(404);
        }
    }

    public function forgotVerify($level, $member){
        return redirect('email/forgot/reset')->with([
            'member' => $member
        ]);
    }
}
