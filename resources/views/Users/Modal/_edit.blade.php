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
                        <small class="form-control-label">Nama Pengguna <span class="text-danger">*</span></small>
                        <input required type="text" id="edit-name" name="edit_name" autocomplete="off" maxlength="100" class="name form-control" placeholder="Masukkan Nama Pengguna" />
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Level <span class="text-danger">*</span></small>
                        <select required class="form-control" id="edit-level" name="edit_level">
                            <option value="2">Admin</option>
                            <option value="1">Super</option>
                            <option value="3">Kasir</option>
                            <option value="4">Keuangan</option>
                            <option value="5">Manajer</option>
                        </select>
                    </div>
                    <div id="edit-kelola">
                        <div class="text-center form-group">
                            <strong>Pilih Pengelolaan :</strong>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                @foreach($groups as $g)
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="groups[]"
                                        id="edit-{{$g->name}}"
                                        value="{{Crypt::encrypt($g->name)}}">
                                    <label class="form-control-label" for="edit-{{$g->name}}">
                                        {{$g->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-registrasi"
                                        value="{{Crypt::encrypt('registrasi')}}">
                                    <label class="form-control-label" for="edit-registrasi">
                                        Registrasi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-pedagang"
                                        value="{{Crypt::encrypt('pedagang')}}">
                                    <label class="form-control-label" for="edit-pedagang">
                                        Pedagang
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-tempatusaha"
                                        value="{{Crypt::encrypt('tempatusaha')}}">
                                    <label class="form-control-label" for="edit-tempatusaha">
                                        Tempat Usaha
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-pembongkaran"
                                        value="{{Crypt::encrypt('pembongkaran')}}">
                                    <label class="form-control-label" for="edit-pembongkaran">
                                        Pembongkaran
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-pembayaran"
                                        value="{{Crypt::encrypt('pembayaran')}}">
                                    <label class="form-control-label" for="edit-pembayaran">
                                        Kasir / Pembayaran
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-tagihan"
                                        value="{{Crypt::encrypt('tagihan')}}">
                                    <label class="form-control-label" for="edit-tagihan">
                                        Tagihan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-publishing"
                                        value="{{Crypt::encrypt('publishing')}}">
                                    <label class="form-control-label" for="edit-publishing">
                                        Publishing
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-laporan"
                                        value="{{Crypt::encrypt('laporan')}}">
                                    <label class="form-control-label" for="edit-laporan">
                                        Laporan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-tarif"
                                        value="{{Crypt::encrypt('tarif')}}">
                                    <label class="form-control-label" for="edit-tarif">
                                        Tarif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-alatmeter"
                                        value="{{Crypt::encrypt('alatmeter')}}">
                                    <label class="form-control-label" for="edit-alatmeter">
                                        Alat Meter
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-simulasi"
                                        value="{{Crypt::encrypt('simulasi')}}">
                                    <label class="form-control-label" for="edit-simulasi">
                                        Simulasi Tagihan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="choosed[]"
                                        id="edit-potensi"
                                        value="{{Crypt::encrypt('potensi')}}">
                                    <label class="form-control-label" for="edit-potensi">
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
function edit_init(){
    $("#edit-form")[0].reset();
    $("#edit-name").val('');
    $("#edit-level").prop("selectedIndex", 0).val();
    $("#edit-kelola").show();
}

var id;

$(document).on('click', '.edit', function(e){
    e.preventDefault();
    id = $(this).attr("id");
    edit_init();

    $.ajax({
        url: "/users/" + id + "/edit",
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
                $("#edit-level").val(data.success.level).change();

                if(data.success.otoritas){
                    if(data.success.otoritas.groups){
                        $.each(data.success.otoritas.groups, function (index, value){
                            $("#edit-" + value).prop("checked", true);
                        });
                    }

                    if(data.success.otoritas.choosed){
                        $.each(data.success.otoritas.choosed, function (index, value){
                            $("#edit-" + value).prop("checked", true);
                        });
                    }
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

    $('#edit-modal').on('shown.bs.modal', function() {
        $("#edit-name").focus();
    });
});

$("#edit-level").on('change', function() {
    if($("#edit-level").val() == 2){
        $("#edit-kelola").show();
    }
    else{
        $("#edit-kelola").hide();
    }
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
        url: "/users/" + id,
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
