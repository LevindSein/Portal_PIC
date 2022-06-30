<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Data Tempat</title>

        <style type="text/css">
            @media print{
                @page {
                    height: 21cm;   /* auto is the initial value */
                    width: 29.7cm;
                    margin: auto;  /* this affects the margin in the printer settings */
                    border: 1px solid black;  /* set a border for all printed pages */
                }
            }

            thead {display: table-header-group;}

            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                color: #000;
                text-decoration: underline;
            }

            td{
                white-space: nowrap;
            }

            body {
                position: relative;
                width: 29.7cm;
                height: 21cm;
                margin: auto;
                color: #000;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 12px;
                font-family: Arial;
                -webkit-print-color-adjust: exact;
            }

            header {
                padding: 10px 0;
                margin-bottom: 30px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
            }

            .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{font-family:Arial, sans-serif;font-size:12px;padding:5px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:5px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg .tg-r8fv{font-family:Arial, Helvetica, sans-serif !important;font-weight:bold;color:#000000;text-align:center;vertical-align:middle}
            .tg .tg-g25h{font-family:Arial, Helvetica, sans-serif !important;color:#000000;vertical-align:middle}
        </style>

        @laravelPWA
    </head>

    <body>
        <div class="se-pre-con"></div>

        <div>
            <table class="tg">
                <thead>
                    <tr>
                        <th colspan="13" style="border-style:none;">
                            <img style="max-width: 65%;" src="{{asset('images/logo.png')}}" />
                            <h2>Data Tempat</h2>
                        </th>
                    </tr>
                    <tr>
                        <th class="tg-r8fv" rowspan="2">No.</th>
                        <th class="tg-r8fv" rowspan="2">Kontrol</th>
                        <th class="tg-r8fv" rowspan="2">No. Los</th>
                        <th class="tg-r8fv" rowspan="2">Jml Los</th>
                        <th class="tg-r8fv" rowspan="2">Pengguna</th>
                        <th class="tg-r8fv" rowspan="2">Pemilik</th>
                        <th class="tg-r8fv" colspan="6">Fasilitas yang digunakan</th>
                        <th class="tg-r8fv" rowspan="2">Status</th>
                    </tr>
                    <tr>
                        <th class="tg-r8fv">LI</th>
                        <th class="tg-r8fv">AB</th>
                        <th class="tg-r8fv">KI</th>
                        <th class="tg-r8fv">KB</th>
                        <th class="tg-r8fv">AK</th>
                        <th class="tg-r8fv">LA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height: 10px">
                    </tr>
                    @php
                        $i = 1;
                    @endphp
                    @if($data->isNotEmpty())
                    @foreach ($data as $d)
                    <tr>
                        <td class="tg-g25h" style="text-align: center;">{{$i}}</td>
                        <td class="tg-g25h" style="text-align: center;">{{$d->name}}</td>
                        <td class="tg-g25h" style="text-align: center; white-space: normal;">{{implode(', ', $d->los)}}</td>
                        <td class="tg-g25h" style="text-align: center;">{{$d->jml_los}}</td>
                        <td class="tg-g25h" style="text-align: center; white-space: normal;">{{$d->pengguna->name}}</td>
                        <td class="tg-g25h" style="text-align: center; white-space: normal;">{{$d->pemilik->name}}</td>
                        @if($d->trf_listrik_id)
                        <td class="tg-g25h" style="text-align: center;">&#10004;</td>
                        @else
                        <td class="tg-g25h" style="text-align: center;"></td>
                        @endif
                        @if($d->trf_airbersih_id)
                        <td class="tg-g25h" style="text-align: center;">&#10004;</td>
                        @else
                        <td class="tg-g25h" style="text-align: center;"></td>
                        @endif
                        @if($d->trf_keamananipk_id)
                        <td class="tg-g25h" style="text-align: center;">&#10004;</td>
                        @else
                        <td class="tg-g25h" style="text-align: center;"></td>
                        @endif
                        @if($d->trf_kebersihan_id)
                        <td class="tg-g25h" style="text-align: center;">&#10004;</td>
                        @else
                        <td class="tg-g25h" style="text-align: center;"></td>
                        @endif
                        @if($d->trf_airkotor_id)
                        <td class="tg-g25h" style="text-align: center;">&#10004;</td>
                        @else
                        <td class="tg-g25h" style="text-align: center;"></td>
                        @endif
                        @if($d->trf_lainnya_id)
                        <td class="tg-g25h" style="text-align: center;">&#10004;</td>
                        @else
                        <td class="tg-g25h" style="text-align: center;"></td>
                        @endif
                        <td class="tg-g25h" style="text-align: center;">{{\App\Models\Tempat::status($d->status)}}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    @else
                    <tr>
                        <td class="tg-g25h" style="text-align: center;" colspan="13">No Data Available.</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="13" style="border-style:none;">
                            <br><br>
                            <div style="text-align:right;">
                                <b>Bandung, {{\Carbon\Carbon::now()}}</b>
                            </div>
                            <br><br><br>
                            <div style="text-align:right;">
                                <b>{{Auth::user()->name}}</b>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach(config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

    <script>
        $(document).ready(function(){
            window.print();
        });
    </script>
</html>
