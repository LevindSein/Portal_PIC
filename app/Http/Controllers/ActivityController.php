<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

use App\Models\AuthenticationLog;
use App\Models\ActivityLog;
use App\Models\User;

use Carbon\Carbon;

use DataTables;


class ActivityController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $data = AuthenticationLog::with('user:id,username,name,level')->get();

            return DataTables::of($data)
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
            ->addColumn('longtime', function($data){
                $start = new Carbon($data->login_at);
                if($data->logout_at){
                    $end = new Carbon($data->logout_at);
                } else {
                    $end = Carbon::now();
                }

                $totalDuration = $end->diffInSeconds($start);

                return gmdate('H:i:s', $totalDuration);
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
            ->rawColumns(['user.name', 'user.level', 'login_successful', 'longtime', 'action'])
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

    public function print(Request $request){
        //Validator
        $input['dari'] = Carbon::parse($request->dari_times)->format('Y-m-d H:i:s');
        $input['ke']   = Carbon::parse($request->ke_times)->format('Y-m-d H:i:s');

        if($input['dari'] > $input['ke']){
            $c = $input['ke'];
            $input['ke']   = $input['dari'];
            $input['dari'] = $c;
        }

        Validator::make($input, [
            'dari' => 'required|date_format:Y-m-d H:i:s',
            'ke'   => 'required|date_format:Y-m-d H:i:s',
        ])->validate();
        //End Validator

        $data = ActivityLog::with('user')->whereBetween('updated_at', [$input['dari'], $input['ke']])->get();

        return view('Activity.Pages._print', [
            'dari'  => $input['dari'],
            'ke'    => $input['ke'],
            'data'  => $data
        ]);
    }

    public function print1($id){
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

        return view('Activity.Pages._print1', [
            'start'    => $start,
            'end'      => $end,
            'username' => $username,
            'name'     => $name,
            'level'    => $level,
            'data'     => $activities
        ]);
    }
}
