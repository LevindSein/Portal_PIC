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
                    <div id="tambah-kelola">
                        <div class="text-center form-group">
                            <strong>Pilih Pengelolaan :</strong>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                @foreach($groups as $g)
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="groups[]"
                                        id="tambah-{{$g->name}}"
                                        value="{{Crypt::encrypt($g->name)}}">
                                    <label class="form-control-label" for="tambah-{{$g->name}}">
                                        {{$g->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-registrasi"
                                        value="{{Crypt::encrypt('registrasi')}}">
                                    <label class="form-control-label" for="tambah-registrasi">
                                        Registrasi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-pedagang"
                                        value="{{Crypt::encrypt('pedagang')}}">
                                    <label class="form-control-label" for="tambah-pedagang">
                                        Pedagang
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-tempatusaha"
                                        value="{{Crypt::encrypt('tempatusaha')}}">
                                    <label class="form-control-label" for="tambah-tempatusaha">
                                        Tempat Usaha
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-pembongkaran"
                                        value="{{Crypt::encrypt('pembongkaran')}}">
                                    <label class="form-control-label" for="tambah-pembongkaran">
                                        Pembongkaran
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-pembayaran"
                                        value="{{Crypt::encrypt('pembayaran')}}">
                                    <label class="form-control-label" for="tambah-pembayaran">
                                        Kasir / Pembayaran
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-tagihan"
                                        value="{{Crypt::encrypt('tagihan')}}">
                                    <label class="form-control-label" for="tambah-tagihan">
                                        Tagihan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-publishing"
                                        value="{{Crypt::encrypt('publishing')}}">
                                    <label class="form-control-label" for="tambah-publishing">
                                        Publishing
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-laporan"
                                        value="{{Crypt::encrypt('laporan')}}">
                                    <label class="form-control-label" for="tambah-laporan">
                                        Laporan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-tarif"
                                        value="{{Crypt::encrypt('tarif')}}">
                                    <label class="form-control-label" for="tambah-tarif">
                                        Tarif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-alatmeter"
                                        value="{{Crypt::encrypt('alatmeter')}}">
                                    <label class="form-control-label" for="tambah-alatmeter">
                                        Alat Meter
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-simulasi"
                                        value="{{Crypt::encrypt('simulasi')}}">
                                    <label class="form-control-label" for="tambah-simulasi">
                                        Simulasi Tagihan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        checked
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="tambah-potensi"
                                        value="{{Crypt::encrypt('potensi')}}">
                                    <label class="form-control-label" for="tambah-potensi">
                                        Potensi
                                    </label>
                                </div>
                            </div>
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
    $("#tambah-username").prop("disabled", true).val('');
    $("#tambah-level").prop("selectedIndex", 0).val();
    $("#tambah-kelola").show();
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

$("#tambah-level").on('change', function() {
    if($("#tambah-level").val() == 2){
        $("#tambah-kelola").show();
    }
    else{
        $("#tambah-kelola").hide();
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
            }, 750);
        }
    });
});
</script>
<!--end::Javascript-->
