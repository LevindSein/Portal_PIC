<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
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
            $data = AuthenticationLog::with('user:id,username,name,level')->get();

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
                $button = '<span class="badge badge-md '. $badge . '">' . User::level($data->user->level) . '</span>';
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
            ->addColumn('jml', function($data){
                $start = $data->login_at;
                $end = Carbon::now();
                if($data->logout_at){
                    $end = $data->logout_at;
                }

                return ActivityLog::where('causer_id', $data->user->id)
                ->whereBetween('updated_at', [$start, $end])
                ->count();
            })
            ->addColumn('action', function($data){
                $button = '';
                if($data->login_successful){
                    $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                }
                return $button;
            })
            ->rawColumns(['user.username', 'user.name', 'user.level', 'login_successful', 'action'])
            ->make(true);
        }

        return view('Activity.index');
    }

    public function show($id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = AuthenticationLog::with('user')->findOrFail($decrypted);

            $data['level'] = User::level($data->user->level);

            $start = $data->login_at;
            $end = Carbon::now();
            if($data->logout_at){
                $end = $data->logout_at;
            }

            $data['activity'] = ActivityLog::where('causer_id', $data->user->id)
            ->whereBetween('updated_at', [$start, $end])
            ->count();

            return response()->json(['success' => $data]);
        }
    }

    public function print($id){
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => "Data tidak valid."]);
        }

        $data = AuthenticationLog::with('user')->findOrFail($decrypted);

        $start = $data->login_at;
        $end = Carbon::now();
        if($data->logout_at){
            $end = $data->logout_at;
        }

        $username = $data->user->username;
        $name     = $data->user->name;
        $level    = User::level($data->user->level);

        $activities = ActivityLog::where('causer_id', $data->user->id)
        ->whereBetween('updated_at', [$start, $end])
        ->get();

        return view('Activity.Pages._print', [
            'start'    => $start,
            'end'      => $end,
            'username' => $username,
            'name'     => $name,
            'level'    => $level,
            'data'     => $activities
        ]);
    }
}
