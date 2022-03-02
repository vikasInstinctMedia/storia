@extends('layouts.front')
@section('style')
<style>
	.centered {
		text-align: center;
		font-size: 0;
	}

	.centered>div {
		/* float: none; */
		display: inline-block;
		/* text-align: left; */
		font-size: 13px;
	}

    .plus img{
        width: 20px;
        vertical-align: middle;
    }

    .plus{
vertical-align: middle;
line-height: 12;
}
    .addtocard0 {
        color: #fff;
    background-color: #06904d;
    border-color: #06904d;
    padding: 10px 10px;
    font-size: 10px;
    border-radius: 3px;
}
.price-totals{
            font-size: 18px;
        }
</style>
@endsection

@section('content')
<div id="main" >

    <div class="text-center">
        Rediredcting........
    </div>
	<!-- <div class="section section-bg-10 pt-11 pb-17">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<h2 class="page-title text-center">Shop Detail</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="section border-bottom pt-2 pb-2">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ul class="breadcrumbs">
								<li><a href="./">Home</a></li>
								<li><a href="shortcodes.html">Shop</a></li>
								<li>Shop Detail</li>
							</ul>
						</div>
					</div>
				</div>
			</div> -->
	<div class="section pt-7 pb-7" style="display: none">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="single-productt">
						<div class="col-md-6">
							<div class="image-gallery">
								<div class="image-gallery-inner">
                                @if (!empty($product->images))
									@foreach($product->images as $image)
									<div>
										<div class="image-thumb">
											<a href="#" data-rel="prettyPhoto[gallery]">
												<img src="{{ asset('storage/'.$image->image) }}" alt="" />
											</a>
										</div>
									</div>
									@endforeach
                                @endif
								</div>
							</div>
							<div class="image-gallery-nav">
                                @if (isset($product->images) && !empty($product->images))

								@foreach($product->images as $image)
								<div class="image-nav-item">
									<div class="image-thumb">
										<img src="{{ asset('storage/'.$image->image) }}" alt="" height="100" width="100" />
									</div>
								</div>
								@endforeach

                                @endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="summary">
								<h3 class="product-title"> {{ ucwords($product->name) }} </h3>
								<!-- <div class="product-rating">
									<div class="star-rating">
										<span style="width:100%"></span>
									</div>
									<i>(2 customer reviews)</i>
								</div> -->
                                <div class="col-lg-12 col-xs-12 mt-2 bg-light pt-2 pb-2 mb-2" style="color: #000;">
                                    <div class="col-lg-12">
                                        <!-- <h3 class="product-title" style="color: #000;">{{ ucwords($product->name) }}</h3> -->
                                        <p class="fairfruit"></p>
                                    </div>
                                    @if($product->usp)
                                    <div class="col-lg-12">
                                        <!-- USP section -->
                                        <div class="mb-3 storiabrand" style="text-align:center">
                                            @if (isset($product->usp) && $product->usp != '')
                                            @foreach(json_decode($product->usp) as $usp)
                                            <div class="col-lg-3 col-md-3 col-xs-6 storaddf">
                                                <img src="{{ asset('storage/'. $usp->usp_icon) }}">
                                                <p>{{ ucwords($usp->usp) }}</p>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
								<div class="product-price pt-1 pb-1">
									{{--
											@if($product->price_without_discount)
											<del>₹{{ $product->price_without_discount }}</del>
									@endif
									--}}

                                    @if ($product->type == 'regular')
									<ins>₹ <span id="pack-price">{{ $product->base_pack_price }}</span></ins>
                                    @endif

                                    @if ($product->type == 'assorted')
                                    <ins>₹<span class="pack-price">{{ ($product->base_pack_price - $product->base_pack->discount) }}</span> </ins>
                                    @endif
								</div>
								<div class="mb-3 product-info summary1235">
									<p>{{ mb_convert_encoding($product->description, "UTF-8"); }}</p>
								</div>
								<form class="commerce-ordering karho">
									<select name="packs" class="packs pack-select" data-product-id="{{ $product->id }}" id="pack">
										@if (isset($product->packs) && !empty($product->packs))

                                        @foreach($product->packs as $pack)
										<option value="{{ $pack->id }}" {{ $loop->index == 0? 'selected':"" }}>{{ $pack->details->title }}</option>
										@endforeach

                                        @endif
									</select>
								</form>

								<form class="cart karho">
									<button id="in-stock" type="submit" class="single-add-to-cart add-to-cart add-to-cart-btn {{ !$product->base_pack->is_product_in_stock ? 'd-none' : '' }}" data-product-id="{{ $product->id }}">ADD TO CART</button>
									<span id="not-in-stock" class="ml-1 {{ !$product->base_pack->is_product_in_stock ? '' : 'd-none' }}"> out of stock</span>
									<!-- <div class="quantity-chooser">
												<div class="quantity">
													<span class="qty-minus" data-min="1"><i
															class="ion-ios-minus-outline"></i></span>
													<input type="text" name="quantity" value="1" title="Qty"
														class="input-text qty text" size="4">
													<span class="qty-plus" data-max=""><i
															class="ion-ios-plus-outline"></i></span>
												</div>
											</div> -->
								</form>



							</div>
						</div>







						@if($product->type == 'assorted')
						<div class="col-lg-12 col-xs-12 mt-2 bg-light pt-2 pb-2 mb-2" style="color: #000;">
							<div class="col-lg-12 mb-2">
								<h3 class="product-title text-center" style="color: #000;">Pack Contains</h3>

							</div>
							<div class="col-lg-12">
								<div class="mb-3 storiabrand text-center centered">
									@if (isset($product->includedProducts) && !empty($product->includedProducts))

                                    @foreach($product->includedProducts as $includedProduct)
									<div class="col-lg-2 col-md-2 col-xs-6">
										<img src="{{ asset('storage/'. $includedProduct->details->banner_image) }}" width="">
										<p>{{ ucwords($includedProduct->details->name) }}</p>
									</div>
									@endforeach

                                    @endif
								</div>
							</div>
						</div>
						@endif

                        <div class="col-lg-12 col-xs-12 mt-2 bg-dark pt-2 pb-2 mb-2" style="color: #fff;">
							<div class="col-lg-12">
								<h3 class="product-title text-center" style="color: #fff;">{{ $product->know_your_fruit_title }}</h3>
								<p class="fairfruit text-center">{{ $product->know_your_fruit_desc }}</p>
							</div>
							@if($product->fruiticons)
							<div class="col-lg-12">
								<div class="mb-3 storiabrand" style="text-align:center">
                                    @if (isset($product->fruiticons) && $product->fruiticons != '')
									@foreach(json_decode($product->fruiticons) as $fruiticon)
									<div class="col-lg-3 col-md-3 col-xs-6 storaddf">
										<img src="{{ asset('storage/'. $fruiticon->fruiticon_icon ) }}">
										<p>{{ $fruiticon->fruiticon }}</p>
									</div>
									@endforeach
                                    @endif
								</div>
							</div>
							@endif
						</div>
                        <div class="mt-5 mb-5">
                            <div class="row">
                                <div class="col-md-2 col-xs-3 p-0">
                                    <div class="">
                                        <img class="img-fluid" src="https://shop.storiafoods.com/demo/storia/public//storage/product/7tI6KOnaIIOLePHOkB5hxp4KY5LTc2KJp97kOHrx.jpg" style="">
                                    </div>
                                    <div class="text-center">
                                        text content
                                    </div>
                                </div>
                                <div class="col-md-1 col-xs-1 plus p-0"><img src="{{ asset('front/images/plus.png') }}" style=""></div>
                                <div class="col-md-2 col-xs-3 p-0">
                                    <div class="">
                                        <img class="img-fluid" src="https://shop.storiafoods.com/demo/storia/public//storage/product/7tI6KOnaIIOLePHOkB5hxp4KY5LTc2KJp97kOHrx.jpg" style="">
                                    </div>
                                    <div class="text-center">
                                        text content
                                    </div>
                                </div>
                                <div class="col-md-1 col-xs-1 plus p-0"><img src="{{ asset('front/images/plus.png') }}" style=""></div>
                                <div class="col-md-2 col-xs-3 p-0">
                                    <div class="">
                                        <img class="img-fluid" src="https://shop.storiafoods.com/demo/storia/public//storage/product/7tI6KOnaIIOLePHOkB5hxp4KY5LTc2KJp97kOHrx.jpg" style="">
                                    </div>
                                    <div class="text-center">
                                        text content
                                    </div>
                                </div>
                                <div class="col-md-1 col-xs-1 plus p-0"><img src="{{ asset('front/images/equal.png') }}" style=""></div>

                                <div class="col-md-2 col-xs-3 p-0 mt-5">
                                    <div class="text-center">
                                        <h3 class="price-totals">700 Rs.</h3>
                                    </div>
                                    <div class="text-center mt-5">
                                     <a href="#" class="addtocard0">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="col-lg-12">
							<div class="commerce-tabs tabs classic">
								<ul class="nav nav-tabs tabs mb-4">
                                    <li class="active">
										<a data-toggle="tab" href="#tab-ingredients" aria-expanded="false">Ingredients</a>
									</li>
                                    <li class="">
										<a data-toggle="tab" href="#tab-nutriation" aria-expanded="false">Nutriation</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-description" aria-expanded="true">FAQs</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-reviews" aria-expanded="false">Reviews</a>
									</li>
								</ul>
								<div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab-ingredients">
                                        @if($product->ingredients)
                                        <div class="col-lg-12 col-xs-12 mt-2  mb-2" style="color: #000;">
                                            <div class="col-lg-4 prodingf">
                                                <h3 class="product-title">Ingredients</h3>
                                                <!-- <p class="fairfruit text-center">Equivalent to 100% fruit Juice</p> -->
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="notebook-paper mb-3 mt-3">
                                                   <p>line 1</p>
                                                   <p>line 1</p>
                                                   <p>line 1</p>
                                                </div>

                                                <div class="mt-3 storiabrand  centered">
                                                    @if (isset($product->ingredients) && $product->ingredients != '')

                                                    @foreach(json_decode($product->ingredients) as $ingredient)
                                                    <div class="col-lg-4 col-md-4 col-xs-6 storaddf">
                                                        <img src="{{ asset('storage/'. $ingredient->ingredient_icon ) }}">
                                                        <p>{{ ucwords($ingredient->ingredient) }}</p>
                                                    </div>
                                                    @endforeach

                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade " id="tab-nutriation">
                                        @if($product->nutritional_information_json)
                                        <div class="col-lg-12 col-xs-12 mt-2 pt-2 pb-2 mb-2">
                                            <h3 class="product-title text-center" style="color: #000;">Nutritional Information</h3>

                                            <div class="product-info">
                                                <table class="blueTable">
                                                    <tbody>
                                                        @if (isset($product->nutritional_information_json) && $product->nutritional_information_json != '')

                                                        @foreach(json_decode($product->nutritional_information_json) as $title => $value)
                                                        <tr>
                                                            <td>{{ $title }}</td>
                                                            <td>{{ $value }}</td>
                                                        </tr>
                                                        @endforeach

                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                        @endif
                                    </div>


									<div id="tab-reviews" class="tab-pane fade">
										<!-- <div class="single-comments-list mt-0">
											<div class="mb-2">
												<h4 class="comment-title">2 reviews for NIMBU PANI</h4>
											</div>
											<ul class="comment-list">
												<li>
													<div class="comment-container">
														<div class="comment-author-vcard">
															<img alt="" src="images/avatar/avatar_100x100.jpg" />
														</div>
														<div class="comment-author-info">
															<span class="comment-author-name">admin</span>
															<a href="#" class="comment-date">July 27, 2016</a>
															<p>Far far away, behind the word mountains, far from
																the countries Vokalia and Consonantia, there
																live the blind texts. Separated they live in
																Bookmarksgrove right at the coast of the
																Semantics, a large language ocean. A small river
																named Duden flows by their place and supplies it
																with the necessary regelialia.</p>
														</div>
														<div class="reply">
															<a class="comment-reply-link" href="#">Reply</a>
														</div>
													</div>
													<ul class="children">
														<li>
															<div class="comment-container">
																<div class="comment-author-vcard">
																	<img alt="" src="images/avatar/avatar_100x100.jpg" />
																</div>
																<div class="comment-author-info">
																	<span class="comment-author-name">admin</span>
																	<a href="#" class="comment-date">July 27,
																		2016</a>
																	<p>Far far away, behind the word mountains,
																		far from the countries Vokalia and
																		Consonantia, there live the blind texts.
																		Separated they live in Bookmarksgrove
																		right at the coast of the Semantics, a
																		large language ocean. A small river
																		named Duden flows by their place and
																		supplies it with the necessary
																		regelialia.</p>
																</div>
																<div class="reply">
																	<a class="comment-reply-link" href="#">Reply</a>
																</div>
															</div>
														</li>
													</ul>
												</li>
												<li>
													<div class="comment-container">
														<div class="comment-author-vcard">
															<img alt="" src="images/avatar/avatar_100x100.jpg" />
														</div>
														<div class="comment-author-info">
															<span class="comment-author-name">admin</span>
															<a href="#" class="comment-date">July 27, 2016</a>
															<p>Far far away, behind the word mountains, far from
																the countries Vokalia and Consonantia, there
																live the blind texts. Separated they live in
																Bookmarksgrove right at the coast of the
																Semantics, a large language ocean. A small river
																named Duden flows by their place and supplies it
																with the necessary regelialia.</p>
														</div>
														<div class="reply">
															<a class="comment-reply-link" href="#">Reply</a>
														</div>
													</div>
												</li>
											</ul>
										</div>
										<div class="single-comment-form mt-0">
											<div class="mb-2">
												<h4 class="comment-title">LEAVE A REPLY</h4>
											</div>
											<form class="comment-form">
												<div class="row">
													<div class="col-md-12">
														<textarea id="comment" name="comment" cols="45" rows="5" placeholder="Message *"></textarea>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4">
														<input id="author" name="author" type="text" value="" size="30" placeholder="Name *" class="mb-2">
													</div>
													<div class="col-md-4">
														<input id="email" name="email" type="email" value="" size="30" placeholder="Email *" class="mb-2">
													</div>
													<div class="col-md-4">
														<input id="url" name="url" type="text" value="" placeholder="Website">
													</div>
												</div>
												<div class="row">
													<div class="col-md-2">
														<input name="submit" type="submit" id="submit" class="btn btn-alt btn-border" value="Submit">
													</div>
												</div>
											</form>
										</div> -->
									</div>
								</div>
							</div>
							</div>
                            <div class="col-lg-12">
                                <div class="related" >
                                    <div class="related mt-5" >
                                        <div class="related-title">
                                            <h2 class="text-center section-title mtn-2 fz-24">Recommended Products</h2>
                                        </div>
                                        {{-- <div class="product-carousel p-0" data-auto-play="true" data-desktop="3" data-laptop="2" data-tablet="2" data-mobile="1">
                                            <div class="product-item text-center">
                                                <div class="product-thumb">
                                                    <a href="shop-detail.html">
                                                        <img src="{{ asset('storage/'.$image->image) }}" alt="" />
                                                    </a>
                                                    <div class="product-action">
                                                        <span class="add-to-cart">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                        </span>
                                                        <span class="wishlist">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to wishlist"></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <a href="shop-detail.html">
                                                        <h2 class="title">100% Juice- Pineapple</h2>
                                                        <span class="price">₹160.00</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-item text-center">
                                                <div class="product-thumb">
                                                    <a href="shop-detail.html">
                                                        <img src="{{ asset('storage/'.$image->image) }}" alt="" />
                                                    </a>
                                                    <div class="product-action">
                                                        <span class="add-to-cart">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                        </span>
                                                        <span class="wishlist">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to wishlist"></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <a href="shop-detail.html">
                                                        <h2 class="title">100% Juice- Pineapple</h2>
                                                        <span class="price">₹160.00</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-item text-center">
                                                <div class="product-thumb">
                                                    <a href="shop-detail.html">
                                                        <img src="{{ asset('storage/'.$image->image) }}" alt="" />
                                                    </a>
                                                    <div class="product-action">
                                                        <span class="add-to-cart">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                        </span>
                                                        <span class="wishlist">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to wishlist"></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <a href="shop-detail.html">
                                                        <h2 class="title">100% Juice- Pineapple</h2>
                                                        <span class="price">₹160.00</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-item text-center">
                                                <div class="product-thumb">
                                                    <a href="shop-detail.html">
                                                        <img src="{{ asset('storage/'.$image->image) }}" alt="" />
                                                    </a>
                                                    <div class="product-action">
                                                        <span class="add-to-cart">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                        </span>
                                                        <span class="wishlist">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to wishlist"></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <a href="shop-detail.html">
                                                        <h2 class="title">100% Juice- Pineapple</h2>
                                                        <span class="price">₹160.00</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-item text-center">
                                                <div class="product-thumb">
                                                    <a href="shop-detail.html">
                                                        <img src="{{ asset('storage/'.$image->image) }}" alt="" />
                                                    </a>
                                                    <div class="product-action">
                                                        <span class="add-to-cart">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                        </span>
                                                        <span class="wishlist">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to wishlist"></a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <a href="shop-detail.html">
                                                        <h2 class="title">100% Juice- Pineapple</h2>
                                                        <span class="price">₹160.00</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				{{-- @include('includes.catalog') --}}
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

<script>
	$('.slider').slick({
		arrows: false
	});

	$(function() {
		var product = "{{ json_encode( $product->only([ 'name', 'base_pack', 'base_pack_price' ]) ) }}";
		product = product.replace( /&quot;/g, '"' ),
		product = JSON.parse( product );
		product.pack_id = product.base_pack.id;
		product.pack_price = product.base_pack_price;
		// console.log(product);

		analytics.productDetailsImpression(product);

	});


</script>
<script>

// document.getElementsByClassName("add-to-cart").click();
setTimeout(function(){

    $('.add-to-cart').click();
    // alert("Hello");
    // window.location = "{{ url('/cart') }}";
}, 1000);


setTimeout(function(){

// $('.add-to-cart').click();
// alert("Hello");
window.location = "{{ url('/cart') }}";
}, 4000);
</script>
@endsection
