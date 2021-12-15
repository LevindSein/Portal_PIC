<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    @include('portal.home.header')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon.png')}}">
    <title>@yield('content-title') | Portal PIC</title>

    {{-- Select2 --}}
    <link rel="stylesheet" type="text/css" href="https://gistcdn.githack.com/LevindSein/f7c69066795ad91de5aabd3e257021b7/raw/869e04587bc9562c030de473491b4e3dc907a289/select2.min.css">

    <link rel="stylesheet" href="{{asset('vendor/intTelInput/build/css/intlTelInput.css')}}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('template/dist/css/style.min.css')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('vendor/fontawesomepro/css/all.min.css')}}" type="text/css">

    {{-- Datatable --}}
    <link rel="stylesheet" href="{{asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">

    {{-- Toastr --}}
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/toastr/toastr.min.css')}}">
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
                    <a class="navbar-brand" href="javascript:void(0)">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="{{asset("img/favicon.png")}}" width="50" height="40" class="dark-logo" />
                        </b>
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
                    <ul class="navbar-nav float-left mr-auto" id="sidebarType">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="javascript:void(0)"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <img
                                    src="{{asset(Auth::user()->photo)}}?{{$rand}}"
                                    alt="user"
                                    class="rounded-circle" width="31">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated fadeIn">
                                <span class="with-arrow">
                                    <span class="bg-light"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-light text-white mb-2">
                                    <div class=""><img src="{{asset(Auth::user()->photo)}}?{{$rand}}" alt="user" class="img-circle"
                                            width="60"></div>
                                    <div class="ml-2">
                                        <h4 class="text-dark mb-0">{{Auth::user()->name}}</h4>
                                        <p class="text-dark mb-0">{{Auth::user()->email}}</p>
                                        <p class="text-dark mb-0">{{Auth::user()->telephone}}</p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{url('profile')}}">
                                    <i class="fas fa-user mr-1 ml-1"></i>
                                    <span>Profil</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('logout')}}">
                                    <i class="fad fa-sign-out-alt mr-1 ml-1 text-danger"></i>
                                    <span class="text-danger">Logout</span>
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
                            <a href="javascript:void(0)" class="btn btn-block create-btn text-white no-block d-flex align-items-center">
                                <i class="fas fa-check-square"></i>
                                <span class="hide-menu ml-1">&nbsp;Bayar&nbsp;Tagihan</span>
                            </a>
                        </li>
                        @if(Auth::user()->level != 3)
                        <li class="sidebar-item {{ (request()->is('production/dashboard*')) ? 'bg-light' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark {{ (request()->is('production/dashboard*')) ? 'active' : '' }}" href="{{url('production/dashboard')}}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard mr-1 text-info"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="fad fa-user-headset mr-1 text-info"></i>
                                <span class="hide-menu">Layanan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{url('#')}}" class="sidebar-link waves-effect waves-dark">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Registrasi</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{url('#')}}" class="sidebar-link waves-effect waves-dark">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Pembongkaran</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ (request()->is('production/users*')) ? 'bg-light' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark {{ (request()->is('production/users*')) ? 'active' : '' }}" href="{{url('production/users')}}" aria-expanded="false">
                                <i class="fas fa-users mr-1 text-info"></i>
                                <span class="hide-menu">Pengguna</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ (request()->is('production/point*')) ? 'bg-light' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark {{ (request()->is('production/point*')) ? 'active' : '' }}" href="{{url('production/point/stores')}}" aria-expanded="false">
                                <i class="fas fa-building mr-1 text-info"></i>
                                <span class="hide-menu">Tempat&nbsp;Usaha</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ (request()->is('production/prices*')) ? 'bg-light' : '' }}">
                            <a class="sidebar-link has-arrow waves-effect waves-dark {{ (request()->is('production/prices*')) ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false">
                                <i class="far fa-pi mr-1 text-info"></i>
                                <span class="hide-menu">Rumusan&nbsp;Tarif</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ (request()->is('production/prices*')) ? 'in' : '' }}">
                                <li class="sidebar-item">
                                    <a href="{{url('production/prices/listrik')}}" class="sidebar-link waves-effect waves-dark {{ (request()->is('production/prices/listrik*')) ? 'active' : '' }}">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Listrik</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{url('production/prices/airbersih')}}" class="sidebar-link waves-effect waves-dark {{ (request()->is('production/prices/airbersih*')) ? 'active' : '' }}">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Air&nbsp;Bersih</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{url('production/prices/keamananipk')}}" class="sidebar-link waves-effect waves-dark {{ (request()->is('production/prices/keamananipk*')) ? 'active' : '' }}">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Keamanan&nbsp;IPK</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{url('production/prices/kebersihan')}}" class="sidebar-link waves-effect waves-dark {{ (request()->is('production/prices/kebersihan*')) ? 'active' : '' }}">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Kebersihan</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{url('production/prices/airkotor')}}" class="sidebar-link waves-effect waves-dark {{ (request()->is('production/prices/airkotor*')) ? 'active' : '' }}">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Air&nbsp;Kotor</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{url('production/prices/lain')}}" class="sidebar-link waves-effect waves-dark {{ (request()->is('production/prices/lain*')) ? 'active' : '' }}">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Lainnya</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ (request()->is('production/manage*')) ? 'bg-light' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark {{ (request()->is('production/manage*')) ? 'active' : '' }}" href="{{url('production/manage/bills')}}" aria-expanded="false">
                                <i class="fad fa-file-invoice mr-1 text-info"></i>
                                <span class="hide-menu">Kelola&nbsp;Tagihan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{url('#')}}" aria-expanded="false">
                                <i class="far fa-rocket-launch mr-1 text-info"></i>
                                <span class="hide-menu">Potensi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="fad fa-book mr-1 text-info"></i>
                                <span class="hide-menu">Laporan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{url('#')}}" class="sidebar-link waves-effect waves-dark">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Pemakaian</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{url('#')}}" class="sidebar-link waves-effect waves-dark">
                                        <i class="mdi mdi-adjust mr-1 text-success"></i>
                                        <span class="hide-menu">Pendapatan</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ (request()->is('production/histories*')) ? 'bg-light' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark {{ (request()->is('production/histories*')) ? 'active' : '' }}" href="{{url('production/histories')}}" aria-expanded="false">
                                <i class="fad fa-clock mr-1 text-info"></i>
                                <span class="hide-menu">Riwayat&nbsp;Login</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ (request()->is('production/changelogs*')) ? 'bg-light' : '' }}">
                            <a class="sidebar-link waves-effect waves-dark {{ (request()->is('production/changelogs*')) ? 'active' : '' }}" href="{{url('production/changelogs')}}" aria-expanded="false">
                                <i class="fas fa-info mr-1 text-info"></i>
                                <span class="hide-menu">Changelog</span>
                            </a>
                        </li>
                        @endif

                        <hr class="hide-menu">

                        <li class="nav-small-cap"></li>
                        <div class="text-center">
                            <a class="hide-menu text-danger" href="{{url('logout')}}">
                                <i class="fad fa-sign-out-alt mr-1 ml-1"></i>
                                Logout
                            </a>
                        </div>

                        <li class="nav-small-cap"></li>
                        <div class="text-center">
                            <span class="hide-menu text-muted">Version 3.0.1</span>
                        </div>
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
            @if(is_null(Auth::user()->email_verified_at))
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

                <div id="firstCome" class="modal fade" role="dialog" tabIndex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title titles">UPGRADE VERSION 3.0</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-lg-6 col-xlg-6">
                                        <div class="mt-4 text-center">
                                            <img src="{{asset('img/upgrade.svg')}}" width="150" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xlg-6">
                                        <h3>Apa yang baru ?</h3>
                                        <h5>Banyak Hal di versi 3.0</h5>
                                        <h6><i class="fad fa-arrow-up"></i> Simple User Interface</h6>
                                        <h6><i class="fad fa-arrow-up"></i> Performance</h6>
                                        <h6><i class="fad fa-arrow-up"></i> Security</h6>
                                        <h6><i class="fad fa-arrow-up"></i> Feature</h6>
                                        <h6><i class="fad fa-arrow-up"></i> Bug Fixed</h6>
                                        <small class="text-muted pt-4 db">Released on 12.2021</small>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button data-dismiss="modal" class="btn btn-success btn-rounded">Mengerti</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="confirmModal" class="modal fade" role="dialog" tabIndex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title titles">{title}</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
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
               &copy;2021 PT.Pengelola Pusat Perdagangan Caringin
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
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('template/dist/js/waves.min.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('template/dist/js/sidebarmenu.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('template/dist/js/custom.min.js')}}"></script>

    <script src="{{asset('custom.js')}}"></script>

    <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>

    <script src="{{asset('vendor/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>

    <script src="{{asset('vendor/select2/dist/js/select2.min.js')}}"></script>

    <script src="{{asset('vendor/block-ui/jquery.blockUI.js')}}"></script>

    <script src="{{asset('vendor/intTelInput/build/js/intlTelInput.js')}}"></script>

    @if(!in_array(Auth::user()->id, explode(',', request()->cookie('first_come'))))
    <script>
        $(document).ready(function(){
            setTimeout(() => {
                $("#firstCome").modal('show');
            }, 2000);
        });
    </script>
    @endif

    <script>
        $(window).on('load', function() {
            $(".se-pre-con").fadeIn("slow").fadeOut("slow");
        });

        // notifyForThisMinute(); // First call starts process
        // function notifyForThisMinute() {
        //     // Notify user of things we should notify them of as of this minute
        //     // ...
        //     $.ajax({
        //         url: "/notification/bill/reviews",
        //         type: "GET",
        //         cache:false,
        //         success:function(data)
        //         {
        //             if(data.success){
        //                 console.log(data.success);
        //             }
        //         },
        //         error:function(data){
        //             console.log(data);
        //         }
        //     });

        //     // Schedule next check for beginning of next minute; always wait
        //     // until we're a second into the minute to make the checks easier
        //     setTimeout(notifyForThisMinute, (61 - new Date().getSeconds()) * 1000);
        // }

        $(document).ready(function(){
            // $.fn.dataTable.ext.errMode = 'none';
            // $('#dtable').on('error.dt', function(e, settings, techNote, message) {
            //     console.log( 'An error has been reported by DataTables: ', message);
            // })

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
                    $(".tooltip").tooltip("hide");
                }, 1000);
            });

            setInterval(() => {
                var email = localStorage.getItem("email");
                if(email == 'terverifikasi'){
                    localStorage.setItem("email", null);
                    location.reload();
                }
            }, 60000);

            $("#emailResend").click( function(e){
                e.preventDefault();
                $.ajax({
                    url: "/email/verify/resend",
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
                            setTimeout(function() {
                                location.href = "/profile";
                            }, 1000);
                        }
                    },
                    error:function(data){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error("System error.");
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
