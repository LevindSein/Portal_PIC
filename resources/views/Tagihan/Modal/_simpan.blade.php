<!--begin::Modal-->
<div class="modal fade" id="simpan-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="simpan-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title"></h5>
            </div>
            <form id="simpan-form">
                <div class="modal-body">
                    <small class="form-control-label">Pilih Fasilitas</small>
                    <div class="form-group" id="simpan-content"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
    var id, nama;

    $(document).on('click', '.save', function(e){
        e.preventDefault();
        id = $(this).attr("id");
        nama = $(this).attr("nama");

        $(".title").text("Simpan Tagihan : " + $(this).attr("nama"));

        $.ajax({
            url: "/tagihan/check/" + id,
            cache: false,
            method: "GET",
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
                    var html = '';
                    var dataset = data.success;
                    if(dataset.listrik){
                        html += '<div class="form-check">';
                        html += '<input type="checkbox" name="simpan_fasilitas[]" id="simpan-listrik" value="listrik" />';
                        html += '<label class="form-control-label" for="simpan-listrik">&nbsp;Listrik</label>';
                        html += '</div>';
                    }

                    if(dataset.airbersih){
                        html += '<div class="form-check">';
                        html += '<input type="checkbox" name="simpan_fasilitas[]" id="simpan-airbersih" value="airbersih" />';
                        html += '<label class="form-control-label" for="simpan-airbersih">&nbsp;Air Bersih</label>';
                        html += '</div>';
                    }

                    if(dataset.keamananipk){
                        html += '<div class="form-check">';
                        html += '<input type="checkbox" name="simpan_fasilitas[]" id="simpan-keamananipk" value="keamananipk" />';
                        html += '<label class="form-control-label" for="simpan-keamananipk">&nbsp;Keamanan IPK</label>';
                        html += '</div>';
                    }

                    if(dataset.kebersihan){
                        html += '<div class="form-check">';
                        html += '<input type="checkbox" name="simpan_fasilitas[]" id="simpan-kebersihan" value="kebersihan" />';
                        html += '<label class="form-control-label" for="simpan-kebersihan">&nbsp;Kebersihan</label>';
                        html += '</div>';
                    }

                    if(dataset.airkotor){
                        html += '<div class="form-check">';
                        html += '<input type="checkbox" name="simpan_fasilitas[]" id="simpan-airkotor" value="airkotor" />';
                        html += '<label class="form-control-label" for="simpan-airkotor">&nbsp;Air Kotor</label>';
                        html += '</div>';
                    }

                    if(dataset.lainnya){
                        html += '<div class="form-check">';
                        html += '<input type="checkbox" name="simpan_fasilitas[]" id="simpan-lainnya" value="lainnya" />';
                        html += '<label class="form-control-label" for="simpan-lainnya">&nbsp;Lainnya</label>';
                        html += '</div>';
                    }

                    $("#simpan-content").html(html);
                }
            },
            error:function(data){
                toastr.error("System error.");
                console.log(data);
            },
            complete:function(data){
                if(JSON.parse(data.responseText).success){
                    $("#simpan-modal").modal("show");
                }
                setTimeout(() => {
                    $.unblockUI();
                }, 100);
            }
        });
    })

    $('#simpan-form').on('submit', function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "/tagihan/simpan/" + id,
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
                toastr.error("System error.");
                console.log(data);
            },
            complete:function(data){
                if(JSON.parse(data.responseText).success){
                    $('#simpan-modal').modal('hide');
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
