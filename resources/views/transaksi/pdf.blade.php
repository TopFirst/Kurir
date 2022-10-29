
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi Kurir | Cetak Transaksi</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> --}}
  <!-- Ionicons -->
  {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          {{ config('app.name', 'Aplikasi Kurir') }}
          <small class="float-right">Date: {{ date('Y-m-d') }}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info my-3">
      <div class="col-sm-4 invoice-col">
        <b>Periode Jemput:</b> {{ $jemput }}<br>
        <b>Periode Antar:</b> {{ $antar }}<br>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Tipe:</b> {{ $tipe }}<br>
        <b>Kurir:</b> {{ $kurir }}<br>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Hp Seller:</b> {{ $hp_seller }}<br>
        <b>Status:</b> {{ $status }}<br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th style="width:100px">ID</th>
            <th>HP Seller</th>
            <th>Deskripsi</th>
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
              @php
               $i=1;   
              @endphp
              @foreach($dat as $trx)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $trx->id }}</td>
                    <td>{{ $trx->hp_seller }}</td>
                    <td>{{ $trx->nama_customer?$trx->nama_customer." - ":"" }}{{ $trx->deskripsi }}</td>
                    <td>{{ $trx->created_at }}</td>
                    <td>{{ $trx->kurir->name }}</td>
                    <td>{{ $trx->antar->updated_at??'-' }}</td>
                    <td>{{ $trx->antar->kurir->name??'-' }}</td>
                    <td>{{ $trx->talangan }}</td>
                    <td>{{ $trx->ongkir }}</td>
                    <td>{{ $trx->antar->status->name??'Belum Diinput' }}</td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Ringkasan</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Total Talangan:</th>
              <td>{{ $total_talangan }}</td>
            </tr>
            <tr>
              <th>Total Ongkos Kirim:</th>
              <td>{{ $total_ongkir }}</td>
            </tr>
            <tr>
              <th>Grand Total:</th>
              <td>{{ $grand_total }}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<script type="text/javascript"> 
    window.addEventListener("load", window.print());
  </script>
</body>
</html>
