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
                <h1>Create Recipe</h1>
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
                    <form action="{{ isset($action) ? route('admin.recipe.recipe_update',['id' => $recipe->id]) : route('admin.recipe.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if (isset($action))
                                            <input type="hidden" name="recipe_id" id="" value="{{ $recipe->id }}">
                                        @endif
                                        <label for="name" class="required">Title</label>
                                        <input name="title" type="text" class="form-control" autocomplete="off" value="{{ isset($recipe->title) ? $recipe->title : '' }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="slug" class="required">Select Category</label>
                                        <select name="recipe_category_id" id="" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($rec_category as $rec_cat)
                                                <option value="{{ $rec_cat->id }}"
                                                    @if (isset($recipe))
                                                    @if ($recipe->recipe_category_id == $rec_cat->id)
                                                        selected
                                                    @endif
                                                    @endif
                                                    >{{ $rec_cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Thumbnail Image (Resolution : 870 X 470 px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="thumbnail_image" type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                        @if(isset($recipe->thumbnail_image))
                                            <a target="_blank" href="{{ asset('storage/'.$recipe->thumbnail_image ) }}">Uploaded Thumbnail Image</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <div class="input-group">

                                                <textarea name="description">{{ isset($recipe->description) ? $recipe->description : '' }}</textarea>

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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>
<script>
    CKEDITOR.replace( 'description' );
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
