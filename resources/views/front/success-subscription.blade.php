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

<!-- Breadcrumb Area Start -->

<div class="section border-bottom pt-2 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index') }}">Home</a></li>
                    <li><a href="{{ route('payment.return') }}">Success</a></li>
                    <li>Your Order</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->



<section class="tempcart">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Starting of Dashboard data-table area -->
                <div class="content-box section-padding add-product-1">
                    <div class="top-area">
                        <div class="content">
                            <h4 class="heading">
                                THANK YOU FOR YOUR PURCHASE.
                            </h4>
                            <p class="text">
                                We'll email you an order confirmation And Subscription Information.
                            </p>
                            <a href="{{ route('front.index') }}" class="link">Get Back To Our Homepage</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="product__header">
                                <div class="row reorder-xs text-center">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="product-header-title">
                                            <h2>Order id : {{$order->receipt_id}}</h2>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 col-sm-12" id="tempview">
                                        <div class="dashboard-content">
                                            <div class="view-order-page" id="print">
                                                <p class="order-date">Order Date - {{ $order->created_at->format('F d,Y') }}</p>
                                                <br>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="product-header-title">
                                            <p>Subscription : {{$order->subscription->title}}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="product-header-title">
                                            <p>Subscription Type: {{$order->subscription->subscription_type->title}}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="product-header-title">
                                            <p>Amount: ₹ {{$order->subscription->price}}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>


</section>



@endsection


@section('scripts')

@if (session('short_url') && session('short_url') != '')
    <script>
        // alert(1);
        alert('Subscription Compelte , Now Please Complete Payment To Activate Your Subscription');
        setTimeout(redirect_razor, 1000);

function redirect_razor() {
//   document.getElementById("demo").innerHTML = "Happy Birthday!"
// window.location.href="{{ session('short_url') }}";
window.open(
  '{{ session("short_url") }}',
  '_blank' // <- This is what makes it open in a new window.
);

}
    </script>
@endif

<script>
$(function() {


    // checkoutSuccess();

})
</script>
@endsection
