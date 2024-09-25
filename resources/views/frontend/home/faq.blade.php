<section class="faqs_section" id="faq">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="inner_faqs">
					<div class="faqs_head">
						<h3>FAQ</h3>
						<div class="btn_view">
							<a href="{{ route('homepage.index') }}?viewAll#faq" aria-label="View All FAQ" class="btn-primary">
							    View All
							</a>
						</div>
					</div>
					<div class="accordion_main">
						<div class="accordion" id="accordionExample">
							@foreach($faq as $f => $faq)
								<div class="accordion-item">
								    <h2 class="accordion-header" id="heading{{$f}}">
								      	<button class="accordion-button {{ $f > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$f}}" aria-expanded="true" aria-controls="collapse{{$f}}">
								       {{ $faq['title'] ?? ''}}
								      	</button>
								    </h2>
								    <div id="collapse{{$f}}" class="accordion-collapse collapse {{ $f > 0 ? '' : 'show' }}" aria-labelledby="heading{{$f}}" data-bs-parent="#accordionExample">
								      	<div class="accordion-body">
								            {!! $faq['description'] ?? '' !!}   
								      	</div>
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