<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="keyword" content="Pasar Bandung, Pasar Tradisional, Pasar Induk, Caringin, Pasar Induk Caringin Kota Bandung"/>
        <meta name="author" content="Pasar Induk Caringin Kota Bandung"/>
        <meta name="description"content="Login untuk Member Area Pasar Induk Caringin Kota Bandung" />
        <meta property="og:site_name" content="Pasar Induk Caringin Kota Bandung">
        <meta property="og:title" content="Pasar Induk Caringin Kota Bandung" />
        <meta property="og:description" content="Login untuk Member Area Pasar Induk Caringin Kota Bandung" />
        <meta property="og:image" itemprop="image" content="{{asset('portal/home/login/img/favicon.png')}}">
        <meta property="og:type" content="website" />
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
        <link rel="icon" sizes="16x16 32x32 64x64" href="{{asset('img/favicon.png')}}">
        <link rel="icon" sizes="196x196" href="{{asset('img/favicon.png')}}">
        <link rel="icon" sizes="160x160" href="{{asset('img/favicon.png')}}">
        <link rel="icon" sizes="96x96" href="{{asset('img/favicon.png')}}">
        <link rel="icon" sizes="64x64" href="{{asset('img/favicon.png')}}">
        <link rel="icon" sizes="32x32" href="{{asset('img/favicon.png')}}">
        <link rel="icon" sizes="16x16" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{asset('img/favicon.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon.png')}}">
        <meta name="google" content="notranslate">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- CSS for this page --}}
        <link rel="stylesheet" href="{{asset('portal/home/login/style.css')}}"/>
        <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}" type="text/css">
        <link rel="stylesheet" href="{{asset('vendor/fontawesomepro/css/all.min.css')}}" type="text/css">

        {{-- jQuery 3.60 --}}

        <script src="{{asset('portal/home/login/jquery.min.js')}}"></script>

        {{-- Toastr --}}
        <link rel="stylesheet" type="text/css" href="{{asset('vendor/toastr/toastr.min.css')}}">
        <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>

        <title>Home | Portal PIC</title>
    </head>
    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form class="sign-in-form" id="form_login">
                        <h2 class="title">Masuk</h2>
                        <div id="check-username" class="input-field">
                            <i class="fas fa-user"></i>
                            <input required type="text" maxlength="100" id="username" name="username" placeholder="Username/Email" style="text-transform:lowercase;"/>
                        </div>
                        <div id="check-password" class="input-field">
                            <i class="fas fa-lock"></i>
                            <input required type="password" minlength="6" name="password" placeholder="Password"/>
                        </div>
                        <input type="submit" class="btn" value="Submit" />
                    </form>
                    <form class="sign-up-form" id="form_register">
                        <h2 class="title">Daftar</h2>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input required type="email" autocomplete="off" maxlength="100" id="email" name="email" placeholder="Masukkan Email" style="text-transform:lowercase;"/>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input required type="password" minlength="6" name="password" placeholder="Ketikkan Password"/>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input required type="password" minlength="6" name="ulangiPassword" placeholder="Ulangi Password"/>
                        </div>
                        <input type="submit" class="btn" value="Submit"/>
                    </form>
                </div>
            </div>

            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>Ingin Bergabung ?</h3>
                        <p>Dapatkan banyak manfaat menjadi member dari Pasar Induk Caringin Kota Bandung</p>
                        <button class="btn transparent" id="sign-up-btn">Daftar</button>
                    </div>
                    <img src="{{asset('portal/home/login/img/login.svg')}}" class="image" alt="Pasar Induk Caringin Kota Bandung"/>
                </div>
                <div class="panel right-panel">
                    <div class="content">
                        <h3>Sudah Terdaftar ?</h3>
                        <p>Segera masuk dan temukan manfaat menjadi member di Pasar Induk Caringin Kota Bandung</p>
                        <button class="btn transparent" id="sign-in-btn">Masuk</button>
                    </div>
                    <img src="{{asset('portal/home/login/img/register.svg')}}" class="image" alt="Pasar Induk Caringin Kota Bandung"/>
                </div>
            </div>
        </div>

        <script src="{{asset('portal/home/login/app.js')}}"></script>
        <script src="{{asset('custom.js')}}"></script>
        <script>
            $(document).ready(function(){
                $("#username").focus();

                $('#username, #email').on('keypress', function ( event ) {
                    var key = event.keyCode;
                    if (key === 32) {
                        $(this).val(key.replace(/ /g, '_'));
                    }
                });

                $("#username, #email").on('input', function(key) {
                    var value = $(this).val();
                    $(this).val(value.replace(/ /g, '_'));
                });


                $('#form_login').on('submit', function(e){
                    e.preventDefault();
                    callingFunction("login", $(this).serialize());
                });

                $('#form_register').on('submit', function(e){
                    e.preventDefault();
                    callingFunction("register", $(this).serialize());
                });

                function callingFunction(type, data){
                    if(type == "login"){
                        url = "/login";
                    }
                    else{
                        url = "/register";
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: url,
                        cache: false,
                        method: "POST",
                        data: data,
                        dataType: "json",
                        success:function(data)
                        {
                            if(data.success){
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.success(data.success);
                                location.href = "/login";
                            }
                            else if(data.warning){
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.warning(data.warning);
                            }
                            else if(data.info){
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.info(data.info);
                            }
                            else if(data.error){
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.error(data.error);
                            }
                            else if(data.register){
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.success("Selesaikan Registrasi.");
                                location.href = "/register/" + data.register;
                            }
                            else{
                                toastr.options = {
                                    "closeButton": true,
                                    "preventDuplicates": true,
                                };
                                toastr.error("Kesalahan sistem.");
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
                                toastr.error("Kesalahan sistem.");
                                console.log(data);
                            }
                        },
                        complete:function(data){
                            if(type == "login"){
                                $("#form_login")[0].reset();
                                $("#username").focus();
                            }
                            else{
                                $("#form_register")[0].reset();
                                $("#email").focus();
                            }
                        }
                    });
                }
            });
        </script>

        @include('message.toastr')
    </body>
</html>
