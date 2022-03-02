@extends('admin.layout.app')
@section('page_title', 'User')
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
            <h1>User list</h1>
          </div>
          <div class="col-sm-6">
            <!-- <a href="{{ route('admin.categories.create') }}" class="btn btn-success float-sm-right">Add New</a> -->
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
                <table id="categories" class="table table-bordered">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Total Orders</th>
                    <th>Email</th>
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
    $(function () {
      window.dataTable = $("#categories").DataTable({
          ...datatableProperties,
          ajax: "{{ route('admin.users.getlist') }}",
          columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
            {data: 'name', name: 'name'},
            {data: 'orders_count', name: 'orders_count'},
            {data: 'email', name: 'email '},
            // {data: 'banner_image', name: 'banner_image', searchable: false, orderable: false, render: function(data, type, row) {
            //   console.log(data);
            //   return `<img src="${data}" . '" alt="" height="30px" weight="50px">`;
            // }},
            {data: 'action', name: 'action', orderable: false, searchable: false, render: function(data, type, row) {

              
              return `<div class="btn-group">
                        <a href ='${data.edit_url}'>
                        <button type="button" class="btn btn-warning">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        </a>
                        <button type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>`;
            }},
          ],
          
        });

        
    });

    </script>
@endsection