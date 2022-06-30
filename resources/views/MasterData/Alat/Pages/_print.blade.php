<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Data Alat Meter</title>

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

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
            }

            .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 15px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
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
                        <th colspan="{{ ($levelAlat == 1) ? 6 : 5}}" style="border-style:none;">
                            <img style="max-width: 65%;" src="{{asset('images/logo.png')}}" />
                            <h2>Data Alat Meter {{$level}}</h2>
                        </th>
                    </tr>
                    <tr>
                        <th class="tg-r8fv">No.</th>
                        <th class="tg-r8fv">Kode</th>
                        <th class="tg-r8fv">Nama</th>
                        <th class="tg-r8fv">Stand</th>
                        @if($levelAlat == 1)
                        <th class="tg-r8fv">Daya</th>
                        @endif
                        <th class="tg-r8fv">Status</th>
                    </tr>
                </thead>
                @if($data->count() > 0)
                <tbody>
                    <tr style="height: 10px">
                    </tr>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($data as $d)
                    <tr>
                        <td class="tg-g25h" style="text-align: center;">{{$i}}</td>
                        <td class="tg-g25h" style="text-align: left; white-space: normal;">{{$d->code}}</td>
                        <td class="tg-g25h" style="text-align: left; white-space: normal;">{{$d->name}}</td>
                        <td class="tg-g25h" style="text-align: left; white-space: normal;">{{$d->stand}}</td>
                        @if($levelAlat == 1)
                        <td class="tg-g25h" style="text-align: left; white-space: normal;">{{$d->daya}}</td>
                        @endif
                        <td class="tg-g25h" style="text-align: left; white-space: normal;">{{$d->status}}</td>
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
                        <td class="tg-g25h" style="text-align: center;" colspan="{{ ($levelAlat == 1) ? 6 : 5}}">No Data Available.</td>
                    </tr>
                </tbody>
                @endif
                <tfoot>
                    <tr>
                        <th colspan="{{ ($levelAlat == 1) ? 6 : 5}}" style="border-style:none;">
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
