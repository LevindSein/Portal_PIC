@extends('portal.layout.master')

@section('content-title')
Registrasi Pengguna
@endsection

@section('content-button')
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="registerForm">
                    <input type="hidden" id="userId" name="userId" value="{{($data) ? $data->id : ''}}">
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Pilih Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" id="level" name="level">
                                    <option value="3" selected>Nasabah</option>
                                    @if(Auth::user()->level == 1)
                                    <option value="2">Organisator</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" required autocomplete="off" maxlength="100" placeholder="Alm. H. John Doe, S.pd., MT" class="form-control form-control-line" value="{{($data) ? $data->name : ''}}">
                            </div>
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" maxlength="200" required autocomplete="off" placeholder="something@email.com" class="form-control form-control-line" style="text-transform:lowercase;" value="{{($data) ? $data->email : ''}}">
                            </div>
                            <div class="form-group">
                                <label>Handphone <span class="text-danger">*</span></label>
                                <input type="hidden" id="country" name="country" />
                                <input id="phone" name="phone" type="tel" autocomplete="off" minlength="8" maxlength="15" placeholder="878123xxxxx" class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>KTP <span class="text-danger">*</span></label>
                                <input required type="tel" id="ktp" name="ktp" autocomplete="off" minlength="16" maxlength="16" placeholder="16 digit nomor KTP" class="form-control form-control-line">
                            </div>
                            <div class="form-group">
                                <label>NPWP</label>
                                <input type="tel" id="npwp" name="npwp" autocomplete="off" minlength="15" maxlength="15" placeholder="15 digit nomor NPWP" class="form-control form-control-line">
                            </div>
                            <div class="form-group">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea required rows="5" id="address" name="address" autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control form-control-line"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group" id="authorityDiv">
                        <div class="text-center form-group">
                            <h4>Privileged :</h4>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-xlg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-xlg-6">
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="registrasi"
                                                    value="registrasi">
                                                <label class="form-control-label" for="registrasi">
                                                    Layn.Registrasi
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="pedagang"
                                                    value="pedagang">
                                                <label class="form-control-label" for="pedagang">
                                                    Layn.Pedagang
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="tempatusaha"
                                                    value="tempatusaha">
                                                <label class="form-control-label" for="tempatusaha">
                                                    Layn.Tempat Usaha
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="pembongkaran"
                                                    value="pembongkaran">
                                                <label class="form-control-label" for="pembongkaran">
                                                    Layn.Pembongkaran
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="pemakaian"
                                                    value="pemakaian">
                                                <label class="form-control-label" for="pemakaian">
                                                    Lap.Pemakaian
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="pendapatan"
                                                    value="pendapatan">
                                                <label class="form-control-label" for="pendapatan">
                                                    Lap.Pendapatan
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="tunggakan"
                                                    value="tunggakan">
                                                <label class="form-control-label" for="tunggakan">
                                                    Lap.Tunggakan
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xlg-6">
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="tagihan"
                                                    value="tagihan">
                                                <label class="form-control-label" for="tagihan">
                                                    Kelola Tagihan
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="simulasi"
                                                    value="simulasi">
                                                <label class="form-control-label" for="simulasi">
                                                    Simulasi Tagihan
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="datausaha"
                                                    value="datausaha">
                                                <label class="form-control-label" for="datausaha">
                                                    Data Usaha
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="alatmeter"
                                                    value="alatmeter">
                                                <label class="form-control-label" for="alatmeter">
                                                    Alat Meter
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="tarif"
                                                    value="tarif">
                                                <label class="form-control-label" for="tarif">
                                                    Tarif
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    checked
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="kelola[]"
                                                    id="harilibur"
                                                    value="harilibur">
                                                <label class="form-control-label" for="harilibur">
                                                    Hari Libur
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xlg-6">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label>Otoritas <span class="text-danger">*</span></label>
                                        <a id="chooseGroup" value="chooseAll" type="button" class="text-info" href="javascript:void(0)"></a>
                                    </div>
                                    <select id="authority" name="authority[]" class="select2 form-control form-control-line" style="width: 100%;height: 36px;" multiple></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="tempatusahaDiv">
                        <label>Pilih Tempat Usaha <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tu_0" name="tempatusahaChoose" value="0" checked>
                                <label class="custom-control-label" style="font-weight: 400;" for="tu_0">Tidak menggunakan</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tu_1" name="tempatusahaChoose" value="1">
                                <label class="custom-control-label" style="font-weight: 400;" for="tu_1">Pilih yang tersedia</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tu_2" name="tempatusahaChoose" value="2">
                                <label class="custom-control-label" style="font-weight: 400;" for="tu_2">Buat tempat baru</label>
                            </div>
                        </div>
                    </div>
                    <div id="div_tu_2">
                        <div class="row">
                            <div class="col-lg-6 col-xlg-6">
                                <div class="form-group">
                                    <label>Pilih Status Kepemilikan <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input
                                                checked
                                                class="form-check-input"
                                                type="checkbox"
                                                name="pemilik"
                                                id="pemilik">
                                            <label class="form-control-label" style="font-weight: 400;" for="pemilik">
                                                Pemilik Tempat
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input
                                                checked
                                                class="form-check-input"
                                                type="checkbox"
                                                name="pengguna"
                                                id="pengguna">
                                            <label class="form-control-label" style="font-weight: 400;" for="pengguna">
                                                Pengguna Tempat
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Blok Tempat <span class="text-danger">*</span></label>
                                    <select required id="group" name="group" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Los <span class="text-danger">*</span></label>
                                    <select required id="los" name="los[]" class="select2 form-control form-control-line" style="width: 100%;" multiple></select>
                                </div>
                                <div class="form-group">
                                    <label>Kode Kontrol <span class="text-danger">*</span></label>
                                    <input required type="text" id="kontrol" name="kontrol" autocomplete="off" maxlength="20" placeholder="Sesuaikan Blok & No.Los" class="form-control form-control-line" style="text-transform: uppercase">
                                </div>
                            </div>
                            <div class="col-lg-6 col-xlg-6">
                                <div class="form-group">
                                    <label>Kategori Komoditi</label>
                                    <select id="commodity" name="commodity[]" class="select2 form-control form-control-line" style="width: 100%; height:36px;" multiple></select>
                                </div>
                                <div class="form-group">
                                    <label>Status Tempat <span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="stt_aktif" name="status" value="1" checked>
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
                                    <label>Keterangan Status Tempat <span id="ketLabel" class="text-danger">*</span></label>
                                    <textarea rows="3" id="ket" name="ket" autocomplete="off" placeholder="Ketikkan Keterangan disini" maxlength="255" class="form-control form-control-line"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Info Tambahan</label>
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
                                            <label>Pilih Alat Meter <span class="text-danger">*</span></label>
                                            <select id="tlistrik" name="tlistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pilih Tarif <span class="text-danger">*</span></label>
                                            <select id="plistrik" name="plistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Diskon</label>
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
                                            <label>Pilih Alat Meter <span class="text-danger">*</span></label>
                                            <select id="tairbersih" name="tairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pilih Tarif <span class="text-danger">*</span></label>
                                            <select id="pairbersih" name="pairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Diskon</label>
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
                                            <label>Pilih Tarif <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select id="pkeamananipk" name="pkeamananipk" class="select2 form-control form-control-line" style="width: 100%"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Diskon</label>
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
                                            <label>Pilih Tarif <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select id="pkebersihan" name="pkebersihan" class="select2 form-control form-control-line" style="width: 100%"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Diskon</label>
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
                                            <label>Pilih Tarif <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select id="pairkotor" name="pairkotor" class="select2 form-control form-control-line" style="width: 100%"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Diskon</label>
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
                            </div>
                            <div class="col-lg-6 col-xlg-6">
                                {{-- Lainnya --}}
                                <div>
                                    <div id="divlainNew"></div>

                                    <div class="form-group">
                                        <button id="divLainAdd" class="btn btn-sm btn-rounded btn-info"><i class="fas fa-fw fa-plus mr-1"></i>Fasilitas Lainnya</button>
                                        <sup>
                                            <a href='{{url("production/prices/lain")}}' target="_blank">
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
                    </div>
                    <div class="form-group">
                        <p>(<label class="text-danger">*</label>) wajib diisi.</p>
                    </div>x
                    <div class="form-group text-center">
                        <input type="hidden" id="registerFormValue" value="{{($data) ? 'update' : 'add'}}"/>
                        <button type="submit" id="save_btn" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-modal')
