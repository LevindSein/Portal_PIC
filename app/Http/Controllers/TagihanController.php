<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Tempat;
use App\Models\Group;
use App\Models\Tarif;
use App\Models\Periode;
use App\Models\Alat;
use App\Models\Tagihan;

use Carbon\Carbon;

use Excel;
use DataTables;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $status = $request->status;
            $periode = $request->periode;

            $data = Tagihan::with('pengguna:id,name')->where([
                ['status', $status],
                ['periode_id', $periode]
            ]);

            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '';
                if($data->status){
                    if($data->stt_publish){
                        if(($data->listrik && $data->listrik->lunas) && ($data->airbersih && $data->airbersih->lunas) && ($data->keamananipk && $data->keamananipk->lunas) && ($data->kebersihan && $data->kebersihan->lunas) && ($data->airkotor && $data->airkotor->lunas) && ($data->lainnya && $data->lainnya->lunas)){
                            $button .= '<a type="button" data-toggle="tooltip" title="Semua Lunas" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-check"></i></a>';
                        } else {
                            $button .= '<a type="button" data-toggle="tooltip" title="Batalkan Publish" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="publish btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-undo"></i></a>';
                        }
                    } else {
                        if(!(($data->listrik && $data->listrik->lunas) && ($data->airbersih && $data->airbersih->lunas) && ($data->keamananipk && $data->keamananipk->lunas) && ($data->kebersihan && $data->kebersihan->lunas) && ($data->airkotor && $data->airkotor->lunas) && ($data->lainnya && $data->lainnya->lunas))){
                            $button .= '<a type="button" data-toggle="tooltip" title="Edit" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="edit btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-marker"></i></a>';
                        }
                        $button .= '<a type="button" data-toggle="tooltip" title="Hapus" id="'.Crypt::encrypt($data->id).'" status="" nama="'.$data->name.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash"></i></a>';
                        $button .= '<a type="button" data-toggle="tooltip" title="Publish" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="publish btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-paper-plane"></i></a>';
                    }
                } else {
                    $button .= '<a type="button" data-toggle="tooltip" title="Hapus Permanen" id="'.Crypt::encrypt($data->id).'" status="Permanen " nama="'.$data->name.'" class="delete btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-trash-alt"></i></a>';
                    $button .= '<a type="button" data-toggle="tooltip" title="Aktifkan" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="aktif btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-lightbulb-on"></i></a>';
                }
                $button .= '<a type="button" data-toggle="tooltip" title="Rincian" id="'.Crypt::encrypt($data->id).'" nama="'.$data->name.'" class="detail btn btn-sm btn-neutral btn-icon"><i class="fas fa-fw fa-info"></i></a>';
                return $button;
            })
            ->addColumn('fasilitas', function($data){
                $listrik = '';
                if($data->listrik){
                    $li = $data->listrik;
                    $daya = number_format($li->daya, 0, '', '.');
                    $awal = number_format($li->awal, 0, '', '.');
                    $akhir = number_format($li->akhir, 0, '', '.');
                    $pakai = number_format($li->pakai, 0, '', '.');
                    $total = number_format($li->total, 0, '', '.');
                    if($li->lunas)
                        $listrik = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Listrik' data-content='Daya: $daya<br>Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br><b>Tagihan: $total</b>'><i class='fas fa-bolt' style='color:#1cc88a;'></i></a>";
                    else
                        $listrik = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Listrik' data-content='Daya: $daya<br>Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br><b>Tagihan: $total</b>'><i class='fas fa-bolt' style='color:#d7d8cc;'></i></a>";
                }
                $airbersih = '';
                if($data->airbersih){
                    $ab = $data->airbersih;
                    $awal = number_format($ab->awal, 0, '', '.');
                    $akhir = number_format($ab->akhir, 0, '', '.');
                    $pakai = number_format($ab->pakai, 0, '', '.');
                    $total = number_format($ab->total, 0, '', '.');
                    if($ab->lunas)
                        $airbersih = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Air Bersih' data-content='Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br><b>Tagihan: $total</b>'><i class='fas fa-tint' style='color:#1cc88a;'></i></a>";
                    else
                        $airbersih = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Air Bersih' data-content='Awal: $awal<br>Akhir: $akhir<br>Pakai: $pakai<br><b>Tagihan: $total</b>'><i class='fas fa-tint' style='color:#d7d8cc;'></i></a>";
                }
                $keamananipk = '';
                if($data->keamananipk){
                    $ki = $data->keamananipk;
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $total = number_format($ki->total, 0, '', '.');
                    if($ki->lunas)
                        $keamananipk = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Keamanan IPK' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-lock' style='color:#1cc88a;'></i></a>";
                    else
                        $keamananipk = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Keamanan IPK' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-lock' style='color:#d7d8cc;'></i></a>";
                }
                $kebersihan = '';
                if($data->kebersihan){
                    $kb = $data->kebersihan;
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $total = number_format($kb->total, 0, '', '.');
                    if($kb->lunas)
                        $kebersihan = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Kebersihan' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-leaf' style='color:#1cc88a;'></i></a>";
                    else
                        $kebersihan = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Kebersihan' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-leaf' style='color:#d7d8cc;'></i></a>";
                }
                $airkotor = '';
                if($data->airkotor){
                    $ak = $data->airkotor;
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $total = number_format($ak->total, 0, '', '.');
                    if($ak->lunas)
                        $airkotor = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Air Kotor' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-burn' style='color:#1cc88a;'></i></a>";
                    else
                        $airkotor = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Air Kotor' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-burn' style='color:#d7d8cc;'></i></a>";
                }
                $lainnya = '';
                if($data->lainnya){
                    $la = $data->lainnya;
                    $jml_los = number_format($data->jml_los, 0, '', '.');
                    $total = number_format($la->total, 0, '', '.');
                    if($la->lunas)
                        $lainnya = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Lainnya' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-chart-pie' style='color:#1cc88a;'></i></a>";
                    else
                        $lainnya = "<a type='button' class='mr-1 ml-1' data-container='body' data-trigger='hover' data-toggle='popover' data-html='true' title='Lainnya' data-content='Jml Los: $jml_los<br><b>Tagihan: $total</b>'><i class='fas fa-chart-pie' style='color:#d7d8cc;'></i></a>";
                }
                return $listrik.$airbersih.$keamananipk.$kebersihan.$airkotor.$lainnya;
            })
            ->editColumn('pengguna.name', function($data){
                $name = $data->pengguna->name;
                if(strlen($name) > 15) {
                    $name = substr($name, 0, 11);
                    $name = str_pad($name,  15, ".");
                }

                return "<span data-toggle='tooltip' title='" . $data->pengguna->name . "'>$name</span>";
            })
            ->editColumn('tagihan', function($data){
                return number_format($data->tagihan->total, 0, ',', '.');
            })
            ->filterColumn('name', function ($query, $keyword) {
                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(name, nicename) like ?", ["%{$keywords}%"]);
            })
            ->rawColumns(['action', 'fasilitas', 'pengguna.name', 'tagihan'])
            ->make(true);
        }
        return view('Tagihan.index');
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
            $input['periode'] = $request->tambah_periode;
            $periode = Periode::findOrFail($input['periode']);

            $diff_month = Periode::diffInMonth($periode);

            $input['tempat_usaha'] = $request->tambah_tempat;

            $input['pengguna'] = $request->tambah_pengguna;

            Validator::make($input, [
                'periode'      => 'required|exists:periode,id',
                'tempat_usaha' => 'required|exists:tempat,id',
                'pengguna'     => 'required|exists:users,id',
            ])->validate();

            $los = $this->multipleSelect($request->tambah_los);
            sort($los, SORT_NATURAL);
            $jml_los = count($los);

            $no_los = Group::findOrFail(Tempat::findOrFail($input['tempat_usaha'])->group_id);
            foreach($los as $l){
                $input['nomor_los'] = $l;
                Validator::make($input, [
                    'nomor_los' => 'required|in:' . implode(',', json_decode($no_los->data)),
                ])->validate();
            }

            $diskon = [];

            $data['trf_listrik_id'] = NULL;
            $data['alat_listrik_id'] = NULL;
            if($request->tambah_listrik){
                $input['alat_listrik'] = $request->tambah_alat_listrik;
                $input['tarif_listrik'] = $request->tambah_trf_listrik;
                $input['diskon_listrik'] = $request->tambah_dis_listrik;
                $input['awal_stand_listrik'] = str_replace('.', '', $request->tambah_awal_listrik);
                $input['akhir_stand_listrik'] = str_replace('.', '', $request->tambah_akhir_listrik);

                Validator::make($input, [
                    'alat_listrik'   => ['required','numeric',
                                            Rule::exists('alat', 'id')
                                            ->where('level', 1)
                                        ],
                    'tarif_listrik'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 1)
                                        ],
                    'diskon_listrik' => 'nullable|numeric|gte:0|lte:100',
                    'awal_stand_listrik' => 'required|numeric|gte:0|lte:999999999999',
                    'akhir_stand_listrik' => 'required|numeric|gte:0|lte:999999999999'
                ])->validate();

                $data['alat_listrik_id'] = $input['alat_listrik'];
                $data['trf_listrik_id']  = $input['tarif_listrik'];
                if($input['diskon_listrik']){
                    $diskon['listrik']   = $input['diskon_listrik'];
                }
            }

            $data['trf_airbersih_id'] = NULL;
            $data['alat_airbersih_id'] = NULL;
            if($request->tambah_airbersih){
                $input['alat_air_bersih'] = $request->tambah_alat_airbersih;
                $input['tarif_air_bersih'] = $request->tambah_trf_airbersih;
                $input['diskon_air_bersih'] = $request->tambah_dis_airbersih;
                $input['awal_stand_air_bersih'] = str_replace('.', '', $request->tambah_awal_airbersih);
                $input['akhir_stand_air_bersih'] = str_replace('.', '', $request->tambah_akhir_airbersih);

                Validator::make($input, [
                    'alat_air_bersih'   => ['required','numeric',
                                            Rule::exists('alat', 'id')
                                            ->where('level', 2)
                                        ],
                    'tarif_air_bersih'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 2)
                                        ],
                    'diskon_air_bersih' => 'nullable|numeric|gte:0|lte:100',
                    'awal_stand_air_bersih' => 'required|numeric|gte:0|lte:999999999999',
                    'akhir_stand_air_bersih' => 'required|numeric|gte:0|lte:999999999999'
                ])->validate();

                $data['alat_airbersih_id'] = $input['alat_air_bersih'];
                $data['trf_airbersih_id']  = $input['tarif_air_bersih'];
                if($input['diskon_air_bersih']){
                    $diskon['airbersih']   = $input['diskon_air_bersih'];
                }
            }

            $data['trf_keamananipk_id'] = NULL;
            if($request->tambah_keamananipk){
                $input['tarif_keamanan_ipk'] = $request->tambah_trf_keamananipk;
                $input['diskon_keamanan_ipk'] = str_replace('.', '', $request->tambah_dis_keamananipk);

                Validator::make($input, [
                    'tarif_keamanan_ipk'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 3)
                                        ]
                ])->validate();

                $tarif = Tarif::findOrFail($input['tarif_keamanan_ipk']);
                $max = count($los) * $tarif->data->Tarif;

                Validator::make($input, [
                    'diskon_keamanan_ipk' => 'nullable|numeric|gte:0|lte:' . $max,
                ])->validate();

                $data['trf_keamananipk_id']  = $input['tarif_keamanan_ipk'];
                if($input['diskon_keamanan_ipk']){
                    $diskon['keamananipk']   = $input['diskon_keamanan_ipk'];
                }
            }

            $data['trf_kebersihan_id'] = NULL;
            if($request->tambah_kebersihan){
                $input['tarif_kebersihan'] = $request->tambah_trf_kebersihan;
                $input['diskon_kebersihan'] = str_replace('.', '', $request->tambah_dis_kebersihan);

                Validator::make($input, [
                    'tarif_kebersihan'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 4)
                                        ]
                ])->validate();

                $tarif = Tarif::findOrFail($input['tarif_kebersihan']);
                $max = count($los) * $tarif->data->Tarif;

                Validator::make($input, [
                    'diskon_kebersihan' => 'nullable|numeric|gte:0|lte:' . $max,
                ])->validate();

                $data['trf_kebersihan_id']  = $input['tarif_kebersihan'];
                if($input['diskon_kebersihan']){
                    $diskon['kebersihan']   = $input['diskon_kebersihan'];
                }
            }

            $data['trf_airkotor_id'] = NULL;
            if($request->tambah_airkotor){
                $input['tarif_air_kotor'] = $request->tambah_trf_airkotor;
                $input['diskon_air_kotor'] = 0;
                if($request->tambah_dis_airkotor){
                    $input['diskon_air_kotor'] = str_replace('.', '', $request->tambah_dis_airkotor);
                }

                Validator::make($input, [
                    'tarif_air_kotor'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 5)
                                        ]
                ])->validate();

                $tarif = Tarif::findOrFail($input['tarif_air_kotor']);

                if($tarif->status == 'per-Los'){
                    $max = count($los) * $tarif->data->Tarif;
                } else {
                    $max = $tarif->data->Tarif;
                }

                Validator::make($input, [
                    'diskon_air_kotor' => 'nullable|numeric|gte:0|lte:' . $max,
                ])->validate();

                $data['trf_airkotor_id']  = $input['tarif_air_kotor'];
                if($input['diskon_air_kotor']){
                    $diskon['airkotor']   = $input['diskon_air_kotor'];
                }
            }

            $data['trf_lainnya_id'] = NULL;
            if($request->tambah_lainnya){
                $lainnya = [];
                foreach ($request->tambah_lainnya as $key) {
                    $input['tarif_lainnya']  = $key;

                    Validator::make($input, [
                        'tarif_lainnya'
                        => ['required','numeric',
                            Rule::exists('tarif', 'id')
                            ->where('level', 6)
                        ]
                    ])->validate();

                    $lainnya[] = $key;
                }

                $data['trf_lainnya_id'] = json_encode($lainnya);
            }

            $data['los']         = json_encode($los);
            $data['jml_los']     = $jml_los;
            $data['pengguna_id'] = $input['pengguna'];
            $data['diskon']      = json_encode($diskon);

            DB::transaction(function() use ($data, $input){
                $dataset = Tempat::lockForUpdate()->findOrFail($input['tempat_usaha']);

                if($dataset->alat_listrik_id){
                    $alat = Alat::findOrFail($dataset->alat_listrik_id);
                    $alat->status = 1;
                    $alat->save();
                }

                if($data['alat_listrik_id']){
                    $alat = Alat::findOrFail($data['alat_listrik_id']);
                    $alat->status = 0;
                    $alat->save();
                }

                if($dataset->alat_airbersih_id){
                    $alat = Alat::findOrFail($dataset->alat_airbersih_id);
                    $alat->status = 1;
                    $alat->save();
                }

                if($data['alat_airbersih_id']){
                    $alat = Alat::findOrFail($data['alat_airbersih_id']);
                    $alat->status = 0;
                    $alat->save();
                }

                $dataset->update($data);
            });

            return response()->json(['success' => 'Data berhasil disimpan.', 'debug' => $input['periode']]);
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

            $data = Tagihan::with('periode', 'pengguna')->findOrFail($decrypted);

            if($data->listrik){
                $listrik = [];
                $dataset = $data->listrik;
                $listrik['Status_Lunas'] = ($dataset->lunas) ? 'Lunas' : 'Belum Lunas';
                $listrik['Kasir'] = $dataset->kasir;
                $listrik['Tarif'] = Tarif::findOrFail($data->listrik->tarif)->name;
                $alat = Alat::findOrFail($data->listrik->alat);
                $listrik['Alat_Meter'] = $alat->name;
                $listrik['Daya'] = number_format($dataset->daya, 0, ',', '.') . ' Watt';
                $listrik['Stand_Awal'] = number_format($dataset->awal, 0, ',', '.');
                $listrik['Stand_Akhir'] = number_format($dataset->akhir, 0, ',', '.');
                $listrik['Status_Reset'] = ($dataset->reset) ? 'Ya' : 'Tidak';
                $listrik['Pemakaian'] = number_format($dataset->pakai, 0, ',', '.');
                $listrik['Rekmin'] = 'Rp ' . number_format($dataset->rekmin, 0, ',', '.') . ',-';
                $listrik['Blok_1'] = 'Rp ' . number_format($dataset->blok1, 0, ',', '.') . ',-';
                $listrik['Blok_2'] = 'Rp ' . number_format($dataset->blok2, 0, ',', '.') . ',-';
                $listrik['Beban'] = 'Rp ' . number_format($dataset->beban, 0, ',', '.') . ',-';
                $listrik['PJU'] = 'Rp ' . number_format($dataset->pju, 0, ',', '.') . ',-';
                $listrik['Subtotal'] = 'Rp ' . number_format($dataset->subtotal, 0, ',', '.') . ',-';
                $listrik['PPN'] = 'Rp ' . number_format($dataset->ppn, 0, ',', '.') . ',-';
                $listrik['Denda'] = 'Rp ' . number_format($dataset->denda, 0, ',', '.') . ',-';
                $listrik['Diskon'] = 'Rp ' . number_format($dataset->diskon, 0, ',', '.') . ',-';
                $listrik['Total'] = 'Rp ' . number_format($dataset->total, 0, ',', '.') . ',-';
                $listrik['Realisasi'] = 'Rp ' . number_format($dataset->realisasi, 0, ',', '.') . ',-';
                $listrik['Selisih'] = 'Rp ' . number_format($dataset->selisih, 0, ',', '.') . ',-';
                $data['data_listrik'] = $listrik;
            }

            if($data->airbersih){
                $airbersih = [];
                $dataset = $data->airbersih;
                $airbersih['Status_Lunas'] = ($dataset->lunas) ? 'Lunas' : 'Belum Lunas';
                $airbersih['Kasir'] = $dataset->kasir;
                $airbersih['Tarif'] = Tarif::findOrFail($data->airbersih->tarif)->name;
                $alat = Alat::findOrFail($data->airbersih->alat);
                $airbersih['Alat_Meter'] = $alat->name;
                $airbersih['Stand_Awal'] = number_format($dataset->awal, 0, ',', '.');
                $airbersih['Stand_Akhir'] = number_format($dataset->akhir, 0, ',', '.');
                $airbersih['Status_Reset'] = ($dataset->reset) ? 'Ya' : 'Tidak';
                $airbersih['Pemakaian'] = number_format($dataset->pakai, 0, ',', '.');
                $airbersih['Standar'] = 'Rp ' . number_format($dataset->bayar, 0, ',', '.') . ',-';
                $airbersih['Pemeliharaan'] = 'Rp ' . number_format($dataset->pemeliharaan, 0, ',', '.') . ',-';
                $airbersih['Beban'] = 'Rp ' . number_format($dataset->beban, 0, ',', '.') . ',-';
                $airbersih['Air_Kotor'] = 'Rp ' . number_format($dataset->airkotor, 0, ',', '.') . ',-';
                $airbersih['Subtotal'] = 'Rp ' . number_format($dataset->subtotal, 0, ',', '.') . ',-';
                $airbersih['PPN'] = 'Rp ' . number_format($dataset->ppn, 0, ',', '.') . ',-';
                $airbersih['Denda'] = 'Rp ' . number_format($dataset->denda, 0, ',', '.') . ',-';
                $airbersih['Diskon'] = 'Rp ' . number_format($dataset->diskon, 0, ',', '.') . ',-';
                $airbersih['Total'] = 'Rp ' . number_format($dataset->total, 0, ',', '.') . ',-';
                $airbersih['Realisasi'] = 'Rp ' . number_format($dataset->realisasi, 0, ',', '.') . ',-';
                $airbersih['Selisih'] = 'Rp ' . number_format($dataset->selisih, 0, ',', '.') . ',-';
                $data['data_airbersih'] = $airbersih;
            }

            if($data->keamananipk){
                $keamananipk = [];
                $dataset = $data->keamananipk;
                $keamananipk['Status_Lunas'] = ($dataset->lunas) ? 'Lunas' : 'Belum Lunas';
                $keamananipk['Kasir'] = $dataset->kasir;
                $tarif = Tarif::findOrFail($data->keamananipk->tarif);
                $keamananipk['Nama_Tarif'] = $tarif->name;
                $keamananipk['Tarif'] = 'Rp ' . number_format($tarif->data->Tarif, 0, ',', '.') . ',-' . " " . $tarif->status;
                $keamananipk['Keamanan'] = 'Rp ' . number_format($dataset->keamanan, 0, ',', '.') . ',-';
                $keamananipk['IPK'] = 'Rp ' . number_format($dataset->ipk, 0, ',', '.') . ',-';
                $keamananipk['Subtotal'] = 'Rp ' . number_format($dataset->subtotal, 0, ',', '.') . ',-';
                $keamananipk['Diskon'] = 'Rp ' . number_format($dataset->diskon, 0, ',', '.') . ',-';
                $keamananipk['Total'] = 'Rp ' . number_format($dataset->total, 0, ',', '.') . ',-';
                $keamananipk['Realisasi'] = 'Rp ' . number_format($dataset->realisasi, 0, ',', '.') . ',-';
                $keamananipk['Selisih'] = 'Rp ' . number_format($dataset->selisih, 0, ',', '.') . ',-';
                $data['data_keamananipk'] = $keamananipk;
            }

            if($data->kebersihan){
                $kebersihan = [];
                $dataset = $data->kebersihan;
                $kebersihan['Status_Lunas'] = ($dataset->lunas) ? 'Lunas' : 'Belum Lunas';
                $kebersihan['Kasir'] = $dataset->kasir;
                $tarif = Tarif::findOrFail($data->kebersihan->tarif);
                $kebersihan['Nama_Tarif'] = $tarif->name;
                $kebersihan['Tarif'] = 'Rp ' . number_format($tarif->data->Tarif, 0, ',', '.') . ',-' . " " . $tarif->status;
                $kebersihan['Subtotal'] = 'Rp ' . number_format($dataset->subtotal, 0, ',', '.') . ',-';
                $kebersihan['Diskon'] = 'Rp ' . number_format($dataset->diskon, 0, ',', '.') . ',-';
                $kebersihan['Total'] = 'Rp ' . number_format($dataset->total, 0, ',', '.') . ',-';
                $kebersihan['Realisasi'] = 'Rp ' . number_format($dataset->realisasi, 0, ',', '.') . ',-';
                $kebersihan['Selisih'] = 'Rp ' . number_format($dataset->selisih, 0, ',', '.') . ',-';
                $data['data_kebersihan'] = $kebersihan;
            }

            if($data->airkotor){
                $airkotor = [];
                $dataset = $data->airkotor;
                $airkotor['Status_Lunas'] = ($dataset->lunas) ? 'Lunas' : 'Belum Lunas';
                $airkotor['Kasir'] = $dataset->kasir;
                $tarif = Tarif::findOrFail($data->airkotor->tarif);
                $airkotor['Nama_Tarif'] = $tarif->name;
                $airkotor['Tarif'] = 'Rp ' . number_format($tarif->data->Tarif, 0, ',', '.') . ',-' . " " . $tarif->status;
                $airkotor['Subtotal'] = 'Rp ' . number_format($dataset->subtotal, 0, ',', '.') . ',-';
                $airkotor['Diskon'] = 'Rp ' . number_format($dataset->diskon, 0, ',', '.') . ',-';
                $airkotor['Total'] = 'Rp ' . number_format($dataset->total, 0, ',', '.') . ',-';
                $airkotor['Realisasi'] = 'Rp ' . number_format($dataset->realisasi, 0, ',', '.') . ',-';
                $airkotor['Selisih'] = 'Rp ' . number_format($dataset->selisih, 0, ',', '.') . ',-';
                $data['data_airkotor'] = $airkotor;
            }

            if($data->lainnya){
                $lainnya = [];
                $dataset = $data->lainnya;
                $lainnya['Status_Lunas'] = ($dataset->lunas) ? 'Lunas' : 'Belum Lunas';
                $lainnya['Kasir'] = $dataset->kasir;
                foreach ($dataset->data as $key) {
                    $tarif = Tarif::findOrFail($key->tarif);
                    $lainnya['Tarif_'.$tarif->name] = 'Rp ' . number_format($tarif->data->Tarif, 0, ',', '.') . ',-' . " " . $tarif->status;
                    $lainnya['Total_'.$tarif->name] = 'Rp ' . number_format($key->total, 0, ',', '.') . ',-';
                }
                $lainnya['Subtotal'] = 'Rp ' . number_format($dataset->subtotal, 0, ',', '.') . ',-';
                $lainnya['Total'] = 'Rp ' . number_format($dataset->total, 0, ',', '.') . ',-';
                $lainnya['Realisasi'] = 'Rp ' . number_format($dataset->realisasi, 0, ',', '.') . ',-';
                $lainnya['Selisih'] = 'Rp ' . number_format($dataset->selisih, 0, ',', '.') . ',-';
                $data['data_lainnya'] = $lainnya;
            }

            $tagihan = [];
            $dataset = $data->tagihan;
            $tagihan['Subtotal'] = 'Rp ' . number_format($dataset->subtotal, 0, ',', '.') . ',-';
            $tagihan['PPN'] = 'Rp ' . number_format($dataset->ppn, 0, ',', '.') . ',-';
            $tagihan['Denda'] = 'Rp ' . number_format($dataset->denda, 0, ',', '.') . ',-';
            $tagihan['Diskon'] = 'Rp ' . number_format($dataset->diskon, 0, ',', '.') . ',-';
            $tagihan['Total'] = 'Rp ' . number_format($dataset->total, 0, ',', '.') . ',-';
            $tagihan['Realisasi'] = 'Rp ' . number_format($dataset->realisasi, 0, ',', '.') . ',-';
            $tagihan['Selisih'] = 'Rp ' . number_format($dataset->selisih, 0, ',', '.') . ',-';
            $data['data_tagihan'] = $tagihan;

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

            $data = Tagihan::with('periode', 'pengguna', 'group')->findOrFail($decrypted);

            if($data->listrik){
                $data['trf_listrik_id']  = Tarif::findOrFail($data->listrik->tarif);
                $data['alat_listrik_id'] = Alat::findOrFail($data->listrik->alat);
            }

            if($data->airbersih){
                $data['trf_airbersih_id']  = Tarif::findOrFail($data->airbersih->tarif);
                $data['alat_airbersih_id'] = Alat::findOrFail($data->airbersih->alat);
            }

            if($data->keamananipk){
                $data['trf_keamananipk_id']  = Tarif::findOrFail($data->keamananipk->tarif);
            }

            if($data->kebersihan){
                $data['trf_kebersihan_id']  = Tarif::findOrFail($data->kebersihan->tarif);
            }

            if($data->airkotor){
                $data['trf_airkotor_id']  = Tarif::findOrFail($data->airkotor->tarif);
            }

            if($data->lainnya){
                $lainnya = [];
                foreach ($data->lainnya->data as $key) {
                    $lainnya[] = Tarif::findOrFail($key->tarif);
                }
                $data['trf_lainnya'] = $lainnya;
            }

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
        return response()->json(['success' => 'Data berhasil disimpan.']);
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
                $data = Tagihan::lockForUpdate()->findOrFail($decrypted);

                if($data->status){
                    $data->update([
                        'status' => 0
                    ]);
                } else {
                    $data->delete();
                }
            });

            return response()->json(['success' => "Data berhasil dihapus."]);
        }
    }

    public function publish($id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $message = DB::transaction(function() use ($decrypted){
                $data = Tagihan::lockForUpdate()->findOrFail($decrypted);

                if($data->stt_publish){
                    $publish = 0;
                    $message = 'Data Tagihan dibatalkan.';
                } else {
                    $publish = 1;
                    $message = 'Data Tagihan dipublish.';
                }

                $data->update([
                    'stt_publish' => $publish
                ]);

                return $message;
            });
            return response()->json(['success' => $message]);
        }
    }

    public function aktif($id)
    {
        if(request()->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            $message = DB::transaction(function() use ($decrypted){
                $data = Tagihan::lockForUpdate()->findOrFail($decrypted);

                $data->update([
                    'status' => 1
                ]);
            });
            return response()->json(['success' => 'Data berhasil diaktifkan.']);
        }
    }

    public function tempat($id)
    {
        if(request()->ajax()){
            $data = Tempat::with('group', 'pengguna')->findOrFail($id);

            if($data->trf_listrik_id){
                $data['trf_listrik_id']  = Tarif::findOrFail($data->trf_listrik_id);
                $data['alat_listrik_id'] = Alat::findOrFail($data->alat_listrik_id);
            }

            if($data->trf_airbersih_id){
                $data['trf_airbersih_id']  = Tarif::findOrFail($data->trf_airbersih_id);
                $data['alat_airbersih_id'] = Alat::findOrFail($data->alat_airbersih_id);
            }

            if($data->trf_keamananipk_id){
                $data['trf_keamananipk_id'] = Tarif::findOrFail($data->trf_keamananipk_id);
            }

            if($data->trf_kebersihan_id){
                $data['trf_kebersihan_id'] = Tarif::findOrFail($data->trf_kebersihan_id);
            }

            if($data->trf_airkotor_id){
                $data['trf_airkotor_id'] = Tarif::findOrFail($data->trf_airkotor_id);
            }

            if($data->trf_lainnya_id){
                $lainnya = [];
                foreach ($data->trf_lainnya_id as $key) {
                    $lainnya[] = Tarif::findOrFail($key);
                }
                $data['trf_lainnya'] = $lainnya;
            }

            return response()->json(['success' => $data]);
        }
    }

    public function multipleSelect($data){
        $temp = [];
        for($i = 0; $i < count($data); $i++){
            $temp[$i] = $data[$i];
        }
        return $temp;
    }
}
