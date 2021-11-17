<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="keyword"
        content="Pasar Bandung, Pasar Tradisional, Pasar Induk, Caringin, Pasar Induk Caringin Kota Bandung" />
    <meta name="author" content="Pasar Induk Caringin Kota Bandung" />
    <meta name="description" content="Login untuk Member Area Pasar Induk Caringin Kota Bandung" />
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
    <meta name="robots" content="noindex, nofollow" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon.png')}}">
    <title>@yield('content-title') | Portal PIC</title>

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
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="se-pre-con"></div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="#">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{asset("img/favicon.png")}}" width="50" height="40" class="dark-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        {{-- <span class="logo-text"> --}}
                            <!-- dark Logo text -->
                            {{-- <img src="{{asset("img/logo.png")}}" width="90" height="20" class="dark-logo" /> --}}
                        {{-- </span> --}}
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell font-24"></i>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated fadeIn">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span></span>
                                <ul class="list-style-none">
                                    <li>
                                        <div class="drop-title bg-primary text-white">
                                            <h4 class="mb-0 mt-1">(Angka) (Baru)</h4>
                                            <span class="font-light">Notifikasi</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center notifications">
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="message-item">
                                                <span class="btn btn-danger btn-circle">
                                                    <i class="fa fa-link"></i>
                                                </span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">(Judul Notif)</h5>
                                                    <span class="mail-desc">(Just see the my new admin!)</span>
                                                    <span class="time">(9:30 AM)</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center mb-1 text-dark" href="javascript:void(0);">
                                            <strong>Semua Notifikasi</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="javascript:void(0)"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="{{asset(Auth::user()->foto)}}?{{$rand}}" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated fadeIn">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span></span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white mb-2">
                                    <div class=""><img src="{{asset(Auth::user()->foto)}}?{{$rand}}" alt="user" class="img-circle"
                                            width="60"></div>
                                    <div class="ml-2">
                                        <h4 class="mb-0">{{Auth::user()->name}}</h4>
                                        <p class=" mb-0">{{Auth::user()->email}}</p>
                                        <p class=" mb-0">{{Auth::user()->telephone}}</p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{url('profil')}}">
                                    <i class="fas fa-user mr-1 ml-1"></i>
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" oncontextmenu="return false;"
                                    onclick="location.href = '/logout' ">
                                    <i class="fas fa-power-off mr-1 ml-1"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="p-15 mt-1">
                            @if(Auth::user()->level != 3)
                            <a href="javascript:void(0)"
                                class="btn btn-block create-btn text-white no-block d-flex align-items-center">
                                <i class="fas fa-plus-square"></i>
                                <span class="hide-menu ml-1">&nbsp;Tambah&nbsp;Tagihan</span>
                            </a>
                            @endif
                            <a href="javascript:void(0)"
                                class="btn btn-block create-btn text-white no-block d-flex align-items-center">
                                <i class="fas fa-check-square"></i>
                                <span class="hide-menu ml-1">&nbsp;Bayar&nbsp;Tagihan</span>
                            </a>
                        </li>
                        @if(Auth::user()->level != 3)
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ (request()->is('production/dashboard*')) ? 'active' : '' }}" href="{{url('production/dashboard')}}"
                                aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a
                                class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fad fa-user-headset"></i>
                                <span class="hide-menu">Layanan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Registrasi</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Pedagang</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Tempat&nbsp;Usaha</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Pembongkaran</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('#')}}"
                                aria-expanded="false">
                                <i class="fad fa-file-invoice"></i>
                                <span class="hide-menu">Kelola&nbsp;Tagihan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a
                                class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fad fa-book"></i>
                                <span class="hide-menu">Laporan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Pemakaian</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Pendapatan</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Tunggakan</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('#')}}"
                                aria-expanded="false">
                                <i class="fad fa-clipboard-list"></i>
                                <span class="hide-menu">Data&nbsp;Usaha</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a
                                class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="fad fa-tools"></i>
                                <span class="hide-menu">Utilities</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Tarif</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Alat&nbsp;Meter</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="index.html" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu">Hari&nbsp;Libur</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ (request()->is('production/user*')) ? 'active' : '' }}" href="{{url('production/user')}}"
                                aria-expanded="false">
                                <i class="fas fa-user"></i>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ (request()->is('production/riwayat-login*')) ? 'active' : '' }}" href="{{url('production/riwayat-login')}}"
                                aria-expanded="false">
                                <i class="fad fa-clock"></i>
                                <span class="hide-menu">Riwayat&nbsp;Login</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('#')}}"
                                aria-expanded="false">
                                <i class="fas fa-clipboard-check"></i>
                                <span class="hide-menu">Changelog</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('#')}}"
                                aria-expanded="false">
                                <i class="fad fa-box-open"></i>
                                <span class="hide-menu">Kotak&nbsp;Saran</span>
                            </a>
                        </li>
                        @endif
                        <li class="nav-small-cap"></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            @if(Auth::user()->email_verified_at == NULL)
            <div class="alert alert-warning alert-block text-center" id="warning-alert">
                <strong>Email Anda belum diverifikasi!</strong> Silakan verifikasi email anda, <a href="javascript:void(0)" id="emailResend">disini</a>.
            </div>
            @endif
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">@yield('content-title')</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <div>
                                @yield('content-button')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('content-body')

                @yield('content-modal')

                <div id="confirmModal" class="modal fade" role="dialog" tabIndex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title titles">{title}</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body bodies">{body}</div>
                            <form id="confirmForm">
                                <div class="modal-footer">
                                    <input type="hidden" id="confirmValue" value="">
                                    <button type="submit" name="ok_button" id="ok_button" class="btn">{Button}</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <br>
            <footer class="footer text-center">
                Copyright &copy;2020 PT.Pengelola Pusat Perdagangan Caringin
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
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
            $(".sidebartoggler").click(function(){
                var adjust = setInterval(() => {
                    var adjust = $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                }, 10);
                setTimeout(() => {
                    clearInterval(adjust);
                }, 1000);
            });

            $(document).on('shown.bs.tooltip', function (e) {
                setTimeout(function () {
                    $(e.target).tooltip('hide');
                }, 1000);
            });
            setInterval(function(){
                setTimeout(function(){
                    $(".tooltip").tooltip("hide");
                }, 1000);
            }, 10000);

            setInterval(() => {
                var email = localStorage.getItem("email");
                if(email == 'terverifikasi'){
                    localStorage.setItem("email", null);
                    location.reload();
                }
            }, 5000);

            $("#emailResend").click( function(e){
                e.preventDefault();
                $.ajax({
                    url: "/email/verify/resend/",
                    type: "GET",
                    cache:false,
                    beforeSend:function(){
                        $("#emailResend").text('mengirim email verifikasi . . ').removeAttr("href");
                    },
                    success:function(data)
                    {
                        if(data.success){
                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                            };
                            toastr.success(data.success);
                        }
                        else if(data.exception){
                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                            };
                            toastr.error("Data gagal diproses.");
                            console.log(data.exception);
                        }
                        else if(data.warning){
                            toastr.options = {
                                "closeButton": true,
                                "preventDuplicates": true,
                            };
                            toastr.warning(data.warning);
                            setTimeout(function() {
                                location.href = "/profil";
                            }, 1000);
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
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error("Kesalahan Sistem.");
                        console.log(data);
                    },
                    complete:function(data){
                        $("#emailResend").text('disini').attr("href", "javascript:void(0)");
                    }
                });
            });
        });
    </script>

    @include('message.toastr')

    @yield('content-js')
</body>

</html>
