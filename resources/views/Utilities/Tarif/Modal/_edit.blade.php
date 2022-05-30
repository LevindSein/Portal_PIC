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
                        <small class="form-control-label">Nama Tarif <span class="text-danger">*</span></small>
                        <input required type="text" id="edit-name" name="edit_name" autocomplete="off" maxlength="50" class="name form-control" placeholder="Masukkan Nama Tarif" />
                    </div>
                    <div class="listrik">
                        <div class="form-group">
                            <small class="form-control-label">Beban Daya <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="15" type="text" id="edit-beban" name="edit_beban" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">kWh</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Blok 1 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-blok1" name="edit_blok1" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Blok 2 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-blok2" name="edit_blok2" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Standar Operasional <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="2" type="text" id="edit-standar" name="edit_standar" autocomplete="off" placeholder="Ketikkan dalam angka" class="number hour form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text"><sup>Jam&nbsp;</sup>&frasl;<sub>&nbsp;Hari</sub></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">PJU <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="edit-pju" name="edit_pju" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Denda 1 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-denda1" name="edit_denda1" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Denda 2 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="edit-denda2" name="edit_denda2" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">PPN <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="edit-ppnlistrik" name="edit_ppnlistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="airbersih">
                        <div class="form-group">
                            <small class="form-control-label">Tarif 1 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-tarif1" name="edit_tarif1" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif 2 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-tarif2" name="edit_tarif2" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Pemeliharaan <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-pemeliharaan" name="edit_pemeliharaan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Beban <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-bbn" name="edit_bbn" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Air Kotor <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="edit-arkot" name="edit_arkot" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Denda <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-denda" name="edit_denda" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">PPN <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="edit-ppnair" name="edit_ppnair" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="keamananipk">
                        <div class="form-group">
                            <small class="form-control-label">Tarif <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-keamananipk" name="edit_keamananipk" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">% Keamanan <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="edit-keamanan" name="edit_keamanan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">% IPK <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="edit-ipk" name="edit_ipk" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kebersihan">
                        <div class="form-group">
                            <small class="form-control-label">Tarif <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-kebersihan" name="edit_kebersihan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                    </div>
                    <div class="airkotor">
                        <div class="form-group">
                            <small class="form-control-label">Tarif <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-airkotor" name="edit_airkotor" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                    </div>
                    <div class="lainnya">
                        <div class="form-group">
                            <small class="form-control-label">Tarif <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="edit-lainnya" name="edit_lainnya" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
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
    }

    var id;

    $(document).on('click', '.edit', function(e){
        e.preventDefault();
        id = $(this).attr("id");
        edit_init();
        hide();

        $.ajax({
            url: "/utilities/tarif/" + id + "/edit",
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

                    if(data.success.level == 1){
                        listrik();

                        $("#edit-beban").val(Number(data.success.data.Tarif_Beban).toLocaleString('id-ID'));
                        $("#edit-blok1").val(Number(data.success.data.Tarif_Blok_1).toLocaleString('id-ID'));
                        $("#edit-blok2").val(Number(data.success.data.Tarif_Blok_2).toLocaleString('id-ID'));
                        $("#edit-standar").val(Number(data.success.data.Standar_Operasional).toLocaleString('id-ID'));
                        $("#edit-pju").val(Number(data.success.data.PJU).toLocaleString('id-ID'));
                        $("#edit-denda1").val(Number(data.success.data.Denda_1).toLocaleString('id-ID'));
                        $("#edit-denda2").val(Number(data.success.data.Denda_2).toLocaleString('id-ID'));
                        $("#edit-ppnlistrik").val(Number(data.success.data.PPN).toLocaleString('id-ID'));
                    } else if (data.success.level == 2){
                        airbersih();

                        $("#edit-tarif1").val(Number(data.success.data.Tarif_1).toLocaleString('id-ID'));
                        $("#edit-tarif2").val(Number(data.success.data.Tarif_2).toLocaleString('id-ID'));
                        $("#edit-pemeliharaan").val(Number(data.success.data.Tarif_Pemeliharaan).toLocaleString('id-ID'));
                        $("#edit-bbn").val(Number(data.success.data.Tarif_Beban).toLocaleString('id-ID'));
                        $("#edit-arkot").val(Number(data.success.data.Tarif_Air_Kotor).toLocaleString('id-ID'));
                        $("#edit-denda").val(Number(data.success.data.Denda).toLocaleString('id-ID'));
                        $("#edit-ppnair").val(Number(data.success.data.PPN).toLocaleString('id-ID'));
                    } else if (data.success.level == 3){
                        keamananipk();

                        $("#edit-keamananipk").val(Number(data.success.data.Tarif).toLocaleString('id-ID'));
                        $("#edit-keamanan").val(Number(data.success.data.Persen_Keamanan).toLocaleString('id-ID'));
                        $("#edit-ipk").val(Number(data.success.data.Persen_IPK).toLocaleString('id-ID'));
                    } else if (data.success.level == 4){
                        kebersihan();

                        $("#edit-kebersihan").val(Number(data.success.data.Tarif).toLocaleString('id-ID'));
                    } else if (data.success.level == 5){
                        airkotor();

                        $("#edit-airkotor").val(Number(data.success.data.Tarif).toLocaleString('id-ID'));
                    } else {
                        lainnya();

                        $("#edit-lainnya").val(Number(data.success.data.Tarif).toLocaleString('id-ID'));
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

    $("#edit-keamanan").on('input', function (e) {
        var keamanan = $("#edit-keamanan").val();

        var ipk = 100 - keamanan;
        if(ipk < 0){
            ipk = 0;
        }
        $("#edit-ipk").val(ipk);
    });

    $("#edit-ipk").on('input', function (e) {
        var ipk = $("#edit-ipk").val();

        var keamanan = 100 - ipk;
        if(keamanan < 0){
            keamanan = 0;
        }
        $("#edit-keamanan").val(keamanan);
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
            url: "/utilities/tarif/" + id,
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
