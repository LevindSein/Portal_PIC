<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Group;
use App\Models\Country;
use App\Models\User;
use App\Models\Commodity;
use App\Models\TListrik;
use App\Models\PListrik;
use App\Models\TAirBersih;
use App\Models\PAirBersih;
use App\Models\PKeamananIpk;
use App\Models\PKebersihan;
use App\Models\PAirKotor;
use App\Models\PLain;

class SearchController extends Controller
{
    public function users(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = User::select('id', 'name', 'ktp')
            ->where('name', 'LIKE', '%'.$key.'%')
            ->orWhere('ktp', 'LIKE', '%'.$key.'%')
            ->orderBy('name','asc')
            ->limit(5)
            ->get();
        }
        return response()->json($data);
    }

    public function group(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = Group::select('id', 'name')->where('name', 'LIKE', '%'.$key.'%')->orderBy('name','asc')->get();
        }
        return response()->json($data);
    }

    public function los(Request $request, $group){
        $data = Group::where('name', $group)->first();
        $data = $data->data;
        $data = json_decode($data)->data;
        $data = explode(',', $data);
        if($request->ajax()) {
            $key = preg_quote($request->q, '~');
            $data = preg_grep('~' . $key. '~', $data);

            $i = 0;
            $dataset = [];
            foreach($data as $d){
                $dataset[$i]['id'] = $d;
                $dataset[$i]['name'] = $d;
                $i++;
            }
        }
        return response()->json($dataset);
    }

    public function commodity(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = Commodity::select('id', 'name')->where('name', 'LIKE', '%'.$key.'%')->orderBy('name','asc')->get();
        }
        return response()->json($data);
    }

    public function tlistrik(Request $request){
        $data = [];
        if($request->ajax()) {
            $data = TListrik::select('id', 'code', 'name', 'meter', 'power')
            ->where('stt_available', 1)
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query->where('code', 'LIKE', '%'.$key.'%')
                      ->orWhere('name', 'LIKE', '%'.$key.'%')
                      ->orWhere('power', 'LIKE', '%'.$key.'%')
                      ->orWhere('meter', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('code','asc')
            ->limit(10)
            ->get();
        }
        return response()->json($data);
    }

    public function tairbersih(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = TAirBersih::select('id', 'code', 'name', 'meter')
            ->where('stt_available', 1)
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query->where('code', 'LIKE', '%'.$key.'%')
                      ->orWhere('name', 'LIKE', '%'.$key.'%')
                      ->orWhere('meter', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('code','asc')
            ->limit(10)
            ->get();
        }
        return response()->json($data);
    }

    public function plistrik(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = PListrik::select('id', 'name')->where('name', 'LIKE', '%'.$key.'%')->orderBy('name','asc')->get();
        }
        return response()->json($data);
    }

    public function pairbersih(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = PAirBersih::select('id', 'name')->where('name', 'LIKE', '%'.$key.'%')->orderBy('name','asc')->get();
        }
        return response()->json($data);
    }

    public function pkeamananipk(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = PKeamananIpk::select('id', 'name', 'price')
            ->where('name', 'LIKE', '%'.$key.'%')
            ->orWhere('price', 'LIKE', '%'.$key.'%')
            ->orderBy('name','asc')
            ->get();
        }
        return response()->json($data);
    }

    public function pkebersihan(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = PKebersihan::select('id', 'name', 'price')
            ->where('name', 'LIKE', '%'.$key.'%')
            ->orWhere('price', 'LIKE', '%'.$key.'%')
            ->orderBy('name','asc')
            ->get();
        }
        return response()->json($data);
    }

    public function pairkotor(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = PAirKotor::select('id', 'name', 'price')
            ->where('name', 'LIKE', '%'.$key.'%')
            ->orWhere('price', 'LIKE', '%'.$key.'%')
            ->orderBy('name','asc')
            ->get();
        }
        return response()->json($data);
    }

    public function plain(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = PLain::select('id', 'name', 'price')
            ->where('name', 'LIKE', '%'.$key.'%')
            ->orWhere('price', 'LIKE', '%'.$key.'%')
            ->orderBy('name','asc')
            ->get();
        }
        return response()->json($data);
    }

    public function country(){
        return response()->json(Country::find(Auth::user()->country_id));
    }
}
