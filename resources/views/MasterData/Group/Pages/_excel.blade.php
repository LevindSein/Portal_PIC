<table>
    <tr>
        <td colspan="4" align="center" style="border: 1px solid #000000;"><b>Data Grup Tempat</b></td>
    </tr>
    <tr>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>No.</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Nama</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Jml Los</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Alamat</b></td>
    </tr>
    @php
        $i = 1;
    @endphp
    @foreach ($data as $d)
    <tr>
        <td style="border: 1px solid #000000;">{{$i}}</td>
        <td style="border: 1px solid #000000;">{{$d->name}}</td>
        <td style="border: 1px solid #000000;">{{($d->data) ? count(json_decode($d->data)) : 0}}</td>
        <td style="border: 1px solid #000000;">{{($d->data) ? implode(', ', json_decode($d->data))  : ''}}</td>
    </tr>
    @php
        $i++;
    @endphp
    @endforeach
    <tr></tr>
    <tr>
        <td colspan="4" align="right"><b>Bandung, {{\Carbon\Carbon::now()}}</b></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="4" align="right"><b>{{Auth::user()->name}}</b></td>
    </tr>
</table>
