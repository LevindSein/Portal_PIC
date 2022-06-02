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
                                <select required class="form-control form-control-sm select2" id="tambah-group" name="tambah_group"></select>
                            </div>
                            <div class="form-group tambah-los">
                                <small class="form-control-label">Nomor Los <span class="text-danger">*</span></small>
                                <select required id="tambah-los" name="tambah_los[]" class="select2 form-control form-control-sm" multiple></select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Kode Kontrol <span class="text-danger">*</span></small>
                                <input required type="text" id="tambah-name" name="tambah_name" autocomplete="off" maxlength="25" class="name form-control form-control-sm" placeholder="Otomatis setelah Grup dan Los terisi" style="text-transform: uppercase;"/>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Pengguna</small>
                                <select class="form-control form-control-sm select2" id="tambah-pengguna" name="tambah_pengguna"></select>
                            </div>
                            <div class="form-group">
                                <small class="form-control-label">Pemilik <span class="text-danger">*</span></small>
                                <select class="form-control form-control-sm select2" id="tambah-pemilik" name="tambah_pemilik"></select>
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
                                <small class="form-control-label">Keterangan</small>
                                <textarea rows="3" id="tambah-ket" name="tambah_ket" autocomplete="off" placeholder="Ketikkan Keterangan . . ." class="form-control" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <h4 class="text-center">FASILITAS</h4>
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
                            <div class="listrik"></div>
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
                            </div>
                            <div class="airbersih"></div>
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
                            </div>
                            <div class="keamananipk"></div>
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
                            </div>
                            <div class="kebersihan"></div>
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
                            </div>
                            <div class="airkotor"></div>
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

        $("#tambah-los").val('').html('').prop("disabled",true).select2({placeholder: "Grup perlu diisi terlebih dahulu"});

        $("#tambah-pengguna").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });;
        select2user("#tambah-pengguna", "/search/users", "-- Cari Pengguna --");

        $("#tambah-pemilik").val('').html('').on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
        });;
        select2user("#tambah-pemilik", "/search/users", "-- Cari Pemilik --");

        $(".listrik").html('');
        $(".airbersih").html('');
        $(".keamananipk").html('');
        $(".kebersihan").html('');
        $(".airkotor").html('');
    }

    $("#add").click(function(){
        $("#tambah-modal").modal("show");

        tambah_init();
    });

    $(document).on("change", '#tambah-group', function(e) {
        var group = $('#tambah-group').val();
        $("#tambah-los").prop("disabled", false);
        $("#tambah-los").val("").html("");
        select2los("#tambah-los", "/search/" + group + "/los", "-- Pilih Nomor Los --");
    });

    $(document).on("change", '#tambah-group, #tambah-los', function(e) {
        if($("#tambah-los").val() == ''){
            $("#tambah-name").val('').prop("disabled", true);
        } else {
            $("#tambah-name").prop("disabled", false);

            var dataset = {
                'group' : $("#tambah-group").val(),
                'los' : $("#tambah-los").val(),
            };
            $.ajax({
                url: "/services/place/generate/kontrol",
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

    $('#tambah-listrik').click(checkFasListrik);
    function checkFasListrik(){
        if($("#tambah-listrik").is(":checked")){
            var html = '';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Alat Meter <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-alat-listrik" name="tambah_alat_listrik" class="select2 form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Tarif <span class="text-danger">*</span></small>';
            html += '<select required id="tambah-trf-listrik" name="tambah_trf_listrik" class="select2 form-control form-control-sm"></select>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<small class="form-control-label">Diskon (% Tagihan)</small>';
            html += '<input maxlength="3" type="text" id="tambah-dis-listrik" name="tambah_dis_listrik" autocomplete="off" placeholder="Ketikkan dalam angka" class="number percent form-control form-control-sm">';
            html += '</div>';
            $(".listrik").html(html);

            $("#tambah-alat-listrik").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });;
            select2alat("#tambah-alat-listrik", "/search/alat", 1, "-- Cari Alat --");

            $("#tambah-trf-listrik").val('').html('').on('select2:open', () => {
                $('input.select2-search__field').prop('placeholder', 'Ketik disini..');
            });;
            select2tarif("#tambah-trf-listrik", "/search/tarif", 1, "-- Cari Tarif --");
        }
        else{
            $(".listrik").html('');
        }
    }

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
            url: "/services/place",
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

    function select2group(select2id, url, placeholder){
        $(select2id).select2({
            placeholder: placeholder,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                cache: true,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (d) {
                            return {
                                id: d.name,
                                text: d.name
                            }
                        })
                    };
                },
            }
        });
    }

    function select2los(select2id, url, placeholder){
        $(select2id).select2({
            placeholder: placeholder,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                cache: true,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (d) {
                            return {
                                id: d,
                                text: d
                            }
                        })
                    };
                },
            }
        });
    }

    function select2user(select2id, url, placeholder){
        $(select2id).select2({
            placeholder: placeholder,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                cache: true,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (d) {
                            return {
                                id: d.id,
                                text: d.name + ' (' + d.ktp + ')'
                            }
                        })
                    };
                },
            }
        });
    }

    function select2alat(select2id, url, level, placeholder){
        url = url + "?level=" + level;
        if(level == 1){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data, $level) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.name + ' (' + d.stand + ' - ' + d.daya + 'W)'
                                }
                            })
                        };
                    },
                }
            });
        } else {
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.name + ' (' + d.stand + ')'
                                }
                            })
                        };
                    },
                }
            });
        }
    }

    function select2tarif(select2id, url, level, placeholder){
        url = url + "?level=" + level;
        $(select2id).select2({
            placeholder: placeholder,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                cache: true,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (d) {
                            return {
                                id: d.id,
                                text: d.name
                            }
                        })
                    };
                },
            }
        });
    }
</script>
<!--end::Javascript-->
