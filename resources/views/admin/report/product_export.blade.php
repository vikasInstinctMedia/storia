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
        <h1>All Product Stock Report</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div>
      <div class="row" style="padding: 10px 10px 0px 10px;background: #06904d;margin:5px 5px 5px 0px;">
    @php
        $reqdata = request()->input();
        $category_id = isset($reqdata['category_id']) ? $reqdata['category_id'] : '';
    @endphp
       <form action="{{ route('admin.productstock') }}" method="get" style="display: none">

        <div class="row" style="text-align: left;">
          {{-- <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
            <select class="form-control" id="status" name="status">
              <option value="" <?php if($status==""){?> selected <?php } ?>> -- Select Status -- </option>
              <option value="pending" <?php if($status=="pending"){?> selected <?php } ?>>Pending</option>
              <option value="processing" <?php if($status=="processing"){?> selected <?php } ?>>Processing</option>
              <option value="completed" <?php if($status=="completed"){?> selected <?php } ?>>Completed</option>
              <option value="declined" <?php if($status=="declined"){?> selected <?php } ?>>Declined</option>
              <option value="on delivery" <?php if($status=="on delivery"){?> selected <?php } ?>>On Delivery</option>
              <option value="cancelled" <?php if($status=="cancelled"){?> selected <?php } ?>>Cancel</option>
            </select>
          </div> --}}


          <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select Category</option>
              @foreach($category_data as $cat)
              <option value="{{ $cat->id }}" <?php if($category_id==$cat->id){?> selected <?php } ?>>{{ $cat->name }}</option>
              @endforeach
            </select>
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

          <!-- /.card-header -->
          <div class="card-body">

              <table id="orders" class="table table-bordered">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Branch</th>
                    <th>Product Name</th>
                    <th>Slug</th>
                    <th>Category</th>
                    <th>Packs</th>
                    <th>Type</th>
                    <th>Unit Price</th>
                    <th>Description</th>
                    <th>USP</th>
                    <th>Ingredients</th>
                    <th>nutritional information</th>
                    <th>know your fruit title</th>
                    <th>know your fruit desc</th>
                    <th>fruiticons</th>
                    <th>Status</th>
                    <th>Thumbnail</th>
                    <th>Stock</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                    $i=1;
                    // echo '<pre>';
                        // print_r($products);
                      foreach($products as $product){
                        $procats =\App\Models\ProductCategory::where('product_id', $product->pro_id)->where('category_id',$category_id)->get();
                        if($category_id != '' && count($procats) == 0){
                            continue;
                        }
                        @endphp

                        <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $product->br_name }}</td>
                        <td>{{ $product->pro_name  }}</td>
                        <td>{{ $product->pro_slug }}</td>
                       <td>
                        @php
                        $procats2 =\App\Models\ProductCategory::with(['category'])->where('product_id', $product->pro_id)->get();
                        foreach ($procats2 as $key2 => $pro_cat) {
                           echo $pro_cat->category->name.',';
                        }
                        @endphp
                        <td>
                            @php
                        $packmaps =\App\Models\ProductPackMap::with(['details'])->where('product_id', $product->pro_id)->get();
                        foreach ($packmaps as $key3 => $pro_map) {
                           echo $pro_map->details->title.'(sku - '.$pro_map->sku.' | discount '.$pro_map->discount.'),';
                        }
                        @endphp
                        </td>
                        <td>{{ $product->type }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            @php
                            $pro_usp = json_decode($product->usp,true);
                            if(!empty($pro_usp))
                            {
                                foreach ($pro_usp as $key4 => $uspdata) {
                                echo $uspdata['usp'].',';
                            }
                            }
                            @endphp
                        </td>

                        <td>
                            @php

                            $pro_ing = json_decode($product->ingredients,true);
                            if(!empty($pro_ing)){

                            foreach ($pro_ing as $key4 => $ingdata) {
                                echo $ingdata['ingredient'].',';
                            }
                            }
                            // print_r($pro_ing);
                            @endphp
                        </td>
                        <td>{{ $product->nutritional_information }}</td>
                        <td>{{ $product->know_your_fruit_title }}</td>
                        <td>{{ $product->know_your_fruit_desc }}</td>
                        <td>

                            @php

$pro_frt = json_decode($product->fruiticons,true);
if(!empty($pro_frt)){

foreach ($pro_frt as $key5 => $frtdata) {
    echo $frtdata['fruiticon'].',';
}
}
// print_r($pro_frt);
@endphp
                        </td>
                        <td>
                        @php
                            if($product->is_active == 1){
                                echo 'Active';
                            }else{
                                echo 'In-active';
                            }
                        @endphp
                        </td>
                        <td><img src="{{ asset('storage/'.$product->pro_thumb) }}" height="100px" width="150px"></td>
                        <td>{{ $product->quantity }}</td>

                      </tr>

                    @php
                    }
                    @endphp


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
        buttons: [
            // 'copy',
            // 'csv',
            'excel',
            // 'pdf',
            // 'print'
        ]
    } );


    //var totalfinal=$('#finalTotal').val();
    //$('#finaltotalshow').text(totalfinal);

});


$(document).on('change','#category_id',function(){
    var cur_val = $(this).val();
    // alert(cur_val);
    $('#export_cat').val(cur_val);
});
</script>
@if (auth()->user()->roleIs('branch_admin'))
<script>
    $(document).ready(function(){
    $('.buttons-excel').text('');
    $('.buttons-excel').text('Export');
    $('.buttons-excel').click();
    // window.close();
    var myWindow = window.open("", "_self");
  myWindow.document.write("");
  window.location = "{{ route('admin.cfa.productstock') }}";
//   setTimeout (function() {myWindow.close();},2000);
});

</script>
@else
<script>
    $(document).ready(function(){
    $('.buttons-excel').text('');
    $('.buttons-excel').text('Export');
    $('.buttons-excel').click();
    // window.close();
    var myWindow = window.open("", "_self");
  myWindow.document.write("");
  window.location = "{{ route('admin.productstock') }}";
//   setTimeout (function() {myWindow.close();},2000);
});

</script>
@endif

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
