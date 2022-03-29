@extends('layouts.front')

@section('style')
@if (isset($metadata['meta_title']))
<meta name="title" content="{{ $metadata['meta_title'] }}">
<title>{{ $metadata['meta_title'] }}</title>
@else
<title>Storia Foods &#8211; Home</title>
@endif

@if (isset($metadata['meta_description']))
<meta name="description" content="{{ $metadata['meta_description'] }}">
@else
<meta name="description" content="Storia Foods &#8211; Home">
@endif
@endsection

@section('content')
<style>
    #rev_slider {
        height: 850px !important;
    }

    .header.header-355 {
        position: absolute;
        left: 0;
        right: 0;
        background: rgba(33, 33, 33, .2);
        width: 100%;
    }

    .topbar1 {
        background: #000 !important;
    }

    .logo-image1 {
        background-image: url(../front/images/footer_logo.png) !important;
        background-position: center;
        background-size: 100%;
        background-repeat: no-repeat;
        z-index: 999;
        display: block !important;
    }

    .main-menu a {
        color: #fff;
    }

    .ion-bag {
        color: #fff;
    }

    @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
        header.header-mobile .header-left i {
            color: #fff;
        }

    }
</style>
<div id="main">
    <div class="section">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 p-0">
                    <div class="overlay"></div>
                    <div id="rev_slider" class="rev_slider fullscreenbanner">
                        <ul>
                            @foreach ($about_us_data_array['slider_1'] as $item)


                            <li data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide">
                                <img src="{{ asset('storage/'. $item['image']) }}" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" />
                                <div class="Made">
                                    <h1>{{ $item['title'] }}</h1>
                                    <p>{{ $item['description'] }}</p>
                                </div>
                            </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section pt-10 pb-10" style="display: none;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center mb-1 section-pretitle">Welcome to Organik!</div>
                    <h2 class="text-center section-title mtn-2">A little story about us</h2>
                    <div class="organik-seperator mb-9 center">
                        <span class="sep-holder"><span class="sep-line"></span></span>
                        <div class="sep-icon"><i class="organik-flower"></i></div>
                        <span class="sep-holder"><span class="sep-line"></span></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="about-main-img col-lg-6">
                    <img src="{{asset('front/images/007.jpg')}}" alt="" />
                </div>
                <div class="about-content col-lg-6">
                    <div class="about-content-title">
                        <h4>A family owned farm</h4>
                        <div class="about-content-title-line"></div>
                    </div>
                    <div class="about-content-text">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                            Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown printer took a galley</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                            Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown printer took a galley<br></p>
                    </div>
                    <div class="about-carousel" data-auto-play="true" data-desktop="4" data-laptop="4" data-tablet="4" data-mobile="2">
                        <a href="{{asset('front/images/carousel/01.jpg')}}" data-rel="prettyPhoto[gallery]">
                            <img src="{{asset('front/images/carousel/001.jpg')}}" alt="" />
                            <span class="ion-plus-round"></span>
                        </a>
                        <a href="{{asset('front/images/carousel/02.jpg')}}" data-rel="prettyPhoto[gallery]">
                            <img src="{{asset('front/images/carousel/002.jpg')}}" alt="" />
                            <span class="ion-plus-round"></span>
                        </a>
                        <a href="{{asset('front/images/carousel/03.jpg')}}" data-rel="prettyPhoto[gallery]">
                            <img src="{{asset('front/images/carousel/003.jpg')}}" alt="" />
                            <span class="ion-plus-round"></span>
                        </a>
                        <a href="{{asset('front/images/carousel/04.jpg')}}" data-rel="prettyPhoto[gallery]">
                            <img src="{{asset('front/images/carousel/004.jpg')}}" alt="" />
                            <span class="ion-plus-round"></span>
                        </a>
                        <a href="{{asset('front/images/carousel/05.jpg')}}" data-rel="prettyPhoto[gallery]">
                            <img src="{{asset('front/images/carousel/005.jpg')}}" alt="" />
                            <span class="ion-plus-round"></span>
                        </a>
                        <a href="{{asset('front/images/carousel/05.jpg')}}" data-rel="prettyPhoto[gallery]">
                            <img src="{{asset('front/images/carousel/006.jpg')}}" alt="" />
                            <span class="ion-plus-round"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
        <!-- Overlay -->


        <!-- Indicators -->
        <ol class="carousel-indicators">
            @php
                $i = 0;
            @endphp
            @foreach ($about_us_data_array['slider_2'] as $item2)

            <li data-target="#bs-carousel" data-slide-to="{{ $i }}" class="
            @php
                if($i == 0){
                    echo 'active';
                }
            @endphp
            " style="background-image: dsa.png"></li>

            @php
                $i++;
            @endphp
            @endforeach
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @php
            $i = 0;
        @endphp
        @foreach ($about_us_data_array['slider_2'] as $item2)

            <div class="item slides
            @php
            if($i == 0){
                echo 'active';
            }
        @endphp
            ">
                <div class="slide-1" style='background-image: url("{{ asset('storage/'. $item2['image']) }}")'></div>
                <!-- <div class="hero">
                            <hgroup>
                                <h1>We are creative</h1>
                                <h3>Get start your next awesome project</h3>
                            </hgroup>
                            <button class="btn btn-hero btn-lg" role="button">See all features</button>
                        </div> -->
            </div>
        @php
            $i++;
        @endphp
        @endforeach

        </div>
    </div>
    <div class="section">
        <div class="container-fluid">
            <div class="row">
                @if (isset($about_us_data_array['images_new']['image1']))

                <div class="col-sm-6 p-0">
                    <div class="organik-featured-product style-2 gopshop" data-bg-color="#e3e3e3" data-bg-image="{{ asset('storage/'. $about_us_data_array['images_new']['image1']) }}" style="background-image: url(&quot;images/reciepe_block-.png&quot;); background-color: rgb(235 235 234);">
                    </div>
                </div>

                @endif
                @if (isset($about_us_data_array['images_new']['image1']))

                <div class="col-sm-6 p-0">
                    <div class="organik-featured-product style-3" data-bg-color="#e3e3e3" data-bg-image="{{ asset('storage/'. $about_us_data_array['images_new']['image2']) }}" style="background-image: url(&quot;images/featured_product_3.png&quot;); background-color: rgb(198, 230, 246);">
                        <div class="organik-featured-product-box">
                            <div class="organik-featured-product-box">
                                @if (isset($about_us_data_array['images_new']['title2']))

                                <h1 class="subtitle">{{ $about_us_data_array['images_new']['title2'] }}</h1>

                                @endif

                                @if (isset($about_us_data_array['images_new']['redirect_url2']))

                                <a class="organik-btn small smallshoping" href="{{ $about_us_data_array['images_new']['redirect_url2'] }}">Make This More</a>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>


    @include('includes.instagram_posts')

    @include('includes.review')

</div>

@endsection

@section('scripts')

@endsection
