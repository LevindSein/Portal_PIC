<!--begin::Modal-->
<div class="modal fade" id="detail-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian</h5>
            </div>
            <div class="modal-body text-center" style="height: 60vh;">

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
