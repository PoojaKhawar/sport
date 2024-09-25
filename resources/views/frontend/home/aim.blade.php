<section class="aim_section">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="parent_area">
					<h3>{{ $data['secure_future']['title'] ?? ''}}</h3>
					<div class="row">
						<div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
							<div class="left_area">
								<div class="line line_1"></div>
								<div class="line line_2"></div>
								<div class="image_area">
									<img src="{{General::renderImage(FileSystem::getAllSizeImages($data['secure_future_img']) , 'large')}}" alt="{{ $data['secure_future']['title'] ?? 'aim-image'}}" title="{{ $data['secure_future']['title'] ?? 'aim-image'}}" fetchpriority="low"/>
								</div>
							</div>
						</div>	
						<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
							<div class="right_area">
								<div class="counter_area">
									<h4  id="counter1">{{ $data['secure_future']['total_emp'] ?? '0'}}</h4>
									<p>Employees</p>
								</div>
								<div class="counter_area">
									<h4  id="counter2">{{ $data['secure_future']['total_inspec'] ?? '0'}}</h4>
									<p>Inspections</p>
								</div>
								<div class="counter_area">
									<h4  id="counter3">{{ $data['secure_future']['total_loc'] ?? '0'}}</h4>
									<p>Locations</p>
								</div>
							</div>
						</div>	
					</div>
					<div class="text_area">
						{!! $data['secure_future']['description'] ?? '' !!}
					</div>
					@if(!empty($data['values']))
						<div class="our_value_area">
							<h4>Our Values</h4>
							<div class="cards_area">
								@foreach($data['values'] as $k => $v)
								<div class="my_card">
									<div class="icon_area">
										<img src="{{ General::renderImage(FileSystem::getAllSizeImages($data['value_img' . ($k + 1)] ?? ''), 'large') }}" alt="{{ $v['title'] ?? 'value-icon' }}" title="{{ $v['title'] ?? 'value-icon' }}" fetchpriority="low" width="50px" height="51px" />
									</div>
									<h5 class="match_height_heading">{{ $v['title'] ?? '' }}</h5>
									<p class="match_height_txt">
										{{ $v['description'] ?? '' }}
									</p>
								</div>
								@endforeach
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>