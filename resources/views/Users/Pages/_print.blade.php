<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Data Pengguna</title>

        <style type="text/css">
            @media print{
                @page {
                    height: 29.7cm;   /* auto is the initial value */
                    width: 21cm;
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
                width: 21cm;
                height: 29.7cm;
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

            h1 {
                border-top: 1px solid  #000;
                border-bottom: 1px solid  #000;
                color: #000;
                padding: 10px;
                font-size: 2em;
                line-height: 1.5em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
            }

            #project {
                float: left;
            }

            #project span {
                color: #000;
                text-align: right;
                width: 52px;
                margin-right: 60px;
                display: inline-block;

            }

            #company {
                float: right;
                text-align: right;
            }

            #ttd {
                float: right;
                text-align: center;
            }

            #project div,
            #company div {
                white-space: nowrap;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
            }

            .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg .tg-vbo4{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;color:#000000;text-align:right;vertical-align:middle}
            .tg .tg-ccvv{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;color:#000000;text-align:center;vertical-align:top}
            .tg .tg-rtqe{font-family:Arial, Helvetica, sans-serif !important;;color:#000000;text-align:left;vertical-align:middle}
            .tg .tg-8m6k{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;color:#000000;text-align:right;vertical-align:top}
            .tg .tg-r8fv{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;color:#000000;text-align:center;vertical-align:middle}
            .tg .tg-cegc{font-family:Arial, Helvetica, sans-serif !important;;color:#000000;text-align:center;vertical-align:middle}
            .tg .tg-g25h{font-family:Arial, Helvetica, sans-serif !important;;color:#000000;text-align:right;vertical-align:center}

            #notices .notice {
                color: #5D6975;
            }

            footer {
                color: #5D6975;
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #000;
                padding: 8px 0;
                text-align: center;
            }
        </style>

        @laravelPWA
    </head>

    <body>
        <div class="se-pre-con"></div>

        <div>
            <table class="tg">
                <thead>
                    <tr>
                        <th colspan="5" style="border-style:none;">
                            <img style="max-width: 65%;" src="{{asset('images/logo.png')}}" />
                            <h2>Data Pengguna</h2>
                            <h3 style="text-transform: uppercase">{{$level}}&nbsp;&mdash;&nbsp;{{$status}}</h3>
                        </th>
                    </tr>
                    <tr>
                        <th class="tg-r8fv">No.</th>
                        <th class="tg-r8fv">Username</th>
                        <th class="tg-r8fv">Nama</th>
                        <th class="tg-r8fv">Level</th>
                        <th class="tg-r8fv">status</th>
                    </tr>
                </thead>
                @if($dataset->count() > 0)
                <tbody>
                    <tr style="height: 10px">
                    </tr>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($dataset as $d)
                    <tr>
                        <td class="tg-g25h">{{$i}}</td>
                        <td class="tg-g25h" style="white-space: normal;">{{$d->username}}</td>
                        <td class="tg-g25h" style="white-space: normal;">{{$d->name}}</td>
                        <td class="tg-g25h">{{\App\Models\User::level($d->level)}}</td>
                        <td class="tg-g25h">{{\App\Models\User::status($d->status)}}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </tbody>
                @else
                <tbody>
                    <tr style="height: 10px">
                    </tr>
                    <tr>
                        <td class="tg-g25h" style="text-align: center;" colspan="5">No Data Available.</td>
                    </tr>
                </tbody>
                @endif
                <tfoot>
                    <tr>
                        <th colspan="5" style="border-style:none;">
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
