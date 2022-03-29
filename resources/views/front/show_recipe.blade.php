@extends('layouts.front')
@section('style')
@if (isset($recipe->meta_title))
<meta name="title" content="{{ $recipe->meta_title }}">
<title>{{ $recipe->meta_title }}</title>
@else
<title>Storia Foods &#8211; Home</title>
@endif
{{-- <pre>
@php
    print_r($recipe->toArray());
    exit;
@endphp --}}
@if(isset($recipe->meta_description))
<meta name="description" content="{{ $recipe->meta_description }}">
@else
<meta name="description" content="Storia Foods &#8211; Home">
@endif
@endsection
@section('content')
<div id="main">
    <!-- <div class="section section-bg-10 pt-11 pb-17">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="page-title text-center">Shakes Recipes</h2>
                </div>
            </div>
        </div>
    </div> -->
    <div class="section border-bottom pt-2 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumbs">
                        <li><a href="./">Home</a></li>
                        <li><a href="blog.html">{{ $recipe->category->name }}</a></li>
                        <li>{{ $recipe->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="section pt-7 pb-7">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-blog">
                        <div class="post-thumbnail">
                            <a href="#">
                                <img src="{{ asset('storage/'. $recipe->thumbnail_image) }}" alt="" />
                            </a>
                        </div>

                        <h1 class="entry-title" style="font-size: 28px">{{ $recipe->title }} </h1>
                        <div class="entry-content">
                            {!! $recipe->description !!}
                        </div>
                        <div class="entry-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="share">
                                        <span> <i class="ion-android-share-alt"></i> Share this post </span>
                                        <span> <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                        </span>
                                        <span> <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                        </span>
                                        <span> <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="entry-nav">
                            <div class="row">
                                <div class="col-md-5 left">
                                    <i class="fa fa-angle-double-left"></i>
                                    <a href="#">Strawberry Banana Oats Smoothie?</a>
                                </div>
                                <div class="col-md-2 text-center">
                                    <i class="ion-grid"></i>
                                </div>
                                <div class="col-md-5 right text-right">
                                    <a href="#">Rose Iced Latte</a>
                                    <i class="fa fa-angle-double-right"></i>
                                </div>
                            </div>
                        </div>
                        <div class="comments-area">

                            <div class="single-comment-form">
                                <div class="mb-2">
                                    <h2 class="comment-title">LEAVE A REPLY</h2>
                                </div>
                                <form class="comment-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="comment" name="comment" cols="45" rows="5" placeholder="Message *"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input id="author" name="author" type="text" value="" size="30" placeholder="Name *" class="mb-2">
                                        </div>
                                        <div class="col-md-4">
                                            <input id="email" name="email" type="email" value="" size="30" placeholder="Email *" class="mb-2">
                                        </div>
                                        <div class="col-md-4">
                                            <input id="url" name="url" type="text" value="" placeholder="Website">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input name="submit" type="submit" id="submit" class="btn btn-alt btn-border" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
