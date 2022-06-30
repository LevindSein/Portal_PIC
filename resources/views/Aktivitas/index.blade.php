@extends('Layout.index')

@section('content-title')
Aktifitas Pengguna
@endsection

@section('content-button')
@include('Aktivitas.Partial._button')
@endsection

@section('content-body')
<table class="table table-striped table-hover" width="100%" id="dtable">
    <thead>
        <tr>
            <th class="all">Username</th>
            <th class="min-tablet">Nama</th>
            <th class="min-desktop">Level</th>
            <th class="min-tablet">Status</th>
            <th class="min-desktop">Durasi</th>
            <th class="min-tablet">Jml.Act</th>
            <th class="all">Action</th>
        </tr>
    </thead>
</table>
@endsection

@section('content-modal')
@include('Aktivitas.Modal._rincian')
@include('Aktivitas.Modal._print')
@endsection

@section('content-js')
<script>
    var dtable = $('#dtable').DataTable({
        responsive : true,
        language : {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            },
            searchPlaceholder: "Username/Nama"
        },
        serverSide : true,
        ajax : "/aktivitas",
        columns : [
            { data: 'user.name', name: 'user.name', class : 'text-center align-middle' },
            { data: 'user.level', name: 'user.level', class : 'text-center align-middle' },
            { data: 'login_successful', name: 'login_successful', class : 'text-center align-middle' },
            { data: 'login_at', name: 'login_at', class : 'text-center align-middle' },
            { data: 'longtime', name: 'longtime', class : 'text-center align-middle' },
            { data: 'jml', name: 'jml', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        stateSave : true,
        deferRender : true,
        pageLength : 5,
        aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
        order : [[ 4, "desc" ]],
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [6] },
            { "bSearchable": false, "aTargets": [2,3,4,5,6] }
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
