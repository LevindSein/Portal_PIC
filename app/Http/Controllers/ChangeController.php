<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Changelogs;

use App\Exports\ChangelogsExport;

use Carbon\Carbon;

use Excel;
use DataTables;

class ChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Changelogs::select('id', 'times', 'title');

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->title, 0, 15).'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->title, 0, 15).'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->title, 0, 15).'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->editColumn('title', function($data){
                $name = $data->title;
                if(strlen($name) > 25) {
                    $name = substr($name, 0, 21);
                    $name = str_pad($name,  25, ".");
                }

                return "<span data-toggle='tooltip' title='$data->title'>$name</span>";
            })
            ->rawColumns(['action', 'title'])
            ->make(true);
        }

        return view('Changelogs.index');
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
            $input['times'] = Carbon::parse($request->tambah_times)->format('Y-m-d H:i:s');
            $input['title'] = $request->tambah_title;
            $input['data']  = $request->tambah_data;

            Validator::make($input, [
                'times' => 'required|date_format:Y-m-d H:i:s',
                'title' => 'required|max:50|string',
                'data'  => 'required|string',
            ])->validate();
            // End Validator

            DB::transaction(function() use ($input){
                Changelogs::create([
                    'code'      => Changelogs::code(),
                    'times'     => $input['times'],
                    'title'     => $input['title'],
                    'data'      => $input['data'],
                    'causer_id' => Auth::user()->id
                ]);
            });

            return response()->json(['success' => 'Data berhasil disimpan.']);
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

            $data = Changelogs::with('user')->findOrFail($decrypted);

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

            $data = Changelogs::findOrFail($decrypted);

            $date = Carbon::parse($data->times)->format('Y-m-d');
            $time = Carbon::parse($data->times)->format('H:i:s');
            $data['times'] = $date.'T'.$time;

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
            //Validator
            $input['times'] = Carbon::parse($request->edit_times)->format('Y-m-d H:i:s');
            $input['title'] = $request->edit_title;
            $input['data']  = $request->edit_data;

            Validator::make($input, [
                'times' => 'required|date_format:Y-m-d H:i:s',
                'title' => 'required|max:50|string',
                'data'  => 'required|string',
            ])->validate();
            // End Validator

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            DB::transaction(function() use ($input, $decrypted){
                $data = Changelogs::lockForUpdate()->findOrFail($decrypted);

                $data->update([
                    'times'     => $input['times'],
                    'title'     => $input['title'],
                    'data'      => $input['data'],
                    'causer_id' => Auth::user()->id
                ]);
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
                $data = Changelogs::lockForUpdate()->findOrFail($decrypted);

                $data->delete();
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }

    public function excel($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => "Data tidak valid."]);
        }

        $data = Changelogs::findOrFail($decrypted);

        return Excel::download(new ChangelogsExport($data->id), 'Changelogs_('. $data->code . ')_' . Carbon::now() . '.xlsx');
    }
}
