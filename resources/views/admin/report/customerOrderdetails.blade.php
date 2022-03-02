@extends('admin.layout.app')
@section('page_title', 'Product')
@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">


@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Customers Order Details</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div>
      <div class="row" style="padding: 10px 10px 0px 10px;background: #06904d;margin:5px 5px 5px 0px;">
       <form action="{{ route('admin.customer.filter') }}" method="post">
        <div class="row" style="text-align: left;">
          @csrf
            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                <select id="datetime" name="datetime" class="form-control" style="color: black;">
                    <option value="custom" <?php if($filterType=="custom"){?> selected <?php } ?>>Custom</option>
                    <option disabled="disabled">-------------------------</option>
                    <option value="yesterday" <?php if($filterType=="yesterday"){?> selected <?php } ?>>Yesterday</option>
                    <option value="today" <?php if($filterType=="today"){?> selected <?php } ?>>Today</option>
                    <option disabled="disabled">-------------------------</option>
                    <option value="lastweek" <?php if($filterType=="lastweek"){?> selected <?php } ?>>Last Week</option>
                    <option value="thisweek" <?php if($filterType=="thisweek"){?> selected <?php } ?>>This Week</option>
                    <option disabled="disabled">-------------------------</option>
                    <option value="thismonth" <?php if($filterType=="thismonth"){?> selected <?php } ?>>This Month</option>
                    <option disabled="disabled">-------------------------</option>
                    <option value="lastseven" <?php if($filterType=="lastseven"){?> selected <?php } ?>>Last 7 Days</option>
                </select>
            </div>
            <input type="hidden" value="{{ $id }}" name="id" id="id">
            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-7" style="color: black;">
                <div id="date-range">
                    <div class="form-group data-custon-pick data-custom-mg" id="data_5">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="date" class="form-control" id="start" name="start" <?php if($start!=""){?> value="{{ $start }}" <?php } ?>/>
                            <span class="input-group-addon" style="padding:0px 10px;"> to </span>
                            <input type="date" class="form-control" id="end" name="end"  <?php if($end!=""){?> value="{{ $end }}" <?php } ?>/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1" style="color: black;">
                <div>
                    <button type="submit" class="btn btn-primary">Go</button>
                </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                <!--<button type="submit" name="submit" value="submit" class="btn btn-primary"> View Details </button>-->
            </div>
        </div>
        </form>
    </div>
    </div>
    <div class="row">
      <div class="col-12">


        <div class="card">
          <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
          <!-- /.card-header -->
          <div class="card-body">
            <table id="orders" class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Customer Phone</th>
                  <th>Order Number</th>
                  <th>Branch</th>
                  <th>City</th>
                  <th>Products</th>
                  <th>No of Products</th>
                  <th>Amount</th>
                  <th>AWB</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>View</th>

                </tr>
              </thead>
              <tbody>
                @php
                  $i=1;
                  $finalTotal=0;
                  foreach($orders as $key){
                    $finalTotal+=$key->pay_amount;
                @endphp
                  <tr>
                  <td>{{ $i++ }}</td>
                  <td>{{ $key->customer_name}}</td>
                  <td>{{ $key->customer_email }}</td>
                  <td>{{ $key->customer_phone }}</td>
                  <td>{{ $key->order_number }}</td>
                  <td>{{ $key->branch->name }}</td>
                  <td>{{ $key->customer_city }}</td>
                  <td>
                    @php
                    $orderProducts =\App\Models\OrderProduct::where('order_id', $key->id)->get();
                    // print_r($orderProducts);
                    $name = '';
                    foreach ($orderProducts as $key2 => $ordpro) {
                        $maps =\App\Models\ProductPackMap::where('id', $ordpro->product_pack_map_id)->first();
                        // print_r($maps);
                        $pros = \App\Models\Product::where('id', $maps->product_id)->first();

                        $name .= $pros->name.'('.$ordpro->quantity.')'.',';
                    }
                    // echo $name;
                    echo rtrim($name, ',');

                    @endphp
                    </td>
                  <td>{{ $key->totalQty }}</td>
                  <td>{{ $key->pay_amount }}</td>
                  <td>{{ $key->awb_number }}</td>
                  <td>{{ $key->status }}</td>
                  <td>{{ date('d-m-Y',strtotime($key->created_at)) }}</td>

                    <td><a href="{{ route('admin.orders.show',[ 'order' => $key->id]) }}" class="btn btn-success"><i class="fas fa-eye"></i></a></td>

                  </tr>
                @php
                    }
                @endphp
                 <div class="card-header">
                    <h2 class="card-title"><b> Total Order Transactions = <span id="finaltotalshow">{{ $finalTotal }}</span></b></h2>
                </div>

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

