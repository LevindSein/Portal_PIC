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
                                <p>Berikut adalah pesan untuk <b>{{$type}}</b> akun anda <a href="{{url('/')}}">Member Area</a> Pasar Induk Caringin Kota Bandung sebagai <b>{{$role}}</b>.</p>
                                <p>Silakan klik tombol di bawah ini :</p>
                                <div style="text-align: center;">
                                    <p>uid : <b>{{$uid}}</b></p>
                                    <p>password : <b>{{$password}}</b></p>
                                    <a href="{{$url}}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #4fc3f7; border-radius: 60px; text-decoration:none;">{{$button}}</a>
                                </div>
                                <b>- {{$regards}}</b>
                                <p>Jika tombol di atas tidak berfungsi, silakan kunjungi</p>
                                <p style="font-size: 12px">{{$url}}</p>
                                <p style="font-size: 10px">Pesan ini dikirim oleh sistem. Anda tidak perlu membalasnya.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
