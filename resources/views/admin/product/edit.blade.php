@extends('admin.layout.app')
@section('page_title', 'Product')
@section('style')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/plugins/dropzone/min/dropzone.min.css') }}">
<style>
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
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
            <form action="{{ route('admin.products.update', ['product' => $product->id ]) }}" method="post" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                <div class="row gutters-5">

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Product Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Product Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input name="name" value="{{ old('name', $product->name) }}" type="text" class="form-control" placeholder="Product Name" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Category <span class="text-danger">*</span></label>
                                    <div class="col-md-8">

                                        <select name="category_ids[]" class="form-control" id="category_id" style="width: 100%;" multiple>
                                            <option value="">Select</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, $product->categories->pluck('category_id')->toArray()) ? 'selected' : ''}}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Packs<span class="text-danger">*</span></label>
                                    <div class="col-md-8">

                                        <select name="packs[]" class="form-control" id="packs" style="width: 100%;" multiple>

                                            @foreach($packs as $pack)
                                            <option value="{{ $pack->id }}" {{ in_array($pack->id, $product->packs->pluck('pack_id')->toArray()) ? 'selected' : ''}}>{{ $pack->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Type <span class="text-danger">*</span></label>
                                    <div class="col-md-8">

                                        <select name="type" class="form-control" id="type" style="width: 100%;">
                                            <option value="">Select</option>
                                            <option value="regular" {{ $product->type == 'regular'? 'selected':'' }}>Regular</option>
                                            <option value="assorted" {{ $product->type == 'assorted'? 'selected':'' }} >Assorted</option>
                                        </select>


                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">For Festival</label>
                                    <div class="col-md-8">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="season" value="1" {{ $product->season ? 'checked' : '' }}  >
                                            <span></span>
                                        </label>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Slug<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input name="slug" value="{{ old('slug', $product->slug) }}" type="text" class="form-control" placeholder="slug">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Product Images</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="signinSrEmail">Gallery Images <small>(500x500)</small></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="banner_image" type="file" class="custom-file-input" id="banner-image">
                                                <label class="custom-file-label" for="banner-image">Choose file</label>
                                            </div>
                                        </div>
                                        @if($product->banner_image)
                                        <a href="{{ asset('storage/'. $product->banner_image) }}" target="_blank"> Uploaded image</a></br>
                                        @endif
                                        <small class="text-muted">These images are visible in product details page gallery. Use 500x500 (or less) sizes image with aspect ratio of 1:1.</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="signinSrEmail">Thumbnail Image <small>(300x300)</small></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="thumbnail_image[]" type="file" multiple class="custom-file-input" id="thumbnail-image">
                                                <label class="custom-file-label" for="thumbnail-image">Choose file</label>
                                            </div>
                                        </div>
                                        <small class="text-muted">This image is visible in all product box. Use 300x300 sizes image with aspect ratio of 1:1. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.</small>
                                        <div class="show-uploaded-images">

                                            @foreach($product->images as $image)
                                            <a href="{{ asset('storage/'. $image->image) }}" target="_blank">Uploaded image {{ $loop->iteration }}</a>
                                            @endforeach

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Product price + stock</h5>
                            </div>
                            <div class="card-body">

                                
                                <div class="form-group row" id="included_products_container" style="{{ $product->type != 'assorted' ? 'display:none' : '' }}">
                                    <label class="col-md-3 col-from-label">Products <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <select name="included_products[]" class="form-control" id="included_products" style="" multiple>
                                            <option value="">Select</option>
                                            @foreach($products as $singleProduct)
                                            <option value="{{ $singleProduct->id }}" {{ in_array($singleProduct->id, $includedProductsIdsArray ) ? 'selected' : '' }} >{{ $singleProduct->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Unit price <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="number" name="price" value="{{ old('price', $product->price) }}" lang="en" min="0" value="0" step="0.01" placeholder="Unit price" class="form-control" required="">
                                    </div>
                                </div>

                                <div id="show-hide-div">
                                    @foreach($product->packs as $pack)
                                    <div class="form-group row sku-div">
                                        <label class="col-md-3 col-from-label">
                                            SKU({{ $pack->details->title }})
                                        </label>
                                        <div class="col-md-6">
                                            <input name="sku[{{ $pack->details->id }}]" value="{{  $pack->sku }}" type="text" placeholder="SKU" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <input name="discount[{{ $pack->details->id }}]" value="{{  $pack->discount }}" lang="en" min="0" value="0" step="0.01" type="number" placeholder="Discount For SKU" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <br>
                                <div class="sku_combination" id="sku_combination">

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Product Description</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Description</label>
                                    <div class="col-md-8">
                                        <textarea name="description" rows="8" class="form-control">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">SEO Meta Tags</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Meta Title</label>
                                    <div class="col-md-8">
                                        <input name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" type="text" class="form-control" placeholder="Meta Title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">Description</label>
                                    <div class="col-md-8">
                                        <textarea name="meta_description" rows="8" class="form-control">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="signinSrEmail">meta Images <small>(600x600)</small></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="meta_image" type="file" class="custom-file-input" id="meta-image">
                                                <label class="custom-file-label" for="meta-image">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">USP <small>(title - image)</small> </h5>
                            </div>
                            <div class="card-body" id="usp-list">

                                <div class="row" style="display:none">
                                    <div class="col-sm-7">
                                        <input name="usp[1]" type="text" class="form-control usp-title" />
                                    </div>
                                    <div class="col-sm-5 custom-file">
                                        <input name="usp_icon[1]" type="file" class="custom-file-input usp-icon" id="usp_icon[1]">
                                        <label class="custom-file-label" for="usp_icon[1]">Choose file</label>
                                    </div>
                                </div>
                                @if($product->usp)
                                @foreach(json_decode($product->usp) as $usp)
                                <div class="row">
                                    <div class="col-sm-7">
                                        <input name="usp[{{ $loop->iteration }}]" type="text" class="form-control usp-title" value="{{ $usp->usp }}" />
                                    </div>
                                    <div class="col-sm-5 custom-file">
                                        <input name="usp_icon[{{ $loop->iteration }}]" type="file" class="custom-file-input usp-icon" id="usp_icon[{{ $loop->iteration }}]">
                                        <label class="custom-file-label" for="usp_icon[{{ $loop->iteration }}]">Choose file</label>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-default" id="add_usp">Add</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Ingrediants <small>(title - image)</small> </h5>
                            </div>
                            <div class="card-body" id="ingredient-list">

                                <div class="row" style="display:none">
                                    <div class="col-sm-7">
                                        <input name="ingredient[1]" type="text" class="form-control ingredient-title" />
                                    </div>
                                    <div class="col-sm-5 custom-file">
                                        <input name="ingredient_icon[1]" type="file" class="custom-file-input ingredient-icon" id="ingredient_icon[1]">
                                        <label class="custom-file-label" for="ingredient_icon[1]">Choose file</label>
                                    </div>
                                </div>

                                @if($product->ingredients)
                                @foreach(json_decode($product->ingredients) as $ingredient)
                                <div class="row">
                                    <div class="col-sm-7">
                                        <input name="ingredient[{{ $loop->iteration }}]" type="text" class="form-control ingredient-title" value="{{ $ingredient->ingredient }}" />
                                    </div>
                                    <div class="col-sm-5 custom-file">
                                        <input name="ingredient_icon[{{ $loop->iteration }}]" type="file" class="custom-file-input ingredient-icon" id="ingredient_icon[{{ $loop->iteration }}]">
                                        <label class="custom-file-label" for="ingredient_icon[{{ $loop->iteration }}]">Choose file</label>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-default" id="add_ingredient">Add</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Know Your Fruit <small>(title - image)</small> </h5>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="text" name="know_your_fruit_title" value="{{ $product->know_your_fruit_title }}" class="form-control" placeholder="title">
                                        <textarea name="know_your_fruit_desc" class="form-control" placeholder="Description" >{{ $product->know_your_fruit_desc }}</textarea>
                                    </div>
                                </div>
                                <br />
                                <div id="fruiticon-list">
                                    <div class="row" style="display:none">
                                        <div class="col-sm-7">
                                            <input name="fruiticon[1]" type="text" class="form-control fruiticon-title" />
                                        </div>
                                        <div class="col-sm-5 custom-file">
                                            <input name="fruiticon_icon[1]" type="file" class="custom-file-input fruiticon-icon" id="fruiticon_icon[1]">
                                            <label class="custom-file-label" for="fruiticon_icon[1]">Choose file</label>
                                        </div>
                                    </div>


                                    @if($product->fruiticons)
                                    @foreach(json_decode($product->fruiticons) as $fruiticon)
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <input name="fruiticon[{{ $loop->iteration }}]" type="text" class="form-control fruiticon-title" value="{{ $fruiticon->fruiticon }}" />
                                        </div>
                                        <div class="col-sm-5 custom-file">
                                            <input name="fruiticon_icon[{{ $loop->iteration }}]" type="file" class="custom-file-input fruiticon-icon" id="fruiticon_icon[{{ $loop->iteration }}]">
                                            <label class="custom-file-label" for="fruiticon_icon[{{ $loop->iteration }}]">Choose file</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-default" id="add_fruiticon">Add</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Nutritional Information <small>(per 100ml)</small> </h5>
                            </div>
                            <div class="card-body row">
                                <textarea name="nutritional_information" class="form_control" style="width: 100%;" rows="8">{!! $product->nutritional_information !!}</textarea>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">Featured</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-6 col-from-label">Status</label>
                                    <div class="col-md-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked': '' }}>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-12">
                        <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                            <!-- <div class="btn-group mr-2" role="group" aria-label="First group">
                            <button type="submit" name="button" value="draft" class="btn btn-warning">Save As Draft</button>
                        </div>
                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <button type="submit" name="button" value="unpublish" class="btn btn-primary">Save &amp; Unpublish</button>
                        </div> -->
                            <div class="btn-group" role="group" aria-label="Second group">
                                <button type="submit" name="button" value="publish" class="btn btn-success">Save &amp; Publish</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
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

<script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('template/plugins/dropzone/min/dropzone.min.js') }}"></script>

<script>
    $(function() {
        bsCustomFileInput.init();

        $('.select2').select2();
        $('#packs').select2();
        $('#category_id').select2();
        $('#included_products').select2();

        $(document).on('change', '#packs', function() {
            let htmlStr = '';
            $("#packs :selected").each(function() {
                console.log(this.value);
                htmlStr += `<div class="form-group row sku-div">
                                        <label class="col-md-3 col-from-label">
                                            SKU(${this.text})
                                        </label>
                                        <div class="col-md-6">
                                            <input name="sku[${this.value}]" value="" type="text" placeholder="SKU" class="form-control" autocomplete="off" >
                                        </div>
                                        <div class="col-md-3">
                                            <input name="discount[${this.value}]" value="" lang="en" min="0" value="0" step="0.01" type="number" placeholder="Discount For SKU" class="form-control" autocomplete="off">
                                        </div>
                                    </div>`;

            });

            $('#show-hide-div').html(htmlStr);
        });

        // To Add mutiple USP entries
        $(document).on('click', '#add_usp', function() {
            let element = $('#usp-list').find('.row:hidden').first().clone();
            console.log(element);
            let count = $('#usp-list').find('.row').length + 1;
            // console.log(count);
            element.css('display', '');
            element.find('.usp-title').first().attr('name', 'usp[' + count + ']');
            element.find('.usp-icon').first().attr('name', 'usp_icon[' + count + ']');
            element.find('.usp-icon').first().attr('id', 'usp_icon[' + count + ']');
            element.find('.custom-file-label').first().attr('for', 'usp_icon[' + count + ']');
            element.appendTo("#usp-list");
        });

        // To Add mutiple USP entries
        $(document).on('click', '#add_ingredient', function() {
            console.log('test');
            let element = $('#ingredient-list').find('.row:hidden').first().clone();
            let count = $('#ingredient-list').find('.row').length + 1;
            console.log(count);
            element.css('display', '');
            element.find('.ingredient-title').first().attr('name', 'ingredient[' + count + ']');
            element.find('.ingredient-icon').first().attr('name', 'ingredient_icon[' + count + ']');
            element.find('.ingredient-icon').first().attr('id', 'ingredient_icon[' + count + ']');
            element.find('.custom-file-label').first().attr('for', 'ingredient_icon[' + count + ']');
            console.log(element);
            element.appendTo('#ingredient-list');
        });

        // To Add mutiple USP entries
        $(document).on('click', '#add_fruiticon', function() {
            let element = $('#fruiticon-list').find('.row:hidden').first().clone();
            let count = $('#fruiticon-list').find('.row').length + 1;
            // console.log(count);
            element.css('display', '');
            element.find('.fruiticon-title').first().attr('name', 'fruiticon[' + count + ']');
            element.find('.fruiticon-icon').first().attr('name', 'fruiticon_icon[' + count + ']');
            element.find('.fruiticon-icon').first().attr('id', 'fruiticon_icon[' + count + ']');
            element.find('.custom-file-label').first().attr('for', 'fruiticon_icon[' + count + ']');
            element.appendTo("#fruiticon-list");
        });

    });
</script>
@endsection