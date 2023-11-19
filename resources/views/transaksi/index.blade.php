@extends('layouts/admin')

@push('css')
<style>
    /* Start by setting display:none to make this hidden.
    Then we position it in relation to the viewport window
    with position:fixed. Width, height, top and left speak
    for themselves. Background we set to 80% white with
    our animation centered, and no-repeating */
    /* .modal {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('http://i.stack.imgur.com/FhHRx.gif') 
                    50% 50% 
                    no-repeat;
    } */

    /* When the body has the loading class, we turn
    the scrollbar off with overflow:hidden */
    /* body.loading .modal {
        overflow: hidden;   
    } */

    /* Anytime the body has the loading class, our
    modal element will be visible */
    /* body.loading .modal {
        display: block;
    } */
</style>
    
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
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-boxes"></i></span>
    
                  <div class="info-box-content">
                    <span class="info-box-text">Jumlah Data</span>
                    <span class="info-box-number" id="jumlahdata">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dolly-flatbed"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Penjemputan</span>
                  <span class="info-box-number" id="totpenjemputan">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-truck-moving"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Pengantaran</span>
                  <span class="info-box-number" id="antaran">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>
  
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Grand Total</span>
                  <span class="info-box-number" id="grand_total">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-middle">Daftar Transaksi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('transaksi.cetakpdf') }}" method="POST" target="_blank" class="form-horizontal">
                            <div class="row justify-content-between mb-0">
                                @csrf
                                @method('POST')
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="filter_periode" class="col-form-label col-form-label-sm">Periode Jemput</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm float-right" name="filter_periode" id="filter_periode">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="filter_periode_antar" class="col-form-label col-form-label-sm">Periode Antar</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm float-right" name="filter_periode_antar" id="filter_periode_antar">
                                    </div>
                                  </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="filter_kurir_tipe" class="col-form-label col-form-label-sm text-right mr-2">Kurir</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="filter_kurir_tipe" id="filter_kurir_tipe"
                                                    class="form-control form-control-sm m-0">
                                                    <option value="1" selected>Jemput/Antar</option>
                                                    <option value="2"> Jemput </option>
                                                    <option value="3"> Antar </option>
                                                </select>
                                            </div>
                                            <select name="filter_kurir" id="filter_kurir"
                                                class="form-control form-control-sm m-0">
                                                <option value=""> Pilih Kurir </option>
                                                @foreach ($kurirs as $key=>$kurir)
                                                <option value="{{ $kurir->id }}"> {{ $kurir->name??'-' }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="filter_seller" class="col-form-label col-form-label-sm">HP Seller</label>
                                    <input type="text" name="filter_seller" placeholder="nomor hp seller.." id="filter_seller" class="form-control form-control-sm" autocomplete="off" role="combobox" list="seller_list" aria-autocomplete="list" >
                                </div>
                            </div>
                            <datalist id="seller_list" role="listbox">
                                @foreach ($sellers as $seller)
                                    <option value="{{ $seller->hp }}">{{ $seller->nama? $seller->nama.' - ':'' }} {{ $seller->deskripsi??'' }}</option>
                                @endforeach
                            </datalist>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="filter_status" class="col-form-label col-form-label-sm">Status</label>
                                    <select name="filter_status" id="filter_status" class="form-control form-control-sm">
                                            <option value=""> Pilih Status </option>
                                            <option value="belum_input"> Belum Input</option>
                                            @foreach ($statuses as $key=>$stt)
                                            <option value="{{ $stt->id }}"> {{ $stt->name }} </option>
                                            @endforeach
                                       </select>
                                  </div>
                            </div>
                            <div class="col-sm-1 my-auto">
                                <button type="submit" class="btn btn-sm btn-default float-right"><i class="fa fa-print"></i> print</button>
                            </div>
                        </div>
                        </form>
                        <div class="table-responsive p-0" style="height:500px;">
                            <table id="tbldata" class="table table-head-fixed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="width:100px">ID</th>
                                        <th>Seller</th>
                                        <th>Alamat</th>
                                        <th>Tgl Jemput</th>
                                        <th>Kurir Jemput</th>
                                        <th>Tgl Antar</th>
                                        <th>Kurir Antar</th>
                                        <th>Talangan</th>
                                        <th>Ongkir</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-right">Total Paket : </th>
                                        <th colspan="4" id="totalPaket"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="8" class="text-right">Total Talangan : </th>
                                        <th colspan="4" id="talangan"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="8" class="text-right">Total Ongkir : </th>
                                        <th colspan="4" id="ongkir"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="8" class="text-right">Grand Total : </th>
                                        <th colspan="4" id="sisa"></th>
                                    </tr>
                                </tfoot>
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
<!-- default scripts -->
<script type="text/javascript">
    //untuk loading
    // $body = $("body");
  
    // $(document).on({
    //     ajaxStart: function() { $body.addClass("loading");    },
    //     ajaxStop: function() { $body.removeClass("loading"); }    
    // });
  </script>

<!-- Select2 -->
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function () {
        $('.select2').select2();
    });

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
            startDate: moment().subtract(1, 'days'),
            endDate : moment()
        });
        //deklarasi datetimepicker antar
        $('input[name="filter_periode_antar"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
            });

        $('input[name="filter_periode_antar"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            otable.draw();
        });

        $('input[name="filter_periode_antar"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            otable.draw();

        });


        let otable=$('#tbldata').DataTable({
            responsive: false,
            serverSide: true,
            processing: true,
            "paging":   false,
            "dom": "<t>",
            // ajax: "{{ route('transaksi.json') }}",
            ajax: {
                "url"  : "{{ route ('transaksi.json') }}",
                "data" : function (d) {
                            d.filter_periode = $('#filter_periode').val();
                            d.filter_seller=$('#filter_seller').val();
                            d.filter_kurir=$('#filter_kurir').val();
                            d.filter_kurir_tipe=$('#filter_kurir_tipe').val();
                            d.filter_status=$('#filter_status').val();
                            d.filter_periode_antar=$('#filter_periode_antar').val();
                        },
                beforeSend: function (xhr) {
                            $("#loading").show();
                        },
                complete: function () {
                            $("#loading").hide();
                        },
                "error" : function(y){
                            console.log(y);
                        }
            },
            "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading..n.</span> '},
            columns: [
                { "data": null,"sortable": false, 
                render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                            }  
                },
                { data: 'id', name: 'id' },
                { data: 'seller', name: 'seller' },
                { data: 'detail', name: 'detail', orderable:false },
                { data: 'created_at', name: 'created_at' },
                { data: 'kurirjemput', name: 'kurirjemput' },
                { data: 'tglproses', name: 'tglproses' },
                { data: 'kurirantar', name: 'kurirantar' },
                { data: 'talangan', name: 'talangan', orderable:false },
                { data: 'ongkir', name: 'ongkir', orderable:false },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable:false },
            ],
            columnDefs:[
                {
                    targets:4, render:function(data){
                        return moment(data).format('D/MM/YYYY hh:mm:ss')??'-'; 
                    }
                },
                {
                    targets:6, render:function(data){
                        return moment(data).format('D/MM/YYYY hh:mm:ss')??'-'; 
                    }
                }
            ]
            
        });

        //filter Berdasarkan periode jemput
        $('#filter_periode').change(function () {
            otable.draw();
        });
        //filter Berdasarkan periode antar
        $('#filter_periode_antar').change(function () {
            console.loh('yess');
            otable.draw();
        });
        //filter Berdasarkan hp seller
        $('#filter_seller').change(function () {
            otable.draw();
        });
        //filter Berdasarkan kurir
        $('#filter_kurir').change(function () {
            otable.draw();
        });
        //filter Berdasarkan jenis paket
        $('#filter_kurir_tipe').change(function () {
            otable.draw();
        });
        //filter Berdasarkan jenis status
        $('#filter_status').change(function () {
            otable.draw();
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
        

        otable.on('draw', function () {
            var dat=otable.ajax.json();
            $("#talangan").text(dat['totaltalangan']);
            $("#ongkir").text(dat['totalongkir']);
            $("#sisa").text(dat['sisa']);
            $("#totpenjemputan").text(dat['sisa']);
            $("#antaran").text(dat['antaran']);
            $("#grand_total").text(dat['grand_total']);
            $("#jumlahdata").text(dat['jumlahdata']);
            $("#totalPaket").text(dat['jumlahdata']);
            // $("#jmlbaris").text('Jumlah baris : ' + dat['recordsTotal']);
            // console.log(dat['sisa']);
        });
    });
</script>
@endpush