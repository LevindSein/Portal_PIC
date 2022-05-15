@extends('Layout.index')

@section('content-title')
Users
@endsection

@section('content-button')
<!--begin::Actions-->
<select class="form-control form-control-sm mr-2" id="level" name="level">
    <option value="1">Super</option>
    <option value="2">Admin</option>
    <option value="3">Kasir</option>
    <option value="4">Keuangan</option>
    <option value="5">Manajer</option>
</select>
<!--end::Actions-->
<!-- Button -->
<div class="dropdown-menu dropdown-menu-right">
    <a class="dropdown-item" id="add" href="javascript:void(0)">Tambah</a>
    <a class="dropdown-item" id="generate" href="javascript:void(0)">Unduh Data Pengguna</a>
</div>
<a class="dropdown-toggle btn btn-sm btn-neutral" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</a>
@endsection

@section('content-body')
<table class="table table-striped table-hover" width="100%" id="dtable">
    <thead>
        <tr>
            <th class="all">Nama</th>
            <th class="min-tablet">Username</th>
            <th class="min-tablet">Level</th>
            <th class="all">Action</th>
        </tr>
    </thead>
</table>
@endsection

@section('content-modal')
@include('Users.Modal._tambah')
@include('Users.Modal._edit')
@include('Users.Modal._reset')
@include('Users.Modal._hapus')
@include('Users.Modal._rincian')
@endsection

@section('content-js')
<script>
    var url = "/users?level=" + $("#level").prop("selectedIndex", 0).val();

    var dtable = $('#dtable').DataTable({
        responsive : true,
        language : {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        serverSide : true,
        ajax : url,
        columns : [
            { data: 'name', name: 'name', class : 'text-center align-middle' },
            { data: 'username', name: 'username', class : 'text-center align-middle' },
            { data: 'level', name: 'level', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        stateSave : true,
        deferRender : true,
        pageLength : 5,
        aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
        order : [[ 0, "asc" ]],
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [3] },
            { "bSearchable": false, "aTargets": [2, 3] }
        ],
        scrollY : "50vh",
        scrollX : true,
        preDrawCallback : function( settings ) {
            scrollPosition = $(".dataTables_scrollBody").scrollTop();
        },
        drawCallback : function( settings ) {
            $(".dataTables_scrollBody").scrollTop(scrollPosition);
            if(typeof rowIndex != 'undefined') {
                dtable.row(rowIndex).nodes().to$().addClass('row_selected');
            }
            setTimeout( function () {
                $("[data-toggle='tooltip']").tooltip();
            }, 10)
        },
    });

    $(document).on('change', '#level', function(){
        url = "/users?level=" + $("#level").val();
        dtable.ajax.url( url ).load();
        dtableReload();
    });

    setInterval(function(){
        dtableReload();
    }, 60000);

    function dtableReload(searchKey = null){
        if(searchKey){
            dtable.search(searchKey).draw();
        }

        dtable.ajax.reload(function(){
            console.log("Refresh Automatic")
        }, false);

        $(".tooltip").tooltip("hide");

        $(".popover").popover("hide");
    }
</script>
@endsection
