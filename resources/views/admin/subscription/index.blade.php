@extends('admin.layout.app')
@section('page_title', 'Susbcription')
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
            <h1>Subscription List</h1>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('admin.subscription.create') }}" class="btn btn-success float-sm-right">Add New</a>
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
                    <th>Thumbnail Image</th>
                    <th>Price</th>
                    <th>Pack</th>
                    {{-- <th>Banner Image</th> --}}
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($subscription as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td><img src="{{ asset('storage/'. $item->thumbnail ) }}" alt="" style="width: 10%"></td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->pack->title }}</td>
                        <td><a href="{{ route('admin.subscription.edit',['id'=>$item->id]) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                            <a href="{{ route('admin.subscription.delete',['id'=>$item->id]) }}" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>

                    </tr>
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
