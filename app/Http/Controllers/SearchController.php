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

    public function los($group){
        $data = Group::where('name', $group)->first();
        $data = json_decode($data)->data;
        $data = json_decode($data)->data;
        $data = explode(',', $data);
        $i = 0;
        $dataset = [];
        foreach($data as $d){
            $dataset[$i]['id'] = $d;
            $dataset[$i]['name'] = $d;
            $i++;
        }
        return json_encode($dataset);
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
            $key = $request->q;
            $data = TListrik::select('id', 'code', 'name', 'meter', 'power')
            ->where([['code', 'LIKE', '%'.$key.'%'], ['stt_available', 1]])
            ->orWhere([['name', 'LIKE', '%'.$key.'%'], ['stt_available', 1]])
            ->orWhere([['meter', 'LIKE', '%'.$key.'%'], ['stt_available', 1]])
            ->orWhere([['power', 'LIKE', '%'.$key.'%'], ['stt_available', 1]])
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

    public function country(){
        return response()->json(Country::find(Auth::user()->country_id));
    }
}
