@php
use App\Models\Admin\Setting;
$companyName = Setting::get('company_name');
$companyEmail = Setting::get('company_email');
$companyPhoneNumber = Setting::get('company_phonenumber');
$companyAddress = Setting::get('company_address');
$companyTiming = Setting::get('company_timing');
@endphp
<section class="get_touch_section" id="contactUs">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="inner_area">
					<div class="content_main">
						<div class="left_area">
							<div class="map_area">
								<iframe 
								src="https://maps.google.it/maps?q={{ $companyAddress ?? ''}}&output=embed"
								loading="lazy"
								referrerpolicy="no-referrer-when-downgrade"
								allowfullscreen
								zoom=5
								class="frame_style"
								></iframe>

								{{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d109744.197454309!2d76.77071360000001!3d30.732280449999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fed0be66ec96b%3A0xa5ff67f9527319fe!2sChandigarh!5e0!3m2!1sen!2sin!4v1722938791887!5m2!1sen!2sin"></iframe> --}}
							</div>
						</div>
						<div class="right_area">
							<div class="form_area">
								<form action="{{ route('contactus.index')}}" method="post" id="contactUsForm">
									@csrf
									<h3>Get in touch with us</h3>
									<div class="row">
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
											<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">	
											<div class="form-group">
												<input type="text" name="first_name" class="form-control" placeholder="First Name" />
											</div>
										</div>
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
											<div class="form-group">
												<input type="text" name="last_name" class="form-control" placeholder="Last Name" />
											</div>
										</div>
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
											<div class="form-group">
												<input type="text" name="email" class="form-control" placeholder="Email" />
											</div>
										</div>
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
											<div class="form-group">
												<input type="text" name="phonenumber" class="form-control" placeholder="Phone Number" />
											</div>
										</div>
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
											<div class="form-group">
												<input type="text" name="company_name" class="form-control" placeholder="Company Name" />
											</div>
										</div>
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-6 col-12">
											<div class="form-group">
												<input type="text" name="country" class="form-control" placeholder="Country" />
											</div>
										</div>
										<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="form-group">
												<input type="text" name="subject" class="form-control" placeholder="Subject" />
											</div>
										</div>
										<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="form-group">
												<textarea name="message" placeholder="Message" class="form-control"></textarea>
											</div>
										</div>
									</div>
									<div class="btn_sub">
										<button class="btn-primary" type="submit">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="info_content">
						<div class="inner_info">
							<div class="item_info">
								<div class="icon_text_area">
									<i class="fal fa-map-marker-alt"></i>
									<span>Visit</span>
								</div>
								<a  href="https://www.google.com/maps/search/{{ urlencode($companyAddress ?? '#') }}" aria-label="Company Address" target="_blank">
									{{  characterLimitWithRemoveTags($companyAddress , 35) ?? '#'  }}
								</a>
								<!-- <p>From Monday to Friday: 12:00-17:00</p> -->
							</div>
						</div>
						<div class="inner_info">
							<div class="item_info">
								<div class="icon_text_area">
									<i class="far fa-phone-alt"></i>
									<span>Call</span>
								</div>
								<a href="tel:{{ $companyPhoneNumber ?? '#' }}" aria-label="Company Phone Number" target="_blank">
									{{ $companyPhoneNumber ?? '#' }}
								</a>
								<!-- <p>From Monday to Friday: 12:00-17:00</p> -->
							</div>
						</div>
						<div class="inner_info">
							<div class="item_info">
								<div class="icon_text_area">
									<i class="far fa-envelope"></i>
									<span>Email</span>
								</div>
								<a  href="mailto:{{ $companyEmail ?? '#' }}" aria-label="Company Email" target="_blank" >
                                     {{ $companyEmail ?? '#' }}
								</a>
								<!-- <p>From Monday to Friday: 12:00-17:00</p> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>