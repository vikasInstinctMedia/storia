@extends('admin.layout.app')
@section('page_title', 'Banner')
@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@endsection
@section('content')
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 78px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    </style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Banners</h1>
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

                    <div class="card-header">
                        <h3 class="card-title">Add Banner</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.settings.banner.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="required" for="image">banner Image (Resolution : 1920 X 470 px)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input" id="banner-image" required>
                                            <label class="custom-file-label" for="banner-image">Choose file</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-5">
                                    <label for="redirect_url">Redirect_url</label>
                                    <input name="redirect_url" type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-main" style="margin-top:30px"> Add </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card">
                    <!-- <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div> -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="banners" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Redirect_Url</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banners as $banner)
                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td><img src="{{ asset('storage/'. $banner->image) }}" height="60px" width="auto"></td>
                                    <td>{{ $banner->redirect_url }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.settings.banner.delete', ['banner' => $banner->id ]) }}">
                                                <button type="button" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        <form action="{{ route('admin.settings.banner.seq.store') }}" method="post">
                            {{ csrf_field() }}

                        <ul id="sortable">
                            @foreach($banners as $banner)
                            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <img src="{{ asset('storage/'. $banner->image) }}" height="60px" width="auto">
                                <input type="hidden" name="seq[]" value="{{ $banner->id }}">
                            </li>
                            @endforeach
                        </ul>
                        <input type="submit" value="Save Sequence" class="btn btn-success">
                        </form>
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

<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>

<script>
    $(function() {
        bsCustomFileInput.init();

        window.dataTable = $("#banners").DataTable({
            ...datatableProperties,
        });


    });
</script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
$( function() {
  $( "#sortable" ).sortable();
} );
</script>
@endsection
