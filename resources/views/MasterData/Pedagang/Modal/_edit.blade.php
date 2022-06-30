<!--begin::Modal-->
<div class="modal fade" id="edit-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
            </div>
            <form id="edit-form">
                <div class="modal-body" style="height: 60vh;">
                    <div class="form-group">
                        <small class="form-control-label">Nama Pedagang <span class="text-danger">*</span></small>
                        <input required type="text" id="edit-name" name="edit_name" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pedagang" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">KTP <span class="text-danger">*</span></small>
                        <input required type="text" id="edit-ktp" name="edit_ktp" autocomplete="off" maxlength="25" class="number form-control" placeholder="123xxxxxxxxx"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Email</small>
                        <input type="email" id="edit-email" name="edit_email" autocomplete="off" maxlength="255" class="form-control" placeholder="something@gmail.com" style="text-transform: lowercase;" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Whatsapp</small>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+62</span>
                            </div>
                            <input type="text" id="edit-phone" name="edit_phone" autocomplete="off" maxlength="16" class="number form-control" placeholder="8xxxx"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">NPWP</small>
                        <input type="text" id="edit-npwp" name="edit_npwp" autocomplete="off" maxlength="25" class="number form-control" placeholder="xx.xxx.xxx.x-xxx.xxx"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Alamat</small>
                        <textarea rows="8" id="edit-alamat" name="edit_alamat" autocomplete="off" placeholder="Masukkan alamat KTP" class="form-control" maxlength="255"></textarea>
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
    $("#edit-name").val('');
}

var id;

$(document).on('click', '.edit', function(e){
    e.preventDefault();
    id = $(this).attr("id");
    edit_init();

    $.ajax({
        url: "/services/pedagang/" + id + "/edit",
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
                $("#edit-name").val(data.success.name);
                $("#edit-ktp").val(Number(data.success.ktp).toLocaleString('id-ID'));
                $("#edit-email").val((data.success.email) ? data.success.email : '');
                $("#edit-phone").val((data.success.phone) ? Number(data.success.phone).toLocaleString('id-ID') : '');
                $("#edit-npwp").val((data.success.npwp) ? Number(data.success.npwp).toLocaleString('id-ID') : '');
                $("#edit-alamat").val(data.success.address);
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

    $('#edit-modal').on('shown.bs.modal', function() {
        $("#edit-name").focus();
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
        url: "/services/pedagang/" + id,
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
