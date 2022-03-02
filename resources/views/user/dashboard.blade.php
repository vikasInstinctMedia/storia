@extends('layouts.front')
@section('content')

@section('head')
 <style>
     .sub_name_show{
         font-weight:700;
     }
 </style>
@endsection

<div id="main">
    <div class="container mt-5">
        <div class="row">
            <h2 class="text-center section-title mtn-2 fz-24 mb-3">Order History</h2>
            <div class="col-md-2 d-md-block bg-light sidebar">
                <nav class="sidebar-sticky">
                    <ul class="tab nav">
                        <li class="nav-item">
                            <a class="nav-link tablinks" onclick="openCity(event, 'Dashboard')" id="defaultOpen">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tablinks" onclick="openCity(event, 'Purchased')">
                                <span data-feather="file"></span>
                                Purchased Item
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tablinks" onclick="openCity(event, 'Subscriptions')">
                                <span data-feather="file"></span>
                                Subscriptions
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                                <a class="nav-link tablinks" onclick="openCity(event, 'Profile')">
                                    <span data-feather="shopping-cart"></span>
                                    Edit Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tablinks" onclick="openCity(event, 'Reset')">
                                    <span data-feather="users"></span>
                                    Reset Password
                                </a>
                            </li> -->
                        <li class="nav-item">
                            <a href="{{ route('user-logout') }}">
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div id="Dashboard" class="tabcontent">

                    <div class="col-lg-12 storiaboosthistory">
                        <div class="col-lg-6">
                            <div class="text-center">
                                <svg viewBox="0 0 36 36" style="width: 200px; height: 200px;">
                                    <path fill="none" stroke="#eee" stroke-width=4 d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="circle" fill="none" stroke-width="4" stroke-linecap="round" style="stroke: #5fbd74; animation: progress 1s ease-out forwards" d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <text x="18" y="20.35" class="percentage" style="fill: #5fbd74; font-family: sans-serif; font-size: .5em; text-anchor: middle">{{ Auth::user()->orders()->where('status','completed')->count() }}</text>
                                </svg>
                            </div>
                            <div class="text-center">
                                Total Orders
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <svg viewBox="0 0 36 36" style="width: 200px; height: 200px;">
                                    <path fill="none" stroke="#eee" stroke-width=4 d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="circle" fill="none" stroke-width="4" stroke-linecap="round" style="stroke: #0b8747; animation: progress 1s ease-out forwards" d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <text x="18" y="20.35" class="percentage" style="fill: #0b8747; font-family: sans-serif; font-size: .5em; text-anchor: middle">{{ Auth::user()->orders()->where('status','pending')->count() }}</text>
                                </svg>
                            </div>
                            <div class="text-center">
                                Pending Orders
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-5 mb-5 storiaboosthistory">
                        <h2>Recent Order</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#Order</th>
                                        <th>Date</th>
                                        <th>Order Total</th>
                                        <th>Order Status</th>
                                        <th>Tracking Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dashboardOrders as $order)
                                    <tr>
                                        <td>{{$order->order_number}}</td>
                                        <td>{{date('d M Y',strtotime($order->created_at))}}</td>
                                        <td>₹{{ round($order->pay_amount, 2) }}</td>
                                        <td>{{ucwords($order->status)}}</td>
                                        <td>{{$order->tracking_status ?? "N-A"}}</td>
                                        <td>
                                            <a href="https://storiafoods.ordr.live/trk/{{ $order->awb_number }}">
                                                <button type="button" class="btn btn-success full-width-button storia-green">Track Order</button>
                                            </a>

                                            <!-- <form method="post" id="cancel-order-form" action="{{  route('front.track.order.cancel') }}">
                                                @csrf
                                                <input type="hidden" name="awb_number" value="{{ $order->awb_number }}">
                                                <button type="submit" class="btn btn-default full-width-button">Cancel Order</button>
                                            </form> -->
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="Purchased" class="tabcontent">
                    <div class="col-lg-12 mt-5 mb-5">
                        <h2>Recent Order</h2>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#Order</th>
                                        <th>Date</th>
                                        <th>Order Total</th>
                                        <th>Order Status</th>
                                        <th>Tracking Status</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($orderss as $order)--}}
                                    @foreach($dashboardOrders as $order)
                                    <tr>
                                        <td>{{$order->order_number}}</td>
                                        <td>{{date('d M Y',strtotime($order->created_at))}}</td>
                                        <td>₹{{ round($order->pay_amount, 2) }}</td>
                                        <td>{{ucwords($order->status)}}</td>
                                        <td>{{$order->tracking_status ?? "N-A"}}</td>
                                        <td>-</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="Subscriptions" class="tabcontent">
                    <div class="col-lg-12 mt-5 mb-5">
                        <h2>Subscriptions</h2>
                        @if (!empty($user_subscriptions->toArray()))

                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Frequency</th>
                                        <th>Subscription Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($orderss as $order)--}}
                                    @foreach($user_subscriptions as $sub)
                                    <tr>
                                        <td>{{$sub->receipt_id}}</td>
                                        <td>{{$sub->subscription->title}}</td>
                                        <td>{{$sub->subscription->subscription_type->title}}</td>
                                        <td>{{date('d M Y',strtotime($sub->created_at))}}</td>
                                        <td>₹{{ round($sub->price, 2) }}</td>
                                        <td>
                                            @if($sub->pay_type == 1)
                                                <span>{{ $sub->for_how_many }} Weeks</span>
                                            @else
                                            <span>{{ $sub->for_how_many }} Months</span>
                                            @endif
                                        </td>
                                        <td>@if($sub->status == 1)
                                            Active
                                            @else
                                            In-active
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-success orders_mod" data-id="{{ $sub->id }}" data-subname="{{ $sub->subscription->title }}" data-toggle="modal" data-target="#orders_modal{{ $sub->id }}">Show Subscription Orders</a>

                                            @if($sub->status == 1)
                                            <a href="javascript:void(0)" class="btn btn-danger cancel_sub" data-id="{{ $sub->id }}" data-subname="{{ $sub->subscription->title }}" data-toggle="modal" data-target="#del_modal">Cancel Subscription</a>
                                            @else
                                        <a href="javascript:void(0)" class="btn btn-danger">Subscription Deactivated</a>
                                            @endif
                                        </td>
                                    </tr>

