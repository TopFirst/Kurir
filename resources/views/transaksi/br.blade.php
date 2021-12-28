@extends('layouts/admin')

@section('container')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Backup & Restore</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Backup & Restore</li>
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
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
                @if ($message = Session::get('failed'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Backup & Restore</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="filter_periode" class="col-form-label">Periode</label>
                                    <div class="input-group col-lg-5">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control float-right" name="filter_periode" id="filter_periode">
                                    </div>
                                    <button type="button" class="btn btn-default"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <a href="#" data-toggle="modal" data-target="#Bmodal" class="btn btn-info float-right">Back Up</a>
                                <a href="#" data-toggle="modal" data-target="#Rmodal" class="btn btn-default float-right mx-2">Restore</a>

                                <!-- backup modal -->
                                <div class="modal fade" id="Bmodal">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('transaksi.backup') }}">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Backup Transaksi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="form-group row">
                                                            <label for="periode_backup" class="col-form-label col-lg-4">Periode Backup</label>
                                                            <div class="input-group col-lg-8">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control float-right" name="periode_backup" id="periode_backup">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-md btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                <!-- Restore modal -->
                                <div class="modal fade" id="Rmodal">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('transaksi.restore') }}">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Restore Transaksi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="form-group row">
                                                            <label for="periode_restore" class="col-form-label col-lg-4">Periode Restore</label>
                                                            <div class="input-group col-lg-8">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="far fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control float-right" name="periode_restore" id="periode_restore">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-md btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            </div>
                        </div>
                            <table id="tbldata5" class="table table-head-fixed p-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="width:125px">ID</th>
                                        <th>Seller</th>
                                        <th>Alamat</th>
                                        <th>Tgl Jemput</th>
                                        <th>Kurir Jemput</th>
                                        <th>Tgl Antar</th>
                                        <th>Kurir Antar</th>
                                        <th>Talangan</th>
                                        <th>Ongkir</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksis as $trx)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $trx->id }}</td>
                                            <td>{{ $trx->seller->nama??$trx->hp_seller }}</td>
                                            <td>{{ $trx->deskripsi }}</td>
                                            <td>{{ $trx->created_at }}</td>
                                            <td>{{ $trx->kurir->name }}</td>
                                            <td>{{ $trx->antar->created_at??'' }}</td>
                                            <td>{{ $trx->antar->kurir->name??'' }}</td>
                                            <td>{{ $trx->talangan }}</td>
                                            <td>{{ $trx->ongkir }}</td>
                                            <td>{{ $trx->antar->status->name??'Belum Input' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer justify-content-between my-0 pb-0">
                        <div class="mt-2 float-left">Jumlah produk : {!! $transaksis->total() !!}</div>
                        <div class="float-right">
                            {!! $transaksis->links() !!}
                        </div>
                    </div>
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
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    var otable;
    $(function () {
        //deklarasi datetimepicker jemput
        $('#filter_periode').daterangepicker(
        {
            ranges : {
                'Hari Ini' : [moment().subtract(1, 'days'), moment()],
                'Kemarin' : [moment().subtract(2, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir' : [moment().subtract(7, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(30, 'days'), moment()],
                'Bulan Ini' : [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu' : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            // startDate: moment().subtract(29, 'days'),
            startDate: moment().startOf('year'),
            endDate : moment().endOf('year')
        });
        //deklarasi datepicker bakcup
        $('#periode_backup').daterangepicker(
        {
            ranges : {
                'Hari Ini' : [moment().subtract(1, 'days'), moment()],
                'Kemarin' : [moment().subtract(2, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir' : [moment().subtract(7, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(30, 'days'), moment()],
                'Bulan Ini' : [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu' : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().startOf('year'),
            endDate : moment()
        });
        //deklarasi datetimepicker jemput
        $('#periode_restore').daterangepicker(
        {
            ranges : {
                'Hari Ini' : [moment().subtract(1, 'days'), moment()],
                'Kemarin' : [moment().subtract(2, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir' : [moment().subtract(7, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(30, 'days'), moment()],
                'Bulan Ini' : [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu' : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().startOf('year'),
            endDate : moment()
        });

    });
</script>
@endpush