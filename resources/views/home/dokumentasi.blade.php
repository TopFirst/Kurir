@extends('layouts/admin')

@section('container')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dokumentasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dokumentasi</li>
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
            @foreach ($dokumentasis as $dok)
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <div class="card-title">{{ $dok->title }}</div>
                        </div>
                        <div class="card-body">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{ $dok->link }}" frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $dok->desc }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection


