@extends('layouts.front')
@section('style')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/dropzone/min/dropzone.min.css') }}">

    <style>

        /* .add_qty_btn{
            position: absolute;
    z-index: 111;
    margin-left: -111px;
    margin-top: 3px;
        }

        .remove_qty_btn{
            position: absolute;
            z-index: 111;
            margin-left: 1px;
            margin-top: 3px;
        } */

@media (max-width:320px)  {
    .li_data{
        font-size: 11px;
        margin-left: 17px;
    }
    .select_pro_title{
        margin-left: 17px;
    }
    .small_screen_my_pack{
        padding: 14px 1px 1px 28px;
    font-size: 11px;
    }
    .small_screen_my_pack_2{
        padding: 0px 0px 0px 28px;
    font-size: 11px;
    }
    .sub_btn{
        text-align: center;
    }
    .li_data>input{
        width:57px !important;
    }
    .small_screen_my_pack_3{
        padding: 0px 1px 1px 28px;
        font-size: 11px;
        margin-top: 37px;
    }

    /* .add_qty_btn{
        margin-left: 29px;
    margin-top: -36px;
    } */
 }
@media (max-width:480px)  {
    .li_data{
        font-size: 11px;
        margin-left: 17px;
    }
    .select_pro_title{
        margin-left: 17px;
    }
    .small_screen_my_pack{
        padding: 14px 1px 1px 28px;
    font-size: 11px;
    }
    .small_screen_my_pack_2{
        padding: 0px 0px 0px 28px;
    font-size: 11px;
    }
    .sub_btn{
        text-align: center;
    }
    .li_data>input{
        width:57px !important;
    }
    .small_screen_my_pack_3{
        padding: 0px 1px 1px 28px;
        font-size: 11px;
        margin-top: 37px;
    }
    /* .add_qty_btn{
        margin-left: 29px;
    margin-top: -36px;
    } */
 }


    </style>
