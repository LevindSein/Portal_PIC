@extends('Layout.index')

@section('content-title')
Tagihan
@endsection

@section('content-button')
@include('Tagihan.Partial._button')
@endsection

@section('content-body')
<div class="form-group row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <select class="form-control form-control-sm" id="periode" name="periode" style="text-align-last: center;">
            @foreach ($periode as $d)
            <option style="text-align: center;" value="{{$d->id}}">{{$d->nicename}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-4"></div>
</div>
<table class="table table-striped table-hover" width="100%" id="dtable">
    <thead>
        <tr>
            <th class="all">Kontrol</th>
            <th class="min-tablet">Nama</th>
            <th class="min-tablet">Fasilitas</th>
            <th class="all">Tagihan</th>
            <th class="all">Action</th>
        </tr>
    </thead>
</table>
@endsection

@section('content-modal')
@include('Tagihan.Modal._tambah')
@include('Tagihan.Modal._edit')
@include('Tagihan.Modal._hapus')
@include('Tagihan.Modal._rincian')
@endsection

@section('content-js')
<script>
    var status = $("#status").prop("selectedIndex", 0).val(), periode = $("#periode").prop("selectedIndex", 0).val(), content_title = 'Tagihan Aktif';
    $(".content-title").text(content_title);

    var url = "/tagihan?status=" + status + "&periode=" + periode;

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
            { data: 'pengguna.name', name: 'pengguna.name', class : 'text-center align-middle' },
            { data: 'fasilitas', name: 'fasilitas', class : 'text-center align-middle' },
            { data: 'tagihan', name: 'tagihan', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        stateSave : true,
        deferRender : true,
        pageLength : 5,
        aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
        order : [[ 0, "asc" ]],
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [2,3,4] },
            { "bSearchable": false, "aTargets": [2,3,4] }
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

    $(document).on('change', '#status, #periode', function(){
        status  = $("#status").val();
        periode = $("#periode").val();
        if(status == 2){
            content_title = 'Tagihan Draft';
        } else if (status == 1){
            content_title = 'Tagihan Aktif';
        } else {
            content_title = 'Tagihan Dihapus';
        }

        $(".content-title").text(content_title);
        url = "/tagihan?status=" + status + "&periode=" + periode;
        dtable.ajax.url( url ).load();
        dtableReload();
    });

    function select2tempat(select2id, url, placeholder){
        $(select2id).select2({
            placeholder: placeholder,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                cache: true,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (d) {
                            return {
                                id: d.id,
                                text: d.name
                            }
                        })
                    };
                },
            }
        });
    }
</script>
@endsection
