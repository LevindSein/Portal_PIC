<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div id="div-tambah-modal" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
            </div>
            <form id="tambah-form">
                <div class="modal-body" style="height: 60vh;">
                    <div name="row">
                        <div name="col">
                            <div class="form-group">
                                <small class="form-control-label">Pilih Periode <span class="text-danger">*</span></small>
                                <select required class="form-control form-control-sm" id="tambah-periode" name="tambah_periode">
                                    @foreach ($periode as $d)
                                    <option value="{{$d->id}}">{{$d->nicename}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Tempat Usaha Aktif <span class="text-danger">*</span></small>
                                <select required class="form-control form-control-sm" id="tambah-tempat" name="tambah_tempat"></select>
                            </div>
                            <div class="form-group tambah-los">
                                <small class="form-control-label">Nomor Los <span class="text-danger">*</span></small>
                                <select required id="tambah-los" name="tambah_los[]" class="form-control form-control-sm" multiple></select>
                            </div>
                            <div class="form-group tambah-pengguna">
                                <small class="form-control-label">Pengguna <span class="text-danger">*</span></small>
                                <select required class="form-control form-control-sm" id="tambah-pengguna" name="tambah_pengguna"></select>
                            </div>
                        </div>
                        <div name="col">
                            <div id="tambah-fasilitas">
                                <div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="tambah_listrik"
                                            id="tambah-listrik">
                                        <label class="form-control-label" for="tambah-listrik">
                                            Listrik
                                        </label>
                                    </div>
                                    <div id="div-tambah-listrik"></div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="tambah_airbersih"
                                            id="tambah-airbersih">
                                        <label class="form-control-label" for="tambah-airbersih">
                                            Air Bersih
                                        </label>
                                    </div>
                                    <div id="div-tambah-airbersih"></div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="tambah_keamananipk"
                                            id="tambah-keamananipk">
                                        <label class="form-control-label" for="tambah-keamananipk">
                                            Keamanan IPK
                                        </label>
                                    </div>
                                    <div id="div-tambah-keamananipk"></div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="tambah_kebersihan"
                                            id="tambah-kebersihan">
                                        <label class="form-control-label" for="tambah-kebersihan">
                                            Kebersihan
                                        </label>
                                    </div>
                                    <div id="div-tambah-kebersihan"></div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="tambah_airkotor"
                                            id="tambah-airkotor">
                                        <label class="form-control-label" for="tambah-airkotor">
                                            Air Kotor
                                        </label>
                                    </div>
                                    <div id="div-tambah-airkotor"></div>
                                </div>

                                <hr>
                                <div id="div-tambah-lainnya"></div>

                                <div class="form-group">
                                    <button type="button" id="tambah-lainnya-add" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus mr-1"></i>Fasilitas Lainnya</button>
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

        $("#tambah-tempat").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2tempat("#tambah-tempat", "/search/tempat", "-- Cari Tempat Usaha --");

        $("#tambah-pengguna").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2user("#tambah-pengguna", "/search/users", "-- Cari Pengguna --");

        $("#tambah-los").val('').html('').select2({placeholder: "-- Pilih Nomor Los --"});

        $(".tambah-los").hide();
        $(".tambah-pengguna").hide();
        $("#tambah-fasilitas").hide();
    }

    var lain = 0, index = 1;
    $("#add").click(function(){
        $("#tambah-modal").modal("show");

        $("#div-tambah-modal").removeClass('modal-lg modal-dialog-scrollable');
        $("div[name=row]").removeClass('row');
        $("div[name=col]").removeClass('col-lg-6');

        tambah_init();
    });

    $(document).on('change', '#tambah-tempat', function(){
        $(".tambah-los").fadeIn();
        $(".tambah-pengguna").fadeIn();
        $("#tambah-fasilitas").fadeIn();

        $("#div-tambah-modal").addClass('modal-lg modal-dialog-scrollable');
        $("div[name=row]").addClass('row');
        $("div[name=col]").addClass('col-lg-6');

        $.ajax({
            url: "/tagihan/tempat/" + $(this).val(),
            cache: false,
            method: "GET",
            dataType: "json",
            success:function(data)
            {
                if(data.success){
                    $('#tambah-los').val("").html("");
                    select2los("#tambah-los", "/search/" + data.success.group.name + "/los", "-- Pilih Nomor Los --");
                    var los = data.success.los;
                    $.each( los, function( i, val ) {
                        var option = $('<option></option>').attr('value', val).text(val).prop('selected', true);
                        $('#tambah-los').append(option).trigger('change');
                    });

                    if(data.success.pengguna.id){
                        $('#tambah-pengguna').val("").html("");
                        var pengguna = new Option(data.success.pengguna.name + " (" + data.success.pengguna.ktp + ")", data.success.pengguna.id, false, false);
                        $('#tambah-pengguna').append(pengguna).trigger('change');
                    }

                    if(data.success.trf_listrik_id){
                        $("#tambah-listrik").prop("checked", true);
                        tambahFasListrik();

                        $("#tambah-alat-listrik").val("").html("");
                        var alat  = new Option(data.success.alat_listrik_id.name + " (" + Number(data.success.alat_listrik_id.stand).toLocaleString('id-ID') + " - " + Number(data.success.alat_listrik_id.daya).toLocaleString('id-ID') + "W)", data.success.alat_listrik_id.id, false, false);
                        $("#tambah-alat-listrik").append(alat).trigger("change");

                        $("#tambah-trf-listrik").val("").html("");
                        var tarif = new Option(data.success.trf_listrik_id.name + " - " + data.success.trf_listrik_id.status, data.success.trf_listrik_id.id, false, false);
                        $("#tambah-trf-listrik").append(tarif).trigger("change");

                        $("#tambah-awal-listrik").val(Number(data.success.alat_listrik_id.stand).toLocaleString('id-ID'));

                        if(data.success.diskon.listrik){
                            $("#tambah-dis-listrik").val(data.success.diskon.listrik)
                        }
                    } else {
                        $("#tambah-listrik").prop("checked", false);
                        tambahFasListrik();
                    }

                    if(data.success.trf_airbersih_id){
                        $("#tambah-airbersih").prop("checked", true);
                        tambahFasAirbersih();

                        $("#tambah-alat-airbersih").val("").html("");
                        var alat  = new Option(data.success.alat_airbersih_id.name + " (" + Number(data.success.alat_airbersih_id.stand).toLocaleString('id-ID') + ")", data.success.alat_airbersih_id.id, false, false);
                        $("#tambah-alat-airbersih").append(alat).trigger("change");

                        $("#tambah-trf-airbersih").val("").html("");
                        var tarif = new Option(data.success.trf_airbersih_id.name + " - " + data.success.trf_airbersih_id.status, data.success.trf_airbersih_id.id, false, false);
                        $("#tambah-trf-airbersih").append(tarif).trigger("change");

                        $("#tambah-awal-airbersih").val(Number(data.success.alat_airbersih_id.stand).toLocaleString('id-ID'));

                        if(data.success.diskon.airbersih){
                            $("#tambah-dis-airbersih").val(data.success.diskon.airbersih)
                        }
                    } else {
                        $("#tambah-airbersih").prop("checked", false);
                        tambahFasAirbersih();
                    }

                    if(data.success.trf_keamananipk_id){
                        $("#tambah-keamananipk").prop("checked", true);
                        tambahFasKeamananipk();

                        $("#tambah-trf-keamananipk").val("").html("");
                        var tarif = new Option(data.success.trf_keamananipk_id.name + " - Rp " + Number(data.success.trf_keamananipk_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_keamananipk_id.status, data.success.trf_keamananipk_id.id, false, false);
                        $("#tambah-trf-keamananipk").append(tarif).trigger("change");

                        if(data.success.diskon.keamananipk){
                            $("#tambah-dis-keamananipk").val(Number(data.success.diskon.keamananipk).toLocaleString("id-ID"));
                        }
                    } else {
                        $("#tambah-keamananipk").prop("checked", false);
                        tambahFasKeamananipk();
                    }

                    if(data.success.trf_kebersihan_id){
                        $("#tambah-kebersihan").prop("checked", true);
                        tambahFasKebersihan();

                        $("#tambah-trf-kebersihan").val("").html("");
                        var tarif = new Option(data.success.trf_kebersihan_id.name + " - Rp " + Number(data.success.trf_kebersihan_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_kebersihan_id.status, data.success.trf_kebersihan_id.id, false, false);
                        $("#tambah-trf-kebersihan").append(tarif).trigger("change");

                        if(data.success.diskon.kebersihan){
                            $("#tambah-dis-kebersihan").val(Number(data.success.diskon.kebersihan).toLocaleString("id-ID"));
                        }
                    } else {
                        $("#tambah-kebersihan").prop("checked", false);
                        tambahFasKebersihan();
                    }

                    if(data.success.trf_airkotor_id){
                        $("#tambah-airkotor").prop("checked", true);
                        tambahFasAirkotor();

                        $("#tambah-trf-airkotor").val("").html("");
                        var tarif = new Option(data.success.trf_airkotor_id.name + " - Rp " + Number(data.success.trf_airkotor_id.data.Tarif).toLocaleString("id-ID") + " " + data.success.trf_airkotor_id.status, data.success.trf_airkotor_id.id, false, false);
                        $("#tambah-trf-airkotor").append(tarif).trigger("change");
                    } else {
                        $("#tambah-airkotor").prop("checked", false);
                        tambahFasAirkotor();
                    }

                    if(data.success.trf_lainnya_id){
                        lain = 0, index = 1;

                        $.each( data.success.trf_lainnya, function( i, val ) {
                            $("#tambah-lainnya-add").trigger("click");
                            $("#tambah-lainnya-" + index).val("").html("");
                            var lainnya = new Option(
                                val.name + " - Rp " + Number(val.data.Tarif).toLocaleString('id-ID') + " " + val.status,
                                val.id,
                                false,
                                false
                            );
                            $("#tambah-lainnya-" + (i+1)).append(lainnya).trigger("change");
                        });
                    } else {
                        $("#div-tambah-lainnya").html("");
                        lain = 0, index = 1;
                    }
                }

                if(data.error){
                    toastr.error(data.error);
                }

                if(data.debug){
                    console.log(data.debug);
                    $("#periode").val(data.debug).change();
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
    });

    $('#tambah-listrik').click(tambahFasListrik).each(tambahFasListrik);
    function tambahFasListrik(){
        if($("#tambah-listrik").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Alat Meter <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-alat-listrik" name="tambah_alat_listrik" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-trf-listrik" name="tambah_trf_listrik" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (% Tagihan)</small>';
            html += '<input maxlength="3" type="text" id="tambah-dis-listrik" name="tambah_dis_listrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control form-control-sm">';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Awal Stand <span class="text-danger">*</span></small>';
            html += '<input required id="tambah-awal-listrik" name="tambah_awal_listrik" class="number form-control form-control-sm" placeholder="Masukkan Nilai Awal Stand" />';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Akhir Stand <span class="text-danger">*</span></small>';
            html += '<input required id="tambah-akhir-listrik" name="tambah_akhir_listrik" class="number form-control form-control-sm" placeholder="Masukkan Nilai Akhir Stand" />';
            html += '</div>';
            html += '<hr>';

            $("#div-tambah-listrik").html(html).hide();

            $("#tambah-alat-listrik").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2alat("#tambah-alat-listrik", "/search/alat", 1, "-- Cari Alat --");

            $("#tambah-trf-listrik").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif1("#tambah-trf-listrik", "/search/tarif", 1, "-- Cari Tarif --");

            $("#div-tambah-listrik").fadeIn();
        }
        else{
            $("#div-tambah-listrik").html('');
        }
    }

    $('#tambah-airbersih').click(tambahFasAirbersih).each(tambahFasAirbersih);
    function tambahFasAirbersih(){
        if($("#tambah-airbersih").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Alat Meter <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-alat-airbersih" name="tambah_alat_airbersih" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-trf-airbersih" name="tambah_trf_airbersih" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (% Tagihan)</small>';
            html += '<input maxlength="3" type="text" id="tambah-dis-airbersih" name="tambah_dis_airbersih" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control form-control-sm">';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Awal Stand <span class="text-danger">*</span></small>';
            html += '<input required id="tambah-awal-airbersih" name="tambah_awal_airbersih" class="number form-control form-control-sm" placeholder="Masukkan Nilai Awal Stand" />';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Akhir Stand <span class="text-danger">*</span></small>';
            html += '<input required id="tambah-akhir-airbersih" name="tambah_akhir_airbersih" class="number form-control form-control-sm" placeholder="Masukkan Nilai Akhir Stand" />';
            html += '</div>';
            html += '<hr>';

            $("#div-tambah-airbersih").html(html).hide();

            $("#tambah-alat-airbersih").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2alat("#tambah-alat-airbersih", "/search/alat", 2, "-- Cari Alat --");

            $("#tambah-trf-airbersih").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif1("#tambah-trf-airbersih", "/search/tarif", 2, "-- Cari Tarif --");

            $("#div-tambah-airbersih").fadeIn();
        }
        else{
            $("#div-tambah-airbersih").html('');
        }
    }

    $('#tambah-keamananipk').click(tambahFasKeamananipk).each(tambahFasKeamananipk);
    function tambahFasKeamananipk(){
        if($("#tambah-keamananipk").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-trf-keamananipk" name="tambah_trf_keamananipk" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (per-Kontrol)</small>';
            html += '<input maxlength="15" type="text" id="tambah-dis-keamananipk" name="tambah_dis_keamananipk" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-sm">';
            html += '</div>';
            html += '<hr>';

            $("#div-tambah-keamananipk").html(html).hide();

            $("#tambah-trf-keamananipk").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif2("#tambah-trf-keamananipk", "/search/tarif", 3, "-- Cari Tarif --");

            $("#div-tambah-keamananipk").fadeIn();
        }
        else{
            $("#div-tambah-keamananipk").html('');
        }
    }

    $('#tambah-kebersihan').click(tambahFasKebersihan).each(tambahFasKebersihan);
    function tambahFasKebersihan(){
        if($("#tambah-kebersihan").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-trf-kebersihan" name="tambah_trf_kebersihan" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (per-Kontrol)</small>';
            html += '<input maxlength="15" type="text" id="tambah-dis-kebersihan" name="tambah_dis_kebersihan" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-sm">';
            html += '</div>';
            html += '<hr>';

            $("#div-tambah-kebersihan").html(html).hide();

            $("#tambah-trf-kebersihan").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif2("#tambah-trf-kebersihan", "/search/tarif", 4, "-- Cari Tarif --");

            $("#div-tambah-kebersihan").fadeIn();
        }
        else{
            $("#div-tambah-kebersihan").html('');
        }
    }

    $('#tambah-airkotor').click(tambahFasAirkotor).each(tambahFasAirkotor);
    function tambahFasAirkotor(){
        if($("#tambah-airkotor").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-trf-airkotor" name="tambah_trf_airkotor" class="form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (per-Kontrol)</small>';
            html += '<input maxlength="15" type="text" id="tambah-dis-airkotor" name="tambah_dis_airkotor" autocomplete="off" placeholder="Ketikkan dalam angka" class="number form-control form-control-sm">';
            html += '</div>';

            $("#div-tambah-airkotor").html(html).hide();

            $("#tambah-trf-airkotor").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });
            select2tarif2("#tambah-trf-airkotor", "/search/tarif", 5, "-- Cari Tarif --");

            $("#div-tambah-airkotor").fadeIn();
        }
        else{
            $("#div-tambah-airkotor").html('');
        }
    }

    $("#tambah-lainnya-add").on('click', function () {
        var html = '';
        html += '<div name="div_lain" class="form-group">';
        html += '<div class="d-flex justify-content-between">';
        html += '<small class="form-control-label">Tarif Lainnya</small>';
        html += '<a type="button" href="javascript:void(0)" id="tambah-lainnya-rmv">';
        html += '<small class="form-control-label text-danger"><i class="fas fa-fw fa-times"></i></small>';
        html += '</a>';
        html += '</div>';
        html += '<select required id="tambah-lainnya-'+ index + '" name="tambah_lainnya[]" class="form-control form-control-sm"></select>';
        html += '</div>';

        if(lain < 10){
            $('#div-tambah-lainnya').append(html).hide();
            select2tarif2("#tambah-lainnya-" + index, "/search/tarif", 6,"-- Cari Tarif --");

            $("#tambah-lainnya-" + index).val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });

            $('#div-tambah-lainnya').fadeIn();

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
    $(document).on('click', '#tambah-lainnya-rmv', function () {
        lain--;
        $(this).closest("[name='div_lain']").remove();
    });

    $(document).on('change', "#tambah-alat-listrik, #tambah-alat-airbersih", function() {
        $.ajax({
            url: "/search/stand/" + $(this).val(),
            cache: false,
            method: "GET",
            dataType: "json",
            success:function(data)
            {
                if(data.level == 2){
                    $("#tambah-awal-airbersih").val(Number(data.stand).toLocaleString('id-ID'));
                } else {
                    $("#tambah-awal-listrik").val(Number(data.stand).toLocaleString('id-ID'));
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
            url: "/tagihan",
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
                    $("#periode").val(data.debug).change();
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
