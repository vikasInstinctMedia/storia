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
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success float-sm-right">Add New</a>
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
                <form action="{{ route('admin.products.index') }}" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select</option>
                            @foreach ($categories as $item)

                            <option value="{{ $item->id }}"
                                @if (Request::input('category_id') == $item->id)
                                selected
                                @endif
                                >{{ $item->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="submit" value="submit" class="btn btn-success">
                    </div>
                </div>
            </form>
              <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <!-- <th>Category</th> -->
                    <th>Slug</th>
                    <!-- <th>SKU</th> -->
                    <th>Thumbnail</th>
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
        var category=$('#category_id').val();
      window.dataTable = $("#products").DataTable({
          ...datatableProperties,
          ajax: "{{ route('admin.products.getlist') }}?category="+category,
          columns: [
            {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
            {data: 'name', name: 'name', orderable: false},
            // {data: 'category.name', name: 'category.name',  orderable: false },
            {data: 'slug', name: 'slug', orderable: false },
            // {data: 'sku', name: 'sku', orderable: false },
            {data: 'thumbnail_image', name: 'thumbnail_image', searchable: false, orderable: false, render: function(data, type, row) {
              console.log(data);
              return `<img src="${data}" . '" alt="" height="30px" weight="50px">`;
            }},
            {data: 'action', name: 'action', orderable: false, searchable: false, render: function(data, type, row) {
              return `<div class="btn-group">
                        <a href="${data.view_url}">
                        <button type="button" class="btn btn-success">
                          <i class="fas fa-eye"></i>
                        </button>
                        </a>
                        <a href="${data.edit_url}">
                        <button type="button" class="btn btn-warning">
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        </a>
                      </div>`;
            }},

          ],
          columnDefs : [
            { width: "4%", targets: 0 },
            { width: "30%", targets: 1 },
            { width: "7%", targets: 2 },
            { width: "10%", targets: 3 },
            { width: "15%", targets: 4 },
        ],

        });


    });

    $(document).on('change','#category_id',function(){
        // var cur_val = $(this).val();
        // alert(cur_val);
    });

    </script>
@endsection
