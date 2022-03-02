@extends('layouts.front')

@section('head_analytics')
<!-- Event snippet for Purchase conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-310388706/HLipCKebofECEOLPgJQB',
      'transaction_id': ''
  });
</script>

@endsection

@section('styles')

<style type="text/css">
	.root.root--in-iframe {
		background: #4682b447 !important;
	}

	.glyphicon.spinning {
		animation: spin 1s infinite linear;
		-webkit-animation: spin2 1s infinite linear;
	}

	@keyframes spin {
		from { transform: scale(1) rotate(0deg); }
		to { transform: scale(1) rotate(360deg); }
	}

	@-webkit-keyframes spin2 {
		from { -webkit-transform: rotate(0deg); }
		to { -webkit-transform: rotate(360deg); }
	}
</style>

@endsection


@section('content')


<style>
    @import url(https://fonts.googleapis.com/css?family=Noto+Sans);

body{
  /* background: darken(#04B486, 30%); */
  /* font-family: 'Noto Sans', 'Helvetica'; */
}

.customAlert{

  display: none;
  position: fixed;
  max-width: 25%;
  min-width: 250px !important;
  /* min-height: 20%; */
  /* height: 124px; */
  font-size: 18px;
  left: 50%;
  top: 50%;
  padding: 10px;
  box-sizing: border-box;
  margin-left: -12.5%;
  margin-top: -5.2%;
  background: #088A68;
  z-index: 1 !important;
  color: white;
  margin-left: 23%;
    margin-top: 12%;


  @media all and (max-width: 1300px){
    .message{
      font-size: 14px !important;
    }
    input[type='button']{
      height: 15% !important;
    }
  }

  .message{
    padding: 5px;
    color: white;
    font-size: 14px;
    line-height: 20px;
    text-align: justify;
  }

  input[type='button']{
    position: absolute;
    top: 100%;
    left: 50%;
    width: 50%;
    height: 36px;
    margin-top: -45px;
    margin-left: -25%;
    outline: 0;
    border: 0;
    background: #04B486;
    color: white;
    &:hover{
      transition: 0.3s;
      cursor: pointer;
      background: lighten(#04B486, 5%);
    }
  }
}

.rab{
  width: 200px;
  height: 30px;
  outline: 0;
  border: 0;
  color: white;
  background: darken(#04B486, 5%);
}

@keyframes fadeOut{
  from{
    opacity: 1;
  }
  to{
    opacity: 0;
  }
}

@keyframes fadeIn{
  from{
    opacity: 0;
  }
  to{
    opacity: 1;
  }
}

.select_css{
    height: 39px;
    border-color: #f1eeea;
}

.coupon-shipping{
    max-width: 50%!important;
}

@media (max-width:480px)  {
    .address_div{
    margin-left: 35px;
}
.select_add_title{
    margin-left: 35px;
}
.coupon-shipping{
max-width: 100% !important;
}
}

@media (max-width:320px)  {
    .address_div{
    margin-left: 35px;
}
.select_add_title{
    margin-left: 35px;
}

.coupon-shipping{
max-width: 100% !important;
}
}
</style>

<div id="main">
	<!-- <div class="section section-bg-10 pt-11 pb-17">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<h2 class="page-title text-center">Checkout</h2>
							</div>
						</div>
					</div>
				</div> -->
	<div class="section border-bottom pt-2 pb-2">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumbs">
						<li><a href="./">Home</a></li>
						<li><a href="shortcodes.html">Shop</a></li>
						<li>Checkout</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="section section-checkout pt-7 pb-7">
		<form id="checkoutform" action="" method="POST" class="checkoutform">

			@include('includes.form-success')
			@include('includes.form-error')

			{{ csrf_field() }}
			<div class="container">
				<div class="row">

					<div class="col-md-6">
						<h3>Billing details</h3>
						<div class="address">

                            <div class="row select_add_div">
                                @if (isset($user_address) && count($user_address) > 0)
                                <label for="" class="select_add_title">Select Address</label>
                                @foreach ($user_address as $add)

                                <div class="col-md-5 address_div" style="
                                border: 1px solid #088a68;
                                padding: 13px 0px 13px 16px;
                                   margin-right: 46px;
                                       margin-top: 4px;
                                       cursor:pointer;" data-id="{{ $add->id }}" data-zip="{{ $add->zip }}">
                                    Name : {{ $add->name }} <br>
                                    Email : {{ $add->email }}<br>
                                    Address : {{ $add->address }}<br>
                                    City : {{ $add->city }}<br>
                                    Country : {{ $add->country }}<br>
                                    Zip : {{ $add->zip }}<br>
                                    Phone : {{ $add->phone }}<br>
                                </div>

                                @endforeach
                                @endif
                            </div>
                            @if (isset($user_address) && count($user_address) > 0)
                            <a href="javascript:void(0)" class="btn btn-default add_add_btn organik-btn mybtn1" data-check="1" style="margin-bottom: 18px;">Add New Address</a>
                            @endif
                            <div class="billing_address_div">
							<div class="row">
								<div class="col-md-6">
                                    <input type="hidden" name="add_id" class="add_id" id="">
									<label>First name <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="First name" size="40" required="" class="for_req" />
									</div>
								</div>
								<div class="col-md-6">
									<label>Last name <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="text" name="lastname" placeholder="Last name" value="{{ old('lastname') }}" size="40" required="" class="for_req"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label>Date Of Birth </label>
									<div class="form-wrap">
										<input type="date" name="dob" value="{{ old('dob') }}" placeholder="First name" size="40" />
									</div>
								</div>
								<div class="col-md-6">
									<label>Gender </label>
									<div class="form-wrap">
										<select name="gender" id="gender" class="select_css">
											<option value="" selected>Select</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Company name</label>
									<div class="form-wrap">
										<input type="text" name="company" value="{{ old('company') }}" placeholder="Company name" value="" size="40" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Country <span class="required">*</span></label>
									<div class="form-wrap">
										<select name="customer_country" id="country" required="" class="for_req select_css">
											<option value="India" selected>India</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>State <span class="required">*</span></label>
									<div class="form-wrap">
										<select name="customer_state" class="state for_req select_css" id="state" required="">
											<option value="">Select</option>
											@foreach($states as $key => $state)
											<option value="{{ $state }}"> {{ $state }} </option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>City <span class="required">*</span></label>
									<div class="form-wrap">
										<select name="city" class="city for_req select_css" id="city" required="">
											<option value="">Select</option>
											@foreach($cities as $key => $city)
											<option value="{{ $city }}">{{ $city }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Address <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="text" name="address" placeholder="Address" value="" size="40" required="" class="for_req" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Postcode / ZIP <span class="required">*</span> </label>
									<div class="form-wrap">
										<input type="text" name="zip" placeholder="Postcode / ZIP" value="{{ old('zip', session()->get('pincode')) }}" size="40" required="" max="6" class="for_req user_zip"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label>Phone <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}" size="40" required="" id="bill_phone" class="for_req phone_no_in" />
									</div>
								</div>
								<div class="col-md-6">
									<label>Email <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="Email" size="40" required="" class="for_req" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Order notes</label>
									<div class="form-wrap">
										<textarea name="order_notes" class="input-text " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
									</div>
								</div>
							</div>
							<div class="row">

								<div class="col-lg-12 mt-3">
									<input class="styled-checkbox" name="ship_to_diff_add" id="ship-diff-address" type="checkbox" value="value1">
									<span for="ship-diff-address">Ship to a Different Address?</span>
								</div>
							</div>
                            </div>
                        </div>
						<div class="row ship-diff-addres-area d-none mt-3 address shipp_address_div">
							<h3>Shipping details</h3>
							<div class="row">
								<div class="col-md-6">
									<label>First name <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="text" name="shipping_firstname" value="" size="40" />
									</div>
								</div>
								<div class="col-md-6">
									<label>Last name <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="text" name="shipping_lastname" value="" size="40" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Country <span class="required">*</span></label>
									<div class="form-wrap">
										<select name="shipping_country" id="country" class="select_css">
											<option value="India">India</option>

										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>State <span class="required">*</span></label>
									<div class="form-wrap">
										<select name="shipping_state" class="state select_css" id="state">
											@foreach($states as $key => $state)
											<option value="{{ $state }}" {{ $loop->index == 0 ?'selected' : ''  }}> {{ $state }} </option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>City <span class="required">*</span></label>
									<div class="form-wrap">
										<select name="shipping_city" class="city select_css" id="city">
											<option value="">Select</option>
											@foreach($cities as $key => $city)
											<option value="{{ $city }}">{{ $city }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Address <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="text" name="shipping_address" value="" size="40" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Postcode / ZIP <span class="required">*</span> </label>
									<div class="form-wrap">
										<input type="text" name="shipping_zip" value="" size="40" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label>Phone <span class="required">*</span> </label>
									<div class="form-wrap">
										<input type="text" name="shipping_phone" value="" size="40" class="phone_no_in" />
									</div>
								</div>
								<div class="col-md-6">
									<label>Email <span class="required">*</span></label>
									<div class="form-wrap">
										<input type="email" name="shipping_email" value="" size="40" />
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="submit-loader">
						<img src="{{asset('front/images/loading_large.gif')}}" alt="">
					</div>
					<div class="col-md-6">
						<h3 class="mt-3">Your order</h3>
						<div class="order-review">
							<table class="checkout-review-order-table">
								<thead>
									<tr>
										<th class="product-name">Product</th>
										<th class="product-total">Total</th>
									</tr>
								</thead>
								<tbody>
									@foreach(Session::get('cart')['items'] as $product)
									<tr>
										<td class="product-name">
											{{ $product['name'] }}&nbsp;<strong class="product-quantity">× {{$product['quantity']}}</strong>
										</td>
										<td class="product-total">
											₹{{ $product['price'] }}
										</td>
									</tr>
									@endforeach
									<!-- <tr>
												<td class="product-name">
													Aurore Grape&nbsp;<strong class="product-quantity">× 1</strong>
												</td>
												<td class="product-total">
													₹9.00
												</td>
											</tr> -->
								</tbody>
								<tfoot>
									<tr>
										<th>Subtotal</th>
										<td>₹ {{ Session::has('cart') ? Session::get('cart')['sub_total'] : '0.00' }}</td>
									</tr>

                                    <tr>
										<th>COD charge</th>
										<td>₹ <span class="cod_charge_data">0</span></td>
									</tr>

									<tr>
										<th>Shipping charge</th>
										<td>₹ {{ Session::has('cart') ? Session::get('cart')['shipping_charge'] : '0.00' }}</td>
									</tr>

									@if( !empty(Session::get('cart')['discount']) )
									<tr>
										<th>Discount</th>
										<td>₹{{ Session::get('cart')['discount']  }}</td>
									</tr>

									@endif
									<!-- <tr>
												<th>Shipping</th>
												<td>
													<ul id="shipping_method">
														<li>
															<input type="radio" name="shipping_method[0]" data-index="0" id="shipping_method_0_free_shipping1" value="free_shipping:1" class="shipping_method" checked="checked">
															<span>Free shipping</span>
														</li>
														<li>
															<input type="radio" name="shipping_method[0]" data-index="0" id="shipping_method_0_local_pickup2" value="local_pickup:2" class="shipping_method">
															<span>Local pickup</span>
														</li>
													</ul>
												</td>
											</tr> -->
									<!-- <tr>
												<th>Tax</th>
												<td>₹2.10</td>
											</tr>
											<tr>
												<th>Service</th>
												<td>₹1.16</td>
											</tr> -->
									<tr class="order-total">
										<th>Total</th>
										<td><strong>₹<span class="final_amt_span">{{ Session::has('cart') ? Session::get('cart')['total'] : '0.00' }}</span></strong></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="checkout-payment payment-information">
                            <h6>Payment Method</h6>
                            <ul class="payment-method">
								<li class="">
									<a class="nav-link payment" data-val="" data-show="no" data-form="{{route('cash.submit')}}" data-pay="cod" data-href="{{ route('front.load.payment',['slug1' => 'cod','slug2' => 0]) }}" id="v-pills-tab3-tab" data-toggle="pill" href="#v-pills-tab3" role="tab" aria-controls="v-pills-tab3" aria-selected="false">


										<!-- <input id="payment_method_cod" type="radio" class="input-radio" name="payment_method" value="cod" checked="checked" data-order_button_text="">
											<span>Cash on delivery</span> </a> -->
										<div class="icon storiaradio">
											<span class="radio"></span>
										</div>
										<p>
											Cash on delivery (COD Charges : ₹30)
										</p>
									</a>

									<div class="payment-box">
										<p>Pay with cash upon delivery.</p>
									</div>
								</li>
								<li>
									<a class="nav-link payment" data-val="" data-show="no" data-form="{{route('razorpay.submit')}}" data-pay="razorpay" data-href="{{ route('front.load.payment',['slug1' => 'razorpay','slug2' => 0]) }}" id="v-pills-tab6-tab" data-toggle="pill" href="#v-pills-tab6" role="tab" aria-controls="v-pills-tab6" aria-selected="false">

										<!-- <input id="payment_method_paypal" type="radio" class="input-radio" name="payment_method" value="razorpay" data-order_button_text="Proceed to Razorpay">
											Razorpay<img src="images/payment.jpg" alt=""> -->
										<div class="icon">
											<span class="radio"></span>
										</div>
										<p>
											<!-- Razorpay -->
											Debit Card / Credit Card / Net Banking / UPI
										</p>

									</a>
								</li>
							</ul>
							<div class="text-right text-center-sm">
								<input type="hidden" name="totalQty" value="{{ Session::has('cart') ? count(Session::get('cart')['items']) : '0' }}">
								<input type="hidden" name="total" id="grandtotal" value="{{round(Session::has('cart') ? Session::get('cart')['total'] : '0.00',2)}}">
								<input type="hidden" id="tgrandtotal" value="{{round(Session::has('cart') ? Session::get('cart')['total'] : '0.00',2)}}">
								<input type="hidden" name="user_id" id="user_id" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">


								<button type="submit" id="final-btn" class="organik-btn mt-6 mybtn1">Place Order</button>

								<!-- <a class="organik-btn mt-6" href="#"> Place Order </a> -->
							</div>


						</div>
					</div>
					<div class="col-lg-12">
						<div class="pay-area d-none">
							<div class="tab-content" id="v-pills-tabContent">

								<div class="tab-pane fade" id="v-pills-tab3" role="tabpanel" aria-labelledby="v-pills-tab3-tab">
								</div>

								<div class="tab-pane fade" id="v-pills-tab6" role="tabpanel" aria-labelledby="v-pills-tab6-tab">
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</form>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 coupon-shipping" style="">
					<div class="coupon">
						<form action="{{ route('front.redeem_coupon') }}" method="post">
							@csrf
							<input type="text" name="code" class="coupon-code" id="coupon_code" value="" placeholder="Coupon code" autocomplete="off" />
							<input type="submit" class="apply-coupon" name="apply_coupon" value="Apply Coupon" />
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<style>
    @media (max-width:600px)  {
        .customAlert{
        margin-left: -32% !important;
    margin-top: 51% !important;
        }
    }
</style>
<div class='customAlert'>
    <p class='message'></p>
    <div class="text-center">
        <input type='button' class='confirmButton' style="background-color: #606060;" value='Ok'>
    </div>
  </div>
@endsection



@section('scripts')
{{-- <script type="text/javascript"></script>
	$('a.payment:first').addClass('active');
	$('.checkoutform').prop('action', $('a.payment:first').data('form'));
	$($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));


	var show = $('a.payment:first').data('show');
	if (show != 'no') {
		$('.pay-area').removeClass('d-none');
	} else {
		$('.pay-area').addClass('d-none');
	}
	$($('a.payment:first').attr('href')).addClass('active').addClass('show');
	$('.submit-loader').hide();
</script> --}}
<script type="text/javascript">
	$('.submit-loader').hide();
	$("#ship-diff-address").on("change", function() {
		if (this.checked) {
			$('.ship-diff-addres-area').removeClass('d-none');
			$('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', true);
		} else {
			$('.ship-diff-addres-area').addClass('d-none');
			$('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', false);
		}

	});

	$('.payment').on('click', function() {
        var payment_check = $(this).attr('data-pay');
        if(payment_check == 'cod'){
            var total = {{ Session::get('cart')['total'] }};
            var final_total = total+30;
            $('.cod_charge_data').text('');
            $('.cod_charge_data').text('30');
        }else{
            var total = {{ Session::get('cart')['total'] }};
            var final_total = total+0;
            $('.cod_charge_data').text('');
            $('.cod_charge_data').text('0');
        }
        $('.final_amt_span').text(final_total);
		$('.submit-loader').show();
		$('.checkoutform').prop('id', '');

		$('.checkoutform').prop('action', $(this).data('form'));

		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).data('show');
		if (show != 'no') {
			$('.pay-area').removeClass('d-none');
		} else {
			$('.pay-area').addClass('d-none');
		}
		$($(this).attr('href')).load($(this).data('href'), function() {
			$('.submit-loader').hide();
		});
	})


	// Update cites on selection of state
	$(document).on('change', '.state', function() {
		// alert('change');
		let state = $(this).val();
		let stateSelect = $(this);

		$.ajax({
			method: 'get',
			url: "{{ route('front.get_cities_by_state') }}",
			data: {
				state
			}
		}).done((res) => {
			let data = JSON.parse(res);

			if (data['status'] == 1) {
				let str = "<option value=''> select </option>"
				data['data'].cities.forEach((city) => {
					// console.log(city);
					str += `<option value='${city}'>${city}</option>`;
				});

				stateSelect.parents(".address").find('.city').html(str);
			}

		});

	});


	// trigger google analytics code
	var cartProducts = "{{ json_encode( Session::get('cart')['items'] ) }}";
	cartProducts = cartProducts.replace( /&quot;/g, '"' ),
	cartProducts = jQuery.parseJSON( cartProducts );
	// console.log(cartProducts);
	// analytics.onCheckout(cartProducts);
	var submitted = false;
	$('#checkoutform').submit(function (e) {

		var add_id = $('.add_id').val();
            if(add_id == ''){
				var bill_phone = $('#bill_phone').val();
                var len = $('#bill_phone').val().length;
            if(len > 10 || len < 10){
                e.preventDefault();
                alert('Please Enter 10 Digits in Phone');
            }

			var check = onlyDigits(bill_phone);
			if(!check){
				e.preventDefault();
				alert('Please Remove Spaces , Alphabets And Special Charachters From Phone Field');
			}
			// let isnum = /^\d+$/.test(val);
			// alert(isnum);
            }



		if(submitted) {
			// console.log('do not submit');
			return false;
		}
		analytics.onCheckout(cartProducts);
		submitted = true;
		$('#final-btn').html("<i class='fa fa-spinner fa-spin fa-fw'></i> Placing");
		setTimeout(() => {
				submitted = false;
				$('#final-btn').html("Place Order");
		}, 7000 );
		// console.log('submit');
		return true;

	});

	function onlyDigits(s) {
  for (let i = s.length - 1; i >= 0; i--) {
    const d = s.charCodeAt(i);
    if (d < 48 || d > 57) return false
  }
  return true
}
</script>


@if (Session::get('cart')['sub_total'] < 400)
    <script>
        var sub_total = {{ Session::get('cart')['sub_total'] }};
        var rem = 400 - sub_total;
        // alert('ADD PRODUCTS WORTH ₹'+rem+' MORE TO GET FREE SHIPPING.');
        var currentCallback;

// override default browser alert
window.alert = function(msg, callback){
  $('.message').text(msg);
  $('.customAlert').css('animation', 'fadeIn 0.3s linear');
  $('.customAlert').css('display', 'inline');
  setTimeout(function(){
    $('.customAlert').css('animation', 'none');
  }, 300);
  currentCallback = callback;
}

$(function(){

  // add listener for when our confirmation button is clicked
  $('.confirmButton').click(function(){
    $('.customAlert').css('animation', 'fadeOut 0.3s linear');
    setTimeout(function(){
     $('.customAlert').css('animation', 'none');
    $('.customAlert').css('display', 'none');
    }, 300);
    currentCallback();
  })

  $('.rab').click(function(){
    alert("If you think about anything, you are actually doing a recursive function which resolves your neurons into a deep pi calculation. You are then executing about 4294 threads in your brain, which do a parallel computation.", function(){
      console.log("Callback executed");
    })
  });

  // our custom alert box
  setTimeout(function(){
    alert('ADD PRODUCTS WORTH ₹'+rem+' MORE TO GET FREE SHIPPING.', function(){
        console.log("Callback executed");
      });
  }, 500);

  setTimeout(function(){
    // $('.customAlert').fadeOut();
  }, 5000);
});



    </script>
@endif
<script>
    $(document).on('click','.address_div',function(){
        var add_id = $(this).attr('data-id');
    var user_zip = $(this).attr('data-zip');

    var add_old = $('.add_id').val();
    if(add_old == add_id){
        $('.address_div').css('background-color','white');
    $('.address_div').css('color','#5E5A54');
    $('.add_id').val('');
    $('.user_zip').val('');
    $('.for_req').attr('required','true');
    }else{
    $('.address_div').css('background-color','white');
    $('.address_div').css('color','#5E5A54');
    $(this).css('background-color','#088a68');
    $(this).css('color','white');
    $('.add_id').val(add_id);
    $('.user_zip').val(user_zip);
    $('.for_req').removeAttr('required');
    }


    // alert(add_id);

});

</script>
@if (isset($user_address) && count($user_address) > 0)

<script>
$(document).ready(function(){
    $('.billing_address_div').fadeOut();
    $('.shipping_address_div').fadeOut();
});
</script>

@endif
<script>
$(document).on('click','.add_add_btn',function(){
    var check = $(this).attr('data-check');
    if(check == 1)
    {
        $('.billing_address_div').fadeIn();
    $('.shipping_address_div').fadeIn();
    $('.select_add_div').fadeOut();
    $(this).attr('data-check', '2');
    $(this).text('Select Address');
    }else{
        $('.billing_address_div').fadeOut();
    $('.shipping_address_div').fadeOut();
    $('.select_add_div').fadeIn();
    $(this).attr('data-check', '1');
    $(this).text('Add New Address');
    }

});

$('.phone_no_in').on('keypress', function(e) {
            if (e.which == 32){
                console.log('Space Detected');
                return false;
            }

            e = (e) ? e : window.event;
            var charCode = (e.which) ? e.which : e.keyCode;
             if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }

            var len = $(this).val().length  ;
            if(len > 9){
                return false;
            }
        });

        // $(document).on('submit','#checkoutform',function(e){


        // });
</script>


@endsection
