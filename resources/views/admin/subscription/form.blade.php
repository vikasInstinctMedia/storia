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
                <h1>
                    @if (isset($action))
                        Update
                    @else
                    Create
                    @endif
                    Subscription</h1>
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
                    <form action="{{ isset($action) ? route('admin.subscription.update',['id' => $subscription->id]) : route('admin.subscription.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if (isset($action))
                                            <input type="hidden" name="subscription_id" id="" value="{{ $subscription->id }}">
                                        @endif
                                        <label for="name" class="required">Title</label>
                                        <input name="title" type="text" class="form-control" autocomplete="off" value="{{ isset($subscription->title) ? $subscription->title : '' }}" />
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Thumbnail Image (Resolution : 400 X 400 px)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="thumbnail_image" type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                        @if(isset($subscription->thumbnail))
                                        <input type="hidden" name="old_thumbnail" value="{{ $subscription->thumbnail }}">
                                            <a target="_blank" href="{{ asset('storage/'.$subscription->thumbnail ) }}">Uploaded Thumbnail Image</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Type</label>
                                        <select name="subscription_types_id" id="subscription_types_id" class="form-control">
                                            @foreach ($subscription_types as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (isset($subscription->subscription_types_id) && $subscription->subscription_types_id == $item->id)
                                                        selected
                                                    @endif
                                                    >{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Category</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}"
                                                    @if (isset($subscription->categorys_id) && $subscription->categorys_id == $cat->id)
                                                    selected
                                                    @endif
                                                    >{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Product</label>
                                        <select name="products_id" id="products_id" class="form-control">
                                            @if (isset($products))
                                            <option value="">Select</option>
                                                @foreach ($products as $pro)
                                                @if($pro['type'] == 'regular')
                                                    <option value="{{ $pro['id'] }}"
                                                    @if (isset($subscription->products_id) && $subscription->products_id == $pro['id'])
                                                        selected
                                                    @endif
                                                    >{{ $pro['name'] }}</option>
                                                @endif
                                                    @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Packs</label>
                                        <select name="packs_id" id="packs_id" class="form-control">
                                            @if (isset($get_pro_packs))
                                            <option value="">Select</option>
                                                @foreach ($get_pro_packs as $pack)
                                                    <option value="{{ $pack->details->id }}"
                                                        @if (isset($subscription->packs_id) && $subscription->packs_id == $pack->details->id)
                                                            selected
                                                        @endif
                                                        >{{ $pack->details->title }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">Selling Price</label>
                                        <input type="text" name="price" class="form-control" value="{{ isset($subscription->price) ? $subscription->price : '' }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <label for="name" class="required">MRP</label>
                                        <input type="text" name="mrp" class="form-control" value="{{ isset($subscription->mrp) ? $subscription->mrp : '' }}">
                                    </div>
                                </div>



                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-main">
                                        @if (isset($action))
                                            Update
                                        @else
                                        Create
                                        @endif
                                    </button>
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

    $(document).on('change','#category_id',function(){
        var cur_val = $(this).val();
        // alert(cur_val);
        $.ajax({
                            url: "{{ route('admin.get_category_wise_products') }}",
                            type: "POST",
                            data: {
                                id: cur_val,
                                "_token": "{{ csrf_token() }}",

                            },
                            success: function(data) {
                                // console.log(data);
                                $('#products_id').text('');
                                $('#products_id').append(data);
                            },
                            error: function(data) {
                                alert("Something went wrong please try again");
                            }
                        });
    });

    $(document).on('change','#products_id',function(){
        var cur_val = $(this).val();
        // alert(cur_val);
        $.ajax({
                            url: "{{ route('admin.get_products_packs') }}",
                            type: "POST",
                            data: {
                                id: cur_val,
                                "_token": "{{ csrf_token() }}",

                            },
                            success: function(data) {
                                // console.log(data);
                                $('#packs_id').text('');
                                $('#packs_id').append(data);
                            },
                            error: function(data) {
                                alert("Something went wrong please try again");
                            }
                        });
    });
</script>
@endsection
