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
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <div class="form-group">
                                <input type="checkbox" class="custom-control-input" id="bayarlistrik" name="bayarlistrik" checked>
                                <label class="custom-control-label" for="bayarlistrik">Listrik</label>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-6 m-auto">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="bulanlistrik1" name="bulanlistrik[]" checked>
                                            <label class="custom-control-label" for="bulanlistrik1">Oktober 2021</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="bulanlistrik2" name="bulanlistrik[]" checked>
                                            <label class="custom-control-label" for="bulanlistrik2">November 2021</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="bulanlistrik3" name="bulanlistrik[]" checked>
                                            <label class="custom-control-label" for="bulanlistrik3">Desember 2021</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 d-none d-lg-block text-left">
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <h5>:</h5>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <h5>:</h5>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <h5>:</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6 m-auto text-right">
                                    <div class="form-group">
                                        <a  href="javascript:void(0)"
                                            class="h5"
                                            id="nominallistrik1"
                                            data-container="body"
                                            data-trigger="click"
                                            title="Oktober 2021"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="Sub : 50.000 (+)<br>Den : 50.000 (+)<br>Disc : 50.000 (-)<hr>Total : 50.000">
                                            10.000
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <a  href="javascript:void(0)"
                                            class="h5"
                                            id="nominallistrik2"
                                            data-container="body"
                                            data-trigger="click"
                                            title="Oktober 2021"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="+ Subtotal : 50.000<br>+ Denda : 50.000<br>- Diskon : 50.000<hr>Tagihan : 50.000">
                                            10.000
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <a  href="javascript:void(0)"
                                            class="h5"
                                            id="nominallistrik3"
                                            data-container="body"
                                            data-trigger="click"
                                            title="Oktober 2021"
                                            data-toggle="popover"
                                            data-html="true"
                                            data-content="+ Subtotal : 50.000<br>+ Denda : 50.000<br>- Diskon : 50.000<hr>Tagihan : 50.000">
                                            10.000
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer-custom">
                    <div class="form-group">
                        <h4 class="text-info ttl_tagihan">Rp. {Total Tagihan}</h4>
                    </div>
                    <div>
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

    $(document).on('click', '.bayar', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Bayar Tagihan ' + nama);

        $.ajax({
            url: "/production/payment/summary/" + id,
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $(".ttl_tagihan").text(data.show.ttl_tagihan);

                    // var html = '';

                    // $("#bayarSummary").append(html);
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
            }
        });
    });
</script>
@endsection
