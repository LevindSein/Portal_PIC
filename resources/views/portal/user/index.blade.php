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
        <a class="dropdown-item tambah" href="javascript:void(0)"><i class="fas fa-plus mr-1 ml-1"></i>&nbsp;Tambah User</a>
        <a class="dropdown-item penghapusan" href="javascript:void(0)"><i class="fas fa-trash mr-1 ml-1"></i>&nbsp;Data Penghapusan</a>
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group col-md-2 col-sm-2" style="padding: 0;">
                    <label for="kategori">Pilih Kategori</label>
                    <select class="form-control" id="kategori" name="kategori">
                        @if(Auth::user()->level == 1)
                        <option value="1">Super Admin</option>
                        <option value="2">Admin</option>
                        <option value="4">Kasir</option>
                        <option value="5">Keuangan</option>
                        <option value="6">Manajer</option>
                        @endif
                        <option value="3">Nasabah</option>
                    </select>
                </div>
                <p id="warning-penghapusan" class="text-danger">*) Data Penghapusan akan terhapus secara permanen oleh sistem saat 30 hari sejak akun yang terkait dihapus.</p>
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

<div id="showModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="mt-4 text-center">
                                    <img id="showFoto" class="rounded-circle" width="150" />
                                    <h4 class="card-title mt-2" id="showNama"></h4>
                                    <div class="row text-center justify-content-md-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                    <div class="card-body">
                                        <h3 id="showLevel"></h3>
                                        <h5 id="showSttAktif"></h5>
                                        <small class="text-muted pt-4 db">Username</small>
                                        <h6 id="showUsername"></h6>
                                        <small class="text-muted pt-4 db">No.Anggota</small>
                                        <h6 id="showAnggota"></h6>
                                        <small class="text-muted pt-4 db">Email</small>
                                        <h6 id="showEmail"></h6>
                                        <small class="text-muted pt-4 db">Whatsapp</small>
                                        <h6 id="showPhone"></h6>
                                        <small class="text-muted pt-4 db">Alamat</small>
                                        <h6 id="showAlamat"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="userModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="userForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Role <span class="text-danger">*</span></label>
                        <select class="form-control" id="level" name="level">
                            @if(Auth::user()->level == 1)
                            <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                            <option value="4">Kasir</option>
                            <option value="5">Keuangan</option>
                            <option value="6">Manajer</option>
                            @endif
                            <option value="3">Nasabah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" required autocomplete="off" maxlength="100" placeholder="Alm. H. John Doe, S.pd., MT" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" maxlength="200" required autocomplete="off" placeholder="something@email.com" class="form-control form-control-line" style="text-transform:lowercase;">
                    </div>
                    <div class="form-group">
                        <label>Whatsapp</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">+62</span>
                            </div>
                            <input type="tel" name="phone" id="phone" autocomplete="off" minlength="10" maxlength="12" placeholder="878123xxxxx" class="form-control form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>KTP</label>
                        <input type="tel" id="ktp" name="ktp" autocomplete="off" minlength="16" maxlength="16" placeholder="16 digit nomor KTP" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>NPWP</label>
                        <input type="tel" id="npwp" name="npwp" autocomplete="off" minlength="15" maxlength="15" placeholder="15 digit nomor NPWP" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea rows="5" id="alamat" name="alamat" autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control form-control-line">{{Auth::user()->alamat}}</textarea>
                    </div>
                    <div class="form-group" id="otoritasDiv">
                        <label>Otoritas <span class="text-danger">*</span></label>
                        <select class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" id="blok" name="blok[]"></select>
                        <div class="text-center form-group">
                            <strong>Pilih Pengelolaan :</strong>
                        </div>
                        <div class="form-group col-lg-12 justify-content-between" style="display: flex;flex-wrap: wrap;">
                            <div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="registrasi"
                                        value="registrasi">
                                    <label class="form-control-label" for="registrasi">
                                        Layn.Registrasi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="pedagang"
                                        value="pedagang">
                                    <label class="form-control-label" for="pedagang">
                                        Layn.Pedagang
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="tempatusaha"
                                        value="tempatusaha">
                                    <label class="form-control-label" for="tempatusaha">
                                        Layn.Tempat Usaha
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="pembongkaran"
                                        value="pembongkaran">
                                    <label class="form-control-label" for="pembongkaran">
                                        Layn.Pembongkaran
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="tagihan"
                                        value="tagihan">
                                    <label class="form-control-label" for="tagihan">
                                        Kelola Tagihan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="simulasi"
                                        value="simulasi">
                                    <label class="form-control-label" for="simulasi">
                                        Simulasi Tagihan
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="pemakaian"
                                        value="pemakaian">
                                    <label class="form-control-label" for="pemakaian">
                                        Lap.Pemakaian
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="pendapatan"
                                        value="pendapatan">
                                    <label class="form-control-label" for="pendapatan">
                                        Lap.Pendapatan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="tunggakan"
                                        value="tunggakan">
                                    <label class="form-control-label" for="tunggakan">
                                        Lap.Tunggakan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="datausaha"
                                        value="datausaha">
                                    <label class="form-control-label" for="datausaha">
                                        Data Usaha
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="alatmeter"
                                        value="alatmeter">
                                    <label class="form-control-label" for="alatmeter">
                                        Alat Meter
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="tarif"
                                        value="tarif">
                                    <label class="form-control-label" for="tarif">
                                        Tarif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="kelola[]"
                                        id="harilibur"
                                        value="harilibur">
                                    <label class="form-control-label" for="harilibur">
                                        Hari Libur
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>(<span class="text-danger">*</span>) wajib diisi.</p>
                    </div>
                    <div class="custom-control custom-checkbox mr-sm-2 mb-3" id="divCheckEmail">
                        <input type="checkbox" class="custom-control-input" id="checkEmail" name="checkEmail" value="checked" onclick="return false">
                        <label class="custom-control-label" for="checkEmail">Kirim Email Verifikasi</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="userFormValue"/>
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
        var id;
        var params = getUrlParameter('data');

        if(params == "penghapusan"){
            penghapusan();
        }
        else{
            home();
        }

        $(".home").click(function(){
            home();
        });

        $(".penghapusan").click(function(){
            penghapusan();
        });

        setInterval(function(){
            dtableReload();
        }, 5000);

        $("#level").on('change', function(){
            var level = $("#level").val();
            if(level == '2'){
                $("#otoritasDiv").show();
                select2custom("#blok", "/cari/blok", "-- Pilih Kelompok --");
                $("#blok").prop("required",true);
            }
            else{
                $("#otoritasDiv").hide();
                $("#blok").prop("required",false);
            }
        });

        $('[type=tel]').on('change', function(e) {
            $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
        });

        $('[type=tel]').on('keypress', function(e) {
            keys = ['0','1','2','3','4','5','6','7','8','9']
            return keys.indexOf(e.key) > -1
        });

        $("#username, #email").on('input', function(key) {
            var value = $(this).val();
            $(this).val(value.replace(/ /g, '_'));
        });
        $("#phone").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });

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

        $(".tambah").click( function(){
            $("#userForm")[0].reset();
            $("#otoritasDiv").hide();
            $('.titles').text('Tambah User');
            $('#divCheckEmail').show();
            $('#checkEmail').prop("checked", true);
            $("#userFormValue").val('tambah');
            $('#userModal').modal('show');

            $("#blok").prop("required",false);
        });

        $(document).on('click', '.edit', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $("#userForm")[0].reset();
            $('.titles').text('Edit data ' + nama);
            $('#divCheckEmail').hide();
            $('#checkEmail').prop("checked", false);
            $("#userFormValue").val('update');

            $("#blok").prop("required",false);

            $.ajax({
                url: "/user/" + id + "/edit",
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#name").val(data.user.name);
                        $("#email").val(data.user.email);
                        $("#phone").val(data.user.phone);
                        $("#ktp").val(data.user.ktp);
                        $("#npwp").val(data.user.npwp);
                        $("#alamat").val(data.user.alamat);
                        $("#level").val(data.user.level).change();

                        if(data.user.level == 2){
                            var json = JSON.parse(data.user.otoritas);

                            for (var k in json.otoritas) {
                                if (json.otoritas.hasOwnProperty(k)) {
                                    if(json.otoritas[k] == false){
                                        $("#" + k).prop("checked",false);
                                    }
                                }
                            }

                            var s1 = $("#blok").select2();
                            var value = json.blok;
                            value.forEach(function(e){
                                if(!s1.find('option:contains(' + e + ')').length)
                                    s1.append($('<option>').text(e));
                            });
                            s1.val(value).trigger("change");
                            select2custom("#blok", "/cari/blok", "-- Pilih Kelompok --");
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
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("Gagal mengambil data.");
                    console.log(data);
                },
                complete:function(){
                    $('#userModal').modal('show');
                }
            });
        });

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

        $(document).on('click', '.deletePermanently', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Hapus permanen data ' + nama + ' ?');
            $('.bodies').text('Pilih "Permanen" di bawah ini jika anda yakin untuk menghapus data user secara permanen.');
            $('#ok_button').addClass('btn-danger').removeClass('btn-info').text('Permanen');
            $('#confirmValue').val('deletePermanently');
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

        $(document).on('click', '.details', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Informasi ' + nama);

            var rand = shuffle('1234567890');

            $.ajax({
                url: "/user/" + id,
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#showFoto").attr('src', '/' + data.user.foto + '?' + rand);
                        $("#showLevel").text(data.user.level);
                        $("#showSttAktif").html(data.user.stt_aktif);
                        $("#showUsername").text(data.user.username);
                        $("#showNama").text(data.user.name);
                        $("#showAnggota").text(data.user.anggota);

                        if(data.user.email)
                            $("#showEmail").html("<a target='_blank' href='mailto:" + data.user.email + "'>" + data.user.email + " <i class='fas fa-external-link'></i></a>");
                        else
                            $("#showEmail").html("&mdash;");
                        if(data.user.phone)
                            $("#showPhone").html("<a target='_blank' href='https://wa.me/62" + data.user.phone + "'>+62" + data.user.phone + " <i class='fas fa-external-link'></i></a>");
                        else
                            $("#showPhone").html("&mdash;");

                        $("#showAlamat").text(data.user.alamat);
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
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("Gagal mengambil data.");
                    console.log(data);
                },
                complete:function(){
                    $('#showModal').modal('show');
                }
            });
        });

        $('#userForm').submit(function(e){
            e.preventDefault();
            value = $("#userFormValue").val();
            if(value == 'tambah'){
                url = "/user";
                type = "POST";
            }
            else if(value == 'update'){
                url = "/user/" + id;
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
                url = "/user/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Hapus";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
            else if(value == 'deletePermanently'){
                url = "/user/permanen/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Permanen";
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
                    if(value == 'tambah' || value == 'update'){
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
                        else if(value == 'tambah' || value == 'update'){
                            var selectedLevel = $('#level').val();
                            $("#kategori").val(selectedLevel).change();
                            $(".page-title").text("User");
                            window.history.replaceState(null, null, "?data=user");
                            dtable = dtableInit("/user/level/" + selectedLevel);
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
                        toastr.error("Kesalahan Sistem.");
                    }
                    console.log(data);
                },
                complete:function(data){
                    if(value == 'tambah' || value == 'update'){
                        $('#userModal').modal('hide');
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

        function shuffle(string) {
            var parts = string.split('');
            for (var i = parts.length; i > 0;) {
                var random = parseInt(Math.random() * i);
                var temp = parts[--i];
                parts[i] = parts[random];
                parts[random] = temp;
            }
            return parts.join('');
        }

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
                                    id: d.nama,
                                    text: d.nama
                                }
                            })
                        };
                    },
                }
            });
        }

        function penghapusan(){
            $("#kategori").prop('selectedIndex',0)
            $(".page-title").text("Data Penghapusan");
            window.history.replaceState(null, null, "?data=penghapusan");
            dtable = dtableInit("/user/penghapusan/1");
            $('#warning-penghapusan').show();
        }

        function home(){
            $("#kategori").prop('selectedIndex',0)
            $(".page-title").text("User");
            window.history.replaceState(null, null, "?data=user");
            dtable = dtableInit("/user");
            $('#warning-penghapusan').hide();
        }
    });
</script>
@endsection
