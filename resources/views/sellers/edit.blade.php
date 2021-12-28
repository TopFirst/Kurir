@extends('layouts/admin')

@section('container')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Seller</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seller.index') }}">Seller</a></li>
                    <li class="breadcrumb-item active">Edit Seller</li>
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

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {!! Form::model($seller, ['method' => 'PATCH','route' => ['seller.update', $seller->id]]) !!}

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Seller</h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Nama Seller:</strong>
                                        {!! Form::text('nama', null, array('placeholder' => 'nama seller','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>HP:</strong>
                                        {!! Form::text('hp', null, array('placeholder' => 'HP','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Deskripsi:</strong>
                                        {!! Form::textarea('deskripsi', null, array('placeholder' => 'Deksripsi Seller','class' =>
                                        'form-control', 'rows'=>2)) !!}
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer justify-content-between">
                        <a href="{{ route('seller.index') }}" class="btn btn-default">Back</a>
                        <a href="#" data-toggle="modal" data-target="#konfirmasihapus" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Hapus Seller</a>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
                <!-- /.card -->
                {!! Form::close() !!}
            </div>
            <!-- Konfirmasi Hapus -->
            <div class="modal fade" id="konfirmasihapus">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{ route('seller.destroy',$seller->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <p>Apakah yakin menghapus seller ini <b>{{ $seller->name }}</b>?
                                </p>
                                <div class="justify-content-between">
                                    <button type="button" class="btn btn-md btn-default"
                                        data-dismiss="modal">Cancel</button>
                                    <div class="float-right">
                                        <button type="submit"
                                            class="btn btn-md btn-outline-danger"><i
                                                class="fa fa-trash"></i> Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>

    </div>
</div>
<!-- /.content -->

{{-- <!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

@endsection
