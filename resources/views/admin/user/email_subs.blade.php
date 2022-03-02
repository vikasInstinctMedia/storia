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
        <h1>Email Subscriptions</h1>
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

          <!-- /.card-header -->
          <div class="card-body">

              <table id="orders" class="table table-bordered">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                    $i=1;
                    // echo '<pre>';
                        // print_r($products);
                      foreach($get_data as $product){
                    @endphp
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $product->email }}</td>
                        <td><a href="{{ route('admin.email_sub.delete',$product->id) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></td>

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
