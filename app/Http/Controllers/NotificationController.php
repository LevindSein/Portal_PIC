<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function billReviews(){
        if(request()->ajax()){
            return response()->json(['success' => 'reviewed']);
        }
        else{
            abort(404);
        }
    }
}
