<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Alat;

use Carbon\Carbon;

use Excel;
use DataTables;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Alat::where([['level',  $request->level], ['status', $request->status]]);

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
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 12);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='$data->name'>$name</span>";
            })
            ->editColumn('stand', function($data){
                return number_format($data->stand, '0', ',', '.');
            })
            ->rawColumns(['action', 'name'])
            ->make(true);
        }

        return view('Utilities.Alat.index');
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
            $input['nama']  = strtoupper($request->tambah_name);
            $input['level'] = $request->tambah_level;
            $input['stand'] = str_replace('.', '', $request->tambah_stand);

            //Validator
            Validator::make($input, [
                'nama'  => 'required|string|max:50|unique:tarif,name',
                'level' => 'required|numeric|digits_between:1,2',
                'stand' => 'required|numeric|lte:999999999999'
            ])->validate();
            //End Validator

            $dataset = [
                'code'  => Alat::code(),
                'name'  => $input['nama'],
                'level' => $input['level'],
                'stand' => $input['stand']
            ];

            if ($input['level'] == 1){
                //Listrik

                $data['daya'] = str_replace('.', '', $request->tambah_daya);
                //Validator
                Validator::make($data, [
                    'daya'   => 'required|numeric|lte:999999999999'
                ])->validate();
                //End Validator

                $dataset['daya'] = $data['daya'];
            }

            DB::transaction(function() use ($dataset){
                Alat::create($dataset);
            });

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
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = Alat::findOrFail($decrypted);

            return response()->json(['success' => $data]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $data = Alat::findOrFail($decrypted);

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => $data]);
        }
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
        if($request->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            DB::transaction(function() use ($decrypted, $request){
                $input['nama']  = $request->edit_name;

                $tarif = Alat::lockForUpdate()->findOrFail($decrypted);

                $input['level'] = $tarif->level;

                //Validator
                Validator::make($input, [
                    'nama'  => 'required|string|max:50|unique:tarif,name,' . $decrypted,
                ])->validate();
                //End Validator

                if($input['level'] == 1){
                    //Listrik

                    $data['Tarif_Beban']         = str_replace('.', '', $request->edit_beban);
                    $data['Tarif_Blok_1']        = str_replace('.', '', $request->edit_blok1);
                    $data['Tarif_Blok_2']        = str_replace('.', '', $request->edit_blok2);
                    $data['Standar_Operasional'] = $request->edit_standar;
                    $data['PJU']                 = $request->edit_pju;
                    $data['Denda_1']             = str_replace('.', '', $request->edit_denda1);
                    $data['Denda_2']             = $request->edit_denda2;
                    $data['PPN']                 = $request->edit_ppnlistrik;
                    //Validator
                    Validator::make($data, [
                        'Tarif_Beban'         => 'required|numeric|lte:999999999999',
                        'Tarif_Blok_1'        => 'required|numeric|lte:999999999999',
                        'Tarif_Blok_2'        => 'required|numeric|lte:999999999999',
                        'Standar_Operasional' => 'required|numeric|lte:24',
                        'PJU'                 => 'required|numeric|lte:100',
                        'Denda_1'             => 'required|numeric|lte:999999999999',
                        'Denda_2'             => 'required|numeric|lte:100',
                        'PPN'                 => 'required|numeric|lte:100'
                    ])->validate();
                    //End Validator
                } else if ($input['level'] == 2){
                    //Air Bersih

                    $data['Tarif_1']            = str_replace('.', '', $request->edit_tarif1);
                    $data['Tarif_2']            = str_replace('.', '', $request->edit_tarif2);
                    $data['Tarif_Pemeliharaan'] = str_replace('.', '', $request->edit_pemeliharaan);
                    $data['Tarif_Beban']        = str_replace('.', '', $request->edit_bbn);
                    $data['Tarif_Air_Kotor']    = $request->edit_arkot;
                    $data['Denda']              = str_replace('.', '', $request->edit_denda);
                    $data['PPN']                = $request->edit_ppnair;
                    //Validator
                    Validator::make($data, [
                        'Tarif_1'            => 'required|numeric|lte:999999999999',
                        'Tarif_2'            => 'required|numeric|lte:999999999999',
                        'Tarif_Pemeliharaan' => 'required|numeric|lte:999999999999',
                        'Tarif_Beban'        => 'required|numeric|lte:999999999999',
                        'Tarif_Air_Kotor'    => 'required|numeric|lte:100',
                        'Denda'              => 'required|numeric|lte:999999999999',
                        'PPN'                => 'required|numeric|lte:100',
                    ])->validate();
                    //End Validator
                } else if ($input['level'] == 3){
                    //Keamanan IPK

                    $data['Tarif']           = str_replace('.', '', $request->edit_keamananipk);
                    $data['Persen_Keamanan'] = $request->edit_keamanan;
                    $data['Persen_IPK']      = $request->edit_ipk;
                    //Validator
                    Validator::make($data, [
                        'Tarif'           => 'required|numeric|lte:999999999999',
                        'Persen_Keamanan' => 'required|numeric|lte:100',
                        'Persen_IPK'      => 'required|numeric|lte:100',
                    ])->validate();
                    //End Validator
                } else if ($input['level'] == 4){
                    //Kebersihan

                    $data['Tarif']       = str_replace('.', '', $request->edit_kebersihan);
                    //Validator
                    Validator::make($data, [
                        'Tarif'          => 'required|numeric|lte:999999999999'
                    ])->validate();
                    //End Validator
                } else if ($input['level'] == 5){
                    //Air Kotor

                    $data['Tarif']       = str_replace('.', '', $request->edit_airkotor);
                    //Validator
                    Validator::make($data, [
                        'Tarif'          => 'required|numeric|lte:999999999999'
                    ])->validate();
                    //End Validator
                } else {
                    //Lainnya

                    $data['Tarif']       = str_replace('.', '', $request->edit_lainnya);
                    //Validator
                    Validator::make($data, [
                        'Tarif'          => 'required|numeric|lte:999999999999'
                    ])->validate();
                    //End Validator
                }

                $tarif->update([
                    'name'  => $input['nama'],
                    'level' => $input['level'],
                    'data'  => json_encode($data)
                ]);
            });

            return response()->json(['success' => 'Data berhasil ditambah.']);
        }
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
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            DB::transaction(function() use ($decrypted){
                $data = Alat::lockForUpdate()->findOrFail($decrypted);

                $data->delete();
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }

    public function print(Request $request){
        //Validator
        $input['level']  = $request->level;
        $input['status'] = $request->status;

        Validator::make($input, [
            'level'    => 'required|in:1,2',
            'status'   => 'required|in:0,1,all',
        ])->validate();
        //End Validator

        if(is_numeric($input['status'])){
            $data = Alat::where([['level', $input['level']], ['status', $input['status']]])->get();
        }
        else {
            $data = Alat::where('level', $input['level'])->get();
        }

        return view('Utilities.Alat.Pages._print', [
            'level'     => Alat::level($input['level']),
            'levelAlat' => $input['level'],
            'data'      => $data
        ]);
    }
}
