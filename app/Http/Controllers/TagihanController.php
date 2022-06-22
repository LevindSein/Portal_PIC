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
use PDO;

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
                    if($data->listrik->lunas)
                        $listrik = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Listrik"><i class="fas fa-bolt" style="color:#1cc88a;"></i></a>';
                    else
                        $listrik = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Listrik"><i class="fas fa-bolt" style="color:#d7d8cc;"></i></a>';
                }
                $airbersih = '';
                if($data->airbersih){
                    if($data->airbersih->lunas)
                        $airbersih = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Air Bersih"><i class="fas fa-tint" style="color:#1cc88a;"></i></a>';
                    else
                        $airbersih = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Air Bersih"><i class="fas fa-tint" style="color:#d7d8cc;"></i></a>';
                }
                $keamananipk = '';
                if($data->keamananipk){
                    if($data->keamananipk->lunas)
                        $keamananipk = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Keamanan IPK"><i class="fas fa-lock" style="color:#1cc88a;"></i></a>';
                    else
                        $keamananipk = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Keamanan IPK"><i class="fas fa-lock" style="color:#d7d8cc;"></i></a>';
                }
                $kebersihan = '';
                if($data->kebersihan){
                    if($data->kebersihan->lunas)
                        $kebersihan = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Kebersihan"><i class="fas fa-leaf" style="color:#1cc88a;"></i></a>';
                    else
                        $kebersihan = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Kebersihan"><i class="fas fa-leaf" style="color:#d7d8cc;"></i></a>';
                }
                $airkotor = '';
                if($data->airkotor){
                    if($data->airkotor->lunas)
                        $airkotor = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Air Kotor"><i class="fas fa-burn" style="color:#1cc88a;"></i></a>';
                    else
                        $airkotor = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Air Kotor"><i class="fas fa-burn" style="color:#d7d8cc;"></i></a>';
                }
                $lainnya = '';
                if($data->lainnya){
                    if($data->lainnya->lunas)
                        $lainnya = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Lainnya"><i class="fas fa-chart-pie" style="color:#1cc88a;"></i></a>';
                    else
                        $lainnya = '<a type="button" class="mr-1 ml-1" data-html="true" data-toggle="tooltip" title="Lainnya"><i class="fas fa-chart-pie" style="color:#d7d8cc;"></i></a>';
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
            ->rawColumns(['action', 'fasilitas', 'name', 'pengguna.name', 'tagihan'])
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
            $input['nomor_los'] = $los;
            $jml_los = count($input['nomor_los']);

            $no_los = Group::findOrFail(Tempat::findOrFail($input['tempat_usaha'])->group_id);
            foreach($los as $l){
                $input['nomor_los'] = $l;
                Validator::make($input, [
                    'nomor_los' => 'required|in:' . implode(',', json_decode($no_los->data)),
                ])->validate();
            }

            $subtotal = 0;
            $denda = 0;
            $diskon = 0;
            $ppn = 0;
            $total = 0;

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
                                            ->where('status', 1)
                                        ],
                    'tarif_listrik'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 1)
                                        ],
                    'diskon_listrik' => 'nullable|numeric|gte:0|lte:100',
                    'awal_stand_listrik' => 'required|numeric|gte:0|lte:999999999999',
                    'akhir_stand_listrik' => 'required|numeric|gte:0|lte:999999999999'
                ])->validate();

                $tarif = Tarif::findOrFail($input['tarif_listrik']);
                $alat = Alat::findOrFail($input['alat_listrik']);

                $daya = $alat->daya;
                $awal = $input['awal_stand_listrik'];
                $akhir = $input['akhir_stand_listrik'];

                $pakai = $akhir - $awal;
                $reset = 0;
                if($awal > $akhir){
                    $pakai = ($akhir + (str_repeat(9, strlen($awal)))) - $awal;
                    $reset = 1;
                }

                $tagihan = Tarif::listrik($tarif->data, $pakai, $daya, $diff_month, $input['diskon_listrik']);

                $data['listrik'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'alat'          => $input['alat_listrik'],
                    'tarif'         => $input['tarif_listrik'],
                    'daya'          => (int)$daya,
                    'awal'          => (int)$awal,
                    'akhir'         => (int)$akhir,
                    'reset'         => (int)$reset,
                    'pakai'         => (int)$pakai,
                    'rekmin'        => (int)$tagihan['rekmin'],
                    'blok1'         => (int)$tagihan['blok1'],
                    'blok2'         => (int)$tagihan['blok2'],
                    'beban'         => (int)$tagihan['beban'],
                    'pju'           => (int)$tagihan['pju'],
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'ppn'           => (int)$tagihan['ppn'],
                    'denda'         => (int)$tagihan['denda'],
                    'denda_bulan'   => (int)$diff_month,
                    'diskon'        => (int)$tagihan['diskon'],
                    'diskon_persen' => (int)$input['diskon_listrik'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $ppn += $tagihan['ppn'];
                $denda += $tagihan['denda'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

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
                                            ->where('status', 1)
                                        ],
                    'tarif_air_bersih'  => ['required','numeric',
                                            Rule::exists('tarif', 'id')
                                            ->where('level', 2)
                                        ],
                    'diskon_air_bersih' => 'nullable|numeric|gte:0|lte:100',
                    'awal_stand_air_bersih' => 'required|numeric|gte:0|lte:999999999999',
                    'akhir_stand_air_bersih' => 'required|numeric|gte:0|lte:999999999999'
                ])->validate();

                $tarif = Tarif::findOrFail($input['tarif_air_bersih']);
                $alat = Alat::findOrFail($input['alat_air_bersih']);

                $awal = $input['awal_stand_air_bersih'];
                $akhir = $input['akhir_stand_air_bersih'];

                $pakai = $akhir - $awal;
                $reset = 0;
                if($awal > $akhir){
                    $pakai = ($akhir + (str_repeat(9, strlen($awal)))) - $awal;
                    $reset = 1;
                }

                $tagihan = Tarif::airbersih($tarif->data, $pakai, $diff_month, $input['diskon_air_bersih']);

                $data['airbersih'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'alat'          => $input['alat_air_bersih'],
                    'tarif'         => $input['tarif_air_bersih'],
                    'awal'          => (int)$awal,
                    'akhir'         => (int)$akhir,
                    'reset'         => (int)$reset,
                    'pakai'         => (int)$pakai,
                    'bayar'         => (int)$tagihan['bayar'],
                    'pemeliharaan'  => (int)$tagihan['pemeliharaan'],
                    'beban'         => (int)$tagihan['beban'],
                    'airkotor'      => (int)$tagihan['airkotor'],
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'ppn'           => (int)$tagihan['ppn'],
                    'denda'         => (int)$tagihan['denda'],
                    'denda_bulan'   => (int)$diff_month,
                    'diskon'        => (int)$tagihan['diskon'],
                    'diskon_persen' => (int)$input['diskon_air_bersih'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $ppn += $tagihan['ppn'];
                $denda += $tagihan['denda'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_keamananipk){
                $input['tarif_keamanan_ipk'] = $request->tambah_trf_keamananipk;
                $input['diskon_keamanan_ipk'] = 0;
                if($request->tambah_dis_keamananipk){
                    $input['diskon_keamanan_ipk'] = str_replace('.', '', $request->tambah_dis_keamananipk);
                }

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

                $tagihan = Tarif::keamananipk($tarif->data, $jml_los, $input['diskon_keamanan_ipk']);

                $data['keamananipk'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'tarif'         => $input['tarif_keamanan_ipk'],
                    'jml_los'       => (int)$jml_los,
                    'keamanan'      => (int)$tagihan['keamanan'],
                    'ipk'           => (int)$tagihan['ipk'],
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'diskon'        => (int)$tagihan['diskon'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_kebersihan){
                $input['tarif_kebersihan'] = $request->tambah_trf_kebersihan;
                $input['diskon_kebersihan'] = 0;
                if($request->tambah_dis_kebersihan){
                    $input['diskon_kebersihan'] = str_replace('.', '', $request->tambah_dis_kebersihan);
                }

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

                $tagihan = Tarif::kebersihan($tarif->data, $jml_los, $input['diskon_kebersihan']);

                $data['kebersihan'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'tarif'         => $input['tarif_kebersihan'],
                    'jml_los'       => (int)$jml_los,
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'diskon'        => (int)$tagihan['diskon'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

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

                $tagihan = Tarif::airkotor($tarif->data, $jml_los, $tarif->status, $input['diskon_air_kotor']);

                $data['airkotor'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'tarif'         => $input['tarif_air_kotor'],
                    'jml_los'       => (int)$jml_los,
                    'subtotal'      => (int)$tagihan['subtotal'],
                    'diskon'        => (int)$tagihan['diskon'],
                    'total'         => (int)$tagihan['total'],
                    'realisasi'     => 0,
                    'selisih'       => (int)$tagihan['total'],
                ]);

                $subtotal += $tagihan['subtotal'];
                $diskon += $tagihan['diskon'];
                $total += $tagihan['total'];
            }

            if($request->tambah_lainnya){
                $lainnya = [];
                $subtotal_lainnya = 0;
                $total_lainnya = 0;
                foreach ($request->tambah_lainnya as $key) {
                    $input['tarif_lainnya']  = $key;

                    Validator::make($input, [
                        'tarif_lainnya'
                        => ['required','numeric',
                            Rule::exists('tarif', 'id')
                            ->where('level', 6)
                        ]
                    ])->validate();

                    $tarif = Tarif::findOrFail($input['tarif_lainnya']);

                    $tagihan = Tarif::lainnya($tarif->data, $jml_los, $tarif->status);

                    $lainnya[] = [
                        'tarif'     => $input['tarif_lainnya'],
                        'subtotal'  => (int)$tagihan['subtotal'],
                        'total'     => (int)$tagihan['total']
                    ];

                    $subtotal_lainnya += $tagihan['subtotal'];
                    $total_lainnya += $tagihan['total'];
                }

                $data['lainnya'] = json_encode([
                    'lunas'         => 0,
                    'kasir'         => null,
                    'data'          => $lainnya,
                    'jml_los'       => $jml_los,
                    'subtotal'      => (int)$subtotal_lainnya,
                    'total'         => (int)$total_lainnya,
                    'realisasi'     => 0,
                    'selisih'       => (int)$total_lainnya,
                ]);

                $subtotal += $subtotal_lainnya;
                $total += $total_lainnya;
            }

            $tempat = Tempat::findOrFail($input['tempat_usaha']);
            $data['code'] = Tagihan::code();
            $data['periode_id'] = $input['periode'];
            $data['name'] = $tempat->name;
            $data['nicename'] = $tempat->nicename;
            $data['pengguna_id'] = $input['pengguna'];
            $data['group_id'] = $tempat->group_id;
            $data['los'] = json_encode($los);
            $data['jml_los'] = $jml_los;
            $data['tagihan'] = json_encode([
                'subtotal'  => $subtotal,
                'ppn'       => $ppn,
                'denda'     => $denda,
                'diskon'    => $diskon,
                'total'     => $total,
                'realisasi' => 0,
                'selisih'   => $total
            ]);

            DB::transaction(function() use ($data){
                Tagihan::create($data);
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
        if($request->ajax()){
            try {
                $decrypted = Crypt::decrypt($id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return response()->json(['error' => "Data tidak valid."]);
            }

            DB::transaction(function() use ($request, $decrypted){
                $dataset = Tagihan::lockForUpdate()->findOrFail($decrypted);

                $periode = Periode::findOrFail($dataset->periode_id);

                $diff_month = Periode::diffInMonth($periode);

                $input['pengguna'] = $request->edit_pengguna;

                Validator::make($input, [
                    'pengguna'     => 'required|exists:users,id',
                ])->validate();

                $los = $this->multipleSelect($request->edit_los);
                sort($los, SORT_NATURAL);
                $input['nomor_los'] = $los;
                $jml_los = count($input['nomor_los']);

                $no_los = Group::findOrFail($dataset->group_id);
                foreach($los as $l){
                    $input['nomor_los'] = $l;
                    Validator::make($input, [
                        'nomor_los' => 'required|in:' . implode(',', json_decode($no_los->data)),
                    ])->validate();
                }

                $subtotal = 0;
                $denda = 0;
                $diskon = 0;
                $ppn = 0;
                $total = 0;
                $realisasi = 0;
                $selisih = 0;

                if($request->edit_listrik){
                    if($dataset->listrik && $dataset->listrik->lunas){
                        $subtotal += $dataset->listrik->subtotal;
                        $ppn += $dataset->listrik->ppn;
                        $denda += $dataset->listrik->denda;
                        $diskon += $dataset->listrik->diskon;
                        $total += $dataset->listrik->total;
                        $realisasi += $dataset->listrik->realisasi;
                        $selisih += $dataset->listrik->selisih;
                    } else {
                        $input['alat_listrik'] = $request->edit_alat_listrik;
                        $input['tarif_listrik'] = $request->edit_trf_listrik;
                        $input['diskon_listrik'] = $request->edit_dis_listrik;
                        $input['awal_stand_listrik'] = str_replace('.', '', $request->edit_awal_listrik);
                        $input['akhir_stand_listrik'] = str_replace('.', '', $request->edit_akhir_listrik);

                        Validator::make($input, [
                            'alat_listrik'   => ['required','numeric',
                                                    Rule::exists('alat', 'id')
                                                    ->where('level', 1)
                                                    ->where('status', 1)
                                                ],
                            'tarif_listrik'  => ['required','numeric',
                                                    Rule::exists('tarif', 'id')
                                                    ->where('level', 1)
                                                ],
                            'diskon_listrik' => 'nullable|numeric|gte:0|lte:100',
                            'awal_stand_listrik' => 'required|numeric|gte:0|lte:999999999999',
                            'akhir_stand_listrik' => 'required|numeric|gte:0|lte:999999999999'
                        ])->validate();

                        $tarif = Tarif::findOrFail($input['tarif_listrik']);
                        $alat = Alat::findOrFail($input['alat_listrik']);

                        $daya = $alat->daya;
                        $awal = $input['awal_stand_listrik'];
                        $akhir = $input['akhir_stand_listrik'];

                        $pakai = $akhir - $awal;
                        $reset = 0;
                        if($awal > $akhir){
                            $pakai = ($akhir + (str_repeat(9, strlen($awal)))) - $awal;
                            $reset = 1;
                        }

                        $tagihan = Tarif::listrik($tarif->data, $pakai, $daya, $diff_month, $input['diskon_listrik']);

                        $data['listrik'] = json_encode([
                            'lunas'         => 0,
                            'kasir'         => null,
                            'alat'          => $input['alat_listrik'],
                            'tarif'         => $input['tarif_listrik'],
                            'daya'          => (int)$daya,
                            'awal'          => (int)$awal,
                            'akhir'         => (int)$akhir,
                            'reset'         => (int)$reset,
                            'pakai'         => (int)$pakai,
                            'rekmin'        => (int)$tagihan['rekmin'],
                            'blok1'         => (int)$tagihan['blok1'],
                            'blok2'         => (int)$tagihan['blok2'],
                            'beban'         => (int)$tagihan['beban'],
                            'pju'           => (int)$tagihan['pju'],
                            'subtotal'      => (int)$tagihan['subtotal'],
                            'ppn'           => (int)$tagihan['ppn'],
                            'denda'         => (int)$tagihan['denda'],
                            'denda_bulan'   => (int)$diff_month,
                            'diskon'        => (int)$tagihan['diskon'],
                            'diskon_persen' => (int)$input['diskon_listrik'],
                            'total'         => (int)$tagihan['total'],
                            'realisasi'     => 0,
                            'selisih'       => (int)$tagihan['total'],
                        ]);

                        $subtotal += $tagihan['subtotal'];
                        $ppn += $tagihan['ppn'];
                        $denda += $tagihan['denda'];
                        $diskon += $tagihan['diskon'];
                        $total += $tagihan['total'];
                        $realisasi += 0;
                        $selisih += $tagihan['total'];
                    }
                } else {
                    if($dataset->listrik && $dataset->listrik->lunas){
                        $subtotal += $dataset->listrik->subtotal;
                        $ppn += $dataset->listrik->ppn;
                        $denda += $dataset->listrik->denda;
                        $diskon += $dataset->listrik->diskon;
                        $total += $dataset->listrik->total;
                        $realisasi += $dataset->listrik->realisasi;
                        $selisih += $dataset->listrik->selisih;
                    } else {
                        $data['listrik'] = NULL;
                    }
                }

                if($request->edit_airbersih){
                    if($dataset->airbersih && $dataset->airbersih->lunas){
                        $subtotal += $dataset->airbersih->subtotal;
                        $ppn += $dataset->airbersih->ppn;
                        $denda += $dataset->airbersih->denda;
                        $diskon += $dataset->airbersih->diskon;
                        $total += $dataset->airbersih->total;
                        $realisasi += $dataset->airbersih->realisasi;
                        $selisih += $dataset->airbersih->selisih;
                    } else {
                        $input['alat_air_bersih'] = $request->edit_alat_airbersih;
                        $input['tarif_air_bersih'] = $request->edit_trf_airbersih;
                        $input['diskon_air_bersih'] = $request->edit_dis_airbersih;
                        $input['awal_stand_air_bersih'] = str_replace('.', '', $request->edit_awal_airbersih);
                        $input['akhir_stand_air_bersih'] = str_replace('.', '', $request->edit_akhir_airbersih);

                        Validator::make($input, [
                            'alat_air_bersih'   => ['required','numeric',
                                                    Rule::exists('alat', 'id')
                                                    ->where('level', 2)
                                                    ->where('status', 1)
                                                ],
                            'tarif_air_bersih'  => ['required','numeric',
                                                    Rule::exists('tarif', 'id')
                                                    ->where('level', 2)
                                                ],
                            'diskon_air_bersih' => 'nullable|numeric|gte:0|lte:100',
                            'awal_stand_air_bersih' => 'required|numeric|gte:0|lte:999999999999',
                            'akhir_stand_air_bersih' => 'required|numeric|gte:0|lte:999999999999'
                        ])->validate();

                        $tarif = Tarif::findOrFail($input['tarif_air_bersih']);
                        $alat = Alat::findOrFail($input['alat_air_bersih']);

                        $awal = $input['awal_stand_air_bersih'];
                        $akhir = $input['akhir_stand_air_bersih'];

                        $pakai = $akhir - $awal;
                        $reset = 0;
                        if($awal > $akhir){
                            $pakai = ($akhir + (str_repeat(9, strlen($awal)))) - $awal;
                            $reset = 1;
                        }

                        $tagihan = Tarif::airbersih($tarif->data, $pakai, $diff_month, $input['diskon_air_bersih']);

                        $data['airbersih'] = json_encode([
                            'lunas'         => 0,
                            'kasir'         => null,
                            'alat'          => $input['alat_air_bersih'],
                            'tarif'         => $input['tarif_air_bersih'],
                            'awal'          => (int)$awal,
                            'akhir'         => (int)$akhir,
                            'reset'         => (int)$reset,
                            'pakai'         => (int)$pakai,
                            'bayar'         => (int)$tagihan['bayar'],
                            'pemeliharaan'  => (int)$tagihan['pemeliharaan'],
                            'beban'         => (int)$tagihan['beban'],
                            'airkotor'      => (int)$tagihan['airkotor'],
                            'subtotal'      => (int)$tagihan['subtotal'],
                            'ppn'           => (int)$tagihan['ppn'],
                            'denda'         => (int)$tagihan['denda'],
                            'denda_bulan'   => (int)$diff_month,
                            'diskon'        => (int)$tagihan['diskon'],
                            'diskon_persen' => (int)$input['diskon_air_bersih'],
                            'total'         => (int)$tagihan['total'],
                            'realisasi'     => 0,
                            'selisih'       => (int)$tagihan['total'],
                        ]);

                        $subtotal += $tagihan['subtotal'];
                        $ppn += $tagihan['ppn'];
                        $denda += $tagihan['denda'];
                        $diskon += $tagihan['diskon'];
                        $total += $tagihan['total'];
                        $realisasi += 0;
                        $selisih += $tagihan['total'];
                    }
                } else {
                    if($dataset->airbersih && $dataset->airbersih->lunas){
                        $subtotal += $dataset->airbersih->subtotal;
                        $ppn += $dataset->airbersih->ppn;
                        $denda += $dataset->airbersih->denda;
                        $diskon += $dataset->airbersih->diskon;
                        $total += $dataset->airbersih->total;
                        $realisasi += $dataset->airbersih->realisasi;
                        $selisih += $dataset->airbersih->selisih;
                    } else {
                        $data['airbersih'] = NULL;
                    }
                }

                if($request->edit_keamananipk){
                    if($dataset->keamananipk && $dataset->keamananipk->lunas){
                        $subtotal += $dataset->keamananipk->subtotal;
                        $diskon += $dataset->keamananipk->diskon;
                        $total += $dataset->keamananipk->total;
                        $realisasi += $dataset->keamananipk->realisasi;
                        $selisih += $dataset->keamananipk->selisih;
                    } else {
                        $input['tarif_keamanan_ipk'] = $request->edit_trf_keamananipk;
                        $input['diskon_keamanan_ipk'] = 0;
                        if($request->edit_dis_keamananipk){
                            $input['diskon_keamanan_ipk'] = str_replace('.', '', $request->edit_dis_keamananipk);
                        }

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

                        $tagihan = Tarif::keamananipk($tarif->data, $jml_los, $input['diskon_keamanan_ipk']);

                        $data['keamananipk'] = json_encode([
                            'lunas'         => 0,
                            'kasir'         => null,
                            'tarif'         => $input['tarif_keamanan_ipk'],
                            'jml_los'       => (int)$jml_los,
                            'keamanan'      => (int)$tagihan['keamanan'],
                            'ipk'           => (int)$tagihan['ipk'],
                            'subtotal'      => (int)$tagihan['subtotal'],
                            'diskon'        => (int)$tagihan['diskon'],
                            'total'         => (int)$tagihan['total'],
                            'realisasi'     => 0,
                            'selisih'       => (int)$tagihan['total'],
                        ]);

                        $subtotal += $tagihan['subtotal'];
                        $diskon += $tagihan['diskon'];
                        $total += $tagihan['total'];
                        $realisasi += 0;
                        $selisih += $tagihan['total'];
                    }
                } else {
                    if($dataset->keamananipk && $dataset->keamananipk->lunas){
                        $subtotal += $dataset->keamananipk->subtotal;
                        $diskon += $dataset->keamananipk->diskon;
                        $total += $dataset->keamananipk->total;
                        $realisasi += $dataset->keamananipk->realisasi;
                        $selisih += $dataset->keamananipk->selisih;
                    } else {
                        $data['keamananipk'] = NULL;
                    }
                }

                if($request->edit_kebersihan){
                    if($dataset->kebersihan && $dataset->kebersihan->lunas){
                        $subtotal += $dataset->kebersihan->subtotal;
                        $diskon += $dataset->kebersihan->diskon;
                        $total += $dataset->kebersihan->total;
                        $realisasi += $dataset->kebersihan->realisasi;
                        $selisih += $dataset->kebersihan->selisih;
                    } else {
                        $input['tarif_kebersihan'] = $request->edit_trf_kebersihan;
                        $input['diskon_kebersihan'] = 0;
                        if($request->edit_dis_kebersihan){
                            $input['diskon_kebersihan'] = str_replace('.', '', $request->edit_dis_kebersihan);
                        }

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

                        $tagihan = Tarif::kebersihan($tarif->data, $jml_los, $input['diskon_kebersihan']);

                        $data['kebersihan'] = json_encode([
                            'lunas'         => 0,
                            'kasir'         => null,
                            'tarif'         => $input['tarif_kebersihan'],
                            'jml_los'       => (int)$jml_los,
                            'subtotal'      => (int)$tagihan['subtotal'],
                            'diskon'        => (int)$tagihan['diskon'],
                            'total'         => (int)$tagihan['total'],
                            'realisasi'     => 0,
                            'selisih'       => (int)$tagihan['total'],
                        ]);

                        $subtotal += $tagihan['subtotal'];
                        $diskon += $tagihan['diskon'];
                        $total += $tagihan['total'];
                        $realisasi += 0;
                        $selisih += $tagihan['total'];
                    }
                } else {
                    if($dataset->kebersihan && $dataset->kebersihan->lunas){
                        $subtotal += $dataset->kebersihan->subtotal;
                        $diskon += $dataset->kebersihan->diskon;
                        $total += $dataset->kebersihan->total;
                        $realisasi += $dataset->kebersihan->realisasi;
                        $selisih += $dataset->kebersihan->selisih;
                    } else {
                        $data['kebersihan'] = NULL;
                    }
                }

                if($request->edit_airkotor){
                    if($dataset->airkotor && $dataset->airkotor->lunas){
                        $subtotal += $dataset->airkotor->subtotal;
                        $diskon += $dataset->airkotor->diskon;
                        $total += $dataset->airkotor->total;
                        $realisasi += $dataset->airkotor->realisasi;
                        $selisih += $dataset->airkotor->selisih;
                    } else {
                        $input['tarif_air_kotor'] = $request->edit_trf_airkotor;
                        $input['diskon_air_kotor'] = 0;
                        if($request->edit_dis_airkotor){
                            $input['diskon_air_kotor'] = str_replace('.', '', $request->edit_dis_airkotor);
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

                        $tagihan = Tarif::airkotor($tarif->data, $jml_los, $tarif->status, $input['diskon_air_kotor']);

                        $data['airkotor'] = json_encode([
                            'lunas'         => 0,
                            'kasir'         => null,
                            'tarif'         => $input['tarif_air_kotor'],
                            'jml_los'       => (int)$jml_los,
                            'subtotal'      => (int)$tagihan['subtotal'],
                            'diskon'        => (int)$tagihan['diskon'],
                            'total'         => (int)$tagihan['total'],
                            'realisasi'     => 0,
                            'selisih'       => (int)$tagihan['total'],
                        ]);

                        $subtotal += $tagihan['subtotal'];
                        $diskon += $tagihan['diskon'];
                        $total += $tagihan['total'];
                        $realisasi += 0;
                        $selisih += $tagihan['total'];
                    }
                } else {
                    if($dataset->airkotor && $dataset->airkotor->lunas){
                        $subtotal += $dataset->airkotor->subtotal;
                        $diskon += $dataset->airkotor->diskon;
                        $total += $dataset->airkotor->total;
                        $realisasi += $dataset->airkotor->realisasi;
                        $selisih += $dataset->airkotor->selisih;
                    } else {
                        $data['airkotor'] = NULL;
                    }
                }

                if($request->edit_lainnya){
                    if($dataset->lainnya && $dataset->lainnya->lunas){
                        $subtotal += $dataset->lainnya->subtotal;
                        $total += $dataset->lainnya->total;
                        $realisasi += $dataset->lainnya->realisasi;
                        $selisih += $dataset->lainnya->selisih;
                    } else {
                        $lainnya = [];
                        $subtotal_lainnya = 0;
                        $total_lainnya = 0;
                        foreach ($request->edit_lainnya as $key) {
                            $input['tarif_lainnya']  = $key;

                            Validator::make($input, [
                                'tarif_lainnya'
                                => ['required','numeric',
                                    Rule::exists('tarif', 'id')
                                    ->where('level', 6)
                                ]
                            ])->validate();

                            $tarif = Tarif::findOrFail($input['tarif_lainnya']);

                            $tagihan = Tarif::lainnya($tarif->data, $jml_los, $tarif->status);

                            $lainnya[] = [
                                'tarif'     => $input['tarif_lainnya'],
                                'subtotal'  => (int)$tagihan['subtotal'],
                                'total'     => (int)$tagihan['total']
                            ];

                            $subtotal_lainnya += $tagihan['subtotal'];
                            $total_lainnya += $tagihan['total'];
                        }

                        $data['lainnya'] = json_encode([
                            'lunas'         => 0,
                            'kasir'         => null,
                            'data'          => $lainnya,
                            'jml_los'       => $jml_los,
                            'subtotal'      => (int)$subtotal_lainnya,
                            'total'         => (int)$total_lainnya,
                            'realisasi'     => 0,
                            'selisih'       => (int)$total_lainnya,
                        ]);

                        $subtotal += $subtotal_lainnya;
                        $total += $total_lainnya;
                    }
                } else {
                    if($dataset->lainnya && $dataset->lainnya->lunas){
                        $subtotal += $dataset->lainnya->subtotal;
                        $total += $dataset->lainnya->total;
                        $realisasi += $dataset->lainnya->realisasi;
                        $selisih += $dataset->lainnya->selisih;
                    } else {
                        $data['lainnya'] = NULL;
                    }
                }

                $data['pengguna_id'] = $input['pengguna'];
                $data['los'] = json_encode($los);
                $data['jml_los'] = $jml_los;
                $data['tagihan'] = json_encode([
                    'subtotal'  => $subtotal,
                    'ppn'       => $ppn,
                    'denda'     => $denda,
                    'diskon'    => $diskon,
                    'total'     => $total,
                    'realisasi' => $realisasi,
                    'selisih'   => $selisih
                ]);

                $dataset->update($data);
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
