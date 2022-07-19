<!--begin::Modal-->
<div class="modal fade" id="edit-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles"></h5>
            </div>
            <form id="edit-form">
                <div class="modal-body">
                    <div class="form-group">
                        <small class="form-control-label">Stand <span class="text-danger">*</span></small>
                        <input required maxlength="15" type="text" id="edit-stand" name="edit_stand" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                    </div>
                    <div class="listrik">
                        <div class="form-group">
                            <small class="form-control-label">Daya <span class="text-danger">*</span></small>
                            <input required maxlength="15" type="text" id="edit-daya" name="edit_daya" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
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
    function edit_init(){
        $("#edit-form")[0].reset();

        hide();
    }

    function edit_init(){
        $("#edit-form")[0].reset();
        $("#edit-name").val('');
        $(".listrik").hide();
        $("#edit-daya").prop('required', false);
    }

    var id;

    $(document).on('click', '.edit', function(e){
        e.preventDefault();
        id = $(this).attr("id");
        $(".titles").text("Edit " + $(this).attr("nama").substring(0,15));

        edit_init();

        $.ajax({
            url: "/data/alat/" + id + "/edit",
            cache: false,
            method: "GET",
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
                    $("#edit-stand").val(Number(data.success.stand).toLocaleString('id-ID'));
                    if(data.success.level == 1){
                        $(".listrik").show();
                        $("#edit-daya").val(Number(data.success.daya).toLocaleString('id-ID'));
                        $("#edit-daya").prop('required', true);
                    }

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
                toastr.error("System error.");
                console.log(data);
            },
            complete:function(data){
                if(JSON.parse(data.responseText).success){
                    $("#edit-modal").modal("show");
                }
                else{
                    toastr.error("Gagal mengambil data.");
                }
                $.unblockUI();
            }
        });
    });

    $("#edit-form").keypress(function(e) {
        if(e.which == 13) {
            $('#edit-form').submit();
            return false;
        }
    });

    $('#edit-form').on('submit', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/data/alat/" + id,
            cache: false,
            method: "PUT",
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
                    $('#edit-modal').modal('hide');
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
