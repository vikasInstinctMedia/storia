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
@endsection
@section('content')

<div class="section border-bottom pt-2 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index') }}">Home</a></li>
                    <li><a href="#">{{ $get_page_data->key }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<section class="pcy_data">
    {{ $get_page_data->value }}
</section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            var datatdat = $('.pcy_data').text();
            $('.pcy_data').text('');
            $('.pcy_data').append(datatdat);
        });
    </script>
@endsection
