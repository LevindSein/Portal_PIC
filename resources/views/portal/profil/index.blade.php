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
                <div class="mt-4 text-center"> <img src="{{Auth::user()->foto}}" class="rounded-circle" width="150" />
                    <h4 class="card-title mt-2">{{Auth::user()->name}}</h4>
                    <div class="row text-center justify-content-md-center">
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <small class="text-muted">Email</small>
                <h6>{{Auth::user()->email}}</h6>
                @if(Auth::user()->phone)
                <small class="text-muted pt-4 db">Whatsapp</small>
                <h6>+{{Auth::user()->phone}}</h6>
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
                        href="#current-month"
                        role="tab"
                        aria-controls="pills-timeline"
                        aria-selected="true">Pengaturan
                    </a>
                </li>
            </ul>
            <!-- Tabs -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                    <div class="card-body">
                        <form id="profilForm" class="form-horizontal form-material" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12">Ganti Foto</label>
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Foto Profil</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="fotoInput" id="fotoInput" accept=".png, .jpg, .jpeg">
                                            <label class="custom-file-label" for="fotoInput">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Username (untuk Login) <span style="color: red">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" id="username" name="username" required autocomplete="off" maxlength="50" placeholder="Username" value="{{Auth::user()->username}}" class="form-control form-control-line" style="text-transform:lowercase;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Nama Lengkap <span style="color: red">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" name="name" required autocomplete="off" maxlength="50" placeholder="Nama Lengkap" value="{{Auth::user()->name}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Email <span style="color: red">*</span></label>
                                <div class="col-md-12">
                                    <input type="email" id="email" name="email" maxlength="100" required autocomplete="off" placeholder="something@email.com" value="{{Auth::user()->email}}" class="form-control form-control-line" style="text-transform:lowercase;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Whatsapp (62xx)</label>
                                <div class="col-md-12">
                                    <input type="tel" name="phone" id ="phone" autocomplete="off" pattern="[\d]{10-15}" minlength="10" maxlength="15" placeholder="62xx" value="{{Auth::user()->phone}}" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Alamat <span style="color: red">*</span></label>
                                <div class="col-md-12">
                                    <textarea rows="5" name="alamat" required autocomplete="off"placeholder="Ketikkan Alamat disini" maxlength="255" class="form-control form-control-line">{{Auth::user()->alamat}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password <span style="color: red">*</span></label>
                                <div class="col-md-12">
                                    <input type="password" name="password" required autocomplete="off" minlength="6" placeholder="Ketikkan password saat ini" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Password Baru</label>
                                <div class="col-md-12">
                                    <input type="password" name="passwordBaru" minlength="6" autocomplete="off" placeholder="Ketikkan jika ingin mengubah password lama" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Konfirmasi Password Baru</label>
                                <div class="col-md-12">
                                    <input type="password" name="konfirmasiPasswordBaru" minlength="6" autocomplete="off" placeholder="Konfirmasi password baru" class="form-control form-control-line">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-rounded">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@endsection

@section('content-js')
<script>
    const fileBlocks = document.querySelectorAll('.custom-file');
    [...fileBlocks].forEach(function (block) {
        block.querySelector('input[type="file"]').onchange = function () {
            const filename = this.files[0].name;
            block.querySelector('.custom-file-label').textContent = filename.slice(0, 30);
        }
    })
</script>

<script>
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
    })
</script>
@endsection
