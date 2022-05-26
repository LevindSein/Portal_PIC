<!--begin::Modal-->
<div class="modal fade" id="detail-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian</h5>
            </div>
            <div class="modal-body text-center" style="height: 60vh;">
                <small class="text-muted pt-4 db">Nomor Seri</small>
                <h3 id="showSeri"></h3>
                <small class="text-muted pt-4 db">Title</small>
                <h3 id="showTitle"></h3>
                <small class="text-muted pt-4 db">Times</small>
                <h3 id="showTimes"></h3>
                <small class="text-muted pt-4 db">Created By</small>
                <h3 id="showCreatedBy"></h3>
                <small class="text-muted pt-4 db">Data</small><br>
                <small><a id="print-activities" href="javascript:void(0);" class="text-primary">Download <i class="fas fa-sm fa-download"></i></a></small>
                <h3 id="showData" class="text-left"></h3>
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
            url: "/changelogs/" + id,
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
                    $("#showSeri").text(data.success.code);
                    $("#showTitle").html(data.success.title.replace(/\r\n/g, '<br>'));
                    $("#showTimes").html(data.success.times);
                    $("#showCreatedBy").text(data.success.user.name);
                    $("#showData").html(data.success.data.replace(/\r\n/g, '<br>'));
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

    $(document).on('click', '#print-activities', function (e) {
        $(this).attr("href", "/changelogs/excel/" + id);
    })
</script>
<!--end::Javascript-->
