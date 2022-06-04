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
                            <option value="3">Keamanan & IPK</option>
                            <option value="4">Kebersihan</option>
                            <option value="5">Air Kotor</option>
                            <option value="6">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Nama Tarif <span class="text-danger">*</span></small>
                        <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="50" class="name form-control" placeholder="Masukkan Nama Tarif" />
                    </div>
                    <div class="listrik">
                        <div class="form-group">
                            <small class="form-control-label">Tarif Rekmin <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-rekmin" name="tambah_rekmin" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Beban Daya <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="15" type="text" id="tambah-beban" name="tambah_beban" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
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
                                <input maxlength="15" type="text" id="tambah-blok1" name="tambah_blok1" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Blok 2 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-blok2" name="tambah_blok2" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Standar Operasional <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="2" type="text" id="tambah-standar" name="tambah_standar" autocomplete="off" placeholder="Ketikkan dalam angka" class="number hour form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text"><sup>Jam&nbsp;</sup>&frasl;<sub>&nbsp;Hari</sub></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">PJU <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="tambah-pju" name="tambah_pju" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
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
                                <input maxlength="15" type="text" id="tambah-denda1" name="tambah_denda1" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Denda 2 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="tambah-denda2" name="tambah_denda2" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">PPN <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="tambah-ppnlistrik" name="tambah_ppnlistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Pasang Baru <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-barulistrik" name="tambah_barulistrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">per-kWh</span>
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
                                <input maxlength="15" type="text" id="tambah-tarif1" name="tambah_tarif1" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif 2 <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-tarif2" name="tambah_tarif2" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Pemeliharaan <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-pemeliharaan" name="tambah_pemeliharaan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Beban <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-bbn" name="tambah_bbn" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Air Kotor <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="tambah-arkot" name="tambah_arkot" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
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
                                <input maxlength="15" type="text" id="tambah-denda" name="tambah_denda" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">PPN <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="tambah-ppnair" name="tambah_ppnair" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">Tarif Pasang Baru <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-baruairbersih" name="tambah_baruairbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                    </div>
                    <div class="keamananipk">
                        <div class="form-group">
                            <small class="form-control-label">Tarif per-Los<span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-keamananipk" name="tambah_keamananipk" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">% Keamanan <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="tambah-keamanan" name="tambah_keamanan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <small class="form-control-label">% IPK <span class="text-danger">*</span></small>
                            <div class="input-group">
                                <input maxlength="3" type="text" id="tambah-ipk" name="tambah_ipk" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kebersihan">
                        <div class="form-group">
                            <small class="form-control-label">Tarif per-Los<span class="text-danger">*</span></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input maxlength="15" type="text" id="tambah-kebersihan" name="tambah_kebersihan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
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
                                <input maxlength="15" type="text" id="tambah-airkotor" name="tambah_airkotor" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
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
                                <input maxlength="15" type="text" id="tambah-lainnya" name="tambah_lainnya" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group status-tarif">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="tambah_status"
                                id="tambah-status1"
                                value="1"
                                checked>
                            <label class="form-control-label" for="tambah-status1">
                                per-Kontrol
                            </label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="tambah_status"
                                id="tambah-status2"
                                value="2">
                            <label class="form-control-label" for="tambah-status2">
                                per-Los
                            </label>
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
        } else if(level == 2){
            airbersih();
        } else if(level == 3){
            keamananipk();
        } else if(level == 4){
            kebersihan();
        } else if(level == 5){
            airkotor();
        } else{
            lainnya();
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
            url: "/utilities/tarif",
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
