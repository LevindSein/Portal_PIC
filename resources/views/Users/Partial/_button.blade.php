<div class="d-flex align-item-center">
    <!--begin::Actions-->
    <button class="add btn btn-sm btn-success d-none d-sm-block"><i class="fas fa-sm fa-plus"></i></button>
    <select class="form-control form-control-sm mr-2" id="level" name="level">
        <option value="all">Semua</option>
        <option value="1">Super</option>
        <option value="2">Admin</option>
        <option value="3">Kasir</option>
        <option value="4">Keuangan</option>
        <option value="5">Manajer</option>
    </select>
    <!--end::Actions-->
    <!-- Button -->
    <div class="dropdown-menu dropdown-menu-right">
        <a class="add dropdown-item d-md-none" href="javascript:void(0)"><i class="fas fa-fw fa-plus"></i>Tambah User</a>
        <div class="dropdown-divider d-md-none"></div>
        <a class="dropdown-item" id="excel" href="javascript:void(0)"><i class="fas fa-fw fa-file-excel"></i>Excel Data Pengguna</a>
        <a class="dropdown-item" id="print" href="javascript:void(0)"><i class="fas fa-fw fa-print"></i>Print Data Pengguna</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" id="activated" href="javascript:void(0)"><i class="fas fa-fw fa-check"></i>Data Pengguna Aktif</a>
        <a class="dropdown-item" id="deleted" href="javascript:void(0)"><i class="fas fa-fw fa-ban"></i>Data Pengguna Nonaktif</a>
    </div>
    <a class="dropdown-toggle btn btn-sm btn-neutral" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</a>
    <!-- End Button -->
</div>
