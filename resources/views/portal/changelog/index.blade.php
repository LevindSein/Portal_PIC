@extends('portal.layout.master')

@section('content-title')
Daftar Log Perubahan
@endsection

@section('content-button')
@if(Auth::user()->level == 1)
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
@endif
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
                                <th>Release</th>
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
            <div class="modal-body">
                <small class="text-muted pt-4 db">Release</small>
                <h6 id="showRelease"></h6>
                <small class="text-muted pt-4 db">Judul</small>
                <h6 id="showTitle"></h6>
                <small class="text-muted pt-4 db">Dibuat oleh</small>
                <h6 id="showCreate"></h6>
                <small class="text-muted pt-4 db">Diperbaharui oleh</small>
                <h6 id="showEdit"></h6>
                <small class="text-muted pt-4 db">Data Log</small>
                <h6 id="showData"></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="logModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="logForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Release Time <span class="text-danger">*</span></label>
                        <input required type="datetime-local" step="1" id="release" name="release" autocomplete="off" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Judul <span class="text-danger">*</span></label>
                        <input required type="text" id="title" name="title" autocomplete="off" maxlength="100" placeholder="Ketikkan judul perubahan" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Data Perubahan <span class="text-danger">*</span></label>
                        <textarea required rows="10" id="data" name="data" autocomplete="off" placeholder="Ketikkan data perubahan" class="form-control form-control-line"></textarea>
                    </div>
                    <div class="form-group">
                        <p>(<label class="text-danger">*</label>) wajib diisi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="logFormValue"/>
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
    var id;
    var dtable = $('#dtable').DataTable({
        "language": {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        "serverSide": true,
        "ajax": "/production/changelogs",
        "columns": [
            { data: 'release_date', name: 'release_date', class : 'text-center align-middle'  },
            { data: 'data', name: 'data', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        "stateSave": true,
        "deferRender": true,
        "pageLength": 10,
        "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
        "order": [[ 0, "desc" ]],
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

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        dtable.column( 1 ).visible( false, false );
        dtable.columns.adjust().draw( false );
    }
    else{
        dtable.column( 1 ).visible( true, false );
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

        $(".tooltip").tooltip("hide");

        $(".popover").popover("hide");
    }

    $(".add").click( function(){
        $("#logForm")[0].reset();
        $('.titles').text('Tambah data Log Perubahan');
        $("#logFormValue").val('add');
        $('#logModal').modal('show');
        $('#logModal').on('shown.bs.modal', function() {
            $('#title').focus();
        });
    });

    $(document).on('click', '.edit', function(){
        id = $(this).attr('id');
        $("#logForm")[0].reset();
        $('.titles').text('Edit data Log Perubahan');
        $("#logFormValue").val('update');

        $.ajax({
            url: "/production/changelogs/" + id + "/edit",
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#release").val(data.changelog.release);
                    $("#title").val(data.changelog.title);
                    $("#data").val(data.changelog.data);
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
                $('#logModal').modal('show');
                $('#logModal').on('shown.bs.modal', function() {
                    $('#title').focus();
                });
            }
        });
    });

    $(document).on('click', '.delete', function(){
        id = $(this).attr('id');
        $('.titles').text('Hapus permanen data Log Perubahan ?');
        $('.bodies').html('Pilih <b>Permanen</b> di bawah ini jika anda yakin untuk menghapus data log perubahan.');
        $('#ok_button').removeClass().addClass('btn btn-danger').text('Permanen');
        $('#confirmValue').val('delete');
        $('#confirmModal').modal('show');
    });

    $('#logForm').submit(function(e){
        e.preventDefault();

        value = $("#logFormValue").val();
        if(value == 'add'){
            url = "/production/changelogs";
            type = "POST";
        }
        else if(value == 'update'){
            url = "/production/changelogs/" + id;
            type = "PUT";
        }
        dataset = $(this).serialize();
        ok_btn_before = "Menyimpan...";
        ok_btn_completed = "Simpan";
        ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
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
            url = "/production/changelogs/" + id;
            type = "DELETE";
            ok_btn_before = "Menghapus...";
            ok_btn_completed = "Hapus";
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
                        $('#logModal').modal('hide');
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
            url: "/production/changelogs/" + id,
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#showRelease").text(data.changelog.release);
                    $("#showTitle").text(data.changelog.title);
                    $("#showCreate").html(data.changelog.created_by_name + "<br>pada " + data.changelog.created_at);
                    $("#showEdit").html(data.changelog.updated_by_name + "<br>pada " + data.changelog.updated_at);
                    $("#showData").html(data.changelog.data.replace(/\r\n/g, '<br>'));
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
