@extends('portal.layout.master')

@section('content-title')
Bayar Tagihan
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn mr-3">
        {{--  --}}
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kontrol</th>
                                <th>Pengguna</th>
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
<div id="bayarModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered dialog-modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="bayarForm">
                <div class="modal-body-xl">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" readonly checked>
                            <label class="custom-control-label font-weight-normal">= Diaktifkan apabila Bayar</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" readonly>
                            <label class="custom-control-label font-weight-normal">= Nonaktifkan apabila Tidak Bayar</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-normal"><sup><i class="fas fa-mouse-pointer text-dark"></i></sup> Klik pada angka tagihan untuk melihat detail.</label>
                    </div>
                    <hr>
                    <input type="hidden" id="paymentId" name="paymentId">
                    <div class="form-group">
                        <input readonly type="text" class="form-control form-control-line" id="kontrol" name="kontrol">
                    </div>
                    <div class="form-group">
                        <input readonly type="text" class="form-control form-control-line" id="pengguna" name="pengguna">
                    </div>
                    <div id="bayar_summary"></div>
                </div>
                <div class="modal-footer-custom">
                    <div class="form-group">
                        <h4 id="ttl_tagihan" class="text-info">Rp. {Total Tagihan}</h4>
                    </div>
                    <div>
                        <input type="hidden" id="bayarFormValue"/>
                        <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('content-js')
