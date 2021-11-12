@extends('portal.layout.master')

@section('content-title')
User
@endsection

@section('content-button')
<a type="button" href="javascript:void(0)" class="btn btn-success home" aria-haspopup="true" aria-expanded="false" data-toggle="tooltip" title="Home">
    <i class="fas fa-home"></i>
</a>
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn">
        <a class="dropdown-item tambah" href="javascript:void(0)"><i class="fas fa-plus"></i>&nbsp;Tambah User</a>
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
                            <option value="2">Admin</option>
                            <option value="3">Nasabah</option>
                            <option value="4">Kasir</option>
                            <option value="5">Keuangan</option>
                            <option value="6">Manajer</option>
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
<div id="resetModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Password Baru</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h1><b><span id="password_baru"></span></b></h1>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" id="btn_copy" class="btn btn-success">Click for Copy!</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="tambahModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="tambahForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Role <span class="text-danger">*</span></label>
                        <select class="form-control" id="level">
                            <option value="2">Admin</option>
                            <option value="3">Nasabah</option>
                            <option value="4">Kasir</option>
                            <option value="5">Keuangan</option>
                            <option value="6">Manajer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" required autocomplete="off" name="name" class="form-control" placeholder="H. John Doe">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" required autocomplete="off" name="email" class="form-control" placeholder="example@email.com">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">+62</span>
                            </div>
                            <input type="text" autocomplete="off" name="phone" class="form-control" placeholder="878xxxxxxxx" aria-label="phone" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>KTP</label>
                        <input type="text" autocomplete="off" name="ktp" class="form-control" placeholder="378405xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label>NPWP</label>
                        <input type="text" autocomplete="off" name="npwp" class="form-control" placeholder="08178xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" rows="5" placeholder="Jl.Ciracas Gg.Jembar No.107, Kota Bandung, Jawa Barat 40614"></textarea>
                    </div>
                    <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                        <input type="checkbox" class="custom-control-input" id="checkEmail" name="checkEmail" value="checked" checked>
                        <label class="custom-control-label" for="checkEmail">Kirim Email Verifikasi</label>
                    </div>
                </div>
                <div class="modal-footer">
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
        var params = getUrlParameter('data');
        if(params == "penghapusan"){
            penghapusan();
        }
        else{
            home();
        }

        $("#btn_copy").click( function(){;
            navigator.clipboard.writeText($("#password_baru").text());
            $('#resetModal').modal('hide');

            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
            };
            toastr.success("Password copied.");
        });

        $('#kategori').on('change', function() {
            if(getUrlParameter('data') == 'penghapusan'){
                dtable = dtableInit("/user/penghapusan/" + this.value);
            }
            else{
                dtable = dtableInit("/user/level/" + this.value);
            }
        });

        $(".home").click(function(){
            home();
        });

        $(".penghapusan").click(function(){
            penghapusan();
        });

        $(".tambah").click( function(){
            $('#tambahModal').modal('show');
        });

        setInterval(function(){
            dtableReload();
        }, 5000);

        var id;
        $(document).on('click', '.reset', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Reset Password ' + nama + ' ?');
            $('.bodies').text('Pilih "Reset" di bawah ini jika anda yakin untuk me-reset password user.');
            $('#ok_button').addClass('btn-danger').removeClass('btn-info').text('Reset');
            $('#confirmValue').val('reset');
            $('#confirmModal').modal('show');
        });

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
            dataset = {
                'id' : id,
                '_token' : token,
            }
            if(value == 'delete'){
                url = "/user/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Hapus";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
            else if(value == 'restore'){
                url = "/user/restore/" + id;
                type = "POST";
                ok_btn_before = "Memulihkan...";
                ok_btn_completed = "Restore";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
            else if(value == 'reset'){
                url = "/user/reset/" + id;
                type = "POST";
                ok_btn_before = "Resetting...";
                ok_btn_completed = "Reset";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
        });

        $('#tambahForm').submit(function(e){
            e.preventDefault();
            url = "/user";
            type = "POST";
            value = "tambah";
            dataset = $(this).serialize();
            ok_btn_before = "Menyimpan...";
            ok_btn_completed = "Simpan";
            ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
        });


        function ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed){
            $.ajax({
                url: url,
                type: type,
                cache:false,
                data: dataset,
                beforeSend:function(){
                    if(value == 'tambah'){
                        $('#save_btn').text(ok_btn_before).prop("disabled",true);
                    }
                    else{
                        $('#ok_button').text(ok_btn_before).prop("disabled",true);
                    }
                },
                success:function(data)
                {
                    if(data.success){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.success(data.success);

                        if(value == 'reset'){
                            $('#password_baru').html(data.pass);
                            $('#resetModal').modal('show');
                        }
                        else if(value == 'tambah'){
                            var selectedLevel = $('#level').val();
                            $("#kategori").val(selectedLevel).change();
                            if(data.status == 'terkirim'){
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.success("Email verifikasi terkirim.");
                            }
                            else if (data.status == 'unchecked'){
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.info("Tanpa kirim email verifikasi.");
                            }
                            else{
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.error("Email verifikasi gagal terkirim.");
                            }
                        }
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
                    dtableReload();
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("Kesalahan Sistem.");
                    console.log(data);
                },
                complete:function(data){
                    if(value == 'tambah'){
                        $('#tambahModal').modal('hide');
                        $('#save_btn').text(ok_btn_completed).prop("disabled",false);
                    }
                    else{
                        $('#confirmModal').modal('hide');
                        $('#ok_button').text(ok_btn_completed).prop("disabled",false);
                    }
                }
            });
        }

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
        }

        function dtableReload(){
            dtable.ajax.reload(function(){
                console.log("Refresh Automatic")
            }, false);
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
            dtable = dtableInit("/user/penghapusan/2");
        }

        function home(){
            $("#kategori").prop('selectedIndex',0)
            $(".page-title").text("User");
            window.history.replaceState(null, null, "?data=user");
            dtable = dtableInit("/user");
        }
    });
</script>
@endsection
