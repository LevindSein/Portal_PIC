<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request){
        return "$request->data";
    }
}
