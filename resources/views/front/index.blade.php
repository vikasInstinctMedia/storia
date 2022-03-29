@extends('layouts.front')

@section('style')
@if (isset($metadata['meta_title']))
<meta name="title" content="{{ $metadata['meta_title'] }}">
<title>{{ $metadata['meta_title'] }}</title>
@else
<title>Storia Foods &#8211; Home</title>
@endif

@if (isset($metadata['meta_description']))
<meta name="description" content="{{ $metadata['meta_description'] }}">
@else
<meta name="description" content="Storia Foods &#8211; Home">
@endif
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<style>
	/* The Modal (background) */
	.modal {
		position: fixed;
		z-index: 999;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
	}

	/* Modal Content */
	.modal-content {
		background-color: #f6f6f8;
		margin: auto;
		padding: 20px;
		border: 1px solid #888;
		width: 40%;
		top: 30%;
		left: 0;
		transform: translate(0%, 0%);
	}

	/* The Close Button */
	.close {
		color: #aaaaaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}

	.mainfull {
		width: 40% !important;
		height: 30%;
	}

	.submit {
		border-radius: 0 !important;
		line-height: 0.7 !important;
		font-weight: normal !important;
		background: #1abe9c !important;
		border: 1px solid #1abe9c !important;
	}

	.markermin {
		background: #1abe9c;
		padding: 11px;
		color: #ffff;
	}

	.modal-backdrop {
		z-index: 0;
	}

	.image-product {
	    height:auto;
	}

	.test-div {
		border:2px solid #CCC;
		/* width:600px; */
	}
	.test-div-inner {
		padding-bottom:100%;
		background:#EEE;
		height:0;
		position:relative;
	}
	.test-image {
		width:100%;
		/* height:100%; */
		display:block;
		/* position:absolute; */
	}



@media only screen and (min-width: 992px) {
    .banner-image-div {
        height: 78% !important;
    }

    .rev_slider{
        margin-bottom:-102px !important;
    }

}


@media only screen and (min-width: 1200px) {
        .banner-image-div {
        height: 78% !important;
    }

    .rev_slider{
        margin-bottom:-102px !important;
    }

}

</style>
@endsection
@section('content')

<div id="main">
	<div class="section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 p-0">
					<div id="rev_slider" class="rev_slider fullscreenbanner">
						<ul>
							<!-- <li data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide">
								<img src="{{asset('front/images/slider/NAS-banner.png')}}" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" />
							</li>
							<li data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide">
								<img src="{{asset('front/images/slider/Summer_essential1.png')}}" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" />
							</li>
							<li data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide">
								<img src="{{asset('front/images/slider/NAS-shakes-4.png')}}" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" />
							</li> -->

							@foreach($banners as $banner)
							<li data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide" class="banner-image-div" data-href="{{ $banner->redirect_url }}" >
								<!-- <a href="" > -->
							 	<img  src="{{asset('storage/'.$banner->image)}}"  alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" />
								<!-- </a> -->
							</li>
							@endforeach

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="section pt-4 pb-0" style="background: #f7f7f7;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center mb-1 section-pretitle">Discover</div>
					<h2 class="text-center section-title pb-3">Our category</h2>
					<div class="organik-seperator center">
						<span class="sep-holder"><span class="sep-line"></span></span>
						<div class="sep-icon"><i class="organik-flower"></i></div>
						<span class="sep-holder"><span class="sep-line"></span></span>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="product-grid masonry-grid-post">
					@foreach($categories as $cat)
					<div class="col-md-4 col-lg-4 col-xs-6 product-item masonry-item text-center">

						<div class="product-thumb test-div">
							<a class="test-div-inner" href="{{ route('front.category',$cat->slug) }}">
								<!-- <div class="badges">
											<span class="hot">New</span>
										</div> -->
								<img src="{{asset('storage/'.$cat->thumbnail_image)}}" alt="" class="test-image" height="1000" width="1000" />

							</a>
						</div>
						<div class="product-info">
							<a href="{{ route('front.category',$cat->slug) }}">
								<h2 class="title">{{ $cat->name }}</h2>
							</a>
						</div>
					</div>
					@endforeach
				</div>
				<!-- <div class="loadmore-contain">
							<a class="organik-btn small" href="shop-list.html"> Load more </a>
						</div> -->
			</div>
		</div>
	</div>


	<!-- instagram posts -->
	@include('includes.instagram_posts')
	@include('includes.review')
</div>

<!-- Pincode modal -->
<div id="pincode-modal" class="container modal">
	<!-- Modal content -->
	<form action="{{ route('front.savepincode') }}" method="POST">
		@csrf
		<div class="modal-content">
			<span class="close" data-dismiss="modal" aria-label="Close" id="pincode_declined" h>&times;</span>
			<div class="text-center">
				<div class="pb-2 pt-2">
					<img src="{{asset('front/images/location.jpg')}}" />
				</div>
				<h4 class="pb-2">
					Please enter your pincode to proceed
				</h4>
				<div class="pb-2">
					<form>
						<i class="fa fa-map-marker markermin" aria-hidden="true"></i>
						<input name="pincode" maxlength="6" class="input mainfull" type="search" placeholder="Please Enter Pincode" autocomplete="off">
						<input class="submit" type="submit" value="Submit">
					</form>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection

@section('scripts')
<script src="{{ asset('front/js/extensions/lazyload/lazyload.js') }}"></script>




@if( ! Session::has('pincode') )
<script>
	$(document).ready(function() {
		setTimeout(() => {
			$('#pincode-modal').modal('show');
			$('.modal-backdrop').removeClass("modal-backdrop");
		}, 500);
	});
</script>

@endif
<script>
	$("body").lazyload();

	$(document).ready(function() {

		setTimeout(() => {
			$('#myModal').modal('show');
			// $('.modal-backdrop').removeClass("modal-backdrop");
		}, 1000);

		// Pincode decliend store in session
		$('#pincode_declined').click(function() {
			$.ajax({
				method: 'get',
				url: "{{ route('front.pincodedeclined') }}"
			})
		});

		$(document).on('click', '.banner-image-div', function() {
			window.location.href = $(this).data('href');
		});
	})
</script>
@endsection
