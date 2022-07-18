<li class="nav-item">
    <a class="nav-link {{ (request()->is('dashboard*')) ? 'active font-weight-bold' : '' }}" href="{{url('dashboard')}}">
        <i class="fas fa-fw fa-tachometer-alt text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('data*')) ? 'active font-weight-bold' : '' }}" href="#navbar-data" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('data*')) ? 'true' : 'false' }}" aria-controls="navbar-data">
        <i class="fas fa-fw fa-database text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Master&nbsp;Data</span>
    </a>
    <div class="collapse {{ (request()->is('data*')) ? 'show' : '' }}" id="navbar-data">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{url('data/periode')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('data/periode*')) ? 'text-primary font-weight-bold' : '' }}">Periode</a>
            </li>
            <li class="nav-item">
                <a href="{{url('data/tarif')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('data/tarif*')) ? 'text-primary font-weight-bold' : '' }}">Tarif</a>
            </li>
            <li class="nav-item">
                <a href="{{url('data/alat')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('data/alat*')) ? 'text-primary font-weight-bold' : '' }}">Alat Meter</a>
            </li>
            <li class="nav-item">
                <a href="{{url('data/pedagang')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('data/pedagang*')) ? 'text-primary font-weight-bold' : '' }}">Pedagang</a>
            </li>
            <li class="nav-item">
                <a href="{{url('data/groups')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('data/groups*')) ? 'text-primary font-weight-bold' : '' }}">Grup Tempat</a>
            </li>
            <li class="nav-item">
                <a href="{{url('data/tempat')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('data/tempat*')) ? 'text-primary font-weight-bold' : '' }}">Tempat Usaha</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('tagihan*')) ? 'active font-weight-bold' : '' }}" href="{{url('tagihan')}}">
        <i class="fas fa-fw fa-dollar-sign text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Tagihan</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('layanan*')) ? 'active font-weight-bold' : '' }}" href="#navbar-layanan" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('layanan*')) ? 'true' : 'false' }}" aria-controls="navbar-layanan">
        <i class="fas fa-fw fa-user-headset text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Layanan</span>
    </a>
    <div class="collapse {{ (request()->is('layanan*')) ? 'show' : '' }}" id="navbar-layanan">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-3 font-weight-bold">Registrasi</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-3 font-weight-bold">Pembongkaran</a>
            </li>
            <li class="nav-item">
                <a href="{{url('layanan/kasir')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('layanan/kasir*')) ? 'text-primary font-weight-bold' : '' }}">Kasir / Pembayaran</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('laporan*')) ? 'active font-weight-bold' : '' }}" href="#navbar-laporan" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('laporan*')) ? 'true' : 'false' }}" aria-controls="navbar-laporan">
        <i class="fas fa-fw fa-book text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Laporan</span>
    </a>
    <div class="collapse {{ (request()->is('laporan*')) ? 'show' : '' }}" id="navbar-laporan">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-3 font-weight-bold">Pemakaian</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-3 font-weight-bold">Pendapatan</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-3 font-weight-bold">Tunggakan</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-3 font-weight-bold">Usaha</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('analitis*')) ? 'active font-weight-bold' : '' }}" href="#navbar-analitis" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('analitis*')) ? 'true' : 'false' }}" aria-controls="navbar-analitis">
        <i class="fad fa-fw fa-rocket text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Analitis</span>
    </a>
    <div class="collapse {{ (request()->is('analitis*')) ? 'show' : '' }}" id="navbar-analitis">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{url('analitis/potention')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('analitis/potention*')) ? 'text-primary font-weight-bold' : '' }}">Potensi</a>
            </li>
            <li class="nav-item">
                <a href="{{url('analitis/simulation')}}" class="nav-link ml-3 font-weight-bold {{ (request()->is('analitis/simulation*')) ? 'text-primary font-weight-bold' : '' }}">Simulasi Tagihan</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('users*')) ? 'active font-weight-bold' : '' }}" href="{{url('users')}}">
        <i class="fad fa-fw fa-users text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Users</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('aktivitas*')) ? 'active font-weight-bold' : '' }}" href="{{url('aktivitas')}}">
        <i class="fas fa-fw fa-history text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Aktivitas</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ (request()->is('changelogs*')) ? 'active font-weight-bold' : '' }}" href="{{url('changelogs')}}">
        <i class="fad fa-fw fa-cogs text-primary mr-2"></i>
        <span class="nav-link-text font-weight-bold">Changelogs</span>
    </a>
</li>
