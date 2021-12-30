@extends('portal.layout.master')

@section('content-title')
Tarif Air Bersih
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn mr-3">
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
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Data</th>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarif Air Bersih</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <small class="text-muted pt-4 db">Nama Tarif</small>
                <h4 id="showName"></h4>
                <small class="text-muted pt-4 db">Tarif 1</small>
                <h6 id="showTarif1"></h6>
                <small class="text-muted pt-4 db">Tarif 2</small>
                <h6 id="showTarif2"></h6>
                <small class="text-muted pt-4 db">Pemeliharaan</small>
                <h6 id="showPemeliharaan"></h6>
                <small class="text-muted pt-4 db">Beban</small>
                <h6 id="showBeban"></h6>
                <small class="text-muted pt-4 db">Air Kotor</small>
                <h6 id="showAirKotor"></h6>
                <small class="text-muted pt-4 db">Denda</small>
                <h6 id="showDenda"></h6>
                <small class="text-muted pt-4 db">PPN</small>
                <h6 id="showPpn"></h6>
                <small class="text-muted pt-4 db">Dibuat oleh</small>
                <h6 id="showCreate"></h6>
                <small class="text-muted pt-4 db">Diperbaharui oleh</small>
                <h6 id="showEdit"></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="priceModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="priceForm">
                <div class="modal-body-xl">
                    <div class="form-group">
                        <label>Nama Tarif <span class="text-danger">*</span></label>
                        <input required type="text" id="name" name="name" autocomplete="off" maxlength="100" placeholder="Contoh: Tarif 1" class="form-control form-control-line">
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Tarif 1 <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input maxlength="11" required type="text" id="tarif1" name="tarif1" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">/ M<sup>3</sup></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>tarif 2 <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input maxlength="11" required type="text" id="tarif2" name="tarif2" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">/ M<sup>3</sup></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pemeliharaan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input maxlength="11" required type="text" id="pemeliharaan" name="pemeliharaan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Beban <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input maxlength="11" required type="text" id="beban" name="beban" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xlg-6">
                            <div class="form-group">
                                <label>Air Kotor <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input maxlength="3" required type="text" id="airkotor" name="airkotor" autocomplete="off" placeholder="Ketikkan dalam angka 0-100" class="number percent form-control form-control-line">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Denda <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input maxlength="11" required type="text" id="denda" name="denda" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>PPN <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input maxlength="3" required type="text" id="ppn" name="ppn" autocomplete="off" placeholder="Ketikkan dalam angka 0-100" class="number percent form-control form-control-line">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>(<label class="text-danger">*</label>) wajib diisi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="priceFormValue"/>
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
    $("#name").on("input", function(){
        this.value = this.value.replace(/\s\s+/g, ' ');
    });

    var id;

    var dtable = $('#dtable').DataTable({
        "language": {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        "serverSide": true,
        "ajax": "/production/prices/airbersih",
        "columns": [
            { data: 'name', name: 'name', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        "stateSave": true,
        "deferRender": true,
        "pageLength": 10,
        "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
        "order": [[ 0, "asc" ]],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [1] },
            { "bSearchable": false, "aTargets": [1] }
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

    $(".add").click( function(){
        $("#priceForm")[0].reset();
        $('.titles').text('Tambah Tarif Air Bersih');
        $("#priceFormValue").val('add');
        $('#priceModal').modal('show');
        $('#priceModal').on('shown.bs.modal', function() {
            $('#name').focus();
        });
    });

    $(document).on('click', '.edit', function(){
        id = $(this).attr('id');
        name = $(this).attr('nama');
        $("#priceForm")[0].reset();
        $('.titles').text('Edit data ' + name);
        $("#priceFormValue").val('update');

        $.ajax({
            url: "/production/prices/airbersih/" + id + "/edit",
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#name").val(data.show.name);
                    $("#tarif1").val(Number(data.show.data.tarif1).toLocaleString('id-ID'));
                    $("#tarif2").val(Number(data.show.data.tarif2).toLocaleString('id-ID'));
                    $("#pemeliharaan").val(Number(data.show.data.pemeliharaan).toLocaleString('id-ID'));
                    $("#beban").val(Number(data.show.data.beban).toLocaleString('id-ID'));
                    $("#airkotor").val(data.show.data.airkotor);
                    $("#denda").val(Number(data.show.data.denda).toLocaleString('id-ID'));
                    $("#ppn").val(data.show.data.ppn);
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
                $('#priceModal').modal('show');
                $('#priceModal').on('shown.bs.modal', function() {
                    $('#name').focus();
                });
            }
        });
    });

    $(document).on('click', '.delete', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Hapus permanen data ' + nama + ' ?');
        $('.bodies').html('Pilih <b>Permanen</b> di bawah ini jika anda yakin untuk menghapus data tarif.');
        $('#ok_button').removeClass().addClass('btn btn-danger').text('Permanen');
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
            url = "/production/prices/airbersih/" + id;
            type = "DELETE";
        }

        ajaxForm(url, type, value, dataset);
    });

    $('#priceForm').submit(function(e){
        e.preventDefault();

        value = $("#priceFormValue").val();
        if(value == 'add'){
            url = "/production/prices/airbersih";
            type = "POST";
        }
        else if(value == 'update'){
            url = "/production/prices/airbersih/" + id;
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
                if(value == 'add' || value == 'update'){
                    if(JSON.parse(data.responseText).success)
                        $('#priceModal').modal('hide');
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

        $.ajax({
            url: "/production/prices/airbersih/" + id,
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#showName").text(data.show.name);
                    $("#showTarif1").text("Rp. " + Number(data.show.data.tarif1).toLocaleString('id-ID'));
                    $("#showTarif2").text("Rp. " + Number(data.show.data.tarif2).toLocaleString('id-ID'));
                    $("#showPemeliharaan").text("Rp. " + Number(data.show.data.pemeliharaan).toLocaleString('id-ID'));
                    $("#showBeban").text("Rp. " + Number(data.show.data.beban).toLocaleString('id-ID'));
                    $("#showAirKotor").text(data.show.data.airkotor + " %");
                    $("#showDenda").text("Rp. " + Number(data.show.data.denda).toLocaleString('id-ID'));
                    $("#showPpn").text(data.show.data.ppn + " %");
                    $("#showCreate").html(data.show.data.created_by_name + "<br>pada " + data.show.data.created_at);
                    $("#showEdit").html(data.show.data.updated_by_name + "<br>pada " + data.show.data.updated_at);
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
</script>
@endsection
