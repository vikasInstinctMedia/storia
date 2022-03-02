@extends('admin.layout.app')
@section('page_title', 'Product')
@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Product Review Report</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div>
        @php
            $reqdata = request()->post();
            // print_r($reqdata);
            $user_id = isset($reqdata['user_id']) ? $reqdata['user_id'] : '';
        @endphp
      <div class="row" style="padding: 10px 10px 0px 10px;background: #06904d;margin:5px 5px 5px 0px;">

        <form action="{{ route('admin.reviewReport') }}" method="get">
            @if ($user_id != '')
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            @endif
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
                  <th>Product Name</th>
                  <th>Author</th>
                  <th>Email</th>
                  <th>Comment</th>
                  <th>Status</th>
                  <th>Add Reply</th>
                  <th>Reply's</th>
                  <th>Action</th>

                </tr>
              </thead>
              <tbody>
                @php
                  $i=1;

                  foreach($Review as $key){

                @endphp
                  <tr>
                  <td>{{ $i++ }}</td>
                  <td>{{ $key->product->name }}</td>
                  <td>{{ $key->author }}</td>
                  <td>{{ $key->email }}</td>
                  <td>{{ $key->comment }}</td>
                  <td>@if($key->status=="1")
                    <h5 style="background-color: green;color:white;">Approved</h5>
                    @else
                    <h5 style="background-color: red;color:white;">Rejected</h5>
                    @endif
                    </td>
                  <td>
                    <form action="{{ route('admin.reviewReplyAdd') }}" method="post">
                      @csrf
                      <input type="hidden" value="{{ $key->id }}" id="revieId" name="revieId">
                      <textarea name="reply" id="reply" class="form-control"  required></textarea><br>
                      <input type="submit" value="Add" class="btn btn-primary">
                    </form>
                    </td>
                  <td>
                    @php
                        $review_reply = \App\Models\Review_reply::where('review_id', $key->id)->get();
                        $i=1;
                    @endphp
                    @foreach($review_reply as $replys)
                      <p style="display: inline-block">{{ $i++ }}){{ $replys->reply }}</p>
                      <a href="{{ route('admin.delete_reply') }}?id={{ $replys->id }}" class="btn btn-danger">Delete</a>
                      <br>
                    @endforeach
                  </td>
                  <td>
                    <button type="button" class="btn btn-success"  data-id="{{ $key->id }}" data-status="{{ $key->status }}"  data-status_comment="{{ $key->status_comment }}"  onclick="editDesg_fun(this)">Change Status</button>
                    <a href="{{ route('admin.review_delete') }}?id={{ $key->id }}" class="btn btn-danger">Delete</a>
                  </td>
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
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Review Status</h4>
          </div>
          <form method="post" action="{{ route('admin.reviewStatusupdate') }}">
            @csrf
          <div class="modal-body">
            <input type="hidden" name="reivewId" id="reivewId" class="form-control"><br>
            <label for="">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="1">Approve</option>
              <option value="0">Rejected</option>
            </select><br><br>
            <label for="">Comment</label>
            <textarea class="form-control" name="status_comment" id="status_comment"></textarea>
          </div>
          <div class="modal-footer">
            <input  type="submit" value="Update" class="btn btn-primary" onclick="return confirm('Are you sure Want to Update?')">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>

      </div>
    </div>
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


  <script>
    $(function () {
  window.dataTable = $("#orders").DataTable({
      ...datatableProperties
    });


});
function editDesg_fun(d){
      var revieId = d.getAttribute("data-id");
      var status_comment=d.getAttribute("data-status_comment");
      var status=d.getAttribute("data-status");


      $("#reivewId").val(revieId);
      $('#status  option[value='+status+']').prop("selected", true);
      $("#status_comment").val(status_comment);

      $("#myModal").modal("show");
      }
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
