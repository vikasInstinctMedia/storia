@extends('admin.layout.app')
@section('page_title', 'Dashboard')
@section('style')
<link rel="stylesheet" href="{{ asset('template/plugins/daterangepicker/daterangepicker.css' ) }} ">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Small boxes (Stat box) -->
<div class="row">


  <!-- Main content -->
  <div class="container-fluid content">
    <div class="col-lg-12">

      <!-- Info boxes -->
      <div class="row">
        <div class="col-lg-3 col-xs-6 col-md-4">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-bag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Products</span>
              <span class="info-box-number">
                {{ $productCount }}
              </span>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-lg-3 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Branches</span>
              <span class="info-box-number">{{ $branchesCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <!-- <div class="clearfix hidden-md-up"></div> -->

        <div class="col-lg-3  col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Current Orders</span>
              <span class="info-box-number">{{ $pendingOrders }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-lg-3  col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Users</span>
              <span class="info-box-number">{{ $usersCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-8">
          <canvas id="sales-bar-chart" style="width:100%;"></canvas>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-sm-12">
              <div class="btn-group btn-group-toggle container mt-4" data-toggle="buttons">
                <label class="btn bg-secondary">
                  <input type="radio" name="options" data-filter-type="day" autocomplete="off" checked=""> Daily
                </label>
                <label class="btn bg-secondary">
                  <input type="radio" name="options" data-filter-type="week" id="option_b2" autocomplete="off"> Weekly
                </label>
                <label class="btn bg-secondary">
                  <input type="radio" name="options" data-filter-type="month" id="option_b3" autocomplete="off"> Monthly
                </label>
              </div>
            </div>
            <div class="col-sm-12 mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control float-right" id="reservation">
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->

  @endsection

  @section('script')
  <!-- OPTIONAL SCRIPTS -->
  <script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('admin/template/js/demo.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('admin/template/js/pages/dashboard3.js') }}"></script>

  <script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>

  <script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>




  <script>
    //Bar chart
    // const barChartData = "{{ $barChartData }}";

    // console.log( JSON.parse(barChartData)  );
    $('#reservation').daterangepicker()

    const data = {
      labels: ['one', 'two', 'three', 'four', 'five', 'six', 'seven'],
      datasets: [{
        label: 'My First Dataset',
        data: [65, 59, 80, 81, 56, 55, 40],
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgb(255, 99, 132)',
        borderWidth: 1
      }, {
        label: 'My sec Dataset',
        data: [65, 59, 15, 81, 56, 55, 40],
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        borderColor: 'rgb(255, 99, 132)',
        borderWidth: 1
      }]
    };

    var chartInteractionModeNearest = new Chart("sales-bar-chart", {
      type: 'bar',
      data: [],
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      },
    });



    function getDataForChart(filterWith) {

      $.ajax({
        'method': 'get',
        'url': "{{ route('admin.cfa.chart_data') }}",
        'data': {
          filterWith
        }
      }).done((res) => {
        console.log(res);
        var data = JSON.parse(res);


        var barCharData = data['data']['barChartData'];

        var chartData = {
          labels: barCharData['labels'],
          datasets: [{
            label: 'Orders',
            data: barCharData['orders_count'],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1
          }, {
            label: 'Products',
            data: barCharData['sku_count'],
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgb(255, 99, 132)',
            borderWidth: 1
          }]
        };

        chartInteractionModeNearest.data = chartData;
        chartInteractionModeNearest.update();

      });
    }


    getDataForChart('day');

    $(document).on('change', 'input[type=radio][name=options]', function() {
      console.log($(this).data('filter-type'));

      getDataForChart($(this).data('filter-type'));
    });
  </script>
  @endsection