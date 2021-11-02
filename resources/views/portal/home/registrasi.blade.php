<!DOCTYPE html>
<html style="font-size: 16px;">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>QR Code Pendaftaran</title>
    <link rel="stylesheet" href="{{asset('portal/home/registrasi/nicepage.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('portal/home/registrasi/Page-17.css')}}" media="screen">
    <link id="u-theme-google-font" rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="QR Code Pendaftaran">
    <meta property="og:type" content="website">
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
                    <a href='{{url("register/download/$name")}}' id="btn_download" class="u-border-none u-btn u-btn-round u-button-style u-custom-color-2 u-hover-custom-color-1 u-radius-50 u-btn-1">Download</a>
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
                        <span class="u-icon u-text-custom-color-2 u-icon-1">
                            <svg class="u-svg-content" viewBox="0 0 492 492" x="0px" y="0px" style="width: 1em; height: 1em;">
                                <g>
                                    <g>
                                        <path
                                            d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12    C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084    c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864    l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </span>&nbsp;Kembali
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
