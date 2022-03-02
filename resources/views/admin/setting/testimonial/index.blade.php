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
                <h1>Testimonials</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.settings.testimonials.create') }}" class="btn btn-success float-sm-right">Add New</a>
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
                        <table id="coupons" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $testimonial->testimonial_name }}</td>
                                    <td>{{ $testimonial->comment }}</td>
                                    <td><img src="{{ asset('storage/'. $testimonial->image ) }}" height="40px" > </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.settings.testimonials.edit', ['testimonial' => $testimonial->id] ) }}">
                                            <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            </a>
                                            <form action="{{ route('admin.settings.testimonials.destroy', ['testimonial' => $testimonial->id]) }}" method="post" class="confirm-before-delete">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @method('delete')
                                                @csrf
                                            </form>

                                        </div>
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
    $(function() {
        window.dataTable = $("#coupons").DataTable({
            ...datatableProperties
        });


    });
</script>
@endsection