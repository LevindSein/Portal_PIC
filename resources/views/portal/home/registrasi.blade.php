<!DOCTYPE html>
<html style="font-size: 16px;">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="keyword" content="Pasar Bandung, Pasar Tradisional, Pasar Induk, Caringin, Pasar Induk Caringin Kota Bandung"/>
    <meta name="author" content="Pasar Induk Caringin Kota Bandung"/>
    <meta name="description"content="Login untuk Member Area Pasar Induk Caringin Kota Bandung" />
    <meta property="og:site_name" content="Pasar Induk Caringin Kota Bandung">
    <meta property="og:title" content="Pasar Induk Caringin Kota Bandung" />
    <meta property="og:description" content="Login untuk Member Area Pasar Induk Caringin Kota Bandung" />
    <meta property="og:image" itemprop="image" content="{{asset('portal/home/login/img/favicon.png')}}">
    <meta property="og:type" content="website" />
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link rel="icon" sizes="16x16 32x32 64x64" href="{{asset('img/favicon.png')}}">
    <link rel="icon" sizes="196x196" href="{{asset('img/favicon.png')}}">
    <link rel="icon" sizes="160x160" href="{{asset('img/favicon.png')}}">
    <link rel="icon" sizes="96x96" href="{{asset('img/favicon.png')}}">
    <link rel="icon" sizes="64x64" href="{{asset('img/favicon.png')}}">
    <link rel="icon" sizes="32x32" href="{{asset('img/favicon.png')}}">
    <link rel="icon" sizes="16x16" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon.png')}}">
    <meta name="google" content="notranslate">

    <link rel="stylesheet" href="{{asset('portal/home/registrasi/nicepage.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('portal/home/registrasi/Page-17.css')}}" media="screen">
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
                        <b>Download</b> dan <b>Tunjukkan</b>&nbsp;<br>QR Code Pendaftaran pada Divisi Layanan Pedagang<br>Pasar Induk Caringin Kota Bandung.<br>Siapkan <b>KTP</b> &amp; <b>NPWP</b> (Jika ada)
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

    <script type="text/javascript" src="{{asset('portal/home/registrasi/jquery.min.js')}}"></script>
    <script src="{{asset('portal/home/registrasi/html2canvas.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('portal/home/registrasi/nicepage.js')}}"></script>
</body>

</html>
