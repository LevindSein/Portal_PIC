<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

use App\Models\AuthenticationLog;
use App\Models\User;

use Carbon\Carbon;

use Excel;
use DataTables;


class ActivityController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = AuthenticationLog::with('user');

            return DataTables::of($data)
            ->editColumn('user.username', function($data){
                $name = $data->user->username;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='" . $data->user->username . "'>$name</span>";
            })
            ->editColumn('user.name', function($data){
                $name = $data->user->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='" . $data->user->name . "'>$name</span>";
            })
            ->editColumn('user.level', function($data){
                $badge = User::badgeLevel($data->user->level);
                $button = '<span class="badge badge-md '. $badge . '">' . User::level($data->level) . '</span>';
                return $button;
            })
            ->editColumn('login_successful', function($data){
                if($data->login_successful){
                    $button = '<span class="badge badge-md badge-success">Success</span>';
                } else {
                    $button = '<span class="badge badge-md badge-danger">Failed</span>';
                }
                return $button;
            })
            ->addColumn('action', function($data){
                $button = '';
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->rawColumns(['user.username', 'user.name', 'user.level', 'login_successful', 'action'])
            ->make(true);
        }

        return view('Activity.index');
    }
}
