@php 
	if(is_array($files) && !empty($files) && isset($files[0]))
@endphp
<div class="owl-carousel owl-theme">
	@foreach ($files as $key => $value) 
		@php
		$value = isset($value['medium']) && $value['medium'] ? $value['medium'] : (isset($value['original']) && $value['original'] ? $value['original'] : "");
		@endphp
		@if($value)
			<div class="item {{ $key < 1 ? ' active' : '' }}">
				<img src="{{ url($value) }}" alt="">
			</div>
		@endif
	@endforeach
</div>
@elseif(!empty($files))
	@php 
	$value = isset($files['medium']) && $files['medium'] ? $files['medium'] : (isset($value['original']) && $value['original'] ? $value['original'] : "")
	@endphp
	@if($value)
	<img src="{{ url($value) }}">
	@endif
@endif
