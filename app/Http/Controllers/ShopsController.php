<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Shops;
use App\Models\User;

use DataTables;
use Carbon\Carbon;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Shops::
            with('pengguna:id,name')
            ->select(
                'kd_kontrol',
                'jml_los',
                'id_pengguna',
                'nicename'
            );
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->name.'" class="edit pointera"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.$data->name.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->name.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->addColumn('fasilitas', function($data){
                $listrik = '<a type="button" data-toggle="tooltip" title="Listrik" class="pointera"><i class="fas fa-bolt" style="color:#fd7e14;""></i></a>';
                $airbersih = '<a type="button" data-toggle="tooltip" title="Air Bersih" class="pointera"><i class="fas fa-tint" style="color:#36b9cc;""></i></a>';
                $keamananipk = '<a type="button" data-toggle="tooltip" title="Keamanan IPK" class="pointera"><i class="fas fa-lock" style="color:#e74a3b;""></i></a>';
                $kebersihan = '<a type="button" data-toggle="tooltip" title="Kebersihan" class="pointera"><i class="fas fa-leaf" style="color:#1cc88a;""></i></a>';
                $airkotor = '<a type="button" data-toggle="tooltip" title="Air Kotor" class="pointera"><i class="fad fa-burn" style="color:#2e96a6;""></i></a>';
                $lain = '<a type="button" data-toggle="tooltip" title="Lain Lain" class="pointera"><i class="fas fa-chart-pie" style="color:#c5793a;""></i></a>';
                return $listrik."&nbsp;&nbsp;".$airbersih."&nbsp;&nbsp;".$keamananipk."&nbsp;&nbsp;".$kebersihan."&nbsp;&nbsp;".$airkotor."&nbsp;&nbsp;".$lain;
            })
            ->editColumn('jml_los', function($data){
                return number_format($data->jml_los);
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action','fasilitas'])
            ->make(true);
        }
        return view('portal.point.shops.index');
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
