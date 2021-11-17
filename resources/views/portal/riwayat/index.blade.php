@extends('portal.layout.master')

@section('content-title')
Riwayat Login
@endsection

@section('content-button')
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-modal')
<div id="showModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles">{Title}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 id="showLevel"></h3>
                <h5 id="showSttAktif"></h5>
                <small class="text-muted pt-4 db">Username</small>
                <h6 id="showUsername"></h6>
                <small class="text-muted pt-4 db">Nama</small>
                <h6 id="showNama"></h6>
                <small class="text-muted pt-4 db">Status</small>
                <h6 id="showStatus"></h6>
                <small class="text-muted pt-4 db">Platform</small>
                <h6 id="showPlatform"></h6>
                <small class="text-muted pt-4 db">Time</small>
                <h6 id="showTime"></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-js')
<script>
    $(document).ready(function(){
        $('#dtable').DataTable({
            "language": {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
            "serverSide": true,
            "ajax": "/production/riwayat-login",
            "columns": [
                { data: 'username', name: 'username', class : 'text-center' },
                { data: 'nama', name: 'nama', class : 'text-center' },
                { data: 'level', name: 'level', class : 'text-center' },
                { data: 'status', name: 'status', class : 'text-center' },
                { data: { '_': 'created_at.display', 'sort': 'created_at.timestamp' }, name: 'created_at', class : 'text-center'  },
                { data: 'show', name: 'show', class : 'text-center' },
            ],
            "stateSave": true,
            "deferRender": true,
            "pageLength": 10,
            "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
            "order": [[ 4, "desc" ]],
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [5] },
                { "bSearchable": false, "aTargets": [2,3,4,5] }
            ],
            "scrollY": "35vh",
            "scrollX": true,
            "preDrawCallback": function( settings ) {
                scrollPosition = $(".dataTables_scrollBody").scrollTop();
            },
            "drawCallback": function( settings ) {
                $(".dataTables_scrollBody").scrollTop(scrollPosition);
                if(typeof rowIndex != 'undefined') {
                    dtable.row(rowIndex).nodes().to$().addClass('row_selected');
                }
                setTimeout( function () {
                    $("[data-toggle='tooltip']").tooltip();
                }, 10)
            },
        });

        var id;
        $(document).on('click', '.details', function(){
            id = $(this).attr('id');
            nama = $(this).attr('nama');
            $('.titles').text('Informasi ' + nama);

            $.ajax({
                url: "/production/riwayat-login/" + id,
                type: "GET",
                cache:false,
                success:function(data){
                    if(data.success){
                        $("#showLevel").text(data.user.level);
                        $("#showSttAktif").html(data.user.stt_aktif);
                        $("#showUsername").text(data.user.username);
                        $("#showNama").text(data.user.nama);
                        $("#showStatus").html(data.user.status);
                        $("#showPlatform").text(data.user.platform);
                        $("#showTime").text(data.user.time);
                    }
                    else if(data.exception){
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error("Data gagal diproses.");
                        console.log(data.exception);
                    }
                    else{
                        toastr.options = {
                            "closeButton": true,
                            "preventDuplicates": true,
                        };
                        toastr.error(data.error);
                    }
                },
                error:function(data){
                    toastr.options = {
                        "closeButton": true,
                        "preventDuplicates": true,
                    };
                    toastr.error("Gagal mengambil data.");
                    console.log(data);
                },
                complete:function(){
                    $('#showModal').modal('show');
                }
            });
        });
    });
</script>
@endsection
