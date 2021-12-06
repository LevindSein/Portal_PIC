@extends('portal.layout.master')

@section('content-title')
Data Tempat
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn">
        <a class="dropdown-item add" href="javascript:void(0)">
            <i class="fas fa-fw fa-plus mr-1 ml-1"></i>
            <span>Tambah Data</span>
        </a>
    </div>
</div>
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
                                <th>Kontrol</th>
                                <th>Pengguna</th>
                                <th>Jml.Los</th>
                                <th>Fasilitas</th>
                                <th>Action</th>
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

@endsection

@section('content-js')
<script>
    $(document).ready(function(){
        var id;

        var dtable = $('#dtable').DataTable({
            "language": {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
            "serverSide": true,
            "ajax": "/production/point/shops",
            "columns": [
                { data: 'kd_kontrol', name: 'nicename', class : 'text-center'  },
                { data: 'pengguna.name', name: 'pengguna.name', class : 'text-center' },
                { data: 'jml_los', name: 'jml_los', class : 'text-center' },
                { data: 'fasilitas', name: 'fasilitas', class : 'text-center' },
                { data: 'action', name: 'action', class : 'text-center' },
            ],
            "stateSave": true,
            "deferRender": true,
            "pageLength": 10,
            "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
            "order": [[ 0, "asc" ]],
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [3,4] },
                { "bSearchable": false, "aTargets": [3,4] }
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

        setInterval(function(){
            dtableReload('');
        }, 5000);

        function dtableReload(searchKey){
            if(searchKey){
                dtable.search(searchKey).draw();
            }
            dtable.ajax.reload(function(){
                console.log("Refresh Automatic")
            }, false);
        }
    });
</script>
@endsection
