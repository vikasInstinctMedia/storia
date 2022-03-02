@extends('layouts.front')




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

    @if(!empty($tempcart))

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
                                We'll email you an order confirmation with details and tracking info.
                            </p>
                            <a href="{{ route('front.index') }}" class="link">Get Back To Our Homepage</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="product__header">
                                <div class="row reorder-xs">
                                    <div class="col-lg-12">
                                        <div class="product-header-title">
                                            <h2>Order# {{$order->order_number}}</h2>
                                            <h2>AWB Number {{$order->awb_number}}</h2>
                                        </div>
                                    </div>
                                    @include('includes.form-success')
                                    <div class="col-md-12" id="tempview">
                                        <div class="dashboard-content">
                                            <div class="view-order-page" id="print">
                                                <p class="order-date">Order Date - {{ $order->created_at->format('F d,Y') }}</p>

                                                <div class="shipping-add-area">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Shipping Address</h5>
                                                            <address>
                                                                Name: {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                                                                Email: {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                                                                Phone: {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                                                                Address: {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
                                                                {{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                                            </address>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="billing-add-area">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5>Billing Address</h5>
                                                            <address>
                                                                Name: {{$order->customer_name}}<br>
                                                                Email: {{$order->customer_email}}<br>
                                                                Phone: {{$order->customer_phone}}<br>
                                                                Address: {{$order->customer_address}}<br>
                                                                {{$order->customer_city}}-{{$order->customer_zip}}
                                                            </address>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5>Payment Information</h5>
                                                            <p>Paid Amount: ₹ {{ round($order->pay_amount, 2) }}</p>
                                                            <p>Payment Method: {{ $order->payment_method_title }}</p>

                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <h4 class="text-center">Ordered Products:</h4>
                                                        <thead>
                                                            <tr>

                                                                <th width="60%">Name</th>
                                                                <th width="20%">Quantity</th>
                                                                <th width="10%">Price</th>
                                                                <th width="10%">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach($tempcart['items'] as $product)
                                                            <tr>

                                                                <td>{{ $product['name'] }}</td>
                                                                <td>{{$product['quantity']}}</td>
                                                                <td>₹{{round($product['price'],2)}}</td>
                                                                <td>₹{{round($product['price'],2)}}</td>

                                                            </tr>
                                                            @endforeach
                                                            <tr>

                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>₹{{ round($order->pay_amount, 2) }}</td>

                                                            </tr>


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>

            @endif

</section>



@endsection


@section('scripts')

<script>
$(function() {

    function checkoutSuccess() {
        // trigger google analytics code
        var orderCart = "{{ json_encode( $tempcart ) }}";
        var orderNumber = "{{ $order->order_number }}";
        var branchName  = "{{ $order->branch->name }}";
        orderCart = orderCart.replace( /&quot;/g, '"' );
        orderCart = jQuery.parseJSON( orderCart );

        orderCart.orderNumber = "{{ $order->order_number }}";
        orderCart.branchName = "{{ $order->branch->name }}";
        // order = order.replace( /&quot;/g, '"' );
        // order = jQuery.parseJSON( order );


        // console.log(orderCart);
        // console.log(orderNumber);
        // console.log(branchName);
        // console.log('order details');
        analytics.checkoutCompleted(orderCart);
    }

    checkoutSuccess();

})


</script>
<!-- Event snippet for Purchase conversion page -->
 <script>
  gtag('event', 'conversion', {
       'send_to': 'AW-351329350/jMOSCJjm7qMDEMa4w6cB',
       'value': {{ round($order->pay_amount, 2) }},
        'currency': 'INR',
         'transaction_id': '{{$order->order_number}}' });
 </script>

 <script>
     fbq('track', 'Purchase', {value: {{ round($order->pay_amount, 2) }}, currency: 'INR'});
 </script>

@endsection
