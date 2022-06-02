<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Group;

class SearchController extends Controller
{
    public function users(Request $request){
        $data = [];
        if($request->ajax()) {
            $data = User::select('id', 'name', 'ktp')
            ->where('level', 6)
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query
                ->where('name', 'LIKE', '%'.$key.'%')
                ->orWhere('ktp', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('name','asc')
            ->limit(5)
            ->get();
        }
        return response()->json($data);
    }

    public function groups(Request $request){
        $data = [];
        if($request->ajax()) {
            $data = Group::select('id', 'name', 'blok', 'nicename', 'nomor')
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query
                ->where('name', 'LIKE', '%'.$key.'%')
                ->orWhere('nicename', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('blok', 'asc')
            ->orderByRaw('LENGTH(nicename), nicename')
            ->orderBy('nomor', 'asc')
            ->limit(5)
            ->get();
        }
        return response()->json($data);
    }

    public function los(Request $request, $name){
        $data = [];
        if($request->ajax()) {
            $group = Group::where('name', $name)->first();
            if($group->data){
                $los = json_decode($group->data);
                foreach($los as $key){
                    if($request->q){
                        if(stripos($key, $request->q)){
                            $data[] = $key;
                        }
                    } else {
                        $data[] = $key;
                    }
                }
            }
        }
        return response()->json($data);
    }
}
