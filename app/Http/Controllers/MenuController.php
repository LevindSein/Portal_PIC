<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;

class MenuController extends Controller
{
    public function index()
    {
        $string = '<li class="nav-item"><a class="nav-link' .  (request()->is("dashboard*")) ? "active font-weight-bold" : '' . '" href="' . url("dashboard") . '"><i class="fas fa-fw fa-tachometer-alt text-primary mr-2"></i><span class="nav-link-text">Dashboard</span></a></li>';
        return $string;
    }
}
