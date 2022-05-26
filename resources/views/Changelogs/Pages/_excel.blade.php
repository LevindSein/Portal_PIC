<table>
    <tr>
        <td colspan="5" align="center" style="border: 1px solid #000000;"><b>Data Changelogs No:{{$data->code}}</b></td>
    </tr>
    <tr>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>No.</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Title</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Data</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Times</b></td>
        <td align="center" style="border: 1px solid #000000; border-bottom: 1px double #000000;"><b>Created By</b></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;">1</td>
        <td style="border: 1px solid #000000;">{{$data->title}}</td>
        <td style="border: 1px solid #000000;">{{$data->data}}</td>
        <td style="border: 1px solid #000000;">{{$data->times}}</td>
        <td style="border: 1px solid #000000;">{{$data->user->name}}</td>
    </tr>
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
