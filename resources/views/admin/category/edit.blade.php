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
                <h1>Edit Category</h1>
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
                    <!-- /.card-header -->
                    <form action="{{ route('admin.categories.update', ['category' => $category->id ] ) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <input type="hidden" name="category_id" value="{{ $category->id }}" >
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Category Name</label>
                                        <input name="name" value="{{ $category->name }}" type="text" class="form-control" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="slug" class="required">Slug</label>
                                        <input name="slug" value="{{ $category->slug }}" type="text" class="form-control" autocomplete="off" />
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
                                        @if($category->banner_image)
                                            <a target="_blank" href="{{ asset('storage/'.$category->banner_image ) }}">Uploaded Banner Image</a>
                                        @endif


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
                                        @if($category->thumbnail_image)
                                            <a target="_blank" href="{{ asset('storage/'.$category->thumbnail_image ) }}">Uploaded Thumbnail Image</a>
                                        @endif
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

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Current Slider Images</label>
                                            <div class="row">
                                            @if (isset($category->category_images) && !empty($category->category_images->toArray()))
                                            @foreach ($category->category_images as $cat_img)
                                                <div class="col-md-3">
                                                    <img src="{{ asset('storage/categories/'.$cat_img->image ) }}" width="100%" alt="">
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="required">Meta title</label>
                                            <input name="meta_title" type="text" class="form-control" autocomplete="off" value="{{ $category->meta_title }}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="required">Meta Description</label>
                                           <textarea name="meta_description" id="" cols="30" rows="10" class="form-control">{{ $category->meta_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-main"> Update </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="col-12">


                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">FAQ's</h3>
                    </div>
                    <form action="{{ route('admin.categories.faq.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="category_id" value="{{ $category->id }}">

                                <div class="col-sm-12 faqs" id="faqs">

                                    @foreach($category->faqs as $faq)
                                    <div class="card faq-card collapsed-card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                {!! $faq->question !!}


                                            </h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <a href="{{ route('admin.categories.faq.delete', ['faq_id' => $faq->id ] ) }}" class="confirm-before-delete">
                                                    <button type="button" class="btn btn-tool" title="Remove">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <input name="question[{{ $faq->id }}]" class="form-control question" type="text" value="{!! $faq->question !!}" placeholder="Question" required />
                                            <textarea name="answer[{{ $faq->id }}]" class="form-control answer" required>{!! $faq->answer !!}</textarea>
                                        </div>
                                        <!-- /.card-body -->
                                        <!-- <div class="card-footer">
                                            Footer
                                        </div> -->
                                        <!-- /.card-footer-->
                                    </div>
                                    <!-- /.card -->
                                    @endforeach

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-main"> Update </button>
                                    <button type="button" class="btn btn-warning" id="add-faq"> Add FAQ</button>
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


    $(document).on('click', '#add-faq', function() {
        var element = $('.faq-card').last().clone();

        var randomChar = "QA" + Math.round(Math.random() * 100000);
        element.find('.answer , .question').val('');
        element.find('.card-title').text('?');
        element.find('.answer').attr('name', "answer[" + randomChar + "]");
        element.find('.question').attr('name', "question[" + randomChar + "]");
        $('#faqs').append(element);
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
