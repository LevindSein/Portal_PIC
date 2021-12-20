<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Bill;
use App\Models\IndoDate;
use App\Models\Period;
use App\Models\Identity;
use App\Models\User;
use App\Models\PListrik;
use App\Models\Store;
use App\Models\TListrik;
use DataTables;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $id_period = Session::get('period');
            $valid['period'] = $id_period;
            $validator = Validator::make($valid, [
                'period' => 'exists:App\Models\Period,id'
            ]);

            if($validator->fails()){
                $id_period = Period::latest('name')->select('id')->first()->id;
            }

            $data = Bill::where('id_period', $id_period)
            ->whereIn('active', [1,2])
            ->select(
                'id',
                'stt_publish',
                'stt_bayar',
                'stt_lunas',
                'kd_kontrol',
                'name',
                'nicename',
                'b_tagihan',
            );
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                if($data->stt_publish == 1){
                    if($data->stt_bayar == 1){
                        if($data->stt_lunas == 1){
                            $button .= '<span style="color:#36bea6;">Lunas</span>';
                        }
                        else{
                            $button .= '<span style="color:#e74a3b;">Belum Lunas</span>';
                        }
                    }
                    else{
                        $button .= '<a type="button" data-toggle="tooltip" title="Unpublish" name="unpublish" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="unpublish"><i class="fas fa-undo" style="color:#e74a3b;"></i></a>';
                    }
                }
                else{
                    $button .= '<a type="button" data-toggle="tooltip" title="Publish" name="publish" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="publish"><i class="fas fa-check" style="color:#36bea6;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                    $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                }
                return $button;
            })
            ->addColumn('fasilitas', function($data){
                return '-';
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('portal.manage.bill.index');
    }

    public function period(){
        if(request()->ajax()){
            $id = Session::get('period');

            if(is_null($id)){
                return response()->json(['success' => Period::latest('name')->first()]);
            }

            $period = Period::find($id);

            return response()->json(['success' => $period]);
        }
        else{
            abort(404);
        }
    }

    public function periodChange($id){
        Session::put('period', $id);
        return response()->json(['success' => $id]);
    }

    public function refresh(Request $request){
        $price = $request->price;
        $checked = $request->checked;
        $digit = str_replace('.','',$request->digit);
        $awal = str_replace('.','',$request->awal);
        $akhir = str_replace('.','',$request->akhir);
        $daya = str_replace('.','',$request->daya);

        $diff = $request->diff;

        if($checked){
            if($digit < strlen($awal)){
                $digit = strlen($awal);
                return response()->json(['info' => "Alat Listrik Minimal $digit digit."]);
            }
        }
        else{
            if($awal > $akhir){
                return response()->json(['info' => "Akhir Meter harus lebih besar dari Awal Meter."]);
            }
        }

        $data = 0;
        $denda = PListrik::find($price);
        $denda = json_decode($denda->data);

        if($checked){
            $digit = str_repeat("9",strlen($awal));
            $akhir = $digit + $akhir;
        }

        if($daya > 4400){
            $denda = $denda->denda2 / 100;

            $tagihan = PListrik::tagihan($price, $awal, $akhir, $daya);

            $denda = round($denda * $tagihan);

            $data = $denda * $diff;
        }
        else{
            $denda = $denda->denda1;

            $data = $denda * $diff;
        }

        return response()->json(['success' => $data]);
    }

    public function multipleSelect($data){
        $temp = array();
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
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
            $data['code'] = Identity::billCode();
            $period = $request->periode;
            $data['id_period'] = $period;

            $data['stt_publish'] = 0;
            if($request->stt_publish){
                $data['stt_publish'] = 1;
            }

            $data['stt_bayar'] = 0;
            $data['stt_lunas'] = 0;

            $data['name'] = User::find($request->pengguna)->name;

            $data['kd_kontrol'] = $request->kontrol;
            $data['nicename'] = str_replace('-','',$request->kontrol);
            $data['group'] = $request->group;

            $los = $this->multipleSelect($request->los);
            sort($los, SORT_NATURAL);
            $data['jml_los'] = count($los);
            $data['no_los'] = implode(',', $los);

            $data['active'] = 1;

            //Listrik
            if($request->fas_listrik){
                $tarif_id = $request->plistrik;

                $tarif = PListrik::find($tarif_id);
                $tarif_data = json_decode($tarif->data);

                $tarif_nama = $tarif->name;

                $data['b_listrik'] = json_encode([
                    'tarif_id' => $tarif_id,
                    'tarif_nama' => $tarif_nama,
                    'daya' => str_replace('.','',$request->dayalistrik),
                    'awal' => str_replace('.','',$request->awlistrik),
                    'akhir' => str_replace('.','',$request->aklistrik),
                    'pakai' => $pakai,
                    'bayar' => $bayar,
                    'blok1' => $blok1,
                    'blok2' => $blok2,
                    'beban' => $beban,
                    'bpju' => $bpju,
                    'sub_tagihan' => $sub_tagihan,
                    'denda' => $denda,
                    'diskon' => $diskon,
                    'ttl_tagihan' => $ttl_tagihan,
                    'rea_tagihan' => $rea_tagihan,
                    'sel_tagihan' => $sel_tagihan,
                ]);
            }
            //Air Bersih
            if($request->fas_airbersih){

            }
            //Keamanan IPK
            if($request->fas_keamananipk){

            }
            //Kebersihan
            if($request->fas_kebersihan){

            }
            //Air Kotor
            if($request->fas_airkotor){

            }

            $data['data'] = json_encode([
                'user_create' => Auth::user()->id,
                'username_create' => Auth::user()->name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'user_update' => Auth::user()->id,
                'username_update' => Auth::user()->name,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            try{
                Bill::create($data);
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            Session::put('period', $period);

            $searchKey = str_replace('-','',$request->kontrol);

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
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

    public function publish($id){
        $tagihan = Bill::select('id', 'stt_publish', 'stt_bayar')->find($id);

        $stt_publish = $tagihan->stt_publish;
        $stt_bayar = $tagihan->stt_bayar;

        if($stt_bayar == 1){
            return response()->json(['error' => 'Data failed to unpublish.', 'info' => 'Tagihan sudah dibayar.']);
        }
        else{
            if($stt_publish == 1){
                $tagihan->stt_publish = 0;
            }
            else{
                $tagihan->stt_publish = 1;
            }

            try{
                $tagihan->save();
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to save.', 'description' => $e]);
            }

            return response()->json(['success' => 'Data updated.']);
        }
    }
}
