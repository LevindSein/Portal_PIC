<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
            </div>
            <form id="tambah-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <small class="form-control-label">Bulan <span class="text-danger">*</span></small>
                            <select required class="form-control form-control-sm" id="tambah-bulan" name="tambah_bulan">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <small class="form-control-label">Tahun <span class="text-danger">*</span></small>
                            <select required class="form-control form-control-sm" id="tambah-tahun" name="tambah_tahun">
                                @foreach (array_reverse(range(2018, strftime("%Y", time()))) as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="form-control-label">Jatuh Tempo Tagihan <span class="text-danger">*</span></small><div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <select required class="form-control form-control-sm" id="tambah-due" name="tambah_due"></select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label class="show-due form-control-label"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <small class="form-control-label">Periode Tagihan Baru<span class="text-danger">*</span></small>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <select required class="form-control form-control-sm" id="tambah-new" name="tambah_new"></select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label class="show-new form-control-label"></label>
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
    var choosed, show_new, show_due, get_due;

    function tambah_init(){
        $("#tambah-form")[0].reset();
        tambah_due();
        tambah_new();
    }

    $(".add").click(function(){
        $("#tambah-modal").modal("show");

        tambah_init();
    });

    $(document).on('change', '#tambah-bulan, #tambah-tahun', function(){
        tambah_due();
        tambah_new();
    });

    $(document).on('change', '#tambah-due', function(){
        tambah_new();
    });

    function tambah_due(){
        choosed = $("#tambah-bulan option:selected").text() + " " + $("#tambah-tahun option:selected").text();
        $(".show-due").text(choosed);

        show_due = getDaysInMonth($("#tambah-bulan").val(), $("#tambah-tahun").val());
        $('#tambah-due').html("");
        $.each(show_due, function (index, value){
            var new_date = new Date(value).getDate();
            $('#tambah-due').append('<option value="' + pad(new_date, 2) + '">' + new_date  + '</option>');
        });

        $("#tambah-due").val(15).change();
    }

    function tambah_new(){
        get_due = $('#tambah-due').val();

        choosed = $("#tambah-bulan option:selected").text() + " " + $("#tambah-tahun option:selected").text();
        $(".show-new").text(choosed);

        show_new = getDaysInMonth($("#tambah-bulan").val(), $("#tambah-tahun").val());
        $('#tambah-new').html("");
        $.each(show_new, function (index, value){
            var new_date = new Date(value).getDate();
            $('#tambah-new').append('<option value="' + pad(new_date, 2) + '">' + new_date  + '</option>');
        });

        $("#tambah-new").val(23).change();
    }

    function getDaysInMonth (month, year) {
        return new Array(31)
        .fill('')
        .map((v,i)=>new Date(year,month-1,i+1))
        .filter(v=>v.getMonth()===month-1);
    }

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
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
            url: "/data/periode",
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
