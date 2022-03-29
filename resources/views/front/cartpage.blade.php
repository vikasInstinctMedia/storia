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
</style>
<div id="main">
    <!-- <div class="section section-bg-10 pt-11 pb-17">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="page-title text-center">Cart</h2>
                </div>
            </div>
        </div>
    </div> -->
    <div class="section border-bottom pt-2 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumbs">
                        <li><a href="/">Home</a></li>
                        <li><a href="/">Shop</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="section pt-7 pb-7">
        <div class="container">

            @if(Session::has('cart') && Session::get('cart')['items'] )
            <div class="row">
                <div class="col-md-8">
                    <table class="table shop-cart">
                        <tbody>

                            @forelse(Session::get('cart')['items'] as $product)
                            <tr class="cart_item">
                                <td class="product-remove">
                                    <a href="#" class="remove cart-remove-list" data-href="{{ route('product.cart.remove',$product['unique_id'])}}">×</a>
                                </td>
                                <td class="product-thumbnail">
                                    <a href="shop-detail.html">
                                        <img src="{{ asset('storage/'. $product['thumbnail_image']) }}" alt="">
                                    </a>
                                </td>
                                <td class="product-info">
                                    <a href="{{ route('front.category',$product['slug']) }}">{{ $product['name'] }}</a>
                                    <!-- <span class="sub-title">Faucibus Tincidunt</span> -->
                                    <span class="amount">₹{{ $product['price'] }}</span>
                                </td>
                                <td class="product-quantity">
                                    <!-- <div class="quantity">
                                        <input id="qty-1" type="number" min="0" name="number" value="{{$product['quantity']}}" class="input-text qty text change-qty" size="2" data-unique_id="{{ $product['unique_id'] }}" data-href="{{ route('product.cart.changeQuantity', ['unique_id' => $product['unique_id'] ]) }}">
                                    </div> -->

                                    <div class="quantity-chooser">
                                        <div class="quantity">
                                            <span class="qty-minus change-qty-btn" data-unique_id="{{ $product['unique_id'] }}" data-min="1"><i class="ion-ios-minus-outline" style="    display: inline-block;
    width: 20px;"></i></span>
                                            <input type="text" name="quantity" id="qty{{ $product['unique_id'] }}" value="{{$product['quantity']}}" title="Qty" class="input-text qty text change-qty" data-href="{{ route('product.cart.changeQuantity', ['unique_id' => $product['unique_id'] ]) }}" style="    display: inline-block;
    width: 50px;
    padding: 0;" size="4">
                                            <span class="qty-plus change-qty-btn" data-unique_id="{{ $product['unique_id'] }}" data-max="" style="    display: inline-block;
    width: 20px;"><i class="ion-ios-plus-outline"></i></span>
                                        </div>
                                    </div>

                                </td>
                                <td class="product-subtotal">
                                    <span class="amount">₹{{ $product['product_total'] }}</span>
                                </td>
                            </tr>
                            @empty



                            @endforelse

                            <tr>
                                <td colspan="5" class="actions">
                                    <a class="continue-shopping text-center" href="{{ url('/') }}"> Continue Shopping</a>
                                    <input type="submit" class="update-cart" name="update_cart" value="Update Cart" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="cart-totals">
                        <table>
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td>₹ {{ Session::get('cart')['sub_total'] }}</td>
                                </tr>
                                <tr class="shipping">
                                    <th>Shipping</th>
                                    <td>₹{{ Session::get('cart')['shipping_charge']  }}</td>
                                </tr>

                                @if( !empty(Session::get('cart')['discount']) )
                                <tr class="shipping">
                                    <th>Discount</th>
                                    <td>₹{{ Session::get('cart')['discount']  }}</td>
                                </tr>

                                @endif
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td><strong>₹ {{ Session::get('cart')['total'] }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="proceed-to-checkout">
                            <a href="{{ route('front.checkout') }}">Proceed to Checkout</a>
                        </div>
                    </div>
                    <div class="coupon-shipping">
                        <div class="coupon">
                            <form action="{{ route('front.redeem_coupon') }}" method="post">
                                @csrf
                                <input type="text" name="code" class="coupon-code" id="coupon_code" value="" placeholder="Coupon code"  autocomplete="off" />
                                <input type="submit" class="apply-coupon" name="apply_coupon" value="Apply Coupon" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @else

            <div class="section pt-7 pb-7">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="commerce">
                                <p class="cart-empty"> Your cart is currently empty.</p>
                                <a class="organik-btn small" href="{{ route('front.index') }}"> Return to shop </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

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
<script>
    $(function() {

        // Cart price change on change of qty
        $(document).on('change', '.change-qty', function() {
            let qty = $(this).val();
            let unique_id = $(this).data('unique_id');
            // alert($(this).val());

            $.get($(this).data('href') + "?qty=" + qty, function(data) {
                var data = JSON.parse(data)
                console.log(data);
                if (data['status'] == 1) {

                    let cartCount = data['data']['cart']['items'].length;
                    console.log(cartCount);
                    $(".cart-count").attr('data-count', cartCount)
                    $("#cart-items").load(mainurl + '/carts/view');
                    window.location.reload();
                    // toastr.success("Product Removed to cart");
                }
            });
        });



        $(document).on('click', '.change-qty-btn', function() {
            // alert('clicked');
            let unique_id = $(this).data('unique_id');
            let qty = $('#qty' + unique_id).val();
            let urlSubmit = $('#qty' + unique_id).data('href');
            // alert('test');
            //   console.log(unique_id);
            //   console.log(qty);
            //   console.log(urlSubmit);


            $.get(urlSubmit + "?qty=" + qty, function(data) {
                var data = JSON.parse(data)
                console.log(data);
                if (data['status'] == 1) {

                    let cartCount = data['data']['cart']['items'].length;
                    console.log(cartCount);
                    $(".cart-count").attr('data-count', cartCount)
                    $("#cart-items").load(mainurl + '/carts/view');
                    window.location.reload();
                    // toastr.success("Product Removed to cart");
                }
            });

        });

    })
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

@endsection
