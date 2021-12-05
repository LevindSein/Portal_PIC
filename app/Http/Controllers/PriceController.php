<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\PListrik;
use App\Models\PAirBersih;
use App\Models\PKeamananIpk;
use App\Models\PKebersihan;
use App\Models\PAirKotor;
use App\Models\PLain;

use DataTables;
use Carbon\Carbon;

class PriceController extends Controller
{
    public function listrik(){
        if(request()->ajax()){
            $data = PListrik::select('id','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('name', function($data){
                return substr($data->name,0,30);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.manage.price.listrik.index');
    }

    public function listrikStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['beban'] = str_replace('.','',$request->beban);
            $data['blok1'] = str_replace('.','',$request->blok1);
            $data['blok2'] = str_replace('.','',$request->blok2);
            $data['denda1'] = str_replace('.','',$request->denda1);

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PListrik,name',
                'beban' => 'required|numeric|lte:999999999',
                'blok1' => 'required|numeric|lte:999999999',
                'blok2' => 'required|numeric|lte:999999999',
                'standar' => 'required|numeric|lte:24',
                'pju' => 'required|numeric|lte:100',
                'denda1' => 'required|numeric|lte:999999999',
                'denda2' => 'required|numeric|lte:100',
                'ppn' => 'required|numeric|lte:100',
            ])->validate();

            $json = json_encode([
                'beban' => str_replace('.','',$request->beban),
                'blok1' => str_replace('.','',$request->blok1),
                'blok2' => str_replace('.','',$request->blok2),
                'standar' => $request->standar,
                'pju' => $request->pju,
                'denda1' => str_replace('.','',$request->denda1),
                'denda2' => $request->denda2,
                'ppn' => $request->ppn,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PListrik::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->name;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function listrikEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function listrikUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['beban'] = str_replace('.','',$request->beban);
            $data['blok1'] = str_replace('.','',$request->blok1);
            $data['blok2'] = str_replace('.','',$request->blok2);
            $data['denda1'] = str_replace('.','',$request->denda1);

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PListrik,name,'.$decrypted,
                'beban' => 'required|numeric|lte:999999999',
                'blok1' => 'required|numeric|lte:999999999',
                'blok2' => 'required|numeric|lte:999999999',
                'standar' => 'required|numeric|lte:24',
                'pju' => 'required|numeric|lte:100',
                'denda1' => 'required|numeric|lte:999999999',
                'denda2' => 'required|numeric|lte:100',
                'ppn' => 'required|numeric|lte:100',
            ])->validate();

