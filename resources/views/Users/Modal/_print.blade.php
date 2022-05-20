<!--begin::Modal-->
<div class="modal fade" id="print-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="print-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title">Print Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="{{url('users/print')}}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <small class="form-control-label">Pilih Level Pengguna</small>
                        <select class="form-control" name="level">
                            <option value="all">Semua</option>
                            <option value="1">Super</option>
                            <option value="2">Admin</option>
                            <option value="3">Kasir</option>
                            <option value="4">Keuangan</option>
                            <option value="5">Manajer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Status Pengguna</small>
                        <select class="form-control" name="status">
                            <option value="all">Semua</option>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif / Dihapus</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
    $("#print").on('click', function(e){
        e.preventDefault();
        $("#print-modal").modal("show");
    })
</script>
<!--end::Javascript-->
