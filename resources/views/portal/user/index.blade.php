@extends('portal.layout.master')

@section('content-title')
User
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action
    </button>
    <div class="dropdown-menu animated fadeIn">
        <a class="dropdown-item" href="javascript:void(0)">Action</a>
        <a class="dropdown-item" href="javascript:void(0)">Another action</a>
        <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:void(0)">Separated link</a>
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group col-md-2 col-sm-2" style="padding: 0;">
                        <label for="kategori">Pilih Kategori</label>
                        <select class="form-control" id="kategori">
                            <option value="nasabah">Nasabah</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Action</th>
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

@section('content-js')
<script>
    $(document).ready(function(){
        var dtable = dtableInit("/user");
        $('#kategori').on('change', function() {
            if(this.value == "admin"){
                dtable = dtableInit("/user/admin");
            }
            else if(this.value == "nasabah"){
                dtable = dtableInit("/user");
            }
        });

        setInterval(function(){
            dtable.ajax.reload(function(){
                console.log("Refresh Automatic")
            }, false);
        }, 5000);

        function dtableInit(url){
            $('#dtable').DataTable().clear().destroy();
            return $('#dtable').DataTable({
                "processing": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                },
                "serverSide": true,
                "ajax": url,
                "columns": [
                    { data: 'username', name: 'username', class : 'text-center' },
                    { data: 'name', name: 'name', class : 'text-center' },
                    { data: 'action', name: 'action', class : 'text-center' },
                    { data: 'show', name: 'show', class : 'text-center' },
                ],
                "stateSave": true,
                "deferRender": true,
                "pageLength": 10,
                "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [2,3] },
                    { "bSearchable": false, "aTargets": [2,3] }
                ],
                "scrollY": "50vh",
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
        }
    });
</script>
@endsection
