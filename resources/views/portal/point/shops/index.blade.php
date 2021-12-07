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
                <p id="showtempat" class="text-danger">*) <b>Menambah</b>, <b>Mengedit</b>, atau <b>Menghapus</b> Data Tempat Usaha tidak akan mempengaruhi <b>Data Tagihan</b> yang sedang berlangsung. <sup><a href="javascript:void(0)" type="button" id="showagain"><i class="fas fa-times"></i> Jangan tampilkan lagi.</a></sup></p>
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
<div id="shopsModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="shopsForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Blok Tempat <span class="text-danger">*</span></label>
                                <select required id="group" name="group" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Nomor Los <span class="text-danger">*</span></label>
                                <select required id="los" name="los[]" class="select2 form-control form-control-line" style="width: 100%; height:36px;" multiple></select>
                            </div>
                            <div class="form-group">
                                <label>Kode Kontrol <span class="text-danger">*</span></label>
                                <input required type="text" id="kontrol" name="kontrol" autocomplete="off" maxlength="20" placeholder="Sesuaikan Blok & No.Los" class="form-control form-control-line" style="text-transform: uppercase">
                            </div>
                            <div class="form-group">
                                <label>Pengguna Tempat <span class="text-danger">*</span></label>
                                <select required id="pengguna" name="pengguna" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Pemilik Tempat <span class="text-danger">*</span></label>
                                <select required id="pemilik" name="pemilik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
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
                                            <label class="custom-control-label" for="stt_aktif">Aktif</label>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="stt_bebas" name="status" value="2">
                                            <label class="custom-control-label" for="stt_bebas">Bebas Bayar</label>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="stt_nonaktif" name="status" value="3">
                                            <label class="custom-control-label" for="stt_nonaktif">Nonaktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan Status Tempat <span id="ketLabel" class="text-danger">*</span></label>
                                <textarea rows="3" id="ket" name="ket" autocomplete="off" placeholder="Ketikkan Keterangan disini" maxlength="255" class="form-control form-control-line"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Info Lokasi</label>
                                <textarea rows="3" id="location" name="location" autocomplete="off" placeholder="Ketikkan info tambahan disini" maxlength="255" class="form-control form-control-line"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center form-group">
                        <h4>FASILITAS TEMPAT :</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Listrik <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control form-control-line">
                            </div>
                            <div class="form-group">
                                <label>Air Bersih <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control form-control-line">
                            </div>
                            <div class="form-group">
                                <label>Air Kotor <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Keamanan IPK <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control form-control-line">
                            </div>
                            <div class="form-group">
                                <label>Kebersihan <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control form-control-line">
                            </div>
                            <div class="form-group">
                                <label>Lainnya <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" class="form-control form-control-line">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>(<span class="text-danger">*</span>) wajib diisi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="shopsFormValue"/>
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
        $("#kontrol").on("input", function(){
            this.value = this.value.replace(/[^0-9a-zA-Z/\-]+$/g, '');
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

        var id;

        var dtable = $('#dtable').DataTable({
            "language": {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
            "serverSide": true,
            "ajax": "/production/point/shops",
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
                { "bSearchable": false, "aTargets": [3,4] }
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
                }, 10)
            },
        });

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

        function initForm(){
            $("#group").val("");
            select2custom("#group", "/search/groups", "-- Cari Blok Tempat --");

            $("#los").select2({
                placeholder: "(Pilih Blok Tempat terlebih dulu)"
            }).val("").prop("disabled", true);

            $("#kontrol").prop("disabled", true);

            $("#pengguna").val("");
            select2user("#pengguna", "/search/users", "-- Cari Pengguna Tempat --");

            $("#pemilik").val("");
            select2user("#pemilik", "/search/users", "-- Cari Pemilik Tempat --");

            $("#commodity").val("");
            select2commodity("#commodity", "/search/commodities", "-- Cari Kategori Komoditi --");

            statusTempat();
        }

        function statusTempat() {
            if ($('#stt_aktif').is(':checked')) {
                $("#ketLabel").addClass("hide");
                $("#ket").prop("required", false);
            }
            else if ($('#stt_bebas').is(':checked')) {
                $("#ketLabel").addClass("hide");
                $("#ket").prop("required", false);
            }
            else {
                $("#ketLabel").removeClass("hide");
                $("#ket").prop("required", true);
            }
        }
        $('input[type="radio"]').click(statusTempat).each(statusTempat);

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
                    url: "/production/point/shops/generate/kontrol",
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

        $(".add").click( function(){
            $("#shopsForm")[0].reset();
            $('.titles').text('Tambah data Tempat Usaha');
            $("#shopsFormValue").val('add');

            initForm();

            $('#shopsModal').modal('show');
        });

        $('#shopsForm').submit(function(e){
            e.preventDefault();
            value = $("#shopsFormValue").val();
            if(value == 'add'){
                url = "/production/point/shops";
                type = "POST";
            }
            else if(value == 'update'){
                url = "/production/point/shops/" + id;
                type = "PUT";
            }
            dataset = $(this).serialize();
            ok_btn_before = "Menyimpan...";
            ok_btn_completed = "Simpan";
            ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
        });

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
                        message: '<i class="fas fa-spin fa-sync text-white"></i>',
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
                            $('#shopsModal').modal('hide');
                    }
                    else{
                        $('#confirmModal').modal('hide');
                    }
                    $.unblockUI();
                }
            });
        }

        function select2custom(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                dropdownParent: $('#shopsModal'),
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
                dropdownParent: $('#shopsModal'),
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

        function select2commodity(select2id, url, placeholder){
            $(select2id).select2({
                placeholder: placeholder,
                dropdownParent: $('#shopsModal'),
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
    });
</script>
@endsection
