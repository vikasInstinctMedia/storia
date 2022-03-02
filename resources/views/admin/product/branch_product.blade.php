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
            {{-- <a href="{{ route('admin.cfa.products.create') }}" class="btn btn-success float-sm-right">Add New</a> --}}
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
                    
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td><img src="{{  asset("storage/".$item->thumbnail_image) }}" alt="" height="30px" weight="50px"></td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.show',[ 'product' => $item->id]) }}">
                                    <button type="button" class="btn btn-success">
                                      <i class="fas fa-eye"></i>
                                    </button>
                                    </a>
                                    {{-- <a href="{{ route('admin.products.edit', ['product' => $item->id]) }}">
                                    <button type="button" class="btn btn-warning">
                                      <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    </a> --}}
                                  </div>
                            </td>
                         <tr></tr>   
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

@endsection

@section('script')
    <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script>
   

    </script>
@endsection