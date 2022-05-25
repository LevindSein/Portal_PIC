<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Data Aktifitas User</title>

        <style type="text/css">
            @media print{
                @page {
                    height: 21cm;   /* auto is the initial value */
                    width: 29.7cm;
                    margin: auto;  /* this affects the margin in the printer settings */
                    border: 1px solid black;  /* set a border for all printed pages */
                    size: landscape;
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
                        <th colspan="3" style="border-style:none;">
                            <img style="max-width: 45%;" src="{{asset('images/logo.png')}}" />
                        </th>
                        <th colspan="3" style="border-style:none;">
                            <h4>Data Aktifitas {{$start}} s.d {{$end}}</h4>
                            <h4>us:{{substr($username, 0, 20)}} | nm:{{substr($name, 0, 20)}} | lv:{{$level}}</h4>
                        </th>
                    </tr>
                    <tr>
                        <th class="tg-r8fv">No.</th>
                        <th class="tg-r8fv">Log Name</th>
                        <th class="tg-r8fv">Desc</th>
                        <th class="tg-r8fv">Old</th>
                        <th class="tg-r8fv">New</th>
                        <th class="tg-r8fv">Times</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height: 10px">
                    </tr>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($data as $d)
                    @php
                        $json = json_decode($d->properties);
                    @endphp
                    <tr>
                        <td class="tg-g25h" style="text-align: center;">{{$i}}</td>
                        <td class="tg-g25h" style="text-align: center;">{{$d->log_name}}</td>
                        <td class="tg-g25h" style="text-align: center;">{{$d->description}}</td>
                        <td class="tg-g25h" style="text-align: center;">
                            @if(isset($json->old))
                            @foreach ($json->old as $key => $value)
                            @if($value)
                                {{$key}} : <span style="white-space: normal;">{{$value}}</span><br>
                            @endif
                            @endforeach
                            @else
                            &nbsp;
                            @endif
                        </td>
                        <td class="tg-g25h" style="text-align: center; width: 50px">
                            @if(isset($json->attributes))
                            @foreach ($json->attributes as $key => $value)
                            @if($value)
                                {{$key}} : <span style="white-space: normal;">{{$value}}</span><br>
                            @endif
                            @endforeach
                            @else
                            &nbsp;
                            @endif
                        </td>
                        <td class="tg-g25h" style="text-align: center;">{{$d->updated_at}}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="border-style:none;">
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
