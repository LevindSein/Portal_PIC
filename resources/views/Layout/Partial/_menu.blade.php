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
                <a href="{{url('utilities/tarif')}}" class="nav-link ml-3 {{ (request()->is('utilities/tarif*')) ? 'text-primary font-weight-bold' : '' }}">Tarif</a>
            </li>
            <li class="nav-item">
                <a href="{{url('utilities/alat')}}" class="nav-link ml-3 {{ (request()->is('utilities/alat*')) ? 'text-primary font-weight-bold' : '' }}">Alat Meter</a>
            </li>
            @if($level == 1)
            <li class="nav-item">
                <a href="{{url('utilities/periode')}}" class="nav-link ml-3 {{ (request()->is('utilities/periode*')) ? 'text-primary font-weight-bold' : '' }}">Periode</a>
            </li>
            @endif
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
@if($level == 1)
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
@endif
<li class="nav-item">
    <a class="nav-link {{ (request()->is('changelogs*')) ? 'active font-weight-bold' : '' }}" href="{{url('changelogs')}}">
        <i class="fad fa-fw fa-cogs text-primary mr-2"></i>
        <span class="nav-link-text">Changelogs</span>
    </a>
</li>
