@extends('portal.layout.master')

@section('content-title')
User
@endsection

@section('content-button')
<a type="button" href="{{url('user')}}" class="btn btn-success" aria-haspopup="true" aria-expanded="false" data-toggle="tooltip" title="Home">
    <i class="fas fa-home"></i>
</a>
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn">
        <a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-plus"></i>&nbsp;Tambah User</a>
        <a class="dropdown-item penghapusan" href="javascript:void(0)"><i class="fas fa-trash"></i>&nbsp;Data Penghapusan</a>
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group col-md-2 col-sm-2" style="padding: 0;">
                        <label for="kategori">Pilih Kategori</label>
                        <select class="form-control" id="kategori">
                            <option value="nasabah">Nasabah</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Details</th>
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
<div id="confirmModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body bodies">{body}</div>
            <form id="confirmForm">
                <div class="modal-footer">
                    <input type="hidden" id="confirmValue" value="">
                    <button type="submit" name="ok_button" id="ok_button" class="btn">{Button}</button>
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
        var params = getUrlParameter('data');
        if(params == "penghapusan"){
            penghapusan();
        }
        else{
            var dtable = dtableInit("/user");
        }

        $('#kategori').on('change', function() {
            if(this.value == "admin"){
                if(getUrlParameter('data') == 'penghapusan'){
                    dtable = dtableInit("/user/penghapusan/2");
                }
                else{
                    dtable = dtableInit("/user/level/2");
                }
            }
            else if(this.value == "nasabah"){
                if(getUrlParameter('data') == 'penghapusan'){
                    dtable = dtableInit("/user/penghapusan/3");
                }
                else{
                    dtable = dtableInit("/user");
                }
            }
        });

        $(".penghapusan").click(function(){
            penghapusan();
        });

        setInterval(function(){
            dtable.ajax.reload(function(){
                console.log("Refresh Automatic")
            }, false);
        }, 5000);

        var id;
        $(document).on('click', '.delete', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Hapus data ' + nama + ' ?');
            $('.bodies').text('Pilih "Hapus" di bawah ini jika anda yakin untuk menghapus data user.');
            $('#ok_button').addClass('btn-danger').removeClass('btn-info').text('Hapus');
            $('#confirmValue').val('delete');
            $('#confirmModal').modal('show');
        });

        $(document).on('click', '.restore', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Pulihkan data ' + nama + ' ?');
            $('.bodies').text('Pilih "Restore" di bawah ini jika anda yakin untuk memulihkan data user.');
            $('#ok_button').addClass('btn-info').removeClass('btn-danger').text('Restore');
            $('#confirmValue').val('restore');
            $('#confirmModal').modal('show');
        });

        $('#confirmForm').submit(function(e){
            e.preventDefault();
            var token = $("meta[name='csrf-token']").attr("content");
            var value = $('#confirmValue').val();
            if(value == 'delete'){
                url = "/user/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Hapus";
            }
            else{
                url = "/user/restore/" + id;
                type = "POST";
                ok_btn_before = "Memulihkan...";
                ok_btn_completed = "Restore";
            }
            $.ajax({
                url: url,
                type: type,
                cache:false,
                data: {
                    "id": id,
                    "_token": token,
                },
                beforeSend:function(){
                    $('#ok_button').text(ok_btn_before).prop("disabled",true);
                },
                success:function(data)
                {
                    if(data.success){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.success(data.success);
                    }
                    else if(data.exception){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error("Data gagal diproses.");
                        console.log(data.exception);
                    }
                    else{
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error(data.error);
                    }
                    dtable.ajax.reload(function(){
                        console.log("Refresh Automatic")
                    }, false);
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("Kesalahan Sistem.");
                },
                complete:function(){
                    $('#confirmModal').modal('hide');
                    $('#ok_button').text(ok_btn_completed).prop("disabled",false);
                }
            })
        });

        function dtableInit(url){
            $('#dtable').DataTable().clear().destroy();
            return $('#dtable').DataTable({
                "language": {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                },
                "serverSide": true,
                "ajax": url,
                "columns": [
                    { data: 'username', name: 'username', class : 'text-center' },
                    { data: 'name', name: 'name', class : 'text-center' },
                    { data: 'stt_aktif', name: 'stt_aktif', class : 'text-center' },
                    { data: 'action', name: 'action', class : 'text-center' },
                    { data: 'show', name: 'show', class : 'text-center' },
                ],
                "stateSave": true,
                "deferRender": true,
                "pageLength": 10,
                "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [3,4] },
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
        };

        function penghapusan(){
            $("#kategori").prop('selectedIndex',0)
            $(".page-title").text("Data Penghapusan");
            window.history.replaceState(null, null, "?data=penghapusan");
            dtable = dtableInit("/user/penghapusan/3");
        }
    });
</script>
@endsection
