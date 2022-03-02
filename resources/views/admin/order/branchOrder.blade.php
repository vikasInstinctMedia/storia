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
        <h1>Orders</h1>
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
          <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
          <!-- /.card-header -->
          <div class="card-body">
            <table id="orders" class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Branch</th>
                  <th>Order Number</th>
                  <th>City</th>
                  <th>No of Products</th>
                  <th>Amount</th>
                  <th>AWB</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>


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

<script>
  $(function() {

    var selectedBranch = '';

    window.dataTable = $("#orders").DataTable({
      ...datatableProperties,
      serverSide: true,
      ajax:  {
          "url": "{{ route('admin.cfa.orders.getlist') }}",
          "data": function ( d ) {
              d.selected_branch = selectedBranch;
          }
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'id',
          orderable: false,
          searchable: false
        },
        {
          data: 'branch.name',
          name: 'branch.name',
          orderable: false
        },
        {
          data: 'order_number',
          name: 'order_number',
          orderable: false
        },
        {
          data: 'customer_city',
          name: 'customer_city',
          orderable: false
        },
        {
          data: 'totalQty',
          name: 'totalQty',
          orderable: false
        },
        {
          data: 'pay_amount',
          name: 'pay_amount',
          orderable: false
        },
        {
          data: 'awb_number',
          name: 'awb_number',
          orderable: false
        },
        {
          data: 'status',
          name: 'status',
          orderable: false
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false,
          render: function(data, type, row) {
            return `<div class="btn-group">
                        <a href="${data.view_url}">
                        <button type="button" class="btn btn-success">
                          <i class="fas fa-eye"></i>
                        </button>
                        </a>
                      </div>`;
          }
        },

      ],
      columnDefs: [{
          width: "4%",
          targets: 0
        },
        {
          width: "30%",
          targets: 1
        },
        {
          width: "7%",
          targets: 2
        },
        {
          width: "10%",
          targets: 3
        },
        {
          width: "15%",
          targets: 4
        },
        {
          width: "19%",
          targets: 5
        },
        {
          width: "15%",
          targets: 6
        },
      ],
      initComplete: function(settings, json) {
        // Search with enter key only
        $('#orders_filter input').unbind();
        $('#orders_filter input').bind('keyup', function(e) {
          if (e.keyCode == 32) this.value += ' ';
          if (e.keyCode != 13) {
            dataTable.search(this.value).draw();
          }

        });
        console.log(json.branches);

        let optionsStr = '';
        for (let branch of json.branches) {
          optionsStr += `<option value="${branch.id}">${branch.name}</option>`;
        }

        $('#orders_filter').prepend(`<span style="display:inline-flex" >
                <select class="form-control" id="branch_select">
                  <option value=""> -- Select Branch -- </option>
                  ${optionsStr}
                </select>
            </span>`);
      },

    });

    //
    $(document).on('change', '#branch_select', function () {
      // console.log($(this).val());
      selectedBranch = $(this).val()
      window.dataTable.draw();
    });

  });
</script>
@endsection
