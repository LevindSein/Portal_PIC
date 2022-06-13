<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Alat;

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
                    $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                    $button .= '<a type="button" data-toggle="tooltip" title="Hapus" status="1" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.$data->code.'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
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
                'stand' => 'required|numeric|gte:0|lte:999999999999'
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
                    'daya'   => 'required|numeric|gte:0|lte:999999999999'
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

            $input['stand'] = str_replace('.', '', $request->edit_stand);

            //Validator
            Validator::make($input, [
                'stand' => 'required|numeric|gte:0|lte:999999999999'
            ])->validate();
            //End Validator

            DB::transaction(function() use ($input, $decrypted, $request){
                $data = Alat::lockForUpdate()->findOrFail($decrypted);

                $dataset = [
                    'stand' => $input['stand']
                ];

                if ($data->level == 1){
                    //Listrik

                    $dataset['daya'] = str_replace('.', '', $request->edit_daya);
                    //Validator
                    Validator::make($dataset, [
                        'daya'   => 'required|numeric|gte:0|lte:999999999999'
                    ])->validate();
                    //End Validator
                }

                $data->update($dataset);
            });

            return response()->json(['success' => 'Data berhasil disimpan.']);
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
