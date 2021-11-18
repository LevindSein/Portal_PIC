<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\KodeAktivasi;

use Carbon\Carbon;

class ScanController extends Controller
{
    public function register(Request $request){
        $qr = $request->qr;
        $kode = $request->aktivasi;

        try {
            $decrypted = Crypt::decrypt($qr);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        $explode = explode("+", $decrypted);
        $anggota = $explode[0];
        $available = $explode[1];
        $now = Carbon::now()->toDateTimeString();

        if($now > $available){
            abort(404);
        }
        else{
            $user = User::where('anggota',$anggota)->first();
            if($user != NULL){
                $user->kode_aktivasi = $kode;
                $user->save();
            }
            $kode = KodeAktivasi::where('kode', $kode)->first();
            $kode->submit = 1;
            $kode->save();
        }
    }
}
