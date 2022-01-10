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
                <div class="form-group col-md-3" style="padding: 0;">
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
<div id="showModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog modal-dialog-centered modal dialog-modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body-xl">
                <small class="text-muted pt-4 db">Kode Tagihan</small>
                <h4 id="showCode"></h4>
                <small class="text-muted pt-4 db">Periode</small>
                <h6 id="showPeriod"></h6>
                <small class="text-muted pt-4 db">Kontrol</small>
                <h6 id="showKontrol"></h6>
                <h3 class="text-center">Tagihan Terhapus</h3>
                <div id="showFasilitas"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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

    $(document).on('click', '.details', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Penghapusan tagihan ' + nama);

        $("#showFasilitas").html('');

        $.ajax({
            url: "/production/manage/deleted/" + id,
            type: "GET",
            cache:false,
            success:function(data){
                if(data.success){
                    $("#showCode").text(data.show.code);
                    $("#showPeriod").text(data.show.period.nicename);
                    $("#showKontrol").text(data.show.kd_kontrol);

                    var html = '';

                    if(data.show.details.del_listrik){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-bolt" style="color:#fd7e14;"></i> Listrik</h5>';
                        html += '<small class="text-muted pt-4 db">Daya</small>';
                        html += '<h6>' + data.show.details.del_listrik.daya + '</h6>';
                        html += '<small class="text-muted pt-4 db">Awal</small>';
                        html += '<h6>' + data.show.details.del_listrik.awal + '</h6>';
                        html += '<small class="text-muted pt-4 db">Akhir</small>';
                        html += '<h6>' + data.show.details.del_listrik.akhir + '</h6>';
                        html += '<small class="text-muted pt-4 db">Pakai</small>';
                        html += '<h6>' + data.show.details.del_listrik.pakai + '</h6>';
                        html += '<small class="text-muted pt-4 db">Tagihan</small>';
                        html += '<h6 class="text-info">Rp. ' + data.show.details.del_listrik.ttl_tagihan + '</h6>';
                        html += '<small class="text-muted pt-4 db">Dihapus oleh</small>';
                        html += '<h6>' + data.show.details.del_listrik.name + '</h6>';
                        html += '<h6>' + data.show.details.del_listrik.time + '</h6>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.details.del_airbersih){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-tint" style="color:#36b9cc;""></i> Air Bersih</h5>';
                        html += '<small class="text-muted pt-4 db">Awal</small>';
                        html += '<h6>' + data.show.details.del_airbersih.awal + '</h6>';
                        html += '<small class="text-muted pt-4 db">Akhir</small>';
                        html += '<h6>' + data.show.details.del_airbersih.akhir + '</h6>';
                        html += '<small class="text-muted pt-4 db">Pakai</small>';
                        html += '<h6>' + data.show.details.del_airbersih.pakai + '</h6>';
                        html += '<small class="text-muted pt-4 db">Tagihan</small>';
                        html += '<h6 class="text-info">Rp. ' + data.show.details.del_airbersih.ttl_tagihan + '</h6>';
                        html += '<small class="text-muted pt-4 db">Dihapus oleh</small>';
                        html += '<h6>' + data.show.details.del_airbersih.name + '</h6>';
                        html += '<h6>' + data.show.details.del_airbersih.time + '</h6>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.details.del_keamananipk){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-lock" style="color:#e74a3b;"></i> Keamanan IPK</h5>';
                        html += '<small class="text-muted pt-4 db">Jml_Los</small>';
                        html += '<h6>' + data.show.details.del_keamananipk.jml_los + '</h6>';
                        html += '<small class="text-muted pt-4 db">Tagihan</small>';
                        html += '<h6 class="text-info">Rp. ' + data.show.details.del_keamananipk.ttl_tagihan + '</h6>';
                        html += '<small class="text-muted pt-4 db">Dihapus oleh</small>';
                        html += '<h6>' + data.show.details.del_keamananipk.name + '</h6>';
                        html += '<h6>' + data.show.details.del_keamananipk.time + '</h6>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.details.del_kebersihan){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fas fa-leaf" style="color:#1cc88a;"></i> Kebersihan</h5>';
                        html += '<small class="text-muted pt-4 db">Jml_Los</small>';
                        html += '<h6>' + data.show.details.del_kebersihan.jml_los + '</h6>';
                        html += '<small class="text-muted pt-4 db">Tagihan</small>';
                        html += '<h6 class="text-info">Rp. ' + data.show.details.del_kebersihan.ttl_tagihan + '</h6>';
                        html += '<small class="text-muted pt-4 db">Dihapus oleh</small>';
                        html += '<h6>' + data.show.details.del_kebersihan.name + '</h6>';
                        html += '<h6>' + data.show.details.del_kebersihan.time + '</h6>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(data.show.details.del_airkotor){
                        html += '<div class="form-group">';
                        html += '<h5><i class="fad fa-burn" style="color:#000000;"></i> Air Kotor</h5>';
                        html += '<small class="text-muted pt-4 db">Tagihan</small>';
                        html += '<h6 class="text-info">Rp. ' + data.show.details.del_airkotor.ttl_tagihan + '</h6>';
                        html += '<small class="text-muted pt-4 db">Dihapus oleh</small>';
                        html += '<h6>' + data.show.details.del_airkotor.name + '</h6>';
                        html += '<h6>' + data.show.details.del_airkotor.time + '</h6>';
                        html += '</div>';
                        html += '<hr>';
                    }

                    if(html){
                        $("#showFasilitas").append(html);
                    }
                    else {
                        html += '<div class="form-group mt-4 text-center">';
                        html += '<img src="/img/sad.png" class="rounded-circle" width="180" />';
                        html += '<h4>Tidak memiliki tagihan terhapus</h4>'
                        html += '</div>';
                        $("#showFasilitas").append(html);
                    }
                }

                if(data.error){
                    toastr.error(data.error);
                }

                if(data.warning){
                    toastr.warning(data.warning);
                }

                if(data.info){
                    toastr.info(data.info);
                }

                if(data.description){
                    console.log(data.description);
                }
            },
            error:function(data){
                toastr.error("Fetching data failed.");
                console.log(data);
            },
            complete:function(){
                $('#showModal').modal('show');
            }
        });
    });

    $(document).on('click', '.restore', function(){
        id = $(this).attr('id');
        nama = $(this).attr('nama');
        $('.titles').text('Restore data penghapusan ' + nama + ' ke Tagihan Aktif?');
        $.ajax({
            url: '/production/manage/deleted/' + id + '/check',
            type: 'GET',
            cache:false,
            success:function(data){
                $('.bodies').html(
                    'Pilih <b>Restore</b> di bawah ini jika anda yakin untuk memulihkan tagihan. Data yang akan dipulihkan adalah semua data yang <b>belum lunas</b> dan <b>tagihan yang sedang aktif tidak akan terpengaruh.</b><br>' +
                    'Tagihan yang akan dipulihkan, yaitu :<br>' +
                    data.show
                );
            },
            error:function(data){
                toastr.error("Fetching data failed.");
                console.log(data);
            },
            complete:function(){
                $('#ok_button').removeClass().addClass('btn btn-info').text('Restore');
                $('#confirmValue').val('restore');
                $('#confirmModal').modal('show');
            }
        });
    });

    $('#confirmForm').submit(function(e){
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var value = $('#confirmValue').val();
        dataset = {
            'id' : id,
            '_token' : token,
        }

        if(value == 'restore'){
            url = "/production/manage/deleted/" + id;
            type = "POST";
        }

        ajaxForm(url, type, value, dataset);
    });

    function ajaxForm(url, type, value, dataset){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: type,
            cache:false,
            data: dataset,
            beforeSend:function(){
                $.blockUI({
                    message: '<i class="fad fa-spin fa-spinner text-white"></i>',
                    baseZ: 9999,
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.5,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
            },
            success:function(data)
            {
                if(data.success){
                    toastr.success(data.success);
                    dtableReload('');
                }

                if(data.error){
                    toastr.error(data.error);
                }

                if(data.warning){
                    toastr.warning(data.warning);
                }

                if(data.info){
                    toastr.info(data.info);
                }

                if(data.description){
                    console.log(data.description);
                }
            },
            error:function(data){
                if (data.status == 422) {
                    $.each(data.responseJSON.errors, function (i, error) {
                        toastr.error(error[0]);
                    });
                }
                else{
                    toastr.error("System error.");
                }
                console.log(data);
            },
            complete:function(data){
                if(value == 'add' || value == 'update'){
                    if(JSON.parse(data.responseText).success)
                        $('#billModal').modal('hide');
                }
                else{
                    $('#confirmModal').modal('hide');
                }
                $.unblockUI();
            }
        });
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
