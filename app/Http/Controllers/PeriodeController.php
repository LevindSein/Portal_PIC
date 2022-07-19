<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\Models\Periode;
use App\Models\IndoDate;

use Carbon\Carbon;

use DataTables;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Periode::where('status', 1)->orderBy('name','desc');

            $now = Carbon::now()->format('Y-m-d');

            return DataTables::of($data)
            ->addColumn('action', function($data) use ($now){
                $button = '';
                if($data->due > $now){
                    $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->nicename.'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                }
                if(!Periode::find($data->id)->tagihan()->exists()){
                    $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" nama="'.$data->nicename.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.$data->nicename.'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->filterColumn('name', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(name, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('MasterData.Periode.index');
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
            //Validator
            $input['bulan']        = $request->tambah_bulan;
            $input['tahun']        = $request->tambah_tahun;
            $input['jatuh_tempo']  = Carbon::parse($input['tahun'] . '-' . $input['bulan'] . '-' . $request->tambah_due)->format('Y-m-d');
            $input['periode_baru'] = Carbon::parse($input['tahun'] . '-' . $input['bulan'] . '-' . $request->tambah_new)->format('Y-m-d');

            $input['periode'] = $input['tahun'] . '-' . $input['bulan'];

            $now = Carbon::now();

            Validator::make($input, [
                'bulan'        => 'required|string|in:01,02,03,04,05,06,07,08,09,10,11,12',
                'tahun'        => 'required|numeric|digits:4|min:2018|max:' . $now->year,
                'periode'      => 'required|string|max:8|unique:periode,name',
                'jatuh_tempo'  => 'required|date|date_format:Y-m-d',
                'periode_baru' => 'required|date|date_format:Y-m-d',
            ])->validate();
            //End Validator

            if($input['periode_baru'] <= $input['jatuh_tempo']){
                return response()->json(['error' => 'Tanggal Periode Tagihan Baru invalid.']);
            }

            DB::transaction(function() use ($input){
                Periode::create([
                    'name'     => $input['periode'],
                    'nicename' => IndoDate::bulan($input['periode'], ' '),
                    'new'      => $input['periode_baru'],
                    'due'      => $input['jatuh_tempo'],
                    'year'     => $input['tahun'],
                ]);
            });

            return response()->json(['success' => 'Data berhasil disimpan.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Periode  $periode
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

            $data = Periode::findOrFail($decrypted);

            $data['due'] = IndoDate::tanggal($data->due, ' ');
            $data['new'] = IndoDate::tanggal($data->new, ' ');

            return response()->json(['success' => $data]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Periode  $periode
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

            $data = Periode::findOrFail($decrypted);

            $data['bulan'] = Carbon::parse($data->name)->format('m');

            return response()->json(['success' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Periode  $periode
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

            $data = Periode::lockForUpdate()->findOrFail($decrypted);

            //Validator
            $input['bulan']        = $request->edit_bulan;
            $input['tahun']        = $request->edit_tahun;
            $input['jatuh_tempo']  = Carbon::parse($input['tahun'] . '-' . $input['bulan'] . '-' . $request->edit_due)->format('Y-m-d');
            $input['periode_baru'] = Carbon::parse($input['tahun'] . '-' . $input['bulan'] . '-' . $request->edit_new)->format('Y-m-d');

            $input['periode'] = $input['tahun'] . '-' . $input['bulan'];

            $now = Carbon::now();

            if($now->format('Y-m-d') > $now){
                return response()->json(['error' => 'Tidak dapat melakukan update.']);
            }

            Validator::make($input, [
                'bulan'        => 'required|string|in:01,02,03,04,05,06,07,08,09,10,11,12',
                'tahun'        => 'required|numeric|digits:4|min:2018|max:' . $now->year,
                'periode'      => 'required|string|max:8|unique:periode,name,' . $decrypted,
                'jatuh_tempo'  => 'required|date|date_format:Y-m-d',
                'periode_baru' => 'required|date|date_format:Y-m-d',
            ])->validate();
            //End Validator

            if($input['periode_baru'] <= $input['jatuh_tempo']){
                return response()->json(['error' => 'Tanggal Periode Tagihan Baru invalid.']);
            }

            DB::transaction(function() use ($input, $data){
                $data->update([
                    'name'     => $input['periode'],
                    'nicename' => IndoDate::bulan($input['periode'], ' '),
                    'new'      => $input['periode_baru'],
                    'due'      => $input['jatuh_tempo'],
                    'year'     => $input['tahun'],
                ]);
            });

            return response()->json(['success' => 'Data berhasil disimpan.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Periode  $periode
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
                $data = Periode::lockForUpdate()->findOrFail($decrypted);

                $data->delete();
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }
}
