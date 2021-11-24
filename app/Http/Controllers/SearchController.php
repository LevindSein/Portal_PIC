<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;

class SearchController extends Controller
{
    public function init(Request $request){
        $data = [];
        if($request->ajax()) {
            $key = $request->q;
            $data = Group::select('id', 'name')->where('name', 'LIKE', '%'.$key.'%')->orderBy('name','asc')->limit(50)->get();
        }
        return response()->json($data);
    }
}
