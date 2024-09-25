<section class="services_section" id="services">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="parent_area">
					<div class="title_area">
						<h3>{{ $data['service_content']['title'] ?? ''}}</h3>
						<p> {{ $data['service_content']['description'] ?? ''}} </p>
					</div>
					<div class="row align-items-center">
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-5 col-sm-5 col-12">
							<div class="left_area">
								<div class="image_area">
									<img src="{{General::renderImage(FileSystem::getAllSizeImages($data['service_img']), 'large')}}" alt="Service-image" title="services-image" fetchpriority="low"/>	
								</div>
							</div>
						</div>
						<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-7 col-sm-7 col-12">
							<div class="right_area">
								<div class="top_area">
									<div class="img_title_area">
										<div class="img_area">
											<img src="{{ url('/frontend/images/icon_1.png')}}" alt="{{ $data['service_content']['sub_title'] ?? 'service-image'}}" title="{{ $data['service_content']['sub_title'] ?? 'service-image'}}" fetchpriority="low"/>
										</div>
										<div class="title">{{ $data['service_content']['sub_title'] ?? ''}}</div>
									</div>
									<p> {{ $data['service_content']['sub_description'] ?? ''}}</p>
								</div>
								@if(!empty($data['service']) && count($data['service']) > 0)
									<div class="bottom_area">
										<ul>
											@foreach($data['service'] as $key => $val)
												<li>
													<div class="img_area">
														<img src="{{General::renderImage(FileSystem::getAllSizeImages($val['icon'] ),'large')}}" alt="{{ $val['title'] ?? 'icon'}}" title="{{ $val['title'] ?? 'icon'}}" fetchpriority="low"/>
													</div>
													<span>{{ $val['title'] ?? ''}}</span>
												</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>