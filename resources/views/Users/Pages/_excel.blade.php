<table>
    <tr>
        <td colspan="5" align="center" style="border: 1px solid #000000;"><b>Data Pengguna</b></td>
    </tr>
    <tr>
        <td colspan="5" align="center" style="border: 1px solid #000000;"><b>LVL : {{strtoupper($level)}} - STT : {{strtoupper($status)}}</b></td>
    </tr>
    <tr>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>No.</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Username</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Nama</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Level</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Status</b></td>
    </tr>
    @php
        $i = 1;
    @endphp
    @foreach ($data as $d)
    <tr>
        <td style="border: 1px solid #000000;">{{$i}}</td>
        <td style="border: 1px solid #000000;">{{$d->username}}</td>
        <td style="border: 1px solid #000000;">{{$d->name}}</td>
        <td align="center" style="border: 1px solid #000000;">{{\App\Models\User::level($d->level)}}</td>
        <td align="center" style="border: 1px solid #000000;">{{\App\Models\User::status($d->status)}}</td>
    </tr>
    @php
        $i++;
    @endphp
    @endforeach
    <tr></tr>
    <tr>
        <td colspan="5" align="right"><b>Bandung, {{\Carbon\Carbon::now()}}</b></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="5" align="right"><b>{{Auth::user()->name}}</b></td>
    </tr>
</table>
