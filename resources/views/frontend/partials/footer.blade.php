<!-- Footer-section---start -->
<section class="footer_section">
	<div class="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="inner_area">
						<div class="row">
							<div class="col-xxl-5 col-xl-5 col-lg-4 col-md-12 col-sm-12 col-12">
								<div class="content_main">
									<h3>{{ $footer['title'] ?? ''}}</h3>
									<div class="txt">
										{{ $footer['description'] ?? ''}}									    
									</div>
								</div>
							</div>
							<div class="col-xxl-7 col-xl-7 col-lg-8 col-md-12 col-sm-12 col-12">
								<div class="main_list">
									<div class="row">
										<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
											<div class="company_main">
												<h4>Company</h4>
												<ul class="inner_list">
													<li>
														<a href="{{ route('homepage.index')}}" aria-label="Home Pages" class="text">Home</a>
													</li>
													@if(!empty($about))
														<li>
															<a href="{{ route('homepage.index')}}#aboutUs" aria-label="About Us" class="text">
															    About
															</a>
														</li>
													@endif
													@if(!empty($services))
														<li>
															<a href="{{ route('homepage.index')}}#services" aria-label="Services" class="text">
															    Services
															</a>
														</li>
													@endif
													 @if(!empty($testCount) && $testCount > 0)
													<li>
														<a href="{{ route('homepage.index')}}#testimonials" aria-label="Testimonials" class="text">
														    Testimonials
														</a>
													</li>
													@endif
												</ul>
											</div>
										</div>
										@if(!empty($legal) && count($legal) > 0)
										<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
											<div class="company_main">
												<h4>Legal</h4>
												<ul class="inner_list">
													@foreach($legal as $k => $val)
														<li class="{{ request()->route('slug') == $val->slug ? 'active' : ''}}">
															{{-- <a href="{{ route('pages.index',['slug' => $val->slug]) }}" aria-label="{{ ucfirst($val->title)}}" class="text">{{ ucfirst($val->title)}}</a> --}}
															<a href="javascript:;" aria-label="{{ ucfirst($val->title)}}" class="text">{{ ucfirst($val->title)}}</a>
														</li>
													@endforeach
													{{-- <li>
														<a href="javascript:;" aria-label="" class="text">Terms of Use</a>
													</li>
													<li>
														<a href="javascript:;" aria-label="" class="text">Cookie Settings</a>
													</li>
													<li>
														<a href="javascript:;" aria-label="" class="text">Privacy Notice</a>
													</li> --}}
												</ul>
											</div>
										</div>
										@endif
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
											<div class="company_main info_list">
												<ul class="inner_list">
													<li>
														<a href="https://www.google.com/maps/search/{{ urlencode($companyAddress ?? '#') }}" aria-label="Company Address" target="_blank" class="text">     <i class="fal fa-map-marker-alt"></i>
															<span>
															    {{ characterLimitWithRemoveTags($companyAddress , 35) ?? '#' }}
														    </span>
														</a>
													</li>
													<li>
														<a href="tel:{{ $companyPhoneNumber ?? '#' }}" aria-label="Company Phone Number" target="_blank" class="text">
															<i class="fal fa-phone-alt"></i>
															<span>{{ $companyPhoneNumber ?? '#' }}</span>
														</a>
													</li>
													<li>
														<a href="mailto:{{ $companyEmail ?? '#' }}" aria-label="Company Email" target="_blank" class="text">
															<i class="fal fa-envelope"></i>
															<span>
																{{ $companyEmail ?? '#' }}
															</span>
														</a>
													</li>
													<li>
													    <a aria-label="Company Timing" class="text" target="_blank">
													        <i class="fal fa-clock"></i>
													        <span>{{ $companyTiming ? $companyTiming : 'Not Available' }}</span>
													    </a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer_bottom">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="inner_area">
						<div class="copyright">© 2024 | All Rights Reserved | Powered By <a href="https://globiztechnology.com/" aria-label="" class="globiz">Globiz Technology Inc.</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Footer-section---end -->