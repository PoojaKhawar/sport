<section class="banner_section" id="aboutUs">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="parent_area">
					<h3>{{ $data['clear_air']['main_title'] ?? ''}}</h3>
					<div class="left_area">
						<h4>{{ $data['clear_air']['sub_title'] ?? ''}}</h4>
						<p>{{ $data['clear_air']['description'] ?? ''}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="image_area">
		<div class="actual_img">
			<img src="{{General::renderImage(FileSystem::getAllSizeImages($data['cleaner_img']), 'large')}}" alt="banner-image" fetchpriority="low" title="banner-image" />
		</div>
	</div>
</section>