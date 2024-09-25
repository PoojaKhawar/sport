<section class="trust_section" id="testimonials">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="parent_area">
					<h3>{{ $data['testimonials']['title'] ?? ''}}</h3>
					<div class="slider_area">
						<div class="owl-carousel owl-theme" id="trust_sec_slider">
							@foreach($testimonials as $t => $test)
						    <div class="item">
						    	<div class="item_inner">
						    		<div class="img_area">
						    			<img src="{{ url('/frontend/images/quote.png')}}" alt="Quote-image" title="Quote-image" fetchpriority="low" />
						    		</div>
						    		<p>
						    			{{ $test['description'] ?? ''}}
						    		</p>
						    		<h5>{{ $test['title'] ?? ''}}</h5>
						    		<h6>{{ $test['designation'] ?? ''}}</h6>
						    	</div>
						    </div>
						    @endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>