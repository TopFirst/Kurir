@extends('layouts/admin')

@section('container')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Konfigurasi Aplikasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Konfigurasi Aplikasi</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        @foreach ($app_configs as $item)
            <div class="row">
                <div class="col-md-6">
                    <div class="card m-0 p-0">
                        <div class="card-body m-0 p-2">
                            <form method="POST" action="{{ route('transaksi.ubahconfig',$item->id) }}">
                                @csrf
                                @method('POST')
                                {{-- <input type="hidden" name="id" value="{{ $item->id }}"> --}}
                                <div class="form-group row m-0 p-0">
                                    <label for="parameter_value" class="col-lg-3 mt-1">{{ $item->parameter_name }}</label>
                                    @if($item->slug=='cut-off-time')
                                        <div class="input-group col-lg-6">
                                            <input type="number" min="0" step="1" class="form-control col-9"  name="parameter_value" value="{{ $item->parameter_value }}" required>
                                            <span class="input-group-append col-3 m-0 p-0">
                                                <input type="text" class="form-control" name="parameter_unit" value="{{ $item->parameter_unit }}" readonly/>
                                            </span>
                                        </div>
                                    @elseif($item->slug=='tipe-pendapatan')
                                        <div class="input-group col-lg-6">
                                            <select name="parameter_value" class="form-control" id="parameter_value">
                                                <option value="1" {{$item->parameter_value == 1 ? 'selected' : ''}}>Untuk Owner</option>
                                                <option value="2" {{$item->parameter_value == 2  ? 'selected' : ''}}>Untuk Kurir</option>
                                            </select>
                                            <span class="input-group-append col-3 m-0 p-0">
                                                <input type="text" class="form-control"  name="parameter_unit" value="{{ $item->parameter_unit }}" readonly>
                                            </span>
                                        </div>
                                    @else
                                        <div class="input-group col-lg-6">
                                            <input type="text" class="form-control col-9"  name="parameter_value" value="{{ $item->parameter_value }}" required>
                                            <span class="input-group-append col-3 m-0 p-0">
                                            <select name="parameter_unit" class="form-control" id="parameter_unit">
                                                <option value="Rb" {{$item->parameter_unit == "Rb" ? 'selected' : ''}}>Ribu</option>
                                                <option value="%" {{$item->parameter_unit == "%"  ? 'selected' : ''}}>%</option>
                                            </select>
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-info float-right">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
    $(function () {

    });
</script>
@endpush