<!--begin::Modal-->
<div class="modal fade" id="print-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="print-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Print Data Tempat</h5>
            </div>
            <form action="{{url('data/tempat/print')}}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <small class="form-control-label">Status Tempat</small>
                        <select class="form-control" name="status">
                            <option value="all">Semua</option>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                            <option value="2">Bebas Bayar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Grup / Blok Tempat</small>
                        <select class="form-control" name="group">
                            <option value="all">Semua</option>
                            @foreach ($groups as $g)
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
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