<div class="modal fade" id="orders_modal{{ $sub->id }}" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{$sub->subscription->title}} Orders</h4>
        </div>
        <div class="modal-body">
          <div class="row"><b>
              <div class="col-md-2">Id</div>
              <div class="col-md-2">Date</div>
              <div class="col-md-2">Order Total</div>
              <div class="col-md-2">Order Status</div>
              <div class="col-md-2">Payment Status</div>
              <div class="col-md-1">Payment Link</div>
              <div class="col-md-1">View</div></b>
              @php
                    $order_sub_data = App\Models\Order::where('user_subscription_id',$sub->id)->get();
                    // print_r($order_sub_data);
              @endphp
<hr>
                @foreach ($order_sub_data as $sub_data)

                <div class="col-md-2">{{$sub_data->order_number}}</div>
                <div class="col-md-2">{{date('d M Y',strtotime($sub_data->created_at))}}</div>
                <div class="col-md-2">₹{{ round($sub_data->pay_amount, 2) }}</div>
                <div class="col-md-2">{{ucwords($sub_data->status)}}</div>
                <div class="col-md-2">{{$sub_data->payment_status }}</div>
                <div class="col-md-1">
                    @if ($sub_data->razorpay_payment_link != '' && $sub_data->payment_status == 'Pending')
                    <a href="{{ $sub_data->razorpay_payment_link }}">Pay Here</a>
                    @endif
                </div>
                <div class="col-md-1">-</div>
                <hr>
                @endforeach

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                        @else
                        <p>No Subscriptions</p>
                        @endif
                    </div>
                </div>

                 <!-- Modal -->


                <div id="Profile" class="tabcontent">
                    <div class="section pt-7 pb-7">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="commerce">
                                        <h2>Login</h2>
                                        <form class="commerce-login-form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Full Name <span class="required">*</span></label>
                                                    <div class="form-wrap">
                                                        <input type="text" name="your-name" value="" size="40">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Email <span class="required">*</span></label>
                                                    <div class="form-wrap">
                                                        <input type="text" name="email" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Phone Number <span class="required">*</span></label>
                                                    <div class="form-wrap">
                                                        <input type="text" name="phone" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-wrap">
                                                        <input type="submit" value="LOGIN">
                                                        <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
                                                        <span>Remember me</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Reset" class="tabcontent">
                    <div class="section pt-7 pb-7">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="commerce">
                                        <h2>Login</h2>
                                        <form class="commerce-login-form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>email address <span class="required">*</span></label>
                                                    <div class="form-wrap">
                                                        <input type="text" name="your-name" value="" size="40">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>New Password <span class="required">*</span></label>
                                                    <div class="form-wrap">
                                                        <input type="password" name="your-pass" value="" size="40">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-wrap">
                                                        <input type="submit" value="Submit">

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="del_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancel Subscription</h4>
        </div>
        <div class="modal-body">
          <p>Do You Really Want To Cancel Subscription For <span class="sub_name_show"></span> ?</p>
          <form action="{{ route('subscription.cancel') }}" method="post" >
            {{ csrf_field() }}
          <div class="row">
            <div class="col-md-3">
                <input type="submit" value="yes" class="btn btn-success">
            </div>
            <div class="col-md-3">
                <input type="button" value="No" class="btn btn-danger">
            </div>
          </div>
          <input type="hidden" name="sub_id" class="sub_id">
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
@endsection
@section('scripts')
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();


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

    $(document).on('click','.cancel_sub',function(){
        var cur_val = $(this).attr('data-id');
        var cur_title = $(this).attr('data-subname');
        // alert(cur_val);
        $('.sub_name_show').text('');
        $('.sub_name_show').text(cur_title);
        $('.sub_id').val(cur_val);
        $('.modal-backdrop').removeClass('modal-backdrop');
    });

    $(document).on('click','.orders_mod',function(){
        // var cur_val = $(this).attr('data-id');
        // var cur_title = $(this).attr('data-subname');
        // alert(cur_val);
        // $('.sub_name_show').text('');
        // $('.sub_name_show').text(cur_title);
        // $('.sub_id').val(cur_val);
        $('.modal-backdrop').removeClass('modal-backdrop');
    });
</script>
@endsection
