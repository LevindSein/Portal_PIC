<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

use App\Models\Tarif;

use Carbon\Carbon;

use Excel;
use DataTables;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Tarif::where('level',  $request->level);

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                if(Session::get('level') == 1){
                    $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                    $button .= '<a type="button" data-toggle="tooltip" title="Hapus" status="1" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name, 0, 15).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->editColumn('name', function($data){
                $name = $data->name;
                if(strlen($name) > 30) {
                    $name = substr($name, 0, 27);
                    $name = str_pad($name,  30, ".");
                }

                return "<span data-toggle='tooltip' title='$data->name'>$name</span>";
            })
            ->rawColumns(['action', 'name'])
            ->make(true);
        }

        return view('Utilities.Tarif.index');
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
        if($request->ajax()){
            $input['nama']  = $request->tambah_name;
            $input['level'] = $request->tambah_level;

            //Validator
            Validator::make($input, [
                'nama'  => 'required|string|max:50|unique:tarif,name',
                'level' => 'required|numeric|digits_between:1,6',
            ])->validate();
            //End Validator

            if($input['level'] == 1){
                //Listrik

                $data['tarif_beban']         = str_replace('.', '', $request->tambah_beban);
                $data['tarif_blok_1']        = str_replace('.', '', $request->tambah_blok1);
                $data['tarif_blok_2']        = str_replace('.', '', $request->tambah_blok2);
                $data['standar_operasional'] = $request->tambah_standar;
                $data['pju']                 = $request->tambah_pju;
                $data['denda_1']             = str_replace('.', '', $request->tambah_denda1);
                $data['denda_2']             = $request->tambah_denda2;
                $data['ppn']                 = $request->tambah_ppnlistrik;
                //Validator
                Validator::make($data, [
                    'tarif_beban'         => 'required|numeric|lte:999999999999',
                    'tarif_blok_1'        => 'required|numeric|lte:999999999999',
                    'tarif_blok_2'        => 'required|numeric|lte:999999999999',
                    'standar_operasional' => 'required|numeric|lte:24',
                    'pju'                 => 'required|numeric|lte:100',
                    'denda_1'             => 'required|numeric|lte:999999999999',
                    'denda_2'             => 'required|numeric|lte:100',
                    'ppn'                 => 'required|numeric|lte:100'
                ])->validate();
                //End Validator
            } else if ($input['level'] == 2){
                //Air Bersih

                $data['tarif_1']            = str_replace('.', '', $request->tambah_tarif1);
                $data['tarif_2']            = str_replace('.', '', $request->tambah_tarif2);
                $data['tarif_pemeliharaan'] = str_replace('.', '', $request->tambah_pemeliharaan);
                $data['tarif_beban']        = str_replace('.', '', $request->tambah_bbn);
                $data['tarif_air_kotor']    = $request->tambah_arkot;
                $data['denda']              = str_replace('.', '', $request->tambah_denda);
                $data['ppn']                = $request->tambah_ppnair;
                //Validator
                Validator::make($data, [
                    'tarif_1'            => 'required|numeric|lte:999999999999',
                    'tarif_2'            => 'required|numeric|lte:999999999999',
                    'tarif_pemeliharaan' => 'required|numeric|lte:999999999999',
                    'tarif_beban'        => 'required|numeric|lte:999999999999',
                    'tarif_air_kotor'    => 'required|numeric|lte:100',
                    'denda'              => 'required|numeric|lte:999999999999',
                    'ppn'                => 'required|numeric|lte:100',
                ])->validate();
                //End Validator
            } else if ($input['level'] == 3){
                //Keamanan IPK

                $data['tarif']           = str_replace('.', '', $request->tambah_keamananipk);
                $data['persen_keamanan'] = $request->tambah_keamanan;
                $data['persen_ipk']      = $request->tambah_ipk;
                //Validator
                Validator::make($data, [
                    'tarif'           => 'required|numeric|lte:999999999999',
                    'persen_keamanan' => 'required|numeric|lte:100',
                    'persen_ipk'      => 'required|numeric|lte:100',
                ])->validate();
                //End Validator
            } else if ($input['level'] == 4){
                //Kebersihan

                $data['tarif']       = str_replace('.', '', $request->tambah_kebersihan);
                //Validator
                Validator::make($data, [
                    'tarif'           => 'required|numeric|lte:999999999999'
                ])->validate();
                //End Validator
            } else if ($input['level'] == 5){
                //Air Kotor

                $data['tarif']       = str_replace('.', '', $request->tambah_airkotor);
                //Validator
                Validator::make($data, [
                    'tarif'           => 'required|numeric|lte:999999999999'
                ])->validate();
                //End Validator
            } else {
                //Lainnya

                $data['tarif']       = str_replace('.', '', $request->tambah_lainnya);
                //Validator
                Validator::make($data, [
                    'tarif'           => 'required|numeric|lte:999999999999'
                ])->validate();
                //End Validator
            }

            Tarif::create([
                'name'  => $input['nama'],
                'level' => $input['level'],
                'data'  => json_encode($data)
            ]);

            return response()->json(['success' => 'Data berhasil ditambah.', 'debug' => $input['level']]);
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
        //
    }
}
