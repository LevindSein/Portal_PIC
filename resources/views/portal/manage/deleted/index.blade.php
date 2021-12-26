@extends('portal.layout.master')

@section('content-title')
Penghapusan Tagihan
@endsection

@section('content-button')
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Menu
    </button>
    <div class="dropdown-menu animated fadeIn mr-3">
        @include('portal.manage.button')
    </div>
</div>
@endsection

@section('content-body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group col-md-3 col-sm-12" style="padding: 0;">
                    <label for="period">Periode Tagihan</label>
                    <select class="select2 form-control" id="period" name="period"></select>
                </div>
                <div class="table-responsive">
                    <table id="dtable" class="table table-striped table-bordered display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kontrol</th>
                                <th>Nama</th>
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
        $("#period").val("").html("");
        select2period("#period", "/search/period", "-- Cari Periode Tagihan --");
        $("#period").on('select2:open', () => {
            $('input.select2-search__field').prop('placeholder', 'Ketik disini untuk mencari..');
        });

        period();
    });

    function period(){
        $.ajax({
            url: "/production/manage/bills/period",
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#period").val("").html("");
                    var period = new Option(data.success.nicename, data.success.id, false, false);
                    $('#period').append(period).trigger('change');
                }
            }
        });
    }

    $("#period").on('change', function(e){
        e.preventDefault();
        $.ajax({
            url: "/production/manage/bills/period/" + $("#period").val(),
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    dtableReload('');
                }
            }
        });
    });

    var id;
    var dtable = $('#dtable').DataTable({
        "language": {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        "serverSide": true,
        "ajax": "/production/manage/deleted",
        "columns": [
            { data: 'kd_kontrol', name: 'nicename', class : 'text-center align-middle' },
            { data: 'name', name: 'name', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        "stateSave": true,
        "deferRender": true,
        "pageLength": 10,
        "aLengthMenu": [[5,10,25,50,100], [5,10,25,50,100]],
        "order": [[ 0, "asc" ]],
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [2] },
            { "bSearchable": false, "aTargets": [2] }
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
            }, 10);
            setTimeout( function () {
                $("[data-toggle='popover']").popover();
            }, 10);
        },
    });

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        dtable.column( 1 ).visible( false, false );
        dtable.columns.adjust().draw( false );
    }
    else{
        dtable.column( 1 ).visible( true, false );
        dtable.columns.adjust().draw( false );
    }

    setInterval(function(){
        dtableReload('');
    }, 60000);

    function dtableReload(searchKey){
        if(searchKey){
            dtable.search(searchKey).draw();
        }
        dtable.ajax.reload(function(){
            console.log("Refresh Automatic")
        }, false);

        $(".tooltip").tooltip("hide");

        $(".popover").popover("hide");
    }

    function select2period(select2id, url, placeholder){
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
                                text: d.nicename
                            }
                        })
                    };
                },
            }
        });
    }
</script>
@endsection
