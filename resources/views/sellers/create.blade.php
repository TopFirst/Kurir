@extends('layouts/admin')

@section('container')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$title}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('seller') }}">Sellers</a></li>
                    <li class="breadcrumb-item active">Tambah Seller</li>
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
                {!! Form::open(array('route' => 'seller.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tambah Seller</h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Nama Seller:</strong>
                                    {!! Form::text('nama', null, array('placeholder' => 'Nama seller','class' =>
                                    'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>HP:</strong>
                                    {!! Form::text('hp', null, array('placeholder' => 'No Hp','class' =>
                                    'form-control', 'required')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Deskripsi:</strong>
                                    {!! Form::textarea('deskripsi', null, array('placeholder' => 'deskripsi detail seller','class' =>
                                    'form-control', 'rows'=>3)) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="{{ url('seller') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
                <!-- /.card -->
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
<!-- /.content -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@endsection