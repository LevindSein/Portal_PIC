<!DOCTYPE html>
<html style="font-size: 16px;">

<head>
    @include('portal.home.header')

    <link rel="stylesheet" href="{{asset('portal/home/register/nicepage.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('portal/home/register/Page-17.css')}}" media="screen">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('vendor/fontawesomepro/css/all.min.css')}}" type="text/css">

    <title>QR Registrasi | Portal PIC</title>
</head>

<body class="u-body">
    <section class="u-clearfix u-section-1" id="sec-84aa">
        <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
            <div class="u-container-style u-group u-shape-rectangle u-group-1">
                <div class="u-container-layout u-container-layout-1">
                    <h1 class="u-align-center u-text u-text-custom-color-2 u-text-default u-text-1">Selesaikan Pendaftaran<br></h1>
                    <div style="text-align: center; margin-top: 1rem;">
                        <div>
                            {{$qr}}
                        </div>
                    </div>
                    <a href='{{url("register/download/$token")}}' id="btn_download" class="u-border-none u-btn u-btn-round u-button-style u-custom-color-2 u-hover-custom-color-1 u-radius-50 u-btn-1">Download</a>
                    <p class="u-align-center u-text u-text-2">
                        <b>Download</b> dan <b>Tunjukkan</b>&nbsp;<br>QR Code Pendaftaran pada Divisi Layanan Pedagang<br>Pasar Induk Caringin Kota Bandung, sebelum tanggal <b>{{$available}}</b>.<br>Siapkan <b>KTP</b> &amp; <b>NPWP</b> (Jika ada)
                    </p>
                    <p class="u-align-center u-text u-text-3">Alamat Kantor :</p>
                    <p class="u-align-center u-text u-text-4">
                        <a class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-palette-1-base u-btn-2"
                            href="https://goo.gl/maps/VHCMLQ9r44dByrmp8">Pasar Induk Caringin, Ruko blok A No.22-25,
                            Babakan Ciparay, Kec. Babakan Ciparay, Kota Bandung, Jawa Barat 40212</a>
                    </p>
                    <a href="{{url('logout')}}" class="u-btn u-button-style u-none u-text-custom-color-2 u-text-hover-custom-color-1 u-btn-3">
                        <i class="fas fa-chevron-left"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="{{asset('portal/home/register/jquery.min.js')}}"></script>
    <script src="{{asset('portal/home/register/html2canvas.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('portal/home/register/nicepage.js')}}"></script>
</body>

</html>
