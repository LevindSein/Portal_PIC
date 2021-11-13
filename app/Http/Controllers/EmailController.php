<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;

use App\Mail\ResendEmail;

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
                return response()->json(['error' => "Email belum tersedia."]);
            }
            else{
                try{
                    $data = [
                        'sender' => "Admin dari PIC",
                        'header' => "Silakan Verifikasi Email Anda",
                        'subject' => "Resend Email Verification",
                        'name' => $user->name,
                        'type' => "verifikasi",
                        'button' => "Verifikasi",
                        'url' => url('email/verify/resend/'.$user->level.'/'.$user->stt_aktif.'/'.Crypt::encrypt($user->anggota)),
                        'regards' => "Selamat Berniaga (PIC BDG Team)",
                    ];
                    Mail::to($user->email)->send(new ResendEmail($data));
                }
                catch(\Exception $e){
                    return response()->json(['exception' => $e]);
                }
            }

            return response()->json(['success' => "Silakan perikasa email anda."]);
        }
        else{
            return response()->json(['error' => '404 Not Found']);
        }
    }

    public function verifyResend($level, $aktif, $anggota){
        try {
            $anggota = Crypt::decrypt($anggota);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(500);
        }

        $user = User::where("anggota", $anggota)->first();
        if($user->level == $level && $user->stt_aktif == $aktif){
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->save();
        }
        else{
            abort(404);
        }
        return view('email.verified');
    }

    public function verify($level, $anggota){
        try {
            $anggota = Crypt::decrypt($anggota);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(500);
        }

        $user = User::where("anggota", $anggota)->first();
        if($user->level == $level){
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->save();
        }
        else{
            abort(404);
        }
        return view('email.verified');
    }
}
