@extends('layouts/admin')

@section('container')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Transaksi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('transaksi.admin') }}">Transaksi</a></li>
                    <li class="breadcrumb-item active">Detail Transaksi</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Detail Transaksi: <strong>{{ $transaksi->id }}</strong></h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <dl>
                                    <dt>Tanggal Input Penjemputan</dt>
                                    <dd>{{ $transaksi->created_at }}</dd>
                                    <dt>Tanggal Input Pengantaran</dt>
                                    <dd>{{ $transaksi->antar->created_at??"-" }}</dd>
                                    <dt>Deskripsi</dt>
                                    <dd>({{ $transaksi->hp_seller }}) {{ $transaksi->deskripsi }}</dd>
                                    <dt>Catatan</dt>
                                    <dd>{{ $trx->antar->catatan??'-' }}</dd>
                                </dl>
                            </div>
                            <div class="col-4">
                                <dl>
                                    <dt>Tanggal Update Penjemputan</dt>
                                    <dd>{{ $transaksi->updated_at }}</dd>
                                    <dt>Tanggal Update Pengantaran</dt>
                                    <dd>{{ $transaksi->antar->updated_at??"-" }}</dd>
                                    <dt>Talangan</dt>
                                    <dd>{{ $transaksi->talangan }} ({{ $transaksi->ongkir }})</dd>
                                </dl>
                            </div>
                            <div class="col-4">
                                <dt>Kurir Jemput</dt>
                                <dd>{{ $transaksi->kurir->name }}</dd>
                                <dt>Kurir Antar</dt>
                                <dd>{{ $transaksi->antar->kurir->name??'-' }}</dd>
                                <dt>Status</dt>
                                <dd><strong>{{ $transaksi->antar->status->name??'Belum Input' }}</strong><br>{{ $transaksi->antar->catatan??'' }}</dd>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="{{ $url }}" class="btn btn-default">Back</a>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
</div>
<!-- /.content -->
@endsection
