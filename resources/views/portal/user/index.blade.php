@extends('portal.layout.master')

@section('content-title')
Pengguna
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
        <a class="dropdown-item add" href="javascript:void(0)">
            <i class="fas fa-fw fa-plus mr-1 ml-1"></i>
            <span>Tambah User</span>
        </a>
        <a class="dropdown-item deleted" href="javascript:void(0)">
            <i class="fas fa-fw fa-trash mr-1 ml-1"></i>
            <span>Data Penghapusan</span>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item registered" href="javascript:void(0)">
            <i class="fas fa-fw fa-user-plus mr-1 ml-1"></i>
            <span>Data Pendaftar</span>
        </a>
        <a class="dropdown-item activation" href="javascript:void(0)">
            <i class="fad fa-fw fa-barcode-read fa-swap-opacity mr-1 ml-1"></i>
            <span>Aktivasi Pendaftaran</span>
        </a>
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
                    <select class="form-control" id="category" name="category">
                        <option value="3">Nasabah</option>
                        @if(Auth::user()->level == 1)
                        <option value="2">Organisator</option>
                        <option value="1">Super Admin</option>
                        @endif
                    </select>
                </div>
                <p id="warning-deleted" class="text-danger">*) Data Penghapusan akan terhapus secara permanen oleh sistem saat 30 hari sejak akun yang terkait dihapus.</p>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>UID</th>
                                <th>Name</th>
                                <th>Status</th>
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
                    <h1><b><span id="newPassword"></span></b></h1>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" id="btn_copy" class="btn btn-success">Click for Copy!</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="activationModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kode Aktivasi</h5>
                <button class="close activationClose" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <p class="text-danger">Harap <b>Jangan di Tutup</b> sebelum QR Code terotentikasi. Apabila tertutup, lakukan <b>Aktivasi Pendaftaran</b> kembali.</p>
                </div>
                <div class="text-center">
                    <p>Kode Aktivasi :</p>
                    <h1><b><span id="activation_code"></span></b></h1>
                </div>
                <div>
                    <p>1. Buka aplikasi <b>QR Code Scanner</b> yang anda miliki.</p>
                    <p>2. Lakukan <b>scanning</b> pada QR Code yang dimiliki Customer.</p>
                    <p>3. Kunjungi <b>situs</b> yang terbaca oleh QR Code Scanner.</p>
                    <p>4. Masukkan <b>Kode Aktivasi</b> di atas.</p>
                    <p>5. Kode Aktivasi <b>valid</b> selama <b>15 menit & 1x Pakai.</b></p>
                    <p>6. Jika sukses, terdapat status <b>kode aktivasi terkirim</b>
                    <p>7. Selesaikan registrasi di aplikasi Portal PIC</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light activationClose" data-dismiss="modal">Tutup</button>
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
                    <div class="col-lg-5 col-xlg-5">
                        <div class="form-group mt-4 text-center">
                            <img id="showPicture" class="rounded-circle" width="150" />
                            <div class="row text-center justify-content-md-center">
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 id="showLevel"></h3>
                            <h5 id="showActive"></h5>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-7 col-xlg-7">
                        <small class="text-muted pt-4 db">UID</small>
                        <h6 id="showUid"></h6>
                        <small class="text-muted pt-4 db">Nama Lengkap</small>
                        <h6 id="showName"></h6>
                        <small class="text-muted pt-4 db">No.Anggota</small>
                        <h6 id="showMember"></h6>
                        <small class="text-muted pt-4 db">KTP / Paspor</small>
                        <h6 id="showKtp"></h6>
                        <small class="text-muted pt-4 db">NPWP</small>
                        <h6 id="showNpwp"></h6>
                        <small class="text-muted pt-4 db">Email</small>
                        <h6 id="showEmail"></h6>
                        <small class="text-muted pt-4 db">Handphone</small>
                        <h6 id="showPhone"></h6>
                        <small class="text-muted pt-4 db">Alamat</small>
                        <h6 id="showAddress"></h6>
                        <small class="text-muted pt-4 db">Dibuat pada</small>
                        <h6 id="showCreate"></h6>
                        <small class="text-muted pt-4 db">Diperbaharui pada</small>
                        <h6 id="showUpdate"></h6>
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
                        <label>Pilih Ketegori <span class="text-danger">*</span></label>
                        <select class="form-control" id="level" name="level">
                            <option value="3">Nasabah</option>
                            @if(Auth::user()->level == 1)
                            <option value="2">Organisator</option>
                            <option value="1">Super Admin</option>
                            @endif
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
                        <label>Handphone <span class="text-danger">*</span></label>
                        <input type="hidden" id="country" name="country" />
                        <input id="phone" name="phone" type="tel" autocomplete="off" minlength="8" maxlength="15" placeholder="878123xxxxx" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>KTP / Paspor <span class="text-danger">*</span></label>
                        <input required type="tel" id="ktp" name="ktp" autocomplete="off" minlength="16" maxlength="16" placeholder="16 digit nomor KTP" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>NPWP</label>
                        <input type="tel" id="npwp" name="npwp" autocomplete="off" minlength="15" maxlength="15" placeholder="15 digit nomor NPWP" class="form-control form-control-line">
                    </div>
                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea required rows="5" id="address" name="address" autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control form-control-line"></textarea>
                    </div>
                    <div class="form-group" id="authorityDiv">
                        <label>Otoritas <span class="text-danger">*</span></label>
                        <select class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" id="group" name="group[]"></select>
                        <div class="text-center form-group">
                            <strong>Privileged :</strong>
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
                        <input type="checkbox" class="custom-control-input" id="checkEmail" name="checkEmail" value="checked">
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

        if(getUrlParameter('data') !== false)
            init(getUrlParameter('data'), 3);
        else
            init(1, 3);

        $(".registered").click(function(){
            init(2, 3);
        });

        $(".home").click(function(){
            init(1, 3);
        });

        $(".deleted").click(function(){
            init(0, 3);
        });

        function init(active, level){
            $("#category").prop('selectedIndex',0)
            if(active == 2){
                $(".page-title").text("Data Pendaftar");
                $('#warning-deleted').hide();
            }
            else if(active == 1){
                $(".page-title").text("Pengguna Aktif");
                $('#warning-deleted').hide();
            }
            else{
                $(".page-title").text("Data Penghapusan");
                $('#warning-deleted').show();
            }

            window.history.replaceState(null, null, "?data=" + active + "&lev=" + level);
            dtable = dtableInit("/production/users?data=" + active + "&lev=" + level);
        }

        var iti;
        function initializeTel(init) {
            iti = window.intlTelInput(document.querySelector("#phone"), {
                initialCountry: init,
                preferredCountries: ['id'],
                formatOnDisplay: false,
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
            });
        }
        initializeTel("id");

        var intervalAktivasi;
        $(".activation").click(function(){
            $.ajax({
                url: "/production/users/code/activate",
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#activation_code").text(data.result.code);
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
                    intervalAktivasi = setInterval(() => {
                        $.ajax({
                            url: "/production/users/activate/verify",
                            type: "GET",
                            cache:false,
                            success:function(data){
                                if(data.success){
                                    toastr.options = {
                                        "closeButton": true,
                                        "preventDuplicates": true,
                                    };
                                    toastr.success(data.success);
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

                                    setTimeout(() => {
                                        $.unblockUI();
                                        location.href = '/production/service/register?data=' + data.result;
                                    }, 2000);
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
                                console.log(data);
                            }
                        });
                    }, 1000);
                    $('#activationModal').modal('show');
                },
            });
        });

        $(".activationClose").click(function(){
            clearInterval(intervalAktivasi);
        });

        $("#level").on('change', function(){
            var level = $("#level").val();
            if(level == '2'){
                $("#authorityDiv").show();
                select2custom("#group", "/search/groups", "-- Pilih Kelompok --");
                $("#group").prop("required",true);
            }
            else{
                $("#authorityDiv").hide();
                $("#group").prop("required",false);
            }
        });

        $('[type=tel]').on('change', function(e) {
            $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
        });

        $('[type=tel]').on('keypress', function(e) {
            keys = ['0','1','2','3','4','5','6','7','8','9']
            return keys.indexOf(e.key) > -1
        });

        $("#email").on('input', function() {
            this.value = this.value.replace(/\s/g, '');
        });
        $("#phone").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "");
            }
        });

        $("#name").on("input", function(){
            this.value = this.value.replace(/[^0-9a-zA-Z/\s.,]+$/g, '');
            this.value = this.value.replace(/\s\s+/g, ' ');
        });

        $("#btn_copy").click( function(){;
            navigator.clipboard.writeText($("#newPassword").text());
            $('#resetModal').modal('hide');

            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
            };
            toastr.success("Password copied.");
        });

        $('#category').on('change', function() {
            dtable = dtableInit("/production/users?data=" + getUrlParameter('data') + "&lev=" + this.value);
        });

        $(".add").click( function(){
            $("#userForm")[0].reset();
            $("#authorityDiv").hide();
            $('.titles').text('Tambah User');
            $('#divCheckEmail').show();
            $('#checkEmail').prop("checked", true);
            $("#userFormValue").val('add');
            iti.destroy();
            initializeTel("id");
            $('#userModal').modal('show');

            $("#group").prop("required",false);
        });

        $(document).on('click', '.edit', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $("#userForm")[0].reset();
            $('.titles').text('Edit data ' + nama);
            $('#divCheckEmail').hide();
            $('#checkEmail').prop("checked", false);
            $("#userFormValue").val('update');

            $("#group").prop("required",false);

            $.ajax({
                url: "/production/users/" + id + "/edit",
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#name").val(data.user.name);
                        $("#email").val(data.user.email);
                        iti.destroy();
                        initializeTel(data.user.iso);
                        $("#phone").val(data.user.phone);
                        $("#ktp").val(data.user.ktp);
                        $("#npwp").val(data.user.npwp);
                        $("#address").val(data.user.address);
                        $("#level").val(data.user.level).change();

                        if(data.user.level == 2){
                            var json = JSON.parse(data.user.authority);

                            for (var k in json.authority) {
                                if (json.authority.hasOwnProperty(k)) {
                                    if(json.authority[k] == false){
                                        $("#" + k).prop("checked",false);
                                    }
                                }
                            }

                            var s1 = $("#group").select2();
                            var value = json.group;
                            value.forEach(function(e){
                                if(!s1.find('option:contains(' + e + ')').length)
                                    s1.append($('<option>').text(e));
                            });
                            s1.val(value).trigger("change");
                            select2custom("#group", "/search/groups", "-- Pilih Kelompok --");
                        }
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

        $(document).on('click', '.activateUser', function(){
            id = $(this).attr('id');
            location.href = '/production/service/register?data=' + id;
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
                url: "/production/users/" + id,
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#showPicture").attr('src', '/' + data.user.photo + '?' + rand);
                        $("#showLevel").text(data.user.level);
                        $("#showActive").html(data.user.active);
                        $("#showUid").text(data.user.uid);
                        $("#showName").text(data.user.name);
                        $("#showMember").text(data.user.member);
                        $("#showCreate").text(data.user.create);
                        $("#showUpdate").text(data.user.update);

                        (data.user.ktp) ? $("#showKtp").html(data.user.ktp) : $("#showKtp").html("&mdash;");

                        (data.user.npwp) ? $("#showNpwp").html(data.user.npwp) : $("#showNpwp").html("&mdash;");

                        (data.user.email) ? $("#showEmail").html("<a target='_blank' href='mailto:" + data.user.email + "'>" + data.user.email + " <i class='fas fa-external-link'></i></a>") : $("#showEmail").html("&mdash;");

                        (data.user.phone) ? $("#showPhone").html("<a target='_blank' href='https://api.whatsapp.com/send?phone=" + data.user.phone + "'>+" + data.user.phone + " <i class='fas fa-external-link'></i></a>") : $("#showPhone").html("&mdash;");

                        (data.user.address) ? $("#showAddress").html(data.user.address) : $("#showAddress").html("&mdash;");
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

        $('#userForm').submit(function(e){
            e.preventDefault();
            var country = iti.getSelectedCountryData();
            $("#country").val(country.iso2);
            value = $("#userFormValue").val();
            if(value == 'add'){
                url = "/production/users";
                type = "POST";
            }
            else if(value == 'update'){
                url = "/production/users/" + id;
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
                url = "/production/users/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Hapus";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
            else if(value == 'deletePermanently'){
                url = "/production/users/permanent/" + id;
                type = "DELETE";
                ok_btn_before = "Menghapus...";
                ok_btn_completed = "Permanen";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
            else if(value == 'restore'){
                url = "/production/users/restore/" + id;
                type = "POST";
                ok_btn_before = "Memulihkan...";
                ok_btn_completed = "Restore";
                ajaxForm(url, type, value, dataset, ok_btn_before, ok_btn_completed);
            }
            else if(value == 'reset'){
                url = "/production/users/reset/" + id;
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

                        if(value == 'reset'){
                            $('#newPassword').html(data.pass);
                            $('#resetModal').modal('show');
                        }
                        else if(value == 'add' || value == 'update'){
                            var selectedLevel = $('#level').val();
                            $("#category").val(selectedLevel).change();
                            $(".page-title").text("Pengguna Aktif");
                            window.history.replaceState(null, null, "?data=1&lev=" + selectedLevel);
                            dtable = dtableInit("/production/users?data=1&lev=" + selectedLevel);
                            $('#warning-deleted').hide();
                        }
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
                        toastr.error("System error.");
                    }
                    console.log(data);
                },
                complete:function(data){
                    if(value == 'add' || value == 'update'){
                        if(JSON.parse(data.responseText).success)
                            $('#userModal').modal('hide');
                    }
                    else{
                        $('#confirmModal').modal('hide');
                    }
                    $.unblockUI();
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
                    { data: 'uid', name: 'uid', class : 'text-center' },
                    { data: 'name', name: 'name', class : 'text-center' },
                    { data: 'active', name: 'active', class : 'text-center' },
                    { data: 'action', name: 'action', class : 'text-center' },
                ],
                "stateSave": true,
                "deferRender": true,
                "pageLength": 10,
                "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [3] },
                    { "bSearchable": false, "aTargets": [2,3] }
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

        setInterval(function(){
            dtableReload();
        }, 5000);

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
        }

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
                                    id: d.name,
                                    text: d.name
                                }
                            })
                        };
                    },
                }
            });
        }
    });
</script>
@endsection
