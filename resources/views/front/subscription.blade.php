@extends('layouts.front')

@section('style')
@if (isset($meta_title))
<meta name="title" content="{{ $meta_title }}">
<title>{{ $meta_title }}</title>
@else
<title>Storia Foods &#8211; Home</title>
@endif

@if (isset($meta_description))
<meta name="description" content="{{ $meta_description }}">
@else
<meta name="description" content="Storia Foods &#8211; Home">
@endif
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<style>
	/* The Modal (background) */
	.modal {
		position: fixed;
		z-index: 999;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
	}

	/* Modal Content */
	.modal-content {
		background-color: #f6f6f8;
		margin: auto;
		padding: 20px;
		border: 1px solid #888;
		width: 40%;
		top: 30%;
		left: 0;
		transform: translate(0%, 0%);
	}

	/* The Close Button */
	.close {
		color: #aaaaaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}

	.mainfull {
		width: 40% !important;
		height: 30%;
	}

	.submit {
		border-radius: 0 !important;
		line-height: 0.7 !important;
		font-weight: normal !important;
		background: #1abe9c !important;
		border: 1px solid #1abe9c !important;
	}

	.markermin {
		background: #1abe9c;
		padding: 11px;
		color: #ffff;
	}

	.modal-backdrop {
		z-index: 0;
	}

	.image-product {
	    height:auto;
	}

	.test-div {
		border:2px solid #CCC;
		/* width:600px; */
	}
	.test-div-inner {
		padding-bottom:100%;
		background:#EEE;
		height:0;
		position:relative;
	}
	.test-image {
		width:100%;
		/* height:100%; */
		display:block;
		/* position:absolute; */
	}
    .card_data>img{
        width: 35%;
    border-radius: 129px;
    }

    .sub_card{
        border: 1px solid #b5bcc3;
    margin-left: 62px;
    margin-right: 15px;
    margin-top: 30px;
    margin-bottom: 30px;
    padding: 19px 0px 19px 0px;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    }


    .sub_card:hover {
        background-color: #0f914f;
    color: white;
    box-shadow: 0 12px 12px 0 rgba(0,0,0,0.2);
    }

    .sub_btn{
        /* background-color: white; */
    /* color: #5e5a54; */
    }

    .zin{
        z-index: 11
    }





@media only screen and (min-width: 992px) {
    .banner-image-div {
        height: 78% !important;
    }

    .rev_slider{
        margin-bottom:-102px !important;
    }

}


@media only screen and (min-width: 1200px) {
        .banner-image-div {
        height: 78% !important;
    }

    .rev_slider{
        margin-bottom:-102px !important;
    }

}

@media (max-width:320px)  {

    .sub_card{
        margin-left: 3px !important;
    }
 }
@media (max-width:480px)  {

    .sub_card{
        margin-left: 3px !important;
    }
 }


    </style>





</style>
@endsection
@section('content')

<div id="main">
	<div class="section">
		<div class="container-fluid">
            <h4 class="text-center">Subscriptions</h4>
            <div class="row text-center main_row" style="padding: 48px">
                {{-- <div class="col-md-3"></div> --}}
                @isset($all_subs)
                @foreach ($all_subs as $item)
                <div class="col-md-3 col-sm-12 col-xs-12 card sub_card shadow-lg">
                    <div class="card_data">
                    <img src="{{ asset('storage/'. $item->thumbnail ) }}" alt="">
                    <br>
                    <hr>
                    <label for="">{{ $item->title }}</label>
                    <br>
                    <label for="">Price : <del>{{ $item->mrp }}</del> {{ $item->price }}</label>
                    <br>
                    <label for="">Pack : {{ $item->pack->title }}</label>
                    <br>
                    <label for="">Type : {{ $item->subscription_type->title }}</label>
                        <br>
                        <button class="btn btn-deafult sub_btn" data-id="{{ $item->id }}" data-subtype="{{ $item->subscription_type->id }}" data-toggle="modal" data-target="#address_modal">Buy</button>
                </div>
                </div>
                @endforeach
                @endisset

            </div>
		</div>
	</div>



	<!-- instagram posts -->

</div>


<!-- Modal -->
<div class="modal fade" id="address_modal" role="dialog" style="padding-top: 0px">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content" style="width: 70%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Please Enter Below Details</h4>
        </div>
        <form action="{{ route('subscription.payment') }}" method="post" id="sub_form">
        <div class="modal-body">
            {{ csrf_field() }}
          <div class="row">
              <div class="col-md-6 col-xs-12 col-sm-12 zin">
                  <label for="">Full Name</label>
                  <input type="text" name="full_name" class="form-control" required>
              </div>
              <div class="col-md-6 col-xs-12 col-sm-12 zin">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 zin">
                <label for="">Mobile No.</label>
                <input type="text" name="mobile_no" class="form-control" required>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 zin payment_div" style="display: block">
                <label for="">Payment Frequency</label>
                    <input type="radio" id="html98" name="pay_type" class="pay_type pay_type1" value="1">
                    <label for="html" style="display: inline-block">Weekly</label>
                    <input type="radio" id="css" name="pay_type" class="pay_type pay_type2" value="2">
                    <label for="css" style="display: inline-block">Monthly</label>
            </div>



            <div class="col-md-12 col-xs-12 col-sm-12 zin">
                <label for="">Address</label>
                <textarea name="address" id="" cols="30" rows="10" class="form-control" required></textarea>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12 zin">
                <label for="">City</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 zin">
                <label for="">State</label>
                <input type="text" name="state" class="form-control" required>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 zin">
                <label for="">Country</label>
                <input type="text" name="country" class="form-control" required>
            </div>
                        <div class="col-md-6 col-xs-12 col-sm-12 zin">
                <label for="">Zip Code</label>
                <input type="text" name="zip" class="form-control" required>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 zin">
                <label for="">Auto Pay</label>
                    <input type="radio" id="html" name="auto_pay" value="1">
                    <label for="html" style="display: inline-block">Yes</label>
                    <input type="radio" id="css" name="auto_pay" value="2" checked>
                    <label for="css" style="display: inline-block">No</label>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12 zin" >
                <label for="">For</label>
                <select name="for_how_many" id="" style="display: inline-block;width:80%">
                @for ($i = 1; $i <= 24; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor


            </select> <span class="show_for">Weeks</span>
            </div>

            <div class="col-md-12">
                <input type="submit" class="btn btn-success" value="Buy">
            </div>
            <input type="hidden" name="sub_id" id="sub_id">
          </div>
        </div>
        </form>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
        </div>
      </div>

    </div>
  </div>

<!-- Pincode modal -->


@endsection

@section('scripts')
<script src="{{ asset('front/js/extensions/lazyload/lazyload.js') }}"></script>




<script>
	$("body").lazyload();

	$(document).ready(function() {
        $(document).on('click','.sub_btn',function(){



            var cur_val = $(this).attr('data-id');
            // alert(cur_val);
            var subtype = $(this).attr('data-subtype');
            // alert(subtype);
            $('#sub_id').val(cur_val);
            if(subtype == 1){
                $('.pay_type2').attr('checked',false);
                 $('.pay_type1').attr('checked','checked');
                $('.show_for').text('Weeks');
                $('.payment_div').fadeIn();
            }else{
                $('.pay_type2').attr('checked','checked');
                $('.pay_type1').attr('checked',false);
                $('.show_for').text('Months');
                $('.payment_div').fadeOut();
            }
        });
	});

    $( ".sub_card" ).mouseenter(function() {
        var sub_btn = $(this).find('.sub_btn');
        $(sub_btn).css('background-color','white');
        $(sub_btn).css('color','#5e5a54');
    });

    $(".sub_card").mouseleave(function(){
        var sub_btn = $(this).find('.sub_btn');
        $(sub_btn).css('background-color','#06904d');
        $(sub_btn).css('color','white');
});


$(document).on('click','.pay_type',function(){
    var cur_val = $(this).val();
    // alert(cur_val);
    if(cur_val == 1){
        $('.show_for').text('');
        $('.show_for').text('Weeks');
    }else{
        $('.show_for').text('');
        $('.show_for').text('Months');
    }
});
</script>
@endsection
