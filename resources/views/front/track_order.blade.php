@extends('layouts.front')
@section('style')
<style>
    .search-div {

        /* max-width: 800px;
        margin-left: auto;
        margin-right: auto; */
    }

    .result-div {
        min-height: 400px;
    }

    .full-width-button {
        width: 100%;
    }

    .storia-green {
        background-color: #06904d;
    }
</style>
@endsection
@section('content')

<div id="main">

    <div class="container">
        <br />
        <div class="search-div">
            <form class="newsletter" method="POST" action="{{ route('front.track.order') }}">
                @csrf

                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="row">
                            <div class="col-md-10 col-xs-8">
                                <input type="text" name="tracking_number" placeholder="AWB/Order number" required="" autocomplete="off">
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <button class="submit-button full-width-button storia-green"" type=" submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <div class="container result-div">

            @if(Session::has('order'))

            @php
            $order = Session::get('order');
            @endphp

            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h5 class="mb-0 h6">Order Details</h5> -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>AWB Number : </label>
                                    <span>{{ $order->awb_number }}</span>
                                    <br />
                                    <label>Order Number: </label>
                                    <span>{{ $order->order_number }}</span>
                                    <br />
                                    <label>Date: </label>
                                    <span>{{ $order->created_at->format('F d,Y') }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <label>Delivery Status : </label>
                                    <h6>
                                        {{ $order->delivery_status }}
                                    </h6>
                                    <label>Order Status : </label>
                                    <h6>
                                        {{ $order->status }}
                                    </h6>
                                </div>
                                <div class="col-sm-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($order->products as $product)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $product['name'] }}</td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>{{ $product['price'] }}</td>
                                                <td>{{ $product['product_total'] }}</td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <label>Total : </label>
                                    <span>₹{{ $order->pay_amount }}</span>
                                    <br />
                                </div>
                                <div class="col-sm-6">
                                    <label>Method : </label>
                                    <span>{{ $order->payment_method_title }}</span>
                                    <br />
                                    <label>Payment Status: </label>
                                    <span>{{ $order->payment_status }}</span>
                                </div>

                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6 pb-3">
                                    <div class="row">
                                        <div class="col-xs-6">

                                            <form method="post" id="cancel-order-form" action="{{  route('front.track.order.cancel') }}">
                                                @csrf
                                                <input type="hidden" name="awb_number" value="{{ $order->awb_number }}">
                                                <button type="submit" class="btn btn-default full-width-button">Cancel Order</button>
                                            </form>
                                        </div>

                                        <div class="col-xs-6">
                                            <a href="https://storiafoods.ordr.live/trk/{{ $order->awb_number }}">
                                                <button type="button" class="btn btn-success full-width-button storia-green">Track Order</button>
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @elseif( Session::has('no_order_found') )

            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="card">

                        <div class="card-body">
                            <h2>
                                No Order Found
                            </h2>
                        </div>
                    </div>

                </div>
            </div>

            @endif

        </div>
    </div>



</div>

@endsection

@section('scripts')
<script>
    $(function() {

        $(document).on('click', '#cancel-order-form', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Click ok to cancel',
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Ok`,
                // denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#cancel-order-form').submit();
                } 
            })

        });

    })
</script>

@endsection