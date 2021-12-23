<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    @include('portal.home.header')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon.png')}}">
    <title>Forgot Password | Portal PIC</title>

    <script src="{{asset('template/assets/libs/jquery/dist/jquery.min.js')}}"></script>

    {{-- Select2 --}}
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/dist/css/select2.min.css')}}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('template/dist/css/style.min.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('vendor/fontawesomepro/css/all.min.css')}}" type="text/css">

    {{-- Datatable --}}
    <link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">

    {{-- Toastr --}}
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/toastr/toastr.min.css')}}">
    <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="se-pre-con"></div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style='background:url("{{asset('img/auth-bg.jpg')}}") no-repeat center center;'>
            <div class="auth-box">
                <div>
                    <div class="logo">
                        <span class="db">
                            <img src="{{asset('img/favicon.png')}}" width="50" alt="logo BP3C" />
                        </span>
                        <h5 class="font-medium mb-3">Recover Password</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal mt-3" id="resetForm">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <input class="form-control form-control-lg" required type="text" maxlength="100" id="email" name="email" placeholder="Email" style="text-transform:lowercase;"/>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 pb-3">
                                        <button class="btn btn-block btn-info btn-rounded" type="submit">Reset</button>
                                    </div>
                                    <a href="{{url('logout')}}" class="u-btn u-button-style u-none u-text-custom-color-2 u-text-hover-custom-color-1 u-btn-3">
                                        <i class="fas fa-chevron-left"></i>&nbsp;Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('template/assets/libs/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('template/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('template/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- apps -->
    <script src="{{asset('template/dist/js/app.min.js')}}"></script>
    <script src="{{asset('template/dist/js/app.init.js')}}"></script>
    <script src="{{asset('template/dist/js/app-style-switcher.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('template/assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('template/dist/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('template/dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('template/dist/js/custom.min.js')}}"></script>

    <script src="{{asset('custom.js')}}"></script>

    <script src="{{asset('vendor/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>

    <script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>

    <script src="{{asset('vendor/block-ui/jquery.blockUI.js')}}"></script>

    <script>
        $(window).on('load', function() {
            $(".se-pre-con").fadeIn("slow").fadeOut("slow");
        });

        $(document).ready(function(){
            $("#email").focus();
        });

        $('#resetForm').on('submit', function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/email/forgot/email",
                cache: false,
                method: "POST",
                data: $(this).serialize(),
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
                        if(data.description){
                            setTimeout(() => {
                                location.reload();
                            }, 300);
                        }
                    }

                    if(data.error){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error(data.error);
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

                    if(data.info){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.info(data.info);
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
                        console.log(data);
                    }
                },
                complete:function(data){
                    $.unblockUI();
                    $("#resetForm")[0].reset();
                    $("#email").focus();
                }
            });
        });
    </script>

    @include('message.toastr')
</body>

</html>
