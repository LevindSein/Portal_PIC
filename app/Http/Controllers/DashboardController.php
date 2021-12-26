<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(){
        Session::put('lastPlace', 'dashboard');
        return view('portal.dashboard.index');
    }
}
