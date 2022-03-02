@extends('layouts.front')
@section('style')
<style>
	.centered {
		text-align: center;
		font-size: 0;
	}

	.centered>div {
		display: inline-block;
		font-size: 13px;
		margin: 0px 40px;
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
    padding: 10px 20px;
    font-size: 13px;
    border-radius: 3px;
    font-weight:bold;
    letter-spacing:1px;
    text-transform:uppercase;
}


.price-totals{
            font-size: 25px;
        }
        .d-inline1{
               display: inline-block;
                vertical-align: middle;
                padding-right: 10px;
        }
        .summercontent{
            padding: 0!important;
            margin: 13px 0px;
           font-size: 14px;
        }
     .pack-select{
    height: 40px!important;
}
.Frequently{
    font-size:25px;
}

@media (max-width:320px)  {
    .ing_width{
        width: 50% !important;
    }
    .product-titleteza{
        font-size: 23px !important;
    }
    .nut_small_pad{
        padding: 0px 3px 0px 2px !important;
    }

    .storiabrand{
        padding-left : 36px;
    }

    .centered>div {
		display: inline-block;
		font-size: 10px;
		margin: 0px 40px;
	}
    .pack_img{
        height: 106px;
    max-width: 99px !important;
    margin-left: -10px;
    }
 }
@media (max-width:480px)  {
    .ing_width{
        width: 50% !important;
    }
    .product-titleteza{
        font-size: 23px !important;
    }

    .nut_small_pad{
        padding: 0px 3px 0px 2px !important;
    }

    .storiabrand{
        padding-left : 36px;
    }
    .centered>div {
		display: inline-block;
		font-size: 10px;
		margin: 0px 40px;
	}

    .pack_img{
        height: 106px;
    max-width: 99px !important;
    margin-left: -10px;
    }
 }
</style>

@php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
@endphp

<meta property="og:title" content="{{ $product->name }}">
<meta property="og:description" content="{{ $product->description }}">
<meta property="og:url" content="{{ $actual_link }}">
<meta property="og:image" content="{{ asset('storage/'.$product->banner_image) }}">
<meta property="product:brand" content="Storia">
<meta property="product:availability" content="{{ !$product->base_pack->is_product_in_stock ? 'Out Of Stock' : 'In Stock' }}">
<meta property="product:condition" content="new">

@if ($product->type == 'regular')
<meta property="product:price:amount" content="{{ $showrpice =  $product->base_pack_price }}">
@endif

@if ($product->type == 'assorted')
<meta property="product:price:amount" content="{{ $showrpice = ($product->base_pack_price - $product->base_pack->discount) }}">
@endif
<meta property="product:price:currency" content="INR">
@if (isset($product->packs) && !empty($product->packs))
@php
    $i = 1;
@endphp
@foreach($product->packs as $pack)
    @php
        if($i > 1){
            continue;
        }
        $i++;
    @endphp
<meta property="product:retailer_item_id" content="{{ $skushow = $pack->sku }}">
@endforeach
@endif
<meta property="product:item_group_id" content="{{ $product->slug }}">

@endsection

@section('content')

<div itemscope itemtype="http://schema.org/Product">
    <meta itemprop="brand" content="Storia">
    <meta itemprop="name" content="{{ $product->name }}">
    <meta itemprop="description" content="{{ $product->description }}">
    <meta itemprop="productID" content="{{ $skushow }}">
    <meta itemprop="url" content="{{ $actual_link }}">
    <meta itemprop="image" content="{{ asset('storage/'.$product->banner_image) }}">
    <div itemprop="value" itemscope itemtype="http://schema.org/PropertyValue">
      <span itemprop="propertyID" content="item_group_id"></span>
      <meta itemprop="value" content="{{ $product->slug }}"></meta>
    </div>
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
      <link itemprop="availability" href="http://schema.org/{{ !$product->base_pack->is_product_in_stock ? 'OutOfStock' : 'InStock' }}">
      <link itemprop="itemCondition" href="http://schema.org/NewCondition">
      <meta itemprop="price" content="{{ $showrpice }}">
      <meta itemprop="priceCurrency" content="INR">
    </div>
  </div>
