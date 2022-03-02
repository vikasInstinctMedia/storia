@extends('admin.layout.app')
@section('page_title', 'Category')
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
            <h1>Blog</h1>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('admin.blog.create') }}" class="btn btn-success float-sm-right">Add New</a>
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
                    {{-- <th>Slug</th> --}}
                    <th>Thumbnail Image</th>
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
          ajax: "{{ route('admin.blog.getlist') }}",
          columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
            {data: 'title', name: 'title'},
            // {data: 'slug', name: 'slug'},
            {data: 'thumbnail_image', name: 'thumbnail_image', searchable: false, orderable: false, render: function(data, type, row) {
              console.log(data);
              return `<img src="${data}" . '" alt="" height="30px" weight="50px">`;
            }},
            {data: 'action', name: 'action', orderable: false, searchable: false, render: function(data, type, row) {


              return `<div class="btn-group">
                        <a href ='${data.edit_url}'>
                        <button type="button" class="btn btn-warning">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        </a>
                        <a href ='${data.delete_url}'>
                        <button type="button" class="btn btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                        </a>
                      </div>`;
            }},
          ],

        });


    });

    </script>
@endsection
