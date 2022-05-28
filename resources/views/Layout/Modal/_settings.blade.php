<!--begin::Modal-->
<div class="modal fade" id="setting-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="setting-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="setting-form">
                <div class="modal-body" style="height: 60vh;">
                    <div class="form-group">
                        <small class="form-control-label">Nama Pengguna <span class="text-danger">*</span></small>
                        <input required type="text" id="setting-name" name="setting_name" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pengguna" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Username (untuk Login) <span class="text-danger">*</span></small>
                        <input required type="text" id="setting-username" name="setting_username" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pengguna" style="text-transform: lowercase;"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Password <span class="text-danger">*</span></small>
                        <input required type="password" id="setting-password" name="setting_password" autocomplete="off" minlength="6" class="form-control" placeholder="Masukkan Password Sekarang"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Ganti Password</small>
                        <input type="password" id="setting-change" name="setting_change" autocomplete="off" minlength="6" class="form-control" placeholder="Jika Ingin Mengubah Password"/>
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

<script>
    $(document).on('click', '#settings', function(e){
        e.preventDefault();
        $("#setting-form")[0].reset();

        $.ajax({
            url: "/settings",
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
                    $("#setting-name").val(data.success.name);
                    $("#setting-username").val(data.success.username);
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
                    $("#setting-modal").modal("show");
                }
                else{
                    toastr.error("Gagal mengambil data.");
                }
                $.unblockUI();
            }
        });

        $('#setting-modal').on('shown.bs.modal', function() {
            $("#setting-name").focus();
            $("#setting-username").on('input change', function() {
                $(this).val($(this).val().replace(/\s/g, '')).toLowerCase().substring(0,10);
            });
        });
    });

    $("#setting-form").keypress(function(e) {
        if(e.which == 13) {
            $('#setting-form').submit();
            return false;
        }
    });

    $('#setting-form').on('submit', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/settings",
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
                    $('#setting-modal').modal('hide');
                    location.reload();
                }
                setTimeout(() => {
                    $.unblockUI();
                }, 750);
            }
        });
    });
</script>
