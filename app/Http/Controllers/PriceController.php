<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\PListrik;
use App\Models\PAirBersih;

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
        return view('portal.price.listrik.index');
    }

    public function listrikStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['beban'] = str_replace(',','',$request->beban);
            $data['blok1'] = str_replace(',','',$request->blok1);
            $data['blok2'] = str_replace(',','',$request->blok2);
            $data['denda1'] = str_replace(',','',$request->denda1);

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
                'beban' => str_replace(',','',$request->beban),
                'blok1' => str_replace(',','',$request->blok1),
                'blok2' => str_replace(',','',$request->blok2),
                'standar' => $request->standar,
                'pju' => $request->pju,
                'denda1' => str_replace(',','',$request->denda1),
                'denda2' => $request->denda2,
                'ppn' => $request->ppn,
            ]);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PListrik::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
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
            $data['beban'] = str_replace(',','',$request->beban);
            $data['blok1'] = str_replace(',','',$request->blok1);
            $data['blok2'] = str_replace(',','',$request->blok2);
            $data['denda1'] = str_replace(',','',$request->denda1);

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
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            $json = json_encode([
                'beban' => str_replace(',','',$request->beban),
                'blok1' => str_replace(',','',$request->blok1),
                'blok2' => str_replace(',','',$request->blok2),
                'standar' => $request->standar,
                'pju' => $request->pju,
                'denda1' => str_replace(',','',$request->denda1),
                'denda2' => $request->denda2,
                'ppn' => $request->ppn,
            ]);
            $data->data = $json;
            $data->name = $request->name;

            $data->save();

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

            $data->delete();

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
        return view('portal.price.air-bersih.index');
    }

    public function airbersihStore(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $data['tarif1'] = str_replace(',','',$request->tarif1);
            $data['tarif2'] = str_replace(',','',$request->tarif2);
            $data['pemeliharaan'] = str_replace(',','',$request->pemeliharaan);
            $data['beban'] = str_replace(',','',$request->beban);
            $data['denda'] = str_replace(',','',$request->denda);

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
                'tarif1' => str_replace(',','',$request->tarif1),
                'tarif2' => str_replace(',','',$request->tarif2),
                'pemeliharaan' => str_replace(',','',$request->pemeliharaan),
                'beban' => str_replace(',','',$request->beban),
                'airkotor' => $request->airkotor,
                'denda' => str_replace(',','',$request->denda),
                'ppn' => $request->ppn,
            ]);
            $dataset['data'] = $json;
            $dataset['name'] = $request->name;

            try{
                PAirBersih::create($dataset);
            } catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            return response()->json(['success' => 'Data saved.']);
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
            $data['tarif1'] = str_replace(',','',$request->tarif1);
            $data['tarif2'] = str_replace(',','',$request->tarif2);
            $data['pemeliharaan'] = str_replace(',','',$request->pemeliharaan);
            $data['beban'] = str_replace(',','',$request->beban);
            $data['denda'] = str_replace(',','',$request->denda);

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
                return response()->json(['error' => 'User not found.', 'description' => $e]);
            }

            $json = json_encode([
                'tarif1' => str_replace(',','',$request->tarif1),
                'tarif2' => str_replace(',','',$request->tarif2),
                'pemeliharaan' => str_replace(',','',$request->pemeliharaan),
                'beban' => str_replace(',','',$request->beban),
                'airkotor' => $request->airkotor,
                'denda' => str_replace(',','',$request->denda),
                'ppn' => $request->ppn,
            ]);
            $data->data = $json;
            $data->name = $request->name;

            $data->save();

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

            $data->delete();

            return response()->json(['success' => 'Data deleted.']);
        }
        else{
            abort(404);
        }
    }
}
