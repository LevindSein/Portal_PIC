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
                                    <option value="2">Organisator</option>
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
                    <div class="form-group" id="tempatusaha">
                        <label>Pilih Tempat Usaha <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tu_0" name="tempatusaha" value="0" checked>
                                <label class="custom-control-label" style="font-weight: 400;" for="tu_0">Tidak menggunakan</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tu_1" name="tempatusaha" value="1">
                                <label class="custom-control-label" style="font-weight: 400;" for="tu_1">Pilih yang tersedia</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="tu_2" name="tempatusaha" value="2">
                                <label class="custom-control-label" style="font-weight: 400;" for="tu_2">Buat tempat baru</label>
                            </div>
                        </div>
                    </div>
                    {{-- <div id="div_tu_2">
                        <div class="row">
                            <div class="col-lg-6 col-xlg-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input
                                            checked
                                            class="form-check-input"
                                            type="checkbox"
                                            name="pemilik"
                                            id="pemilik">
                                        <label class="form-control-label" for="pemilik">
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
                                        <label class="form-control-label" for="pengguna">
                                            Pengguna Tempat
                                        </label>
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
                    </div> --}}
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
        $("#tempatusaha").show();

        iti.destroy();
        initializeTel("id");
    }

    function tempatUsaha() {
        init();
        if ($('#tu_2').is(':checked')) {
            $("#div_tu_2").show();
        }
    }
    $('input[name="tempatusaha"]').click(tempatUsaha).each(tempatUsaha);

    $("#level").on('change', function(){
        level();
    });
    function level() {
        init();
        if ($('#level').val() != 3) {
            $("#tempatusaha").hide();
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
                $.unblockUI();
            }
        });
    }
</script>
@endsection
