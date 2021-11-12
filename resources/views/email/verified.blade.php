<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">

    <script src="{{asset('template/assets/libs/jquery/dist/jquery.min.js')}}"></script>

    <title>Verifikasi Email</title>
</head>

<body style="margin:0px; background: #f8f8f8; ">
    <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
        <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
            <table cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 25px; border: 0">
                <tbody>
                    <tr>
                        <td style="vertical-align: top; padding-bottom:30px; margin:auto; width:50%; text-align:center; align-items: center;">
                            <img src="{{asset('storage/logo.png')}}" alt="PIC BDG" style="border: none;" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" style="width: 100%; border: 0;">
                <tbody>
                    <tr>
                        <td style="background:#2962ff; padding:20px; color:#fff; text-align:center;"> Verifikasi Email. </td>
                    </tr>
                </tbody>
            </table>
            <div style="padding: 40px; background: #fff;">
                <table cellpadding="0" cellspacing="0" style="width: 100%; border: 0;">
                    <tbody>
                        <tr>
                            <td>
                                <p>Terimakasih sudah menjadi bagian dari kami.</p>
                                <div style="text-align: center;">
                                    <h2><b>Verifikasi Berhasil</b></h2>
                                    <a href="{{url("/")}}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #4fc3f7; border-radius: 60px; text-decoration:none;">Kunjungi Portal</a>
                                </div>
                                <b>- Selamat Berniaga (PIC BDG Team)</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            localStorage.setItem("email", "terverifikasi");
        });
    </script>
</body>

</html>
