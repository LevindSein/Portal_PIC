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
            <th class="min-tablet">Fasilitas</th>
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
    var dtable = $('#dtable').DataTable({
        responsive : true,
        language : {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        serverSide : true,
        ajax : "/services/place",
        columns : [
            { data: 'name', name: 'name', class : 'text-center align-middle' },
            { data: 'pengguna.name', name: 'pengguna.name', class : 'text-center align-middle' },
            { data: 'jml_los', name: 'jml_los', class : 'text-center align-middle' },
            { data: 'fasilitas', name: 'fasilitas', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        stateSave : true,
        deferRender : true,
        pageLength : 5,
        aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
        order : [[ 0, "asc" ]],
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [3,4] },
            { "bSearchable": false, "aTargets": [3, 4] }
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

    function select2group(select2id, url, placeholder){
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
                                id: d.name,
                                text: d.name
                            }
                        })
                    };
                },
            }
        });
    }

    function select2los(select2id, url, placeholder){
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
                                id: d,
                                text: d
                            }
                        })
                    };
                },
            }
        });
    }

    function select2user(select2id, url, placeholder){
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
                                text: d.name + ' (' + d.ktp + ')'
                            }
                        })
                    };
                },
            }
        });
    }

    function select2alat(select2id, url, level, placeholder){
        url = url + "?level=" + level;
        if(level == 1){
            $(select2id).select2({
                placeholder: placeholder,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (data, $level) {
                        return {
                            results:  $.map(data, function (d) {
                                return {
                                    id: d.id,
                                    text: d.name + ' (' + d.stand + ' - ' + d.daya + 'W)'
                                }
                            })
                        };
                    },
                }
            });
        } else {
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
                                    text: d.name + ' (' + d.stand + ')'
                                }
                            })
                        };
                    },
                }
            });
        }
    }

    function select2tarif1(select2id, url, level, placeholder){
        url = url + "?level=" + level;
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
                                text: d.name + ' - ' + d.status
                            }
                        })
                    };
                },
            }
        });
    }

    function select2tarif2(select2id, url, level, placeholder){
        url = url + "?level=" + level;
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
                                text: d.name + ' - Rp ' + Number(d.data.Tarif).toLocaleString('id-ID') + ' ' + d.status
                            }
                        })
                    };
                },
            }
        });
    }
</script>
@endsection
