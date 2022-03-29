<!doctype html>
<html lang="en-US">

<head>
    @if(config('app.env') == 'production')

    <meta name="google-site-verification" content="ZjYGy7nF8WeBSJS7_Q_pxbMyD5xevDAVGGiOwIqtirE" />

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KKBSX8N');</script>
    <!-- End Google Tag Manager -->

    @endif

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="facebook-domain-verification" content="sg8mzhgb7j6gagrc2dti9eyy54wqs8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
	<link rel="shortcut icon" href="{{asset('front/images/favicon.ico')}}" />
	{{-- <title>Storia Foods &#8211; Home</title> --}}

	<link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}" type="text/css" media="all" />
	<link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}" type="text/css" media="all" />
	<link rel="stylesheet" href="{{asset('front/css/ionicons.min.css')}}" type="text/css" media="all" />
	<link rel="stylesheet" href="{{asset('front/css/owl.carousel.css')}}" type="text/css" media="all" />
	<link rel="stylesheet" href="{{asset('front/css/owl.theme.css')}}" type="text/css" media="all" />
	<link rel="stylesheet" href="{{asset('front/css/settings.css')}}" type="text/css" media="all" />
	<link rel='stylesheet' href="{{asset('front/css/slick.css') }}" type='text/css' media='all' />
	<link rel="stylesheet" href="{{asset('front/css/style.css')}}" type="text/css" media="all" />
	<link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
	<link rel="stylesheet" href="{{asset('front/css/custom.css')}}" type="text/css" media="all" />



	@if(config('app.env') == 'production')

<!-- Global site tag (gtag.js) - Google Ads: 351329350 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-351329350"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-351329350');
</script>


	<!-- Global site tag (gtag.js) - Google Ads: 310388706 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-310388706"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'AW-310388706');
	</script>

	<!-- Scripts for tracking in facebook and google -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=DC-10419599"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() {dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'DC-10419599');
	</script>

	<!-- End of global snippet: Please do not remove -->
	<!-- Global site tag (gtag.js) - Google Analytics -->

		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167616011-1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-167616011-1');
		</script>

	<!-- Facebook Pixel Code -->

	<script>
		! function(f, b, e, v, n, t, s)

		{
			if (f.fbq) return;
			n = f.fbq = function() {
				n.callMethod ?

					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};

			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';

			n.queue = [];
			t = b.createElement(e);
			t.async = !0;

			t.src = v;
			s = b.getElementsByTagName(e)[0];

			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',

			'https://connect.facebook.net/en_US/fbevents.js');

		fbq('init', '548740299646912');

		fbq('track', 'PageView');
	</script>

	<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=548740299646912&ev=PageView&noscript=1" /></noscript>


	@yield('head_analytics')

	<!-- End Facebook Pixel Code -->


<!-- Facebook Pixel Code -->

<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '470929004598931');
    fbq('track', 'PageView');
</script>

<noscript>

    <img height="1" width="1" src="https://www.facebook.com/tr?id=470929004598931&ev=PageView&noscript=1"/>

</noscript>

    <!-- End Facebook Pixel Code -->
    @endif

	<!-- JS file for all analytics events -->
	<script type="text/javascript" src="{{asset('front/js/analytics.js')}}"></script>

    <style>
        .main_a > li > a{
            padding: 50px 10px !important;
        }
    </style>
	@yield('style')
</head>

