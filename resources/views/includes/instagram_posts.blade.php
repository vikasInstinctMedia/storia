<div class="section pt-7 pb-7">

    <div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="text-center">
						<div class="text-center mb-1 section-pretitle fz-34">Discover</div>
						<h2 class="text-center section-title mtn-2 fz-24">LETS CONNECT ON INSTAGRAM</h2>
						<div class="product-carousel" data-auto-play="true" data-desktop="3" data-laptop="2" data-tablet="2" data-mobile="1">

                            @if (isset($about_us_data_array['instagram_slider']))
                            @foreach ($about_us_data_array['instagram_slider'] as $ins)


                            <div class="product-item text-center">
								<div class="product-thumb">
									<a href="{{ $ins['redirect_url'] }}">
										<img src="{{ asset('storage/'. $ins['image']) }}" alt="" />
									</a>
								</div>
							</div>

                            @endforeach
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