@endsection
@section('content')

    <div id="main">
        <div class="container mt-5">
            <div class="row">
                <h2 class="text-center section-title mtn-2 fz-24 mb-3">Create Pack</h2>
                <form action="{{ route('user.save-user-pack') }}" method="post" id="create_user_pack_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label for="">Category</label>

                            <div class="row">
                                @foreach ($categories as $cat)
                                @if ($cat->id == 1 || $cat->id == 2)
                                {{-- @if ($cat->id == 1 || $cat->id == 2 || $cat->id == 3 || $cat->id == 6) --}}
                                {{-- <div class="col-md-3 col-sm-6 col-xs-6 text-center cat_click" data-id="{{ $cat->id }}"> --}}
                                <div class="col-md-6 col-sm-6 col-xs-6 text-center cat_click" data-id="{{ $cat->id }}">
                                    <div class="" style="cursor: pointer">
                                        <img src="{{ asset('storage/'.$cat->thumbnail_image ) }}" alt="" class="cat_img" width="50%">
                                    </div>
                                    <span class="text-center">{{ $cat->name }}</span>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <div class="form-group row">
                                {{-- <div class="col-md-8">

                                    <select name="packs" class="form-control" id="packs" style="width: 100%;display:none"
                                        autocomplete="off" >
                                        <option value="">Select</option>
                                        @foreach ($packs as $pack)
                                            <option value="{{ $pack->id }}" data-qty="{{ $pack->quantity }}">{{ $pack->title }}</option>
                                        @endforeach
                                    </select>

                                    <select name="category" class="form-control" style="width:100%" id="category">
                                        <option value="">Select</option>
                                        @foreach ($categories as $cat)
                                        @if ($cat->id == 1 || $cat->id == 2 || $cat->id == 3 || $cat->id == 6)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="total_qty" id="total_qty">
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-6 products_div" style="display: none">
                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <label for="" class="select_pro_title">Select Products</label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label for="" class="select_pro_title">Add Quantity</label>
                                </div>
                            </div>
                            <div class="">
                                <ul class="show_products_here" style="    list-style-type: none;                                ">

                                </ul>
                            </div>
                            {{-- <div class="form-group row" id="included_products_container" style="">
                                <div class="col-md-8">
                                    <select name="included_products[]" class="form-control" id="included_products"
                                        style="" >
                                        <option value="">Select</option>
                                         @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-name="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                        <hr>
                        <div class="col-md-6 products_pack_div" style="display: none">
                            {{-- <label for="">Your Pack</label> --}}
                            <div class="row small_screen_my_pack_3">
                                <div class="col-md-4 col-xs-5">Your Pack</div>
                                <div class="col-md-4 col-xs-4">Quantity</div>
                                <div class="col-md-2 col-xs-3">
                                    MRP <span class="" style="font-weight:800"></span>
                                </div>
                            </div>
                            <div class="show_packs_here small_screen_my_pack">

                            </div>
                            <hr>
                            <div class="">
                                <div class="row small_screen_my_pack_2">
                                    <div class="col-md-8 col-xs-8">Total</div>
                                    <div class="col-md-2 col-xs-4">
                                        ₹ <span class="show_total_price" style="font-weight:800"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="add_pro_here">

                            </div>
                        </div>
                        <div class="col-md-6 sub_btn">
                            {{ csrf_field() }}
                            <input type="hidden" name="category_id" id="category_id" value="">
                            <input type="submit" value="submit" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }} "></script>

    <script src="{{ asset('template/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('template/plugins/dropzone/min/dropzone.min.js') }}"></script>

    <script>
        // $('#included_products').select2();
        var total_qty = 0;
        $(document).on('change', '#type', function() {
            if ($("#type :selected").val() == 'assorted') {
                $('#included_products_container').css('display', '');
                return true;
            }
            $('#included_products_container').css('display', 'none');
        });

        $(document).on('change','#packs',function(){
            var cur_val = $(this).val();
            var data_qty = $(this).find(':selected').attr('data-qty');
            $('#total_qty').val(data_qty);
        });

        $(document).on('change','#included_products',function(){
            var cur_val = $(this).val();
            var pro_name = $(this).find(':selected').attr('data-name');
            // alert(pro_name);
            $('.add_pro_here').append('<div class="main_div"><div class="col-md-4"><label for="" class="pro_name">'+pro_name+'</label></div><div class="col-md-1"><label>X</label></div><div class="col-md-4"><input type="hidden" name="pro_id[]" class="form-control" value="'+cur_val+'"><input type="text" name="qty[]" class="form-control" placeholder="quantity" value="1" required></div><div class="col-md-1"><button type="button" class="btn btn-danger del_pro">X</button></div></div>');
        });

        $(document).on('submit','#create_user_pack_form',function(e){
            // e.preventDefault();

    var arr = document.getElementsByClassName('qty_main_tag');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    // alert(tot);
    if(tot > 6 || tot < 6){
        alert('Only 6 Quantity Allowed');
        e.preventDefault();
    }

        });

        $(document).on('click','.del_pro',function(){
            $(this).closest('.main_div').remove();
        });

        $(document).on('change','#category',function(){
            var cur_val = $(this).val();
            // alert(cur_val);

        });

        $(document).on('click','.cat_click',function(){
            $('.cat_img').css('border','0px solid #06904d');
            $(this).find('.cat_img').css('border','1px solid #06904d');
            var cur_val = $(this).attr('data-id');
            // alert(cur_val);
            $('#category_id').val(cur_val);
            $.ajax({
                            url: "{{ route('user.get_category_wise_products') }}",
                            type: "POST",
                            data: {
                                id: cur_val,
                                "_token": "{{ csrf_token() }}",

                            },
                            success: function(data) {
                                // alert(data);
                                $('.show_products_here').text('');
                                $('.show_packs_here').text('');
                                $('.show_products_here').append(data);
                                $('.products_div').fadeIn();
                                $('.products_pack_div').fadeIn();

                                total_qty = 0;
                            },
                            error: function(data) {
                                alert("Something went wrong please try again");
                            }
                        });
        });

        $(document).on('click','.pro_checkbox',function(){
            var qty = $(this).closest('.li_data').find('.qty_data').val();
            // alert(qty);
            var chk = $(this).is(":checked");
            // alert(chk);
            // if(chk){
            //     // alert('checked');
            //     total_qty = parseInt(total_qty)+parseInt(qty);
            // }else{
            //     // alert('not');
            //     total_qty = parseInt(total_qty)-parseInt(qty);
            // }
            // alert(total_qty);
            findTotal();
        });


        $(document).on('keyup','.qty_data',function(){
            // var qty = $(this).val();
            // alert(qty);
            // total_qty = parseInt(total_qty)+parseInt(qty);
            // alert(total_qty);
            findTotal();
        });

    function findTotal(){
    var arr = document.getElementsByClassName('qty_data');
    var tot=0;
    $('.show_packs_here').text('');
    var show_total_price = 0;
    for(var i=0;i<arr.length;i++){
        var chk = $(arr[i]).closest('.li_data').find('.pro_checkbox').is(":checked");
        var pro_name = $(arr[i]).closest('.li_data').find('.pro_name_span').text();
        var pro_id = $(arr[i]).closest('.li_data').find('.pro_name_span').attr('data-id');
        var pro_price = $(arr[i]).closest('.li_data').find('.pro_price').val();
        // alert(chk);
        if(parseInt(arr[i].value))
        {
            if(chk){
                tot += parseInt(arr[i].value);
                var pro_price_final = parseInt(pro_price)*parseInt(arr[i].value)
                show_pack(pro_name,arr[i].value,tot,pro_id,'add',pro_price_final);
                show_total_price = show_total_price+pro_price_final;
            }else{
                // show_pack(pro_name,arr[i].value,tot,pro_id,'remove');
            }
        }
    }
    $('.show_total_price').text('');
    $('.show_total_price').text(show_total_price);
    // alert(tot);
    if(tot > 6){
        alert('Only pack of 6 Allowed');
    }
    // document.getElementById('total').value = tot;
}

function show_pack(name,qty,total_qty,pro_id,show_or_not,pro_price){
    $('.show_packs_here').append('<div class="row product_id'+pro_id+'"><input type="hidden" name="product_main[]" value="'+pro_id+'"><input type="hidden" name="qty_main[]" class="qty_main_tag" value="'+qty+'"><div class="col-md-3 col-xs-4">'+name+'</div> <div class="col-md-1 col-xs-1">X</div><div class="col-md-3 col-xs-3">'+qty+'</div><div class="col-md-1 col-xs-1">=</div><div class="col-md-2 col-xs-2"> ₹ '+pro_price+'</div></div>');
}

$(document).on('click','.add_qty_btn',function(){
    var li_data = $(this).closest('.li_data');
    var qty_data = $(li_data).find('.qty_data').val();
    var qty_data_tag = $(li_data).find('.qty_data');
    var qty_data = parseInt(qty_data) + parseInt(1);
    $(li_data).find('.qty_data').val(qty_data);
    $(qty_data_tag).trigger("keyup");
});

$(document).on('click','.remove_qty_btn',function(){
    var li_data = $(this).closest('.li_data');
    var qty_data = $(li_data).find('.qty_data').val();
    var qty_data_tag = $(li_data).find('.qty_data');
    var qty_data = parseInt(qty_data) - parseInt(1);
    if(qty_data < 0){
        qty_data = 0;
    }
    $(li_data).find('.qty_data').val(qty_data);
    $(qty_data_tag).trigger("keyup");
});
    </script>
@endsection
