<!--begin::Modal-->
<div class="modal fade" id="detail-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian</h5>
            </div>
            <div class="modal-body text-center" style="height: 60vh;">
                <small class="text-muted pt-4 db">Username</small>
                <h3 id="showUsername"></h3>
                <small class="text-muted pt-4 db">Nama</small>
                <h3 id="showNama"></h3>
                <small class="text-muted pt-4 db">Level</small>
                <h3 id="showLevel"></h3>
                <small class="text-muted pt-4 db">IP Address</small>
                <h3 id="showIP"></h3>
                <small class="text-muted pt-4 db">Agent</small>
                <h3 id="showAgent"></h3>
                <small class="text-muted pt-4 db">Login</small>
                <h3 id="showLoginAt"></h3>
                <small class="text-muted pt-4 db">Logout</small>
                <h3 id="showLogoutAt"></h3>
                <hr>
                <small class="text-muted pt-4 db">Aktifitas</small>
                <div id="divActivities">
                    <h3 id="showActivities"></h3>
                </div>
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
            url: "/aktivitas/" + id,
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
                    $("#showUsername").text(data.success.user.username);
                    $("#showNama").text(data.success.user.name);
                    $("#showLevel").text(data.success.level);
                    $("#showIP").text(data.success.ip_address);
                    $("#showAgent").text(data.success.user_agent);
                    $("#showLoginAt").text(data.success.login_at);
                    $("#showLogoutAt").text((data.success.logout_at) ? data.success.logout_at : '-');
                    (data.success.activity > 0) ?
                        $("#showActivities").html(data.success.activity + ' Aktifitas, Lihat <a id="print-activities" href="javascript:void(0);" class="text-primary">disini</a>.') :
                        $("#showActivities").html(data.success.activity + ' Aktifitas');

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
        $(this).attr("href", "/aktivitas/print1/" + id);
        $(this).attr("target", "_blank");
    })
</script>
<!--end::Javascript-->
