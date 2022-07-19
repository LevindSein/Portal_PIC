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
                    html += '<h4 class="text-primary">' + data.success.code + '</h4>';
                    //End Kode

                    //Kontrol
                    html += '<small class="text-muted pt-4 db">Kode Kontrol</small>';
                    html += '<h4 class="text-primary">' + data.success.name + '</h4>';
                    //End Kontrol

                    //Nomor Los
                    html += '<small class="text-muted pt-4 db">Nomor Los</small>';
                    html += '<h4>' + data.success.los.data + '</h4>';
                    //End Nomor Los

                    //Jumlah Los
                    html += '<small class="text-muted pt-4 db">Jumlah Los</small>';
                    html += '<h4>' + data.success.jml_los + '</h4>';
                    //End Jumlah Los

                    //Status Tagihan
                    html += '<small class="text-muted pt-4 db">Status Lunas</small>';
                    html += '<h4>' + ((data.success.stt_lunas) ? '<span class="text-success">Lunas</span>' : '<span class="text-danger">Belum Lunas</span>')  + '</h4>';
                    //End Status Tagihan

                    //Pengguna
                    html += '<small class="text-muted pt-4 db">Pengguna</small>';
                    html += '<h4>' + data.success.pengguna.name + '</h4>';
                    if(data.success.pengguna.ktp){
                        html += '<h4>(KTP) ' + data.success.pengguna.ktp + '</h4>';
                    }
                    if(data.success.pengguna.phone){
                        html += '<h4>(WA) +62' + data.success.pengguna.phone + '</h4>';
                    }
                    //End Pengguna

                    //Tagihan
                    html += '<h4 class="text-center text-primary">TAGIHAN</h4>';
                    $.each( data.success.data_tagihan, function( i, val ) {
                        html += '<div class="row text-left">';
                        html += '<div class="col-4">';
                        html += '<small class="text-muted pt-4 db">' + i.replaceAll("_", " ") + '</small>';
                        html += '</div>';
                        html += '<div class="col-8">';
                        html += '<small class="pt-4">: ' + val + '</small>';
                        html += '</div>';
                        html += '</div>';
                    });
                    html += '<hr>';
                    //End Tagihan

                    html += '<hr class="d-md-none">';
                    html += '</div>';
                    html += '<div class="col-lg-6">';

                    if(data.success.listrik){
                        //Listrik
                        html += '<h4 class="text-center text-primary">LISTRIK</h4>';
                        $.each( data.success.data_listrik, function( i, val ) {
                            if(val != null){
                                html += '<div class="row text-left">';
                                html += '<div class="col-4">';
                                html += '<small class="text-muted pt-4 db">' + i.replaceAll("_", " ") + '</small>';
                                html += '</div>';
                                html += '<div class="col-8">';
                                html += '<small class="pt-4">: ' + val + '</small>';
                                html += '</div>';
                                html += '</div>';
                            }
                        });
                        html += '<hr>';
                        //End Listrik
                    }

                    if(data.success.airbersih){
                        //Air Bersih
                        html += '<h4 class="text-center text-primary">AIR BERSIH</h4>';
                        $.each( data.success.data_airbersih, function( i, val ) {
                            if(val != null){
                                html += '<div class="row text-left">';
                                html += '<div class="col-4">';
                                html += '<small class="text-muted pt-4 db">' + i.replaceAll("_", " ") + '</small>';
                                html += '</div>';
                                html += '<div class="col-8">';
                                html += '<small class="pt-4">: ' + val + '</small>';
                                html += '</div>';
                                html += '</div>';
                            }
                        });
                        html += '<hr>';
                        //End Air Bersih
                    }

                    if(data.success.keamananipk){
                        //Keamanan IPK
                        html += '<h4 class="text-center text-primary">KEAMANAN IPK</h4>';
                        $.each( data.success.data_keamananipk, function( i, val ) {
                            if(val != null){
                                html += '<div class="row text-left">';
                                html += '<div class="col-4">';
                                html += '<small class="text-muted pt-4 db">' + i.replaceAll("_", " ") + '</small>';
                                html += '</div>';
                                html += '<div class="col-8">';
                                html += '<small class="pt-4">: ' + val + '</small>';
                                html += '</div>';
                                html += '</div>';
                            }
                        });
                        html += '<hr>';
                        //End Keamanan IPK
                    }

                    if(data.success.kebersihan){
                        //Kebersihan
                        html += '<h4 class="text-center text-primary">KEBERSIHAN</h4>';
                        $.each( data.success.data_kebersihan, function( i, val ) {
                            if(val != null){
                                html += '<div class="row text-left">';
                                html += '<div class="col-4">';
                                html += '<small class="text-muted pt-4 db">' + i.replaceAll("_", " ") + '</small>';
                                html += '</div>';
                                html += '<div class="col-8">';
                                html += '<small class="pt-4">: ' + val + '</small>';
                                html += '</div>';
                                html += '</div>';
                            }
                        });
                        html += '<hr>';
                        //End Kebersihan
                    }

                    if(data.success.airkotor){
                        //Air Kotor
                        html += '<h4 class="text-center text-primary">AIR KOTOR</h4>';
                        $.each( data.success.data_airkotor, function( i, val ) {
                            if(val != null){
                                html += '<div class="row text-left">';
                                html += '<div class="col-4">';
                                html += '<small class="text-muted pt-4 db">' + i.replaceAll("_", " ") + '</small>';
                                html += '</div>';
                                html += '<div class="col-8">';
                                html += '<small class="pt-4">: ' + val + '</small>';
                                html += '</div>';
                                html += '</div>';
                            }
                        });
                        html += '<hr>';
                        //End Air Kotor
                    }

                    if(data.success.lainnya){
                        //Lainnya
                        html += '<h4 class="text-center text-primary">LAINNYA</h4>';
                        $.each( data.success.data_lainnya, function( i, val ) {
                            if(val != null){
                                html += '<div class="row text-left">';
                                html += '<div class="col-4">';
                                html += '<small class="text-muted pt-4 db">' + i.replaceAll("_", " ") + '</small>';
                                html += '</div>';
                                html += '<div class="col-8">';
                                html += '<small class="pt-4">: ' + val + '</small>';
                                html += '</div>';
                                html += '</div>';
                            }
                        });
                        html += '<hr>';
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
