@extends('layouts/admin')

@push('css')
<link href="{{ asset('plugins/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet" />
@endpush
@section('container')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Transaksi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Transaksi</a></li>
                    <li class="breadcrumb-item active">Edit Transaksi</li>
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

                {!! Form::model($transaksi, ['method' => 'PATCH','route' => ['transaksi.update', $transaksi->id]]) !!}

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Transaksi : <strong>{{$transaksi->id}}</strong></h2>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                        <input type="hidden" name="url" value="{{$url}}"  />

                            <div class="col-md-12">
                                <!-- Tanggal Jemput -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tgl_jemput">Tanggal Jemput:</label>
                                        <div class='input-group' id='tgl_jemput'>
                                            <input type='text' class="form-control datetimepicker" name="tgl_jemput" value="{!! date('Y-m-d H:i', strtotime($transaksi->created_at)) !!}" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                      </div>
                                      
                                </div>
                                <!-- Tanggal Jemput -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tgl_antar">Tanggal Antar:</label>
                                        <div class='input-group' id='tgl_antar'>
                                            <input type='text' class="form-control datetimepicker" name="tgl_antar" value="{!! $transaksi->antar?date('Y-m-d H:i', strtotime($transaksi->antar->created_at)):'' !!}" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                      </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>HP Seller:</strong>
                                        {!! Form::text('hp_seller', null, array('placeholder' => 'hp seller','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Nama Customer:</strong>
                                        {!! Form::text('nama_customer', null, array('placeholder' => 'nama customer..','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Alamat:</strong>
                                        {!! Form::textarea('deskripsi', null, array('placeholder' => 'Deskripsi paket','class' =>
                                        'form-control', 'rows'=>2)) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Talangan:</strong>
                                        {!! Form::number('talangan', null, array('placeholder' => 'total harga paket','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ongkos Kirim:</strong>
                                        {!! Form::number('ongkir', null, array('placeholder' => 'Ongkos Kirim','class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Kurir Jemput:</strong>
                                        {!! Form::select('user_id', $kurirs->pluck('name','id'),$transaksi->user_id, array('class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Kurir Antar:</strong>
                                        @php
                                        $ks=$kurirs->pluck('name','id');
                                        $ks['']='Pilih Kurir';
                                        @endphp
                                        {!! Form::select('user_id_antar', 
                                        $ks->sort(),
                                        $transaksi->antar->user_id??'', array('class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Status:</strong>
                                        @php
                                        $stts=$statuses->pluck('name','id');
                                        // $stts['']='Belum Input';
                                        @endphp
                                        {!! Form::select('id_status', 
                                        $stts->sort(),
                                        $transaksi->antar->status_id??'', array('class' =>
                                        'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Lunas:</strong>
                                        {!! Form::checkbox('lunas', 1, $transaksi->antar?$transaksi->antar->lunas>0:0, array('class' =>'form-control form-control-sm')) !!}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer justify-content-between">
                        <a href="{{ route('transaksi.admin') }}" class="btn btn-default">Back</a>                        
                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>
                <!-- /.card -->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- /.content -->

@endsection
@push('scripts')
<script src="{{ asset('plugins/datetimepicker/jquery.datetimepicker.full.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datetimepicker').datetimepicker({
            format: 'Y-m-d H:i',
            autoclose: true,
            // startDate: '0d'
        });
});

// $(function () {
//     $('.datetimepicker').datetimepicker();
// });
</script>

@endpush
