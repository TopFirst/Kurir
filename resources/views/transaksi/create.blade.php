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
		            <strong>HP Seller:</strong>
					<div class="input-group">
					    <input type="text" name="hp_seller" class="form-control hp nokoma" placeholder="No. telepon" autocomplete="off" role="combobox" list="seller_list" aria-autocomplete="list" required>
					    <div class="input-group-append d-none" id="terdaftar">
					        <span class="input-group-text bg-success" id="id_seller"></span>
					    </div>
					</div>
		        </div>
		    </div>
			<datalist id="seller_list" role="listbox">
				@foreach ($sellers as $seller)
					<option value="{{ $seller->hp }}">{{ $seller->nama? $seller->nama.' - ':'' }} {{ $seller->deskripsi??'' }}</option>
				@endforeach
			</datalist>

		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Alamat:</strong>
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
					<select name="ongkir" class="form-control">
					    @for($i=10;$i<=100;$i+=5) 
						<option value="{{ $i }}">{{ $i }}</option>
					        @endfor
					</select>
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
		//cek seller 
		$(".hp").change(function(){
			$.ajax({
				url: "{{ route ('transaksi.cekseller') }}", 
				data: {hp_seller:this.value},
				success: function(result){
					if(result>0)
					{
						// console.log('masoook');
						$("#id_seller").text(result);
						$("#terdaftar").removeClass("d-none");
					}

				}
			});
			//alert("The text has been changed." + this.value);
		});
		//gak boleh ada character '
		$('.nokoma').keydown(function(e) {
			if(e.keyCode==222)
				return false;
		});
	});
</script>
@endpush