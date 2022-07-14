<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
            </div>
            <form id="tambah-form">
                <div class="modal-body" style="height: 60vh;">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="form-group">
                                <small class="form-control-label">Grup / Blok <span class="text-danger">*</span></small>
                                <select required class="form-control form-control-sm" id="tambah-group" name="tambah_group"></select>
                            </div>
                            <div class="form-group tambah-los">
                                <small class="form-control-label">Nomor Los <span class="text-danger">*</span></small>
                                <textarea rows="3" id="tambah-los" name="tambah_los" autocomplete="off" placeholder="Contoh: 1,2,3A,4,5,6" class="los form-control" style="text-transform: uppercase"></textarea>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Kode Kontrol <span class="text-danger">*</span></small>
                                <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="25" class="name form-control form-control-sm" placeholder="Otomatis setelah Grup dan Los terisi" style="text-transform: uppercase;"/>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Status <span class="text-danger">*</span></small>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="tambah_status"
                                        id="tambah-status1"
                                        value="1"
                                        checked>
                                    <label class="form-control-label" for="tambah-status1">
                                        Aktif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="tambah_status"
                                        id="tambah-status0"
                                        value="0">
                                    <label class="form-control-label" for="tambah-status0">
                                        Nonaktif
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
                                        Bebas Bayar
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Pengguna</small>
                                <select class="form-control form-control-sm" id="tambah-pengguna" name="tambah_pengguna"></select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Pemilik</small>
                                <select class="form-control form-control-sm" id="tambah-pemilik" name="tambah_pemilik"></select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Keterangan</small>
                                <textarea rows="3" id="tambah-ket" name="tambah_ket" autocomplete="off" placeholder="Ketikkan Keterangan . . ." class="form-control" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <h4 class="text-center">FASILITAS</h4>
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
        $("#tambah-name").val('').prop('disabled', true);

        $("#tambah-group").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2group("#tambah-group", "/search/groups", "-- Cari Grup / Blok --");

        $("#tambah-pengguna").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2user("#tambah-pengguna", "/search/users", "-- Cari Pengguna --");

        $("#tambah-pemilik").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });
        select2user("#tambah-pemilik", "/search/users", "-- Cari Pemilik --");

        $("#div-tambah-listrik").html('');
        $("#div-tambah-airbersih").html('');
        $("#div-tambah-keamananipk").html('');
        $("#div-tambah-kebersihan").html('');
        $("#div-tambah-airkotor").html('');
        $("#div-tambah-lainnya").html('');
    }

    var lain = 0, index = 1;
    $(".add").click(function(){
        $("#tambah-modal").modal("show");

        tambah_init();
        lain = 0, index = 1;
    });

    $(document).on("input", '#tambah-group, #tambah-los', function(e) {
        if($("#tambah-group").val() == '' && $("#tambah-los").val() == ''){
            $("#tambah-name").val('').prop('disabled', true);
        } else {
            $("#tambah-name").prop('disabled', false);
            var dataset = {
                'group' : $("#tambah-group").val(),
                'los' : $("#tambah-los").val(),
            };
            $.ajax({
                url: "/data/tempat/generate/kontrol",
                type: "GET",
                cache: false,
                data: dataset,
                success:function(data)
                {
                    $("#tambah-name").val(data.success);
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("System error.");
                    console.log(data);
                }
            });
        }
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
            url: "/data/tempat",
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
