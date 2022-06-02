<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
            </div>
            <form id="tambah-form">
                <div class="modal-body" style="height: 60vh;">
                    <div class="form-group">
                        <small class="form-control-label">Nama Pedagang <span class="text-danger">*</span></small>
                        <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pedagang" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Username (untuk Login) <span class="text-danger">*</span></small>
                        <input required type="text" id="tambah-username" name="tambah_username" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pedagang" style="text-transform: lowercase;"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">KTP <span class="text-danger">*</span></small>
                        <input required type="text" id="tambah-ktp" name="tambah_ktp" autocomplete="off" maxlength="25" class="number form-control" placeholder="123xxxxxxxxx"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Email</small>
                        <input type="email" id="tambah-email" name="tambah_email" autocomplete="off" maxlength="255" class="form-control" placeholder="something@gmail.com" style="text-transform: lowercase;" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Whatsapp</small>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+62</span>
                            </div>
                            <input type="text" id="tambah-phone" name="tambah_phone" autocomplete="off" maxlength="16" class="number form-control" placeholder="8xxxx"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">NPWP</small>
                        <input type="text" id="tambah-npwp" name="tambah_npwp" autocomplete="off" maxlength="25" class="number form-control" placeholder="xx.xxx.xxx.x-xxx.xxx"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Alamat</small>
                        <textarea rows="8" id="tambah-alamat" name="tambah_alamat" autocomplete="off" placeholder="Masukkan alamat KTP" class="form-control" maxlength="255"></textarea>
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
    $("#tambah-username").prop("disabled", true).val('');
}

$("#add").click(function(){
    $("#tambah-modal").modal("show");

    tambah_init();

    $('#tambah-modal').on('shown.bs.modal', function() {
        $("#tambah-name").focus();
    });
});

$("#tambah-name").on('input change', function() {
    if($("#tambah-name").val() == ''){
        $("#tambah-username").prop("disabled", true).val('');
    }
    else{
        $("#tambah-username").prop("disabled", false);
        var str = $("#tambah-name").val().replace(/\s/g, '').toLowerCase().substring(0,10);
        $("#tambah-username").val(str);
    }
});

$("#tambah-username").on('input change', function() {
    $(this).val($(this).val().replace(/\s/g, '')).toLowerCase();
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
        url: "/services/pedagang",
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
