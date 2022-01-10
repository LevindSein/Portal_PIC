@extends('portal.layout.master')

@section('content-title')
Libur Tagihan
@endsection

@section('content-button')
<button type="button" class="btn btn-success add" data-toggle="tooltip" data-placement="left" title="Tambah Data">
    <i class="fas fa-fw fa-plus"></i>
</button>
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn mr-3">
        @include('portal.manage.button')
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
                                <th>Date</th>
                                <th>Desc</th>
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
                <small class="text-muted pt-4 db">Tanggal</small>
                <h6 id="showDate"></h6>
                <small class="text-muted pt-4 db">Deskripsi</small>
                <h6 id="showDesc"></h6>
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

<div id="dayOffModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="dayOffForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal <span class="text-danger">*</span></label>
                        <input required type="date" id="date" name="date" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea rows="5" id="desc" name="desc" autocomplete="off" maxlength="255" placeholder="Ketikkan deskripsi" class="form-control form-control-line"></textarea>
                    </div>
                    <div class="form-group">
                        <p>(<label class="text-danger">*</label>) wajib diisi.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="dayOffFormValue"/>
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
        "ajax": "/production/manage/dayoff",
        "columns": [
            { data: 'date', name: 'date', class : 'text-center align-middle' },
            { data: 'data', name: 'data', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
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
        $("#dayOffForm")[0].reset();
        $('.titles').text('Tambah data Hari Libur');
        $("#dayOffFormValue").val('add');
        $('#dayOffModal').modal('show');
        $('#dayOffModal').on('shown.bs.modal', function() {
            $('#date').focus();
        });
    });

    $(document).on('click', '.edit', function(){
        id = $(this).attr('id');
        name = $(this).attr('nama');
        $("#dayOffForm")[0].reset();
        $('.titles').text('Edit data ' + name);
        $("#dayOffFormValue").val('update');

        $.ajax({
            url: "/production/manage/dayoff/" + id + "/edit",
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#date").val(data.show.date);
                    $("#desc").val(data.show.data.desc);
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
                toastr.error("Fetching data failed.");
                console.log(data);
            },
            complete:function(){
                $('#dayOffModal').modal('show');
                $('#dayOffModal').on('shown.bs.modal', function() {
                    $('#date').focus();
                });
            }
        });
    });

    $(document).on('click', '.delete', function(){
        id = $(this).attr('id');
        name = $(this).attr('nama');
        $('.titles').text('Hapus permanen data ' + name + '?');
        $('.bodies').html('Pilih <b>Permanen</b> di bawah ini jika anda yakin untuk menghapus data hari libur tagihan.');
        $('#ok_button').removeClass().addClass('btn btn-danger').text('Permanen');
        $('#confirmValue').val('delete');
        $('#confirmModal').modal('show');
    });

    $('#dayOffForm').submit(function(e){
        e.preventDefault();

        value = $("#dayOffFormValue").val();
        if(value == 'add'){
            url = "/production/manage/dayoff";
            type = "POST";
        }
        else if(value == 'update'){
            url = "/production/manage/dayoff/" + id;
            type = "PUT";
        }
        dataset = $(this).serialize();
        ajaxForm(url, type, value, dataset);
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
            url = "/production/manage/dayoff/" + id;
            type = "DELETE";
        }

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
                    dtableReload(data.searchKey);
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
                if(value == 'add' || value == 'update'){
                    if(JSON.parse(data.responseText).success)
                        $('#dayOffModal').modal('hide');
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
            url: "/production/manage/dayoff/" + id,
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#showDate").text(data.show.date);
                    $("#showDesc").html(data.show.data.desc);
                    $("#showCreate").html(data.show.data.created_by_name + "<br>pada " + data.show.data.created_at);
                    $("#showEdit").html(data.show.data.updated_by_name + "<br>pada " + data.show.data.updated_at);
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
