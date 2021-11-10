<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use DataTables;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah
        if(request()->ajax())
        {
            $data = User::where('level','3')->select('id','username','name');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" data-original-title="Reset Password" name="reset" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" data-original-title="Edit" name="edit" id="'.Crypt::encryptString($data->id).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" data-original-title="Hapus" name="delete" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->rawColumns(['action','show','otoritas'])
                ->make(true);
        }
        return view('portal.user.index');
    }

    public function admin()
    {
        //level : 1 = Super Admin, 2 = Admin, 3 = Nasabah
        if(request()->ajax())
        {
            $data = User::where('level','2')->select('id','username','name');
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" data-toggle="tooltip" data-original-title="Reset Password" name="reset" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="reset"><i class="fas fa-key" style="color:#fd7e14;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" data-original-title="Edit" name="edit" id="'.Crypt::encryptString($data->id).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" data-original-title="Hapus" name="delete" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                    return $button;
                })
                ->addColumn('show', function($data){
                    $button = '<button title="Show Details" name="show" id="'.Crypt::encryptString($data->id).'" nama="'.$data->name.'" class="details btn btn-sm btn-info">Show</button>';
                    return $button;
                })
                ->rawColumns(['action','show','otoritas'])
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
        //
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
        //
    }
}
