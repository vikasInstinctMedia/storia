@extends('admin.layout.app')
@section('page_title', 'Product')
@section('style')


@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Order <span style="color:green"> {{ $order->order_number }}
            <span< /h1>
      </div>
      <div class="col-sm-6">
        <button data-toggle="modal" data-target="#updateStatusModel" class="btn btn-success float-sm-right">Update Status</button>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">


        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Customer Details</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="divTable blueTable">
                  <div class="divTableBody">
                    <div class="divTableRow">
                      <div class="divTableCell divTableCell1">Name :</div>
                      <div class="divTableCell"> {{ $order->customer_name }}</div>
                      <div class="divTableCell divTableCell1">Phone : </div>
                      <div class="divTableCell">{{ $order->customer_phone }}</div>
                    </div>
                    <div class="divTableRow">
                      <div class="divTableCell divTableCell1"> email </div>
                      <div class="divTableCell">{{ $order->customer_email }}</div>
                      <div class="divTableCell divTableCell1"> </div>
                      <div class="divTableCell"> </div>
                    </div>
                    <div class="divTableRow">
                      <div class="divTableCell divTableCell1">Order number</div>
                      <div class="divTableCell">{{ $order->order_number }}</div>
                      <div class="divTableCell divTableCell1">AWB number</div>
                      <div class="divTableCell">{{ $order->awb_number }}</div>
                    </div>
                    <div class="divTableRow">
                      <div class="divTableCell divTableCell1">State</div>
                      <div class="divTableCell">{{ $order->customer_state }}</div>
                      <div class="divTableCell divTableCell1">City</div>
                      <div class="divTableCell">{{ $order->customer_city }}</div>
                    </div>
                    <div class="divTableRow">
                      <div class="divTableCell divTableCell1">Total Payable</div>
                      <div class="divTableCell">{{ $order->pay_amount }}</div>
                      <div class="divTableCell divTableCell1">Total Quantity </div>
                      <div class="divTableCell"> {{ $order->totalQty }}</div>
                    </div>

                    <div class="divTableRow">
                      <div class="divTableCell divTableCell1">Method</div>
                      <div class="divTableCell">{{ $order->method }}</div>
                      <div class="divTableCell divTableCell1"> Payment Status</div>
                      <div class="divTableCell">{{ $order->payment_status }} </div>
                    </div>

                    <div class="divTableRow">
                        <div class="divTableCell divTableCell1">Status</div>
                        <div class="divTableCell">{{ $order->status }}</div>

                      </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Billing And Shipping Details</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="divTable blueTable">
                  <div class="divTableBody">
                    <div class="divTableRow">
                      <div class="divTableCell divTableCell1">Billing Address :</div>
                      <div class="divTableCell">
                        Name : {{ $order->billing_address->name }}<br>
                        Email : {{ $order->billing_address->email }}<br>
                        Phone : {{ $order->billing_address->phone }}<br>
                        Country : {{ $order->billing_address->country }}<br>
                        city : {{ $order->billing_address->city }}<br>
                        address : {{ $order->billing_address->address }}<br>
                        Zip code : {{ $order->billing_address->zip }}<br>

                      </div>
                      <div class="divTableCell divTableCell1">Shipping Address : </div>
                      <div class="divTableCell">
                        @if ($order->billing_address_id == $order->shipping_address_id)
                        Same As Billing Address
                        @else

                        Name : {{ $order->shipping_address_data->name }}<br>
                        Email : {{ $order->shipping_address_data->email }}<br>
                        Phone : {{ $order->shipping_address_data->phone }}<br>
                        Country : {{ $order->shipping_address_data->country }}<br>
                        city : {{ $order->shipping_address_data->city }}<br>
                        address : {{ $order->shipping_address_data->address }}<br>
                        Zip code : {{ $order->shipping_address_data->zip }}<br>
                        @endif

                      </div>
                    </div>



                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Product Details</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
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
          <!-- /.card-body -->
        </div>


        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>


<!-- Modal -->
<div class="modal fade" id="updateStatusModel" tabindex="-1" role="dialog" aria-labelledby="updateStatusModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    @if(Auth::user()->branch_id=="")
      <form action="{{ route('admin.orders.update.status') }}" method="POST">
    @endif
    @if(Auth::user()->branch_id!="")
      <form action="{{ route('admin.cfa.orders.update.status') }}" method="POST">
    @endif
      @csrf
      <input name="order_id" type="hidden" value="{{ $order->id }}" />
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateStatusModelLabel">Update Order Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <label for="status"> Status </label>
              <select name="status" class="form-control">
                <option value="{{ \App\Models\Order::PENDING }}" >Pending</option>
                <option value="{{ \App\Models\Order::PROCESSING }}">Processing</option>
                <option value="{{ \App\Models\Order::COMPLETED }}">Completed</option>
                <option value="{{ \App\Models\Order::DECLINED }}">Declined</option>
                <option value="{{ \App\Models\Order::DELIVERY }}">On Delivery</option>
                <option value="{{ \App\Models\Order::CANCELLED }}">Cancel</option>
              </select>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('script')


<script>
  $(function() {


  });
</script>
@endsection
