@extends('layouts.front')
@section('style')
    <style>
        .owl-wrapper-outer{
            z-index: 1;
        }
    </style>
@endsection
@section('content')



            <div id="main">
				{{-- <div class="section section-bg-10 pt-11 pb-17">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<h2 class="page-title text-center">Blog Detail</h2>
							</div>
						</div>
					</div>
				</div> --}}
				<div class="section border-bottom pt-2 pb-2">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<ul class="breadcrumbs">
									<li><a href="{{ url('/') }}">Home</a></li>
									{{-- <li><a href="blog.html">Blog</a></li> --}}
									<li>Blog Detail</li>
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
											<img src="{{ asset('storage/'. $blogDetails->banner_image) }}" alt=""  />
										</a>
									</div>
									<div class="entry-meta">
										<span class="posted-on">
											<i class="ion-calendar"></i>
											<span>{{ date('F d, Y', strtotime($blogDetails->date)); }}</span>
										</span>
										<span class="categories">
											<i class="ion-folder"></i>
											{{ $blogDetails->auther }}
										</span>
										{{-- <span class="comment">
											<i class="ion-chatbubble-working"></i> 0
										</span> --}}
									</div>
									<h1 class="entry-title">{{ $blogDetails->title }}</h1>
									<div class="entry-content">
                                        <?php  echo $blogDetails->description; ?>
                                    </div>
									<div class="entry-footer">
										<div class="row">

											<div class="col-md-12">
												<div class="share">
													<span> <i class="ion-android-share-alt"></i> Share this post </span>
													<span> <a target="_blank" href="#"><i class="fa fa-facebook"></i></a> </span>
													<span> <a target="_blank" href="#"><i class="fa fa-twitter"></i></a> </span>
													<span> <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a> </span>
												</div>
											</div>
										</div>
									</div>
									{{-- <div class="entry-author">
										<div class="row">
											<div class="col-md-2">
												<img alt="" src="images/avatar/avatar_100x100.jpg" class="avatar" />
											</div>
											<div class="col-md-10">
												<h3 class="name">TM Organik</h3>
												<div class="desc">We are online market of   fruits, vegetables, juices and dried fruits. We bring fresh, seasonal products from our family farm right to your doorstep.</div>
											</div>
										</div>
									</div>
									<div class="entry-nav">
										<div class="row">
											<div class="col-md-5 left">
												<i class="fa fa-angle-double-left"></i>
												<a href="#">How can salmon be raised  ally in fish farms?</a>
											</div>
											<div class="col-md-2 text-center">
												<i class="ion-grid"></i>
											</div>
											<div class="col-md-5 right">
												<a href="#">How to steam &amp; purée your sugar pie pumkin</a>
												<i class="fa fa-angle-double-right"></i>
											</div>
										</div>
									</div>
									<div class="comments-area">
										<div class="single-comments-list mt-0">
											<div class="mb-2">
												<h2 class="comment-title">2 reviews for Orange Juice</h2>
											</div>
											<ul class="comment-list">
												<li>
													<div class="comment-container">
														<div class="comment-author-vcard">
															<img alt="" src="images/avatar/avatar_100x100.jpg" />
														</div>
														<div class="comment-author-info">
															<span class="comment-author-name">admin</span>
															<a href="#" class="comment-date">July 27, 2020</a>
															<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
														</div>
														<div class="reply">
															<a class="comment-reply-link" href="#">Reply</a>
														</div>
													</div>
													<ul class="children">
														<li>
															<div class="comment-container">
																<div class="comment-author-vcard">
																	<img alt="" src="images/avatar/avatar_100x100.jpg" />
																</div>
																<div class="comment-author-info">
																	<span class="comment-author-name">admin</span>
																	<a href="#" class="comment-date">July 27, 2020</a>
																	<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
																</div>
																<div class="reply">
																	<a class="comment-reply-link" href="#">Reply</a>
																</div>
															</div>
														</li>
													</ul>
												</li>
												<li>
													<div class="comment-container">
														<div class="comment-author-vcard">
															<img alt="" src="images/avatar/avatar_100x100.jpg" />
														</div>
														<div class="comment-author-info">
															<span class="comment-author-name">admin</span>
															<a href="#" class="comment-date">July 27, 2020</a>
															<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
														</div>
														<div class="reply">
															<a class="comment-reply-link" href="#">Reply</a>
														</div>
													</div>
												</li>
											</ul>
										</div>
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
									</div> --}}
								</div>
							</div>



                            <div class="col-lg-12 mt-2" style="margin-top: 40px !important">
                                <div class="related-title">
                                    <h4 class="text-center section-title">Recent Blogs</h4>
                                </div>
                                <div class="product-carousel p-0" data-auto-play="true" data-desktop="3" data-laptop="2" data-tablet="2" data-mobile="1">



                                    @if (isset($blogs))

                                    @foreach ($blogs as $item)



                                    <div class="product-item text-center">
                                        <div class="product-thumb">
                                            <a href="{{ url('blog') }}/{{ $item->slug }}">
                                                <img src="{{ asset('storage/'. $item->thumbnail_image) }}" alt="" />
                                            </a>
                                            {{-- <div class="product-action">
                                                <span class="add-to-cart add-to-cart-btn in-stock {{ !$rec->base_pack->is_product_in_stock ? 'd-none' : '' }} " data-page="listing" data-product-id="{{ $rec->id }}">
                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Add to cart"></a>
                                                </span>

                                            </div> --}}
                                        </div>

                                        <div class="product-info">





                                            <a href="{{ url('blog') }}/{{ $item->slug }}">
                                                <h2 class="title">{{ $item->title }}</h2>

                                            </a>
                                        </div>

                                    </div>


                                    @endforeach

                                    @endif

                                </div>
                            </div>


							<div class="col-md-3" style="display: none;">
								<div class="sidebar">
									<div class="widget widget-product-search">
										<form class="form-search">
											<input type="text" class="search-field" placeholder="Search products…" value="" name="s" />
											<input type="submit" value="Search" />
										</form>
									</div>
									<div class="widget widget-product-categories">
										<h3 class="widget-title">Categories</h3>
										<ul class="product-categories">
											<li><a href="#">Cooking Tips</a> <span class="count">2</span></li>
											<li><a href="#">Nutrition Meal</a> <span class="count">5</span></li>
											<li><a href="#">  Planting</a> <span class="count">4</span></li>
											<li><a href="recipes.html">Recipes</a> <span class="count">4</span></li>
										</ul>
									</div>
									<div class="widget widget_posts_widget">
										<h3 class="widget-title">Popular Posts</h3>
										<div class="item">
											<div class="thumb">
												<img src="images/blog/blog_100x100.jpg" alt="" />
											</div>
											<div class="info">
												<span class="title">
													<a href="blog-detail.html"> How to steam &amp; purée your sugar pie pumkin </a>
												</span>
												<span class="date"> August 9, 2020 </span>
											</div>
										</div>
										<div class="item">
											<div class="thumb">
												<img src="images/blog/blog_100x100.jpg" alt="" />
											</div>
											<div class="info">
												<span class="title">
													<a href="blog-detail.html"> How to steam &amp; purée your sugar pie pumkin </a>
												</span>
												<span class="date"> August 9, 2020 </span>
											</div>
										</div>
										<div class="item">
											<div class="thumb">
												<img src="images/blog/blog_100x100.jpg" alt="" />
											</div>
											<div class="info">
												<span class="title">
													<a href="blog-detail.html"> How can salmon be raised  ally in fish farms? </a>
												</span>
												<span class="date"> August 9, 2020 </span>
											</div>
										</div>
									</div>
									<div class="widget widget-tags">
										<h3 class="widget-title">Search by Tags</h3>
										<div class="tagcloud">
											<a href="#">bread</a> <a href="#">food</a> <a href="#">fruits</a> <a href="#">green</a> <a href="#">healthy</a> <a href="#">natural</a> <a href="#">Storia Foods</a> <a href="#">vegatable</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

@endsection

@section('scripts')

@endsection