@endsection

@section('content-js')
<script>
    var iti;
    var lain = 0;
    var plain = 1;

    function initializeTel(init) {
        iti = window.intlTelInput(document.querySelector("#phone"), {
            initialCountry: init,
            preferredCountries: ['id'],
            formatOnDisplay: false,
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });
    }
    initializeTel("id");

    init();
    level();

    function init(){
        $("#div_tu_2").hide();
        $("#tempatusahaDiv").show();

        $("#authorityDiv").hide();
        $("#authority").val("").html("").trigger("change").prop("required",false);
        $("#chooseGroup")
            .html('<i class="fas fa-sm fa-hand-pointer"></i> Pilih Semua Blok')
            .val("chooseAll")
            .removeClass("text-danger")
            .addClass("text-info");

        iti.destroy();
        initializeTel("id");

        $("#group").val("").html("");
        select2custom("#group", "/search/groups", "-- Cari Blok Tempat --");

        $("#los").val("").html("");
        $("#los").select2({
            placeholder: "(Pilih Blok Tempat terlebih dulu)"
        }).prop("disabled", true);

        $("#kontrol").prop("disabled", true).val("").html("");

        $("#commodity").val("").html("");
        select2idname("#commodity", "/search/commodities", "-- Cari Kategori Komoditi --");

        $("#stt_aktif").prop("checked", true);
        statusTempat();

        $("#tlistrik").val("").html("");
        select2tlistrik("#tlistrik", "/search/tools/listrik", "-- Cari Alat Listrik --");
        $("#plistrik").val("").html("");
        select2idname("#plistrik", "/search/price/listrik", "-- Cari Tarif Listrik --");
        $("#dlistrik").val("").html("");
        fasListrik("hide");

        $("#tairbersih").val("").html("");
        select2tairbersih("#tairbersih", "/search/tools/airbersih", "-- Cari Alat Air Bersih --");
        $("#pairbersih").val("").html("");
        select2idname("#pairbersih", "/search/price/airbersih", "-- Cari Tarif Air Bersih --");
        $("#dairbersih").val("").html("");
        fasAirBersih("hide");

        $("#pkeamananipk").val("").html("");
        select2idprice("#pkeamananipk", "/search/price/keamananipk", "-- Cari Tarif Keamanan IPK --", "per-Los");
        $("#dkeamananipk").val("").html("");
        fasKeamananIpk("hide");

        $("#pkebersihan").val("").html("");
        select2idprice("#pkebersihan", "/search/price/kebersihan", "-- Cari Tarif Kebersihan --", "per-Los");
        $("#dkebersihan").val("").html("");
        fasKebersihan("hide");

        $("#pairkotor").val("").html("");
        select2idprice("#pairkotor", "/search/price/airkotor", "-- Cari Tarif Air Kotor --", "per-Kontrol");
        $("#dairkotor").val("").html("");
        fasAirKotor("hide");

        lain = 0;
        plain = 1;
        $('div[name="divlain"]').remove();
    }

    function tempatUsaha() {
        init();
        if ($('#tu_2').is(':checked')) {
            $("#div_tu_2").show();
        }
    }
    $('input[name="tempatusahaChoose"]').click(tempatUsaha).each(tempatUsaha);

    $("#level").on('change', function(){
        level();
        $('input[name="tempatusahaChoose"]').prop('checked', false);
        $("#tu_0").prop("checked", true);
    });

    function level() {
        init();
        if ($('#level').val() != 3) {
            $("#tempatusahaDiv").hide();

            if($('#level').val() == 2) {
                $("#authorityDiv").show();
                select2custom("#authority", "/search/groups", "-- Cari Blok Tempat --");
            }
        }
    }

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

    $('#registerForm').submit(function(e){
        e.preventDefault();
        var country = iti.getSelectedCountryData();
        $("#country").val(country.iso2);

        value = $("#registerFormValue").val();
        if(value == 'add'){
            url = "/production/service/register";
            type = "POST";
        }
        else if(value == 'update'){
            url = "/production/service/register/" + $("#userId").val();
            type = "PUT";
        }
        dataset = $(this).serialize();
        ajaxForm(url, type, value, dataset);
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
                    toastr.success(data.success);
                }

                if(data.error){
                    toastr.error(data.error);
                }

                if(data.warning){
                    toastr.warning(data.warning);
                }

                if(data.info){
                    toastr.info(data.info);
                }

                if(data.description){
                    console.log(data.description);
                }
            },
            error:function(data){
                if (data.status == 422) {
                    $.each(data.responseJSON.errors, function (i, error) {
                        toastr.error(error[0]);
                    });
                }
                else{
                    toastr.error("System error.");
                }
                console.log(data);
            },
            complete:function(data){
                if(JSON.parse(data.responseText).success)
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                $.unblockUI();
            }
        });
    }

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
            toastr.error("Telah mencapai maksimal.");
        }
    });
    $(document).on('click', '#divlainRemove', function () {
        lain--;
        $(this).closest("[name='divlain']").remove();
    });

    //Nomor Los
    $('#group').on("change", function(e) {
        var group = $('#group').val();
        $("#los").prop("disabled", false);
        $("#los").val("").html("");
        select2custom("#los", "/search/" + group + "/los", "-- Cari Nomor Los --");
    });

    //Kode Kontrol
    $('#los').on('change', function(e) {
        if($("#los").val() == ""){
            $("#kontrol").prop("disabled", true).val("").html("");
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
                    toastr.error("System error.");
                    console.log(data);
                }
            });
        }
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

    $("#chooseGroup").click(function(){
        if($("#chooseGroup").val() == 'chooseAll'){
            $("#chooseGroup")
                .html('<i class="fas fa-sm fa-eraser"></i> Hapus Semua Blok')
                .val("deleteAll")
                .addClass("text-danger")
                .removeClass("text-info");
            $.ajax({
                url: "/production/users/choose/group/all",
                type: "GET",
                cache:false,
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
                    $("#authority").val(null).html("").trigger("change");
                },
                success:function(data){
                    if(data.success){
                        var group = data.success;
                        $.each( group, function( i, val ) {
                            var option = $('<option></option>').attr('value', val.name).text(val.name).prop('selected', true);
                            $('#authority').append(option).trigger('change');
                        });
                    }
                },
                error:function(data){
                    console.log(data);
                },
                complete:function(data){
                    $.unblockUI();
                }
            });
        }
        else{
            $("#chooseGroup")
                .html('<i class="fas fa-sm fa-hand-pointer"></i> Pilih Semua Blok')
                .val("chooseAll")
                .removeClass("text-danger")
                .addClass("text-info");
            $("#authority").val(null).html("").trigger("change");
        }
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

    $("#kontrol").on("input", function(){
        this.value = this.value.replace(/[^0-9a-zA-Z/\-]+$/g, '');
    });
</script>
@endsection
