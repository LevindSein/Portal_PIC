<a class="dropdown-item {{ (request()->is('production/point/stores*')) ? 'bg-info text-white' : '' }}" href="{{url('production/point/stores')}}">
    <i class="fad fa-fw fa-list mr-1"></i>
    <span>Data Tempat</span>
</a>
<a class="dropdown-item {{ (request()->is('production/point/groups*')) ? 'bg-info text-white' : '' }}" href="{{url('production/point/groups')}}">
    <i class="fad fa-fw fa-list mr-1"></i>
    <span>Blok Tempat</span>
</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item {{ (request()->is('production/point/tools/listrik*')) ? 'bg-info text-white' : '' }}" href="{{url('production/point/tools/listrik')}}">
    <i class="fad fa-fw fa-tools mr-1"></i>
    <span>Alat Listrik</span>
</a>
<a class="dropdown-item {{ (request()->is('production/point/tools/airbersih*')) ? 'bg-info text-white' : '' }}" href="{{url('production/point/tools/airbersih')}}">
    <i class="fad fa-fw fa-tools mr-1"></i>
    <span>Alat Air Bersih</span>
</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item {{ (request()->is('production/point/commodities*')) ? 'bg-info text-white' : '' }}" href="{{url('production/point/commodities')}}">
    <i class="fad fa-fw fa-hands-helping mr-1"></i>
    <span>Komoditi</span>
</a>
