<!--begin::Modal-->
<div class="modal fade" id="detail-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <small class="text-muted pt-4 db">Nama</small>
                <h6 id="showNama"></h6>
                <small class="text-muted pt-4 db">Username (untuk Login)</small>
                <h6 id="showUsername"></h6>
                <small class="text-muted pt-4 db">Status</small>
                <h6 id="showStatus"></h6>
                <small class="text-muted pt-4 db">Level</small>
                <h6 id="showLevel"></h6>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
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
        url: "/production/users/" + id,
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
                $("#showUsername").text(data.success.username);
                $("#showNama").text(data.success.name);
                $("#showStatus").html((data.success.status == 1) ? "<span class='text-success'>Aktif</span>" : "<span class='text-danger'>Nonaktif</span>");
                $("#showLevel").text(data.success.level);
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
