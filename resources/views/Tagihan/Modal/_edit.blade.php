<!--begin::Modal-->
<div class="modal fade" id="edit-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title">Edit</h5>
            </div>
            <form id="edit-form">
                <div class="modal-body" style="height: 60vh;">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group edit-los">
                                <small class="form-control-label">Nomor Los <span class="text-danger">*</span></small>
                                <textarea required rows="3" id="edit-los" name="edit_los" autocomplete="off" placeholder="Contoh: 1,2,3A,4,5,6" class="los form-control" style="text-transform: uppercase"></textarea>
                            </div>
                            <div class="form-group edit-pengguna">
                                <small class="form-control-label">Pengguna <span class="text-danger">*</span></small>
                                <select required class="form-control form-control-sm" id="edit-pengguna" name="edit_pengguna"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="edit_listrik"
                                        id="edit-listrik">
                                    <label class="form-control-label" for="edit-listrik" id="label-edit-listrik">
                                        Listrik
                                    </label>
                                </div>
                                <div id="div-edit-listrik"></div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="edit_airbersih"
                                        id="edit-airbersih">
                                    <label class="form-control-label" for="edit-airbersih" id="label-edit-airbersih">
                                        Air Bersih
                                    </label>
                                </div>
                                <div id="div-edit-airbersih"></div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="edit_keamananipk"
                                        id="edit-keamananipk">
                                    <label class="form-control-label" for="edit-keamananipk" id="label-edit-keamananipk">
                                        Keamanan IPK
                                    </label>
                                </div>
                                <div id="div-edit-keamananipk"></div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="edit_kebersihan"
                                        id="edit-kebersihan">
                                    <label class="form-control-label" for="edit-kebersihan" id="label-edit-kebersihan">
                                        Kebersihan
                                    </label>
                                </div>
                                <div id="div-edit-kebersihan"></div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="edit_airkotor"
                                        id="edit-airkotor">
                                    <label class="form-control-label" for="edit-airkotor" id="label-edit-airkotor">
                                        Air Kotor
                                    </label>
                                </div>
                                <div id="div-edit-airkotor"></div>
                            </div>

                            <hr>
                            <div id="div-edit-lainnya"></div>

                            <div class="form-group">
                                <button type="button" id="edit-lainnya-add" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus mr-1"></i>Fasilitas Lainnya</button>
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

        $("#edit-pengguna").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2user("#edit-pengguna", "/search/users", "-- Cari Pengguna --");

        $("#edit-los").val('');

        $("#div-edit-listrik").html('');
        $("#div-edit-airbersih").html('');
        $("#div-edit-keamananipk").html('');
        $("#div-edit-kebersihan").html('');
        $("#div-edit-airkotor").html('');
        $("#div-edit-lainnya").html('');
    }

    var id, lain = 0, index = 1, periode_id;

    $(document).on('click', '.edit', function(e){
        e.preventDefault();
        id = $(this).attr("id");
        edit_init();
        lain = 0, index = 1;

        $.ajax({
            url: "/tagihan/" + id + "/edit",
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
                    periode_id  = data.success.periode.id;

                    $(".title").text('Edit : Periode ' + data.success.periode.nicename + ' - ' + data.success.name);

                    $('#edit-los').val(data.success.los.data);

                    $('#edit-pengguna').val("").html("");
                    var pengguna = new Option(data.success.pengguna.name + " (" + data.success.pengguna.ktp + ")", data.success.pengguna.id, false, false);
                    $('#edit-pengguna').append(pengguna).trigger('change');

                    if(data.success.listrik){
                        if(data.success.listrik.lunas){
                            $("#edit-listrik").prop("checked", false).prop("disabled", true);
                            $("#edit-listrik").hide();
                            $("#label-edit-listrik").hide();
                        } else {
                            $("#edit-listrik").prop("checked", true).prop("disabled", false);
                            $("#edit-listrik").show();
                            $("#label-edit-listrik").show();
                            editFasListrik();

                            $("#edit-alat-listrik").val("").html("");
                            var alat  = new Option(data.success.alat_listrik_id.name + " (" + Number(data.success.alat_listrik_id.stand).toLocaleString('id-ID') + " - " + Number(data.success.alat_listrik_id.daya).toLocaleString('id-ID') + "W)", data.success.alat_listrik_id.id, false, false);
                            $("#edit-alat-listrik").append(alat).trigger("change");

                            $("#edit-trf-listrik").val("").html("");
                            var tarif = new Option(data.success.trf_listrik_id.name + " - " + data.success.trf_listrik_id.status, data.success.trf_listrik_id.id, false, false);
                            $("#edit-trf-listrik").append(tarif).trigger("change");

                            if(data.success.listrik.diskon_persen){
                                $("#edit-dis-listrik").val(data.success.listrik.diskon_persen);
                            }

                            setTimeout(() => {
                                $("#edit-awal-listrik").val(Number(data.success.listrik.awal).toLocaleString('id-ID'));
                                $("#edit-akhir-listrik").val(Number(data.success.listrik.akhir).toLocaleString('id-ID'));
                            }, 1000);
                        }
                    }

                    if(data.success.airbersih){
                        if(data.success.airbersih.lunas){
                            $("#edit-airbersih").prop("checked", false).prop("disabled", true);
                            $("#edit-airbersih").hide();
                            $("#label-edit-airbersih").hide();
                        } else {
                            $("#edit-airbersih").prop("checked", true).prop("disabled", false);
                            $("#edit-airbersih").show();
                            $("#label-edit-airbersih").show();
                            editFasAirbersih();

                            $("#edit-alat-airbersih").val("").html("");
                            var alat  = new Option(data.success.alat_airbersih_id.name + " (" + Number(data.success.alat_airbersih_id.stand).toLocaleString('id-ID') + ")", data.success.alat_airbersih_id.id, false, false);
                            $("#edit-alat-airbersih").append(alat).trigger("change");

                            $("#edit-trf-airbersih").val("").html("");
                            var tarif = new Option(data.success.trf_airbersih_id.name + " - " + data.success.trf_airbersih_id.status, data.success.trf_airbersih_id.id, false, false);
                            $("#edit-trf-airbersih").append(tarif).trigger("change");

                            if(data.success.airbersih.diskon_persen){
                                $("#edit-dis-airbersih").val(data.success.airbersih.diskon_persen);
                            }

                            setTimeout(() => {
                                $("#edit-awal-airbersih").val(Number(data.success.airbersih.awal).toLocaleString('id-ID'));
                                $("#edit-akhir-airbersih").val(Number(data.success.airbersih.akhir).toLocaleString('id-ID'));
                            }, 1000);
                        }
                    }

                    if(data.success.keamananipk){
                        if(data.success.keamananipk.lunas){
                            $("#edit-keamananipk").prop("checked", false).prop("disabled", true);
                            $("#edit-keamananipk").hide();
                            $("#label-edit-keamananipk").hide();
                        } else {
                            $("#edit-keamananipk").prop("checked", true).prop("disabled", false);
                            $("#edit-keamananipk").show();
                            $("#label-edit-keamananipk").show();
                            editFasKeamananipk();

                            $("#edit-trf-keamananipk").val("").html("");
                            var tarif = new Option(data.success.trf_keamananipk_id.name + " - Rp " + Number(data.success.trf_keamananipk_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_keamananipk_id.status, data.success.trf_keamananipk_id.id, false, false);
                            $("#edit-trf-keamananipk").append(tarif).trigger("change");

                            if(data.success.keamananipk.diskon){
                                $("#edit-dis-keamananipk").val(Number(data.success.keamananipk.diskon).toLocaleString("id-ID"));
                            }
                        }
                    }

                    if(data.success.kebersihan){
                        if(data.success.kebersihan.lunas){
                            $("#edit-kebersihan").prop("checked", false).prop("disabled", true);
                            $("#edit-kebersihan").hide();
                            $("#label-edit-kebersihan").hide();
                        } else {
                            $("#edit-kebersihan").prop("checked", true).prop("disabled", false);
                            $("#edit-kebersihan").show();
                            $("#label-edit-kebersihan").show();
                            editFasKebersihan();

                            $("#edit-trf-kebersihan").val("").html("");
                            var tarif = new Option(data.success.trf_kebersihan_id.name + " - Rp " + Number(data.success.trf_kebersihan_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_kebersihan_id.status, data.success.trf_kebersihan_id.id, false, false);
                            $("#edit-trf-kebersihan").append(tarif).trigger("change");

                            if(data.success.kebersihan.diskon){
                                $("#edit-dis-kebersihan").val(Number(data.success.kebersihan.diskon).toLocaleString("id-ID"));
                            }
                        }
                    }

                    if(data.success.airkotor){
                        if(data.success.airkotor.lunas){
                            $("#edit-airkotor").prop("checked", false).prop("disabled", true);
                            $("#edit-airkotor").hide();
                            $("#label-edit-airkotor").hide();
                        } else {
                            $("#edit-airkotor").prop("checked", true).prop("disabled", false);
                            $("#edit-airkotor").show();
                            $("#label-edit-airkotor").show();
                            editFasAirkotor();

                            $("#edit-trf-airkotor").val("").html("");
                            var tarif = new Option(data.success.trf_airkotor_id.name + " - Rp " + Number(data.success.trf_airkotor_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_airkotor_id.status, data.success.trf_airkotor_id.id, false, false);
                            $("#edit-trf-airkotor").append(tarif).trigger("change");

                            if(data.success.airkotor.diskon){
                                $("#edit-dis-airkotor").val(Number(data.success.airkotor.diskon).toLocaleString("id-ID"));
                            }
                        }
                    }

                    if(data.success.lainnya){
                        if(data.success.lainnya.lunas){
                            $("#edit-lainnya-add").prop("disabled", true);
                            $("#edit-lainnya-add").hide();
                        } else {
                            $("#edit-lainnya-add").prop("disabled", false);
                            $("#edit-lainnya-add").show();
                            $.each( data.success.trf_lainnya, function( i, val ) {
                                $("#edit-lainnya-add").trigger("click");
                                $("#edit-lainnya-" + index).val("").html("");
                                var lainnya = new Option(
                                    val.name + " - Rp " + Number(val.data.Tarif).toLocaleString('id-ID') + " " + val.status,
                                    val.id,
                                    false,
                                    false
                                );
                                $("#edit-lainnya-" + (i+1)).append(lainnya).trigger("change");
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
    });

    $('#edit-listrik').click(editFasListrik).each(editFasListrik);
    function editFasListrik(){
        if($("#edit-listrik").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Alat Meter <span class="text-danger">*</span></small>';
            html += '<select required id="edit-alat-listrik" name="edit_alat_listrik" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="edit-trf-listrik" name="edit_trf_listrik" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (% Tagihan)</small>';
            html += '<input maxlength="3" type="text" id="edit-dis-listrik" name="edit_dis_listrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control form-control-sm">';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Awal Stand <span class="text-danger">*</span></small>';
            html += '<input required maxlength="15" id="edit-awal-listrik" name="edit_awal_listrik" class="number form-control form-control-sm" placeholder="Masukkan Nilai Awal Stand" />';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Akhir Stand <span class="text-danger">*</span></small>';
            html += '<input required maxlength="15" id="edit-akhir-listrik" name="edit_akhir_listrik" class="number form-control form-control-sm" placeholder="Masukkan Nilai Akhir Stand" />';
            html += '</div>';
            html += '<hr>';

            $("#div-edit-listrik").html(html).hide();

            $("#edit-alat-listrik").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2alat("#edit-alat-listrik", "/search/alat", 1, "-- Cari Alat --");

            $("#edit-trf-listrik").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif1("#edit-trf-listrik", "/search/tarif", 1, "-- Cari Tarif --");

            $("#div-edit-listrik").fadeIn();
        }
        else{
            $("#div-edit-listrik").html('');
        }
    }

    $('#edit-airbersih').click(editFasAirbersih).each(editFasAirbersih);
    function editFasAirbersih(){
        if($("#edit-airbersih").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Alat Meter <span class="text-danger">*</span></small>';
            html += '<select required id="edit-alat-airbersih" name="edit_alat_airbersih" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="edit-trf-airbersih" name="edit_trf_airbersih" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (% Tagihan)</small>';
            html += '<input maxlength="3" type="text" id="edit-dis-airbersih" name="edit_dis_airbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control form-control-sm">';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Awal Stand <span class="text-danger">*</span></small>';
            html += '<input required maxlength="15" id="edit-awal-airbersih" name="edit_awal_airbersih" class="number form-control form-control-sm" placeholder="Masukkan Nilai Awal Stand" />';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Akhir Stand <span class="text-danger">*</span></small>';
            html += '<input required maxlength="15" id="edit-akhir-airbersih" name="edit_akhir_airbersih" class="number form-control form-control-sm" placeholder="Masukkan Nilai Akhir Stand" />';
            html += '</div>';
            html += '<hr>';

            $("#div-edit-airbersih").html(html).hide();

            $("#edit-alat-airbersih").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2alat("#edit-alat-airbersih", "/search/alat", 2, "-- Cari Alat --");

            $("#edit-trf-airbersih").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif1("#edit-trf-airbersih", "/search/tarif", 2, "-- Cari Tarif --");

            $("#div-edit-airbersih").fadeIn();
        }
        else{
            $("#div-edit-airbersih").html('');
        }
    }

    $('#edit-keamananipk').click(editFasKeamananipk).each(editFasKeamananipk);
    function editFasKeamananipk(){
        if($("#edit-keamananipk").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="edit-trf-keamananipk" name="edit_trf_keamananipk" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (per-Kontrol)</small>';
            html += '<input maxlength="15" type="text" id="edit-dis-keamananipk" name="edit_dis_keamananipk" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-sm">';
            html += '</div>';
            html += '<hr>';

            $("#div-edit-keamananipk").html(html).hide();

            $("#edit-trf-keamananipk").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif2("#edit-trf-keamananipk", "/search/tarif", 3, "-- Cari Tarif --");

            $("#div-edit-keamananipk").fadeIn();
        }
        else{
            $("#div-edit-keamananipk").html('');
        }
    }

    $('#edit-kebersihan').click(editFasKebersihan).each(editFasKebersihan);
    function editFasKebersihan(){
        if($("#edit-kebersihan").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="edit-trf-kebersihan" name="edit_trf_kebersihan" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (per-Kontrol)</small>';
            html += '<input maxlength="15" type="text" id="edit-dis-kebersihan" name="edit_dis_kebersihan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-sm">';
            html += '</div>';
            html += '<hr>';

            $("#div-edit-kebersihan").html(html).hide();

            $("#edit-trf-kebersihan").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif2("#edit-trf-kebersihan", "/search/tarif", 4, "-- Cari Tarif --");

            $("#div-edit-kebersihan").fadeIn();
        }
        else{
            $("#div-edit-kebersihan").html('');
        }
    }

    $('#edit-airkotor').click(editFasAirkotor).each(editFasAirkotor);
    function editFasAirkotor(){
        if($("#edit-airkotor").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="edit-trf-airkotor" name="edit_trf_airkotor" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (per-Kontrol)</small>';
            html += '<input maxlength="15" type="text" id="edit-dis-airkotor" name="edit_dis_airkotor" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-sm">';
            html += '</div>';

            $("#div-edit-airkotor").html(html).hide();

            $("#edit-trf-airkotor").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif2("#edit-trf-airkotor", "/search/tarif", 5, "-- Cari Tarif --");

            $("#div-edit-airkotor").fadeIn();
        }
        else{
            $("#div-edit-airkotor").html('');
        }
    }

    $("#edit-lainnya-add").on('click', function () {
        var html = '';
        html += '<div name="div_lain" class="form-group">';
        html += '<div class="d-flex justify-content-between">';
        html += '<small class="form-control-label">Tarif Lainnya</small>';
        html += '<a type="button" href="javascript:void(0)" id="edit-lainnya-rmv">';
        html += '<small class="form-control-label text-danger"><i class="fas fa-fw fa-times"></i></small>';
        html += '</a>';
        html += '</div>';
        html += '<select required id="edit-lainnya-'+ index + '" name="edit_lainnya[]" class="form-control form-control-sm"></select>';
        html += '</div>';

        if(lain < 10){
            $('#div-edit-lainnya').append(html).hide();
            select2tarif2("#edit-lainnya-" + index, "/search/tarif", 6,"-- Cari Tarif --");

            $("#edit-lainnya-" + index).val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });

            $('#div-edit-lainnya').fadeIn();

            index++;
            lain++;
        }
        else{
            toastr.options = {
                "closeButton": true,
                "preventDuplicates": true,
            };
            toastr.error("Telah mencapai maksimal.");
        }
    });
    $(document).on('click', '#edit-lainnya-rmv', function () {
        lain--;
        $(this).closest("[name='div_lain']").remove();
    });

    $(document).on('change', "#edit-alat-listrik, #edit-alat-airbersih", function() {
        $.ajax({
            url: "/search/stand/" + $(this).val(),
            cache: false,
            method: "GET",
            dataType: "json",
            success:function(data)
            {
                if(data.level == 2){
                    $("#edit-awal-airbersih").val(Number(data.old).toLocaleString('id-ID'));
                    $("#edit-akhir-airbersih").val(Number(data.stand).toLocaleString('id-ID'));
                } else {
                    $("#edit-awal-listrik").val(Number(data.old).toLocaleString('id-ID'));
                    $("#edit-akhir-listrik").val(Number(data.stand).toLocaleString('id-ID'));
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
            }
        });
    })

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
            url: "/tagihan/" + id + "?periode_id=" + periode_id,
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
