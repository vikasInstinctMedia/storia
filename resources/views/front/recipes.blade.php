@extends('layouts.front')

@section('content')

<div id="main">
    <!-- <div class="section section-bg-10 pt-11 pb-17">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="page-title text-center">Recipes</h2>
                </div>
            </div>
        </div>
    </div> -->
    <div class="section border-bottom pt-2 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumbs">
                        <li><a href="index.html">Home</a></li>
                        <li>Recipes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="section pt-3 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center section-title">Our Recipes</h2>
                    <div class="organik-seperator center">
                        <span class="sep-holder"><span class="sep-line"></span></span>
                        <!-- <div class="sep-icon"><i class="organik-flower"></i></div> -->
                        <span class="sep-holder"><span class="sep-line"></span></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 p-0">
                    <div class="text-center">
                        <ul class="masonry-filter">

                            @foreach($recipeCategories as $element)

                                <li><a href="{{ route('front.recipes',[ 'slug' => $element->slug ]) }}" data-filter=".dried" class="change-category"> {{ $element->name }}</a></li>

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="product-grid masonry-grid-post">
                    
                    @forelse($category->recipes as $recipe)
                    <div class="col-md-4 col-sm-6 product-item masonry-item text-center dried">
                        <div class="organik-about">
                            <a href="{{ route('front.recipe.show', [ 'recipe' => $recipe->id ]) }}">
                                <div class="image style-2" data-bg-color="#f5e9e2" style="background-color: rgb(245, 233, 226);">
                                    <img src="{{asset('storage/'. $recipe->thumbnail_image)}}" alt="">
                                    <!-- <div class="organik-about-letter">storia</div> -->
                                </div>
                            </a>
                            <div class="content">
                                <h5>{{ $recipe->title }}</h5>
                                <!-- <a class="link" href="{{ route('front.recipe.show', [ 'recipe' => $recipe->id ]) }}">
                                    <i class="ion-plus-round"></i> Read more
                                </a> -->
                            </div>
                        </div>
                    </div>
                    @empty
                    <h3>
                        <center> No Recipe Found </center>
                    </h3>
                    @endforelse


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).on('click', '.change-category', function () {
    window.location =$(this).attr('href');
});
</script>

@endsection