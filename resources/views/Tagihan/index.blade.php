@extends('Layout.index')

@section('content-title')
Tagihan
@endsection

@section('content-button')
@include('Tagihan.Partial._button')
@endsection

@section('content-body')
<table class="table table-striped table-hover" width="100%" id="dtable">
    <thead>
        <tr>
            <th class="min-tablet">Username</th>
            <th class="all">Nama</th>
            <th class="min-tablet">Level</th>
            <th class="all">Action</th>
        </tr>
    </thead>
</table>
@endsection

@section('content-modal')
@include('Tagihan.Modal._tambah')
@include('Tagihan.Modal._edit')
@include('Tagihan.Modal._hapus')
@include('Tagihan.Modal._rincian')
@endsection

@section('content-js')
<script>

</script>
@endsection