            try{
                $data = PListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->beban = str_replace('.','',$request->beban);
            $json->blok1 = str_replace('.','',$request->blok1);
            $json->blok2 = str_replace('.','',$request->blok2);
            $json->standar = $request->standar;
            $json->pju = $request->pju;
            $json->denda1 = str_replace('.','',$request->denda1);
            $json->denda2 = $request->denda2;
            $json->ppn = $request->ppn;
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->data = $json;
            $data->name = $request->name;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function listrikShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function listrikDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PListrik::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function airbersih(){
        if(request()->ajax()){
            $data = PAirBersih::select('id','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('name', function($data){
                return substr($data->name,0,30);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.manage.price.air-bersih.index');
    }

    public function airbersihStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif1'] = str_replace('.','',$request->tarif1);
            $data['tarif2'] = str_replace('.','',$request->tarif2);
            $data['pemeliharaan'] = str_replace('.','',$request->pemeliharaan);
            $data['beban'] = str_replace('.','',$request->beban);
            $data['denda'] = str_replace('.','',$request->denda);

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PAirBersih,name',
                'tarif1' => 'required|numeric|lte:999999999',
                'tarif2' => 'required|numeric|lte:999999999',
                'pemeliharaan' => 'required|numeric|lte:999999999',
                'beban' => 'required|numeric|lte:999999999',
                'airkotor' => 'required|numeric|lte:100',
                'denda' => 'required|numeric|lte:999999999',
                'ppn' => 'required|numeric|lte:100',
            ])->validate();

            $json = json_encode([
                'tarif1' => str_replace('.','',$request->tarif1),
                'tarif2' => str_replace('.','',$request->tarif2),
                'pemeliharaan' => str_replace('.','',$request->pemeliharaan),
                'beban' => str_replace('.','',$request->beban),
                'airkotor' => $request->airkotor,
                'denda' => str_replace('.','',$request->denda),
                'ppn' => $request->ppn,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PAirBersih::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->name;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function airbersihEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PAirBersih::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function airbersihUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif1'] = str_replace('.','',$request->tarif1);
            $data['tarif2'] = str_replace('.','',$request->tarif2);
            $data['pemeliharaan'] = str_replace('.','',$request->pemeliharaan);
            $data['beban'] = str_replace('.','',$request->beban);
            $data['denda'] = str_replace('.','',$request->denda);

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PAirBersih,name,'.$decrypted,
                'tarif1' => 'required|numeric|lte:999999999',
                'tarif2' => 'required|numeric|lte:999999999',
                'pemeliharaan' => 'required|numeric|lte:999999999',
                'beban' => 'required|numeric|lte:999999999',
                'airkotor' => 'required|numeric|lte:100',
                'denda' => 'required|numeric|lte:999999999',
                'ppn' => 'required|numeric|lte:100',
            ])->validate();

            try{
                $data = PAirBersih::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->tarif1 = str_replace('.','',$request->tarif1);
            $json->tarif2 = str_replace('.','',$request->tarif2);
            $json->pemeliharaan = str_replace('.','',$request->pemeliharaan);
            $json->beban = str_replace('.','',$request->beban);
            $json->airkotor = $request->airkotor;
            $json->denda = str_replace('.','',$request->denda);
            $json->ppn = $request->ppn;
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->data = $json;
            $data->name = $request->name;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function airbersihShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PAirBersih::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function airbersihDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PAirBersih::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function keamananipk(){
        if(request()->ajax()){
            $data = PKeamananIpk::select('id','price','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('name', function($data){
                return substr($data->name,0,30);
            })
            ->editColumn('price', function($data){
                return number_format($data->price);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.manage.price.keamanan-ipk.index');
    }

    public function keamananipkStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PKeamananIpk,name',
                'tarif' => 'required|numeric|lte:999999999',
                'keamanan' => 'required|numeric|lte:100',
                'ipk' => 'required|numeric|lte:100',
            ])->validate();

            $json = json_encode([
                'tarif' => str_replace('.','',$request->tarif),
                'keamanan' => $request->keamanan,
                'ipk' => $request->ipk,
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['price'] = str_replace('.','',$request->tarif);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PKeamananIpk::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->name;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function keamananipkEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PKeamananIpk::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function keamananipkUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PKeamananIpk,name,'.$decrypted,
                'tarif' => 'required|numeric|lte:999999999',
                'keamanan' => 'required|numeric|lte:100',
                'ipk' => 'required|numeric|lte:100',
            ])->validate();

            try{
                $data = PKeamananIpk::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->tarif = str_replace('.','',$request->tarif);
            $json->keamanan = $request->keamanan;
            $json->ipk = $request->ipk;
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->price = str_replace('.','',$request->tarif);
            $data->data = $json;
            $data->name = $request->name;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function keamananipkShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PKeamananIpk::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function keamananipkDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PKeamananIpk::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function kebersihan(){
        if(request()->ajax()){
            $data = PKebersihan::select('id','price','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('name', function($data){
                return substr($data->name,0,30);
            })
            ->editColumn('price', function($data){
                return number_format($data->price);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.manage.price.kebersihan.index');
    }

    public function kebersihanStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PKebersihan,name',
                'tarif' => 'required|numeric|lte:999999999',
            ])->validate();

            $json = json_encode([
                'tarif' => str_replace('.','',$request->tarif),
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['price'] = str_replace('.','',$request->tarif);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PKebersihan::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->name;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function kebersihanEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PKebersihan::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function kebersihanUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PKebersihan,name,'.$decrypted,
                'tarif' => 'required|numeric|lte:999999999',
            ])->validate();

            try{
                $data = PKebersihan::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->tarif = str_replace('.','',$request->tarif);
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->price = str_replace('.','',$request->tarif);
            $data->data = $json;
            $data->name = $request->name;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function kebersihanShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PKebersihan::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function kebersihanDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PKebersihan::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function airkotor(){
        if(request()->ajax()){
            $data = PAirkotor::select('id','price','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('name', function($data){
                return substr($data->name,0,30);
            })
            ->editColumn('price', function($data){
                return number_format($data->price);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.manage.price.air-kotor.index');
    }

    public function airkotorStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PAirkotor,name',
                'tarif' => 'required|numeric|lte:999999999',
            ])->validate();

            $json = json_encode([
                'tarif' => str_replace('.','',$request->tarif),
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['price'] = str_replace('.','',$request->tarif);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PAirkotor::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->name;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function airkotorEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PAirkotor::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function airkotorUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PAirkotor,name,'.$decrypted,
                'tarif' => 'required|numeric|lte:999999999',
            ])->validate();

            try{
                $data = PAirkotor::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->tarif = str_replace('.','',$request->tarif);
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->price = str_replace('.','',$request->tarif);
            $data->data = $json;
            $data->name = $request->name;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function airkotorShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PAirkotor::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function airkotorDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PAirkotor::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }

    public function lain(){
        if(request()->ajax()){
            $data = PLain::select('id','price','name');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.Crypt::encrypt($data->id).'" nama="'.substr($data->name,0,15).'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';

                return $button;
            })
            ->editColumn('name', function($data){
                return substr($data->name,0,30);
            })
            ->editColumn('price', function($data){
                return number_format($data->price);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.manage.price.lain.index');
    }

    public function lainStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PLain,name',
                'tarif' => 'required|numeric|lte:999999999',
            ])->validate();

            $json = json_encode([
                'tarif' => str_replace('.','',$request->tarif),
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $dataset['price'] = str_replace('.','',$request->tarif);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PLain::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = $request->name;

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function lainEdit($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PLain::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Data deleted.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function lainUpdate(Request $request, $id){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif'] = str_replace('.','',$request->tarif);

            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid.', 'description' => $e]);
            }

            Validator::make($data, [
                'name' => 'required|max:100|unique:App\Models\PLain,name,'.$decrypted,
                'tarif' => 'required|numeric|lte:999999999',
            ])->validate();

            try{
                $data = PLain::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $json = json_decode($data->data);

            $json->tarif = str_replace('.','',$request->tarif);
            $json->user_update = Auth::user()->id;
            $json->username_update = Auth::user()->name;
            $json->updated_at = Carbon::now()->toDateTimeString();

            $json = json_encode($json);

            $data->price = str_replace('.','',$request->tarif);
            $data->data = $json;
            $data->name = $request->name;

            try{
                $data->save();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to save.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
        }
        else{
            abort(404);
        }
    }

    public function lainShow($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PLain::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            $data['data'] = json_decode($data->data);

            return response()->json(['success' => 'Fetching data success.', 'show' => $data]);
        }
        else{
            abort(404);
        }
    }

    public function lainDestroy($id){
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => 'Data invalid', 'description' => $e]);
            }

            try{
                $data = PLain::findOrFail($decrypted);
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Data not found.', 'description' => $e]);
            }

            try{
                $data->delete();
            } catch(\Exception $e){
                return response()->json(['error' => "Data failed to delete.", 'description' => $e]);
            }

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }
}
