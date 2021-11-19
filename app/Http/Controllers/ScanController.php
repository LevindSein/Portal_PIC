<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\KodeAktivasi;

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
        $anggota = $explode[0];
        $available = $explode[1];

        $now = Carbon::now()->toDateTimeString();

        if($now > $available){
            abort(404);
        }
        else{
            $user = User::where('anggota', $anggota)->first();
            if($user != NULL){
                if($type == 'pendaftaran'){
                    $nama = $user->name;
                    return view('portal.scan.pendaftaran',[
                        'nama' => $nama,
                        'anggota' => $anggota,
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

    public function scanningQRPendaftaran(Request $request){
        $data = $request->data_hidden;
        $aktivasi = $request->aktivasi;
        try {
            $decrypted = Crypt::decrypt($data);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Data tidak valid.']);
        }

        $explode = explode("+", $decrypted);
        $anggota = $explode[0];
        $available = $explode[1];
        $now = Carbon::now()->toDateTimeString();

        if($now > $available){
            return response()->json(['error' => "Data expired $available."]);
        }
        else{
            $kode = KodeAktivasi::where([['kode', $aktivasi],['submit',0]])->first();
            if($kode != NULL){
                $user = User::where('anggota',$anggota)->first();
                if($user != NULL){
                    $user->kode_aktivasi = $aktivasi;
                    $user->save();
                }
                $kode->submit = 1;
                $kode->save();
            }
            else{
                return response()->json(['error' => 'Kode aktivasi tidak valid.']);
            }

            return response()->json(['success' => 'Kode aktivasi terkirim.']);
        }
    }
}
