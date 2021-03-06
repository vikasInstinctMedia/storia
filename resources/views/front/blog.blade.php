@extends('layouts.front')

@section('style')
    <style>
    .post-content{
        height:170px
    }
    </style>

@endsection

@section('content')

<div id="main">
				<!-- <div class="section section-bg-10 pt-11 pb-17">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<h2 class="page-title text-center">Blog Masonry</h2>
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
									<li><a href="#">Blog</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="section pt-7 pb-7">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="masonry-grid-post">

									@forelse($blogs as $blog)
									<div class="col-md-4 masonry-item">
										<div class="blog-grid-item">
											<div class="post-thumbnail blog-image-div">
												<a href="{{ url('blog') }}/{{ $blog->slug }}">
													<img src="{{ asset('storage/'. $blog->thumbnail_image) }}" alt="" />
												</a>
											</div>
											<div class="post-content">
												<div class="entry-meta">
													<span class="posted-on">
														<i class="ion-calendar"></i>
														{{-- <span>August 9, 2016</span> --}}
														{{ date('F d, Y', strtotime($blog->created_at)); }}
													</span>
													<span class="comment">
														<i class="ion-chatbubble-working"></i>
													</span>
												</div>
												@php
														$blogName=str_replace(' ', ';',$blog->title);
													@endphp
												<a href="{{ url('blog') }}/{{ $blog->slug }}" target="_blank">
													<h1 class="entry-title">{{ $blog->title }}</h1>
												</a>

												<div class="entry-more">

													{{-- <a href="{{ $blog->redirect_url }}" target="_blank">Read more</a> --}}
													<a href="{{ url('blog') }}/{{ $blog->slug }}" target="_blank">Read more</a>
												</div>
											</div>
										</div>
									</div>
									@empty

									<h3><center>No Blogs Found </center></h3>

									@endforelse

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


@endsection

@section('scripts')

@endsection
