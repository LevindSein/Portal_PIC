<!--begin::Modal-->
<div class="modal fade" id="print-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="print-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Print Data Aktifitas</h5>
            </div>
            <form action="{{url('activities/print/dari/ke')}}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <small class="form-control-label">Dari <span class="text-danger">*</span></small>
                            <input required type="datetime-local" id="dari-times" name="dari_times" autocomplete="off" class="form-control form-control-sm" />
                        </div>
                        <div class="form-group col-6">
                            <small class="form-control-label">Ke <span class="text-danger">*</span></small>
                            <input required type="datetime-local" id="ke-times" name="ke_times" autocomplete="off" class="form-control form-control-sm" />
                        </div>
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
