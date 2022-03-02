@extends('admin.layout.app')
@section('page_title', 'Category')
@section('style')

@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Category</h1>
            </div>
            <div class="col-sm-6">
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
                    <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Category Name</label>
                                        <input name="name" type="text" class="form-control" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="slug" class="required">Slug</label>
                                        <input name="slug" type="text" class="form-control" autocomplete="off" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Banner Image (Resolution : 1920 X 470 px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="banner_image" type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Thumbnail Image (Resolution: 1000 X 1000 px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="thumbnail_image" type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Slider Images
                                            <button class="btn btn-success add_slider_image">Add Image</button>
                                        </label>
                                        <div class="input-group add_img_here">

                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-main"> Create </button>
                                </div>
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
<!-- /.content -->
</div>

@endsection

@section('script')

<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>

<script>
    $(function() {
        bsCustomFileInput.init();



    });
    $(document).on('click','.add_slider_image',function(e){
        e.preventDefault();
        $('.add_img_here').append('<div class="row main_div" style="margin-bottom: 5px;"><div class="col-md-5"><input type="file" name="slider_images[]" id="" class="form-control"></div><div class="col-md-5"><input type="text" name="slider_url[]" placeholder="Add redirect Url" class="form-control" id=""></div><div class="col-md-2"><button class="btn btn-danger remove_image">X</button></div>');
    });

    $(document).on('click','.remove_image',function(e){
        e.preventDefault();
        $(this).closest('.main_div').remove();
    });
</script>
@endsection
