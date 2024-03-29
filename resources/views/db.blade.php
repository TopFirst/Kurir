@extends('layouts/admin')

@section('container')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <p class="float-sm-right" id="jam">Terakhir Update : {{ date("h:i:s") }}</p>
              {{-- <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol> --}}
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                                <!-- total pengantaran -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3 id="totalantar">0</h3>
                
                                            <p>Total Pengantaran</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="{{ route('transaksi.admin') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                <!-- total paket On Progress -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="paket_onprocess">0</h3>

                            <p><b id="jml_paket_onprocess"></b> Paket On Process</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('transaksi.admin') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                {{-- <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="totalantar">0</h3>

                            <p>Total Pengantaran</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('transaksi.admin') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> --}}
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $total_kurir }}</h3>

                            <p>Kurir Terdaftar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('users.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $total_seller }}</h3>

                            <p>Pelanggan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('seller.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-md-8">
                  <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-6">
                      <!-- TABLE: LATEST ORDERS -->
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title"><strong class="text" id="totalbeluminput">0</strong> Transaksi Belum Input</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                    <table class="table table-head-fixed m-0" id="tblbeluminput">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Kurir</th>
                                                <th>Seller</th>
                                                <th>Alamat</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('transaksi.admin') }}" class="uppercase">Semua Transaksi</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <!-- TABLE: LATEST ORDERS -->
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title"><strong class="text" id="totalcancel">0</strong> Transaksi Cancel</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                    <table class="table table-head-fixed m-0" id="tblcancel">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Kurir</th>
                                                <th>Seller</th>
                                                <th>Alamat</th>
                                                <th>Talangan</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                            <a href="{{ route('transaksi.admin') }}" class="uppercase">Semua Transaksi</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                            
                      </div>
                  </div>
                  
              </div>
              <!-- list kurir -->
              <div class="col-md-4">
                <div class="row">
                    <div class="col-lg-12">
                      <!-- SELLERS LIST -->
                      <div class="card">
                          <div class="card-header">
                              <h3 class="card-title">Top 4 Seller</h3>
                              <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                  </button>
                                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                  </button>
                              </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body p-0">
                              <ul class="users-list clearfix">
                                  @foreach ($sellers as $item)
                                      <li>
                                          <img src="{{ asset('dist/img/pos.png') }}" alt="Foto Seller">
                                          <a class="users-list-name" href="#">{{ $item->nama??$item->hp }}</a>
                                          <span class="badge badge-info">{{ $item->jumlah}}</span>
                                      </li>
                                  @endforeach
                              </ul>
                              <!-- /.users-list -->
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer text-center">
                              <a href="{{ route('seller.index') }}">Semua Seller</a>
                          </div>
                          <!-- /.card-footer -->
                      </div>
                      <!--/.card -->
                    </div>
                </div>
                  <div class="row">
                      <div class="col-lg-12">
                        <!-- KURIR LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Kurir</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="products-list product-list-in-card pl-2 pr-2">
                                @foreach($kurirs as $key=>$kurir)
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="{{ asset($kurir->foto)  }}" alt="Kurir" class="img-size-50">
                                        </div>
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">{{ $kurir->name??'-' }} ({{ $kurir->id }})
                                                <span class="badge badge-warning float-right">{{ $kurir->jemputan->count() }}</span></a>
                                            <span class="product-description">
                                                ({{ $kurir->hp }}) {{ $kurir->alamat }}
                                            </span>
                                        </div>
                                    </li>
                                    <!-- /.item -->
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="{{ route('users.index') }}" class="uppercase">Semua Kurir</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                      </div>
                  </div>
              </div>
              </div>
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

@endsection

@push('scripts')
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

<script type="text/javascript">
var otable;
var cancel_table;

    $(function () {
        let otable=$('#tblbeluminput').DataTable({
            processing: false,
            responsive: false,
            serverSide: true,
            paging:false,
            scrollY: '500px',
            scrollCollapse: true,
            dom:"<t>",
            ajax: "{{ route('home.json') }}",
            columns: [
                { data: 'id', name: 'id', orderable:false },
                { data: 'kurirjemput', name: 'kurirjemput', orderable:false },
                { data: 'seller', name: 'seller', orderable:false },
                { data: 'detail', name: 'detail', orderable:false },
                { data: 'status', name: 'status', orderable:false },
            ]
            
        });
        let cancel_table=$('#tblcancel').DataTable({
            processing: false,
            responsive: false,
            serverSide: true,
            paging:false,
            scrollY: '500px',
            scrollCollapse: true,
            dom:"<t>",
            ajax: "{{ route('home.json_cancel') }}",
            columns: [
                { data: 'id', name: 'id', orderable:false },
                { data: 'kurirjemput', name: 'kurirjemput', orderable:false },
                { data: 'seller', name: 'seller', orderable:false },
                { data: 'detail', name: 'detail', orderable:false },
                { data: 'talangan', name: 'talangan', orderable:false },
            ]
        });

        otable.on('draw', function () {
            var dat=otable.ajax.json();
            // $("#totaljemput").text(dat['totaljemput']);
            //var onP=dat['jml_paket_onprocess'] . "-" . dat['paket_onprocess'];
            let jml_paket_onprocess=dat['jml_paket_onprocess'];
            let paket_onprocess=dat['paket_onprocess'];
            $("#paket_onprocess").text(paket_onprocess);
            $("#jml_paket_onprocess").text(jml_paket_onprocess);
            $("#totalantar").text(dat['totalantar']);
            $("#totalbeluminput").text(dat['recordsTotal']);
        });
        cancel_table.on('draw', function () {
            var dat_cancel=cancel_table.ajax.json();
            console.log(dat_cancel['recordsTotal']);
            $("#totalcancel").text(dat_cancel['recordsTotal']);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', ".hapus", function () {
          var $tr = $(this).closest("tr");
          var $a = $(this).closest("a");
          var id = $a.data("id");
          if(confirm('Apakah yakin ingin menghapus ini:' + id + '?'))
            {
                $tr.hide(500, function () {
                        $.ajax({
                            method:"POST",
                            url: "{{ route ('transaksi.hapus') }}",
                            data : {
                                    id : id
                                },
                            // dataType: 'json',
                            success: function(data) {
                                if(!data.success){
                                    alert('data gagal dihapus');
                                }
                                else
                                {
                                    cancel_table.draw();
                                }
                                
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                // alert('Error: ' + textStatus + ' - ' + errorThrown);
                                var responseText = jQuery.parseJSON(jqXHR.responseText);
                                console.error(responseText);
                                return false;
                            }
                        });

                });
            }
          
      });

        setInterval(function(){
            var dt = new Date();
            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
            $("#jam").text('Terakhir Update : ' + time)
            // console.log(time);
            otable.draw();
            cancel_table.draw();
        }, 30000); //300000 MS == 5 minutes

    });
</script>
@endpush