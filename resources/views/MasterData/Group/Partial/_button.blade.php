<div class="d-flex align-item-center">
    <!--begin::Actions-->
    <button class="add btn btn-sm btn-success d-none d-sm-block"><i class="fas fa-sm fa-plus"></i></button>
    <!--end::Actions-->
    <!-- Button -->
    <div class="dropdown-menu dropdown-menu-right">
        <a class="add dropdown-item d-md-none" href="javascript:void(0)"><i class="fas fa-fw fa-plus"></i>Tambah Grup</a>
        <div class="dropdown-divider d-md-none"></div>
        <a class="dropdown-item" id="excel" href="{{url('data/groups/excel')}}"><i class="fas fa-fw fa-file-excel"></i>Excel Data Grup</a>
        <a class="dropdown-item" id="print" href="{{url('data/groups/print')}}" target="_blank"><i class="fas fa-fw fa-print"></i>Print Data Grup</a>
    </div>
    <a class="dropdown-toggle btn btn-sm btn-neutral" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</a>
    <!-- End Button -->
</div>

