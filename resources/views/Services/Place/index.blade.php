@extends('Layout.index')

@section('content-title')
Tempat Usaha
@endsection

@section('content-button')
@include('Services.Place.Partial._button')
@endsection

@section('content-body')
<table class="table table-striped table-hover" width="100%" id="dtable">
    <thead>
        <tr>
            <th class="all">Kontrol</th>
            <th class="min-tablet">Pengguna</th>
            <th class="min-tablet">Jml.Los</th>
            <th class="min-tablet">Ket</th>
            <th class="all">Action</th>
        </tr>
    </thead>
</table>
@endsection

@section('content-modal')
@include('Services.Place.Modal._tambah')
@include('Services.Place.Modal._edit')
@include('Services.Place.Modal._hapus')
@include('Services.Place.Modal._rincian')
@include('Services.Place.Modal._print')
@include('Services.Place.Modal._excel')
@endsection

@section('content-js')
<script>
    // var dtable = $('#dtable').DataTable({
    //     responsive : true,
    //     language : {
    //         paginate: {
    //             previous: "<i class='fas fa-angle-left'>",
    //             next: "<i class='fas fa-angle-right'>"
    //         }
    //     },
    //     serverSide : true,
    //     ajax : "services/place",
    //     columns : [
    //         { data: 'kontrol', name: 'kontrol', class : 'text-center align-middle' },
    //         { data: 'pengguna', name: 'pengguna', class : 'text-center align-middle' },
    //         { data: 'jum_los', name: 'jum_los', class : 'text-center align-middle' },
    //         { data: 'action', name: 'action', class : 'text-center align-middle' },
    //     ],
    //     stateSave : true,
    //     deferRender : true,
    //     pageLength : 5,
    //     aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
    //     order : [[ 0, "asc" ]],
    //     aoColumnDefs: [
    //         { "bSortable": false, "aTargets": [3] },
    //         { "bSearchable": false, "aTargets": [2, 3] }
    //     ],
    //     scrollY : "50vh",
    //     scrollX : true,
    //     preDrawCallback : function( settings ) {
    //         scrollPosition = $(".dataTables_scrollBody").scrollTop();
    //     },
    //     drawCallback : function( settings ) {
    //         $(".dataTables_scrollBody").scrollTop(scrollPosition);
    //         if(typeof rowIndex != 'undefined') {
    //             dtable.row(rowIndex).nodes().to$().addClass('row_selected');
    //         }
    //         setTimeout( function () {
    //             $("[data-toggle='tooltip']").tooltip();
    //         }, 10)
    //     },
    // });

    // setInterval(function(){
    //     dtableReload();
    // }, 60000);

    // function dtableReload(searchKey = null){
    //     if(searchKey){
    //         dtable.search(searchKey).draw();
    //     }

    //     dtable.ajax.reload(function(){
    //         console.log("Refresh Automatic")
    //     }, false);

    //     $(".tooltip").tooltip("hide");

    //     $(".popover").popover("hide");
    // }
</script>
@endsection
