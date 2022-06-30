<!--begin::Modal-->
<div class="modal fade" id="print-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="print-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Print Data Tarif</h5>
            </div>
            <form action="{{url('data/tarif/print')}}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <small class="form-control-label">Pilih Tarif</small>
                        <select class="form-control" name="level">
                            <option value="1">Listrik</option>
                            <option value="2">Air Bersih</option>
                            <option value="3">Keamanan & IPK</option>
                            <option value="4">Kebersihan</option>
                            <option value="5">Air Kotor</option>
                            <option value="6">Lainnya</option>
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
