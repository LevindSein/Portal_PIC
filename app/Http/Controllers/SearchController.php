<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Group;
use App\Models\Alat;
use App\Models\Tarif;
use App\Models\Tempat;

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

    public function alat(Request $request){
        $data = [];
        if($request->ajax()) {
            $level = $request->level;
            $data = Alat::where([['level', $level], ['status', 1]])
            ->where(function ($query) use ($request, $level) {
                $key = $request->q;
                if($level == 1){
                    $query
                    ->where('name', 'LIKE', '%'.$key.'%')
                    ->orWhere('stand', 'LIKE', '%'.$key.'%')
                    ->orWhere('daya', 'LIKE', '%'.$key.'%');
                } else {
                    $query
                    ->where('name', 'LIKE', '%'.$key.'%')
                    ->orWhere('stand', 'LIKE', '%'.$key.'%');
                }
            })
            ->orderBy('id','desc')
            ->limit(5)
            ->get();
        }
        return response()->json($data);
    }

    public function tarif(Request $request){
        $data = [];
        if($request->ajax()) {
            $level = $request->level;
            $data = Tarif::where('level', $level)
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query->where('name', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('name','asc')
            ->limit(5)
            ->get();
        }
        return response()->json($data);
    }

    public function tempat(Request $request){
        $data = [];
        if($request->ajax()) {
            $data = Tempat::where('status', 1)->select('id', 'name', 'nicename')
            ->where(function ($query) use ($request) {
                $key = $request->q;
                $query
                ->where('name', 'LIKE', '%'.$key.'%')
                ->orWhere('nicename', 'LIKE', '%'.$key.'%');
            })
            ->orderBy('name','asc')
            ->limit(5)
            ->get();
        }
        return response()->json($data);
    }

    public function stand($id){
        $data = [];
        if(request()->ajax()) {
            $data = Alat::findOrFail($id);
        }
        return response()->json($data);
    }
}
