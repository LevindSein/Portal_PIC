@extends("portal.layout.master")

@section('content-title')
Profil
@endsection

@section('content-body')
<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="mt-4 text-center">
                    <div class="image-hover-text-container" id="changePicture">
                        <div class="image-hover-image">
                            <img src="{{asset(Auth::user()->photo)}}?{{$rand}}" class="rounded-circle" width="150" />
                        </div>
                        <div class="image-hover-text">
                            <div class="image-hover-text-bubble">
                                <span style="font-size:12px;">Click to Change</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center justify-content-md-center">
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <small class="text-muted pt-4 db">UID</small>
                <h6>{{Auth::user()->uid}}</h6>
                <small class="text-muted pt-4 db">Nama Lengkap</small>
                <h6>{{Auth::user()->name}}</h6>
                <small class="text-muted pt-4 db">No.Anggota</small>
                <h6>{{Auth::user()->member}}</h6>
                @if(Auth::user()->email)
                <small class="text-muted pt-4 db">Email</small>
                <h6>{{Auth::user()->email}}</h6>
                @endif
                @if(Auth::user()->phone)
                <small class="text-muted pt-4 db">Handphone</small>
                <h6><span id="showCountry"></span> {{Auth::user()->phone}}</h6>
                </span>
                @endif
                @if(Auth::user()->address)
                <small class="text-muted pt-4 db">Alamat</small>
                <h6>{{Auth::user()->address}}</h6>
                @endif
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Tabs -->
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="pills-timeline-tab"
                        data-toggle="pill"
                        href="#settings"
                        role="tab"
                        aria-controls="pills-timeline"
                        aria-selected="true">Data Diri
                    </a>
                </li>
                {{-- @if(Auth::user()->level == 3)
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="pills-timeline-tab"
                        data-toggle="pill"
                        href="#riwayat"
                        role="tab"
                        aria-controls="pills-timeline"
                        aria-selected="true">Riwayat Pembayaran
                    </a>
                </li>
                @endif --}}
            </ul>
            <!-- Tabs -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="pills-timeline-tab">
                    <div class="card-body">
                        <form id="profileForm" class="form-horizontal form-material">
                            <div class="form-group">
                                <label class="col-md-12">UID <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" id="uid" name="uid" required autocomplete="off" maxlength="15" placeholder="UID" value="{{Auth::user()->uid}}" class="form-control form-control-line" style="text-transform:lowercase;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" id="name" name="name" required autocomplete="off" maxlength="100" placeholder="Alm. H. John Doe, S.pd., MT" value="{{Auth::user()->name}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Email <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="email" id="email" name="email" maxlength="200" required autocomplete="off" placeholder="something@email.com" value="{{Auth::user()->email}}" class="form-control form-control-line" style="text-transform:lowercase;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Handphone <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="hidden" id="country" name="country" />
                                    <input id="phone" name="phone" type="tel" autocomplete="off" minlength="8" maxlength="15" placeholder="878123xxxxx" value="{{Auth::user()->phone}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">KTP / Paspor <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input required type="tel" id="ktp" name="ktp" required autocomplete="off" minlength="7" maxlength="16" placeholder="16 digit nomor KTP" value="{{Auth::user()->ktp}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">NPWP</label>
                                <div class="col-md-12">
                                    <input type="tel" id="npwp" name="npwp" autocomplete="off" minlength="15" maxlength="15" placeholder="15 digit nomor NPWP" value="{{Auth::user()->npwp}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Alamat <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <textarea rows="5" id="address" name="address" required autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control form-control-line">{{Auth::user()->address}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password saat ini <span class="text-danger">*</span></label>
                                <div class="col-md-12 input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-eye-slash" id="passwordShow"></i></span>
                                    </div>
                                    <input type="password" id="password" name="password" required autocomplete="off" minlength="6" placeholder="Ketikkan password saat ini" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password Baru</label>
                                <div class="col-md-12 input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-eye-slash" id="passwordNewShow"></i></span>
                                    </div>
                                    <input type="password" id="passwordNew" name="passwordNew" minlength="6" autocomplete="off" placeholder="Ketikkan jika ubah password" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p>(<span class="text-danger">*</span>) wajib diisi.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" id="save_btn" class="btn btn-success btn-rounded">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="tab-pane fade show active" id="riwayat" role="tabpanel" aria-labelledby="pills-timeline-tab">
                    <div class="card-body">
                        Under Constructions
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@endsection

@section('content-modal')
<div id="pictureModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <form action="{{url('profile/picture')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input" id="pictureInput" name="pictureInput" accept=".png, .jpg, .jpeg">
                                    <label class="custom-file-label" for="pictureInput">Pilih Berkas .jpg, .jpeg, .png</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-rounded btn-info">Unggah</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-js')
<script>
    $(document).ready(function(){
        const fileBlocks = document.querySelectorAll('.custom-file');
        [...fileBlocks].forEach(function (block) {
            block.querySelector('input[type="file"]').onchange = function () {
                const filename = this.files[0].name;
                block.querySelector('.custom-file-label').textContent = filename.slice(0, 30);
            }
        });

        $("#passwordNewShow").click(function(){
            if($('#passwordNew').attr('type') == 'password'){
                $('#passwordNew').prop('type', 'text');
                $('#passwordNewShow').removeClass('fa-eye-slash').addClass('fa-eye');
            }else{
                $('#passwordNew').prop('type', 'password');
                $('#passwordNewShow').addClass('fa-eye-slash').removeClass('fa-eye');
            }
        });

        $("#passwordShow").click(function(){
            if($('#password').attr('type') == 'password'){
                $('#password').prop('type', 'text');
                $('#passwordShow').removeClass('fa-eye-slash').addClass('fa-eye');
            }else{
                $('#password').prop('type', 'password');
                $('#passwordShow').addClass('fa-eye-slash').removeClass('fa-eye');
            }
        });

        $("#changePicture").click(function(){
            $("#pictureModal").modal("show");
        });

        $('[type=tel]').on('change', function(e) {
            $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''));
        });

        $('[type=tel]').on('keypress', function(e) {
            keys = ['0','1','2','3','4','5','6','7','8','9'];
            return keys.indexOf(e.key) > -1;
        });

        $("#uid").on("input", function(){
            this.value = this.value.replace(/[^0-9a-zA-Z/\w_]+$/g, '');
            this.value = this.value.replace(/\s/g, '_');
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

        $.ajax({
            url: "/search/countries",
            type: "GET",
            cache: false,
            success: function(data){
                initializeTel(data.iso);
                $("#showCountry").text("+" + data.phonecode);
            },
            error: function(data){
                console.log(data);
            }
        });

        $("#profileForm").submit(function(e){
            e.preventDefault();

            var country = iti.getSelectedCountryData();
            $("#country").val(country.iso2);

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/profile",
                type: "POST",
                cache: false,
                data: $(this).serialize(),
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
                        if(data.description){
                            setTimeout(() => {
                                location.reload();
                            }, 300);
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
                    $.unblockUI();
                }
            });
        });
    });
</script>
@endsection
