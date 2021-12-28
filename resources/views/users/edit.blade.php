@extends('layouts/admin')

@section('container')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pengguna</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('users') }}">Pengguna</a></li>
                    <li class="breadcrumb-item active">Edit Pengguna</li>
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

                {!! Form::model($user, ['method' => 'PATCH','enctype'=>'multipart/form-data','route' => ['users.update', $user->id]]) !!}

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Pengguna</h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        {!! Form::text('name', null, array('placeholder' => 'Name','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Alamat:</strong>
                                        {!! Form::textarea('alamat', null, array('placeholder' => 'Alamat','class' =>
                                        'form-control', 'rows'=>2)) !!}
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
                                        <strong>Email:</strong>
                                        {!! Form::text('email', null, array('placeholder' => 'Email','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Password:</strong>
                                        {!! Form::password('password', array('placeholder' => 'Password','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Confirm Password:</strong>
                                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Role:</strong>
                                        {!! Form::select('roles[]', $roles,$userRole, array('class' =>
                                        'form-control','multiple')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <img id="profilePicture" style="width:350px;height:350px; object-fit:cover" src="{{ asset($user->foto) }}">
                                    <input type="file"
                                            name="foto"
                                           accept=".jpeg,.png,.jpg,.svg"
                                           asp-for="Input.ProfilePicture"
                                           class="form-control"
                                           style="border:0px!important;padding: 0px;padding-top: 10px;padding-bottom: 30px;"
                                           onchange="document.getElementById('profilePicture').src = window.URL.createObjectURL(this.files[0])" />
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-default">Back</a>
                        <a href="#" data-toggle="modal" data-target="#konfirmasihapus" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Hapus Pengguna</a>
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
                            <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <p>Apakah yakin menghapus pengguna ini <b>{{ $user->name }}</b>?
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
