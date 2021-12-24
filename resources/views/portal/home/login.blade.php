<!DOCTYPE html>
<html lang="en">
    <head>
        @include('portal.home.header')

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- CSS for this page --}}
        <link rel="stylesheet" href="{{asset('portal/home/login/style.css')}}"/>
        <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}" type="text/css">
        <link rel="stylesheet" href="{{asset('vendor/fontawesomepro/css/all.min.css')}}" type="text/css">

        {{-- Toastr --}}
        <link rel="stylesheet" type="text/css" href="{{asset('vendor/toastr/toastr.min.css')}}">

        <title>Home | Portal PIC</title>

        @laravelPWA
    </head>
    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form class="sign-in-form" id="loginForm">
                        <h2 class="title">Masuk</h2>
                        <div id="check-uid" class="input-field">
                            <i class="fas fa-user"></i>
                            <input required type="text" maxlength="100" id="uid" name="uid" placeholder="Email / UID" style="text-transform:lowercase;"/>
                        </div>
                        <div id="check-password" class="input-field">
                            <i class="fas fa-lock"></i>
                            <input required type="password" minlength="6" id="passwordLog" name="password" placeholder="Password"/>
                            <i class="fas fa-eye-slash" id="passwordLogShow"></i>
                        </div>
                        <input type="submit" class="btn" value="Submit" />
                        <div>
                            <a href="{{url('email/forgot')}}" style="font-size: 12px;">Lupa Password?</a>
                        </div>
                    </form>
                    <form class="sign-up-form" id="registerForm">
                        <h2 class="title">Daftar</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input required type="text" autocomplete="off" maxlength="100" id="name" name="name" placeholder="Ketikkan Nama"/>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input required type="email" autocomplete="off" maxlength="200" id="email" name="email" placeholder="Ketikkan Email" style="text-transform:lowercase;"/>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input required type="password" minlength="6" id="passwordReg" name="password" placeholder="Ketikkan Password"/>
                            <i class="fas fa-eye-slash" id="passwordRegShow"></i>
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

        {{-- jQuery 3.60 --}}
        <script src="{{asset('portal/home/login/jquery.min.js')}}"></script>

        <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>

        <script src="{{asset('portal/home/login/app.js')}}"></script>
        <script src="{{asset('custom.js')}}"></script>
        <script src="{{asset('vendor/block-ui/jquery.blockUI.js')}}"></script>

        <script>
            $(document).ready(function(){
                $("#uid").focus();
            });

            // let installPromptEvent;

            // window.addEventListener('beforeinstallprompt', (event) => {
            //     // Prevent Chrome <= 67 from automatically showing the prompt
            //     event.preventDefault();
            //     // Stash the event so it can be triggered later.
            //     installPromptEvent = event;
            //     // Update the install UI to notify the user app can be installed
            //     document.querySelector('#install-button').disabled = false;
            // });
            // btnInstall.addEventListener('click', () => {
            //     // Update the install UI to remove the install button
            //     document.querySelector('#install-button').disabled = true;
            //     // Show the modal add to home screen dialog
            //     installPromptEvent.prompt();
            //     // Wait for the user to respond to the prompt
            //     installPromptEvent.userChoice.then(handleInstall);
            // });

            $('#passwordRegShow').on('click touchstart', function(e){
                e.preventDefault();
                if($('#passwordReg').attr('type') == 'password'){
                    $('#passwordReg').prop('type', 'text');
                    $('#passwordRegShow').removeClass('fa-eye-slash').addClass('fa-eye');
                }else{
                    $('#passwordReg').prop('type', 'password');
                    $('#passwordRegShow').addClass('fa-eye-slash').removeClass('fa-eye');
                }
            });

            $('#passwordLogShow').on('click touchstart', function(e){
                e.preventDefault();
                if($('#passwordLog').attr('type') == 'password'){
                    $('#passwordLog').prop('type', 'text');
                    $('#passwordLogShow').removeClass('fa-eye-slash').addClass('fa-eye');
                }else{
                    $('#passwordLog').prop('type', 'password');
                    $('#passwordLogShow').addClass('fa-eye-slash').removeClass('fa-eye');
                }
            });

            $("#uid, #email").on('input', function() {
                this.value = this.value.replace(/\s/g,'');
            });

            $("#name").on("input", function(){
                this.value = this.value.replace(/[^0-9a-zA-Z/\s.,]+$/g, '');
                this.value = this.value.replace(/\s\s+/g, ' ');
            });

            $('#loginForm').on('submit', function(e){
                e.preventDefault();
                callingFunction("login", $(this).serialize());
            });

            $('#registerForm').on('submit', function(e){
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
                            location.href = "/login";
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
                            if(data.description){
                                setTimeout(function() {
                                    location.href = "/profile";
                                }, 1000);
                            }
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

                            location.href = "/register/" + data.description;
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
                            console.log(data);
                        }
                    },
                    complete:function(data){
                        if(type == "login"){
                            $("#loginForm")[0].reset();
                            $("#uid").focus();
                        }
                        else{
                            $("#registerForm")[0].reset();
                            $("#name").focus();
                        }
                        $.unblockUI();
                    }
                });
            }
        </script>

        @include('message.toastr')
    </body>
</html>
