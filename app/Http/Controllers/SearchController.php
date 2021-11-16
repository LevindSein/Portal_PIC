<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Blok;

class SearchController extends Controller
{
    public function blok(Request $request){
        $blok = [];
        if($request->ajax()) {
            $key = $request->q;
            $blok = Blok::select('id', 'nama')->where('nama', 'LIKE', '%'.$key.'%')->orderBy('nama','asc')->limit(50)->get();
        }
        return response()->json($blok);
    }
}
