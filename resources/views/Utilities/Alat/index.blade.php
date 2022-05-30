@extends('Layout.index')

@section('content-title')
Alat Meter
@endsection

@section('content-button')
@include('Utilities.Alat.Partial._button')
@endsection

@section('content-body')
<table class="table table-striped table-hover" width="100%" id="dtable">
    <thead>
        <tr>
            <th class="all">Nama</th>
            <th class="min-tablet">Code</th>
            <th class="all">Stand</th>
            <th class="all">Action</th>
        </tr>
    </thead>
</table>
@endsection

@section('content-modal')
@include('Utilities.Alat.Modal._tambah')
@include('Utilities.Alat.Modal._edit')
@include('Utilities.Alat.Modal._hapus')
@include('Utilities.Alat.Modal._rincian')
@endsection

@section('content-js')
<script>
    var status = 1, content_title = 'Alat Tersedia';
    $(".content-title").text(content_title);

    var url = "/utilities/alat?level=" + $("#level").prop("selectedIndex", 0).val() + "&status=" + status;

    var dtable = $('#dtable').DataTable({
        responsive : true,
        language : {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            },
            searchPlaceholder: "Nama Alat"
        },
        serverSide : true,
        ajax : url,
        columns : [
            { data: 'name', name: 'name', class : 'text-center align-middle' },
            { data: 'code', name: 'code', class : 'text-center align-middle' },
            { data: 'stand', name: 'stand', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        stateSave : true,
        deferRender : true,
        pageLength : 5,
        aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
        order : [[ 0, "asc" ]],
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [3] },
            { "bSearchable": false, "aTargets": [3] }
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
        url = "/utilities/alat?level=" + $("#level").val() + "&status=" + status;
        dtable.ajax.url( url ).load();
        dtableReload();
    });

    $(document).on('click', '#activated', function(){
        status = 0;
        content_title = 'Alat Aktif';
        $(".content-title").text(content_title);
        url = "/utilities/alat?level=" + $("#level").val() + "&status=" + status;
        dtable.ajax.url( url ).load();
        dtableReload();
    });

    $(document).on('click', '#available', function(){
        status = 1
        content_title = 'Alat Tersedia';
        $(".content-title").text(content_title);
        url = "/utilities/alat?level=" + $("#level").val() + "&status=" + status;
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

    function hide(){
        nonListrik();
    }

    function nonListrik(){
        $(".listrik").fadeOut(200);

        $("#tambah-daya").prop("required", false);

        $("#edit-daya").prop("required", false);
    }

    function listrik(){
        $(".listrik").fadeIn(200);

        $("#tambah-daya").prop("required", true);

        $("#edit-daya").prop("required", true);
    }
</script>
@endsection
