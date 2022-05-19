<table>
    <thead>
        <tr>
            <th colspan="4">
                <h2>Data Pengguna</h2>
            </th>
            <th colspan="4">
                <h2>{{$level}}</h2>
            </th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Level</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($dataset as $d)
        <tr>
            <td>{{$i}}</td>
            <td>{{$d->username}}</td>
            <td>{{$d->name}}</td>
            <td>{{\App\Models\User::level($d->level)}}</td>
        </tr>
        @php
            $i++;
        @endphp
        @endforeach
    </tbody>
</table>
