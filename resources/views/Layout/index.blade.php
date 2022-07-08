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
        <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-secondary" id="sidenav-main">
            <div class="scrollbar-inner">
                <!-- Brand -->
                <div class="sidenav-header d-flex align-items-center">
                    <a class="navbar-brand" href="javascript:void(0)">
                        <span class="sidebar-brand-text mx-2 text-primary"><b>
                        @if($level == 1)
                        SUPER
                        @elseif($level == 2)
                        ADMIN
                        @elseif($level == 3)
                        KASIR
                        @elseif($level == 4)
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
                            @include('Layout.Partial._menu')
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

        @include('Layout.Modal._settings')

        @include('Layout.Partial._js')

        @yield('content-js')

        @include('Layout.Partial._message')
    </body>

</html>
