<!-- =========================================================
* Argon Dashboard PRO v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro
* Copyright 2019 Creative Tim (https://www.creative-tim.com)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 -->
<!DOCTYPE html>
<html>
    <head>
        <title>Login @include('Layout.Partial._title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

        {{-- Global Theme Styles (used by all pages) --}}
        @foreach(config('layout.resources.css') as $style)
            <link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach

        @laravelPWA
    </head>

    <body class="bg-default">
        <!-- Main content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header bg-gradient-primary py-7 pt-9">
                <div class="separator separator-bottom separator-skew zindex-100">
                    <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                    </svg>
                </div>
            </div>

            <!-- Page content -->
            <div class="container mt--8 pb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <div class="card bg-secondary border-0 mb-0">
                            <div class="card-header bg-transparent pb-5">
                                <div class="text-muted text-center mt-2 mb-3">
                                    <img src="{{asset('images/logo.png')}}" />
                                </div>
                            </div>
                            <div class="card-body px-lg-5 py-lg-3">
                                <form role="form" id="formAction">
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-laptop"></i></span>
                                            </div>
                                            <input required type="text" maxlength="100" id="username" name="username" placeholder="Username" class="name form-control" style="text-transform:lowercase;"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input required type="password" minlength="6" id="password" name="password" placeholder="password" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary my-4">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Argon Scripts -->
        {{-- Global Theme JS Bundle (used by all pages)  --}}
        @foreach(config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach

        <script>
            $(document).ready(function(){
                $("#username").focus();
            });

            $("#username").on('input change keydown', function(e) {
                $(this).val($(this).val().replace(/\s/g,''));
            });

            $('#formAction').on('submit', function(e){
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/login',
                    cache: false,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend:function(){
                        $.blockUI({
                            message: '<i class="fas fa-spin fa-spinner"></i>',
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
                            location.reload();
                        }

                        if(data.info){
                            toastr.info(data.info);
                        }

                        if(data.warning){
                            toastr.warning(data.warning);
                        }

                        if(data.error){
                            toastr.error(data.error);
                        }

                        if(data.debug){
                            console.log(data.debug);
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
                            console.log(data);
                        }
                    },
                    complete:function(data){
                        $("#formAction")[0].reset();
                        $("#username").focus();
                        $.unblockUI();
                    }
                });
            });
        </script>

        @include('Layout.Partial._message')
    </body>
 </html>
