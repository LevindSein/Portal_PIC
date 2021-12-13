@extends('portal.layout.master')

@section('content-title')
Alat Listrik
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn mr-3">
        <a class="dropdown-item add" href="javascript:void(0)">
            <i class="fas fa-fw fa-plus mr-1 ml-1"></i>
            <span>Alat Listrik</span>
        </a>
        <div class="dropdown-divider"></div>
        @include('portal.point.button')
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group d-flex">
                    <div class="mr-1 ml-1"><div class='color color-success'></div>&nbsp;Tersedia</div>
                    <div class="mr-1 ml-1"><div class='color color-danger'></div>&nbsp;Digunakan</div>
                </div>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>ID</th>
                                <th>Power (Watt)</th>
                                <th>Meter</th>
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
            <div class="modal-body">
                <small class="text-muted pt-4 db">Kode</small>
                <h6 id="showCode"></h6>
                <small class="text-muted pt-4 db">ID</small>
                <h6 id="showName"></h6>
                <small class="text-muted pt-4 db">Daya</small>
                <h6 id="showPower"></h6>
                <small class="text-muted pt-4 db">Meter</small>
                <h6 id="showMeter"></h6>
                <small class="text-muted pt-4 db">Status Ketersediaan</small>
                <h6 id="showAvailable"></h6>
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

<div id="toolsModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="toolsForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>ID Alat <span class="text-danger">*</span></label>
                        <input required type="text" id="name" name="name" autocomplete="off" maxlength="30" placeholder="Contoh: 170002xxxxx" class="form-control form-control-line" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                        <label>Daya (Watt) <span class="text-danger">*</span></label>
                        <input required type="text" id="power" name="power" autocomplete="off" maxlength="12" placeholder="Ketikkan Daya dalam angka" class="number form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Meter <span class="text-danger">*</span></label>
                        <input required type="text" id="meter" name="meter" autocomplete="off" maxlength="12" placeholder="Ketikkan Meter dalam angka" class="number form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <p>(<label class="text-danger">*</label>) wajib diisi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="toolsFormValue"/>
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

        var id;

        var dtable = $('#dtable').DataTable({
            "language": {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
            "serverSide": true,
            "ajax": "/production/point/tools/listrik",
            "columns": [
                { data: 'code', name: 'code', class : 'text-center' },
                { data: 'name', name: 'name', class : 'text-center' },
                { data: 'power', name: 'power', class : 'text-center' },
                { data: 'meter', name: 'meter', class : 'text-center' },
                { data: 'action', name: 'action', class : 'text-center' },
            ],
            "stateSave": true,
            "deferRender": true,
            "pageLength": 10,
            "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
            "order": [[ 0, "asc" ]],
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [4] },
                { "bSearchable": false, "aTargets": [4] }
            ],
            "scrollY": "45vh",
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
        }

        $(".add").click( function(){
            $("#toolsForm")[0].reset();
            $('.titles').text('Tambah Alat Listrik');
            $("#toolsFormValue").val('add');
            $('#toolsModal').modal('show');
            $('#toolsModal').on('shown.bs.modal', function() {
                $('#name').focus();
            });
        });

        $(document).on('click', '.edit', function(){
            id = $(this).attr('id');
            name = $(this).attr('nama');
            $("#toolsForm")[0].reset();
            $('.titles').text('Edit data ' + name);
            $("#toolsFormValue").val('update');

            $.ajax({
                url: "/production/point/tools/listrik/" + id + "/edit",
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#name").val(data.show.name);
                        $("#power").val(Number(data.show.power).toLocaleString('id-ID'));
                        $("#meter").val(Number(data.show.meter).toLocaleString('id-ID'));
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
                    $('#toolsModal').modal('show');
                    $('#toolsModal').on('shown.bs.modal', function() {
                        $('#name').focus();
                    });
                }
            });
        });

        $(document).on('click', '.delete', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Hapus data ' + nama + ' ?');
            $('.bodies').text('Pilih "Hapus" di bawah ini jika anda yakin untuk menghapus data alat.');
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
                url = "/production/point/tools/listrik/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Hapus";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
        });

        $('#toolsForm').submit(function(e){
            e.preventDefault();

            value = $("#toolsFormValue").val();
            if(value == 'add'){
                url = "/production/point/tools/listrik";
                type = "POST";
            }
            else if(value == 'update'){
                url = "/production/point/tools/listrik/" + id;
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
                            $('#toolsModal').modal('hide');
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
                url: "/production/point/tools/listrik/" + id,
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#showCode").text(data.show.code);
                        (data.show.name) ? $("#showName").text(data.show.name) : $("#showName").html("&mdash;");
                        $("#showPower").text(Number(data.show.power).toLocaleString('id-ID') + " Watt");
                        $("#showMeter").text(Number(data.show.meter).toLocaleString('id-ID'));
                        (data.show.kontrol && !data.show.stt_available)
                            ? $("#showAvailable").html("<a class='text-danger' href='/production/point/stores?s=" + data.show.kontrol + "'>Digunakan&nbsp;" + data.show.kontrol + "&nbsp;<sup><i class='fas fa-external-link'></i></sup></a>")
                            : $("#showAvailable").html("<span class='text-success'>Tersedia</span>");
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
