<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
            </div>
            <form id="tambah-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <small class="form-control-label">Blok <span class="text-danger">*</span></small>
                            <input required type="text" id="tambah-blok" name="tambah_blok" autocomplete="off" maxlength="10" class="blok form-control" placeholder="Contoh : A / B / C" style="text-transform: uppercase;" />
                        </div>
                        <div class="form-group col-6">
                            <small class="form-control-label">Nomor <span class="text-danger">*</span></small>
                            <input required type="text" id="tambah-nomor" name="tambah_nomor" autocomplete="off" maxlength="10" class="nomor form-control" placeholder="Contoh : 1 / 2E / D" style="text-transform: uppercase;" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label><sup><span class="text-danger">*) Wajib diisi.</span></sup></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
    function tambah_init(){
        $("#tambah-form")[0].reset();
        $("#tambah-name").val('');
    }

    $(".add").click(function(){
        $("#tambah-modal").modal("show");

        tambah_init();

        $('#tambah-modal').on('shown.bs.modal', function() {
            $("#tambah-blok").focus();
        });
    });

    $("#tambah-form").keypress(function(e) {
        if(e.which == 13) {
            $('#tambah-form').submit();
            return false;
        }
    });

    $('#tambah-form').on('submit', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/data/groups",
            cache: false,
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend:function(){
                $.blockUI({
                    message: '<i class="fad fa-spin fa-spinner text-white"></i>',
                    baseZ: 9999,
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.5,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            },
            success:function(data)
            {
                if(data.success){
                    toastr.success(data.success);
                }

                if(data.info){
                    toastr.info(data.info);
                }

                if(data.warning){
                    toastr.warning(data.warning);
                }

                if(data.error){
                    toastr.error(data.error);
                }

                if(data.debug){
                    console.log(data.debug);
                }
            },
            error:function(data){
                if (data.status == 422) {
                    $.each(data.responseJSON.errors, function (i, error) {
                        toastr.error(error[0]);
                    });
                }
                else{
                    toastr.error("System error.");
                    console.log(data);
                }
            },
            complete:function(data){
                if(JSON.parse(data.responseText).success){
                    $('#tambah-modal').modal('hide');
                    dtableReload();
                }
                setTimeout(() => {
                    $.unblockUI();
                }, 100);
            }
        });
    });
</script>
<!--end::Javascript-->
