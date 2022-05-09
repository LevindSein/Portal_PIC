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
        <title>@yield('content-title') @include('Layout.Partial._title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

        {{-- Global Theme Styles (used by all pages) --}}
        @foreach(config('layout.resources.css') as $style)
            <link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach

        @laravelPWA

        <style>
            .se-pre-con {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url('../../images/pulse.gif') center no-repeat #fff;
            }
        </style>
    </head>

    <body>
        <div class="se-pre-con"></div>
        <!-- Sidenav -->
        <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
            <div class="scrollbar-inner">
                <!-- Brand -->
                <div class="sidenav-header d-flex align-items-center">
                    <a class="navbar-brand" href="javascript:void(0)">
                        <span class="sidebar-brand-text mx-2 text-primary"><b>
                        @if(Session::get('level') == 1)
                        SUPER
                        @elseif(Session::get('level') == 2)
                        ADMIN
                        @elseif(Session::get('level') == 3)
                        KASIR
                        @elseif(Session::get('level') == 4)
                        KEUANGAN
                        @else
                        MANAJER
                        @endif
                        </b>
                        </span>
                    </a>
                    <div class="ml-auto">
                        <!-- Sidenav toggler -->
                        <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="navbar-inner">
                    <!-- Collapse -->
                    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                        <!-- Nav items -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('dashboard*')) ? 'active' : '' }}" href="{{url('dashboard')}}">
                                    <i class="fas fa-fw fa-tachometer-alt text-primary mr-2"></i>
                                    <span class="nav-link-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('service*')) ? 'active' : '' }}" href="#navbar-layanan" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('service*')) ? 'true' : 'false' }}" aria-controls="navbar-layanan">
                                    <i class="fas fa-fw fa-user-headset text-primary mr-2"></i>
                                    <span class="nav-link-text">Layanan</span>
                                </a>
                                <div class="collapse {{ (request()->is('service*')) ? 'show' : '' }}" id="navbar-layanan">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Registrasi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Pedagang</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Tempat Usaha</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Pembongkaran</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Kasir / Pembayaran</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('tagihan*')) ? 'active' : '' }}" href="javascript:void(0)">
                                    <i class="fad fa-fw fa-coins text-primary mr-2"></i>
                                    <span class="nav-link-text">Tagihan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('laporan*')) ? 'active' : '' }}" href="#navbar-laporan" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('laporan*')) ? 'true' : 'false' }}" aria-controls="navbar-laporan">
                                    <i class="fas fa-fw fa-book text-primary mr-2"></i>
                                    <span class="nav-link-text">Laporan</span>
                                </a>
                                <div class="collapse {{ (request()->is('laporan*')) ? 'show' : '' }}" id="navbar-laporan">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Pemakaian</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Pendapatan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Tunggakan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Usaha</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('utilities*')) ? 'active' : '' }}" href="#navbar-utilities" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('utilities*')) ? 'true' : 'false' }}" aria-controls="navbar-utilities">
                                    <i class="fad fa-fw fa-tools text-primary mr-2"></i>
                                    <span class="nav-link-text">Utilities</span>
                                </a>
                                <div class="collapse {{ (request()->is('utilities*')) ? 'show' : '' }}" id="navbar-utilities">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Tarif</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Alat Meter</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Jatuh Tempo</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Simulasi</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('potensi*')) ? 'active' : '' }}" href="javascript:void(0)">
                                    <i class="fas fa-fw fa-rocket text-primary mr-2"></i>
                                    <span class="nav-link-text">Potensi</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('users*')) ? 'active' : '' }}" href="{{url('users')}}">
                                    <i class="fad fa-fw fa-users text-primary mr-2"></i>
                                    <span class="nav-link-text">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('riwayat*')) ? 'active' : '' }}" href="javascript:void(0)">
                                    <i class="fas fa-fw fa-history text-primary mr-2"></i>
                                    <span class="nav-link-text">Activities</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('changelogs*')) ? 'active' : '' }}" href="javascript:void(0)">
                                    <i class="fad fa-fw fa-cogs text-primary mr-2"></i>
                                    <span class="nav-link-text">Changelogs</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Main content -->
        <div class="main-content" id="panel">
            <!-- Topnav -->
            <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Search form -->
                        <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                            <div class="form-group mb-0">
                                <div class="input-group input-group-alternative input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Search" type="text">
                                </div>
                            </div>
                            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </form>
                        <!-- Navbar links -->
                        <ul class="navbar-nav align-items-center ml-md-auto">
                            <li class="nav-item d-xl-none">
                                <!-- Sidenav toggler -->
                                <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                                    <div class="sidenav-toggler-inner">
                                        <i class="sidenav-toggler-line"></i>
                                        <i class="sidenav-toggler-line"></i>
                                        <i class="sidenav-toggler-line"></i>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item d-sm-none">
                                <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                    <i class="ni ni-zoom-split-in"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder" src="{{asset('assets/img/theme/team-4.jpg')}}">
                                    </span>
                                    <div class="media-body ml-2 d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">{{substr(Auth::user()->name, 0, 20)}}</span>
                                    </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javacript:void(0)" class="dropdown-item">
                                        <i class="ni ni-single-02"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <a href="javacript:void(0)" class="dropdown-item">
                                        <i class="ni ni-settings-gear-65"></i>
                                        <span>Settings</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0)" id="logout" class="dropdown-item">
                                        <i class="ni ni-user-run"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header -->
            <!-- Header -->
            <div class="header bg-primary pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-8 col-5">
                                <!-- Judul -->
                                <h6 class="h2 text-white d-inline-block mb-0">@yield('content-title')</h6>
                            </div>
                            <div class="col-lg-4 col-7 text-right" id="content-button">
                                <div class="d-flex align-items-center">
                                    @yield('content-button')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container-fluid mt--6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card py-4 px-4">
                            @yield('content-body')
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

        @yield('content-modal')

        <script>
            $(document).ready(function() {
                $.fn.dataTable.ext.errMode = 'none';
                $('#dtable').on('error.dt', function(e, settings, techNote, message) {
                    alert("Datatable system error.");
                    console.log( 'An error has been reported by DataTables: ', message);
                });

                // Hide Tooltip after clicked in 500 milliseconds
                $(document).on('click', '[data-toggle="tooltip"]', function(){
                    setTimeout(() => {
                        $(this).tooltip('hide');
                    }, 500);
                });
            });

            $(window).on('load', function() {
                $(".se-pre-con").fadeIn("slow").fadeOut("slow");
            });

            $(document).on('click', '#logout', function(e){
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/logout',
                    cache: false,
                    method: "POST",
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
                            location.href = "/login";
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
                        toastr.error("System error.");
                        console.log(data);
                    },
                    complete:function(data){
                        $.unblockUI();
                    }
                });
            });

            setInterval(() => {
                $.ajax({
                    url: '/check',
                    cache: false,
                    method: "GET",
                    dataType: "json",
                    success:function(data)
                    {
                        if(data.logout){
                            location.href = '/login';
                        }
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
            }, 1000);

            $("#content-button").show();
        </script>

        @yield('content-js')

        @include('Layout.Partial._message')
    </body>

</html>
