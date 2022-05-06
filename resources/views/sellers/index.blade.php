@extends('layouts/admin')

@section('container')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Seller</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Seller</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Seller</h3>
                        <div class="card-tools">
                            <a href="{{ route('seller.exportseller') }}" class="btn btn-sm btn-info"><i class="far fa-file-excel"></i> Export ke Excel</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive p-0" style="height:500px;">

                        <table id="tbldata" class="table table-head-fixed p-0">
                            <thead>
                                <tr>
                                    <th style="width:70px">ID</th>
                                    <th>Nama Seller</th>
                                    <th style="width:150px">HP Seller</th>
                                    <th>Deskripsi</th>
                                    <th style="width:80px">Jml Paket</th>
                                    <th style="width:30px">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sellers as $seller)
                                <tr>
                                    <td>{{ $seller->id }}</td>
                                    <td>{{ $seller->nama??'-' }}</td>
                                    <td>{{ $seller->hp }}</td>
                                    <td>{{ $seller->deskripsi??'-' }}</td>
                                    <td>{{ $seller->jumlah }}</td>
                                    <td class="justify-content-between">
                                        @can('transaksi-edit')
                                        <a href="{{ route('seller.edit',$seller->id) }}" class="text-info"><i class="fas fa-edit"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@push('scripts')
<script type="text/javascript">

    $(function () {
        $('#tbldata').DataTable({
            processing: true,
            responsive: false,
            serverSide: false,
            "paging":   false,
            "order": [[ 4, "desc" ]]

            // "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>",
        });
    });
</script>
@endpush