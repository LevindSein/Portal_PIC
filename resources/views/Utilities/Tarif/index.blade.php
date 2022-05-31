@extends('Layout.index')

@section('content-title')
Tarif Fasilitas
@endsection

@section('content-button')
@include('Utilities.Tarif.Partial._button')
@endsection

@section('content-body')
<table class="table table-striped table-hover" width="100%" id="dtable">
    <thead>
        <tr>
            <th class="all">Nama Tarif</th>
            <th class="all">Action</th>
        </tr>
    </thead>
</table>
@endsection

@section('content-modal')
@include('Utilities.Tarif.Modal._tambah')
@include('Utilities.Tarif.Modal._edit')
@include('Utilities.Tarif.Modal._hapus')
@include('Utilities.Tarif.Modal._rincian')
@include('Utilities.Tarif.Modal._print')
@endsection

@section('content-js')
<script>
    var content_title = 'Tarif Listrik';
    $(".content-title").text(content_title);

    var url = "/utilities/tarif?level=" + $("#level").prop("selectedIndex", 0).val();

    var dtable = $('#dtable').DataTable({
        responsive : true,
        language : {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            },
            searchPlaceholder: "Nama Tarif"
        },
        serverSide : true,
        ajax : url,
        columns : [
            { data: 'name', name: 'name', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        stateSave : true,
        deferRender : true,
        pageLength : 5,
        aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
        order : [[ 0, "asc" ]],
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [1] },
            { "bSearchable": false, "aTargets": [1] }
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
        var level = $(this).val();
        if(level == 1){
            content_title = 'Tarif Listrik';
        } else if(level == 2){
            content_title = 'Tarif Air Bersih';
        } else if(level == 3){
            content_title = 'Tarif Keamanan IPK';
        } else if(level == 4){
            content_title = 'Tarif Kebersihan';
        } else if(level == 5){
            content_title = 'Tarif Air Kotor';
        } else{
            content_title = 'Tarif Lainnya';
        }

        $(".content-title").text(content_title);
        url = "/utilities/tarif?level=" + $("#level").val();
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
        nonAirbersih();
        nonKeamananipk();
        nonKebersihan();
        nonAirkotor();
        nonLainnya();
    }

    function nonListrik(){
        $(".listrik").fadeOut(200);

        $("#tambah-beban").prop("required", false);
        $("#tambah-blok1").prop("required", false);
        $("#tambah-blok2").prop("required", false);
        $("#tambah-standar").prop("required", false);
        $("#tambah-pju").prop("required", false);
        $("#tambah-denda1").prop("required", false);
        $("#tambah-denda2").prop("required", false);
        $("#tambah-ppnlistrik").prop("required", false);

        $("#edit-beban").prop("required", false);
        $("#edit-blok1").prop("required", false);
        $("#edit-blok2").prop("required", false);
        $("#edit-standar").prop("required", false);
        $("#edit-pju").prop("required", false);
        $("#edit-denda1").prop("required", false);
        $("#edit-denda2").prop("required", false);
        $("#edit-ppnlistrik").prop("required", false);
    }

    function nonAirbersih(){
        $(".airbersih").fadeOut(200);

        $("#tambah-tarif1").prop("required", false);
        $("#tambah-tarif2").prop("required", false);
        $("#tambah-pemeliharaan").prop("required", false);
        $("#tambah-bbn").prop("required", false);
        $("#tambah-arkot").prop("required", false);
        $("#tambah-denda").prop("required", false);
        $("#tambah-ppnair").prop("required", false);

        $("#edit-tarif1").prop("required", false);
        $("#edit-tarif2").prop("required", false);
        $("#edit-pemeliharaan").prop("required", false);
        $("#edit-bbn").prop("required", false);
        $("#edit-arkot").prop("required", false);
        $("#edit-denda").prop("required", false);
        $("#edit-ppnair").prop("required", false);
    }

    function nonKeamananipk(){
        $(".keamananipk").fadeOut(200);

        $("#tambah-keamananipk").prop("required", false);
        $("#tambah-keamanan").prop("required", false);
        $("#tambah-ipk").prop("required", false);

        $("#edit-keamananipk").prop("required", false);
        $("#edit-keamanan").prop("required", false);
        $("#edit-ipk").prop("required", false);
    }

    function nonKebersihan(){
        $(".kebersihan").fadeOut(200);

        $("#tambah-kebersihan").prop("required", false);

        $("#edit-kebersihan").prop("required", false);
    }

    function nonAirkotor(){
        $(".airkotor").fadeOut(200);

        $("#tambah-airkotor").prop("required", false);

        $("#edit-airkotor").prop("required", false);
    }

    function nonLainnya(){
        $(".lainnya").fadeOut(200);

        $("#tambah-lainnya").prop("required", false);

        $("#edit-lainnya").prop("required", false);
    }

    function listrik(){
        $(".listrik").fadeIn(200);

        $("#tambah-beban").prop("required", true);
        $("#tambah-blok1").prop("required", true);
        $("#tambah-blok2").prop("required", true);
        $("#tambah-standar").prop("required", true);
        $("#tambah-pju").prop("required", true);
        $("#tambah-denda1").prop("required", true);
        $("#tambah-denda2").prop("required", true);
        $("#tambah-ppnlistrik").prop("required", true);

        $("#edit-beban").prop("required", true);
        $("#edit-blok1").prop("required", true);
        $("#edit-blok2").prop("required", true);
        $("#edit-standar").prop("required", true);
        $("#edit-pju").prop("required", true);
        $("#edit-denda1").prop("required", true);
        $("#edit-denda2").prop("required", true);
        $("#edit-ppnlistrik").prop("required", true);
    }

    function airbersih(){
        $(".airbersih").fadeIn(200);

        $("#tambah-tarif1").prop("required", true);
        $("#tambah-tarif2").prop("required", true);
        $("#tambah-pemeliharaan").prop("required", true);
        $("#tambah-bbn").prop("required", true);
        $("#tambah-arkot").prop("required", true);
        $("#tambah-denda").prop("required", true);
        $("#tambah-ppnair").prop("required", true);

        $("#edit-tarif1").prop("required", true);
        $("#edit-tarif2").prop("required", true);
        $("#edit-pemeliharaan").prop("required", true);
        $("#edit-bbn").prop("required", true);
        $("#edit-arkot").prop("required", true);
        $("#edit-denda").prop("required", true);
        $("#edit-ppnair").prop("required", true);
    }

    function keamananipk(){
        $(".keamananipk").fadeIn(200);

        $("#tambah-keamananipk").prop("required", true);
        $("#tambah-keamanan").prop("required", true);
        $("#tambah-ipk").prop("required", true);

        $("#edit-keamananipk").prop("required", true);
        $("#edit-keamanan").prop("required", true);
        $("#edit-ipk").prop("required", true);
    }

    function kebersihan(){
        $(".kebersihan").fadeIn(200);

        $("#tambah-kebersihan").prop("required", true);

        $("#edit-kebersihan").prop("required", true);
    }

    function airkotor(){
        $(".airkotor").fadeIn(200);

        $("#tambah-airkotor").prop("required", true);

        $("#edit-airkotor").prop("required", true);
    }

    function lainnya(){
        $(".lainnya").fadeIn(200);

        $("#tambah-lainnya").prop("required", true);

        $("#edit-lainnya").prop("required", true);
    }
</script>
@endsection
