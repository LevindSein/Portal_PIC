<!--begin::Modal-->
<div class="modal fade" id="hapus-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="hapus-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title"></h5>
            </div>
            <form id="hapus-form">
                <div class="modal-body">
                    <p>
                        Tekan tombol <span class="text-danger status"></span>, jika anda yakin untuk mengubah status pengguna.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold status"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
    var id;

    $(document).on('click', '.delete', function(e){
        e.preventDefault();
        id = $(this).attr("id");
        stt = $(this).attr("status");

        $("#hapus-modal").modal("show");

        if(stt == 1){
            $(".title").text("Hapus : " + $(this).attr("nama"));
            $(".status").text("Hapus");
        } else {
            $(".title").text("Aktifkan : " + $(this).attr("nama"));
            $(".status").text("Aktifkan");
        }
    })

    $('#hapus-form').on('submit', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/users/" + id,
            cache: false,
            method: "DELETE",
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
                toastr.error("System error.");
                console.log(data);
            },
            complete:function(data){
                if(JSON.parse(data.responseText).success){
                    $('#hapus-modal').modal('hide');
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
