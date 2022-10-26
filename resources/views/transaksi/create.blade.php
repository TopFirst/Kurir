@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>No. {{ $id_baru }}</h2>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST">
    	@csrf
         <div class="row">
			 {{-- <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"> --}}
			 <input type="hidden" name="id" value="{{ $id_baru }}">
			 @can('transaksi-edit')
			 <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
					<strong>Kurir Jemput:</strong>
					{!! Form::select('user_id', $kurirs->pluck('name','id'),Auth::user()->id, array('class' =>
					'form-control')) !!}
				</div>
		    </div>
			 @endcan
			 <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>HP Seller/Olshop:</strong>
					<div class="input-group">
					    {{-- <input type="text" name="hp_seller" class="form-control hp nokoma" placeholder="No. telepon" autocomplete="off" role="combobox" list="seller_list" aria-autocomplete="list" required> --}}
					    <input type="text" data-provide="typeahead" name="hp_seller" autocomplete="off" class="form-control hp nokoma" placeholder="No. telepon" required/>
					    <div class="input-group-append d-none" id="terdaftar">
					        <span class="input-group-text bg-success" id="id_seller"></span>
					    </div>
						<input type="hidden" name="registered_seller" id="registered_seller_id"/>
					</div>
		        </div>
		    </div>
			<div class="col-xs-12 col-sm-12 col-md-12 d-none" id="div_seller_name">
		        <div class="form-group">
		            <strong>Nama Seller/Olshop:</strong>
		            <input type="text"  name="nama_seller" class="form-control" placeholder="Nama seller..">
		        </div>
		    </div>
			<div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Nama Customer:</strong>
		            <input type="text"  name="nama_customer" class="form-control" placeholder="Nama customer.." required>
		        </div>
		    </div>

		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Alamat Customer:</strong>
		            <textarea name="deskripsi" class="form-control nokoma" placeholder="masukkan deskripsi paket" rows="3" required></textarea>
		        </div>
		    </div>
            <hr>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Talangan:</strong>
		            <input type="number" min="0" name="talangan" class="form-control" placeholder="talangan" onkey step="1" required>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Ongkir:</strong>
					<select name="ongkir" id="ongkir" class="form-control">

					@for($i=5;$i<=9;$i++) 
						<option value="{{ $i }}" {{$i==$ongkir_dasar?"selected":""}}>{{ $i }}</option>
					@endfor

					    @for($i=10;$i<=100;$i+=5) 
						<option value="{{ $i }}" {{$i==$ongkir_dasar?"selected":""}}>{{ $i }}</option>
					        @endfor
						<option value="0">Custom</option>

					</select>
		            <input type="number" min="5" max="100" id="custom_ongkir" name="custom_ongkir" value="{{$ongkir_dasar}}" class="form-control" placeholder="custom ongkir.." onkey step="1">

		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>
    </form>
@endsection
@push('scripts')
<script type="text/javascript">
	$(function () {
		$('#custom_ongkir').hide();

		//cek seller 
		//$(".hp").change(function(){
			$('.hp').on('change', function(evt,data) {
				console.log(this.value);
			$.ajax({
				url: "{{ route ('transaksi.cekseller') }}", 
				data: {hp_seller:this.value},
				success: function(result){
					if(result>0)
					{
						$("#registered_seller_id").val(result);
						$("#id_seller").text(result);
						$("#terdaftar").removeClass("d-none");
						$("#div_seller_name").addClass("d-none");
					}
					else
					{
						$("#registered_seller_id").val(0);
						$("#terdaftar").addClass("d-none");
						$("#div_seller_name").removeClass("d-none");
					}

				}
			});
			return false;
			//alert("The text has been changed." + this.value);
		});
		//cek typehead
		var path = "{{ route('transaksi.autocomplete') }}";
		$('input.nokoma').typeahead({
			source:  function (query, process) {
			return $.get(path, { query: query }, function (data) {
				//console.log(data);
					return process(data);
				});
			},
			autoSelect:true,
			displayText:function(item){return item.nama;}
		});
		//gak boleh ada character '
		$('.nokoma').keydown(function(e) {
			if(e.keyCode==222)
				return false;
		});
		$('#ongkir').on('change', function() {
			if(this.value==0)
			$('#custom_ongkir').show();
			else
			$('#custom_ongkir').hide();

		});
	});
</script>
@endpush