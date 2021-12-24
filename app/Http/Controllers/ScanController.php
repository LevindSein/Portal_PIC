<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\ActivationCode;

use Carbon\Carbon;

class ScanController extends Controller
{
    public function scanQR($type, $data){
        try {
            $decrypted = Crypt::decrypt($data);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        $explode = explode('+', $decrypted);
        $member = $explode[0];
        $available = $explode[1];

        $now = Carbon::now()->toDateTimeString();

        if($now > $available){
            return redirect('expired')->with('error', 'Data register expired.');
        }
        else{
            $user = User::where('member', $member)->first();
            if($user){
                if($type == 'register'){
                    $nama = $user->name;
                    return redirect('register')->with([
                        'nama' => $nama,
                        'member' => $member,
                        'data' => $data,
                    ]);
                }
                else{
                    abort(404);
                }
            }
            else{
                abort(404);
            }
        }
    }

    public function scanQrRegister(Request $request){
        $data = $request->data_hidden;
        $activation = $request->activation;
        try {
            $decrypted = Crypt::decrypt($data);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Data invalid.']);
        }

        $explode = explode("+", $decrypted);
        $member = $explode[0];
        $available = $explode[1];
        $now = Carbon::now()->toDateTimeString();

        if($now < $available){
            $code = ActivationCode::where([['code', $activation],['submit',0]])->first();
            if($code && $now < $code->available){
                $user = User::where('member',$member)->first();
                if($user){
                    $user->activation_code = $activation;

                    try{
                        $user->save();
                    } catch(\Exception $e){
                        return response()->json(['error' => "Data failed to sent.", 'description' => $e]);
                    }
                }
                $code->submit = 1;

                try{
                    $code->save();
                } catch(\Exception $e){
                    return response()->json(['error' => "Data failed to sent.", 'description' => $e]);
                }
            }
            else{
                return response()->json(['error' => 'Activation code invalid.']);
            }

            return response()->json(['success' => "Activation code sent."]);
        }
        else{
            return response()->json(['error' => "Data register expired at $available."]);
        }
    }
}
