@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="float-left">
            <h2> Lacak Paket</h2>
        </div>
        <div class="float-right">
            <a class="btn btn-outline-primary" href="{{ route('web.index') }}"> Home</a>
        </div>
    </div>
</div>
<div class="row mt-5">
        <div class="form-group mx-3">
            <strong>No Paket:</strong>
            {{ $dat->id }}
        </div>
        <div class="form-group mx-3">
            <strong>Tanggal Jemput:</strong>
            {{ $dat->created_at }}
        </div>
        <div class="form-group mx-3">
            <strong>Tanggal Antar:</strong>
            {{ $dat->antar->updated_at??'-' }}
        </div>
        <div class="form-group mx-3">
            <strong>Alamat:</strong>
            {{ $dat->deskripsi }}
        </div>
    </div>
    <div class="row">
        <div class="form-group mx-3">
            <strong>Status:</strong>
            {{ $dat->antar->status->name??'Belum Diinput' }}
        </div>
        <div class="form-group mx-3">
            <strong>Harga Paket:</strong>
            {{ $dat->talangan }}
        </div>
        <div class="form-group mx-3">
            <strong>Ongkos Kirim:</strong>
            {{ $dat->ongkir }}
        </div>
    </div>
    <div class="row">
        <div class="form-group row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="card m-3" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset($dat->kurir->foto??'images/nouser.png') }}" alt="Gambar Kurir Antar">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Kurir Jemput</h4>
                        <p class="card-text">Nama : {{ $dat->kurir->name }}<br>
                            Hp : {{ $dat->kurir->hp }}
                        </p>
                        <a href="https://wa.me/{{ $dat->kurir->hp }}" class="btn btn-success"><i
                                class="fa fa-phone"></i> Whatsapp</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="card m-3" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset($dat->antar->kurir->foto??'images/nouser.png') }}" alt="Gambar Kurir Jemput">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Kurir Antar</h4>
                        <p class="card-text">Nama : {{ $dat->antar->kurir->name??'-' }}<br>
                            Hp : {{ $dat->antar->kurir->hp??'-' }}
                        </p>
                        <a href="https://wa.me/{{ $dat->antar->kurir->hp??'0' }}" class="btn btn-success"><i
                                class="fa fa-phone"></i> Whatsapp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection