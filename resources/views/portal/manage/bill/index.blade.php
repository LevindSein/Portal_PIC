@extends('portal.layout.master')

@section('content-title')
Kelola Tagihan
@endsection

@section('content-button')
<button type="button" class="btn btn-success add" data-toggle="tooltip" data-placement="left" title="Tambah Data">
    <i class="fas fa-fw fa-plus"></i>
</button>
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn mr-3">
        @include('portal.manage.button')
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group col-md-3" style="padding: 0;">
                    <label for="period">Periode Tagihan</label>
                    <select class="select2 form-control" id="period" name="period"></select>
                </div>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kontrol</th>
                                <th>Nama</th>
                                <th>
                                    Fasilitas
                                    <sup>
                                        <i class="far fa-question-circle"
                                            style="color:#5b5b5b;"
                                            data-container="body"
                                            data-trigger="hover"
                                            title="Fasilitas"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="Arahkan kursor
                                            <i class='fad fa-swap-opacity fa-mouse-pointer'></i><br>
                                            ke ikon fasilitas <i class='fas fa-bolt' style='color:#fd7e14;'></i>
                                            <i class='fas fa-tint' style='color:#36b9cc;'></i>
                                            <i class='fas fa-lock' style='color:#e74a3b;'></i>
                                            <i class='fas fa-leaf' style='color:#1cc88a;'></i>
                                            <i class='fad fa-burn' style='color:#000000;'></i>
                                            <i class='fas fa-chart-pie' style='color:#c5793a;'></i><br>
                                            untuk melihat detail tagihan.">
                                        </i>
                                    </sup>
                                </th>
                                <th>Tagihan</th>
                                <th>Action</th>
                                <th>Publish</th>
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
                <h5 class="modal-title titles"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body-xl">
                <div class="row">
                    <div class="col-lg-6 col-xlg-6">
                        <small class="text-muted pt-4 db">Kode Tagihan</small>
                        <h4 id="showCode"></h4>
                        <small class="text-muted pt-4 db">Periode</small>
                        <h6 id="showPeriod"></h6>
                        <small class="text-muted pt-4 db">Kontrol</small>
                        <h6 id="showKontrol"></h6>
                        <small class="text-muted pt-4 db">Blok</small>
                        <h6 id="showBlok"></h6>
                        <small class="text-muted pt-4 db">Nomor Los</small>
                        <h6 id="showLos"></h6>
                        <small class="text-muted pt-4 db">Jumlah Los</small>
                        <h6 id="showJumlah"></h6>
                        <small class="text-muted pt-4 db">Pengguna</small>
                        <h6 id="showPengguna"></h6>
                        <small class="text-muted pt-4 db">Status Lunas</small>
                        <h6 id="showLunas"></h6>
                        <small class="text-muted pt-4 db">Total Tagihan</small>
                        <h6 class="text-info" id="showTotal"></h6>
                        <small class="text-muted pt-4 db">Realisasi Tagihan</small>
                        <h6 class="text-success" id="showRealisasi"></h6>
                        <small class="text-muted pt-4 db">Selisih Tagihan</small>
                        <h6 class="text-danger" id="showSelisih"></h6>
                        <small class="text-muted pt-4 db">Status Publish</small>
                        <h6 id="showPublish"></h6>
                        <small class="text-muted pt-4 db">Dibuat oleh</small>
                        <h6 id="showCreate"></h6>
                        <small class="text-muted pt-4 db">Diperbaharui oleh</small>
                        <h6 id="showEdit"></h6>
                    </div>
                    <div class="col-lg-6 col-xlg-6">
                        <h3 class="text-center">Tagihan</h3>
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

