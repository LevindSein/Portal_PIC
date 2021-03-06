<div class="d-flex align-item-center">
    <!--begin::Actions-->
    <button class="add btn btn-sm btn-success d-none d-sm-block"><i class="fas fa-sm fa-plus"></i></button>
    <select class="form-control form-control-sm mr-2" id="level" name="level">
        <option value="1">Listrik</option>
        <option value="2">Air Bersih</option>
    </select>
    <!--end::Actions-->
    <!-- Button -->
    <div class="dropdown-menu dropdown-menu-right">
        <a class="add dropdown-item d-md-none" href="javascript:void(0)"><i class="fas fa-fw fa-plus"></i>Tambah Alat</a>
        <div class="dropdown-divider d-md-none"></div>
        <a class="dropdown-item" id="print" href="javascript:void(0)"><i class="fas fa-fw fa-print"></i>Print Data Alat</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" id="available" href="javascript:void(0)"><i class="fas fa-fw fa-check"></i>Alat Tersedia</a>
        <a class="dropdown-item" id="activated" href="javascript:void(0)"><i class="fas fa-fw fa-ban"></i>Alat Terpakai</a>
    </div>
    <a class="dropdown-toggle btn btn-sm btn-neutral" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</a>
    <!-- End Button -->
</div>
