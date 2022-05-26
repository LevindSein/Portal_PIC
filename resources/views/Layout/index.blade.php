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
                                <a class="nav-link {{ (request()->is('dashboard*')) ? 'active font-weight-bold' : '' }}" href="{{url('dashboard')}}">
                                    <i class="fas fa-fw fa-tachometer-alt text-primary mr-2"></i>
                                    <span class="nav-link-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('services*')) ? 'active font-weight-bold' : '' }}" href="#navbar-layanan" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('services*')) ? 'true' : 'false' }}" aria-controls="navbar-layanan">
                                    <i class="fas fa-fw fa-user-headset text-primary mr-2"></i>
                                    <span class="nav-link-text">Layanan</span>
                                </a>
                                <div class="collapse {{ (request()->is('services*')) ? 'show' : '' }}" id="navbar-layanan">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Registrasi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link ml-3">Pedagang</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('services/place')}}" class="nav-link ml-3 {{ (request()->is('services/place*') || request()->is('services/group*')) ? 'text-primary font-weight-bold' : '' }}">Tempat Usaha</a>
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
                                <a class="nav-link {{ (request()->is('tagihan*')) ? 'active font-weight-bold' : '' }}" href="javascript:void(0)">
                                    <i class="fad fa-fw fa-coins text-primary mr-2"></i>
                                    <span class="nav-link-text">Tagihan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('laporan*')) ? 'active font-weight-bold' : '' }}" href="#navbar-laporan" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('laporan*')) ? 'true' : 'false' }}" aria-controls="navbar-laporan">
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
                                <a class="nav-link {{ (request()->is('utilities*')) ? 'active font-weight-bold' : '' }}" href="#navbar-utilities" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('utilities*')) ? 'true' : 'false' }}" aria-controls="navbar-utilities">
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
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('analytics*')) ? 'active font-weight-bold' : '' }}" href="#navbar-analytics" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('analytics*')) ? 'true' : 'false' }}" aria-controls="navbar-analytics">
                                    <i class="fad fa-fw fa-rocket text-primary mr-2"></i>
                                    <span class="nav-link-text">Analitis</span>
                                </a>
                                <div class="collapse {{ (request()->is('analytics*')) ? 'show' : '' }}" id="navbar-analytics">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{url('analytics/potention')}}" class="nav-link ml-3 {{ (request()->is('analytics/potention*')) ? 'text-primary font-weight-bold' : '' }}">Potensi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('analytics/simulation')}}" class="nav-link ml-3 {{ (request()->is('analytics/simulation*')) ? 'text-primary font-weight-bold' : '' }}">Simulasi Tagihan</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('users*')) ? 'active font-weight-bold' : '' }}" href="{{url('users')}}">
                                    <i class="fad fa-fw fa-users text-primary mr-2"></i>
                                    <span class="nav-link-text">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('activities*')) ? 'active font-weight-bold' : '' }}" href="{{url('activities')}}">
                                    <i class="fas fa-fw fa-history text-primary mr-2"></i>
                                    <span class="nav-link-text">Activities</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('changelogs*')) ? 'active font-weight-bold' : '' }}" href="{{url('changelogs')}}">
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
                                    <a href="javascript:void(0)" id="settings" class="dropdown-item">
                                        <i class="ni ni-settings-gear-65"></i>
                                        <span>Settings</span>
                                    </a>
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
                                <h6 class="h2 text-white d-inline-block mb-0"><div class="content-title">@yield('content-title')</div></h6>
                            </div>
                            <div class="col-lg-4 col-7 text-right" id="content-button">
                                @yield('content-button')
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

        <!--begin::Modal-->
        <div class="modal fade" id="setting-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="setting-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Settings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <form id="setting-form">
                        <div class="modal-body" style="height: 60vh;">
                            <div class="form-group">
                                <small class="form-control-label">Nama Pengguna <span class="text-danger">*</span></small>
                                <input required type="text" id="setting-name" name="setting_name" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pengguna" />
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Username (untuk Login) <span class="text-danger">*</span></small>
                                <input required type="text" id="setting-username" name="setting_username" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pengguna" style="text-transform: lowercase;"/>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Password <span class="text-danger">*</span></small>
                                <input required type="password" id="setting-password" name="setting_password" autocomplete="off" minlength="6" class="form-control" placeholder="Masukkan Password Sekarang"/>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Ganti Password</small>
                                <input type="password" id="setting-change" name="setting_change" autocomplete="off" minlength="6" class="form-control" placeholder="Jika Ingin Mengubah Password"/>
                            </div>
                            <div class="form-group">
                                <label><sup><span class="text-danger">*) Wajib diisi.</span></sup></label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light font-weight-bold" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Modal-->

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

            $(document).on('click', '#settings', function(e){
                e.preventDefault();
                $("#setting-form")[0].reset();

                $.ajax({
                    url: "/settings",
                    cache: false,
                    method: "GET",
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
                            $("#setting-name").val(data.success.name);
                            $("#setting-username").val(data.success.username);
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
                        if(JSON.parse(data.responseText).success){
                            $("#setting-modal").modal("show");
                        }
                        else{
                            toastr.error("Gagal mengambil data.");
                        }
                        $.unblockUI();
                    }
                });

                $('#setting-modal').on('shown.bs.modal', function() {
                    $("#setting-name").focus();
                    $("#setting-username").on('input change', function() {
                        $(this).val($(this).val().replace(/\s/g, '')).toLowerCase().substring(0,10);
                    });
                });
            });

            $("#setting-form").keypress(function(e) {
                if(e.which == 13) {
                    $('#setting-form').submit();
                    return false;
                }
            });

            $('#setting-form').on('submit', function(e){
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/settings",
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
                            toastr.success(data.success);
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
                        if(JSON.parse(data.responseText).success){
                            $('#setting-modal').modal('hide');
                            location.reload();
                        }
                        setTimeout(() => {
                            $.unblockUI();
                        }, 750);
                    }
                });
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
                        toastr.error("System error.");
                        console.log(data);
                    },
                    complete:function(data){
                        $.unblockUI();
                    }
                });
            });

            setTimeout(() => {
                $.ajax({
                    url: '/check',
                    cache: false,
                    method: "GET",
                    dataType: "json",
                    success:function(data)
                    {
                        if(data.logout){
                            location.reload();
                        }
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
            }, 0);

            $("#content-button").show();

            $(document).ready(function() {
                window.history.pushState(null, "", window.location.href);
                window.onpopstate = function() {
                    window.history.pushState(null, "", window.location.href);
                };
            });
        </script>

        @yield('content-js')

        @include('Layout.Partial._message')
    </body>

</html>
