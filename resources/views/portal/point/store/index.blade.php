@extends('portal.layout.master')

@section('content-title')
Data Tempat
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn">
        <a class="dropdown-item add" href="javascript:void(0)">
            <i class="fas fa-fw fa-plus mr-1 ml-1"></i>
            <span>Tambah Data</span>
        </a>
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p id="showtempat" class="text-danger">*) <b>Menambah</b>, <b>Mengedit</b>, atau <b>Menghapus</b> Data Tempat Usaha tidak akan mempengaruhi <b>Data Tagihan</b> yang telah dibuat. <sup><a href="javascript:void(0)" type="button" id="showagain"><i class="fas fa-times"></i> Jangan tampilkan lagi.</a></sup></p>
                <div class="form-group d-flex">
                    <div class="mr-1 ml-1"><div class='color color-success'></div>&nbsp;Aktif</div>
                    <div class="mr-1 ml-1"><div class='color color-info'></div>&nbsp;Bebas Bayar</div>
                    <div class="mr-1 ml-1"><div class='color color-danger'></div>&nbsp;Nonaktif</div>
                </div>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kontrol</th>
                                <th>Pengguna</th>
                                <th>Jml.Los</th>
                                <th>Fasilitas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-modal')
<div id="showModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl dialog-modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body-xl">
                <div class="row">
                    <div class="col-lg-6 col-xlg-6">
                        <small class="text-muted pt-4 db">Kontrol</small>
                        <h6 id="showKontrol"></h6>
                        <small class="text-muted pt-4 db">Blok</small>
                        <h6 id="showGroup"></h6>
                        <small class="text-muted pt-4 db">Nomor Los</small>
                        <h6 id="showLos"></h6>
                        <small class="text-muted pt-4 db">Jumlah Los</small>
                        <h6 id="showJmlLos"></h6>
                        <small class="text-muted pt-4 db">Pengguna</small>
                        <h6 id="showPengguna"></h6>
                        <small class="text-muted pt-4 db">Pemilik</small>
                        <h6 id="showPemilik"></h6>
                        <small class="text-muted pt-4 db">Komoditi</small>
                        <h6 id="showKomoditi"></h6>
                        <small class="text-muted pt-4 db">Status Tempat</small>
                        <h6 id="showStatus"></h6>
                        <small class="text-muted pt-4 db">Keterangan Status Tempat</small>
                        <h6 id="showKet"></h6>
                        <small class="text-muted pt-4 db">Info Tambahan</small>
                        <h6 id="showInfo"></h6>
                        <hr>
                    </div>
                    <div class="col-lg-6 col-xlg-6">
                        <h3 class="text-center">Fasilitas Tempat</h3>
                        <div id="showFasilitas"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="storeModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="storeForm">
                <div class="modal-body-xl">
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Blok Tempat <span class="text-danger">*</span>
                                    <sup>
                                        <a href='{{url("production/point/groups")}}' target="_blank">
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Blok Tempat / Grup Tempat"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Kode lokasi yang menunjukkan kelompok tempat usaha.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Blok Tempat">
                                            </i>
                                        </a>
                                    </sup>
                                </label>
                                <select required id="group" name="group" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Nomor Los <span class="text-danger">*</span>
                                    <sup>
                                        <a href='{{url("production/point/groups")}}' target="_blank">
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Nomor Los"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Nomor petunjuk lokasi tempat usaha, Anda dapat mengisinya setelah Blok Tempat terisi.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Nomor Los pada Blok tempat">
                                            </i>
                                        </a>
                                    </sup>
                                </label>
                                <select required id="los" name="los[]" class="select2 form-control form-control-line" style="width: 100%;" multiple></select>
                            </div>
                            <div class="form-group">
                                <label>Kode Kontrol <span class="text-danger">*</span>
                                    <sup>
                                        <i class="far fa-question-circle"
                                            style="color:#5b5b5b;"
                                            data-container="body"
                                            data-trigger="hover"
                                            title="Kode Kontrol / Kontrol"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="Secara otomatis apabila Blok dan Nomor Los terisi, Namun anda dapat <b>menyesuaikan</b> kebutuhan.<br>Ketikkan apa yang anda butuhkan.">
                                        </i>
                                    </sup>
                                </label>
                                <input required type="text" id="kontrol" name="kontrol" autocomplete="off" maxlength="20" placeholder="Sesuaikan Blok & No.Los" class="form-control form-control-line" style="text-transform: uppercase">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label>Pengguna Tempat
                                        <sup>
                                            <a href='{{url("production/users")}}' target="_blank">
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Pengguna Tempat"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Penanggung jawab terkait penggunaan aset.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola user">
                                                </i>
                                            </a>
                                        </sup>
                                    </label>
                                    <a id="cancelPengguna" type="button" class="text-danger" href="javascript:void(0)"><sup><i class="fas fa-sm fa-times"></i></sup> Hapus</a>
                                </div>
                                <select id="pengguna" name="pengguna" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label>Pemilik Tempat
                                        <sup>
                                            <a href='{{url("production/users")}}' target="_blank">
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Pemilik Tempat"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Individu yang secara sah memiliki aset seutuhnya.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola user">
                                                </i>
                                            </a>
                                        </sup>
                                    </label>
                                    <a id="cancelPemilik" type="button" class="text-danger" href="javascript:void(0)"><sup><i class="fas fa-sm fa-times"></i></sup> Hapus</a>
                                </div>
                                <select id="pemilik" name="pemilik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Kategori Komoditi
                                    <sup>
                                        <a href='{{url("production/point/commodities")}}' target="_blank">
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Kelola Kategori Komiditi"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Jenis atau kelompok dari tempat usaha.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola kategori komoditi">
                                            </i>
                                        </a>
                                    </sup>
                                </label>
                                <select id="commodity" name="commodity[]" class="select2 form-control form-control-line" style="width: 100%; height:36px;" multiple></select>
                            </div>
                            <div class="form-group">
                                <label>Status Tempat <span class="text-danger">*</span>&nbsp;
                                    <sup>
                                        <i class="far fa-question-circle"
                                            style="color:#5b5b5b;"
                                            data-container="body"
                                            data-trigger="hover"
                                            title="Pilih salah satu"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="<b>Aktif</b> : Tagihan dibebankan setiap bulan.<br><b>Bebas Bayar</b> : Tempat digunakan tanpa beban tagihan setiap bulan.<br><b>Nonaktif</b> : Tempat tidak digunakan dan tidak ada beban tagihan.">
                                        </i>
                                    </sup>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="stt_aktif" name="status" value="1">
                                            <label class="custom-control-label" style="font-weight: 400;" for="stt_aktif">Aktif</label>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="stt_bebas" name="status" value="2">
                                            <label class="custom-control-label" style="font-weight: 400;" for="stt_bebas">Bebas Bayar</label>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="stt_nonaktif" name="status" value="0">
                                            <label class="custom-control-label" style="font-weight: 400;" for="stt_nonaktif">Nonaktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan Status Tempat <span id="ketLabel" class="text-danger">*</span>
                                    <sup>
                                        <i class="far fa-question-circle"
                                            style="color:#5b5b5b;"
                                            data-container="body"
                                            data-trigger="hover"
                                            title="Ketikkan sesuatu"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="<b>Wajib di isi</b> : Ketikkan keterangan ketika tempat dinonaktifkan.<br><b>Opsional</b> : Anda dapat mengisinya sewaktu-waktu dengan status tempat apapun.">
                                        </i>
                                    </sup>
                                </label>
                                <textarea rows="3" id="ket" name="ket" autocomplete="off" placeholder="Ketikkan Keterangan disini" maxlength="255" class="form-control form-control-line"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Info Tambahan
                                    <sup>
                                        <i class="far fa-question-circle"
                                            style="color:#5b5b5b;"
                                            data-container="body"
                                            data-trigger="hover"
                                            title="Ketikkan sesuatu"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="<b>Opsional</b> : Anda dapat mengisinya dengan informasi tambahan seperti lokasi atau kondisi dari tempat.">
                                        </i>
                                    </sup>
                                </label>
                                <textarea rows="3" id="info" name="info" autocomplete="off" placeholder="Ketikkan info tambahan disini" maxlength="255" class="form-control form-control-line"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center form-group">
                        <h4>FASILITAS TEMPAT :</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            {{-- Listrik --}}
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_listrik" name="fas_listrik">
                                        <label class="custom-control-label" for="fas_listrik">Listrik</label>
                                    </div>
                                </div>
                                <div id="divlistrik" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Alat Meter <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/point/tools/listrik")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Alat Listrik"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Alat ukur penggunaan listrik bulanan untuk tempat usaha.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola alat listrik">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <select id="tlistrik" name="tlistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/manage/prices/listrik")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Listrik"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Tarif listrik yang dibebankan tempat usaha untuk setiap bulannya.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola tarif listrik">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <select id="plistrik" name="plistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Ketikkan sesuatu"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Opsional</b> : Potongan harga tagihan listrik yang dibebankan secara persentase.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <input maxlength="3" type="text" id="dlistrik" name="dlistrik" autocomplete="off" placeholder="Ketikkan dalam angka 0-100" class="number percent form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">% Tagihan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            {{-- End Listrik --}}
                            {{-- Air Bersih --}}
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_airbersih" name="fas_airbersih">
                                        <label class="custom-control-label" for="fas_airbersih">Air Bersih</label>
                                    </div>
                                </div>
                                <div id="divairbersih" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Alat Meter <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/point/tools/airbersih")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Alat Air Bersih"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Alat ukur penggunaan air bersih bulanan untuk tempat usaha.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola alat air bersih">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <select id="tairbersih" name="tairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/manage/prices/airbersih")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Air Bersih"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Tarif air bersih yang dibebankan tempat usaha untuk setiap bulannya.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola tarif air bersih">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <select id="pairbersih" name="pairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Ketikkan sesuatu"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Opsional</b> : Potongan harga tagihan air bersih yang dibebankan secara persentase.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <input maxlength="3" type="text" id="dairbersih" name="dairbersih" autocomplete="off" placeholder="Ketikkan dalam angka 0-100" class="number percent form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">% Tagihan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            {{-- End Air Bersih --}}
                            {{-- Keamanan IPK --}}
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_keamananipk" name="fas_keamananipk">
                                        <label class="custom-control-label" for="fas_keamananipk">Keamanan IPK</label>
                                    </div>
                                </div>
                                <div id="divkeamananipk" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/manage/prices/keamananipk")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Keamanan & IPK"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Tarif keamanan & ipk per-Nomor Los yang dibebankan tempat usaha untuk setiap bulannya.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola tarif keamanan ipk">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <select id="pkeamananipk" name="pkeamananipk" class="select2 form-control form-control-line" style="width: 100%"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Ketikkan sesuatu"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Opsional</b> : Potongan harga tagihan keamanan ipk yang dibebankan per-Tempat Usaha.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input maxlength="11" type="text" id="dkeamananipk" name="dkeamananipk" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">per-Kontrol</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            {{-- End Keamanan IPK --}}
                            {{-- Kebersihan --}}
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_kebersihan" name="fas_kebersihan">
                                        <label class="custom-control-label" for="fas_kebersihan">Kebersihan</label>
                                    </div>
                                </div>
                                <div id="divkebersihan" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/manage/prices/kebersihan")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Kebersihan"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Tarif kebersihan per-Nomor Los yang dibebankan tempat usaha untuk setiap bulannya.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola tarif kebersihan">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <select id="pkebersihan" name="pkebersihan" class="select2 form-control form-control-line" style="width: 100%"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Ketikkan sesuatu"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Opsional</b> : Potongan harga tagihan kebersihan yang dibebankan per-Tempat Usaha.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input maxlength="11" type="text" id="dkebersihan" name="dkebersihan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">per-Kontrol</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            {{-- End Kebersihan --}}
                            {{-- Air Kotor --}}
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_airkotor" name="fas_airkotor">
                                        <label class="custom-control-label" for="fas_airkotor">Air Kotor</label>
                                    </div>
                                </div>
                                <div id="divairkotor" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/manage/prices/airkotor")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Air Kotor"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Tarif air kotor yang dibebankan tempat usaha untuk setiap bulannya dikarenakan sesuatu yang kaitannya dengan air kotor.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola tarif air kotor">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <select id="pairkotor" name="pairkotor" class="select2 form-control form-control-line" style="width: 100%"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Ketikkan sesuatu"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Opsional</b> : Potongan harga tagihan air kotor yang dibebankan per-Tempat Usaha.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input maxlength="11" type="text" id="dairkotor" name="dairkotor" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            {{-- End Air Kotor --}}
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            {{-- Lainnya --}}
                            <div>
                                <div id="divlainNew"></div>

                                <div class="form-group">
                                    <button id="divLainAdd" class="btn btn-sm btn-rounded btn-info"><i class="fas fa-fw fa-plus mr-1"></i>Fasilitas Lainnya</button>
                                    <sup>
                                        <a href='{{url("production/manage/prices/lain")}}' target="_blank">
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Tarif Fasilitas Lainnya"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Tambahkan tarif lainnya yang dibebankan tempat usaha untuk setiap bulannya.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola tarif lainnya">
                                            </i>
                                        </a>
                                    </sup>
                                </div>
                            </div>
                            {{-- End Lainnya --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <p>(<label class="text-danger">*</label>) wajib diisi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="storeFormValue"/>
                    <button type="submit" id="save_btn" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('content-js')
<script>
    $(document).ready(function(){
        var id;
        var lain = 0;
        var plain = 1;

        var dtable = $('#dtable').DataTable({
            "language": {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
            "serverSide": true,
            "ajax": "/production/point/stores",
            "columns": [
                { data: 'kd_kontrol', name: 'nicename', class : 'text-center'  },
                { data: 'pengguna.name', name: 'pengguna.name', class : 'text-center' },
                { data: 'jml_los', name: 'jml_los', class : 'text-center' },
                { data: 'fasilitas', name: 'fasilitas', class : 'text-center' },
                { data: 'action', name: 'action', class : 'text-center' },
            ],
            "stateSave": true,
            "deferRender": true,
            "pageLength": 10,
            "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
            "order": [[ 0, "asc" ]],
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [3,4] },
                { "bSearchable": false, "aTargets": [3,4] },
            ],
            "scrollY": "45vh",
            "scrollX": true,
            "preDrawCallback": function( settings ) {
                scrollPosition = $(".dataTables_scrollBody").scrollTop();
            },
            "drawCallback": function( settings ) {
                $(".dataTables_scrollBody").scrollTop(scrollPosition);
                if(typeof rowIndex != 'undefined') {
                    dtable.row(rowIndex).nodes().to$().addClass('row_selected');
                }
                setTimeout( function () {
                    $("[data-toggle='tooltip']").tooltip();
                }, 10)
            },
        });

        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            for ( var i=1 ; i<4 ; i++ ) {
                dtable.column( i ).visible( false, false );
            }
            dtable.columns.adjust().draw( false );
        }
        else{
            for ( var i=1 ; i<4 ; i++ ) {
                dtable.column( i ).visible( true, false );
            }
            dtable.columns.adjust().draw( false );
        }

        var searchValue = getUrlParameter('s');
        if(searchValue){
            dtable.search(searchValue).draw();
        }

        setInterval(function(){
            dtableReload('');
        }, 5000);

        function dtableReload(searchKey){
            if(searchKey){
                dtable.search(searchKey).draw();
            }
            dtable.ajax.reload(function(){
                console.log("Refresh Automatic")
            }, false);
        }

        $(".add").click( function(){
            $("#storeForm")[0].reset();
            $('.titles').text('Tambah data Tempat Usaha');
            $("#storeFormValue").val('add');

            initForm();

            $('#storeModal').modal('show');
        });

        $(document).on('click', '.edit', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Edit data ' + nama);
            $("#storeFormValue").val('update');

            initForm();

            $.ajax({
                url: "/production/point/stores/" + id + "/edit",
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $('#group').val("").html("");
                        var group = new Option(data.show.group, data.show.group, false, false);
                        $('#group').append(group).trigger('change');

                        $('#los').val("").html("");
                        var los = data.show.no_los;
                        $.each( los, function( i, val ) {
                            var option = $('<option></option>').attr('value', val).text(val).prop('selected', true);
                            $('#los').append(option).trigger('change');
                        });

                        $("#kontrol").val(data.show.kd_kontrol);

                        if(data.show.pengguna.id){
                            $("#cancelPengguna").show();
                            $('#pengguna').val("").html("");
                            var pengguna = new Option(data.show.pengguna.name + ' (' + data.show.pengguna.ktp + ')', data.show.pengguna.id, false, false);
                            $('#pengguna').append(pengguna).trigger('change');
                        }

                        if(data.show.pemilik.id){
                            $("#cancelPemilik").show();
                            $('#pemilik').val("").html("");
                            var pemilik = new Option(data.show.pemilik.name + ' (' + data.show.pemilik.ktp + ')', data.show.pemilik.id, false, false);
                            $('#pemilik').append(pemilik).trigger('change');
                        }

                        //Komoditi
                        $('#commodity').val("").html("");
                        var commodity = $.parseJSON(data.show.komoditi);
                        $.each( commodity, function( i, val ) {
                            var option = $('<option></option>').attr('value', val.id).text(val.name).prop('selected', true);
                            $('#commodity').append(option).trigger('change');
                        });

                        (data.show.status == 2)
                            ? $("#stt_bebas").prop("checked", true)
                            : (data.show.status == 1)
                            ? $("#stt_aktif").prop("checked", true)
                            : $("#stt_nonaktif").prop("checked", true);
                        statusTempat();

                        $("#ket").val(data.show.ket);
                        $("#info").val(data.show.info);

                        if(data.show.fas_listrik){
                            $("#fas_listrik").prop("checked", true);
                            fasListrik('show');

                            $('#tlistrik').val("").html("");
                            var tlistrik = new Option(
                                data.show.tlistrik.code + ' - (' + Number(data.show.tlistrik.meter).toLocaleString('id-ID') + ') - ' + data.show.tlistrik.power + ' Watt' + ' - ID: ' + data.show.tlistrik.name,
                                data.show.tlistrik.id,
                                false,
                                false
                            );
                            $('#tlistrik').append(tlistrik).trigger('change');

                            $('#plistrik').val("").html("");
                            var plistrik = new Option(
                                data.show.plistrik.name,
                                data.show.plistrik.id,
                                false,
                                false
                            );
                            $('#plistrik').append(plistrik).trigger('change');

                            if(data.show.data.diskon.listrik){
                                $("#dlistrik").val(Number(data.show.data.diskon.listrik).toLocaleString('id-ID'));
                            }
                        }

                        if(data.show.fas_airbersih){
                            $("#fas_airbersih").prop("checked", true);
                            fasAirBersih('show');

                            $('#tairbersih').val("").html("");
                            var tairbersih = new Option(
                                data.show.tairbersih.code + ' - (' + Number(data.show.tairbersih.meter).toLocaleString('id-ID') + ') - ID: ' + data.show.tairbersih.name,
                                data.show.tairbersih.id,
                                false,
                                false
                            );
                            $('#tairbersih').append(tairbersih).trigger('change');

                            $('#pairbersih').val("").html("");
                            var pairbersih = new Option(
                                data.show.pairbersih.name,
                                data.show.pairbersih.id,
                                false,
                                false
                            );
                            $('#pairbersih').append(pairbersih).trigger('change');

                            if(data.show.data.diskon.airbersih){
                                $("#dairbersih").val(Number(data.show.data.diskon.airbersih).toLocaleString('id-ID'));
                            }
                        }

                        if(data.show.fas_keamananipk){
                            $("#fas_keamananipk").prop("checked", true);
                            fasKeamananIpk('show');

                            $('#pkeamananipk').val("").html("");
                            var pkeamananipk = new Option(
                                data.show.pkeamananipk.name + ' - ' + Number(data.show.pkeamananipk.price).toLocaleString('id-ID'),
                                data.show.pkeamananipk.id,
                                false,
                                false
                            );
                            $('#pkeamananipk').append(pkeamananipk).trigger('change');

                            if(data.show.data.diskon.keamananipk){
                                $("#dkeamananipk").val(Number(data.show.data.diskon.keamananipk).toLocaleString('id-ID'));
                            }
                        }

                        if(data.show.fas_kebersihan){
                            $("#fas_kebersihan").prop("checked", true);
                            fasKebersihan('show');

                            $('#pkebersihan').val("").html("");
                            var pkebersihan = new Option(
                                data.show.pkebersihan.name + ' - ' + Number(data.show.pkebersihan.price).toLocaleString('id-ID'),
                                data.show.pkebersihan.id,
                                false,
                                false
                            );
                            $('#pkebersihan').append(pkebersihan).trigger('change');

                            if(data.show.data.diskon.kebersihan){
                                $("#dkebersihan").val(Number(data.show.data.diskon.kebersihan).toLocaleString('id-ID'));
                            }
                        }

                        if(data.show.fas_airkotor){
                            $("#fas_airkotor").prop("checked", true);
                            fasAirKotor('show');

                            $('#pairkotor').val("").html("");
                            var pairkotor = new Option(
                                data.show.pairkotor.name + ' - ' + Number(data.show.pairkotor.price).toLocaleString('id-ID'),
                                data.show.pairkotor.id,
                                false,
                                false
                            );
                            $('#pairkotor').append(pairkotor).trigger('change');

                            if(data.show.data.diskon.airkotor){
                                $("#dairkotor").val(Number(data.show.data.diskon.airkotor).toLocaleString('id-ID'));
                            }
                        }

                        if(data.show.fas_lain){
                            var json = $.parseJSON(data.show.fas_lain);
                            $.each( json, function( i, val ) {
                                $('#divLainAdd').trigger('click');
                                $('#plain' + plain).val("").html("");
                                var plainOpt = new Option(
                                    val.name + ' - ' + Number(val.price).toLocaleString('id-ID') + ' ' + val.satuan_name,
                                    val.id,
                                    false,
                                    false
                                );
                                $('#plain' + (i+1)).append(plainOpt).trigger('change');
                            });
                        }
                    }

                    if(data.info){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.info(data.info);
                    }

                    if(data.warning){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.warning(data.warning);
                    }

                    if(data.error){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error(data.error);
                    }

                    if(data.description){
                        console.log(data.description);
                    }
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("Fetching data failed.");
                    console.log(data);
                },
                complete:function(){
                    $('#storeModal').modal('show');
                }
            });
        });

        $("#divLainAdd").on('click', function (e) {
            e.preventDefault();

            var html = '';
            html += '<div name="divlain" class="form-group">';
            html += '<div class="d-flex justify-content-between">';
            html += '<label>Pilih Tarif Fasilitas <span class="text-danger">*</span></label>';
            html += '<a type="button" class="text-danger" href="javascript:void(0)" id="divlainRemove">';
            html += 'Hapus <i class="fas fa-fw fa-eraser mr-1 ml-1"></i>';
            html += '</a>';
            html += '</div>';
            html += '<select required id="plain'+ plain + '" name="plain[]" class="select2 form-control form-control-line" style="width: 100%"></select>';
            html += '</div>';

            if(lain < 10){
                $('#divlainNew').append(html);
                select2plain("#plain" + plain, "/search/price/lain", "-- Cari Tarif Fasilitas --");

                $("#plain" + plain).on('select2:open', () => {
                    $('input.select2-search__field').prop('placeholder', 'Ketik Tarif/Nama Tarif disini..');
                });

                plain++;
                lain++;
            }
            else{
                toastr.options = {
                    "closeButton": true,
                    "preventDuplicates": true,
                };
                toastr.error("Telah mencapai maksimal.");
            }
        });
        $(document).on('click', '#divlainRemove', function () {
            lain--;
            $(this).closest("[name='divlain']").remove();
        });

        $('#storeForm').submit(function(e){
            e.preventDefault();
            value = $("#storeFormValue").val();
            if(value == 'add'){
                url = "/production/point/stores";
                type = "POST";
            }
            else if(value == 'update'){
                url = "/production/point/stores/" + id;
                type = "PUT";
            }
            dataset = $(this).serialize();
            ok_btn_before = "Menyimpan...";
            ok_btn_completed = "Simpan";
            ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
        });

        $(document).on('click', '.delete', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Hapus data ' + nama + ' ?');
            $('.bodies').text('Pilih "Hapus" di bawah ini jika anda yakin untuk menghapus data tempat.');
            $('#ok_button').addClass('btn-danger').removeClass('btn-info').text('Hapus');
            $('#confirmValue').val('delete');
            $('#confirmModal').modal('show');
        });

        $('#confirmForm').submit(function(e){
            e.preventDefault();
            var token = $("meta[name='csrf-token']").attr("content");
            var value = $('#confirmValue').val();
            dataset = {
                'id' : id,
                '_token' : token,
            }
            if(value == 'delete'){
                url = "/production/point/stores/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Hapus";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
        });

        function initForm(){
            $("#group").val("");
            select2custom("#group", "/search/groups", "-- Cari Blok Tempat --");

            $("#los").val("");
            $("#los").select2({
                placeholder: "(Pilih Blok Tempat terlebih dulu)"
            }).prop("disabled", true);

            $("#kontrol").prop("disabled", true).val("");

            $("#cancelPengguna").hide();
            $("#pengguna").val("");
            select2user("#pengguna", "/search/users", "-- Cari Pengguna Tempat --");

            $("#cancelPemilik").hide();
            $("#pemilik").val("");
            select2user("#pemilik", "/search/users", "-- Cari Pemilik Tempat --");

            $("#commodity").val("");
            select2idname("#commodity", "/search/commodities", "-- Cari Kategori Komoditi --");

            $("#stt_aktif").prop("checked", true);
            statusTempat();

            $("#tlistrik").val("");
            select2tlistrik("#tlistrik", "/search/tools/listrik", "-- Cari Alat Listrik --");
            $("#plistrik").val("");
            select2idname("#plistrik", "/search/price/listrik", "-- Cari Tarif Listrik --");
            $("#dlistrik").val("");
            fasListrik("hide");

            $("#tairbersih").val("");
            select2tairbersih("#tairbersih", "/search/tools/airbersih", "-- Cari Alat Air Bersih --");
            $("#pairbersih").val("");
            select2idname("#pairbersih", "/search/price/airbersih", "-- Cari Tarif Air Bersih --");
            $("#dairbersih").val("");
            fasAirBersih("hide");

            $("#pkeamananipk").val("");
            select2idprice("#pkeamananipk", "/search/price/keamananipk", "-- Cari Tarif Keamanan IPK --", "per-Los");
            $("#dkeamananipk").val("");
            fasKeamananIpk("hide");

            $("#pkebersihan").val("");
            select2idprice("#pkebersihan", "/search/price/kebersihan", "-- Cari Tarif Kebersihan --", "per-Los");
            $("#dkebersihan").val("");
            fasKebersihan("hide");

            $("#pairkotor").val("");
            select2idprice("#pairkotor", "/search/price/airkotor", "-- Cari Tarif Air Kotor --", "per-Kontrol");
            $("#dairkotor").val("");
            fasAirKotor("hide");

            lain = 0;
            plain = 1;
            $('div[name="divlain"]').remove();
        }

        function ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed){
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: type,
                cache:false,
                data: dataset,
                beforeSend:function(){
                    $.blockUI({
                        message: '<i class="fad fa-spin fa-spinner text-white"></i>',
                        baseZ: 9999,
                        overlayCSS: {
                            backgroundColor: '#000',
                            opacity: 0.5,
                            cursor: 'wait'
                        },
                        css: {
                            border: 0,
                            padding: 0,
                            backgroundColor: 'transparent'
                        }
                    });
                },
                success:function(data)
                {
                    if(data.success){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.success(data.success);
                        dtableReload(data.searchKey);
                    }

                    if(data.info){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.info(data.info);
                    }

                    if(data.warning){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.warning(data.warning);
                    }

                    if(data.error){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error(data.error);
                    }

                    if(data.description){
                        console.log(data.description);
                    }
                },
                error:function(data){
                    if (data.status == 422) {
                        $.each(data.responseJSON.errors, function (i, error) {
                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                            };
                            toastr.error(error[0]);
                        });
                    }
                    else{
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error("System error.");
                    }
                    console.log(data);
                },
                complete:function(data){
                    if(value == 'add' || value == 'update'){
                        if(JSON.parse(data.responseText).success)
                            $('#storeModal').modal('hide');
                    }
                    else{
                        $('#confirmModal').modal('hide');
                    }
                    $.unblockUI();
                }
            });
        }

        $(document).on('click', '.details', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Informasi ' + nama);

            $("#showFasilitas").html('');

            $.ajax({
                url: "/production/point/stores/" + id,
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#showKontrol").text(data.show.kd_kontrol);
                        $("#showGroup").text(data.show.group);
                        $("#showLos").text(data.show.no_los);
                        $("#showJmlLos").text(data.show.jml_los);
                        var pengguna = data.show.pengguna.name;
                        pengguna += (data.show.pengguna.uid) ?  "<br><span style='font-weight:400; font-size: 12px;'>Phone : " + data.show.pengguna.uid + "</span>" : "";
                        pengguna += (data.show.pengguna.phone) ?  "<br><span style='font-weight:400; font-size: 12px;'>Phone : +" + data.show.pengguna.country.phonecode + " " + data.show.pengguna.phone + "</span>" : "";
                        pengguna += (data.show.pengguna.email) ?  "<br><span style='font-weight:400; font-size: 12px;'>Email : " + data.show.pengguna.email + "</span>" : "";
                        pengguna += (data.show.pengguna.ktp) ?  "<br><span style='font-weight:400; font-size: 12px;'>KTP : " + data.show.pengguna.ktp + "</span>" : "";
                        $("#showPengguna").html(pengguna);

                        var pemilik = data.show.pemilik.name;
                        pemilik += (data.show.pemilik.uid) ?  "<br><span style='font-weight:400; font-size: 12px;'>Phone : " + data.show.pemilik.uid + "</span>" : "";
                        pemilik += (data.show.pemilik.phone) ?  "<br><span style='font-weight:400; font-size: 12px;'>Phone : +" + data.show.pemilik.country.phonecode + " " + data.show.pemilik.phone + "</span>" : "";
                        pemilik += (data.show.pemilik.email) ?  "<br><span style='font-weight:400; font-size: 12px;'>Email : " + data.show.pemilik.email + "</span>" : "";
                        pemilik += (data.show.pemilik.ktp) ?  "<br><span style='font-weight:400; font-size: 12px;'>KTP : " + data.show.pemilik.ktp + "</span>" : "";
                        $("#showPemilik").html(pemilik);

                        var json = $.parseJSON(data.show.komoditi);
                        var text = '';
                        $.each(json, function(i, val){
                            text += val.name + ', ';
                        });
                        text = text.replace(/,\s*$/, "");
                        (text) ? $("#showKomoditi").text(text) : $("#showKomoditi").text("-");

                        $("#showStatus").html(data.show.status);

                        (data.show.ket) ? $("#showKet").text(data.show.ket) : $("#showKet").text("-");
                        (data.show.info) ? $("#showInfo").text(data.show.info) : $("#showInfo").text("-");

                        var html = '';

                        if(data.show.fas_listrik){
                            html += '<div class="form-group">';
                            html += '<h5><i class="fas fa-bolt" style="color:#fd7e14;"></i> Listrik</h5>';
                            html += '<small class="text-muted pt-4 db">Alat Meter</small>';
                            html += '<h6>' + data.show.tlistrik.code + ' - (' + Number(data.show.tlistrik.meter).toLocaleString('id-ID') + ') - ' + data.show.tlistrik.power + ' Watt</h6>';
                            html += '<h6>ID : ' + data.show.tlistrik.name + '</h6>';
                            html += '<small class="text-muted pt-4 db">Tarif</small>';
                            html += '<h6>' + data.show.plistrik.name + '</h6>';
                            html += '<small class="text-muted pt-4 db">Diskon</small>';
                            (data.show.data.diskon.listrik)
                                ? html += '<h6>' + data.show.data.diskon.listrik +' %</h6>'
                                : html += '<h6>-</h6>';
                            html += '</div>';
                            html += '<hr>';
                        }

                        if(data.show.fas_airbersih){
                            html += '<div class="form-group">';
                            html += '<h5><i class="fas fa-tint" style="color:#36b9cc;""></i> Air Bersih</h5>';
                            html += '<small class="text-muted pt-4 db">Alat Meter</small>';
                            html += '<h6>' + data.show.tairbersih.code + ' - (' + Number(data.show.tairbersih.meter).toLocaleString('id-ID') + ')' + '</h6>'
                            html += '<h6>ID : ' + data.show.tairbersih.name + '</h6>';
                            html += '<small class="text-muted pt-4 db">Tarif</small>';
                            html += '<h6>' + data.show.pairbersih.name + '</h6>';
                            html += '<small class="text-muted pt-4 db">Diskon</small>';
                            (data.show.data.diskon.airbersih)
                                ? html += '<h6>' + data.show.data.diskon.airbersih +' %</h6>'
                                : html += '<h6>-</h6>';
                            html += '</div>';
                            html += '<hr>';
                        }

                        if(data.show.fas_keamananipk){
                            html += '<div class="form-group">';
                            html += '<h5><i class="fas fa-lock" style="color:#e74a3b;"></i> Keamanan IPK</h5>';
                            html += '<small class="text-muted pt-4 db">Tarif</small>';
                            html += '<h6>Rp. ' + Number(data.show.pkeamananipk.price).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Los</small></h6>';
                            html += '<small class="text-muted pt-4 db">Total sebelum Diskon</small>';
                            html += '<h6>Rp. ' + Number(data.show.pkeamananipk.price * data.show.jml_los).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>';
                            html += '<small class="text-muted pt-4 db">Diskon</small>';
                            (data.show.data.diskon.keamananipk)
                                ? html += '<h6>Rp. ' + Number(data.show.data.diskon.keamananipk).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>'
                                : html += '<h6>-</h6>';
                            html += '<small class="text-muted pt-4 db">Total setelah Diskon</small>';
                            html += '<h6>Rp. ' + Number((data.show.pkeamananipk.price * data.show.jml_los) - data.show.data.diskon.keamananipk).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>';
                            html += '</div>';
                            html += '<hr>';
                        }

                        if(data.show.fas_kebersihan){
                            html += '<div class="form-group">';
                            html += '<h5><i class="fas fa-leaf" style="color:#1cc88a;"></i> Kebersihan</h5>';
                            html += '<small class="text-muted pt-4 db">Tarif</small>';
                            html += '<h6>Rp. ' + Number(data.show.pkebersihan.price).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Los</small></h6>';
                            html += '<small class="text-muted pt-4 db">Total sebelum Diskon</small>';
                            html += '<h6>Rp. ' + Number(data.show.pkebersihan.price * data.show.jml_los).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>';
                            html += '<small class="text-muted pt-4 db">Diskon</small>';
                            (data.show.data.diskon.kebersihan)
                                ? html += '<h6>Rp. ' + Number(data.show.data.diskon.kebersihan).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>'
                                : html += '<h6>-</h6>';
                            html += '<small class="text-muted pt-4 db">Total setelah Diskon</small>';
                            html += '<h6>Rp. ' + Number((data.show.pkebersihan.price * data.show.jml_los) - data.show.data.diskon.kebersihan).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>';
                            html += '</div>';
                            html += '<hr>';
                        }

                        if(data.show.fas_airkotor){
                            html += '<div class="form-group">';
                            html += '<h5><i class="fad fa-burn" style="color:#000000;"></i> Air Kotor</h5>';
                            html += '<small class="text-muted pt-4 db">Tarif</small>';
                            html += '<h6>Rp. ' + Number(data.show.pairkotor.price).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>';
                            html += '<small class="text-muted pt-4 db">Diskon</small>';
                            (data.show.data.diskon.airkotor)
                                ? html += '<h6>Rp. ' + Number(data.show.data.diskon.airkotor).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>'
                                : html += '<h6>-</h6>';
                            html += '<small class="text-muted pt-4 db">Total setelah Diskon</small>';
                            html += '<h6>Rp. ' + Number(data.show.pairkotor.price - data.show.data.diskon.airkotor).toLocaleString('id-ID') + ' <small style="font-weight: 600;">per-Kontrol</small></h6>';
                            html += '</div>';
                            html += '<hr>';
                        }

                        if(data.show.fas_lain){
                            html += '<div class="form-group">';
                            html += '<h5><i class="fas fa-chart-pie" style="color:#c5793a;"></i> Lainnya</h5>';

                            var json = $.parseJSON(data.show.fas_lain);
                            $.each(json, function(i, val){
                                html += '<small class="text-muted pt-4 db">Fasilitas ' + val.name + '</small>';
                                html += '<h6>Rp. ' + Number(val.price).toLocaleString('id-ID') + " <small style='font-weight: 600;'>" + val.satuan_name + '</small></h6>';
                            });

                            html += '</div>';
                            html += '<hr>';
                        }

                        if(html){
                            $("#showFasilitas").append(html);
                        }
                        else {
                            html += '<div class="form-group mt-4 text-center">';
                            html += '<img src="/img/sad.png" class="rounded-circle" width="180" />';
                            html += '<h4>Tidak memiliki fasilitas apapun</h4>'
                            html += '</div>';
                            $("#showFasilitas").append(html);
                        }
                    }

                    if(data.info){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.info(data.info);
                    }

                    if(data.warning){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.warning(data.warning);
                    }

                    if(data.error){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error(data.error);
                    }

                    if(data.description){
                        console.log(data.description);
                    }
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("Fetching data failed.");
                    console.log(data);
                },
                complete:function(){
                    $('#showModal').modal('show');
                }
            });
        });

        //Nomor Los
        $('#group').on("change", function(e) {
            var group = $('#group').val();
            $("#los").prop("disabled", false);
            $("#los").val("");
            select2custom("#los", "/search/" + group + "/los", "-- Cari Nomor Los --");
        });

        //Kode Kontrol
        $('#los').on('change', function(e) {
            if($("#los").val() == ""){
                $("#kontrol").prop("disabled", true).val("");
            }
            else{
                $("#kontrol").prop("disabled", false);

                var dataset = {
                    'group' : $("#group").val(),
                    'los' : $("#los").val(),
                };
                $.ajax({
                    url: "/production/point/stores/generate/kontrol",
                    type: "GET",
                    cache: false,
                    data: dataset,
                    success:function(data)
                    {
                        $("#kontrol").val(data.success);
                        console.log(data.success);
                    },
                    error:function(data){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error("System error.");
                        console.log(data);
                    }
                });
            }
        });

        //Pengguna
        $('#pengguna').on("input", function(e) {
            if($('#pengguna').val()){
                $("#cancelPengguna").show();
            }
            else{
                $("#cancelPengguna").hide();
            }
        });

        $("#cancelPengguna").click(function(){
            $("#pengguna").val(null).trigger("change");
            $("#cancelPengguna").hide();
        });

        //Pemilik
        $('#pemilik').on("input", function(e) {
            if($('#pemilik').val()){
                $("#cancelPemilik").show();
            }
            else{
                $("#cancelPemilik").hide();
            }
        });

        $("#cancelPemilik").click(function(){
            $("#pemilik").val(null).trigger("change");
            $("#cancelPemilik").hide();
        });

        function fasListrik(data){
            if(data == 'show'){
                $("#divlistrik").show();
                $("#tlistrik").prop("required", true);
                $("#plistrik").prop("required", true);
                $("#fas_listrik").prop("checked", true);
            }
            else{
                $("#divlistrik").hide();
                $("#tlistrik").prop("required", false);
                $("#plistrik").prop("required", false);
                $("#fas_listrik").prop("checked", false);
            }
        }

        function checkFasListrik(){
            if($("#fas_listrik").is(":checked")){
                fasListrik("show");
            }
            else{
                fasListrik("hide");
            }
        }
        $('#fas_listrik').click(checkFasListrik).each(checkFasListrik);

        function fasAirBersih(data){
            if(data == 'show'){
                $("#divairbersih").show();
                $("#tairbersih").prop("required", true);
                $("#pairbersih").prop("required", true);
                $("#fas_airbersih").prop("checked", true);
            }
            else{
                $("#divairbersih").hide();
                $("#tairbersih").prop("required", false);
                $("#pairbersih").prop("required", false);
                $("#fas_airbersih").prop("checked", false);
            }
        }

        function checkFasAirBersih(){
            if($("#fas_airbersih").is(":checked")){
                fasAirBersih("show");
            }
            else{
                fasAirBersih("hide");
            }
        }
        $('#fas_airbersih').click(checkFasAirBersih).each(checkFasAirBersih);

        function fasKeamananIpk(data){
            if(data == 'show'){
                $("#divkeamananipk").show();
                $("#pkeamananipk").prop("required", true);
                $("#fas_keamananipk").prop("checked", true);
            }
            else{
                $("#divkeamananipk").hide();
                $("#pkeamananipk").prop("required", false);
                $("#fas_keamananipk").prop("checked", false);
            }
        }

        function checkFasKeamananIpk(){
            if($("#fas_keamananipk").is(":checked")){
                fasKeamananIpk("show");
            }
            else{
                fasKeamananIpk("hide");
            }
        }
        $('#fas_keamananipk').click(checkFasKeamananIpk).each(checkFasKeamananIpk);

        function fasKebersihan(data){
            if(data == 'show'){
                $("#divkebersihan").show();
                $("#pkebersihan").prop("required", true);
                $("#fas_kebersihan").prop("checked", true);
            }
            else{
                $("#divkebersihan").hide();
                $("#pkebersihan").prop("required", false);
                $("#fas_kebersihan").prop("checked", false);
            }
        }

        function checkFasKebersihan(){
            if($("#fas_kebersihan").is(":checked")){
                fasKebersihan("show");
            }
            else{
                fasKebersihan("hide");
            }
        }
        $('#fas_kebersihan').click(checkFasKebersihan).each(checkFasKebersihan);

        function fasAirKotor(data){
            if(data == 'show'){
                $("#divairkotor").show();
                $("#pairkotor").prop("required", true);
                $("#fas_airkotor").prop("checked", true);
            }
            else{
                $("#divairkotor").hide();
                $("#pairkotor").prop("required", false);
                $("#fas_airkotor").prop("checked", false);
            }
        }

        function checkFasAirKotor(){
            if($("#fas_airkotor").is(":checked")){
                fasAirKotor("show");
            }
            else{
                fasAirKotor("hide");
            }
        }
        $('#fas_airkotor').click(checkFasAirKotor).each(checkFasAirKotor);

        function statusTempat() {
            if ($('#stt_aktif').is(':checked')) {
                $("#ketLabel").addClass("hide");
                $("#ket").prop("required", false).attr("placeholder", "Ketikkan keterangan disini");
            }
            else if ($('#stt_bebas').is(':checked')) {
                $("#ketLabel").addClass("hide");
                $("#ket").prop("required", false).attr("placeholder", "Ketikkan keterangan disini");
            }
            else {
                $("#ketLabel").removeClass("hide");
                $("#ket").prop("required", true).attr("placeholder", "Kenapa nonaktif ?");
            }
        }
        $('input[name="status"]').click(statusTempat).each(statusTempat);

        function select2custom(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.name,
                                    text: d.name
                                }
                            })
                        };
                    },
                }
            });
        }

        function select2user(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.name + ' (' + d.ktp + ')'
                                }
                            })
                        };
                    },
                }
            });
        }

        function select2idname(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                maximumSelectionLength: 3,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.name
                                }
                            })
                        };
                    },
                }
            });
        }

        function select2idprice(select2id, url, placeholder, satuan){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.name + ' - ' + Number(d.price).toLocaleString('id-ID') + ' ' + satuan
                                }
                            })
                        };
                    },
                }
            });
        }

        function select2tlistrik(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.code + ' - (' + Number(d.meter).toLocaleString('id-ID') + ') - ' + d.power + ' Watt' + ' - ID: ' + d.name
                                }
                            })
                        };
                    },
                }
            });
        }

        function select2tairbersih(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.code + ' - (' + Number(d.meter).toLocaleString('id-ID') + ') - ID: ' + d.name
                                }
                            })
                        };
                    },
                }
            });
        }

        function select2plain(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.name + ' - ' + Number(d.price).toLocaleString('id-ID') + " " + satuanLain(d.satuan)
                                }
                            })
                        };
                    },
                }
            });
        }
        function satuanLain(data){
            return (data == 2) ? "per-Los" : "per-Kontrol";
        }

        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        }

        $("#kontrol").on("input", function(){
            this.value = this.value.replace(/[^0-9a-zA-Z/\-]+$/g, '');
        });

        $(".number").on('input', function (e) {
            if(e.which >= 37 && e.which <= 40) return;

            if (/^[0-9.,]+$/.test($(this).val())) {
                $(this).val(parseFloat($(this).val().replace(/\./g, '')).toLocaleString('id-ID'));
            }
            else {
                $(this).val($(this).val().substring(0, $(this).val().length - 1));
            }
        });

        $('.percent').on('input', function (e) {
            if ($(this).val() > 100) $(this).val($(this).val().replace($(this).val(), 100));
        });

        var showtempat = getCookie('showtempat');
        if(showtempat == 'hide'){
            $("#showtempat").hide();
        }
        else{
            $("#showtempat").show();
        }
        $("#showagain").click(function(){
            setCookie('showtempat','hide',30);
            $("#showtempat").hide();
        });

        function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

        $('#storeModal').on('shown.bs.modal', function() {
            $('#group').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Cari Kode Blok disini..');
            });
            $('#pengguna, #pemilik').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Cari Nama/KTP/Paspor disini..');
            });
            $('#tlistrik').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Cari Kode/Meter/Daya/ID disini..');
            });
            $('#tairbersih').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Cari Kode/Meter/ID disini..');
            });
            $('#plistrik, #pairbersih').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Cari Nama Tarif disini..');
            });
            $('#pkeamananipk, #pkebersihan, #pairkotor').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Cari Tarif/Nama Tarif disini..');
            });
        });
    });
</script>
@endsection
