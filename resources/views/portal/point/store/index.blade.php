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
                <div><div class='color color-success'></div>&nbsp;Aktif</div>
                <div><div class='color color-info'></div>&nbsp;Bebas Bayar</div>
                <div><div class='color color-danger'></div>&nbsp;Nonaktif</div><br>
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
<div id="storeModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="storeForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Blok Tempat <span class="text-danger">*</span> <sup><a href="{{url('production/point/groups')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                <select required id="group" name="group" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Nomor Los <span class="text-danger">*</span> <sup><a href="{{url('production/point/groups')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                <select required id="los" name="los[]" class="select2 form-control form-control-line" style="width: 100%;" multiple></select>
                            </div>
                            <div class="form-group">
                                <label>Kode Kontrol <span class="text-danger">*</span></label>
                                <input required type="text" id="kontrol" name="kontrol" autocomplete="off" maxlength="20" placeholder="Sesuaikan Blok & No.Los" class="form-control form-control-line" style="text-transform: uppercase">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label>Pengguna Tempat <sup><a href="{{url('production/users')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                    <a id="cancelPengguna" type="button" class="text-danger" href="javascript:void(0)"><sup><i class="fas fa-sm fa-times"></i></sup> Hapus</a>
                                </div>
                                <select id="pengguna" name="pengguna" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label>Pemilik Tempat <sup><a href="{{url('production/users')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                    <a id="cancelPemilik" type="button" class="text-danger" href="javascript:void(0)"><sup><i class="fas fa-sm fa-times"></i></sup> Hapus</a>
                                </div>
                                <select id="pemilik" name="pemilik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Kategori Komoditi <sup><a href="{{url('production/point/commodities')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                <select id="commodity" name="commodity[]" class="select2 form-control form-control-line" style="width: 100%; height:36px;" multiple></select>
                            </div>
                            <div class="form-group">
                                <label>Status Tempat <span class="text-danger">*</span></label>
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
                                            <input type="radio" class="custom-control-input" id="stt_nonaktif" name="status" value="3">
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
                                <textarea rows="3" id="location" name="location" autocomplete="off" placeholder="Ketikkan info tambahan disini" maxlength="255" class="form-control form-control-line"></textarea>
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
                                        <label>Pilih Alat Meter <span class="text-danger">*</span> <sup><a href="{{url('production/point/tools/listrik')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <select id="tlistrik" name="tlistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span> <sup><a href="{{url('production/manage/prices/listrik')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <select id="plistrik" name="plistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon</label>
                                        <div class="input-group">
                                            <input maxlength="3" type="text" id="dlistrik" name="dlistrik" autocomplete="off" placeholder="Ketikkan dalam angka 0-100" class="number percent form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">%</span>
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
                                        <label>Pilih Alat Meter <span class="text-danger">*</span> <sup><a href="{{url('production/point/tools/airbersih')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <select id="tairbersih" name="tairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span> <sup><a href="{{url('production/manage/prices/airbersih')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <select id="pairbersih" name="pairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon</label>
                                        <div class="input-group">
                                            <input maxlength="3" type="text" id="dairbersih" name="dairbersih" autocomplete="off" placeholder="Ketikkan dalam angka 0-100" class="number percent form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            {{-- End Air Bersih --}}
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
                                        <label>Pilih Tarif <span class="text-danger">*</span> <sup><a href="{{url('production/manage/prices/airkotor')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <select id="pairkotor" name="pairkotor" class="select2 form-control form-control-line"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon</label>
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
                                        <label>Pilih Tarif <span class="text-danger">*</span> <sup><a href="{{url('production/manage/prices/keamananipk')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <select id="pkeamananipk" name="pkeamananipk" class="select2 form-control form-control-line"></select>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">/ Los</span>
                                            </div>
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
                                                <span class="input-group-text">/ Los</span>
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
                                        <label>Pilih Tarif <span class="text-danger">*</span> <sup><a href="{{url('production/manage/prices/kebersihan')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <select id="pkebersihan" name="pkebersihan" class="select2 form-control form-control-line"></select>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">/ Los</span>
                                            </div>
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
                                                <span class="input-group-text">/ Los</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            {{-- End Kebersihan --}}
                            {{-- Lainnya --}}
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_lain" name="fas_lain">
                                        <label class="custom-control-label" for="fas_lain">Lainnya</label>
                                    </div>
                                </div>
                                <div id="divlain" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span> <sup><a href="{{url('production/manage/prices/lain')}}" target="_blank"><i class="far fa-question-circle" style="color:#5b5b5b;"></i></a></sup></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <select id="plain" name="plain" class="select2 form-control form-control-line"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input maxlength="11" type="text" id="dlain" name="dlain" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <hr>
                                    </div>
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
        $('#storeModal').on('shown.bs.modal', function() {
            $('#pengguna, #pemilik').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik Nama/KTP/Paspor disini..');
            });
            $('#tlistrik').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik Kode/Meter/Daya/ID disini..');
            });
            $('#tairbersih').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik Kode/Meter/ID disini..');
            });
            $('#plistrik, #pairbersih').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik Nama Tarif disini..');
            });
            $('#pkeamananipk, #pkebersihan, #pairkotor, #plain').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik Tarif/Nama Tarif disini..');
            });
        });

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

        var id;

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
                { "bSearchable": false, "aTargets": [3,4] }
            ],
            "scrollY": "35vh",
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

        function initForm(){
            $("#group").val("");
            select2custom("#group", "/search/groups", "-- Cari Blok Tempat --");

            $("#los").select2({
                placeholder: "(Pilih Blok Tempat terlebih dulu)"
            }).val("").prop("disabled", true);

            $("#kontrol").prop("disabled", true);

            $("#cancelPengguna").hide();
            $("#pengguna").val("");
            select2user("#pengguna", "/search/users", "-- Cari Pengguna Tempat --");

            $("#cancelPemilik").hide();
            $("#pemilik").val("");
            select2user("#pemilik", "/search/users", "-- Cari Pemilik Tempat --");

            $("#commodity").val("");
            select2idname("#commodity", "/search/commodities", "-- Cari Kategori Komoditi --");

            $("#stt_nonaktif").prop("checked", true);
            statusTempat();

            $("#tlistrik").val("");
            select2tlistrik("#tlistrik", "/search/tools/listrik", "-- Cari Alat Listrik --");
            $("#plistrik").val("");
            select2idname("#plistrik", "/search/price/listrik", "-- Cari Tarif Listrik --");
            fasListrik("hide");

            $("#tairbersih").val("");
            select2tairbersih("#tairbersih", "/search/tools/airbersih", "-- Cari Alat Air Bersih --");
            $("#pairbersih").val("");
            select2idname("#pairbersih", "/search/price/airbersih", "-- Cari Tarif Air Bersih --");
            fasAirBersih("hide");

            $("#pkeamananipk").val("");
            select2idprice("#pkeamananipk", "/search/price/keamananipk", "-- Cari Tarif Keamanan IPK --");
            fasKeamananIpk("hide");

            $("#pkebersihan").val("");
            select2idprice("#pkebersihan", "/search/price/kebersihan", "-- Cari Tarif Kebersihan --");
            fasKebersihan("hide");

            $("#pairkotor").val("");
            select2idprice("#pairkotor", "/search/price/airkotor", "-- Cari Tarif Air Kotor --");
            fasAirKotor("hide");

            $("#plain").val("");
            select2idprice("#plain", "/search/price/lain", "-- Cari Tarif Lainnya --");
            fasLain("hide");
        }

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

        function fasLain(data){
            if(data == 'show'){
                $("#divlain").show();
                $("#plain").prop("required", true);
                $("#fas_lain").prop("checked", true);
            }
            else{
                $("#divlain").hide();
                $("#plain").prop("required", false);
                $("#fas_lain").prop("checked", false);
            }
        }

        function checkFasLain(){
            if($("#fas_lain").is(":checked")){
                fasLain("show");
            }
            else{
                fasLain("hide");
            }
        }
        $('#fas_lain').click(checkFasLain).each(checkFasLain);

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
        $('input[name="status"]').click(statusTempat).each(statusTempat);

        //Pengguna
        $('#pengguna').on("input", function(e) {
            if($('#pengguna').val()){
                $("#stt_aktif").prop("checked", true);
                $("#cancelPengguna").show();
            }
            else{
                $("#cancelPengguna").hide();
                $("#stt_nonaktif").prop("checked", true);
            }
            statusTempat();
        });

        $("#cancelPengguna").click(function(){
            $("#pengguna").val(null).trigger("change");
            $("#cancelPengguna").hide();
            $("#stt_nonaktif").prop("checked", true);
            statusTempat();
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

        $(".add").click( function(){
            $("#storeForm")[0].reset();
            $('.titles').text('Tambah data Tempat Usaha');
            $("#storeFormValue").val('add');

            initForm();

            $('#storeModal').modal('show');
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
                            $('#storeModal').modal('hide');
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

        function select2idprice(select2id, url, placeholder){
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
                                    text: d.name + ' - ' + Number(d.price).toLocaleString('id-ID')
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
                                    text: d.code + ' - (' + Number(d.meter).toLocaleString('id-ID') + ')' + ' - ID: ' + d.name
                                }
                            })
                        };
                    },
                }
            });
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
    });
</script>
@endsection
