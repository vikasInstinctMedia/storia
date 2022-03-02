<div class="section section-bg-7 section-cover pt-4 pb-8">
		<div class="col-sm-12">
			<h2 class="text-center section-title pb-4">Customer Reviews</h2>
			<div class="organik-seperator center">
				<span class="sep-holder"><span class="sep-line"></span></span>

				<span class="sep-holder"><span class="sep-line"></span></span>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="testimonial-carousel organik-testimonial style-3" data-auto-play="true" data-desktop="3" data-laptop="3" data-tablet="2" data-mobile="1">

                        @if (isset($about_us_data_array['client_slider']))
                        @foreach ($about_us_data_array['client_slider'] as $cln)

                        <div class="testi-item">
							<div class="text">
                                {{ $cln['description'] }}
                            </div>
							<div class="info">
								<div class="photo">
									<img src="{{ asset('storage/'. $cln['image']) }}" alt="" />
								</div>
								<div class="author">
									<span class="name">{{ $cln['title'] }}</span>

								</div>
							</div>
						</div>

                        @endforeach
                        @endif
					</div>
				</div>
			</div>
		</div>
	</div>
