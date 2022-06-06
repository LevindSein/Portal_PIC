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
        url: "/services/place/" + id,
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

                //Kontrol
                html += '<small class="text-muted pt-4 db">Kode Kontrol</small>';
                html += '<h3 class="text-primary">' + data.success.name + '</h3>';
                //End Kontrol

                //Group
                html += '<small class="text-muted pt-4 db">Grup</small>';
                html += '<h3 class="text-primary">' + data.success.group.name + '</h3>';
                //End Group

                //Nomor Los
                html += '<small class="text-muted pt-4 db">Nomor Los</small>';
                html += '<h3 class="text-primary">' + data.success.los + '</h3>';
                //End Nomor Los

                //Jumlah Los
                html += '<small class="text-muted pt-4 db">Jumlah Los</small>';
                html += '<h3 class="text-primary">' + data.success.jml_los + '</h3>';
                //End Jumlah Los

                //Jumlah Los
                html += '<small class="text-muted pt-4 db">Status</small>';
                if(data.success.status == 2)
                    html += '<h3 class="text-info">Bebas Bayar</h3>';
                else if(data.success.status == 1)
                    html += '<h3 class="text-success">Aktif</h3>';
                else
                    html += '<h3 class="text-danger">Nonaktif</h3>';
                //End Jumlah Los

                if(data.success.pengguna_id){
                    //Pengguna
                    html += '<small class="text-muted pt-4 db">Pengguna</small>';
                    html += '<h3 class="text-primary">' + data.success.pengguna.name + '</h3>';
                    if(data.success.pengguna.ktp){
                        html += '<h3 class="text-primary">(KTP) ' + data.success.pengguna.ktp + '</h3>';
                    }
                    if(data.success.pengguna.phone){
                        html += '<h3 class="text-primary">(WA) +62' + data.success.pengguna.phone + '</h3>';
                    }
                    //End Pengguna
                }

                if(data.success.pemilik_id){
                    //Pemilik
                    html += '<small class="text-muted pt-4 db">Pemilik</small>';
                    html += '<h3 class="text-primary">' + data.success.pemilik.name + '</h3>';
                    if(data.success.pemilik.ktp){
                        html += '<h3 class="text-primary">(KTP) ' + data.success.pemilik.ktp + '</h3>';
                    }
                    if(data.success.pemilik.phone){
                        html += '<h3 class="text-primary">(WA) +62' + data.success.pemilik.phone + '</h3>';
                    }
                    //End Pemilik
                }

                if(data.success.ket){
                    //Keterangan
                    html += '<small class="text-muted pt-4 db">Keterangan Tempat</small>';
                    html += '<h3 class="text-primary">' + data.success.ket + '</h3>';
                    //End Keterangan
                }

                html += '<hr class="d-md-none">';
                html += '</div>';
                html += '<div class="col-lg-6">';

                if(data.success.trf_listrik_id){
                    //Listrik
                    html += '<div class="form-group">';
                    html += '<h4 class="text-center">LISTRIK</h4>';
                    html += '<small class="text-muted pt-4 db">Alat Meter</small>';
                    html += '<h3 class="text-primary">' + data.success.alat_listrik_id.name + '</h3>';
                    html += '<h3 class="text-primary">(Stand) ' + Number(data.success.alat_listrik_id.stand).toLocaleString('id-ID') + '</h3>';
                    html += '<h3 class="text-primary">(Daya) ' + Number(data.success.alat_listrik_id.daya).toLocaleString('id-ID') + '</h3>';
                    html += '<small class="text-muted pt-4 db">Tarif</small>';
                    html += '<h3 class="text-primary">' + data.success.trf_listrik_id.name + '</h3>';
                    if(data.success.diskon.listrik){
                        html += '<small class="text-muted pt-4 db">Diskon</small>';
                        html += '<h3 class="text-primary">' + data.success.diskon.listrik + '% dari Tagihan</h3>';
                    }
                    html += '</div>';
                    html += '<hr>';
                    //End Listrik
                }

                if(data.success.trf_airbersih_id){
                    //Air Bersih
                    html += '<div class="form-group">';
                    html += '<h4 class="text-center">AIR BERSIH</h4>';
                    html += '<small class="text-muted pt-4 db">Alat Meter</small>';
                    html += '<h3 class="text-primary">' + data.success.alat_airbersih_id.name + '</h3>';
                    html += '<h3 class="text-primary">(Stand) ' + Number(data.success.alat_airbersih_id.stand).toLocaleString('id-ID') + '</h3>';
                    html += '<small class="text-muted pt-4 db">Tarif</small>';
                    html += '<h3 class="text-primary">' + data.success.trf_airbersih_id.name + '</h3>';
                    if(data.success.diskon.airbersih){
                        html += '<small class="text-muted pt-4 db">Diskon</small>';
                        html += '<h3 class="text-primary">' + data.success.diskon.airbersih + '% dari Tagihan</h3>';
                    }
                    html += '</div>';
                    html += '<hr>';
                    //End Air Bersih
                }

                if(data.success.trf_keamananipk_id){
                    //Keamanan IPK
                    html += '<div class="form-group">';
                    html += '<h4 class="text-center">AIR BERSIH</h4>';
                    html += '<small class="text-muted pt-4 db">Tarif</small>';
                    html += '<h3 class="text-primary">' + data.success.trf_keamananipk_id.name + '</h3>';
                    html += '<h3 class="text-primary">Rp ' + Number(data.success.trf_keamananipk_id.data.Tarif).toLocaleString('id-ID') + ' per-Los</h3>';
                    if(data.success.diskon.keamananipk){
                        html += '<small class="text-muted pt-4 db">Diskon</small>';
                        html += '<h3 class="text-primary">Rp ' + Number(data.success.diskon.keamananipk).toLocaleString('id-ID') + ' per-Kontrol</h3>';
                    }
                    html += '</div>';
                    html += '<hr>';
                    //End Keamanan IPk
                }

                if(data.success.trf_kebersihan_id){
                    //Kebersihan
                    html += '<div class="form-group">';
                    html += '<h4 class="text-center">KEBERSIHAN</h4>';
                    html += '<small class="text-muted pt-4 db">Tarif</small>';
                    html += '<h3 class="text-primary">' + data.success.trf_kebersihan_id.name + '</h3>';
                    html += '<h3 class="text-primary">Rp ' + Number(data.success.trf_kebersihan_id.data.Tarif).toLocaleString('id-ID') + ' per-Los</h3>';
                    if(data.success.diskon.kebersihan){
                        html += '<small class="text-muted pt-4 db">Diskon</small>';
                        html += '<h3 class="text-primary">Rp ' + Number(data.success.diskon.kebersihan).toLocaleString('id-ID') + ' per-Kontrol</h3>';
                    }
                    html += '</div>';
                    html += '<hr>';
                    //End Kebersihan
                }

                if(data.success.trf_airkotor_id){
                    //Air Kotor
                    html += '<div class="form-group">';
                    html += '<h4 class="text-center">AIR KOTOR</h4>';
                    html += '<small class="text-muted pt-4 db">Tarif</small>';
                    html += '<h3 class="text-primary">' + data.success.trf_airkotor_id.name + '</h3>';
                    html += '<h3 class="text-primary">Rp ' + Number(data.success.trf_airkotor_id.data.Tarif).toLocaleString('id-ID') + ' ' + data.success.trf_airkotor_id.status + '</h3>';
                    html += '</div>';
                    html += '<hr>';
                    //End Air Kotor
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
