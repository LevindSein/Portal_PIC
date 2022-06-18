<!--begin::Modal-->
<div class="modal fade" id="detail-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian</h5>
            </div>
            <div class="modal-body text-center" style="height: 60vh;">
                <div id="showRincian"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light font-weight-bold" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
    var id;

    $(document).on('click', '.detail', function(e){
        e.preventDefault();
        id = $(this).attr("id");

        $.ajax({
            url: "/tagihan/" + id,
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
                    var html = '';
                    html += '<div class="row">';
                    html += '<div class="col-lg-6">';

                    //Kode
                    html += '<small class="text-muted pt-4 db">Kode Tagihan</small>';
                    html += '<h3 class="text-primary">' + data.success.code + '</h3>';
                    //End Kode

                    //Kontrol
                    html += '<small class="text-muted pt-4 db">Kode Kontrol</small>';
                    html += '<h3 class="text-primary">' + data.success.name + '</h3>';
                    //End Kontrol

                    //Nomor Los
                    html += '<small class="text-muted pt-4 db">Nomor Los</small>';
                    html += '<h3>' + data.success.los + '</h3>';
                    //End Nomor Los

                    //Jumlah Los
                    html += '<small class="text-muted pt-4 db">Jumlah Los</small>';
                    html += '<h3>' + data.success.jml_los + '</h3>';
                    //End Jumlah Los

                    //Status Tagihan
                    html += '<small class="text-muted pt-4 db">Status Lunas</small>';
                    html += '<h3>' + ((data.success.stt_lunas) ? '<span class="text-success">Lunas</span>' : '<span class="text-danger">Belum Lunas</span>')  + '</h3>';
                    //End Status Tagihan

                    //Pengguna
                    html += '<small class="text-muted pt-4 db">Pengguna</small>';
                    html += '<h3>' + data.success.pengguna.name + '</h3>';
                    if(data.success.pengguna.ktp){
                        html += '<h3>(KTP) ' + data.success.pengguna.ktp + '</h3>';
                    }
                    if(data.success.pengguna.phone){
                        html += '<h3>(WA) +62' + data.success.pengguna.phone + '</h3>';
                    }
                    //End Pengguna

                    html += '<hr class="d-md-none">';
                    html += '</div>';
                    html += '<div class="col-lg-6">';

                    if(data.success.listrik){
                        //Listrik

                        //End Listrik
                    }

                    if(data.success.airbersih){
                        //Air Bersih

                        //End Air Bersih
                    }

                    if(data.success.keamananipk){
                        //Keamanan IPK

                        //End Keamanan IPK
                    }

                    if(data.success.kebersihan){
                        //Kebersihan

                        //End Kebersihan
                    }

                    if(data.success.airkotor){
                        //Air Kotor

                        //End Air Kotor
                    }

                    if(data.success.lainnya){
                        //Lainnya

                        //End Lainnya
                    }

                    html += '</div>';
                    html += '</div>';

                    $("#showRincian").html(html);
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
                    $("#detail-modal").modal("show");
                }
                else{
                    toastr.error("Gagal mengambil data.");
                }
                $.unblockUI();
            }
        });
    });
</script>
<!--end::Javascript-->
