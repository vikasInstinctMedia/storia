@extends('layouts.front')

@section('style')
@if (isset($meta_title))
<meta name="title" content="{{ $meta_title }}">
<title>{{ $meta_title }}</title>
@else
<title>Storia Foods &#8211; Home</title>
@endif

@if (isset($meta_description))
<meta name="description" content="{{ $meta_description }}">
@else
<meta name="description" content="Storia Foods &#8211; Home">
@endif
<style>
	.section-bg-10 {
		background-image: url("{{ url('storage/'. $category->banner_image) }}");
	}
	/* .product_list_image {

	} */

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
</style>
@endsection
@section('content')

			<div id="main">
				<div class="section section-bg-10">
					<div class="container">
						<div class="row">

						</div>
					</div>
				</div>
				<!-- <div class="section border-bottom pt-2 pb-2">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<ul class="breadcrumbs">
									<li><a href="./">Home</a></li>
									<li><a href="./">Shop</a></li>
									<li>{{ $category->name }}</li>
								</ul>
							</div>
						</div>
					</div>
				</div> -->
				<div class="section pt-3 pb-3">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								{{--
								@include('includes.filter')
								--}}

								<div class="product-grid">
									@include('includes.product.filtered-products')
								</div>
							</div>
							{{--
								@include('includes.catalog')
							--}}
						</div>
					</div>
				</div>
			</div>

@endsection

@section('scripts')
<script>
	$(function() {
		$('.product_list_image').each(function() {
			$(this).href = $(this).href;
		});

		$('.product-item').each(function() {
			$(this).css('height', $(this).prev().outerHeight());
		});

	});
</script>

@endsection