<script>
    var dtable = $('#dtable').DataTable({
        "language": {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        "serverSide": true,
        "ajax": "/production/payment",
        "columns": [
            { data: 'kd_kontrol', name: 'nicename', class : 'text-center align-middle' },
            { data: 'pengguna', name: 'pengguna', class : 'text-center align-middle' },
            { data: 'tagihan', name: 'tagihan', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        "stateSave": true,
        "deferRender": true,
        "pageLength": 10,
        "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
        "order": [[ 0, "asc" ]],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [3] },
            { "bSearchable": false, "aTargets": [3] }
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
        dtable.column( 1 ).visible( false, false );
        dtable.columns.adjust().draw( false );
    }
    else{
        dtable.column( 1 ).visible( true, false );
        dtable.columns.adjust().draw( false );
    }

    setInterval(function(){
        dtableReload();
    }, 60000);

    function dtableReload(){
        dtable.ajax.reload(function(){
            console.log("Refresh Automatic")
        }, false);

        $(".tooltip").tooltip("hide");

        $(".popover").popover("hide");
    }

    $('#bayarForm').submit(function(e){
        e.preventDefault();
        value = $("#bayarFormValue").val();
        url = "/production/payment";
        type = "POST";
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
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.success(data.success);
                    dtableReload(data.searchKey);
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
                if(value == 'add'){
                    if(JSON.parse(data.responseText).success)
                        $('#bayarModal').modal('hide');
                }
                else{
                    $('#confirmModal').modal('hide');
                }
                $.unblockUI();
            }
        });
    }

    function totalBayar(){
        var sum = 0;
        $('.nominal:visible').each(function() {
            var value = Number($(this).text().replace(/\./g, ''));
            sum += value;
        });

        $("#ttl_tagihan").text('Rp. ' + sum.toLocaleString('id-ID'));
    }

    $('#bayarModal').on('shown.bs.modal', function() {
        function checkfaslistrik(){
            if($("#bayarlistrik").is(":checked")){
                $("#rowlistrik").show();
            }
            else{
                $("#rowlistrik").hide();
            }
            totalBayar();
        }
        $('#bayarlistrik').click(checkfaslistrik);

        function bulanlistrik(){
            if($(this).is(":checked")){
                $("#nominallistrik" + $(this).attr("index")).show();
            }
            else{
                $("#nominallistrik" + $(this).attr("index")).hide();
            }
            totalBayar();
        }
        $('.bulanlistrik').click(bulanlistrik);

        function checkairbersih(){
            if($("#bayarairbersih").is(":checked")){
                $("#rowairbersih").show();
            }
            else{
                $("#rowairbersih").hide();
            }
            totalBayar();
        }
        $('#bayarairbersih').click(checkairbersih);

        function bulanairbersih(){
            if($(this).is(":checked")){
                $("#nominalairbersih" + $(this).attr("index")).show();
            }
            else{
                $("#nominalairbersih" + $(this).attr("index")).hide();
            }
            totalBayar();
        }
        $('.bulanairbersih').click(bulanairbersih);

        function checkkeamananipk(){
            if($("#bayarkeamananipk").is(":checked")){
                $("#rowkeamananipk").show();
            }
            else{
                $("#rowkeamananipk").hide();
            }
            totalBayar();
        }
        $('#bayarkeamananipk').click(checkkeamananipk);

        function bulankeamananipk(){
            if($(this).is(":checked")){
                $("#nominalkeamananipk" + $(this).attr("index")).show();
            }
            else{
                $("#nominalkeamananipk" + $(this).attr("index")).hide();
            }
            totalBayar();
        }
        $('.bulankeamananipk').click(bulankeamananipk);

        function checkkebersihan(){
            if($("#bayarkebersihan").is(":checked")){
                $("#rowkebersihan").show();
            }
            else{
                $("#rowkebersihan").hide();
            }
            totalBayar();
        }
        $('#bayarkebersihan').click(checkkebersihan);

        function bulankebersihan(){
            if($(this).is(":checked")){
                $("#nominalkebersihan" + $(this).attr("index")).show();
            }
            else{
                $("#nominalkebersihan" + $(this).attr("index")).hide();
            }
            totalBayar();
        }
        $('.bulankebersihan').click(bulankebersihan);

        function checkairkotor(){
            if($("#bayarairkotor").is(":checked")){
                $("#rowairkotor").show();
            }
            else{
                $("#rowairkotor").hide();
            }
            totalBayar();
        }
        $('#bayarairkotor').click(checkairkotor);

        function bulanairkotor(){
            if($(this).is(":checked")){
                $("#nominalairkotor" + $(this).attr("index")).show();
            }
            else{
                $("#nominalairkotor" + $(this).attr("index")).hide();
            }
            totalBayar();
        }
        $('.bulanairkotor').click(bulanairkotor);

        function checklain(){
            if($("#bayarlain").is(":checked")){
                $("#rowlain").show();
            }
            else{
                $("#rowlain").hide();
            }
            totalBayar();
        }
        $('#bayarlain').click(checklain);

        function bulanlain(){
            if($(this).is(":checked")){
                $("#nominallain" + $(this).attr("index")).show();
            }
            else{
                $("#nominallain" + $(this).attr("index")).hide();
            }
            totalBayar();
        }
        $('.bulanlain').click(bulanlain);
    });

    $(document).on('click', '.bayar', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $("#bayarFormValue").val('add');
        $('.titles').text('Bayar Tagihan ' + nama);
        $('#bayar_summary').html('');
        var bayar_summary = '';

        $.ajax({
            url: "/production/payment/summary/" + id,
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#paymentId").val(id);
                    $("#kontrol").val(data.show.kd_kontrol);
                    $("#pengguna").val(data.show.pengguna);

                    ttl_tagihan = data.show.ttl_tagihan;

                    if (data.show.listrik.length === 0) {
                        bayar_summary += '';
                    } else {
                        var html = '';

                        html += '<div class="custom-control custom-checkbox">';
                        html += '<div class="form-group">';
                        html += '<input type="checkbox" class="custom-control-input" id="bayarlistrik" name="bayarlistrik" checked>';
                        html += '<label class="custom-control-label" for="bayarlistrik">Listrik</label>';
                        html += '</div>';
                        html += '<div id="rowlistrik">';
                        //foreach
                        $.each( data.show.listrik , function( i, val ) {
                        html += '<div class="d-flex justify-content-between">';
                        html += '<div class="form-group">';
                        html += '<div class="custom-control custom-checkbox">';
                        html += '<input type="checkbox" class="custom-control-input bulanlistrik" value="' + val.id + '" index="' + i + '" id="bulanlistrik' + i + '" name="bulanlistrik[]" checked>';
                        html += '<label class="custom-control-label" for="bulanlistrik' + i + '">' + val.period + '</label>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="form-group">';
                        html += '<a href="javascript:void(0)"';
                        html += 'class="h5 nominal"';
                        html += 'value="' + val.sel_tagihan + '"';
                        html += 'id="nominallistrik' + i + '"';
                        html += 'title="' + val.period + '"';
                        html += 'data-toggle="popover"';
                        html += 'data-html="true"';
                        html += 'data-content="Sub : ' + val.sub_tagihan.toLocaleString('id-ID')
                                + ' (+)<br>Den : ' + val.den_tagihan.toLocaleString('id-ID')
                                + ' (+)<br>Disc : ' + val.dis_tagihan.toLocaleString('id-ID')
                                + ' (-)<br>Total : ' + val.ttl_tagihan.toLocaleString('id-ID')
                                + '<br>Dibayar : ' + val.rea_tagihan.toLocaleString('id-ID')
                                + '<br><b>Ditagih : ' + val.sel_tagihan.toLocaleString('id-ID') + '</b>">';
                        html += val.sel_tagihan.toLocaleString('id-ID');
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        });
                        //endforeach
                        html +=   '</div>';
                        html += '</div>';
                        html += '<hr>';

                        bayar_summary += html;
                    }

                    if (data.show.airbersih.length === 0) {
                        bayar_summary += '';
                    } else {
                        var html = '';

                        html += '<div class="custom-control custom-checkbox">';
                        html += '<div class="form-group">';
                        html += '<input type="checkbox" class="custom-control-input" id="bayarairbersih" name="bayarairbersih" checked>';
                        html += '<label class="custom-control-label" for="bayarairbersih">Air Bersih</label>';
                        html += '</div>';
                        html += '<div id="rowairbersih">';
                        //foreach
                        $.each( data.show.airbersih , function( i, val ) {
                        html += '<div class="d-flex justify-content-between">';
                        html += '<div class="form-group">';
                        html += '<div class="custom-control custom-checkbox">';
                        html += '<input type="checkbox" class="custom-control-input bulanairbersih" value="' + val.id + '" index="' + i + '" id="bulanairbersih' + i + '" name="bulanairbersih[]" checked>';
                        html += '<label class="custom-control-label" for="bulanairbersih' + i + '">' + val.period + '</label>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="form-group">';
                        html += '<a href="javascript:void(0)"';
                        html += 'class="h5 nominal"';
                        html += 'id="nominalairbersih' + i + '"';
                        html += 'title="' + val.period + '"';
                        html += 'data-toggle="popover"';
                        html += 'data-html="true"';
                        html += 'data-content="Sub : ' + val.sub_tagihan.toLocaleString('id-ID')
                                + ' (+)<br>Den : ' + val.den_tagihan.toLocaleString('id-ID')
                                + ' (+)<br>Disc : ' + val.dis_tagihan.toLocaleString('id-ID')
                                + ' (-)<br>Total : ' + val.ttl_tagihan.toLocaleString('id-ID')
                                + '<br>Dibayar : ' + val.rea_tagihan.toLocaleString('id-ID')
                                + '<br><b>Ditagih : ' + val.sel_tagihan.toLocaleString('id-ID') + '</b>">';
                        html += val.sel_tagihan.toLocaleString('id-ID');
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        });
                        //endforeach
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';

                        bayar_summary += html;
                    }

                    if (data.show.keamananipk.length === 0) {
                        bayar_summary += '';
                    } else {
                        var html = '';

                        html += '<div class="custom-control custom-checkbox">';
                        html += '<div class="form-group">';
                        html += '<input type="checkbox" class="custom-control-input" id="bayarkeamananipk" name="bayarkeamananipk" checked>';
                        html += '<label class="custom-control-label" for="bayarkeamananipk">Keamanan IPK</label>';
                        html += '</div>';
                        html += '<div id="rowkeamananipk">';
                        //foreach
                        $.each( data.show.keamananipk , function( i, val ) {
                        html += '<div class="d-flex justify-content-between">';
                        html += '<div class="form-group">';
                        html += '<div class="custom-control custom-checkbox">';
                        html += '<input type="checkbox" class="custom-control-input bulankeamananipk" value="' + val.id + '" index="' + i + '" id="bulankeamananipk' + i + '" name="bulankeamananipk[]" checked>';
                        html += '<label class="custom-control-label" for="bulankeamananipk' + i + '">' + val.period + '</label>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="form-group">';
                        html += '<a href="javascript:void(0)"';
                        html += 'class="h5 nominal"';
                        html += 'id="nominalkeamananipk' + i + '"';
                        html += 'title="' + val.period + '"';
                        html += 'data-toggle="popover"';
                        html += 'data-html="true"';
                        html += 'data-content="Sub : ' + val.sub_tagihan.toLocaleString('id-ID')
                                + ' (+)<br>Disc : ' + val.dis_tagihan.toLocaleString('id-ID')
                                + ' (-)<br>Total : ' + val.ttl_tagihan.toLocaleString('id-ID')
                                + '<br>Dibayar : ' + val.rea_tagihan.toLocaleString('id-ID')
                                + '<br><b>Ditagih : ' + val.sel_tagihan.toLocaleString('id-ID') + '</b>">';
                        html += val.sel_tagihan.toLocaleString('id-ID');
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        });
                        //endforeach
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';

                        bayar_summary += html;
                    }

                    if (data.show.kebersihan.length === 0) {
                        bayar_summary += '';
                    } else {
                        var html = '';

                        html += '<div class="custom-control custom-checkbox">';
                        html += '<div class="form-group">';
                        html += '<input type="checkbox" class="custom-control-input" id="bayarkebersihan" name="bayarkebersihan" checked>';
                        html += '<label class="custom-control-label" for="bayarkebersihan">Kebersihan</label>';
                        html += '</div>';
                        html += '<div id="rowkebersihan">';
                        //foreach
                        $.each( data.show.kebersihan , function( i, val ) {
                        html += '<div class="d-flex justify-content-between">';
                        html += '<div class="form-group">';
                        html += '<div class="custom-control custom-checkbox">';
                        html += '<input type="checkbox" class="custom-control-input bulankebersihan" value="' + val.id + '" index="' + i + '" id="bulankebersihan' + i + '" name="bulankebersihan[]" checked>';
                        html += '<label class="custom-control-label" for="bulankebersihan' + i + '">' + val.period + '</label>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="form-group">';
                        html += '<a href="javascript:void(0)"';
                        html += 'class="h5 nominal"';
                        html += 'id="nominalkebersihan' + i + '"';
                        html += 'title="' + val.period + '"';
                        html += 'data-toggle="popover"';
                        html += 'data-html="true"';
                        html += 'data-content="Sub : ' + val.sub_tagihan.toLocaleString('id-ID')
                                + ' (+)<br>Disc : ' + val.dis_tagihan.toLocaleString('id-ID')
                                + ' (-)<br>Total : ' + val.ttl_tagihan.toLocaleString('id-ID')
                                + '<br>Dibayar : ' + val.rea_tagihan.toLocaleString('id-ID')
                                + '<br><b>Ditagih : ' + val.sel_tagihan.toLocaleString('id-ID') + '</b>">';
                        html += val.sel_tagihan.toLocaleString('id-ID');
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        });
                        //endforeach
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';

                        bayar_summary += html;
                    }

                    if (data.show.airkotor.length === 0) {
                        bayar_summary += '';
                    } else {
                        var html = '';

                        html += '<div class="custom-control custom-checkbox">';
                        html += '<div class="form-group">';
                        html += '<input type="checkbox" class="custom-control-input" id="bayarairkotor" name="bayarairkotor" checked>';
                        html += '<label class="custom-control-label" for="bayarairkotor">Air Kotor</label>';
                        html += '</div>';
                        html += '<div id="rowairkotor">';
                        //foreach
                        $.each( data.show.airkotor , function( i, val ) {
                        html += '<div class="d-flex justify-content-between">';
                        html += '<div class="form-group">';
                        html += '<div class="custom-control custom-checkbox">';
                        html += '<input type="checkbox" class="custom-control-input bulanairkotor" value="' + val.id + '" index="' + i + '" id="bulanairkotor' + i + '" name="bulanairkotor[]" checked>';
                        html += '<label class="custom-control-label" for="bulanairkotor' + i + '">' + val.period + '</label>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="form-group">';
                        html += '<a href="javascript:void(0)"';
                        html += 'class="h5 nominal"';
                        html += 'id="nominalairkotor' + i + '"';
                        html += 'title="' + val.period + '"';
                        html += 'data-toggle="popover"';
                        html += 'data-html="true"';
                        html += 'data-content="Sub : ' + val.sub_tagihan.toLocaleString('id-ID')
                                + ' (+)<br>Disc : ' + val.dis_tagihan.toLocaleString('id-ID')
                                + ' (-)<br>Total : ' + val.ttl_tagihan.toLocaleString('id-ID')
                                + '<br>Dibayar : ' + val.rea_tagihan.toLocaleString('id-ID')
                                + '<br><b>Ditagih : ' + val.sel_tagihan.toLocaleString('id-ID') + '</b>">';
                        html += val.sel_tagihan.toLocaleString('id-ID');
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        });
                        //endforeach
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';

                        bayar_summary += html;
                    }

                    if (data.show.lain.length === 0) {
                        bayar_summary += '';
                    } else {
                        var html = '';

                        html += '<div class="custom-control custom-checkbox">';
                        html += '<div class="form-group">';
                        html += '<input type="checkbox" class="custom-control-input" id="bayarlain" name="bayarlain" checked>';
                        html += '<label class="custom-control-label" for="bayarlain">Lainnya</label>';
                        html += '</div>';
                        html += '<div id="rowlain">';
                        //foreach
                        $.each( data.show.lain , function( i, val ) {
                        html += '<div class="d-flex justify-content-between">';
                        html += '<div class="form-group">';
                        html += '<div class="custom-control custom-checkbox">';
                        html += '<input type="checkbox" class="custom-control-input bulanlain" value="' + val.id + '" index="' + i + '" id="bulanlain' + i + '" name="bulanlain[]" checked>';
                        html += '<label class="custom-control-label" for="bulanlain' + i + '">' + val.period + '</label>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="form-group">';
                        html += '<a href="javascript:void(0)"';
                        html += 'class="h5 nominal"';
                        html += 'id="nominallain' + i + '"';
                        html += 'title="' + val.period + '"';
                        html += 'data-toggle="popover"';
                        html += 'data-html="true"';
                        html += 'data-content="'
                                + val.fasilitas
                                + '<br>Total : ' + val.ttl_tagihan.toLocaleString('id-ID')
                                + '<br>Dibayar : ' + val.rea_tagihan.toLocaleString('id-ID')
                                + '<br><b>Ditagih : ' + val.sel_tagihan.toLocaleString('id-ID') + '</b>">';
                        html += val.sel_tagihan.toLocaleString('id-ID');
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        });
                        //endforeach
                        html += '</div>';
                        html += '</div>';
                        html += '<hr>';

                        bayar_summary += html;
                    }

                    $("#bayar_summary").append(bayar_summary.slice(0,-4));

                    $("#ttl_tagihan").text('Rp. ' + ttl_tagihan.toLocaleString('id-ID'));
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
                $('#bayarModal').modal('show');
                var is_touch_device = ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch;
                $('[data-toggle="popover"]').popover({
                    trigger: is_touch_device ? "click" : "hover"
                });
            }
        });
    });
</script>
@endsection
