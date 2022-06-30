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
                        <small class="form-control-label">Level <span class="text-danger">*</span></small>
                        <select required class="form-control" id="tambah-level" name="tambah_level">
                            <option value="1">Listrik</option>
                            <option value="2">Air Bersih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Nama Alat <span class="text-danger">*</span></small>
                        <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="50" class="name form-control" placeholder="Masukkan Nama / No.Seri Alat" style="text-transform: uppercase;" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Stand <span class="text-danger">*</span></small>
                        <input required maxlength="15" type="text" id="tambah-stand" name="tambah_stand" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                    </div>
                    <div class="listrik">
                        <div class="form-group">
                            <small class="form-control-label">Daya <span class="text-danger">*</span></small>
                            <input maxlength="15" type="text" id="tambah-daya" name="tambah_daya" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
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

        hide();

        $("#tambah-level").val($("#level").val()).change();
    }

    $("#add").click(function(){
        $("#tambah-modal").modal("show");

        tambah_init();
    });

    $(document).on("change", "#tambah-level", function(){
        var level = $(this).val();

        hide();

        if(level == 1){
            listrik();
        }
    });

    $("#tambah-keamanan").on('input', function (e) {
        var keamanan = $("#tambah-keamanan").val();

        var ipk = 100 - keamanan;
        if(ipk < 0){
            ipk = 0;
        }
        $("#tambah-ipk").val(ipk);
    });

    $("#tambah-ipk").on('input', function (e) {
        var ipk = $("#tambah-ipk").val();

        var keamanan = 100 - ipk;
        if(keamanan < 0){
            keamanan = 0;
        }
        $("#tambah-keamanan").val(keamanan);
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
            url: "/utilities/alat",
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
                    $("#level").val(data.debug).change();
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
