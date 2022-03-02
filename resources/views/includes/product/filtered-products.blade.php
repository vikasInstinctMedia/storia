									@if (count($prods) > 0)
									@foreach ($prods as $key => $prod)
									<div class="col-lg-4 col-md-4 col-xs-6 product-item text-center mb-3" data-product="{{ json_encode($prod->only(['name','base_pack'])) }}">
										<div class="product-thumb test-div" >
											<a class="test-div-inner product-clicked" href="{{ route('front.category',  $prod->slug ) }}">
												<div class="badges">
													<!-- <span class="hot">Hot</span>
													<span class="onsale">Sale!</span> -->
												</div>

												<img src="{{asset('storage/'.$prod->banner_image)}}" alt=""  class="product_list_image test-image"   height="1000" width="1000" />

											</a>
											{{-- <div class="product-action">




												<span class="add-to-cart add-to-cart-btn in-stock {{ !$prod->base_pack->is_product_in_stock ? 'd-none' : '' }} " data-page="listing" data-product-id="{{ $prod->id }}">
													<a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
												</span>


												<span class="not-in-stock {{ !$prod->base_pack->is_product_in_stock ? '' : 'd-none' }}" >Out of stock</p>

												<!-- <span class="wishlist">
													<a href="#" data-toggle="tooltip" data-placement="top" title="Add to wishlist"></a>
												</span>
												<span class="quickview">
													<a href="#" data-toggle="tooltip" data-placement="top" title="Quickview"></a>
												</span>
												<span class="compare">
													<a href="#" data-toggle="tooltip" data-placement="top" title="Compare"></a>
												</span> -->
											</div> --}}
										</div>
										<div class="product-info">

											<form class="commerce-ordering">
												<select name="packs" class="pack-select" data-product-id="{{ $prod->id }}" style="">

													@foreach($prod->packs as $pack)
														<option value="{{ $pack->id }}"> {{ $pack->details->title }} </option>
													@endforeach

												</select>
											</form>
                                            <div class="add-to-cart add-to-cart-btn in-stock {{ !$prod->base_pack->is_product_in_stock ? 'd-none' : '' }} " data-page="listing" data-product-id="{{ $prod->id }}" style="    background-color: #06904d;padding: 7px 0px 7px 0px;">

                                                <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart" style="color: white;">  <i class="fa fa-shopping-bag" aria-hidden="true" style="padding-right: 15px;"></i>Add To Cart</a>
                                            </div>

                                            <div class="not-in-stock {{ !$prod->base_pack->is_product_in_stock ? '' : 'd-none' }}"  style="background-color: #06904d;
                                                padding: 7px 0px 7px 0px;
                                                color: white;
                                            ">
                                                <span>Out of stock</span>
                                            </div>

											<a href="{{ route('front.category',  $prod->slug ) }}" class="product-clicked">
												<h2 class="title">{{ $prod->showName() }}</h2>
												<span class="price">


                                                    @if ($prod->type == 'regular')
													@if( $prod->base_pack_price_without_discount != $prod->base_pack_price )
                                                    <del>₹<span class="pack-discount-price">{{ $prod->base_pack_price_without_discount }}</span></del>
                                                     @endif
                                                     <ins>₹<span class="pack-price">{{ $prod->base_pack_price }}</span> </ins>
                                                    @endif

                                                    @if ($prod->type == 'assorted')
                                                    @if( $prod->base_pack_price != ($prod->base_pack_price - $prod->base_pack->discount) )
                                                    <del>₹<span class="pack-discount-price">{{ $prod->base_pack_price_without_discount }}</span></del>
                                                     @endif
                                                    <ins>₹<span class="pack-price">{{ ($prod->base_pack_price - $prod->base_pack->discount) }}</span> </ins>
                                                    @endif


												</span>
											</a>
										</div>
									</div>
									@endforeach
									<div class="col-lg-12">
										<div class="page-center mt-5">
											{!! $prods->links() !!}
										</div>
									</div>
									@else
									<div class="col-lg-12">
										<div class="page-center">
											<h4 class="text-center">No Data Found</h4>
										</div>
									</div>
									@endif