<body>
    @if(config('app.env') == 'production')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KKBSX8N"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

	<!-- <div class="noo-spinner">
		<div class="spinner">
			<div class="cube1"></div>
			<div class="cube2"></div>
		</div>
	</div> -->

	<div id="menu-slideout" class="slideout-menu hidden-md-up">
		<div class="mobile-menu">
			<ul id="mobile-menu" class="menu">
				<li class="">
					<a href="{{ url('/') }}" class="active">Home</a>
				</li>
				<li class="">
					<a href="{{ route('front.aboutus') }}">About Us</a>
				</li>
				<li>
					<a href="{{ route('front.recipes') }}">Recipes</a>
				</li>
				<li>
					<a href="{{ route('front.blog') }}">Blog</a>

				</li>
                @if(Auth::guard('web')->check())
                <li style="">
					<a href="{{ route('create.user-pack') }}">Create Pack</a>

				</li>

                <li style="">
					<a href="{{ route('subscription') }}">Susbcription</a>

				</li>
                @endif
				<li>
					<a href="{{ route('front.contactus') }}">Contact</a>
				</li>

				<li class="dropdown">
					<a href="#">Categories</a>
					<i class="sub-menu-toggle fa fa-angle-down"></i>
					<ul class="sub-menu">
						@foreach($categories as $category)
						<li><a href="{{ route('front.category', $category->slug) }}">{{ $category->name }}</a></li>
						@endforeach
					</ul>
				</li>

			</ul>
		</div>
	</div>
	<div class="site">
		@if(Session::has('top_bar_message'))
		<div class="alert alert-success alert-dismissible show mb-0" role="alert">
			<div class="container">
				{!! Session::get('top_bar_message') !!}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		@endif
		<div class="topbar topbar1">
			<div class="container">
				<div class="row">

                    <div class="col-md-12 text-center" style="color:red;font-size: 15px;font-weight: 800;">
                        Free shipping on orders above Rs. 400/-
                    </div>
					<div class="col-md-6">
						<div class="topbar-text">
							<span> </span>
							<span> </span>
						</div>
					</div>

					<div class="col-md-6">
						<div class="topbar-menu">
							<ul class="topbar-menu">
								<!-- <li class="dropdown">
										<a href="#">Languages</a>
										<ul class="sub-menu">
											<li><a href="#">English</a></li>
											<li><a href="#">Français</a></li>
										</ul>
									</li> -->
								@if(!Auth::guard('web')->check())
								<li><a href="{{ route('user.userlogin') }}">Login</a></li>
								<li><a href="{{ route('user.userregister') }}">Register</a></li>
								<li><a href="{{ route('front.track.index') }}">Track Order</a></li>
								@else
								<li><a href="{{ route('user-dashboard') }}">Dashboard</a></li>
								<li><a href="{{ route('user-logout') }}">Logout</a></li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<header id="header" class="header header-desktop header-2 header-355">
			<div class="top-search">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<form>
								<input type="search" class="top-search-input" name="s" placeholder="What are you looking for?" />
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<a href="{{ url('/') }}" id="logo">
							<img class="logo-image logo-image1" src="{{asset('front/images/logo.png')}}" alt="Organik Logo" />
						</a>
					</div>
					<div class="col-md-9">
						<div class="header-right">
							<nav class="menu">
								<ul class="main-menu main_a">
									<li class="{{ (request()->is('home')) ? 'active' : '' }}">
										<a href="{{ url('/') }}">Home</a>
									</li>
									<li class="{{ (request()->is('aboutus')) ? 'active' : '' }}">
										<a href="{{ route('front.aboutus') }}">About Us</a>
									</li>
									<li class="{{ (request()->is('recipes')) ? 'active' : '' }}">
										<a href="{{ route('front.recipes') }}">Recipes</a>
									</li>
									<li class="{{ (request()->is('blog')) ? 'active' : '' }}">
										<a href="{{ route('front.blog') }}">Blog</a>
									</li>
                                    @if(Auth::guard('web')->check())
                                    <li class="{{ (request()->is('pack')) ? 'active' : '' }}" style="">
										<a href="{{ route('create.user-pack') }}">Create Pack</a>
									</li>


                                    <li class="{{ (request()->is('subscription')) ? 'active' : '' }}" style="">
										<a href="{{ route('subscription') }}">Subscription</a>
									</li>

                                    @endif

									<li class="{{ (request()->is('contactus')) ? 'active' : '' }}">
										<a href="{{ route('front.contactus') }}">Contact</a>
									</li>



									<li class="dropdown">
										<a href="#">Categories</a>
										<!-- <i class="sub-menu-toggle fa fa-angle-down"></i> -->
										<ul class="sub-menu">
											@foreach($categories as $category)
											<li><a href="{{ route('front.category', $category->slug) }}">{{ $category->name }}</a></li>
											@endforeach
										</ul>
									</li>

                                    {{-- <li class="dropdown">
										<a href="#">Pages</a>
										<!-- <i class="sub-menu-toggle fa fa-angle-down"></i> -->
										<ul class="sub-menu">
											@foreach($pages_data as $pag)
											<li><a href="{{ route('front.show_page', $pag->slug) }}">{{ $pag->key }}</a></li>
											@endforeach
										</ul>
									</li> --}}

								</ul>
							</nav>
							<div class="btn-wrap">
								<div class="mini-cart-wrap">
									<div class="mini-cart">
										<div class="mini-cart-icon cart-count" id="cart-count" data-count="{{ Session::has('cart') ? count(Session::get('cart')['items']) : '0' }}">
											<i class="ion-bag"></i>
										</div>
									</div>
									<div class="widget-shopping-cart-content" id="cart-items">
										@include('load.cart')
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</header>
		<header class="header header-mobile header-355">
			<div class="container">
				<div class="row">
					<div class="col-xs-2">
						<div class="header-left">
							<div id="open-left"><i class="ion-navicon"></i></div>
						</div>
					</div>
					<div class="col-xs-8">
						<div class="header-center">
							<a href="{{ url('/') }}" id="logo-2">
								<img class="logo-image" src="{{asset('front/images/logo.png')}}" alt="Organik Logo" />
							</a>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="header-right">
							<div class="mini-cart-wrap">
								<!-- <a href="cart.html"> -->
								<div class="mini-cart">
									<div class="mini-cart-icon cart-count" id="cart-count" data-count="{{ Session::has('cart') ? count(Session::get('cart')['items']) : '0' }}">
										<a href="{{ route('cart.page') }}"> <i class="ion-bag"></i> </a>
									</div>
									<!-- <div class="widget-shopping-cart-content" id="cart-items">
											@include('load.cart')
										</div> -->
								</div>
								<!-- </a> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		@yield('content')

		<footer class="footer">
			<div class="container">
				<div class="row">
					{{-- <div class="col-md-5"> --}}
                        <div class="col-md-3">
						<img src="{{asset('front/images/footer_logo.png')}}" class="footer-logo" alt="" />
						<!-- <p>
							We, at Storia®, are committed to achieving a truly circular food and beverage ecosystem.
						</p> -->
						<div class="footer-social">
							<a href="https://www.instagram.com/storiafoods" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a>
							<a href=" https://twitter.com/storiafoods/" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a>
							<!-- <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a> -->
							<a href="https://www.instagram.com/storiafoods/" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram"></i></a>
							<a href="https://www.youtube.com/channel/UC65SDDRJScUEFNnxLUsjtAA" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube"></i></a>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-xs-6">
						<div class="widget">
							<h3 class="widget-title">Information</h3>
							<ul>
								<li><a href="{{ url('/home') }}">Home</a></li>
								<li><a href="{{ route('front.aboutus') }}">About Us</a></li>
								<li><a href="{{ route('front.blog') }}">Our Blog</a></li>
								<li><a href="{{ route('front.contactus') }}">Contact Us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-xs-6">
						<div class="widget">
							<h3 class="widget-title">Useful Link</h3>
							<ul>
								<li><a href="{{ route('front.terms') }}">Terms of Use</a></li>
								<li><a href="{{ route('front.privacy_policy') }}">Privacy Policy</a></li>
								<li><a href="{{ route('front.refund_policy') }}"> Refund Policy</a></li>

                            </ul>
						</div>
					</div>

                    @if (!empty($pages_data) && $pages_data->count() > 0)


                    <div class="col-lg-2 col-md-2 col-xs-12">
						<div class="widget">
							<h3 class="widget-title">Pages</h3>
							<ul>
                                @foreach($pages_data as $pag)
											<li><a href="{{ route('front.show_page', $pag->slug) }}">{{ $pag->key }}</a></li>

								@endforeach



							</ul>
						</div>
					</div>

                    @else
                    <div class="col-lg-2 col-md-2 col-xs-12">

					</div>
                    @endif
					<div class="col-lg-3 col-md-3 col-xs-12">
						<div class="widget">
							<h3 class="widget-title">Subscribe</h3>
							<p>
								Enter your email address for our mailing list to keep yourself updated.
							</p>
							<form class="newsletter" method="POST" action="{{ route('subscribe.email') }}">
								@csrf
								<input type="email" name="email" placeholder="Your email address" required="" />
								<button type="submit"><i class="fa fa-paper-plane"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						Copyright © 2021 <a href="#" class="foodu">Storia Foods</a> - All Rights Reserved.
					</div>
					<div class="col-md-4">
						<img src="images/footer_payment.png" alt="" />
					</div>
				</div>
			</div>
			<div class="backtotop" id="backtotop"></div>
		</div>
	</div>
	<script type="text/javascript">
		var mainurl = "{{url('/')}}";
	</script>


	<script type="text/javascript" src="{{asset('front/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/jquery-migrate.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/modernizr-2.7.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/owl.carousel.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/jquery.countdown.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/jquery.isotope.init.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/script.js')}}"></script>
	<script type="text/javascript" src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{asset('front/js/jquery.themepunch.tools.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/jquery.themepunch.revolution.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.video.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.actions.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.navigation.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.migration.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/extensions/revolution.extension.parallax.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
	<script type="text/javascript" src="{{asset('front/js/slick.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('front/js/custom.js')}}"></script>


	<!-- Flash Message Popup -->
	<script>
		toastr.options = {
			"debug": false,
			"positionClass": "toast-bottom-center",
			"progressBar": true,
			"fadeIn": 300,
			"fadeOut": 1000,
			"timeOut": 3000,
			"extendedTimeOut": 200
		}
	</script>
	@if(Session::has('message'))
	<script>
		toastr.success("{{ session('message') }}");
	</script>
	@elseif(Session::has('error'))
	<script>
		toastr.error("{{ session('error') }}");
	</script>
	@endif
    <script>
    $(document).ready(function(){
    $("img").hide();
});

$(window).load(function(){
    $("img").show();
});
    </script>
	@yield('scripts')

</body>

</html>
