<body style="margin:0px; background: #f8f8f8; ">
    <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
        <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
            <table cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 25px; border: 0">
                <tbody>
                    <tr>
                        <td style="vertical-align: top; padding-bottom:30px; margin:auto; width:50%; text-align:center; align-items: center;">
                            <img src="{{$message->embed(asset('storage/logo.png'))}}" alt="PIC BDG" style="border: none;" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" style="width: 100%; border: 0;">
                <tbody>
                    <tr>
                        <td style="background:#e24c26; padding:20px; color:#fff; text-align:center;"> {{$header}} </td>
                    </tr>
                </tbody>
            </table>
            <div style="padding: 40px; background: #fff;">
                <table cellpadding="0" cellspacing="0" style="width: 100%; border: 0;">
                    <tbody>
                        <tr>
                            <td>
                                <p>Yth. Sdr/i {{$name}}</p>
                                <p>Terimakasih telah menjadi bagian dari kami.</p>
                                <p>Berikut adalah pesan untuk <b>{{$type}}</b> akun anda di <a href="{{url('/')}}">Member Area</a> Pasar Induk Caringin Kota Bandung sebagai <b>{{$role}}</b>.</p>
                                <b>- {{$regards}}</b>
                                <p>Apabila Anda ingin melakukan re-aktivasi, silakan datang ke Bagian Pelayanan Pedagang di Kantor Pasar Induk Caringin Kota Bandung, <b>sebelum tanggal {{$limit}}</b></p>
                                <p>
                                    <a href="https://goo.gl/maps/VHCMLQ9r44dByrmp8">Pasar Induk Caringin, Ruko blok A No.22-25, Babakan Ciparay, Kec. Babakan Ciparay, Kota Bandung, Jawa Barat 40212</a>
                                </p>
                                <p style="font-size: 10px">Pesan ini dikirim oleh sistem. Anda tidak perlu membalasnya.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