<div id="billModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="billForm">
                <div class="modal-body-xl">
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Periode Tagihan <span class="text-danger">*</span>
                                    <sup>
                                        <i class="far fa-question-circle"
                                            style="color:#5b5b5b;"
                                            data-container="body"
                                            data-trigger="hover"
                                            title="Periode Tagihan"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="Pilih periode tagihan yang tersedia. Note: <b>Mengedit</b> tagihan tidak dapat mengubah periode tagihan yang telah dipilih.">
                                        </i>
                                    </sup>
                                </label>
                                <select required id="periode" name="periode" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Kode Kontrol <span class="text-danger">*</span>
                                    <sup>
                                        <a href='{{url("production/point/stores")}}' target="_blank">
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Kode Kontrol"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Pilih kode kontrol yang tersedia. Note: <b>Mengedit</b> tagihan tidak dapat mengubah kode kontrol yang telah dipilih. <br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Kontrol yang tersedia">
                                            </i>
                                        </a>
                                    </sup>
                                </label>
                                <select required id="kontrol" name="kontrol" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Blok Tempat <span class="text-danger">*</span>
                                    <sup>
                                        <i class="far fa-question-circle"
                                            style="color:#5b5b5b;"
                                            data-container="body"
                                            data-trigger="hover"
                                            title="Blok Tempat / Grup Tempat"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="Akan terisi secara otomatis sesuai kode kontrol yang dipilih.">
                                        </i>
                                    </sup>
                                </label>
                                <input id="group" name="group" class="form-control form-control-line" placeholder="(Sesuai Kode Kontrol yang terisi)"/>
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
                                                data-content="Nomor petunjuk lokasi tempat usaha, Anda dapat mengisinya setelah Blok Tempat terisi. Ini akan menghitung otomatis tagihan yang berjenis <b>per-Los</b>.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Nomor Los pada Blok tempat">
                                            </i>
                                        </a>
                                    </sup>
                                </label>
                                <select required id="los" name="los[]" class="select2 form-control form-control-line" style="width: 100%;" multiple></select>
                            </div>
                            <div class="form-group">
                                <label>Pengguna Tempat <span class="text-danger">*</span>
                                    <sup>
                                        <a href='{{url("production/users")}}' target="_blank">
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Pengguna Tempat"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Pengguna yang bertanggung jawab atas tagihan yang dibebankan.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Pengguna yang tersedia.">
                                            </i>
                                        </a>
                                    </sup>
                                </label>
                                <select id="pengguna" name="pengguna" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="stt_publish" name="stt_publish" checked>
                                    <label class="custom-control-label" for="stt_publish">Publish Tagihan
                                        <sup>
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Publish Tagihan"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Mengirim tagihan ke kasir untuk dibayar dan mengirim notifikasi ke pengguna tempat untuk melakukan pembayaran tagihan.">
                                            </i>
                                        </sup>
                                    </label>
                                </div>
                            </div>
                            <p class="text-danger">Pastikan data tagihan benar sebelum di publish.</p>
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            <h4 class="text-center" id="titleTagihan"></h4>
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_listrik" name="fas_listrik">
                                        <label class="custom-control-label text-warning" for="fas_listrik">Listrik
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Tagihan Listrik"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Aktif</b> : Apabila periode tagihan dan kode kontrol sudah terisi dan atau tagihan belum lunas.<br><b>Tambah</b> : Aktifkan kolom.<br><b>Hapus</b> : Hilangkan centang.<br><b>Lunas</b> : Data tidak dapat diedit.<br><b>Dapat memulihkan</b> : Apabila anda menghapus tagihan.">
                                                </i>
                                            </sup>
                                        </label>
                                        <small class="text-success" id="lunas_listrik">(Lunas)</small>
                                    </div>
                                </div>
                                <div id="divlistrik" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/prices/listrik")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Listrik"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Pilih tarif listrik yang tersedia.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Tarif.">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <select id="plistrik" name="plistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Daya Listrik <span class="text-danger">*</span>
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Daya Listrik"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Ketikkan besaran daya listrik.<br><b>Isi Manual</b> : Apabila tempat usaha tidak terdeteksi memiliki alat meter listrik.<br><b>Isi Otomatis</b> : Apabila tempat usaha terdeteksi memiliki alat meter.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <input maxlength="11" type="text" id="dayalistrik" name="dayalistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Watt</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Awal Meter <span class="text-danger">*</span>
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Awal Meter Listrik"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Ketikkan posisi angka meteran terdahulu.<br><b>Isi Manual</b> : Apabila tempat usaha tidak terdeteksi memiliki alat meter.<br><b>Isi Otomatis</b> : Apabila tempat usaha terdeteksi memiliki alat meter.">
                                                </i>
                                            </sup>
                                        </label>
                                        <input maxlength="11" type="text" id="awlistrik" name="awlistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group">
                                        <label>Akhir Meter <span class="text-danger">*</span>
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Akhir Meter Listrik"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Ketikkan posisi angka meteran terbaru.<br><b>Isi Manual</b> : Apabila tempat usaha tidak terdeteksi memiliki alat meter.<br><b>Isi Otomatis</b> : Apabila tempat usaha terdeteksi memiliki alat meter.">
                                                </i>
                                            </sup>
                                        </label>
                                        <input maxlength="11" type="text" id="aklistrik" name="aklistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group form-check form-check-inline">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checklistrik0" name="checklistrik0">
                                            <label class="custom-control-label" for="checklistrik0">Meter kembali ke Nol <span id="labellistrik0" class="text-danger">*</span>
                                                <sup>
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Reset Meteran"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="<b>Manual</b> : Apabila sistem tidak mendeteksi meteran mengalami reset.<br><b>Otomatis</b> : Apabila akhir meter lebih kecil daripada awal meter.">
                                                    </i>
                                                </sup>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Diskon Tagihan Listrik"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Isi dengan angka <b>0-100</b> % Tagihan.<br><b>Manual</b> : Apabila anda ingin menambahkan diskon tagihan.<br><b>Otomatis</b> : Apabila sistem mendeteksi tempat usaha mendapat regulasi terkait diskon tagihan.">
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
                                        <label>Denda
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Denda Tagihan Listrik"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="isi dengan banyaknya periode tagihan yang menunggak.<br><b>Manual</b> : Apabila anda ingin menambahkan denda tagihan.<br><b>Otomatis</b> : Apabila sistem mendeteksi tagihan mengalami jatuh tempo.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <input maxlength="5" type="text" id="denlistrik" name="denlistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bulan</span>
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
                                        <label class="custom-control-label text-info" for="fas_airbersih">Air Bersih
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Tagihan Air Bersih"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Aktif</b> : Apabila periode tagihan dan kode kontrol sudah terisi dan atau tagihan belum lunas.<br><b>Tambah</b> : Aktifkan kolom.<br><b>Hapus</b> : Hilangkan centang.<br><b>Lunas</b> : Data tidak dapat diedit.<br><b>Dapat memulihkan</b> : Apabila anda menghapus tagihan.">
                                                </i>
                                            </sup>
                                        </label>
                                        <small class="text-success" id="lunas_airbersih">(Lunas)</small>
                                    </div>
                                </div>
                                <div id="divairbersih" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/prices/airbersih")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Air Bersih"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Pilih tarif air bersih yang tersedia.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Tarif.">
                                                    </i>
                                                </a>
                                            </sup>
                                        </label>
                                        <select id="pairbersih" name="pairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Awal Meter <span class="text-danger">*</span>
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Awal Meter Air Bersih"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Ketikkan posisi angka meteran terdahulu.<br><b>Isi Manual</b> : Apabila tempat usaha tidak terdeteksi memiliki alat meter.<br><b>Isi Otomatis</b> : Apabila tempat usaha terdeteksi memiliki alat meter.">
                                                </i>
                                            </sup>
                                        </label>
                                        <input maxlength="11" type="text" id="awairbersih" name="awairbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group">
                                        <label>Akhir Meter <span class="text-danger">*</span>
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Akhir Meter Air Bersih"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Ketikkan posisi angka meteran terbaru.<br><b>Isi Manual</b> : Apabila tempat usaha tidak terdeteksi memiliki alat meter.<br><b>Isi Otomatis</b> : Apabila tempat usaha terdeteksi memiliki alat meter.">
                                                </i>
                                            </sup>
                                        </label>
                                        <input maxlength="11" type="text" id="akairbersih" name="akairbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group form-check form-check-inline">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkairbersih0" name="checkairbersih0">
                                            <label class="custom-control-label" for="checkairbersih0">Meter kembali ke Nol <span id="labelairbersih0" class="text-danger">*</span>
                                                <sup>
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Reset Meteran"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="<b>Manual</b> : Apabila sistem tidak mendeteksi meteran mengalami reset.<br><b>Otomatis</b> : Apabila akhir meter lebih kecil daripada awal meter.">
                                                    </i>
                                                </sup>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Diskon Tagihan Air Bersih"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Isi dengan angka <b>0-100</b> % Tagihan.<br><b>Manual</b> : Apabila anda ingin menambahkan diskon tagihan.<br><b>Otomatis</b> : Apabila sistem mendeteksi tempat usaha mendapat regulasi terkait diskon tagihan.">
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
                                        <label>Denda
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Denda Tagihan Air Bersih"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="isi dengan banyaknya periode tagihan yang menunggak.<br><b>Manual</b> : Apabila anda ingin menambahkan denda tagihan.<br><b>Otomatis</b> : Apabila sistem mendeteksi tagihan mengalami jatuh tempo.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <input maxlength="5" type="text" id="denairbersih" name="denairbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bulan</span>
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
                                        <label class="custom-control-label text-danger" for="fas_keamananipk">Keamanan IPK
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Tagihan Keamanan IPK"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Aktif</b> : Apabila periode tagihan dan kode kontrol sudah terisi dan atau tagihan belum lunas.<br><b>Tambah</b> : Aktifkan kolom.<br><b>Hapus</b> : Hilangkan centang.<br><b>Lunas</b> : Data tidak dapat diedit.<br><b>Dapat memulihkan</b> : Apabila anda menghapus tagihan.">
                                                </i>
                                            </sup>
                                        </label>
                                        <small class="text-success" id="lunas_keamananipk">(Lunas)</small>
                                    </div>
                                </div>
                                <div id="divkeamananipk" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/prices/keamananipk")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Keamanan IPK"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Pilih tarif keamanan ipk yang tersedia.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Tarif.">
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
                                                    title="Diskon Tagihan Keamanan IPK"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Isi dengan nominal tertentu.<br><b>Manual</b> : Apabila anda ingin menambahkan diskon tagihan.<br><b>Otomatis</b> : Apabila sistem mendeteksi tempat usaha mendapat regulasi terkait diskon tagihan.">
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
                                        <label class="custom-control-label text-success" for="fas_kebersihan">Kebersihan
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Tagihan Kebersihan"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Aktif</b> : Apabila periode tagihan dan kode kontrol sudah terisi dan atau tagihan belum lunas.<br><b>Tambah</b> : Aktifkan kolom.<br><b>Hapus</b> : Hilangkan centang.<br><b>Lunas</b> : Data tidak dapat diedit.<br><b>Dapat memulihkan</b> : Apabila anda menghapus tagihan.">
                                                </i>
                                            </sup>
                                        </label>
                                        <small class="text-success" id="lunas_kebersihan">(Lunas)</small>
                                    </div>
                                </div>
                                <div id="divkebersihan" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/prices/kebersihan")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Kebersihan"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Pilih tarif kebersihan yang tersedia.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Tarif.">
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
                                                    title="Diskon Tagihan Kebersihan"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Isi dengan nominal tertentu.<br><b>Manual</b> : Apabila anda ingin menambahkan diskon tagihan.<br><b>Otomatis</b> : Apabila sistem mendeteksi tempat usaha mendapat regulasi terkait diskon tagihan.">
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
                                        <label class="custom-control-label text-dark" for="fas_airkotor">Air Kotor
                                            <sup>
                                                <i class="far fa-question-circle"
                                                    style="color:#5b5b5b;"
                                                    data-container="body"
                                                    data-trigger="hover"
                                                    title="Tagihan Air Kotor"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="<b>Aktif</b> : Apabila periode tagihan dan kode kontrol sudah terisi dan atau tagihan belum lunas.<br><b>Tambah</b> : Aktifkan kolom.<br><b>Hapus</b> : Hilangkan centang.<br><b>Lunas</b> : Data tidak dapat diedit.<br><b>Dapat memulihkan</b> : Apabila anda menghapus tagihan.">
                                                </i>
                                            </sup>
                                        </label>
                                        <small class="text-success" id="lunas_airkotor">(Lunas)</small>
                                    </div>
                                </div>
                                <div id="divairkotor" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span>
                                            <sup>
                                                <a href='{{url("production/prices/airkotor")}}' target="_blank">
                                                    <i class="far fa-question-circle"
                                                        style="color:#5b5b5b;"
                                                        data-container="body"
                                                        data-trigger="hover"
                                                        title="Tarif Air Kotor"
                                                        data-toggle="popover"
                                                        data-html="true"
                                                        data-content="Pilih tarif air kotor yang tersedia.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Tarif.">
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
                                                    title="Diskon Tagihan Air Kotor"
                                                    data-toggle="popover"
                                                    data-html="true"
                                                    data-content="Isi dengan nominal tertentu.<br><b>Manual</b> : Apabila anda ingin menambahkan diskon tagihan.<br><b>Otomatis</b> : Apabila sistem mendeteksi tempat usaha mendapat regulasi terkait diskon tagihan.">
                                                </i>
                                            </sup>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input maxlength="11" type="text" id="dairkotor" name="dairkotor" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
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
                            {{-- End Air Kotor --}}
                            {{-- Lainnya --}}
                            <div>
                                <div class="form-group" id="lunas_lain"></div>

                                <div id="divlainNew"></div>

                                <div class="form-group">
                                    <button id="divLainAdd" class="btn btn-sm btn-rounded btn-info"><i class="fas fa-fw fa-plus mr-1"></i>Tagihan Lainnya</button>
                                    <sup>
                                        <a href='{{url("production/prices/lain")}}' target="_blank">
                                            <i class="far fa-question-circle"
                                                style="color:#5b5b5b;"
                                                data-container="body"
                                                data-trigger="hover"
                                                title="Tagihan Lainnya"
                                                data-toggle="popover"
                                                data-html="true"
                                                data-content="Pilih tarif lainnya yang tersedia.<br><b>Aktif</b> : Apabila periode tagihan dan kode kontrol sudah terisi dan atau tagihan belum lunas.<br><b>Tidak dapat memulihkan</b> : Apabila anda menghapus tagihan.<br>Klik pada <i class='far fa-question-circle'></i> untuk mengelola Tarif.">
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
                    <input type="hidden" id="billFormValue"/>
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
        $("#period").val("").html("");
        select2period("#period", "/search/period", "-- Cari Periode Tagihan --");
        $("#period").on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini untuk mencari..');
        });

        period();
    });

    function period(){
        $.ajax({
            url: "/production/manage/bills/period",
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#period").val("").html("");
                    var period = new Option(data.success.nicename, data.success.id, false, false);
                    $('#period').append(period).trigger('change');
                }
            }
        });
    }

    $("#period").on('change', function(e){
        e.preventDefault();
        $.ajax({
            url: "/production/manage/bills/period/" + $("#period").val(),
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    dtableReload('');
                }
            }
        });
    });

    var lain = 0;
    var plain = 1;
    var id;
    var dtable = $('#dtable').DataTable({
        "language": {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        "serverSide": true,
        "ajax": "/production/manage/bills",
        "columns": [
            { data: 'kd_kontrol', name: 'nicename', class : 'text-center align-middle' },
            { data: 'name', name: 'name', class : 'text-center align-middle' },
            { data: 'fasilitas', name: 'fasilitas', class : 'text-center align-middle' },
            { data: 'b_tagihan', name: 'b_tagihan', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
            { data: 'publish', name: 'publish', class : 'text-center align-middle' },
        ],
        "stateSave": true,
        "deferRender": true,
        "pageLength": 10,
        "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
        "order": [[ 0, "asc" ]],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [2,3,4,5] },
            { "bSearchable": false, "aTargets": [2,4,5] }
        ],
        "scrollY": "50vh",
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
            }, 10);
            setTimeout( function () {
                $("[data-toggle='popover']").popover();
            }, 10);
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

    setInterval(function(){
        dtableReload('');
    }, 60000);

    function dtableReload(searchKey){
        if(searchKey){
            dtable.search(searchKey).draw();
        }
        dtable.ajax.reload(function(){
            console.log("Refresh Automatic")
        }, false);

        $(".tooltip").tooltip("hide");

        $(".popover").popover("hide");
    }

    $("#periode, #kontrol").on('change', function(){
        if($("#periode").val() && $("#kontrol").val() && $("#billFormValue").val() == 'add'){
            $.ajax({
                url: "/search/bill?periode=" + $("#periode").val() + "&kontrol=" + $("#kontrol").val(),
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#group").val(data.show.group);

                        $("#los").val("").html("").prop("disabled", false);
                        select2custom("#los", "/search/" + data.show.group + "/los", "-- Cari Nomor Los --");
                        var los = data.show.no_los;
                        $.each( los, function( i, val ) {
                            var option = $('<option></option>').attr('value', val).text(val).prop('selected', true);
                            $('#los').append(option).trigger('change');
                        });

                        $("#pengguna").val("").html("").prop("disabled", false);
                        select2user("#pengguna", "/search/users", "-- Cari Pengguna Tagihan --");
                        if(data.show.pengguna.id){
                            var pengguna = new Option(data.show.pengguna.name + ' (' + data.show.pengguna.ktp + ')', data.show.pengguna.id, false, false);
                            $('#pengguna').append(pengguna).trigger('change');
                        }

                        fasListrik("hide");
                        $("#fas_listrik").prop("checked", false).attr('disabled', false);
                        $('#plistrik').val("").html("");
                        $("#dayalistrik").val('');
                        $("#awlistrik").val('');
                        $("#aklistrik").val('');
                        $("#dlistrik").val('');

                        fasAirBersih("hide");
                        $("#fas_airbersih").prop("checked", false).attr('disabled', false);
                        $('#pairbersih').val("").html("");
                        $("#awairbersih").val('');
                        $("#akairbersih").val('');
                        $("#dairbersih").val('');

                        fasKeamananIpk("hide");
                        $("#fas_keamananipk").prop("checked", false).attr("disabled", false);
                        $('#pkeamananipk').val("").html("");
                        $("#dkeamananipk").val('');

                        fasKebersihan("hide");
                        $("#fas_kebersihan").prop("checked", false).attr("disabled", false);
                        $('#pkebersihan').val("").html("");
                        $("#dkebersihan").val('');

                        fasAirKotor("hide");
                        $("#fas_airkotor").prop("checked", false).attr("disabled", false);
                        $('#pairkotor').val("").html("");
                        $("#dairkotor").val('');

                        if(data.show.fas_listrik){
                            $("#fas_listrik").prop("checked", true).attr('disabled', false);
                            fasListrik('show');

                            var plistrik = new Option(
                                data.show.plistrik.name,
                                data.show.plistrik.id,
                                false,
                                false
                            );
                            $('#plistrik').append(plistrik).trigger('change');

                            $("#dayalistrik").val(Number(data.show.tlistrik.power).toLocaleString('id-ID'));
                            $("#awlistrik").val(Number(data.show.tlistrik.meter).toLocaleString('id-ID'));
                            $("#aklistrik").val(Number(data.show.tlistrik.meter).toLocaleString('id-ID'));

                            if(data.show.data.diskon.listrik){
                                $("#dlistrik").val(Number(data.show.data.diskon.listrik).toLocaleString('id-ID'));
                            }

                            $("#denlistrik").val(data.show.denlistrik);
                        }

                        if(data.show.fas_airbersih){
                            $("#fas_airbersih").prop("checked", true);
                            fasAirBersih('show');

                            var pairbersih = new Option(
                                data.show.pairbersih.name,
                                data.show.pairbersih.id,
                                false,
                                false
                            );
                            $('#pairbersih').append(pairbersih).trigger('change');

                            $("#awairbersih").val(Number(data.show.tairbersih.meter).toLocaleString('id-ID'));
                            $("#akairbersih").val(Number(data.show.tairbersih.meter).toLocaleString('id-ID'));

                            if(data.show.data.diskon.airbersih){
                                $("#dairbersih").val(Number(data.show.data.diskon.airbersih).toLocaleString('id-ID'));
                            }

                            $("#denairbersih").val(Number(data.show.denairbersih).toLocaleString('id-ID'));
                        }

                        if(data.show.fas_keamananipk){
                            $("#fas_keamananipk").prop("checked", true);
                            fasKeamananIpk('show');

                            var pkeamananipk = new Option(
                                data.show.pkeamananipk.name + ' - ' + Number(data.show.pkeamananipk.price).toLocaleString('id-ID') + ' per-Los',
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

                            var pkebersihan = new Option(
                                data.show.pkebersihan.name + ' - ' + Number(data.show.pkebersihan.price).toLocaleString('id-ID') + ' per-Los',
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

                            var pairkotor = new Option(
                                data.show.pairkotor.name + ' - ' + Number(data.show.pairkotor.price).toLocaleString('id-ID') + ' per-Kontrol',
                                data.show.pairkotor.id,
                                false,
                                false
                            );
                            $('#pairkotor').append(pairkotor).trigger('change');

                            if(data.show.data.diskon.airkotor){
                                $("#dairkotor").val(Number(data.show.data.diskon.airkotor).toLocaleString('id-ID'));
                            }
                        }

                        lain = 0;
                        plain = 1;
                        $('div[name="divlain"]').remove();
                        $("#divLainAdd").attr('disabled', false);
                        if(data.show.fas_lain){
                            var json = $.parseJSON(data.show.fas_lain);
                            $.each( json, function( i, val ) {
                                $('#divLainAdd').trigger('click');
                                var plainOpt = new Option(
                                    val.name + ' - ' + Number(val.price).toLocaleString('id-ID') + ' ' + val.satuan_name,
                                    val.id,
                                    false,
                                    false
                                );
                                $('#plain' + (plain-1)).append(plainOpt).trigger('change');
                            });
                        }
                    }

                    if(data.error){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error(data.error);
                        if(data.exists){
                            initForm();
                        }
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
                }
            });
        }
    });

    $("#awlistrik, #aklistrik").on('input', function(){
        var awal = Number($("#awlistrik").val().replace(/\./g, ''));
        var akhir = Number($("#aklistrik").val().replace(/\./g, ''));
        if(akhir < awal){
            $("#checklistrik0").prop("checked", true);
        }
        else{
            $("#checklistrik0").prop("checked", false);
        }
    })

    $("#awairbersih, #akairbersih").on('input', function(){
        var awal = Number($("#awairbersih").val().replace(/\./g, ''));
        var akhir = Number($("#akairbersih").val().replace(/\./g, ''));
        if(akhir < awal){
            $("#checkairbersih0").prop("checked", true);
        }
        else{
            $("#checkairbersih0").prop("checked", false);
        }
    })

    function initForm(){
        $("#periode").val("").html("").prop("disabled", false);
        select2period("#periode", "/search/period", "-- Cari Periode Tagihan --");

        $("#kontrol").val("").html("").prop("disabled", false);
        select2kontrol("#kontrol", "/search/kontrol", "-- Cari Kode Kontrol --");

        $("#group").val("").prop("readonly", true);

        $("#los").val("").html("").prop("disabled", true);
        $("#los").select2({
            placeholder: "(Sesuai Blok Tempat yang terisi)"
        });

        $("#pengguna").val("").html("").prop("required", true).prop("disabled", true);
        $("#pengguna").select2({
            placeholder: "(Kode Kontrol harus terisi)"
        });

        fasListrik("hide");
        $("#lunas_listrik").hide();
        $("#fas_listrik").prop("checked", false).attr('disabled', true);
        select2idname("#plistrik", "/search/price/listrik", "-- Cari Tarif Listrik --");
        $("#plistrik").val("").html("");
        select2idname("#plistrik", "/search/price/listrik", "-- Cari Tarif Listrik --");
        $("#dlistrik").val("").html("");

        fasAirBersih("hide");
        $("#lunas_airbersih").hide();
        $("#fas_airbersih").prop("checked", false).attr('disabled', true);
        select2idname("#pairbersih", "/search/price/airbersih", "-- Cari Tarif Air Bersih --");
        $("#pairbersih").val("").html("");
        select2idname("#pairbersih", "/search/price/airbersih", "-- Cari Tarif Air Bersih --");
        $("#dairbersih").val("").html("");

        fasKeamananIpk("hide");
        $("#lunas_keamananipk").hide();
        $("#fas_keamananipk").prop("checked", false).attr('disabled', true);
        select2idprice("#pkeamananipk", "/search/price/keamananipk", "-- Cari Tarif Keamanan IPK --", "per-Los");
        $("#dkeamananipk").val("").html("");

        fasKebersihan("hide");
        $("#lunas_kebersihan").hide();
        $("#fas_kebersihan").prop("checked", false).attr('disabled', true);
        select2idprice("#pkebersihan", "/search/price/kebersihan", "-- Cari Tarif Kebersihan --", "per-Los");
        $("#dkebersihan").val("").html("");

        fasAirKotor("hide");
        $("#lunas_airkotor").hide();
        $("#fas_airkotor").prop("checked", false).attr('disabled', true);
        select2idprice("#pairkotor", "/search/price/airkotor", "-- Cari Tarif Air Kotor --", "per-Kontrol");
        $("#dairkotor").val("").html("");

        lain = 0;
        plain = 1;
        $("#lunas_lain").html('');
        $('div[name="divlain"]').remove();
        $("#divLainAdd").attr('disabled', true);
    }

    $(".add").click( function(){
        $("#billForm")[0].reset();
        $('.titles').text('Tambah Tagihan');
        $("#billFormValue").val('add');
        $("#titleTagihan").text('Tambah Tagihan Fasilitas');

        initForm();

        $('#billModal').modal('show');
    });

    $('#billForm').submit(function(e){
        e.preventDefault();
        value = $("#billFormValue").val();
        if(value == 'add'){
            url = "/production/manage/bills";
            type = "POST";
        }
        else if(value == 'update'){
            url = "/production/manage/bills/" + id;
            type = "PUT";
        }
        dataset = $(this).serialize();
        ajaxForm(url, type, value, dataset);
    });

    $(document).on('click', '.edit', function(){
        id = $(this).attr('id');
        name = $(this).attr('nama');
        $("#billForm")[0].reset();
        $('.titles').text('Edit Tagihan ' + name);
        $("#titleTagihan").text('Edit Tagihan Fasilitas');
        $("#billFormValue").val('update');

        initForm();

        $.ajax({
            url: "/production/manage/bills/" + id + "/edit",
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    var period = new Option(data.show.period.nicename, data.show.period.id, false, false);
                    $('#periode').append(period).trigger('change');
                    $('#periode').select2({disabled:'readonly'});

                    var kontrol = new Option(data.show.kd_kontrol, data.show.kd_kontrol, false, false);
                    $('#kontrol').append(kontrol).trigger('change');
                    $('#kontrol').select2({disabled:'readonly'});

                    $("#group").val(data.show.group);

                    $("#los").val("").html("").prop("disabled", false);
                    select2custom("#los", "/search/" + data.show.group + "/los", "-- Cari Nomor Los --");
                    var los = data.show.no_los.split(',');
                    $.each( los, function( i, val ) {
                        var option = $('<option></option>').attr('value', val).text(val).prop('selected', true);
                        $('#los').append(option).trigger('change');
                    });

                    $("#pengguna").prop("required", false).prop("disabled", false);
                    select2user("#pengguna", "/search/users", data.show.name);

                    if(data.show.stt_publish){
                        $("#stt_publish").prop('checked', true);
                    }
                    else{
                        $("#stt_publish").prop('checked', false);
                    }

                    fasListrik("hide");
                    $("#fas_listrik").prop("checked", false).attr('disabled', false);
                    $('#plistrik').val("").html("");
                    $("#dayalistrik").val('');
                    $("#awlistrik").val('');
                    $("#aklistrik").val('');
                    $("#dlistrik").val('');

                    fasAirBersih("hide");
                    $("#fas_airbersih").prop("checked", false).attr('disabled', false);
                    $('#pairbersih').val("").html("");
                    $("#awairbersih").val('');
                    $("#akairbersih").val('');
                    $("#dairbersih").val('');

                    fasKeamananIpk("hide");
                    $("#fas_keamananipk").prop("checked", false).attr("disabled", false);
                    $('#pkeamananipk').val("").html("");
                    $("#dkeamananipk").val('');

                    fasKebersihan("hide");
                    $("#fas_kebersihan").prop("checked", false).attr("disabled", false);
                    $('#pkebersihan').val("").html("");
                    $("#dkebersihan").val('');

                    fasAirKotor("hide");
                    $("#fas_airkotor").prop("checked", false).attr("disabled", false);
                    $('#pairkotor').val("").html("");
                    $("#dairkotor").val('');

                    if(data.show.b_listrik){
                        if(data.show.b_listrik.lunas){
                            fasListrik("hide");
                            $("#lunas_listrik").show();
                            $("#fas_listrik").prop("checked", true).attr('disabled', true);
                        }
                        else{
                            $("#fas_listrik").prop("checked", true);
                            fasListrik('show');

                            var plistrik = new Option(
                                data.show.b_listrik.tarif_nama,
                                data.show.b_listrik.tarif_id,
                                false,
                                false
                            );
                            $('#plistrik').append(plistrik).trigger('change');

                            $("#dayalistrik").val(Number(data.show.b_listrik.daya).toLocaleString('id-ID'));
                            $("#awlistrik").val(Number(data.show.b_listrik.awal).toLocaleString('id-ID'));
                            $("#aklistrik").val(Number(data.show.b_listrik.akhir).toLocaleString('id-ID'));

                            if(data.show.b_listrik.reset){
                                $("#checklistrik0").prop("checked", true);
                            }

                            if(data.show.b_listrik.diskon){
                                $("#dlistrik").val(Number(data.show.b_listrik.diskon_persen).toLocaleString('id-ID'));
                            }

                            $("#denlistrik").val(data.show.b_listrik.denda_bulan);
                        }
                    }

                    if(data.show.b_airbersih){
                        if(data.show.b_airbersih.lunas){
                            fasAirBersih("hide");
                            $("#lunas_airbersih").show();
                            $("#fas_airbersih").prop("checked", true).attr('disabled', true);
                        }
                        else{
                            $("#fas_airbersih").prop("checked", true);
                            fasAirBersih('show');

                            var pairbersih = new Option(
                                data.show.b_airbersih.tarif_nama,
                                data.show.b_airbersih.tarif_id,
                                false,
                                false
                            );
                            $('#pairbersih').append(pairbersih).trigger('change');

                            $("#awairbersih").val(Number(data.show.b_airbersih.awal).toLocaleString('id-ID'));
                            $("#akairbersih").val(Number(data.show.b_airbersih.akhir).toLocaleString('id-ID'));

                            if(data.show.b_airbersih.reset){
                                $("#checkairbersih0").prop("checked", true);
                            }

                            if(data.show.b_airbersih.diskon){
                                $("#dairbersih").val(Number(data.show.b_airbersih.diskon_persen).toLocaleString('id-ID'));
                            }

                            $("#denairbersih").val(data.show.b_airbersih.denda_bulan);
                        }
                    }

                    if(data.show.b_keamananipk){
                        if(data.show.b_keamananipk.lunas){
                            fasKeamananIpk("hide");
                            $("#lunas_keamananipk").show();
                            $("#fas_keamananipk").prop("checked", true).attr('disabled', true);
                        }
                        else{
                            $("#fas_keamananipk").prop("checked", true);
                            fasKeamananIpk('show');

                            var pkeamananipk = new Option(
                                data.show.b_keamananipk.tarif_nama + ' - ' + Number(data.show.b_keamananipk.price).toLocaleString('id-ID') + ' per-Los',
                                data.show.b_keamananipk.tarif_id,
                                false,
                                false
                            );
                            $('#pkeamananipk').append(pkeamananipk).trigger('change');

                            if(data.show.b_keamananipk.diskon){
                                $("#dkeamananipk").val(Number(data.show.b_keamananipk.diskon).toLocaleString('id-ID'));
                            }
                        }
                    }

                    if(data.show.b_kebersihan){
                        if(data.show.b_kebersihan.lunas){
                            fasKebersihan("hide");
                            $("#lunas_kebersihan").show();
                            $("#fas_kebersihan").prop("checked", true).attr('disabled', true);
                        }
                        else{
                            $("#fas_kebersihan").prop("checked", true);
                            fasKebersihan('show');

                            var pkebersihan = new Option(
                                data.show.b_kebersihan.tarif_nama + ' - ' + Number(data.show.b_kebersihan.price).toLocaleString('id-ID') + ' per-Los',
                                data.show.b_kebersihan.tarif_id,
                                false,
                                false
                            );
                            $('#pkebersihan').append(pkebersihan).trigger('change');

                            if(data.show.b_kebersihan.diskon){
                                $("#dkebersihan").val(Number(data.show.b_kebersihan.diskon).toLocaleString('id-ID'));
                            }
                        }
                    }

                    if(data.show.b_airkotor){
                        if(data.show.b_airkotor.lunas){
                            fasAirKotor("hide");
                            $("#lunas_airkotor").show();
                            $("#fas_airkotor").prop("checked", true).attr('disabled', true);
                        }
                        else{
                            $("#fas_airkotor").prop("checked", true);
                            fasAirKotor('show');

                            var pairkotor = new Option(
                                data.show.b_airkotor.tarif_nama + ' - ' + Number(data.show.b_airkotor.price).toLocaleString('id-ID') + ' per-Kontrol',
                                data.show.b_airkotor.tarif_id,
                                false,
                                false
                            );
                            $('#pairkotor').append(pairkotor).trigger('change');

                            if(data.show.b_airkotor.diskon){
                                $("#dairkotor").val(Number(data.show.b_airkotor.diskon).toLocaleString('id-ID'));
                            }
                        }
                    }

                    $('div[name="divlain"]').remove();
                    $("#divLainAdd").attr('disabled', false);
                    if(data.show.b_lain){
                        $.each( data.show.b_lain, function( i, val ) {
                            $('#divLainAdd').trigger('click');
                            if(val.lunas == 0){
                                var plainOpt = new Option(
                                    val.tarif_nama + ' - ' + Number(val.price).toLocaleString('id-ID') + ' ' + val.satuan_nama,
                                    val.tarif_id,
                                    false,
                                    false
                                );
                                $('#plain' + (plain-1)).append(plainOpt).trigger('change');
                            }
                            else{
                                var html = '';
                                html += '<div>';
                                html += '<label>' + val.tarif_nama + '</label> <span>: ' + Number(val.price).toLocaleString('id-ID') + ' ' + val.satuan_nama + '</span> <small class="text-success">(Lunas)</small>';
                                html += '</div>';
                                $('#lunas_lain').append(html);

                                $('#plain' + (plain-1)).closest("[name='divlain']").remove();
                            }
                        });
                    }
                }

                if(data.error){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error(data.error);
                }

                if(data.warning){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.warning(data.warning);
                }

                if(data.info){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.info(data.info);
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
                $('#billModal').modal('show');
            }
        });
    });

    $(document).on('click', '.publish', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Publish ' + nama + ' ?');
        $('.bodies').html('Pilih <b>Publish</b> di bawah ini jika anda yakin untuk publish tagihan. Dengan publish tagihan, maka tagihan akan ada pada menu pembayaran dan tagihan akan dikirim ke nasabah terkait.');
        $('#ok_button').removeClass().addClass('btn btn-success').text('Publish');
        $('#confirmValue').val('publish');
        $('#confirmModal').modal('show');
    });

    $(document).on('click', '.unpublish', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Unpublish ' + nama + ' ?');
        $('.bodies').html('Pilih <b>Unpublish</b> di bawah ini jika anda yakin untuk unpublish tagihan.');
        $('#ok_button').removeClass().addClass('btn btn-danger').text('Unpublish');
        $('#confirmValue').val('unpublish');
        $('#confirmModal').modal('show');
    });

    $(document).on('click', '.delete', function(){
        id = $(this).attr('id');
        name = $(this).attr('nama');
        $('.titles').text('Hapus permanen data ' + name + '?');
        $('.bodies').html('Pilih <b>Hapus</b> di bawah ini jika anda yakin untuk menghapus data tagihan.');
        $('#ok_button').removeClass().addClass('btn btn-danger').text('Hapus');
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

        if(value == 'publish'){
            url = "/production/manage/bills/publish/" + id;
            type = "POST";
        }
        else if(value == 'unpublish'){
            url = "/production/manage/bills/publish/" + id;
            type = "POST";
        }
        else if(value == 'delete'){
            url = "/production/manage/bills/" + id;
            type = "DELETE";
        }

        ajaxForm(url, type, value, dataset);
    });

    $(document).on('click', '.details', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Tagihan ' + nama);

        $("#showFasilitas").html('');

        $.ajax({
            url: "/production/manage/bills/" + id,
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#showCode").text(data.show.code);
                    $("#showPeriod").text(data.show.period.nicename);
                    $("#showKontrol").text(data.show.kd_kontrol);
                    $("#showBlok").text(data.show.group);
                    $("#showLos").text(data.show.no_los);
                    $("#showJumlah").text(data.show.jml_los);
                    $("#showPengguna").text(data.show.name);
                    $("#showTotal").text('Rp. ' + Number(data.show.b_tagihan.ttl_tagihan).toLocaleString('id-ID'));
                    $("#showRealisasi").text('Rp. ' + Number(data.show.b_tagihan.rea_tagihan).toLocaleString('id-ID'));
                    $("#showSelisih").text('Rp. ' + Number(data.show.b_tagihan.sel_tagihan).toLocaleString('id-ID'));
                    $("#showCreate").html(data.show.data.created_by_name + "<br>pada " + data.show.data.created_at);
                    $("#showEdit").html(data.show.data.updated_by_name + "<br>pada " + data.show.data.updated_at);
                    $("#showPublish").html(data.show.stt_publish + "<br>pada " + data.show.publish + "<br>oleh " + data.show.data.publish_by);
                    $("#showLunas").html(data.show.stt_lunas);

                    var html = '';

                    if(data.show.b_listrik){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-bolt" style="color:#fd7e14;"></i> Listrik</h5>';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Status</small>';
                        html += '<h6>' + data.show.b_listrik.lunas + '</h6>';
                        html += (data.show.b_listrik.kasir) ? '<h6>' + data.show.b_listrik.kasir + '</h6>' : '';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_listrik.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_listrik.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_listrik.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="acc_listrik">';
                        html += '<div id="col_listrik" class="collapse" aria-labelledby="head_listrik" data-parent="#acc_listrik">';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + data.show.b_listrik.tarif_nama + '</h6>';
                        html += '<small class="text-muted pt-4 db">Alat Meter</small>';
                        html += (data.show.code_tlistrik) ? '<h6>' + data.show.code_tlistrik + '</h6>' : '<h6>?</h6>';
                        html += '<small class="text-muted pt-4 db">Daya</small>';
                        html += '<h6>' + Number(data.show.b_listrik.daya).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Awal</small>';
                        html += '<h6>' + Number(data.show.b_listrik.awal).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Akhir</small>';
                        html += '<h6>' + Number(data.show.b_listrik.akhir).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Reset</small>';
                        html += (data.show.b_listrik.reset) ? '<h6>Ya</h6>' : '<h6>Tidak</h6>';
                        html += '<small class="text-muted pt-4 db">Pakai</small>';
                        html += '<h6>' + Number(data.show.b_listrik.pakai).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Blok 1</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_listrik.blok1).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Blok 2</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_listrik.blok2).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">+ Beban</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_listrik.beban).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ PJU</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_listrik.pju).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ PPN</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_listrik.ppn).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Subtotal</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_listrik.sub_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Denda</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_listrik.denda).toLocaleString('id-ID') + ' (' + Number(data.show.b_listrik.denda_bulan).toLocaleString('id-ID') + ' Bln)</h6>';
                        html += '<small class="text-muted pt-4 db">- Diskon</small>';
                        html += (data.show.b_listrik.diskon) ? '<h6>Rp. ' + Number(data.show.b_listrik.diskon).toLocaleString('id-ID') + ' (' + data.show.b_listrik.diskon_persen + ' %)</h6>' : '<h6>0</h6>';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_listrik.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_listrik.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_listrik.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        if(data.show.b_listrik.restored_by_name){
                            html += '<div class="form-group text-center">';
                            html += '<p>Dipulihkan : ' + data.show.b_listrik.restored_by_name + '</p>';
                            html += '<p>' + data.show.b_listrik.restored_time + '</p>';
                            html += '</div>';
                        }
                        html += '</div>';
                        html += '<div id="head_listrik" class="text-center">';
                        html += '<h5>';
                        html += '<button class="btn btn-link collapsed text-info klik" data-toggle="collapse" data-target="#col_listrik" aria-expanded="false" aria-controls="col_listrik">';
                        html += 'Klik, untuk selengkapnya';
                        html += '</button>';
                        html += '</h5>';
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.b_airbersih){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-tint" style="color:#36b9cc;""></i> Air Bersih</h5>';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Status</small>';
                        html += '<h6>' + data.show.b_airbersih.lunas + '</h6>';
                        html += (data.show.b_airbersih.kasir) ? '<h6>' + data.show.b_airbersih.kasir + '</h6>' : '';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_airbersih.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_airbersih.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_airbersih.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="acc_airbersih">';
                        html += '<div id="col_airbersih" class="collapse" aria-labelledby="head_airbersih" data-parent="#acc_airbersih">';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + data.show.b_airbersih.tarif_nama + '</h6>';
                        html += '<small class="text-muted pt-4 db">Alat Meter</small>';
                        html += (data.show.code_tairbersih) ? '<h6>' + data.show.code_tairbersih + '</h6>' : '<h6>?</h6>';
                        html += '<small class="text-muted pt-4 db">Awal</small>';
                        html += '<h6>' + Number(data.show.b_airbersih.awal).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Akhir</small>';
                        html += '<h6>' + Number(data.show.b_airbersih.akhir).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Reset</small>';
                        html += (data.show.b_airbersih.reset) ? '<h6>Ya</h6>' : '<h6>Tidak</h6>';
                        html += '<small class="text-muted pt-4 db">Pakai</small>';
                        html += '<h6>' + Number(data.show.b_airbersih.pakai).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Pembayaran</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airbersih.bayar).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Pemeliharaan</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airbersih.pemeliharaan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Beban</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airbersih.beban).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">+ Air Kotor</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airbersih.arkot).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ PPN</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airbersih.ppn).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Subtotal</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airbersih.sub_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Denda</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airbersih.denda).toLocaleString('id-ID') + ' (' + Number(data.show.b_airbersih.denda_bulan).toLocaleString('id-ID') + ' Bln)</h6>';
                        html += '<small class="text-muted pt-4 db">- Diskon</small>';
                        html += (data.show.b_airbersih.diskon) ? '<h6>Rp. ' + Number(data.show.b_airbersih.diskon).toLocaleString('id-ID') + ' (' + data.show.b_airbersih.diskon_persen + ' %)</h6>' : '<h6>0</h6>';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_airbersih.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_airbersih.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_airbersih.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        if(data.show.b_airbersih.restored_by_name){
                            html += '<div class="form-group text-center">';
                            html += '<p>Dipulihkan : ' + data.show.b_airbersih.restored_by_name + '</p>';
                            html += '<p>' + data.show.b_airbersih.restored_time + '</p>';
                            html += '</div>';
                        }
                        html += '</div>';
                        html += '<div id="head_airbersih" class="text-center">';
                        html += '<h5>';
                        html += '<button class="btn btn-link collapsed text-info klik" data-toggle="collapse" data-target="#col_airbersih" aria-expanded="false" aria-controls="col_airbersih">';
                        html += 'Klik, untuk selengkapnya';
                        html += '</button>';
                        html += '</h5>';
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.b_keamananipk){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-lock" style="color:#e74a3b;"></i> Keamanan IPK</h5>';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Status</small>';
                        html += '<h6>' + data.show.b_keamananipk.lunas + '</h6>';
                        html += (data.show.b_keamananipk.kasir) ? '<h6>' + data.show.b_keamananipk.kasir + '</h6>' : '';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_keamananipk.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_keamananipk.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_keamananipk.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="acc_keamananipk">';
                        html += '<div id="col_keamananipk" class="collapse" aria-labelledby="head_keamananipk" data-parent="#acc_keamananipk">';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + data.show.b_keamananipk.tarif_nama + '</h6>';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + Number(data.show.b_keamananipk.price).toLocaleString('id-ID') + ' per-Los</h6>';
                        html += '<small class="text-muted pt-4 db">Jumlah Los</small>';
                        html += '<h6>' + Number(data.show.b_keamananipk.jml_los).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Subtotal</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_keamananipk.sub_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">- Diskon</small>';
                        html += (data.show.b_keamananipk.diskon) ? '<h6>Rp. ' + Number(data.show.b_keamananipk.diskon).toLocaleString('id-ID') + '</h6>' : '<h6>0</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">= Keamanan</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_keamananipk.keamanan).toLocaleString('id-ID') + ' (' + data.show.b_keamananipk.keamanan_persen + '%)</h6>';
                        html += '<small class="text-muted pt-4 db">= IPK</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_keamananipk.ipk).toLocaleString('id-ID') + ' (' + data.show.b_keamananipk.ipk_persen + '%)</h6>';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_keamananipk.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_keamananipk.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_keamananipk.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        if(data.show.b_keamananipk.restored_by_name){
                            html += '<div class="form-group text-center">';
                            html += '<p>Dipulihkan : ' + data.show.b_keamananipk.restored_by_name + '</p>';
                            html += '<p>' + data.show.b_keamananipk.restored_time + '</p>';
                            html += '</div>';
                        }
                        html += '</div>';
                        html += '<div id="head_keamananipk" class="text-center">';
                        html += '<h5>';
                        html += '<button class="btn btn-link collapsed text-info klik" data-toggle="collapse" data-target="#col_keamananipk" aria-expanded="false" aria-controls="col_keamananipk">';
                        html += 'Klik, untuk selengkapnya';
                        html += '</button>';
                        html += '</h5>';
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.b_kebersihan){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-leaf" style="color:#1cc88a;"></i> Kebersihan</h5>';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Status</small>';
                        html += '<h6>' + data.show.b_kebersihan.lunas + '</h6>';
                        html += (data.show.b_kebersihan.kasir) ? '<h6>' + data.show.b_kebersihan.kasir + '</h6>' : '';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_kebersihan.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_kebersihan.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_kebersihan.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="acc_kebersihan">';
                        html += '<div id="col_kebersihan" class="collapse" aria-labelledby="head_kebersihan" data-parent="#acc_kebersihan">';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + data.show.b_kebersihan.tarif_nama + '</h6>';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + Number(data.show.b_kebersihan.price).toLocaleString('id-ID') + ' per-Los</h6>';
                        html += '<small class="text-muted pt-4 db">Jumlah Los</small>';
                        html += '<h6>' + Number(data.show.b_kebersihan.jml_los).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">+ Subtotal</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_kebersihan.sub_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">- Diskon</small>';
                        html += (data.show.b_kebersihan.diskon) ? '<h6>Rp. ' + Number(data.show.b_kebersihan.diskon).toLocaleString('id-ID') + '</h6>' : '<h6>0</h6>';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_kebersihan.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_kebersihan.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_kebersihan.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        if(data.show.b_kebersihan.restored_by_name){
                            html += '<div class="form-group text-center">';
                            html += '<p>Dipulihkan : ' + data.show.b_kebersihan.restored_by_name + '</p>';
                            html += '<p>' + data.show.b_kebersihan.restored_time + '</p>';
                            html += '</div>';
                        }
                        html += '</div>';
                        html += '<div id="head_kebersihan" class="text-center">';
                        html += '<h5>';
                        html += '<button class="btn btn-link collapsed text-info klik" data-toggle="collapse" data-target="#col_kebersihan" aria-expanded="false" aria-controls="col_kebersihan">';
                        html += 'Klik, untuk selengkapnya';
                        html += '</button>';
                        html += '</h5>';
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.b_airkotor){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fad fa-burn" style="color:#000000;"></i> Air Kotor</h5>';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Status</small>';
                        html += '<h6>' + data.show.b_airkotor.lunas + '</h6>';
                        html += (data.show.b_airkotor.kasir) ? '<h6>' + data.show.b_airkotor.kasir + '</h6>' : '';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_airkotor.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_airkotor.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_airkotor.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="acc_airkotor">';
                        html += '<div id="col_airkotor" class="collapse" aria-labelledby="head_airkotor" data-parent="#acc_airkotor">';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + data.show.b_airkotor.tarif_nama + '</h6>';
                        html += '<small class="text-muted pt-4 db">Tarif</small>';
                        html += '<h6>' + Number(data.show.b_airkotor.price).toLocaleString('id-ID') + ' per-Kontrol</h6>';
                        html += '<small class="text-muted pt-4 db">+ Subtotal</small>';
                        html += '<h6>Rp. ' + Number(data.show.b_airkotor.sub_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">- Diskon</small>';
                        html += (data.show.b_airkotor.diskon) ? '<h6>Rp. ' + Number(data.show.b_airkotor.diskon).toLocaleString('id-ID') + '</h6>' : '<h6>0</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.b_airkotor.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.b_airkotor.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.b_airkotor.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        if(data.show.b_airkotor.restored_by_name){
                            html += '<div class="form-group text-center">';
                            html += '<p>Dipulihkan : ' + data.show.b_airkotor.restored_by_name + '</p>';
                            html += '<p>' + data.show.b_airkotor.restored_time + '</p>';
                            html += '</div>';
                        }
                        html += '</div>';
                        html += '<div id="head_airkotor" class="text-center">';
                        html += '<h5>';
                        html += '<button class="btn btn-link collapsed text-info klik" data-toggle="collapse" data-target="#col_airkotor" aria-expanded="false" aria-controls="col_airkotor">';
                        html += 'Klik, untuk selengkapnya';
                        html += '</button>';
                        html += '</h5>';
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.b_lain){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-chart-pie" style="color:#c5793a;"></i> Lainnya</h5>';
                        html += '<div class="row">';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Status</small>';
                        html += '<h6>' + data.show.lunas_lain + '</h6>';
                        html += '<small class="text-muted pt-4 db">Total</small>';
                        html += '<h6 class="text-info">Rp. ' + Number(data.show.total_lain).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '<div class="col-lg-6 col-xlg-6">';
                        html += '<small class="text-muted pt-4 db">Realisasi</small>';
                        html += '<h6 class="text-success">Rp. ' + Number(data.show.realisasi_lain).toLocaleString('id-ID') + '</h6>';
                        html += '<small class="text-muted pt-4 db">Selisih</small>';
                        html += '<h6 class="text-danger">Rp. ' + Number(data.show.selisih_lain).toLocaleString('id-ID') + '</h6>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div id="acc_lain">';
                        html += '<div id="col_lain" class="collapse" aria-labelledby="head_lain" data-parent="#acc_lain">';

                        $.each(data.show.b_lain, function(i, val){
                            html += '<div class="row">';
                            html += '<div class="col-lg-6 col-xlg-6">';
                            html += '<small class="text-muted pt-4 db">Tarif</small>';
                            html += '<h6>' + val.tarif_nama + '</h6>';
                            html += '<small class="text-muted pt-4 db">Status</small>';
                            html += '<h6>' + val.lunas + '</h6>';
                            html += (val.kasir) ? '<h6>' + val.kasir + '</h6>' : '';
                            html += '<small class="text-muted pt-4 db">Tarif</small>';
                            html += '<h6>' + Number(val.price).toLocaleString('id-ID') + ' ' + val.satuan_nama + '</h6>';
                            html += '<small class="text-muted pt-4 db">Jumlah Los</small>';
                            html += '<h6>' + val.jml_los + '</h6>';
                            html += '</div>';
                            html += '<div class="col-lg-6 col-xlg-6">';
                            html += '<small class="text-muted pt-4 db">+ Subtotal</small>';
                            html += '<h6>Rp. ' + Number(val.sub_tagihan).toLocaleString('id-ID') + '</h6>';
                            html += '<small class="text-muted pt-4 db">Total</small>';
                            html += '<h6 class="text-info">Rp. ' + Number(val.ttl_tagihan).toLocaleString('id-ID') + '</h6>';
                            html += '<small class="text-muted pt-4 db">Realisasi</small>';
                            html += '<h6 class="text-success">Rp. ' + Number(val.rea_tagihan).toLocaleString('id-ID') + '</h6>';
                            html += '<small class="text-muted pt-4 db">Selisih</small>';
                            html += '<h6 class="text-danger">Rp. ' + Number(val.sel_tagihan).toLocaleString('id-ID') + '</h6>';
                            html += '</div>';
                            html += '</div>';
                            html += '<hr>';
                        });

                        html += '</div>';
                        html += '<div id="head_lain" class="text-center">';
                        html += '<h5>';
                        html += '<button class="btn btn-link collapsed text-info info klik" data-toggle="collapse" data-target="#col_lain" aria-expanded="false" aria-controls="col_lain">';
                        html += 'Klik, untuk selengkapnya';
                        html += '</button>';
                        html += '</h5>';
                        html += '</div>';
                        html += '</div>';
                    }

                    if(html){
                        $("#showFasilitas").append(html);
                    }
                    else {
                        html += '<div class="form-group mt-4 text-center">';
                        html += '<img src="/img/sad.png" class="rounded-circle" width="180" />';
                        html += '<h4>Tidak memiliki tagihan apapun</h4>'
                        html += '</div>';
                        $("#showFasilitas").append(html);
                    }
                }

                if(data.error){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error(data.error);
                }

                if(data.warning){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.warning(data.warning);
                }

                if(data.info){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.info(data.info);
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

    $('#showModal').on('shown.bs.modal', function() {
        $('.klik').click(function(){
            var $this = $(this);
            $this.toggleClass('selengkapnya');
            if($this.hasClass('selengkapnya')){
                $this.text('Sembunyikan');
            } else {
                $this.text('Klik, untuk selengkapnya.');
            }
        });
    });

    function ajaxForm(url, type, value, dataset){
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
                    period();
                }

                if(data.error){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error(data.error);
                }

                if(data.warning){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.warning(data.warning);
                }

                if(data.info){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.info(data.info);
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
                        $('#billModal').modal('hide');
                }
                else{
                    $('#confirmModal').modal('hide');
                }
                $.unblockUI();
            }
        });
    }

    function fasListrik(data){
        if(data == 'show'){
            $("#divlistrik").show();
            $("#plistrik").prop("required", true);
            $("#dayalistrik").prop("required", true);
            $("#awlistrik").prop("required", true);
            $("#aklistrik").prop("required", true);
            $("#fas_listrik").prop("checked", true);
        }
        else{
            $("#divlistrik").hide();
            $("#plistrik").prop("required", false);
            $("#dayalistrik").prop("required", false);
            $("#awlistrik").prop("required", false);
            $("#aklistrik").prop("required", false);
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
            $("#pairbersih").prop("required", true);
            $("#awairbersih").prop("required", true);
            $("#akairbersih").prop("required", true);
            $("#fas_airbersih").prop("checked", true);
        }
        else{
            $("#divairbersih").hide();
            $("#pairbersih").prop("required", false);
            $("#awairbersih").prop("required", false);
            $("#akairbersih").prop("required", false);
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

    function select2period(select2id, url, placeholder){
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
                                text: d.nicename
                            }
                        })
                    };
                },
            }
        });
    }

    function select2kontrol(select2id, url, placeholder){
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
                                id: d.kd_kontrol,
                                text: d.kd_kontrol
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

    $('#billModal').on('shown.bs.modal', function() {
        $("#periode").on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini untuk mencari..');
        });
        $("#kontrol").on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini untuk mencari..');
        });
        $('#pengguna').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Cari Nama/KTP disini..');
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
</script>
@endsection
