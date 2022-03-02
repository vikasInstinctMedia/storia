




@extends('admin.layout.app')
@section('page_title', 'Category')
@section('style')

@endsection
@section('content')

<div id="main">
			<div class="section section-error pt-12 pb-12">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="text-center">
								<img src="{{ asset('front/images/error/404.png') }}" class="mb-6" alt="" />
								<h3 class="error-title uppercase">Oops! This page is not available</h3>
								<span class="error-content uppercase">
									Please go back to 
									<a href="{{ route('admin.dashboard') }}">Dashboard</a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection

@section('script')
	
@endsection