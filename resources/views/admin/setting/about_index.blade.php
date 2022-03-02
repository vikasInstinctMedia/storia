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
                <h1>Slider 1</h1>
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
                        <form method="post" action="{{ route('admin.settings.about_us.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="required" for="image">banner Image (Resoultion:1920 X 1000 px)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input" id="banner-image" required>
                                            <label class="custom-file-label" for="banner-image">Choose file</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <label for="redirect_url">Redirect_url</label>
                                    <input name="redirect_url" type="text" class="form-control">
                                </div>

                                <div class="col-sm-5">
                                    <label for="redirect_url">Title</label>
                                    <input name="title" type="text" class="form-control">
                                </div>
                                <div class="col-sm-12">
                                    <label for="redirect_url">Description</label>
                                    <textarea class="form-control" name="description"></textarea>
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
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($about_us_data['slider_1']))
                                    @foreach($about_us_data['slider_1'] as $banner)

                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td><img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto"></td>
                                    <td>{{ $banner['redirect_url'] }}</td>
                                    <td>{{ $banner['title'] }}</td>
                                    <td>{{ $banner['description'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.settings.about_us.delete', ['banner' => $loop->iteration ]) }}">
                                                <button type="button" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                        {{-- <form action="{{ route('admin.settings.banner.seq.store') }}" method="post">
                            {{ csrf_field() }}

                        <ul id="sortable">
                         @if (isset($about_us_data['slider_1']))
                                    @foreach($about_us_data['slider_1'] as $banner)
                            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto">
                                <input type="hidden" name="seq[]" value="{{ $loop->iteration }}">
                            </li>
                            @endforeach
                        @endif
                        </ul>
                        <input type="submit" value="Save Sequence" class="btn btn-success">
                        </form> --}}
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


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Slider 2</h1>
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
                        <form method="post" action="{{ route('admin.settings.about_us2.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="required" for="image">banner Image (Resolution : 1920 X 500 px)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input" id="banner-image" required>
                                            <label class="custom-file-label" for="banner-image">Choose file</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <label for="redirect_url">Redirect_url</label>
                                    <input name="redirect_url" type="text" class="form-control">
                                </div>

                                <div class="col-sm-5">
                                    <label for="redirect_url">Title</label>
                                    <input name="title" type="text" class="form-control">
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
                                @if (isset($about_us_data['slider_2']))
                                    @foreach($about_us_data['slider_2'] as $banner)

                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td><img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto"></td>
                                    <td>{{ $banner['redirect_url'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.settings.about_us2.delete', ['banner' => $loop->iteration ]) }}">
                                                <button type="button" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                        {{-- <form action="{{ route('admin.settings.banner.seq.store') }}" method="post">
                            {{ csrf_field() }}

                        <ul id="sortable">
                         @if (isset($about_us_data['slider_2']))
                                    @foreach($about_us_data['slider_2'] as $banner)
                            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto">
                                <input type="hidden" name="seq[]" value="{{ $loop->iteration }}">
                            </li>
                            @endforeach
                        @endif
                        </ul>
                        <input type="submit" value="Save Sequence" class="btn btn-success">
                        </form> --}}
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

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Images Section</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success float-sm-right">Add New</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Add Images</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.settings.about_us3.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="required" for="image">Image1 (Resolution : 1200 X 981 px)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image1" type="file" class="custom-file-input" id="banner-image" >
                                            <label class="custom-file-label" for="banner-image">Choose file</label>

                                        </div>
                                        @if (isset($about_us_data['images_new']['image1']))
                                        <img src="{{ asset('storage/'. $about_us_data['images_new']['image1']) }}" alt="" width="40%">
                                       @endif
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <label for="redirect_url">Redirect_url</label>
                                    <input name="redirect_url1" type="text" class="form-control" value="{{ isset($about_us_data['images_new']['redirect_url1']) ? $about_us_data['images_new']['redirect_url1'] : ''  }}">
                                </div>

                                <div class="col-sm-5">
                                    <label for="redirect_url">Title</label>
                                    <input name="title1" type="text" class="form-control" value="{{ isset($about_us_data['images_new']['title1']) ? $about_us_data['images_new']['title1'] : ''  }}">
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="required" for="image">Image2 (Resolution: 760 X 199 px)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image2" type="file" class="custom-file-input" id="banner-image">
                                            <label class="custom-file-label" for="banner-image">Choose file</label>
                                        </div>
                                        @if (isset($about_us_data['images_new']['image2']))
                                        <img src="{{ asset('storage/'. $about_us_data['images_new']['image2']) }}" alt="" width="40%">
                                       @endif
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <label for="redirect_url">Redirect_url</label>
                                    <input name="redirect_url2" type="text" class="form-control" value="{{ isset($about_us_data['images_new']['redirect_url2']) ? $about_us_data['images_new']['redirect_url2'] : ''  }}">
                                </div>

                                <div class="col-sm-5">
                                    <label for="redirect_url">Title</label>
                                    <input name="title2" type="text" class="form-control" value="{{ isset($about_us_data['images_new']['title2']) ? $about_us_data['images_new']['title2'] : ''  }}">
                                </div>

                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-main" style="margin-top:30px"> Add </button>
                                </div>
                            </div>

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

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Instagram Slider</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success float-sm-right">Add New</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Add Banner For Instagram Slider</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.settings.about_us4.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="required" for="image">banner Image(Resolution: 570 X 440 px)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input" id="banner-image" required>
                                            <label class="custom-file-label" for="banner-image">Choose file</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <label for="redirect_url">Redirect_url</label>
                                    <input name="redirect_url" type="text" class="form-control">
                                </div>

                                <div class="col-sm-5">
                                    <label for="redirect_url">Title</label>
                                    <input name="title" type="text" class="form-control">
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
                                @if (isset($about_us_data['instagram_slider']))
                                    @foreach($about_us_data['instagram_slider'] as $banner)

                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td><img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto"></td>
                                    <td>{{ $banner['redirect_url'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.settings.about_us4.delete', ['banner' => $loop->iteration ]) }}">
                                                <button type="button" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                        {{-- <form action="{{ route('admin.settings.banner.seq.store') }}" method="post">
                            {{ csrf_field() }}

                        <ul id="sortable">
                         @if (isset($about_us_data['slider_2']))
                                    @foreach($about_us_data['slider_2'] as $banner)
                            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto">
                                <input type="hidden" name="seq[]" value="{{ $loop->iteration }}">
                            </li>
                            @endforeach
                        @endif
                        </ul>
                        <input type="submit" value="Save Sequence" class="btn btn-success">
                        </form> --}}
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

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Clients Slider</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success float-sm-right">Add New</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Add Banner For Our Client Slider</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.settings.about_us5.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="required" for="image">banner Image (Resolution: 120 X 120 px)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input" id="banner-image" required>
                                            <label class="custom-file-label" for="banner-image">Choose file</label>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-sm-5">
                                    <label for="redirect_url">Name</label>
                                    <input name="title" type="text" class="form-control">
                                </div>
                                <div class="col-sm-12">
                                    <label for="redirect_url">Description</label>
                                    <textarea class="form-control" name="description"></textarea>
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

                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($about_us_data['client_slider']))
                                    @foreach($about_us_data['client_slider'] as $banner)

                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td><img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto"></td>

                                    <td>{{ $banner['title'] }}</td>
                                    <td>{{ $banner['description'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.settings.about_us5.delete', ['banner' => $loop->iteration ]) }}">
                                                <button type="button" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach
                                @endif

                            </tbody>
                        </table>
                        {{-- <form action="{{ route('admin.settings.banner.seq.store') }}" method="post">
                            {{ csrf_field() }}

                        <ul id="sortable">
                         @if (isset($about_us_data['slider_1']))
                                    @foreach($about_us_data['slider_1'] as $banner)
                            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <img src="{{ asset('storage/'. $banner['image']) }}" height="60px" width="auto">
                                <input type="hidden" name="seq[]" value="{{ $loop->iteration }}">
                            </li>
                            @endforeach
                        @endif
                        </ul>
                        <input type="submit" value="Save Sequence" class="btn btn-success">
                        </form> --}}
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
