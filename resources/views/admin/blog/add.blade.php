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
                <h1>Create Blog</h1>
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
                    <form action="{{ isset($action) ? route('admin.blog.update',['id' => $blog->id]) : route('admin.blog.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if (isset($action))
                                            <input type="hidden" name="blog_id" id="" value="{{ $blog->id }}">
                                        @endif
                                        <label for="name" class="required">Title</label>
                                        <input name="title" type="text" class="form-control" autocomplete="off" value="{{ isset($blog->title) ? $blog->title : '' }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Slug</label>
                                        <input name="slug" type="text" class="form-control" autocomplete="off" value="{{ isset($blog->slug) ? $blog->slug : '' }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Thumbnail Image (Resolution :  957 X 957 px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="thumbnail_image" type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                        @if(isset($blog->thumbnail_image))
                                            <a target="_blank" href="{{ asset('storage/'.$blog->thumbnail_image ) }}">Uploaded Thumbnail Image</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Banner Image (Resolution :  1280 X 768 px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="banner_image" type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                        @if(isset($blog->banner_image))
                                            <a target="_blank" href="{{ asset('storage/'.$blog->banner_image ) }}">Uploaded Banner Image</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Date</label>
                                        <input name="date" type="date" class="form-control" autocomplete="off" value="{{ isset($blog->date) ? $blog->date : '' }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Author</label>
                                        <input name="auther" type="text" class="form-control" autocomplete="off" value="{{ isset($blog->auther) ? $blog->auther : '' }}" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <div class="input-group">

                                                <textarea name="description">{{ isset($blog->description) ? $blog->description : '' }}</textarea>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tags</label>

                                            <input type="text" class="form-control homefeed_tags" value="@php
                                                if(isset($home_feed_tags)){
                                                    $tag_array = [];
                                                    foreach ($home_feed_tags as $key => $value) {
                                                        array_push($tag_array,$value->tags->tag);
                                                    }
                                                    echo implode(",",$tag_array);
                                                }
                                            @endphp" name="homefeed_tags"/>

                                            @if (isset($tag_array))
                                                <input type="hidden" name="old_tags" value="{{ implode(",",$tag_array) }}">
                                            @endif

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

    $('input[name="homefeed_tags"]').amsifySuggestags({
    suggestionsAction : {
		timeout: -1,
		minChars: 2,
		minChange: -1,
		delay: 100,
		type: 'GET',
		url: "{{ route('admin.get.tags.suggestions') }}",
		dataType: null,
		beforeSend : function() {
			console.info('beforeSend');
		},
		success: function(data) {
			console.info('success');
		},
		error: function() {
			console.info('error');
		},
		complete: function(data) {
			console.info('complete');
		}
	}
	});
</script>
@endsection
