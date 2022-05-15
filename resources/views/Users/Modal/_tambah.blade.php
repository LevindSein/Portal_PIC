<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="tambah-form">
                <div class="modal-body" style="height: 60vh;">
                    <div class="form-group">
                        <small class="form-control-label">Nama Pengguna <span class="text-danger">*</span></small>
                        <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pengguna" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Username (untuk Login) <span class="text-danger">*</span></small>
                        <input required type="text" id="tambah-username" name="tambah_username" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pengguna" style="text-transform: lowercase;"/>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Level <span class="text-danger">*</span></small>
                        <select required class="form-control" id="tambah-level" name="tambah_level">
                            <option value="2">Admin</option>
                            <option value="1">Super</option>
                            <option value="3">Kasir</option>
                            <option value="4">Keuangan</option>
                            <option value="5">Manajer</option>
                        </select>
                    </div>
                    <div class="text-center form-group">
                        <strong>Pilih Pengelolaan :</strong>
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
        url: "/users",
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
            }, 750);
        }
    });
});
</script>
<!--end::Javascript-->
