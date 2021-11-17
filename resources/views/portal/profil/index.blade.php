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
                    <div class="image-hover-text-container" id="changePhoto">
                        <div class="image-hover-image">
                            <img src="{{asset(Auth::user()->foto)}}?{{$rand}}" class="rounded-circle" width="150" />
                        </div>
                        <div class="image-hover-text">
                            <div class="image-hover-text-bubble">
                                <span style="font-size:12px;">Click to Change</span>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mt-2">{{Auth::user()->name}}</h4>
                    <div class="row text-center justify-content-md-center">
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <small class="text-muted pt-4 db">No.Anggota</small>
                <h6>{{Auth::user()->anggota}}</h6>
                @if(Auth::user()->phone)
                <small class="text-muted pt-4 db">Email</small>
                <h6>{{Auth::user()->email}}</h6>
                @endif
                @if(Auth::user()->phone)
                <small class="text-muted pt-4 db">Whatsapp</small>
                <h6>+62{{Auth::user()->phone}}</h6>
                @endif
                @if(Auth::user()->alamat)
                <small class="text-muted pt-4 db">Alamat</small>
                <h6>{{Auth::user()->alamat}}</h6>
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
                        aria-selected="true">Personal Data
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
                        <form id="profilForm" class="form-horizontal form-material">
                            <div class="form-group">
                                <label class="col-md-12">Username (untuk Login) <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" id="username" name="username" required autocomplete="off" maxlength="50" placeholder="Username" value="{{Auth::user()->username}}" class="form-control form-control-line" style="text-transform:lowercase;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" name="name" required autocomplete="off" maxlength="100" placeholder="Alm. H. John Doe, S.pd., MT" value="{{Auth::user()->name}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Email <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="email" id="email" name="email" maxlength="200" required autocomplete="off" placeholder="something@email.com" value="{{Auth::user()->email}}" class="form-control form-control-line" style="text-transform:lowercase;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Whatsapp</label>
                                <div class="col-md-12 input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">+62</span>
                                    </div>
                                    <input type="tel" name="phone" id ="phone" autocomplete="off" minlength="10" maxlength="12" placeholder="878123xxxxx" value="{{Auth::user()->phone}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">KTP <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="tel" id="ktp" name="ktp" required autocomplete="off" minlength="16" maxlength="16" placeholder="16 digit nomor KTP" value="{{Auth::user()->ktp}}" class="form-control form-control-line">
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
                                    <textarea rows="5" id="alamat" name="alamat" required autocomplete="off" placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control form-control-line">{{Auth::user()->alamat}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password saat ini <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="password" name="password" required autocomplete="off" minlength="6" placeholder="Ketikkan password saat ini" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password Baru</label>
                                <div class="col-md-12">
                                    <input type="password" name="passwordBaru" minlength="6" autocomplete="off" placeholder="Ketikkan jika ingin ubah password" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Konfirmasi Password Baru</label>
                                <div class="col-md-12">
                                    <input type="password" name="konfirmasiPasswordBaru" minlength="6" autocomplete="off" placeholder="Ulangi password baru" class="form-control form-control-line">
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
<div id="photoModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <form action="{{url('profil/foto')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input" name="fotoInput" id="fotoInput" accept=".png, .jpg, .jpeg">
                                    <label class="custom-file-label" for="fotoInput">Choose file .jpg, .jpeg, .png</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-rounded btn-info">Upload</button>
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

        $("#changePhoto").click(function(){
            $("#photoModal").modal("show");
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

        $("#profilForm").submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/profil",
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
                        setTimeout(() => {
                            location.reload();
                        }, 300);
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
                        console.log(data);
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
                        toastr.error("Kesalahan Sistem.");
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
