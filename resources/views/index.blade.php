<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags --> 
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>{{ $web_data->nama }}</title>
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/owl.carousel/css/owl.carousel.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/owl.carousel/css/owl.theme.default.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/aos/css/aos.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/jquery-flipster/css/jquery.flipster.css') }}">
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
		<link rel="shortcut icon" href="favicon.png" />
	</head>
	<body data-spy="scroll" data-target=".navbar" data-offset="50">
		<div id="mobile-menu-overlay"></div>
		<nav class="navbar navbar-expand-lg fixed-top">
			<div class="container">
				{{-- <a class="navbar-brand" href="#"><img src="images/logo.svg" alt="Marshmallow"></a> --}}
				<a class="navbar-brand" href="#"><img src="{{ asset($web_data->url_logo) }}" alt="logo">
					@can('role-edit')
					<span>
					<button type="button" data-toggle="modal" data-target="#editheadermodal" class="btn text-center"
						data-aos="zoom-in-up" data-aos-easing="linear"><i
							class="mdi mdi-pencil-circle-outline mdi-24px"></i></button>
						</span>
				@endcan
				</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"><i class="mdi mdi-menu"> </i></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
					<div class="d-lg-none d-flex justify-content-between px-4 py-3 align-items-center">
						<img src="images/logo-dark.svg" class="logo-mobile-menu" alt="logo">
						<a href="javascript:;" class="close-menu"><i class="mdi mdi-close"></i></a>
					</div>
					<ul class="navbar-nav ml-auto align-items-center">
						<li class="nav-item active">
							<a class="nav-link" href="#home">Beranda <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#layanan">Layanan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#about">Tentang Kami</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#gallery">Gallery</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#testimonial">Testimonial</a>
						</li>
						@auth
						<li class="nav-item">
								<a class="nav-link btn btn-light" href="{{ route('transaksi.index') }}">Dashboard</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-light" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
							    Log Out
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							    @csrf
							</form>
						</li>
						@else
						<li class="nav-item">
						    <a class="nav-link" href="{{ route('login') }}">Log in</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-success" href="tel:{{ $web_data->hp1 }}">+{{ $web_data->hp1 }}</a>
						</li>
						@endauth
							
                        {{-- @if (Route::has('login')) --}}
                        {{-- <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <li class="nav-item">
									<a class="nav-link m-0" href="{{ url('/home') }}"><i class="fa fa-sign-out-alt"></i></a>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Log in</a>
                                </li>
                            @endauth
                        </div> --}}
                        {{-- @endif --}}
						
					</ul>
				</div>
			</div>
		</nav>
		<div class="page-body-wrapper">
			<section id="home" class="home">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="main-banner">
								<div class="d-sm-flex justify-content-between">
									<div data-aos="zoom-in-up">
										<div class="banner-title">
												<h3 class="font-weight-medium">{{ $web_top_info->nama }}<br>{!! $web_top_info->sub_judul !!}
											</h3>
										</div>
										<p class="mt-3">
                                            {!! $web_top_info->desc !!}
										</p>
										<a href="#" class="btn btn-secondary mt-3">Selengkapnya..</a>
									</div>
									<div class="mt-5 mt-lg-0">
										@can('role-edit')
										<div class="position-absolute" style="z-index:1000">
											<a href="#" onclick="return EditData('{{ $web_top_info->id }}','{{ $web_top_info->tipe }}','{{ $web_top_info->nama }}','{{ $web_top_info->sub_judul }}','{{ $web_top_info->url_logo }}','{{ $web_top_info->desc }}')"
											class="btn" data-aos="zoom-in-up" data-aos-easing="linear" ><i class="mdi mdi-pencil-circle-outline mdi-24px text-white"></i></a>
										</div>
										@endcan
											  <div class="col-12 col-sm-12 col-md-12">
												<div class="row mt-2">
												    <form action="{{ route('home.cekresi') }}" method="POST" class="d-block col-12">
											  <img src="{{ asset($web_top_info->url_logo) }}" alt="kurir" class="d-block mx-auto img-fluid mb-2" data-aos="zoom-in-up">
											  {{-- <img src="https://www.tiki.id/images/1-Beranda/Ikon-Cek-Resi.png" class="d-block mx-auto mb-2"> --}}
														@csrf
														@method('GET')
												        <div class="input-group">
												            <input type="text" class="form-control" name="txtcari" placeholder="No transaksi.." required>
												            <span class="input-group-append">
												                <button type="submit" class="btn btn-info btn-flat">Cek!</button>
												            </span>
												        </div>
												    </form>
												</div>
											</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="our-services" id="layanan">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<h5 class="text-dark">Kami menawarkan</h5>
							<h3 class="font-weight-medium text-dark mb-5">Jasa Kurir Lokal Terbaik
								@can('role-edit')
										<span>
										<button type="button" onclick="return AddData('layanan')" class="btn text-center"
											data-aos="zoom-in-up" data-aos-easing="linear"><i
												class="mdi mdi-library-plus mdi-24px"></i></button>
											</span>
									@endcan
							</h3>
						</div>
					</div>		
							
					<div class="row" data-aos="fade-up">
					    @foreach ($web_layanans as $key => $web_layanan)
					    <div class="col-sm-4 text-center text-lg-left">

					        @can('role-edit')
					        <div class="position-absolute" style="z-index:1; right:0">
								<div class="btn-group btn-group-append">
									<button type="button" onclick="return HapusData('{{ $web_layanan->id }}')"
										class="btn text-center" data-aos="zoom-in-up" data-aos-easing="linear"><i
											class="mdi mdi-delete-circle mdi-24px float-right"></i></button>
									<button type="button" onclick="return EditData('{{ $web_layanan->id }}','{{ $web_layanan->tipe }}','{{ $web_layanan->nama }}','{{ $web_layanan->sub_judul }}','{{ $web_layanan->url_logo }}','{{ $web_layanan->desc }}')"
										class="btn text-center" data-aos="zoom-in-up" data-aos-easing="linear"><i
											class="mdi mdi-pencil-circle-outline mdi-24px"></i></button>
								</div>
					        </div>
					        @endcan
					        <div class="services-box" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
					            <img src="{{ asset($web_layanan->url_logo) }}" class="img-fluid" alt="{{ $web_layanan->nama }}" data-aos="zoom-in">
					            <h6 class="text-dark mb-3 mt-4 font-weight-medium">{{ $web_layanan->nama }}</h6>
					            <p>{{ $web_layanan->desc }}</p>
					        </div>
					    </div>
					    @endforeach
					</div>

				</div>
			</section>
			<section class="our-process" id="about">
				<div class="container">
					<div class="row">
						<div class="col-sm-6" data-aos="fade-up">
							<h5 class="text-dark">{{ $web_about->nama }}</h5>
							<h3 class="font-weight-medium text-dark">{{ $web_about->sub_judul }}</h3>
							<h5 class="text-dark mb-3">{{ $web_about->sub_judul }}</h5>
							<p class="font-weight-medium mb-4">{!! $web_about->desc !!}</p>
						</div>
						<div class="col-sm-6 text-right" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
							@can('role-edit')
					        <div class="position-absolute" style="z-index:1; right:0">
					            <button type="button" onclick="return EditData('{{ $web_about->id }}','{{ $web_about->tipe }}','{{ $web_about->nama }}','{{ $web_about->sub_judul }}','{{ $web_about->url_logo }}',`{{ $web_about->desc }}`)"
					                class="btn text-center" data-aos="zoom-in-up" data-aos-easing="linear">
									<i class="mdi mdi-pencil-circle-outline mdi-24px"></i></button>
					        </div>
					        @endcan
							<img src="{{ asset($web_about->url_logo) }}" alt="{{ $web_about->nama }}" class="img-fluid">
						</div>
					</div>
				</div>
			</section>
			<section class="our-projects" id="gallery">
				<div class="container">
					<div class="row mb-5">
						<div class="col-sm-12">
							<div class="d-sm-flex justify-content-between align-items-center mb-2">
								<h3 class="font-weight-medium text-dark ">Gallery 
									@can('role-edit')
										<span>
										<button type="button" onclick="return AddData('gallery')" class="btn text-center"
											data-aos="zoom-in-up" data-aos-easing="linear"><i
												class="mdi mdi-library-plus mdi-24px"></i></button>
											</span>
									@endcan
								</h3>
								<div><a href="#" class="btn btn-outline-primary">Selengkapnya..</a></div>
							</div>
						</div>

					</div>
				</div>
				<div class="mb-5" data-aos="fade-up">
					<div class="owl-carousel-projects owl-carousel owl-theme">
					    @foreach ($web_galleries as $key => $gallery)
						<div class="item">
							@can('role-edit')
					        <div class="position-absolute" style="z-index:1; right:0">
					            <button type="button" onclick="return HapusData('{{ $gallery->id }}')"
					                class="btn text-center" data-aos="zoom-in-up" data-aos-easing="linear"><i
					                    class="mdi mdi-delete-circle mdi-24px"></i></button>
					        </div>
					        @endcan
							<img src="{{ asset($gallery->url_logo) }}" alt="{{ $gallery->nama }}">
							</div>
							
							@endforeach
						{{-- @for($i=1;$i<11;$i++)
						<div class="item">
							<img src="https://source.unsplash.com/331x392/?courier/?sig={{ $i }}" alt="slider_{{ $i }}">
						</div>
						@endfor --}}
						
					</div>
				</div>
				<div class="container">
					<div class="row pt-5 mt-5 pb-5 mb-5">
						<div class="col-sm-3">
							<div class="d-flex py-3 my-3 my-lg-0 justify-content-center" data-aos="fade-down">
								<img src="images/satisfied-client.svg" alt="satisfied-client" class="mr-3">
								<div>
									{{-- <h4 class="font-weight-bold text-dark mb-0"><span class="scVal2">0</span>%</h4> --}}
									<h4 class="font-weight-bold text-dark mb-0">100%</h4>
									<h5 class="text-dark mb-0">Kepuasan Pelanggan</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="d-flex py-3 my-3 my-lg-0 justify-content-center" data-aos="fade-up">
								<img src="images/finished-project.svg" alt="satisfied-client" class="mr-3">
								<div>
									{{-- <h4 class="font-weight-bold text-dark mb-0"><span class="fpVal">0</span></h4> --}}
									<h4 class="font-weight-bold text-dark mb-0">{{ $total_transaksi }}</h4>
									<h5 class="text-dark mb-0">Paket Terkirim</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="d-flex py-3 my-3 my-lg-0 justify-content-center" data-aos="fade-down">
								<img src="images/team-members.svg" alt="Team Members" class="mr-3">
								<div>
									{{-- <h4 class="font-weight-bold text-dark mb-0"><span class="tMVal">0</span></h4> --}}
									<h4 class="font-weight-bold text-dark mb-0">{{ $total_kurir }}</h4>
									<h5 class="text-dark mb-0">Kurir Terdaftar</h5>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="d-flex py-3 my-3 my-lg-0 justify-content-center" data-aos="fade-up">
								<img src="images/our-blog-posts.svg" alt="Our Blog Posts" class="mr-3">
								<div>
									{{-- <h4 class="font-weight-bold text-dark mb-0"><span class="bPVal">0</span></h4> --}}
									<h4 class="font-weight-bold text-dark mb-0">{{ $total_pelanggan }}</h4>
									<h5 class="text-dark mb-0">Pelanggan Setia</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="testimonial" id="testimonial">
				<div class="container">
					<div class="row  mt-md-0 mt-lg-4">
						<div class="col-sm-6 text-white" data-aos="fade-up">
							<p class="font-weight-bold mb-3">{{ $web_testimoni_head->nama }}</p>
							<h3 class="font-weight-medium">{!! $web_testimoni_head->sub_judul !!}</h3>
							<ul class="flipster-custom-nav">
								<li class="flipster-custom-nav-item">
									<a href="javascript:;" class="flipster-custom-nav-link" title="0"></a>
								</li>
								<li class="flipster-custom-nav-item">
									<a href="javascript:;" class="flipster-custom-nav-link"  title="1"></a>
								</li>
								<li class="flipster-custom-nav-item">
									<a href="javascript:;" class="flipster-custom-nav-link active" title="2"></a>
								</li>
								<li class="flipster-custom-nav-item">
									<a href="javascript:;" class="flipster-custom-nav-link"  title="3"></a>
								</li>
							</ul>
						</div>
						<div class="col-sm-6" data-aos="fade-up">
							<div id="testimonial-flipster">
								<ul>
								@foreach ($web_testimoni as $key => $testimoni)
									<li>
										<div class="testimonial-item">
										    @can('role-edit')
										    <div class="position-absolute" style="z-index:1; right:0">
										        <button type="button" onclick="return EditData('{{ $testimoni->id }}','{{ $testimoni->tipe }}','{{ $testimoni->nama }}','{{ $testimoni->sub_judul }}','{{ $testimoni->url_logo }}','{{ $testimoni->desc }}')"
										            class="btn text-center" data-aos="zoom-in-up" data-aos-easing="linear"><i
										                class="mdi mdi-pencil-circle-outline mdi-24px"></i></button>
										    </div>
										    @endcan
											<img src="{{ $testimoni->url_logo }}" alt="icon" class="testimonial-icons">
											<p>{{ $testimoni->desc }}
											</p>
											<h6 class="testimonial-author">{{ $testimoni->nama }}</h6>
											<p class="testimonial-destination">{{ $testimoni->sub_judul }}</p>
										</div>
									</li>
									@endforeach
									
								</ul>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="clients pt-5 mt-5"  data-aos="fade-up" data-aos-offset="-400">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							@can('role-edit')
							<div class="position-absolute my-n5 mx-n5" style="z-index:1;">
							    <button type="button" class="btn text-center" onclick="return AddData('client')" data-aos="zoom-in-up" data-aos-easing="linear"><i
							            class="mdi mdi-library-plus mdi-24px"></i></button>
							</div>
							@endcan

							<div class="d-sm-flex justify-content-between align-items-center">
								@foreach ($web_client as $key => $client)
								@can('role-edit')
								<div class="d-sm-flex py-3 my-3 my-lg-0">
								    <div class="position-absolute" style="z-index:1;">
								        <button type="button" onclick="return HapusData('{{ $client->id }}')"
								            class="btn text-center" data-aos="zoom-in-up" data-aos-easing="linear"><i
								                class="mdi mdi-delete-circle mdi-24px"></i></button>
								    </div>
								</div>
								@endcan
								<img src="{{ asset($client->url_logo) }}" alt="{{ $client->nama }}" class="p-2 p-lg-0" data-aos="fade-down"  data-aos-offset="-400">
								@endforeach
							</div>

						</div>
					</div>
				</div>
			</section>
			<section class="contactus" id="contact">
				<div class="container">
					<div class="row mb-5 pb-5">
						<div class="col-sm-5" data-aos="fade-up" data-aos-offset="-500">
							@can('role-edit')
					        <div class="position-absolute" style="z-index:1; right:0">
					            <button type="button" onclick="return EditData('{{ $web_contact->id }}','{{ $web_contact->tipe }}','{{ $web_contact->nama }}','{{ $web_contact->sub_judul }}','{{ $web_contact->url_logo }}','{{ $web_contact->desc }}')"
					                class="btn text-center" data-aos="zoom-in-up" data-aos-easing="linear">
									<i class="mdi mdi-pencil-circle-outline mdi-24px"></i></button>
					        </div>
					        @endcan
							<img src="{{ $web_contact->url_logo }}" alt="{{ $web_contact->nama }}" class="img-fluid">
						</div>
						<div class="col-sm-7" data-aos="fade-up" data-aos-offset="-500">
							<h3 class="font-weight-medium text-dark mt-5 mt-lg-0">{{ $web_contact->nama }} </h3>
							<h5 class="text-dark mb-5">{{ $web_contact->desc }} </h5>
							<form>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<input type="text" class="form-control" id="name" placeholder="Name*">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<input type="email" class="form-control" id="mail" placeholder="Email*">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<textarea name="message" id="message" class="form-control" placeholder="Message*" rows="5"></textarea>
										</div>
									</div>
									<div class="col-sm-12">
										<a href="#" class="btn btn-secondary">SEND</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
		<footer class="footer">
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<address>
								<p>{{ $web_data->alamat1 }}</p>
								<p class="mb-4">{{ $web_data->alamat2 }}</p>
								<div class="d-flex align-items-center">
									<p class="mr-4 mb-0">+{{ $web_data->hp1 }}</p>
									<a href="mailto:{{ $web_data->email1 }}" class="footer-link">{{ $web_data->email1 }}</a>
								</div>
								<div class="d-flex align-items-center">
									<p class="mr-4 mb-0">+{{ $web_data->hp2 }}</p>
									<a href="mailto:{{ $web_data->email2 }}" class="footer-link">{{ $web_data->email2 }}</a>
								</div>
							</address>
							<div class="social-icons">
								<h6 class="footer-title font-weight-bold">
									Media Sosial
								</h6>
								<div class="d-flex">
									<a href="https://www.youtube.com/{{ $web_data->yt }}"><i class="mdi mdi-youtube"></i></a>
									<a href="https://www.facebook.com/{{ $web_data->fb }}"><i class="mdi mdi-facebook-box"></i></a>
									<a href="https://www.twitter.com/{{ $web_data->twitter }}"><i class="mdi mdi-twitter"></i></a>
									<a href="https://www.instagram.com/{{ $web_data->ig }}"><i class="mdi mdi-instagram"></i></a>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-4">
									<h6 class="footer-title">Menu</h6>
									<ul class="list-footer">
										<li><a href="#" class="footer-link">Beranda</a></li>
										<li><a href="#layanan" class="footer-link">Layanan</a></li>
										<li><a href="#gallery" class="footer-link">Gallery</a></li>
										<li><a href="#contact" class="footer-link">Hubungi Kami</a></li>
									</ul>
								</div>
								<div class="col-sm-4">
									<h6 class="footer-title">Jam Kerja</h6>
									<ul class="list-footer">
										<li><a href="#" class="footer-link">Senin-Jumat 8am-8pm</a></li>
										<li><a href="#" class="footer-link">Sabtu 9am-8pm</a></li>
										<li><a href="#" class="footer-link">Minggu 9am-7pm</a></li>
										<li><a href="#" class="footer-link">Hari Libur 10am-6pm</a></li>
									</ul>
								</div>
								<div class="col-sm-4">
									<h6 class="footer-title">Link</h6>
									<ul class="list-footer">
										<li><a href="#" class="footer-link">Link 1</a></li>
										<li><a href="#" class="footer-link">Link 2</a></li>
										<li><a href="#" class="footer-link">Link 3</a></li>
										<li><a href="#" class="footer-link">Link 4</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="container">
					<div class="d-flex justify-content-between align-items-center">
						<div class="d-flex align-items-center">
							<img src="{{ asset($web_data->url_logo) }}" alt="logo" class="mr-3">
							<p class="mb-0 text-small pt-1">© 2021 <a href="https://www.aoksinergi.com" class="text-white" target="_blank">Aok Sinergi</a>. All rights reserved.</p>
						</div>
						<div>
							<div class="d-flex">
								<a href="#" class="text-small text-white mx-2 footer-link">Privacy Policy </a>          
								<a href="#" class="text-small text-white mx-2 footer-link">Customer Support </a>
								<a href="#" class="text-small text-white mx-2 footer-link">Careers </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>

		@can('role-edit')
				<!-- modal web data edit -->
				<div class="modal fade" id="editheadermodal">
					<div class="modal-dialog text-dark">
						<form action="{{ route('web.update_web_info',$web_data->id) }}" method="POST"
							enctype="multipart/form-data">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Ubah Header {{ $web_data->id }} </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									@csrf
									@method('POST')
									<div class="form-group">
										<label>Nama</label>
										<input type="text" class="form-control form-control-sm" name="nama" value="{{ $web_data->nama }}" placeholder="masukkan nama.." required>
									</div>
									<div class="form-group">
										<label>HP 1</label>
										<input type="text" class="form-control form-control-sm" name="hp1" value="{{ $web_data->hp1 }}" placeholder="masukkan HP 1.." required>
									</div>
									<div class="form-group">
										<label>HP 2</label>
										<input type="text" class="form-control form-control-sm" name="hp2" value="{{ $web_data->hp2 }}" placeholder="masukkan HP 2.." required>
									</div>
									<div class="form-group">
										<label>Email 1</label>
										<input type="email" class="form-control form-control-sm" name="email1" value="{{ $web_data->email1 }}" placeholder="masukkan email 1.." required>
									</div>
									<div class="form-group">
										<label>Email 2</label>
										<input type="email" class="form-control form-control-sm" name="email2" value="{{ $web_data->email2 }}" placeholder="masukkan email 2.." required>
									</div>
									<div class="form-group">
										<label>Alamat 1</label>
										<input type="text" class="form-control form-control-sm" name="alamat1" value="{{ $web_data->alamat1 }}" placeholder="masukkan alamat 1.." required>
									</div>
									<div class="form-group">
										<label>Alamat 2</label>
										<input type="text" class="form-control form-control-sm" name="alamat2" value="{{ $web_data->alamat2 }}" placeholder="masukkan alamat 2.." required>
									</div>
									<div class="form-group">
										<label for="modal_url_logo_header">Logo</label>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="modal_url_logo_header" name="url_logo"
													accept=".jpeg,.png,.jpg,.svg">
												<label class="custom-file-label" for="modal_url_logo_header">Pilih</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Facebook</label>
										<input type="text" class="form-control form-control-sm" name="fb" value="{{ $web_data->fb }}" placeholder="masukkan facebook .." required>
									</div>
									<div class="form-group">
										<label>Youtube</label>
										<input type="text" class="form-control form-control-sm" name="yt" value="{{ $web_data->yt }}" placeholder="masukkan youtube.." required>
									</div>
									<div class="form-group">
										<label>Instagram</label>
										<input type="text" class="form-control form-control-sm" name="ig" value="{{ $web_data->ig }}" placeholder="masukkan instagram.." required>
									</div>
									<div class="form-group">
										<label>Twitter</label>
										<input type="text" class="form-control form-control-sm" name="twitter" value="{{ $web_data->twitter }}" placeholder="masukkan twitter.." required>
									</div>
								</div>
								<div class="modal-footer justify-content-between">
									<button type="submit" class="btn btn-success">Submit</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</form>
					</div>
					<!-- /.modal-dialog -->
				</div>
		<!-- modal edit -->
		<div class="modal fade" id="modaleditdata">
			<div class="modal-dialog text-dark">
				<form action="{{ route('web.update_layanan') }}" method="POST"
					enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Ubah Layanan <label id="aidi"></label> </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							@csrf
							@method('POST')
							<input type="hidden" name="id" id="modal_id">
							<input type="hidden" name="tipe" id="modal_tipe">
							<div class="form-group">
								<label>Nama</label>
								<input type="text" class="form-control form-control-sm" name="nama" id="modal_nama" placeholder="masukkan nama.." required>
							</div>
							<div class="form-group">
								<label>Sub Judul</label>
								<input type="text" class="form-control form-control-sm" name="sub_judul" id="modal_sub_judul" placeholder="masukkan sub judul..">
							</div>
							<div class="form-group">
								<label for="modal_url_logo">Logo</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="modal_url_logo" name="url_logo"
											accept=".jpeg,.png,.jpg,.svg">
										<label class="custom-file-label" for="modal_url_logo">Pilih</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="desc">Deskripsi</label>
								<textarea class="form-control form-control-sm" rows="5" name="desc" id="modal_desc" placeholder="masukkan deskripsi.."></textarea>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="submit" class="btn btn-success">Submit</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</form>
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- modal tambah gambar -->
		<div class="modal fade" id="add_pic">
			<div class="modal-dialog text-dark">
				<form action="{{ route('web.isi_layanan') }}" method="POST"
					enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Isi Layanan</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							@csrf
							@method('POST')
							<div class="form-group">
								<label>Nama</label>
								<input type="text" class="form-control form-control-sm" name="nama" placeholder="masukkan nama.." required>
							</div>
							<div class="form-group">
								<label>Tipe</label>
								<input type="text" class="form-control form-control-sm" name="tipe" id="new_tipe_modal" readonly>
							</div>
							<div class="form-group">
								<label for="url_logo_gal">Logo</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="url_logo_gal" name="url_logo"
											accept=".jpeg,.png,.jpg,.svg">
										<label class="custom-file-label" for="url_logo_gal">Pilih</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Deskripsi</label>
								<textarea class="form-control form-control-sm" rows="4" name="desc" placeholder="masukkan deskripsi.."></textarea>
							</div>
						</div>
						<div class="modal-footer float-right">
							<button type="submit" class="btn btn-success">Tambah Baru</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</form>
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- modal konfirmasi hapus gambar -->
		<div class="modal fade" id="konfirmasihapus">
		    <div class="modal-dialog text-dark">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h5 class="modal-title">Konfirmasi Hapus</h5>
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                </button>
		            </div>
		            <div class="modal-body">
		                <form action="{{ route('web.hapus') }}" method="POST">
		                    @csrf
		                    @method('POST')
		                    <p>Apakah yakin ingin mengapus gambar ini?</p>
							<input type="hidden" name="id" id="id_hapus">
		                    <div class="justify-content-between">
		                        <button type="submit" class="btn btn-outline-danger">Hapus</button>
		                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		                    </div>
		                </form>
		            </div>
		        </div>
		        <!-- /.modal-content -->
		    </div>
		    <!-- /.modal-dialog -->
		</div>
		@endcan
		<!-- /.modal edit -->
		<script src="{{ asset('vendors/base/vendor.bundle.base.js') }}"></script>
		<script src="{{ asset('vendors/owl.carousel/js/owl.carousel.js') }}"></script>
		<script src="{{ asset('vendors/aos/js/aos.js') }}"></script>
		<script src="{{ asset('vendors/jquery-flipster/js/jquery.flipster.min.js') }}"></script>
		<!-- bs-custom-file-input -->
		<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				// var maxScVal = @{{ $total_pelanggan }}
				bsCustomFileInput.init();
			});
			function EditData($id, $tipe, $nama, $sub_judul, $url_logo, $desc)
			{
				$("#modal_id").val($id);
				$("#modal_tipe").val($tipe);
				$("#modal_nama").val($nama);
				$("#modal_sub_judul").val($sub_judul);
				$("#vurl_logo").val($url_logo);
				$("#modal_desc").text($desc.toString());
				$("#aidi").text($id);
				$('#modaleditdata').modal('toggle');
			}
			function AddData($tipe)
			{
				$("#new_tipe_modal").val($tipe);
				$('#add_pic').modal('toggle');
			}
			function HapusData($id)
			{
				$("#id_hapus").val($id);
				$('#konfirmasihapus').modal('toggle');
			}
			$(function () {
				// counter Satisfied clients
				var maxScVal = 50;
				var isc = parseInt($('.scVal2').text());
				var tim;
				function run() {
				tim = setInterval(function() {
				if (isc >= maxScVal) {
				clearInterval(tim);
				return;
				}
				$('.scVal2').text(++isc);
				}, 100);
				}
				run();
				//Counters
			});
		</script>
		<script src="js/template.js"></script>
	</body>
</html>