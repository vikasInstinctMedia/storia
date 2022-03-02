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
                <h1>Page</h1>
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
                    <form action="{{ isset($action) ? route('admin.page_update',['id' => $get_page_data->id]) : route('admin.page_store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        @if (isset($action))
                                            <input type="hidden" name="recipe_id" id="" value="{{ $get_page_data->id }}">
                                        @endif
                                        <label for="name" class="required">Title</label>
                                        <input name="title" type="text" class="form-control" autocomplete="off" value="{{ isset($get_page_data->key) ? $get_page_data->key : '' }}" />
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="required">Slug</label>
                                        <input name="slug" type="text" class="form-control" autocomplete="off" value="{{ isset($get_page_data->slug) ? $get_page_data->slug : '' }}" />
                                    </div>
                                </div>



                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Page data</label>
                                        <div class="input-group">

                                                <textarea name="description" id="description">{{ isset($get_page_data->value) ? $get_page_data->value : '' }}</textarea>

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
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script> --}}
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>
<script>
    CKEDITOR.replace( 'description', {height: 1200 , width : 1200} );
</script>
<script>
    // ClassicEditor
    //     .create( document.querySelector( '#description' ) )
    //     .catch( error => {
    //         console.error( error );
    //     } );
</script>
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
