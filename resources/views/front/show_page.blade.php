@extends('layouts.front')

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