<div id="main">
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
	<div class="section pb-7">
		<div class="container">
			<div class="row">

					<div class="single-productt">
						<div class="col-md-5">
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

						<div class="col-md-7">
							<div class="summary">

								<!-- <div class="product-rating">
									<div class="star-rating">
										<span style="width:100%"></span>
									</div>
									<i>(2 customer reviews)</i>
								</div> -->
								<div class="col-md-12 col-xs-12 mb-3">
								     <h4 class="product-title product-titleteza"> {{ ucwords($product->name) }} </h4>
								</div>
                               <div class="col-md-12 col-xs-12 mb-2">
                                    @if($product->usp)
                                        <!-- USP section -->
                                        <div class="">
                                            @if (isset($product->usp) && $product->usp != '')
                                            @foreach(json_decode($product->usp) as $usp)
                                            <div class="col-md-2 col-xs-6 storaddf456 p-0 text-center">
                                                <div class="jenod1">
                                                    <img src="{{ asset('storage/'. $usp->usp_icon) }}">
                                                </div>
                                                <div class="jenod2">
                                                    <p class="summercontent">{{ ucwords($usp->usp) }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    @endif
                                </div>

								<div class="col-md-12 col-xs-12 product-price  mb-4" style="z-index: 1111">
								    <div class="d-inline1">
    									{{--
    											@if($product->price_without_discount)
    											<del>₹{{ $product->price_without_discount }}</del>
    									@endif
    									--}}

                                        @if ($product->type == 'regular')
    									<ins>₹ <span id="pack-price" class="pack-price-main">{{ $product->base_pack_price }}</span></ins>
                                        @endif

                                        @if ($product->type == 'assorted')
                                        <ins>₹<span class="pack-price" class="pack-price-main">{{ ($product->base_pack_price - $product->base_pack->discount) }}</span> </ins>
                                        @endif
                                    </div>

                                    <div class="d-inline1">
                                        <form class="commerce-ordering karho">
        									<select name="packs" class="packs pack-select" data-product-id="{{ $product->id }}" id="pack" data-list="1">
        										@if (isset($product->packs) && !empty($product->packs))

                                                @foreach($product->packs as $pack)
        										<option value="{{ $pack->id }}" {{ $loop->index == 0? 'selected':"" }}>{{ $pack->details->title }}
                                                </option>
        										@endforeach

                                                @endif
        									</select>
    								    </form>
								    </div>

                                    <div class="d-inline1">
                                        <form class="cart karho">
									<button id="in-stock" type="submit" class="single-add-to-cart add-to-cart add-to-cart-btn btn-md {{ !$product->base_pack->is_product_in_stock ? 'd-none' : '' }}" data-product-id="{{ $product->id }}">ADD TO CART</button>
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

								<div class="col-lg-12 product-info summary1235">
									<p>{{ mb_convert_encoding($product->description, "UTF-8"); }}</p>
								</div>


							</div>
						</div>

						@if($product->type == 'assorted')
						<div class="" style="color: #000;">
							<div class="col-lg-12 mb-2">
								<h3 class="product-title text-center" style="color: #000;">Pack Contains</h3>

							</div>
							<div class="col-lg-12">
								<div class="mb-3 storiabrand text-center centered">
									@if (isset($product->includedProducts) && !empty($product->includedProducts))

                                    @foreach($product->includedProducts as $includedProduct)
									<div class="col-lg-2 col-md-2 col-xs-4">
										<img src="{{ asset('storage/'. $includedProduct->details->banner_image) }}" class="pack_img" width="" style="">
										<p>{{ ucwords($includedProduct->details->name) }}</p>
									</div>
									@endforeach

                                    @endif
								</div>
							</div>
						</div>
						@endif
                        @if (isset($product_freq))

                        <div class="col-lg-12 col-xs-12 mt-2 pt-2 pb-2 mb-2" style="z-index: 1111;">
                            	<h3 class="product-title text-left pb-4 Frequently">Frequently Bought Together</h3>
                                @php
                                    $price_feq_final = 0;
                                    $cnt = count($product_freq);
                                @endphp
                                @php
                                    $k = 1;
                                    $k2 = 0;
                                @endphp
                                @foreach ($product_freq as $rec_2)

                                <div class="storiafoodscountermain" style="width:25%">
                                    <div class="storiafoodscounter">
                                        <img class="img-fluid" src="{{asset('storage/'.$rec_2->banner_image)}}" >
                                    </div>
                                    <div class="storiafoodscounter1">

                                        <div class="col-md-12 col-xs-12 product-price  mb-4 product-item" style="display: none;z-index:1111">
                                            <div class="d-inline1">
                                                {{--
                                                        @if($product->price_without_discount)
                                                        <del>₹{{ $product->price_without_discount }}</del>
                                                @endif
                                                --}}

                                                @if ($rec_2->type == 'regular')
                                                <ins>₹ <span id="pack-price">{{ $rec_2->base_pack_price }}</span></ins>
                                                @endif

                                                @if ($rec_2->type == 'assorted')
                                                <ins>₹<span class="pack-price">{{ ($rec_2->base_pack_price - $rec_2->base_pack->discount) }}</span> </ins>
                                                @endif
                                            </div>

                                            <div class="d-inline1">
                                                <form class="commerce-ordering karho">
                                                    @php
                                                        $freq_pack = '';
                                                    @endphp
                                                    <select name="packs" class="packs pack-select" data-product-id="{{ $rec_2->id }}" id="">
                                                        @if (isset($rec_2->packs) && !empty($rec_2->packs))
                                                        @php
                                                            $fq = 0;
                                                        @endphp
                                                        @foreach($rec_2->packs as $pack_2)
                                                        @php
                                                            if($fq == 0){
                                                                $freq_pack = $pack_2->details->title;
                                                            }
                                                        @endphp
                                                        <option value="{{ $pack_2->id }}" {{ $loop->index == 0? 'selected':"" }}>{{ $pack_2->details->title }}</option>
                                                        @php
                                                            $fq++;
                                                        @endphp
                                                        @endforeach

                                                        @endif
                                                    </select>
                                                </form>
                                            </div>

                                            <div class="d-inline1 feq_add_cart_buttons">
                                                <form class="cart karho">
                                            <button id="in-stock" type="submit" class="single-add-to-cart cart_btn_js_{{ $k }} add-to-cart add-to-cart-btn btn-md {{ !$rec_2->base_pack->is_product_in_stock ? 'd-none' : '' }}" data-product-id="{{ $rec_2->id }}" data-pk="feq">ADD TO CART</button>
                                            <span id="not-in-stock" class="ml-1 {{ !$rec_2->base_pack->is_product_in_stock ? '' : 'd-none' }}"> out of stock</span>
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

                                        {{ $rec_2->name }}-{{ $freq_pack }}

                                        @php
                                        if ($rec_2->type == 'regular')
    									{
                                            $price_frq = $rec_2->base_pack_price;
                                        }

                                        if ($rec_2->type == 'assorted')
    									{
                                            $price_frq = ($rec_2->base_pack_price - $rec_2->base_pack->discount);
                                        }

                                        $price_feq_final = $price_feq_final + $price_frq;
                                        @endphp
                                    </div>
                                </div>



                                @if ($k == $cnt)
                                <div class="storiafoodscounter3"><img src="{{ asset('front/images/equal.png') }}" style=""></div>
                                @else
                                <div class="storiafoodscounter3"><img src="{{ asset('front/images/plus.png') }}" style=""></div>
                                @endif
                                @php
                                $k++;
                                $k2++;
                            @endphp
                            @endforeach

                                <div class="storiafoodscountermain storiafoodscountermain123">
                                    <div class="text-center">
                                        <h3 class="price-totals">₹ {{ $price_feq_final }}</h3>
                                    </div>
                                    <div class="text-center addtocardsdsdsd">
                                     <a href="javascript:void(0)" class="addtocard0 freq_add_cart_main">Add to cart</a>
                                    </div>
                                </div>
                        </div>

                        @endif

                        <div class="col-lg-12 col-xs-12 bg-dark pt-2 pb-2 mb-2 mt-2" >
							<h3 class="product-title redi">{{ $product->know_your_fruit_title }}</h3>
							<p class="fairfruit redi">{{ $product->know_your_fruit_desc }}</p>
							@if($product->fruiticons)
                                    @if (isset($product->fruiticons) && $product->fruiticons != '')
									@foreach(json_decode($product->fruiticons) as $fruiticon)
									<div class="col-lg-3 col-md-3 col-xs-6 storaddf">
										<img src="{{ asset('storage/'. $fruiticon->fruiticon_icon ) }}">
										<p class="redi">{{ $fruiticon->fruiticon }}</p>
									</div>
									@endforeach
                                    @endif
							@endif
						</div>

						<div class="col-lg-12 mt-2">
							<div class="commerce-tabs tabs classic">
								<ul class="nav nav-tabs tabs mb-1">
                                    @if ($product->type == 'regular')
                                    {{-- <li class="">
										<a data-toggle="tab" href="#tab-ingredients" aria-expanded="false">Ingredients</a>
									</li> --}}
                                    @endif
                                    <li class="@if($product->type == 'assorted')
                                        active
                                        @endif active">
										<a data-toggle="tab" href="#tab-nutriation" aria-expanded="false">Nutrition / Ingredients</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-description" aria-expanded="true">FAQs</a>
									</li>
									<li class="">
										<a data-toggle="tab" href="#tab-reviews" aria-expanded="false">Reviews</a>
									</li>
								</ul>
								<div class="tab-content">
                                    @if ($product->type == 'regular')
                                    <div class="tab-pane fade" id="tab-ingredients">
                                        @if($product->ingredients)
                                        <div class="col-lg-12 col-xs-12 mt-2  mb-2" style="color: #000;">
                                            <div class="col-lg-4 prodingf  p-0">
                                                <h3 class="product-title">Ingredients</h3>
                                                <!-- <p class="fairfruit text-center">Equivalent to 100% fruit Juice</p> -->
                                            </div>
                                            <div class="col-lg-8 p-0">
                                              <table class="blueTable">
                                                <tbody>
                                                    {{-- @if (isset($product->ingredients) && $product->ingredients != '')

                                                    @foreach(json_decode($product->ingredients) as $ingredient)
                                                    <tr>
                                                <td class="celling"> <img src="{{ asset('storage/'. $ingredient->ingredient_icon ) }}" style="width: 5%">{{ ucwords($ingredient->ingredient) }}</td>
                                             </tr>
                                             @endforeach

                                             @endif --}}

                                             @if (isset($product->ingredients) && $product->ingredients != '')

                                             @foreach(json_decode($product->ingredients) as $ingredient)

                                             <tr>
                                                <td class="celling"> <img src="{{ asset('storage/'. $ingredient->ingredient_icon ) }}" width="10%">
                                                   <label style="margin-top: 23px;font-weight: 100;margin-left:23px"> {{ ucwords($ingredient->ingredient) }} </label>
                                                </td>
                                             </tr>


                                             @endforeach

                                             @endif


{{--
                                                 <tr>
                                                <td class="celling"><div class="centered">
                                                    @if (isset($product->ingredients) && $product->ingredients != '')

                                                    @foreach(json_decode($product->ingredients) as $ingredient)
                                                    <div class="assetstossdsd45dsjd">
                                                        <img src="{{ asset('storage/'. $ingredient->ingredient_icon ) }}">
                                                        <p>{{ ucwords($ingredient->ingredient) }}</p>
                                                    </div>
                                                    @endforeach

                                                    @endif
                                                </div></td>
                                                </tr> --}}
                                                </tbody>
                                                </table>


                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    <div class="tab-pane fade @if($product->type == 'assorted')
                                        active in
                                        @endif active in" id="tab-nutriation">
                                        @if($product->nutritional_information_json)
                                        <div class="row" style="    border: 1px solid #d1d1d1;
                                        margin-left: 1px;
                                        margin-right: 1px;
                                        padding: 16px 0px 27px 0px;">
                                        <div class="col-lg-6 col-xs-6 nut_small_pad" style="border-right: 1px solid #d1d1d1;    padding: 0px 12px 0px 12px; min-height:449px">
                                            <h3 class="product-title text-center" style="color: #000;">Nutritional Information</h3>

                                            <div class="product-info">
                                                <table class="blueTable" style="background-color: white;">
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

                                        <div class="col-lg-6 col-xs-6" style=" ">
                                            <h3 class="product-title text-center" style="color: #000;">Ingredients</h3>

                                            <div class="product-info">
                                                <table class="blueTable" style="background-color: white;">
                                                    <tbody>
                                                        {{-- @if (isset($product->ingredients) && $product->ingredients != '')

                                                        @foreach(json_decode($product->ingredients) as $ingredient)
                                                        <tr>
                                                    <td class="celling"> <img src="{{ asset('storage/'. $ingredient->ingredient_icon ) }}" style="width: 5%">{{ ucwords($ingredient->ingredient) }}</td>
                                                 </tr>
                                                 @endforeach

                                                 @endif --}}

                                                 @if (isset($product->ingredients) && $product->ingredients != '')

                                                 @foreach(json_decode($product->ingredients) as $ingredient)

                                                 <tr>
                                                    <td class="celling"> <img src="{{ asset('storage/'. $ingredient->ingredient_icon ) }}" class="ing_width" width="10%">
                                                       <p style=""> {{ ucwords($ingredient->ingredient) }} </p>
                                                    </td>
                                                 </tr>


                                                 @endforeach

                                                 @endif


                                                         {{--
                                                     <tr>
                                                    <td class="celling"><div class="centered">
                                                        @if (isset($product->ingredients) && $product->ingredients != '')

                                                        @foreach(json_decode($product->ingredients) as $ingredient)
                                                        <div class="assetstossdsd45dsjd">
                                                            <img src="{{ asset('storage/'. $ingredient->ingredient_icon ) }}">
                                                            <p>{{ ucwords($ingredient->ingredient) }}</p>
                                                        </div>
                                                        @endforeach

                                                        @endif
                                                    </div></td>
                                                    </tr> --}}
                                                    </tbody>
                                                    </table>

                                            </div>


                                        </div>
                                        </div>
                                        @endif
                                    </div>

									<div class="tab-pane fade " id="tab-description">
										<div class="col-sm-12 bg-light">
											<div class="accordion icon-default icon-right" id="accordion3">

												@forelse($faqs as $faq)

												<div class="accordion-group toggle">
													<div class="accordion-heading toggle_title">
														<a class="accordion-toggle" data-toggle="collapse" aria-expanded="true" aria-controls="collapse{{ $faq->id }}" href="#collapse{{ $faq->id }}">
															{!! $faq->question !!}
														</a>
														<span class="icon"><i class="ion-plus-circled icon_data"></i></span>
													</div>
													<div id="collapse{{ $faq->id }}" class="bg-light accordion-body collapse ">
														<div class="accordion-inner">
															<p>
																{!! $faq->answer !!}
															</p>
														</div>
													</div>
												</div>

												@empty

												@endif

											</div>
										</div>
									</div>
									<div id="tab-reviews" class="tab-pane fade">
                                        <div class="single-comments-list mt-0">
                                           <div class="mb-2">
                                               @php
                                                   $review = \App\Models\Review::where('product_id',$product->id)->where('status', 1)->get();
                                               @endphp
                                               <h4 class="comment-title" style="margin-top: 20px">Total {{ count($review) }} Reviews For {{ ucwords($product->name) }}</h4>
                                           </div>
                                           <ul class="comment-list">
                                               @foreach($review as $key)
                                               <li>
                                                   <div class="comment-container">
                                                       <div class="comment-author-vcard">
                                                           <img alt="" src="{{ asset('front/images/user-default.png') }}" />
                                                       </div>
                                                       <div class="comment-author-info">
                                                           @php
                                                               if($key->user_id!=null){
                                                                   $user =\App\Models\User::where('id', $key->user_id)->get();
                                                                   $name='';
                                                                   foreach($user as $key1=>$value){
                                                                       $name=$value->name;
                                                                   }
                                                               }else{
                                                                   $name="Guest";
                                                               }
                                                           @endphp
                                                           <span class="comment-author-name" style="font-size: 18px">{{ $key->author }}</span>
                                                           <a href="#" class="comment-date">{{ date('M d, Y', strtotime($key->created_at)) }}</a>
                                                           <p>{{ $key->comment }}.</p>
                                                       </div>
                                                       {{-- <div class="reply">
                                                           <a class="comment-reply-link" href="#">Reply</a>
                                                       </div> --}}
                                                   </div>
                                                   @php
                                                       $review_reply = \App\Models\Review_reply::where('review_id', $key->id)->get();
                                                   @endphp
                                                   <ul class="children" style="list-style: none;">
                                                       @foreach($review_reply as $reply)
                                                       <li>
                                                           <div class="comment-container">
                                                               <div class="comment-author-vcard">
                                                                   <img alt="" src="{{ asset('front/images/user-default.png') }}" />
                                                               </div>
                                                               <div class="comment-author-info">
                                                                   <span class="comment-author-name" style="font-size: 18px">admin</span>
                                                                   <a href="#" class="comment-date">{{ date('M d, Y', strtotime($reply->created_at)) }}</a>
                                                                   <p>{{ $reply->reply }}.</p>
                                                               </div>
                                                               {{-- <div class="reply">
                                                                   <a class="comment-reply-link" href="#">Reply</a>
                                                               </div> --}}
                                                           </div>
                                                       </li>
                                                       @endforeach
                                                   </ul>
                                               </li>
                                               @endforeach
                                           </ul>
                                       </div>
                                       <div class="single-comment-form mt-0">
                                           <div class="mb-2">
                                               <h4 class="comment-title">WRITE A REVIEW</h4>
                                           </div>
                                           <form class="comment-form" id="productReview" action="{{ route('reviewAdd') }}" method="post" style="position: relative;z-index: 1;">
                                               @csrf
                                               <div class="row">
                                                   <div class="col-md-12">
                                                       <textarea id="comment" name="comment" cols="45" rows="5" placeholder="Message *" required></textarea>
                                                   </div>
                                               </div>
                                               <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                               <input type="hidden" name="user_id" id="user_id" value="{{ Auth::check() ? Auth::user()->id : '' }}">
                                               <div class="row">
                                                   <div class="col-md-4">
                                                       <input id="author" name="author" type="text" value="{{ Auth::check() ? Auth::user()->name : '' }}" size="30" placeholder="Name *" class="mb-2" required>
                                                   </div>
                                                   <div class="col-md-4">
                                                       <input id="email" name="email" type="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" size="30" placeholder="Email *" class="mb-2" required>
                                                   </div>
                                                   <div class="col-md-4">
                                                       {{-- <input id="url" name="url" type="text" value="" placeholder="Website" > --}}
                                                   </div>
                                               </div>
                                               <div class="row">
                                                   <div class="col-md-2">
                                                       <input name="submit" type="submit" id="submit" class="btn btn-alt btn-border" value="Submit">
                                                   </div>
                                               </div>
                                           </form>
                                       </div>
                                   </div>
								</div>
							</div>
						</div>
                                    @if (isset($prods_new))

					            	<div class="col-lg-12 mt-2" style="margin-top: 40px !important">
                                        <div class="related-title">
                                            <h4 class="text-center section-title">Recommended Products</h4>
                                        </div>
                                        <div class="product-carousel p-0" data-auto-play="true" data-desktop="3" data-laptop="2" data-tablet="2" data-mobile="1">
                                            @foreach ($prods_new as $rec)
                                            @php
                                                if($category_id == 1)
                                                {
                                                    $show_array = [1,2,3,4,9];
                                                }elseif ($category_id == 2) {
                                                    $show_array = [13,14,16,18];
                                                }

                                                if (($key = array_search($product->id, $show_array)) !== false) {
                                                    unset($show_array[$key]);
                                                }
                                            @endphp

                                             @if (in_array($rec->id, $show_array))


                                            <div class="product-item text-center">
                                                <div class="product-thumb">
                                                    <a href="{{ route('front.category',  $rec->slug ) }}">
                                                        <img src="{{asset('storage/'.$rec->banner_image)}}" alt="" />
                                                    </a>
                                                    {{-- <div class="product-action">
                                                        <span class="add-to-cart add-to-cart-btn in-stock {{ !$rec->base_pack->is_product_in_stock ? 'd-none' : '' }} " data-page="listing" data-product-id="{{ $rec->id }}">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                        </span>

                                                    </div> --}}
                                                </div>
                                                <div class="product-info">
                                                    <form class="commerce-ordering" >
                                                        <select name="packs" class="pack-select" data-product-id="{{ $rec->id }}">

                                                            @foreach($rec->packs as $pack)
                                                                <option value="{{ $pack->id }}"> {{ $pack->details->title }} </option>
                                                            @endforeach

                                                        </select>
                                                    </form>

                                                    <div class="add-to-cart add-to-cart-btn in-stock {{ !$rec->base_pack->is_product_in_stock ? 'd-none' : '' }} " data-page="listing" data-product-id="{{ $rec->id }}" style="    background-color: #06904d;padding: 7px 0px 7px 0px;">

                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart" style="color: white;">  <i class="fa fa-shopping-bag" aria-hidden="true" style="padding-right: 15px;"></i>Add To Cart</a>
                                                    </div>

                                                    <div class="not-in-stock {{ !$rec->base_pack->is_product_in_stock ? '' : 'd-none' }}"  style="background-color: #06904d;
                                                        padding: 7px 0px 7px 0px;
                                                        color: white;
                                                    ">
                                                        <span>Out of stock</span>
                                                    </div>

                                                    <a href="{{ route('front.category',  $rec->slug ) }}">
                                                        <h2 class="title">{{ $rec->name }}</h2>
                                                        <span class="price">
                                                            @if ($rec->type == 'regular')
                                                            @if( $rec->base_pack_price_without_discount != $rec->base_pack_price )
                                                            <del>₹<span class="pack-discount-price">{{ $rec->base_pack_price_without_discount }}</span></del>
                                                             @endif
                                                             <ins>₹<span class="pack-price">{{ $rec->base_pack_price }}</span> </ins>
                                                            @endif

                                                            @if ($rec->type == 'assorted')
                                                            @if( $rec->base_pack_price != ($rec->base_pack_price - $rec->base_pack->discount) )
                                                            <del>₹<span class="pack-discount-price">{{ $rec->base_pack_price_without_discount }}</span></del>
                                                             @endif
                                                            <ins>₹<span class="pack-price">{{ ($rec->base_pack_price - $rec->base_pack->discount) }}</span> </ins>
                                                            @endif
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>


                                            @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    @endif
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
    // myTimer(i);
    $(document.body).on('click','.freq_add_cart_main',function(){
        // $('.feq_add_cart_buttons').find('.add-to-cart').click();
        var divs = document.querySelectorAll('.feq_add_cart_buttons .add-to-cart');
        var i = 1;
        var divLength = divs.length;
        // console.log("here something");
        var cart_main_interval  = setInterval(function() {
            // divs[i].click();s
            if(i >= divLength){
                clearInterval(cart_main_interval);
            }
        // console.info(i);
        $('.cart_btn_js_'+i).closest('.feq_add_cart_buttons').find('.add-to-cart').click();
        i++;
        }, 100);
    });

    $(document).on('click','.icon_data',function(){
       var accordion_group =  $(this).closest('.accordion-group');
       $(accordion_group).find('a').click();

        var toggle_title = $(accordion_group).find('.toggle_title');

        // alert($(toggle_title).hasClass('active'));

        if($(this).hasClass('ion-minus-circled') == true){

            $(this).addClass('ion-plus-circled');
            $(this).removeClass('ion-minus-circled');
        }else{

            $(this).addClass('ion-minus-circled');
            $(this).removeClass('ion-plus-circled');
        }

        if($(toggle_title).hasClass('active') == true){
            $(toggle_title).removeClass('active');

        }else{
            $(toggle_title).addClass('active');

        }
    });

    $(document).on('click','.accordion-group',function(){

        var icon_data = $(this).find('.icon_data');
        console.log(icon_data);
        if($(icon_data).hasClass('ion-plus-circled') == false){

            $(icon_data).addClass('ion-plus-circled');
            $(icon_data).removeClass('ion-minus-circled');
        }else{

            $(icon_data).addClass('ion-minus-circled');
            $(icon_data).removeClass('ion-plus-circled');
        }
    });

</script>

<script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"Product",
      "productID":"{{ $skushow }}",
      "name":"{{ $product->name }}",
      "description":"{{ $product->description }}",
      "url":"{{ $actual_link }}",
      "image":"{{ asset('storage/'.$product->banner_image) }}",
      "brand":"storia",
      "offers": [
        {
          "@type": "Offer",
          "price": "{{ $showrpice }}",
          "priceCurrency": "INR",
          "itemCondition": "https://schema.org/NewCondition",
          "availability": "https://schema.org/{{ !$product->base_pack->is_product_in_stock ? 'OutOfStock' : 'InStock' }}"
        }
      ],
      "additionalProperty": [{
        "@type": "PropertyValue",
        "propertyID": "{{ $skushow }}",
        "value": "{{ $product->slug }}"
      }]
    }
    </script>
@endsection
