@extends('layouts.app')


@section('content')
    @php
        $totaljemput=($transaksis_jemput->sum('talangan')-$transaksis_jemput->sum('ongkir'));
        $totalantar=($transaksis_antar->where('status_id',2)->sum('talangan')-$transaksis_antar->where('status_id',2)->sum('ongkir'));
        $totalcancel=($transaksis_jemput_cancel->sum('talangan')-$transaksis_jemput_cancel->sum('ongkir'));
        $grandtotal=$totalantar-$totaljemput;
    @endphp

    <div class="container-fluid">
            <form id="gantiuser" action="{{ route('transaksi.index') }}" method="GET" class="responsive">
                @csrf
                <div class="row justify-content-between mb-0">
                    <div class="col-xs-12 col-sm-12 col-md-3 m-0">
                        <div class="form-group m-0">
                            <label for="cmbkurir" class="col-form-label">Kurir</label>
                                <select name="user_id" id="cmbkurir" class="form-control form-control-sm select2" {{ Auth::user()->hasRole('Admin')?'':'disabled' }}>
                                    <option value="" disabled>--Pilih Kurir--</option>
                                    @foreach($kurirs as $key=>$kurir)
                                    <option value="{{ $kurir->id }}" {{ $kurir->id==$id_pengguna?'selected':'' }}>
                                        {{ $kurir->name??'-' }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 m-0">
                        <div class="form-group m-0">
                            <label for="reservationdate" class="col-form-label">Periode</label>
                            <input type="datetime-local" name="tanggalan" class="form-control form-control-sm" value="{{$tanggal}}"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 m-0">
                        <div class="form-group m-0">
                            <label for="cmbkurir" class="col-form-label">Status</label>
                                <select name="status_id" id="cmbstatus" class="form-control form-control-sm select2">
                                    <option value="">--Semua--</option>
                                    @foreach($statuses as $key=>$status)
                                    <option value="{{ $status->id }}" {{ $status->id==$id_status?'selected':'' }}>
                                        {{ $status->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 m-0">
                        <div class="form-group m-0">
                            <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control form-control-sm" value="{{$jam_selesai}}"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 m-0">
                        <div class="form-group m-0">
                            <label for="hp_seller" class="col-form-label">Seller</label>
                            <div class="form-group row">
                                <input type="text" name="hp_seller" id="hp_seller" placeholder="nomor seller.." value="{{ $hp }}" class="form-control form-control-sm col-8 ml-2" autocomplete="off" role="combobox" list="seller_list" aria-autocomplete="list">
                                <button type="submit" id="btnsubmit" class="btn btn-sm btn-info col-2 ml-2">Cari</button>
                                <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-info col-1" data-toggle="tooltip" title="Reset Filter">R</a>
                            </div>
                        </div>
                    </div>
                    <datalist id="seller_list" role="listbox">
                        @foreach ($sellers as $seller)
                            <option value="{{ $seller->hp }}">{{ $seller->nama? $seller->nama.' - ':'' }} {{ $seller->deskripsi??'' }}</option>
                        @endforeach
                    </datalist>

                </div>
            </form>
            <hr class="m-0 mb-4">

        <div class="row">
            {{-- tabel jemput --}}
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <h4 class="float-left mt-1">Tabel Penjemputan</h4>
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary float-right">Baru</a>
                    </div>
                </div>
                <table class="table table-bordered small">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Alamat</th>
                            <th>Seller</th>
                            <th>Talangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                         $i=1;   
                        @endphp
                        @foreach ($transaksis_jemput as $key => $trx)
                        <tr>
                            <td>{{ $i++; }}</td>
                            <td>
                                <a href="#" data-toggle="modal"
                                    data-target="#show_{{ str_replace("/","",$trx->id) }}">{{ $trx->id }}</a>
                                <div class="modal fade" id="show_{{ str_replace("/","",$trx->id) }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Transaksi Details</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <dl>
                                                            <dt>No.</dt>
                                                            <dd>{{ $trx->id }}</dd>
                                                            <dt>Seller</dt>
                                                            <dd>{{ $trx->seller->nama??$trx->hp_seller }}</dd>
                                                            <dt>Talangan</dt>
                                                            <dd>{{ $trx->talangan }}</dd>

                                                        </dl>
                                                    </div>
                                                    <div class="col-4">
                                                        <dl>
                                                            <dt>Tanggal Buat</dt>
                                                            <dd>{{ $trx->created_at }}</dd>
                                                            <dt>Alamat</dt>
                                                            <dd>{{ $trx->deskripsi }}</dd>
                                                            <dt>Ongkos Kirim</dt>
                                                            <dd>{{ $trx->ongkir }}</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-4">
                                                        <dt>Kurir Jemput</dt>
                                                        <dd>{{ $trx->kurir->name??'-' }}</dd>
                                                        <dt>Kurir Antar</dt>
                                                        <dd>{{ $trx->antar->kurir->name??'-' }}</dd>
                                                        <dt>Status</dt>
                                                        <dd>{{ $trx->antar->status->name??'Proses' }}</dd>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-md btn-default"
                                                    data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                <div class="form-group float-right mb-0">
                                @can('transaksi-edit')
                                <a href="{{ route('transaksi.edit',$trx->id) }}" class="text-info"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('transaksi-delete')
                                <a href="#" class="text-danger" data-toggle="modal"
                                    data-target="#konfirmasi_del1_{{ str_replace("/","",$trx->id) }}"><i
                                        class="fa fa-trash"></i></a>
                                <!-- Konfirmasi Hapus -->
                                <div class="modal fade" id="konfirmasi_del1_{{ str_replace("/","",$trx->id) }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="{{ route('transaksi.destroy',$trx->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <p>Apakah yakin menghapus transaksi ini <b>{{ $trx->id }}</b>?
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
                                @endcan
                            </div>
                            </td>
                            <td>{{ $trx->deskripsi }}</td>
                            <td>{{ $trx->seller->nama??$trx->hp_seller }}</td>
                            <td>{{ $trx->talangan }} ({{ $trx->ongkir }})</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th>{{ $transaksis_jemput->sum('talangan') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4">Ongkir</th>
                            <th>{{ $transaksis_jemput->sum('ongkir') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4">Grand Total</th>
                            <th>{{ $totaljemput }}</th>
                        </tr>
                    </tfoot>
                </table>
                {{-- {!! $transaksis_jemput->links() !!} --}}
            </div>

            <div class="col-lg-6">
                {{-- Tabel Antar --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <h4 class="float-left mt-1">Tabel Pengantaran</h4>
                                <a href="#" data-toggle="modal" data-target="#newantar"
                                    class="btn btn-secondary float-right">Baru</a>
                                <div class="modal fade" id="newantar">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Pengantaran Baru</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('transaksi.konfirmasi_antar') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="tbljemput_id">Kode Jemput:</label>
                                                                <select name="tbljemput_id" id="tbljemput_id"
                                                                    class="form-control select2" style="width: 100%;">
                                                                    <option value="" selected disabled>--Pilih--</option>
                                                                    @foreach ($transaksis_belum_antar as $key => $trx)
                                                                    <option value="{{ $trx->id }}">{{ $trx->id }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>                                                                
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-0 p-0">
                                                                        <label for="seller_penjemputan" class="col-md-2 col-sm-4 py-0 my-0">Seller</label> 
                                                                        <div class="col-md-10 col-sm-8"><cite id="seller_penjemputan">-</cite></div>
                                                                </div>
                                                                <div class="form-group row m-0 p-0">
                                                                        <label for="deskripsi_penjemputan" class="col-md-2 col-sm-4 py-0 my-0">Deskripsi</label>  
                                                                        <div class="col-md-10 col-sm-8"><cite id="deskripsi_penjemputan">-</cite></div>
                                                                </div>
                                                                <div class="form-group row m-0 p-0">
                                                                        <label for="talangan_penjemputan" class="col-md-2 col-sm-4 py-0 my-0">Talangan</label> 
                                                                        <div class="col-md-10 col-sm-8"><cite id="talangan_penjemputan">-</cite></div>
                                                                </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Tutup</button>
                                                    <button type="submit"
                                                        class="btn btn-success float-right">Konfirmasi</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered small">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Alamat</th>
                                    <th>Seller</th>
                                    <th>Status</th>
                                    <th>Talangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;   
                               @endphp
                                @foreach ($transaksis_antar as $key => $trx)
                                <tr>
                                    <td>{{ $i++; }}</td>
                                    <td>
                                        <a href="#" data-toggle="modal"
                                            data-target="#show2_{{ str_replace("/","",$trx->id) }}">{{ $trx->id }}</a>
                                        <div class="modal fade" id="show2_{{ str_replace("/","",$trx->id) }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Transaksi Details</h4>
                                                        <a href="https://wa.me/{{ $trx->jemput->hp_seller }}"
                                                            class="btn btn-md btn-success m-0"><i class="fa fa-phone"></i>
                                                            Hubungi</a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <dl>
                                                                    <dt>No.</dt>
                                                                    <dd>{{ $trx->id }}</dd>
                                                                    <dt>Hp Seller</dt>
                                                                    <dd>{{ $trx->jemput->seller->nama??$trx->jemput->hp_seller }}</dd>
                                                                    <dt>Kurir Antar</dt>
                                                                    <dd>{{ $trx->kurir->name??'-' }}</dd>
                                                                    <dt>Catatan</dt>
                                                                    <dd>{{ $trx->antar->catatan??'-' }}</dd>
                                                                </dl>
                                                            </div>
                                                            <div class="col-4">
                                                                <dl>
                                                                    <dt>Tanggal Jemput</dt>
                                                                    <dd>{{ $trx->jemput->created_at }}</dd>
                                                                    <dt>Alamat</dt>
                                                                    <dd>{{ $trx->jemput->deskripsi }}</dd>
                                                                    <dt>Talangan</dt>
                                                                    <dd>{{ $trx->jemput->talangan }} ({{ $trx->ongkir }})</dd>
                                                                </dl>
                                                            </div>
                                                            <div class="col-4">
                                                                <dt>Input Pengantaran</dt>
                                                                <dd>{{ $trx->created_at }}</dd>
                                                                <dt>Proses Terakhir</dt>
                                                                <dd>{{ $trx->updated_at }}</dd>
                                                                <dt>Kurir Jemput</dt>
                                                                <dd>{{ $trx->jemput->kurir->name??'-' }}</dd>
                                                                <dt>Status</dt>
                                                                <dd>{{ $trx->status->name }}</dd>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                            @can('transaksi-create')
                                                            @if($trx->status->name==='Proses')
                                                            <button class="btn btn-md btn-warning m-0" onclick="return isi_catatan('{{ $trx->id }}');">Cancel</button>
                                                            <button class="btn btn-md btn-default m-0" data-dismiss="modal">Keluar</button>
                                                            
                                                            <form action="{{ route('transaksi.gantistatus',$trx->id) }}"
                                                                method="POST" class="m-0">
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="id" value="{{ $trx->id }}">
                                                                <input type="hidden" name="status_id" value="2">
                                                                <button type="submit"
                                                                    class="btn btn-md btn-success m-0">Selesai</button>
                                                            </form>
                                                            @endif
                                                            @endcan
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                        <div class="form-group float-right mb-0">
                                        @can('transaksi-edit')
                                        <a href="{{ route('transaksi.edit',$trx->id) }}" class="text-info"><i class="fa fa-edit"></i></a>
                                        @endcan
                                        @can('transaksi-delete')
                                        <a href="#" class="text-danger" data-toggle="modal"
                                            data-target="#konfirmasi_del2_{{ str_replace("/","",$trx->id) }}"><i
                                                class="fa fa-trash"></i></a>
                                        <!-- Konfirmasi Hapus -->
                                        <div class="modal fade" id="konfirmasi_del2_{{ str_replace("/","",$trx->id) }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form action="{{ route('transaksi.destroy',$trx->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Apakah yakin menghapus transaksi ini <b>{{ $trx->id }}</b>?
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
                                        @endcan
                                    </div>
                                    </td>
                                    <td>{{ $trx->jemput->deskripsi }}</td>
                                    <td>{{ $trx->jemput->seller->nama??$trx->jemput->hp_seller }}</td>
                                    <td>
                                        @if ($trx->status->id==1)
                                            <span class="badge badge-primary">{{ $trx->status->name }}</span>
                                        @else
                                            <span class="badge badge-success">{{ $trx->status->name }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $trx->talangan }} ({{ $trx->ongkir }})</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th>{{ $transaksis_antar->where('status_id',2)->sum('talangan') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="5">Ongkir</th>
                                    <th>{{ $transaksis_antar->where('status_id',2)->sum('ongkir') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="5">Grand Total</th>
                                    <th>{{ $totalantar }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                {{-- Tabel Cancel --}}
                @if($transaksis_jemput_cancel->count()>0)
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <h4 class="float-left mt-1">Informasi Cancel</h4>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Alamat</th>
                                    <th>Talangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;   
                            @endphp
                                @foreach ($transaksis_jemput_cancel as $key => $trx)
                                <tr>
                                    <td>{{ $i++; }}</td>
                                    <td>
                                        <a href="#" data-toggle="modal"
                                            data-target="#show3_{{ str_replace("/","",$trx->id) }}">{{ $trx->id }}</a>
                                        <div class="modal fade" id="show3_{{ str_replace("/","",$trx->id) }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Transaksi Details</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <dl>
                                                                    <dt>No.</dt>
                                                                    <dd>{{ $trx->id }}</dd>
                                                                    <dt>Seller</dt>
                                                                    <dd>{{ $trx->seller->nama??$trx->hp_seller }}</dd>
                                                                    <dt>Kurir Antar</dt>
                                                                    <dd>{{ $trx->antar->kurir->name??'-' }}</dd>
                                                                    <dt>Catatan</dt>
                                                                    <dd>{{ $trx->antar->catatan??'-' }}</dd>
                                                                </dl>
                                                            </div>
                                                            <div class="col-4">
                                                                <dl>
                                                                    <dt>Tanggal Jemput</dt>
                                                                    <dd>{{ $trx->created_at }}</dd>
                                                                    <dt>Alamat</dt>
                                                                    <dd>{{ $trx->deskripsi }}</dd>
                                                                    <dt>Talangan</dt>
                                                                    <dd>{{ $trx->talangan }} ({{ $trx->ongkir }})</dd>
                                                                </dl>
                                                            </div>
                                                            <div class="col-4">
                                                                <dt>Tanggal Proses</dt>
                                                                <dd>{{ $trx->antar->updated_at }}</dd>
                                                                <dt>Kurir Jemput</dt>
                                                                <dd>{{ $trx->kurir->name??'-' }}</dd>
                                                                <dt>Status</dt>
                                                                <dd>{{ $trx->antar->status->name??'Dijemput' }}</dd>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-md btn-default"
                                                            data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                        @can('transaksi-delete')
                                        <a href="#" class="text-danger" data-toggle="modal"
                                            data-target="#konfirmasi_del_{{ str_replace("/","",$trx->id) }}"><i
                                                class="fa fa-trash"></i></a>
                                        <!-- Konfirmasi Hapus -->
                                        <div class="modal fade" id="konfirmasi_del_{{ str_replace("/","",$trx->id) }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <form action="{{ route('transaksi.destroy',$trx->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p>Apakah yakin menghapus transaksi ini <b>{{ $trx->id }}</b>?
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
                                        @endcan

                                    </td>
                                    <td>{{ $trx->deskripsi }}</td>
                                    <td>{{ $trx->talangan }} ({{ $trx->ongkir }})

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>{{ $transaksis_jemput_cancel->sum('talangan') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3">Ongkir</th>
                                    <th>{{ $transaksis_jemput_cancel->sum('ongkir') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3">Grand Total</th>
                                    <th>{{ $totalcancel }}</th>
                                </tr>
                            </tfoot>

                        </table>
                        {{-- {!! $transaksis_jemput_cancel->links() !!} --}}
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            {{-- Informasi Total Transaksi --}}
                <div class="col-lg-12">
                    <div class="callout callout-info">
                        <h6>Grand Total : Total Pengantaran - Total Penjemputan</h6>
                        <h2>{{  $grandtotal  }}</h2>
                      </div>
                </div>
        </div>


        {{-- modal jika ada catatan transaksi pengantaran (karena cancel) --}}
        <div class="modal fade" id="isicatatancancel">
            <div class="modal-dialog">
                <div class="modal-content m-2">
                    <form action="{{ route('transaksi.gantistatus') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="status_id" value="3">
                            <div class="form-group">
                                <label for="no_trx">ID Transaksi</label>
                                <input type="text" class="form-control" name="id" id="id_trx" readonly>
                            </div>
                            <div class="form-group">
                                <label for="catatan_cancel">Catatan</label>
                                <textarea name="catatan" id="catatan_cancel"
                                    class="form-control" rows="2"
                                    placeholder="catatan.." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between p-1">
                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-md btn-info float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();

        $('#tbljemput_id').on('change', function(){ 
            $.ajax({
                            // method:"POST",
                            url: "{{ route ('transaksi.GetJemput') }}",
                            data : {
                                    id : this.value
                                },
                            // dataType: 'json',
                            success: function(data) {
                                console.log(data);
                                 var dat= data.data;
                                if(data.success){ 
                                    var talangan=dat.talangan + "(" + dat.ongkir + ")";
                                    $('#seller_penjemputan').text(dat.hp_seller);
                                    $('#deskripsi_penjemputan').text(dat.deskripsi);
                                    $('#talangan_penjemputan').text(talangan);
                                }
                                
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                var responseText = jQuery.parseJSON(jqXHR.responseText);
                                console.error(responseText);
                                return false;
                            }
                        });
        })

    });
    function isi_catatan(id)
        {
            $('#id_trx').val(id);
            $('#catatan_cancel').val('');
            $('#isicatatancancel').modal('toggle');
        }
</script>
@endpush