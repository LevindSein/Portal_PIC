<!--begin::Modal-->
<div class="modal fade" id="edit-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
            </div>
            <form id="edit-form">
                <div class="modal-body" style="height: 60vh;">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="form-group">
                                <small class="form-control-label">Grup / Blok <span class="text-danger">*</span></small>
                                <select required class="form-control form-control-sm select2" id="edit-group" name="edit_group"></select>
                            </div>
                            <div class="form-group edit-los">
                                <small class="form-control-label">Nomor Los <span class="text-danger">*</span></small>
                                <select required id="edit-los" name="edit_los[]" class="form-control form-control-sm" multiple></select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Kode Kontrol <span class="text-danger">*</span></small>
                                <input required type="text" id="edit-name" name="edit_name" autocomplete="off" maxlength="25" class="name form-control form-control-sm" placeholder="Otomatis setelah Grup dan Los terisi" style="text-transform: uppercase;"/>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Status <span class="text-danger">*</span></small>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="edit_status"
                                        id="edit-status1"
                                        value="1">
                                    <label class="form-control-label" for="edit-status1">
                                        Aktif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="edit_status"
                                        id="edit-status0"
                                        value="0">
                                    <label class="form-control-label" for="edit-status0">
                                        Nonaktif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="edit_status"
                                        id="edit-status2"
                                        value="2">
                                    <label class="form-control-label" for="edit-status2">
                                        Bebas Bayar
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Pengguna</small>
                                <select class="form-control form-control-sm select2" id="edit-pengguna" name="edit_pengguna"></select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Pemilik</small>
                                <select class="form-control form-control-sm select2" id="edit-pemilik" name="edit_pemilik"></select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Keterangan</small>
                                <textarea rows="3" id="edit-ket" name="edit_ket" autocomplete="off" placeholder="Ketikkan Keterangan . . ." class="form-control" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <h4 class="text-center">FASILITAS</h4>
                            <div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="edit_listrik"
                                        id="edit-listrik">
                                    <label class="form-control-label" for="edit-listrik">
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
                                    <label class="form-control-label" for="edit-airbersih">
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
                                    <label class="form-control-label" for="edit-keamananipk">
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
                                    <label class="form-control-label" for="edit-kebersihan">
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
                                    <label class="form-control-label" for="edit-airkotor">
                                        Air Kotor
                                    </label>
                                </div>
                                <div id="div-edit-airkotor"></div>
                            </div>

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
        $("#edit-name").val('').prop('disabled', true);

        $("#edit-group").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2group("#edit-group", "/search/groups", "-- Cari Grup / Blok --");

        $("#edit-los").val('').html('').prop("disabled",true).select2({placeholder: "Grup perlu diisi terlebih dahulu"});

        $("#edit-pengguna").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2user("#edit-pengguna", "/search/users", "-- Cari Pengguna --");

        $("#edit-pemilik").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2user("#edit-pemilik", "/search/users", "-- Cari Pemilik --");

        $("#div-edit-listrik").html('');
        $("#div-edit-airbersih").html('');
        $("#div-edit-keamananipk").html('');
        $("#div-edit-kebersihan").html('');
        $("#div-edit-airkotor").html('');
        $("#div-edit-lainnya").html('');
    }

    var id, lain = 0, index = 1;
    $(document).on('click', '.edit', function(e){
        e.preventDefault();
        id = $(this).attr("id");
        edit_init();
        lain = 0, index = 1;

        $.ajax({
            url: "/services/place/" + id + "/edit",
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
                    $('#edit-group').val("").html("");
                    var group = new Option(data.success.group.name, data.success.group.name, false, false);
                    $('#edit-group').append(group).trigger('change');

                    $('#edit-los').val("").html("");
                    var los = data.success.los;
                    $.each( los, function( i, val ) {
                        var option = $('<option></option>').attr('value', val).text(val).prop('selected', true);
                        $('#edit-los').append(option).trigger('change');
                    });

                    if(data.success.pengguna.id){
                        $('#edit-pengguna').val("").html("");
                        var pengguna = new Option(data.success.pengguna.name + " (" + data.success.pengguna.ktp + ")", data.success.pengguna.id, false, false);
                        $('#edit-pengguna').append(pengguna).trigger('change');
                    }

                    if(data.success.pemilik.id){
                        $('#edit-pemilik').val("").html("");
                        var pemilik = new Option(data.success.pemilik.name + " (" + data.success.pemilik.ktp + ")", data.success.pemilik.id, false, false);
                        $('#edit-pemilik').append(pemilik).trigger('change');
                    }

                    $("#edit-name").val(data.success.name);

                    $("#edit-status" + data.success.status).prop("checked", true);
                    $("#edit-ket").val(data.success.ket);

                    if(data.success.trf_listrik_id){
                        $("#edit-listrik").prop("checked", true);
                        editFasListrik();

                        $("#edit-alat-listrik").val("").html("");
                        var alat  = new Option(data.success.alat_listrik_id.name + " (" + data.success.alat_listrik_id.stand + " - " + data.success.alat_listrik_id.daya + "W)", data.success.alat_listrik_id.id, false, false);
                        $("#edit-alat-listrik").append(alat).trigger("change");

                        $("#edit-trf-listrik").val("").html("");
                        var tarif = new Option(data.success.trf_listrik_id.name + " - " + data.success.trf_listrik_id.status, data.success.trf_listrik_id.id, false, false);
                        $("#edit-trf-listrik").append(tarif).trigger("change");

                        if(data.success.diskon.listrik){
                            $("#edit-dis-listrik").val(data.success.diskon.listrik)
                        }
                    }

                    if(data.success.trf_airbersih_id){
                        $("#edit-airbersih").prop("checked", true);
                        editFasAirbersih();

                        $("#edit-alat-airbersih").val("").html("");
                        var alat  = new Option(data.success.alat_airbersih_id.name + " (" + data.success.alat_airbersih_id.stand + ")", data.success.alat_airbersih_id.id, false, false);
                        $("#edit-alat-airbersih").append(alat).trigger("change");

                        $("#edit-trf-airbersih").val("").html("");
                        var tarif = new Option(data.success.trf_airbersih_id.name + " - " + data.success.trf_airbersih_id.status, data.success.trf_airbersih_id.id, false, false);
                        $("#edit-trf-airbersih").append(tarif).trigger("change");

                        if(data.success.diskon.airbersih){
                            $("#edit-dis-airbersih").val(data.success.diskon.airbersih)
                        }
                    }

                    if(data.success.trf_keamananipk_id){
                        $("#edit-keamananipk").prop("checked", true);
                        editFasKeamananipk();

                        $("#edit-trf-keamananipk").val("").html("");
                        var tarif = new Option(data.success.trf_keamananipk_id.name + " - Rp " + Number(data.success.trf_keamananipk_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_keamananipk_id.status, data.success.trf_keamananipk_id.id, false, false);
                        $("#edit-trf-keamananipk").append(tarif).trigger("change");

                        if(data.success.diskon.keamananipk){
                            $("#edit-dis-keamananipk").val(Number(data.success.diskon.keamananipk).toLocaleString("id-ID"));
                        }
                    }

                    if(data.success.trf_kebersihan_id){
                        $("#edit-kebersihan").prop("checked", true);
                        editFasKebersihan();

                        $("#edit-trf-kebersihan").val("").html("");
                        var tarif = new Option(data.success.trf_kebersihan_id.name + " - Rp " + Number(data.success.trf_kebersihan_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_kebersihan_id.status, data.success.trf_kebersihan_id.id, false, false);
                        $("#edit-trf-kebersihan").append(tarif).trigger("change");

                        if(data.success.diskon.kebersihan){
                            $("#edit-dis-kebersihan").val(Number(data.success.diskon.kebersihan).toLocaleString("id-ID"));
                        }
                    }

                    if(data.success.trf_airkotor_id){
                        $("#edit-airkotor").prop("checked", true);
                        editFasAirkotor();

                        $("#edit-trf-airkotor").val("").html("");
                        var tarif = new Option(data.success.trf_airkotor_id.name + " - Rp " + Number(data.success.trf_airkotor_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_airkotor_id.status, data.success.trf_airkotor_id.id, false, false);
                        $("#edit-trf-airkotor").append(tarif).trigger("change");
                    }

                    if(data.success.trf_lainnya_id){
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

    $(document).on("change", "#edit-group", function(e) {
        var group = $("#edit-group").val();
        $("#edit-los").prop("disabled", false);
        $("#edit-los").val("").html("");
        select2los("#edit-los", "/search/" + group + "/los", "-- Pilih Nomor Los --");
    });

    $(document).on("change", "#edit-group, #edit-los", function(e) {
        if($("#edit-los").val() == ''){
            $("#edit-name").val('').prop("disabled", true);
        } else {
            $("#edit-name").prop("disabled", false);
        }
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
            url: "/services/place/" + id,
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
