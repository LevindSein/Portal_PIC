<a class="dropdown-item {{ (request()->is('production/manage/bills*')) ? 'bg-info text-white' : '' }}" href="{{url('production/manage/bills')}}">
    <i class="fas fa-fw fa-file-invoice mr-1"></i>
    <span>Data Tagihan</span>
</a>
<a class="dropdown-item {{ (request()->is('production/manage/deleted*')) ? 'bg-info text-white' : '' }}" href="{{url('production/manage/deleted')}}">
    <i class="fas fa-fw fa-trash mr-1"></i>
    <span>Data Penghapusan</span>
</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item {{ (request()->is('production/manage/dayoff*')) ? 'bg-info text-white' : '' }}" href="{{url('production/manage/dayoff')}}">
    <i class="fad fa-fw fa-list mr-1"></i>
    <span>Libur Tagihan</span>
</a>
