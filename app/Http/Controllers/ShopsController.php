<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Shops;
use App\Models\TListrik;
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
                'id',
                'kd_kontrol',
                'jml_los',
                'id_pengguna',
                'nicename',
                'status',
                'fas_listrik',
                'fas_airbersih',
                'fas_keamananipk',
                'fas_kebersihan',
                'fas_airkotor',
                'fas_lain',
            );
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Edit" name="edit" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="edit pointera"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Delete" name="delete" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="delete"><i class="fas fa-trash" style="color:#e74a3b;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" data-toggle="tooltip" title="Show Details" name="show" id="'.$data->id.'" nama="'.$data->kd_kontrol.'" class="details"><i class="fas fa-info-circle" style="color:#36bea6;"></i></a>';
                return $button;
            })
            ->addColumn('fasilitas', function($data){
                $listrik = ($data->fas_listrik != NULL) ? '<a type="button" data-toggle="tooltip" title="Listrik" class="pointera"><i class="fas fa-bolt" style="color:#fd7e14;""></i></a>' : '<a type="button" data-toggle="tooltip" title="No - Listrik"><i class="fas fa-bolt" style="color:#d7d8cc;""></i></a>';
                $airbersih = ($data->fas_airbersih != NULL) ? '<a type="button" data-toggle="tooltip" title="Air Bersih" class="pointera"><i class="fas fa-tint" style="color:#36b9cc;""></i></a>' : '<a type="button" data-toggle="tooltip" title="No - Air Bersih"><i class="fas fa-tint" style="color:#d7d8cc;""></i></a>';
                $keamananipk = ($data->fas_keamananipk != NULL) ? '<a type="button" data-toggle="tooltip" title="Keamanan IPK" class="pointera"><i class="fas fa-lock" style="color:#e74a3b;""></i></a>' : '<a type="button" data-toggle="tooltip" title="No - Keamanan IPK"><i class="fas fa-lock" style="color:#d7d8cc;""></i></a>';
                $kebersihan = ($data->fas_kebersihan != NULL) ? '<a type="button" data-toggle="tooltip" title="Kebersihan" class="pointera"><i class="fas fa-leaf" style="color:#1cc88a;""></i></a>' : '<a type="button" data-toggle="tooltip" title="No - Kebersihan"><i class="fas fa-leaf" style="color:#d7d8cc;""></i></a>';
                $airkotor = ($data->fas_airkotor != NULL) ? '<a type="button" data-toggle="tooltip" title="Air Kotor" class="pointera"><i class="fad fa-burn" style="color:#2e96a6;""></i></a>' : '<a type="button" data-toggle="tooltip" title="No - Air Kotor"><i class="fas fa-burn" style="color:#d7d8cc;""></i></a>';
                $lain = ($data->fas_lain != NULL) ? '<a type="button" data-toggle="tooltip" title="Lain Lain" class="pointera"><i class="fas fa-chart-pie" style="color:#c5793a;""></i></a>' : '<a type="button" data-toggle="tooltip" title="No - Lain Lain"><i class="fas fa-chart-pie" style="color:#d7d8cc;""></i></a>';
                return $listrik."&nbsp;&nbsp;".$airbersih."&nbsp;&nbsp;".$keamananipk."&nbsp;&nbsp;".$kebersihan."&nbsp;&nbsp;".$airkotor."&nbsp;&nbsp;".$lain;
            })
            ->editColumn('kd_kontrol', function($data){
                if($data->status == 1){
                    $button = "<span class='text-success'>$data->kd_kontrol</span>";
                }
                else if($data->status == 2){
                    $button = "<span class='text-info'>$data->kd_kontrol</span>";
                }
                else{
                    $button = "<span class='text-danger'>$data->kd_kontrol</span>";
                }
                return $button;
            })
            ->editColumn('jml_los', function($data){
                return number_format($data->jml_los);
            })
            ->filterColumn('nicename', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(kd_kontrol, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action','kd_kontrol','fasilitas'])
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
        if($request->ajax()){
            $data['group'] = $request->group;

            $los = $this->multipleSelect($request->los);
            $data['jml_los'] = count($los);
            sort($los, SORT_NATURAL);
            $data['no_los'] = implode(',', $los);

            $data['kd_kontrol'] = strtoupper($request->kontrol);
            $data['nicename'] = str_replace('-','',$request->kontrol);

            $data['id_pengguna'] = $request->pengguna;
            $data['id_pemilik'] = $request->pemilik;

            $data['status'] = $request->status;
            $data['ket'] = $request->ket;

            if(!is_null($request->commodity)){
                $komoditi = $this->multipleSelect($request->commodity);
                sort($komoditi, SORT_NATURAL);
                $data['komoditi'] = implode(',', $komoditi);
            }

            $data['lokasi'] = $request->location;

            if(!empty($request->fas_listrik)){
                $tools = TListrik::find($request->tlistrik);
                $tools->stt_available = 0;
                $tools->save();

                $data['fas_listrik'] = json_encode([
                    'id_tools' => $request->tlistrik,
                    'id_price' => $request->plistrik,
                    'dis_listrik' => $request->dlistrik
                ]);
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
                Shops::create($data);
            }
            catch(\Exception $e){
                return response()->json(['error' => 'Data failed to create.', 'description' => $e]);
            }

            $searchKey = str_replace('-','',$request->kontrol);

            return response()->json(['success' => 'Data saved.', 'searchKey' => $searchKey]);
        }
        else{
            abort(404);
        }
    }

    public function gKontrol(Request $request){
        $group = $request->group;
        $los = $this->multipleSelect($request->los);
        sort($los, SORT_NATURAL);

        $los = $los[0];
        $data = Shops::kontrol($group,$los);
        return response()->json(['success' => $data]);
    }

    public function multipleSelect($data){
        $temp = [];
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
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
        if(request()->ajax()){
            try{
                $data = Shops::findOrFail($id);
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
