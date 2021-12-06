@extends('portal.layout.master')

@section('content-title')
Tarif Kebersihan
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
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th><sup>Price&nbsp;</sup>&frasl;<sub>&nbsp;Los</sub></th>
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
                <h5 class="modal-title">Tarif Kebersihan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <small class="text-muted pt-4 db">Nama Tarif</small>
                <h4 id="showName"></h4>
                <small class="text-muted pt-4 db">Tarif</small>
                <h6 id="showTarif"></h6>
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

<div id="priceModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="priceForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Tarif <span class="text-danger">*</span></label>
                        <input required type="text" id="name" name="name" autocomplete="off" maxlength="100" placeholder="Contoh: Tarif 1" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Tarif <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input maxlength="11" required type="text" id="tarif" name="tarif" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-line">
                            <div class="input-group-prepend">
                                <span class="input-group-text">/ Los</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>(<span class="text-danger">*</span>) wajib diisi.</p>
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
    $(document).ready(function(){
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
        $('.hour').on('input', function (e) {
            if ($(this).val() > 24) $(this).val($(this).val().replace($(this).val(), 24));
        });

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
            "ajax": "/production/manage/prices/kebersihan",
            "columns": [
                { data: 'name', name: 'name', class : 'text-center' },
                { data: 'price', name: 'price', class : 'text-center' },
                { data: 'action', name: 'action', class : 'text-center' },
            ],
            "stateSave": true,
            "deferRender": true,
            "pageLength": 10,
            "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
            "order": [[ 0, "asc" ]],
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [2] },
                { "bSearchable": false, "aTargets": [2] }
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

        $(".add").click( function(){
            $("#priceForm")[0].reset();
            $('.titles').text('Tambah Tarif Kebersihan');
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
                url: "/production/manage/prices/kebersihan/" + id + "/edit",
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#name").val(data.show.name);
                        $("#tarif").val(Number(data.show.data.tarif).toLocaleString('id-ID'));
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
            $('.titles').text('Hapus data ' + nama + ' ?');
            $('.bodies').text('Pilih "Hapus" di bawah ini jika anda yakin untuk menghapus data tarif.');
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
                url = "/production/manage/prices/kebersihan/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Hapus";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
        });

        $('#priceForm').submit(function(e){
            e.preventDefault();

            value = $("#priceFormValue").val();
            if(value == 'add'){
                url = "/production/manage/prices/kebersihan";
                type = "POST";
            }
            else if(value == 'update'){
                url = "/production/manage/prices/kebersihan/" + id;
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
                url: "/production/manage/prices/kebersihan/" + id,
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#showName").text(data.show.name);
                        $("#showTarif").text("Rp. " + Number(data.show.data.tarif).toLocaleString('id-ID') + " / Los");
                        $("#showCreate").html(data.show.data.username_create + "<br>pada " + data.show.data.created_at);
                        $("#showEdit").html(data.show.data.username_update + "<br>pada " + data.show.data.updated_at);
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
    });
</script>
@endsection
