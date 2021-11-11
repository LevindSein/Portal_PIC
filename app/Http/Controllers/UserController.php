<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DataTables;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            $data = User::where([['level','2'],['stt_aktif','!=','0']])->select('id','username','name','stt_aktif');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" data-original-title="Reset Password" name="reset" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" data-original-title="Edit" name="edit" id="'.Crypt::encryptString($data->id).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" data-original-title="Hapus" name="delete" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('stt_aktif', function($data){
                    if($data->stt_aktif == 1){
                        $button = '<span style="color:#36bea6;">Aktif</span>';
                    }
                    else if($data->stt_aktif == 2){
                        $button = '<span style="color:#2962FF;">Terdaftar</span>';
                    }
                    return $button;
                })
                ->rawColumns(['action','show','stt_aktif'])
                ->make(true);
        }
        return view('portal.user.index');
    }

    public function level($level)
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            $data = User::where([['level',$level],['stt_aktif','!=','0']])->select('id','username','name','stt_aktif');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" title="Reset Password" name="reset" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encryptString($data->id).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Hapus" name="delete" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('stt_aktif', function($data){
                    if($data->stt_aktif == 1){
                        $button = '<span style="color:#36bea6;">Aktif</span>';
                    }
                    else if($data->stt_aktif == 2){
                        $button = '<span style="color:#2962FF;">Terdaftar</span>';
                    }
                    return $button;
                })
                ->rawColumns(['action','show','stt_aktif'])
                ->make(true);
        }
    }

    public function penghapusan($level)
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah, 4 = Kasir, 5 = Keuangan, 6 = Manajer
        if(request()->ajax())
        {
            $data = User::where([['level', $level],['stt_aktif','0']])->select('id','username','name','stt_aktif');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" title="Restore" name="restore" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="restore"><i class="fas fa-undo" style="color:#4e73df;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->editColumn('stt_aktif', function($data){
                    $button = '<span style="color:#e74a3b;">Nonaktif</span>';
                    return $button;
                })
                ->rawColumns(['action','show','stt_aktif'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(request()->ajax()){
            return response()->json(['success' => 'Data berhasil disimpan.']);
        }
        else{
            return response()->json(['error' => '404 Not Found']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(request()->ajax()){
            $id = Crypt::decryptString($id);
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            if($user->nonaktif != NULL){
                $json = json_decode($user->nonaktif, true);

                $history = count($json);
                if($history > 5){
                    $length = $history - 5;
                    array_splice($json, 0, $length);
                }

                // Get last id
                $last_item    = end($json);
                $last_item_id = $last_item['id'];

                $id = ++$last_item_id;
            }
            else{
                $id = 1;
            }

            $json[] = array(
                'id' => $id,
                'status' => 'nonaktif',
                'stt_aktif' => $user->stt_aktif,
                'anggota' => Auth::user()->anggota,
                'timestamp' => Carbon::now()->toDateTimeString(),
            );
            $nonaktif = json_encode($json);

            $user->stt_aktif = 0;
            $user->nonaktif = $nonaktif;
            $user->save();

            return response()->json(['success' => 'Data berhasil dihapus.']);
        }
        else{
            return response()->json(['error' => '404 Not Found.']);
        }
    }

    public function restore($id)
    {
        if(request()->ajax()){
            $id = Crypt::decryptString($id);
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }

            if($user->nonaktif != NULL){
                $json = json_decode($user->nonaktif, true);

                $history = count($json);
                if($history > 5){
                    $length = $history - 5;
                    array_splice($json, 0, $length);
                }

                // Get last id
                $last_item    = end($json);
                $last_item_id = $last_item['id'];

                $user->stt_aktif = $json[count($json) - 1]["stt_aktif"];

                $id = ++$last_item_id;
            }
            else{
                $id = 1;
            }

            $json[] = array(
                'id' => $id,
                'status' => 'diaktifkan',
                'stt_aktif' => $user->stt_aktif,
                'anggota' => Auth::user()->anggota,
                'timestamp' => Carbon::now()->toDateTimeString(),
            );
            $nonaktif = json_encode($json);
            $user->nonaktif = $nonaktif;
            $user->save();

            return response()->json(['success' => 'Data berhasil dipulihkan.']);
        }
        else{
            return response()->json(['error' => '404 Not Found.']);
        }
    }

    public function reset($id)
    {
        if(request()->ajax()){
            $id = Crypt::decryptString($id);
            try{
                $user = User::findOrFail($id);
            }catch(ModelNotFoundException $e){
                return response()->json(['exception' => $e]);
            }
            $pass = str_shuffle('00112233445566778899');
            $pass = substr($pass,0,7);

            $user->password = Hash::make(sha1(md5(hash('gost', $pass))));
            $user->save();

            return response()->json(['success' => 'Reset password berhasil.', 'pass' => $pass]);
        }
        else{
            return response()->json(['error' => '404 Not Found']);
        }
    }
}