@endsection

@section('script')
<script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>


  <script>
    $(function () {
//   window.dataTable = $("#orders").DataTable({
//       ...datatableProperties
//     });

$('#orders').DataTable( {
        dom: 'Bfrtip',
        "scrollX": true,
        buttons: [
            // 'copy',
            // 'csv',
            'excel',
            // 'pdf',
            // 'print'
        ]
    } );

});

$(document).ready(function(){
    $('.buttons-excel').text('');
    $('.buttons-excel').text('Export');
});
  </script>
<script>
  $("#datetime").on("change", function() {

                 var value = $("#datetime").val().toLowerCase();
                 if(value == 'all'){
                     var all = "all";
                 }
                 else if(value == 'custom'){
                     $("#date-range").show();
                     var start = $("#start").val();
                     var end = $("#end").val();
                 }
                 else if(value == 'yesterday'){
                     $("#date-range").show();
                     var start = "{{ date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d')))) }}";
                     var end = "{{ date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d')))) }}";
                     $("#start").val(start);
                     $("#end").val(end);

                 }
                 else if(value == 'today'){
                     $("#date-range").show();
                     var start = "{{ date('Y-m-d') }}";
                     var end = "{{ date('Y-m-d') }}";
                     $("#start").val(start);
                     $("#end").val(end);

                 }
                 else if(value == 'lastweek'){
                     $("#date-range").show();

                     <?php $previous_week = strtotime("-1 week +1 day");
                           $start_week = strtotime("last sunday midnight",$previous_week);
                           $end_week = strtotime("next saturday",$start_week);
                           $start_week = date("Y-m-d",$start_week);
                           $end_week = date("Y-m-d",$end_week);  ?>
                       var start = "{{ $start_week }}";
                       var end = "{{ $end_week }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
                 else if(value == 'thisweek'){
                     $("#date-range").show();
                     <?php $d = strtotime("today");
                           $start_week = strtotime("last sunday midnight",$d);
                           $end_week = strtotime("next saturday",$d);
                           $start = date("Y-m-d",$start_week);
                           $end = date("Y-m-d",$end_week); ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);
                 }
                 else if(value == 'lastmonth'){
                     $("#date-range").show();
                     <?php $last_month_first_day=strtotime('first day of last month');
                         $last_month_last_day=strtotime('last day of last month');

                           $start = date('Y-m-d',$last_month_first_day);
                           $end = date('Y-m-d',$last_month_last_day); ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
                 else if(value == 'thismonth'){
                     $("#date-range").show();
                     <?php $this_month_first_day=strtotime('first day of this month');
                         $this_month_last_day=strtotime('last day of this month');

                           $start = date('Y-m-d',$this_month_first_day);
                           $end = date('Y-m-d',$this_month_last_day); ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
                 else if(value == 'lastsix'){
                     $("#date-range").show();
                     <?php $start = date("Y-m-d", strtotime("-6 months"));
                           $end = date('Y-m-d'); ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
                 else if(value == 'lastyear'){
                     $("#date-range").show();
                     <?php $start = date("Y-m-d",strtotime("last year January 1st"));
                           $end = date("Y-m-d",strtotime("last year December 31st")); ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
                 else if(value == 'thisyear'){
                     $("#date-range").show();
                     <?php $start = date("Y-m-d",strtotime("this year January 1st"));
                           $end = date("Y-m-d",strtotime("this year December 31st")); ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
                 else if(value == 'lastseven'){
                     $("#date-range").show();
                     <?php $start = date('Y-m-d', strtotime('-7 day', strtotime(date('d-M-Y'))));
                           $end = date('Y-m-d');  ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
                 else if(value == 'lastthierty'){
                     $("#date-range").show();
                     <?php $start = date('Y-m-d', strtotime('-30 day', strtotime(date('d-M-Y'))));
                           $end = date('Y-m-d');  ?>
                       var start = "{{ $start }}";
                       var end = "{{ $end }}";
                       $("#start").val(start);
                       $("#end").val(end);

                 }
               });
</script>
@endsection
