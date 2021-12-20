@extends('portal.layout.master')

@section('content-title')
Kelola Tagihan
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn mr-3">
        <a class="dropdown-item add" href="javascript:void(0)">
            <i class="fas fa-fw fa-plus mr-1 ml-1"></i>
            <span>Tagihan</span>
        </a>
        <div class="dropdown-divider"></div>
        @include('portal.manage.button')
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group col-md-3 col-sm-12" style="padding: 0;">
                    <label for="period">Periode Tagihan</label>
                    <select class="select2 form-control" id="period" name="period"></select>
                </div>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kontrol</th>
                                <th>Nama</th>
                                <th>Fasilitas</th>
                                <th>Tagihan</th>
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
                                <label>Periode Tagihan <span class="text-danger">*</span></label>
                                <select required id="periode" name="periode" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Kode Kontrol <span class="text-danger">*</span></label>
                                <select required id="kontrol" name="kontrol" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div class="form-group">
                                <label>Blok Tempat <span class="text-danger">*</span></label>
                                <input id="group" name="group" class="form-control form-control-line" placeholder="(Sesuai Kode Kontrol yang terisi)"/>
                            </div>
                            <div class="form-group">
                                <label>Nomor Los <span class="text-danger">*</span></label>
                                <select required id="los" name="los[]" class="select2 form-control form-control-line" style="width: 100%;" multiple></select>
                            </div>
                            <div class="form-group">
                                <label>Pengguna Tempat <span class="text-danger">*</span></label>
                                <select id="pengguna" name="pengguna" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                            </div>
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="stt_publish" name="stt_publish" checked>
                                        <label class="custom-control-label" for="stt_publish">Publish Tagihan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            <h4 class="text-center" id="titleTagihan"></h4>
                            <div>
                                <div class="form-group form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="fas_listrik" name="fas_listrik">
                                        <label class="custom-control-label text-warning" for="fas_listrik">Listrik</label>
                                    </div>
                                </div>
                                <div id="divlistrik" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span></label>
                                        <select id="plistrik" name="plistrik" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Daya Listrik <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input maxlength="11" type="text" id="dayalistrik" name="dayalistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Watt</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Awal Meter <span class="text-danger">*</span></label>
                                        <input maxlength="11" type="text" id="awlistrik" name="awlistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group">
                                        <label>Akhir Meter <span class="text-danger">*</span></label>
                                        <input maxlength="11" type="text" id="aklistrik" name="aklistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group form-check form-check-inline">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checklistrik0" name="checklistrik0">
                                            <label class="custom-control-label" for="checklistrik0">Meter kembali ke Nol <span id="labellistrik0" class="text-danger">*</span></label>
                                            <div class="input-group" id="gruplistrik0">
                                                <input maxlength="1" type="text" id="inputlistrik0" name="inputlistrik0" autocomplete="off" placeholder="Digit Alat Meter (1-9)" class="number form-control form-control-line">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Digit</span>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="d-flex justify-content-between">
                                            <label>Denda <span class="text-danger">*</span></label>
                                            <a id="hitlistrik" type="button" class="text-info" href="javascript:void(0)"><i class="fas fa-sm fa-calculator"></i> Hitung</a>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input maxlength="15" type="text" id="denlistrik" name="denlistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
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
                                        <label class="custom-control-label text-info" for="fas_airbersih">Air Bersih</label>
                                    </div>
                                </div>
                                <div id="divairbersih" style="padding-left: 2rem;">
                                    <div class="form-group">
                                        <label>Pilih Tarif <span class="text-danger">*</span></label>
                                        <select id="pairbersih" name="pairbersih" class="select2 form-control form-control-line" style="width: 100%; height:36px;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Awal Meter <span class="text-danger">*</span></label>
                                        <input maxlength="11" type="text" id="awairbersih" name="awairbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group">
                                        <label>Akhir Meter <span class="text-danger">*</span></label>
                                        <input maxlength="11" type="text" id="akairbersih" name="akairbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    </div>
                                    <div class="form-group form-check form-check-inline">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkairbersih0" name="checkairbersih0">
                                            <label class="custom-control-label" for="checkairbersih0">Meter kembali ke Nol <span id="labelairbersih0" class="text-danger">*</span></label>
                                            <div class="input-group" id="grupairbersih0">
                                                <input maxlength="1" type="text" id="inputairbersih0" name="inputairbersih0" autocomplete="off" placeholder="Digit Alat Meter (1-9)" class="number form-control form-control-line">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Digit</span>
                                                </div>
                                            </div>
                                        </div>
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
                                        <label>Denda <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input maxlength="15" type="text" id="denairbersih" name="denairbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
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
                                        <label class="custom-control-label text-danger" for="fas_keamananipk">Keamanan IPK</label>
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
                                        <label class="custom-control-label text-success" for="fas_kebersihan">Kebersihan</label>
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
                                        <label class="custom-control-label text-dark" for="fas_airkotor">Air Kotor</label>
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
                            {{-- Lainnya --}}
                            <div>
                                <div id="divlainNew"></div>

                                <div class="form-group">
                                    <button id="divLainAdd" class="btn btn-sm btn-rounded btn-info"><i class="fas fa-fw fa-plus mr-1"></i>Fasilitas Lainnya</button>
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
            { data: 'kd_kontrol', name: 'nicename', class : 'text-center' },
            { data: 'name', name: 'name', class : 'text-center' },
            { data: 'fasilitas', name: 'fasilitas', class : 'text-center' },
            { data: 'b_tagihan', name: 'b_tagihan', class : 'text-center' },
            { data: 'action', name: 'action', class : 'text-center' },
        ],
        "stateSave": true,
        "deferRender": true,
        "pageLength": 10,
        "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
        "order": [[ 0, "asc" ]],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [2,3,4] },
            { "bSearchable": false, "aTargets": [2,3,4] }
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
    }

    $("#periode, #kontrol").on('change', function(){
        if($("#periode").val() && $("#kontrol").val()){
            $.ajax({
                url: "/search/bill?periode=" + $("#periode").val() + "&kontrol=" + $("#kontrol").val(),
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#group").val(data.show.group);

                        $("#los").prop("disabled", false);
                        $("#los").val("").html("");
                        select2custom("#los", "/search/" + data.show.group + "/los", "-- Cari Nomor Los --");
                        var los = data.show.no_los;
                        $.each( los, function( i, val ) {
                            var option = $('<option></option>').attr('value', val).text(val).prop('selected', true);
                            $('#los').append(option).trigger('change');
                        });

                        $("#pengguna").prop("disabled", false);
                        $("#pengguna").val("").html("");
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

                        lain = 0;
                        plain = 1;
                        $('div[name="divlain"]').remove();

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

                            $("#denlistrik").val(Number(data.show.denlistrik).toLocaleString('id-ID'));

                            $("#hitlistrik").on('click', function(e){
                                e.preventDefault();
                                var checked = 0;
                                if($("#checklistrik0").is(":checked")){
                                    checked = 1;
                                }
                                $.ajax({
                                    url: "/production/manage/bills/refresh"
                                        + '?price=' + data.show.plistrik.id
                                        + '&diff=' + data.show.diff
                                        + '&checked=' + checked
                                        + '&digit=' + $("#inputlistrik0").val()
                                        + '&awal=' + $("#awlistrik").val()
                                        + '&akhir=' + $("#aklistrik").val()
                                        + '&diskon=' + $("#dlistrik").val()
                                        + '&daya=' + $("#dayalistrik").val(),
                                    type: "GET",
                                    cache:false,
                                    success:function(result){
                                        if(result.success){
                                            $("#denlistrik").val(Number(result.success).toLocaleString('id-ID'));
                                        }

                                        if(result.info){
                                            toastr.options = {
                                                "closeButton": true,
                                                "preventDuplicates": true,
                                            };
                                            toastr.info(result.info);
                                        }
                                    },
                                    error:function(result){
                                        toastr.options = {
                                            "closeButton": true,
                                            "preventDuplicates": true,
                                        };
                                        toastr.error("Fetching data failed.");
                                        console.log(result);
                                    }
                                });
                            });
                        }
                        else if(!data.show.id_tlistrik){
                            $("#fas_listrik").attr('disabled', true);
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

                            $("#awairbersih, #inputairbersih0").on('input', function(e){
                                e.preventDefault();
                                var awal = $("#awairbersih").val().replace(/\./g, '');
                                var digit = $("#inputairbersih0").val().replace(/\./g, '');

                                if(digit < awal.length){

                                    toastr.options = {
                                        "closeButton": true,
                                        "preventDuplicates": true,
                                    };
                                    toastr.info("Alat Air Bersih Minimal " + awal.length + " digit.");
                                }
                            });

                            $("#denairbersih").val(Number(data.show.denairbersih).toLocaleString('id-ID'));
                        }
                        else if(!data.show.id_tairbersih){
                            $("#fas_airbersih").attr('disabled', true);
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

                        $("#divLainAdd").attr('disabled', false);
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

    function initForm(){
        $("#periode").val("").html("");
        select2period("#periode", "/search/period", "-- Cari Periode Tagihan --");

        $("#kontrol").val("").html("");
        select2kontrol("#kontrol", "/search/kontrol", "-- Cari Kode Kontrol --");

        $("#group").val("").prop("readonly", true);

        $("#los").prop("disabled", true).val("").html("");
        $("#los").select2({
            placeholder: "(Sesuai Blok Tempat yang terisi)"
        });

        $("#pengguna").prop("disabled", true).val("").html("");
        $("#pengguna").select2({
            placeholder: "(Kode Kontrol harus terisi)"
        });

        fasListrik("hide");
        listrik0("hide");
        $("#fas_listrik").prop("checked", false).attr('disabled', true);
        select2idname("#plistrik", "/search/price/listrik", "-- Cari Tarif Listrik --");
        $("#plistrik").val("").html("");
        select2idname("#plistrik", "/search/price/listrik", "-- Cari Tarif Listrik --");
        $("#dlistrik").val("").html("");

        fasAirBersih("hide");
        airbersih0("hide");
        $("#fas_airbersih").prop("checked", false).attr('disabled', true);
        select2idname("#pairbersih", "/search/price/airbersih", "-- Cari Tarif Air Bersih --");
        $("#pairbersih").val("").html("");
        select2idname("#pairbersih", "/search/price/airbersih", "-- Cari Tarif Air Bersih --");
        $("#dairbersih").val("").html("");

        fasKeamananIpk("hide");
        $("#fas_keamananipk").prop("checked", false).attr('disabled', true);
        select2idprice("#pkeamananipk", "/search/price/keamananipk", "-- Cari Tarif Keamanan IPK --", "per-Los");
        $("#dkeamananipk").val("").html("");

        fasKebersihan("hide");
        $("#fas_kebersihan").prop("checked", false).attr('disabled', true);
        select2idprice("#pkebersihan", "/search/price/kebersihan", "-- Cari Tarif Kebersihan --", "per-Los");
        $("#dkebersihan").val("").html("");

        fasAirKotor("hide");
        $("#fas_airkotor").prop("checked", false).attr('disabled', true);
        select2idprice("#pairkotor", "/search/price/airkotor", "-- Cari Tarif Air Kotor --", "per-Kontrol");
        $("#dairkotor").val("").html("");

        lain = 0;
        plain = 1;
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
        ok_btn_before = "Menyimpan...";
        ok_btn_completed = "Simpan";
        ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
    });

    $(document).on('click', '.publish', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Publish ' + nama + ' ?');
        $('.bodies').text('Pilih "Publish" di bawah ini jika anda yakin untuk publish tagihan.');
        $('#ok_button').removeClass().addClass('btn btn-success').text('Publish');
        $('#confirmValue').val('publish');
        $('#confirmModal').modal('show');
    });

    $(document).on('click', '.unpublish', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Unpublish ' + nama + ' ?');
        $('.bodies').text('Pilih "Unpublish" di bawah ini jika anda yakin untuk unpublish tagihan.');
        $('#ok_button').removeClass().addClass('btn btn-danger').text('Unpublish');
        $('#confirmValue').val('unpublish');
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
            ok_btn_before = "Publishing...";
            ok_btn_completed = "Publish";
        }
        else if(value == 'unpublish'){
            url = "/production/manage/bills/publish/" + id;
            type = "POST";
            ok_btn_before = "Unpublishing...";
            ok_btn_completed = "Unpublish";
        }

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
            $("#denlistrik").prop("required", true);
            $("#fas_listrik").prop("checked", true);
        }
        else{
            $("#divlistrik").hide();
            $("#plistrik").prop("required", false);
            $("#dayalistrik").prop("required", false);
            $("#awlistrik").prop("required", false);
            $("#aklistrik").prop("required", false);
            $("#denlistrik").prop("required", false);
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

    function listrik0(data){
        if(data == 'show'){
            $("#gruplistrik0").show();
            $("#labellistrik0").show();
            $("#inputlistrik0").val('');
            $("#inputlistrik0").prop("required", true);
        }
        else{
            $("#gruplistrik0").hide();
            $("#labellistrik0").hide();
            $("#inputlistrik0").val('');
            $("#inputlistrik0").prop("required", false);
        }
    }

    function checkListrik0(){
        if($("#checklistrik0").is(":checked")){
            listrik0("show");
        }
        else{
            listrik0("hide");
        }
    }
    $('#checklistrik0').click(checkListrik0).each(checkListrik0);

    function fasAirBersih(data){
        if(data == 'show'){
            $("#divairbersih").show();
            $("#pairbersih").prop("required", true);
            $("#awairbersih").prop("required", true);
            $("#akairbersih").prop("required", true);
            $("#denairbersih").prop("required", true);
            $("#fas_airbersih").prop("checked", true);
        }
        else{
            $("#divairbersih").hide();
            $("#pairbersih").prop("required", false);
            $("#awairbersih").prop("required", false);
            $("#akairbersih").prop("required", false);
            $("#denairbersih").prop("required", false);
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

    function airbersih0(data){
        if(data == 'show'){
            $("#grupairbersih0").show();
            $("#labelairbersih0").show();
            $("#inputairbersih0").val('');
            $("#inputairbersih0").prop("required", true);
        }
        else{
            $("#grupairbersih0").hide();
            $("#labelairbersih0").hide();
            $("#inputairbersih0").val('');
            $("#inputairbersih0").prop("required", false);
        }
    }

    function checkAirBersih0(){
        if($("#checkairbersih0").is(":checked")){
            airbersih0("show");
        }
        else{
            airbersih0("hide");
        }
    }
    $('#checkairbersih0').click(checkAirBersih0).each(checkAirBersih0);

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
