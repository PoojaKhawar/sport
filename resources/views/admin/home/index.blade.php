@extends('layouts.adminlayout')
@section('content')
@php
    use App\Models\Admin\PageContent;
@endphp

<style>
  .border-dotted {
    border-style: dotted;
    border-width: thin;
  }
</style>

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>MANAGE HOME CONTENT</h6>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content_area">
    <div class="container-xxl flex-grow-1 container-p-y">
    	<!--!! FLAST MESSAGES !!-->
    	@include('admin.partials.flash_messages')
    	<div class="row">
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3">
    			<div class="card">
    				<h5 class="card-header">Clean Air Initiative</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					@php
    					    $clearAir = PageContent::getData('home', 'clear_air', 'data');
    					    $clearAirImg = PageContent::getData('home', 'cleaner_img', 'image');
    					@endphp
    					<form action="{{ route('admin.pageContent',['type' => 'home']) }}#clear_air" method="post" class="validation1">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Main Title</label>
    									<input type="text" class="form-control" name="data[clear_air][main_title]" value="{{ old('data[clear_air][main_title]' , $clearAir->main_title ?? '') }}" placeholder="Enter Title" maxlength="40" required />
    									<small>Maximun character : 40</small>
    									<label id="data[clear_air][main_title]-error" class="error" for="data[clear_air][main_title]">
	    									@error('data[clear_air][main_title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Sub Title</label>
    									<input type="text" class="form-control" name="data[clear_air][sub_title]" value="{{ old('data[clear_air][sub_title]' , $clearAir->sub_title ?? '') }}" placeholder="Enter Title" maxlength="150" required />
    									<small>Maximun character : 150</small>
    									<label id="data[clear_air][sub_title]-error" class="error" for="data[clear_air][sub_title]">
	    									@error('data[clear_air][sub_title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Description</label>
    									<textarea class="form-control" name="data[clear_air][description]" placeholder="Enter Description" maxlength="200" required>{{ old('data[clear_air][description]', $clearAir->description ?? '') }}</textarea>
    									<small>Maximum character : 200</small>
    									<label id="data[clear_air][description]-error" class="error" for="data[clear_air][description]">
    									    @error('data[clear_air][description]') 
    									        {{ $message }} 
    									    @enderror
    									</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    								<div class="form-group">
    									<label class="form-label">Image</label>
    									<div 
    										class="upload-image-section"
    										data-type="image"
    										data-multiple="false"
    										data-path="home"
    										data-resize-large="1152*680"
    										data-resize-medium="768*453"
    										data-resize-small="384*226"
    									>
    										<div class="upload-section {{ isset($clearAirImg->data) && $clearAirImg->data  ? 'd-none' : "" }} ">
    											<div class="button-ref mb-3">
    												<button class="btn btn-primary" type="button">
    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
    									                <span class="btn-inner--text">Upload Image</span>
    								              	</button>
    								              	@include('admin.partials.recommendedSize', ['width' => '1152', 'height' => "680"])
    								            </div>
    								            <!-- PROGRESS BAR -->
    											<div class="progress d-none">
    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    							                </div>
    							            </div>
    						                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="image[cleaner_img]"></textarea>
							                <div class="show-section {{ !old('image.cleaner_img') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image.cleaner_img') ])
							                </div>
							                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
							                	@include('admin.partials.previewFileRender', ['file' => $clearAirImg->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $clearAirImg->id ?? '' ])
							                </div>
    									</div>
    								</div>
    							</div>
    						</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3" id="service">
    			<div class="card">
    				<h5 class="card-header">Service</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					@php
    					    $service = PageContent::getData('home', 'service', 'json');
    					    $content = PageContent::getData('home', 'service_content', 'data');
    					    $serviceImg = PageContent::getData('home', 'service_img', 'image');
    					    $auditIcon = PageContent::getData('home', 'service_audit_icon', 'image');
    					@endphp
    					<form action="{{ route('admin.pageContent',['type' => 'home']) }}#service" method="post" class="validation2">
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
    								<div class="form-group">
    									<label class="form-label">Title</label>
    									<input type="text" class="form-control" name="data[service_content][title]" value="{{ old('data[service_content][title]' , $content->title ?? '') }}" placeholder="Enter Title" maxlength="30" required />
    									<small>Maximun character : 30</small>
    									<label id="data[service_content][title]-error" class="error" for="data[service_content][title]">
	    									@error('data[service_content][title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
    								<div class="form-group">
    									<label class="form-label">Sub Title</label>
    									<input type="text" class="form-control" name="data[service_content][sub_title]" value="{{ old('data[service_content][sub_title]' , $content->sub_title ?? '') }}" placeholder="Enter Sub Title" maxlength="30" required />
    									<small>Maximun character : 30</small>
    									<label id="data[service_content][sub_title]-error" class="error" for="data[service_content][sub_title]">
	    									@error('data[service_content][sub_title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
    								<div class="form-group">
    									<label class="form-label">Description</label>
    									<textarea class="form-control" name="data[service_content][description]" maxlength="200" placeholder="Enter Description" required>{{ old('data[service_content][description]', $content->description ?? '') }}</textarea>
    									<small>Maximun character : 200</small>
    									<label id="data[service_content][description]-error" class="error" for="data[service_content][description]">
    									    @error('data[service_content][description]') 
    									        {{ $message }} 
    									    @enderror
    									</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
    								<div class="form-group">
    									<label class="form-label">Sub Description</label>
    									<textarea class="form-control" name="data[service_content][sub_description]"  maxlength="200" placeholder="Enter Sub Description" required>{{ old('data[service_content][sub_description]', $content->sub_description ?? '') }}</textarea>
    									<small>Maximun character : 200</small>
    									<label id="data[service_content][sub_description]-error" class="error" for="data[service_content][sub_description]">
    									    @error('data[service_content][sub_description]') 
    									        {{ $message }} 
    									    @enderror
    									</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    								<div class="form-group">
    									<label class="form-label">Image</label>
    									<div 
    										class="upload-image-section"
    										data-type="image"
    										data-multiple="false"
    										data-path="home"
    										data-resize-large="1000*1000"
    										data-resize-medium="610*589 "
    										data-resize-small="300*300"
    									>
    										<div class="upload-section {{ isset($serviceImg->data) && $serviceImg->data  ? 'd-none' : "" }} ">
    											<div class="button-ref mb-3">
    												<button class="btn btn-primary" type="button">
    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
    									                <span class="btn-inner--text">Upload Image</span>
    								              	</button>
    								              	@include('admin.partials.recommendedSize', ['width' => '610', 'height' => "589"])
    								            </div>
    								            <!-- PROGRESS BAR -->
    											<div class="progress d-none">
    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    							                </div>
    							            </div>
    						                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="image[service_img]"></textarea>
							                <div class="show-section {{ !old('image.service_img') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image.service_img') ])
							                </div>
							                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
							                	@include('admin.partials.previewFileRender', ['file' => $serviceImg->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $serviceImg->id ?? '' ])
							                </div>
    									</div>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    								<div class="form-group">
    									<label class="form-label">Sub Icon</label>
    									<div 
    										class="upload-image-section"
    										data-type="image"
    										data-multiple="false"
    										data-path="home"
    										data-resize-large="36*36"
    										data-resize-medium="24*24"
    										data-resize-small="16*16"
    									>
    										<div class="upload-section {{ isset($auditIcon->data) && $auditIcon->data  ? 'd-none' : "" }} ">
    											<div class="button-ref mb-3">
    												<button class="btn btn-primary" type="button">
    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
    									                <span class="btn-inner--text">Upload Icon</span>
    								              	</button>
    								              	@include('admin.partials.recommendedSize', ['width' => '36', 'height' => "36"])
    								            </div>
    								            <!-- PROGRESS BAR -->
    											<div class="progress d-none">
    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    							                </div>
    							            </div>
    						                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="image[service_audit_icon]"></textarea>
							                <div class="show-section {{ !old('image.service_audit_icon') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image.service_audit_icon') ])
							                </div>
							                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
							                	@include('admin.partials.previewFileRender', ['file' => $auditIcon->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $auditIcon->id ?? '' ])
							                </div>
    									</div>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
    								<div class="card border">
    									<div class="card-header">
    										<h6>Audits ( Reports Listing)</h6>
    										<div style="text-align: right; margin-top: -28px;">
										        <p class="btn btn-primary btn-sm" id="addMore">Add More +</p>
										    </div> 
    									</div>
    									<div class="card-body">
    										<div id="auditContainer">
    											@if(!empty($service) && count($service) > 0)
	    											@foreach($service as $k => $value)
		    											<div class="row border-dotted mt-3 audit-item py-2">
						    								<div style="text-align: right;" class="remove-item">
														        <i class="fas fa-times"></i>
														    </div>
														    <input type="hidden" value="{{ $k }}" class="index">
						    								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
							    								<div class="form-group">
							    									<label class="form-label">Title</label>
							    									<input type="text" class="form-control" name="json[service][{{ $k}}][title]" value="{{ old('json[service][' . $k . '][title]', $value['title'] ?? '') }}" placeholder="Enter Title" maxlength="30" required />
							    									<small>Maximun character : 30</small>
							    									<label id="json[service][{{ $k}}][title]-error" class="error" for="json[service][{{ $k}}][title]">
								    									@error('json[service]['. $k.'][title]')
								    								        {{ $message }} 
								    								    @enderror
							    								    </label>
							    								</div>
							    							</div>
							    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
							    								<div class="form-group">
							    									<label class="form-label">Sub Icon</label>
							    									<div 
							    										class="upload-image-section"
							    										data-type="image"
							    										data-multiple="false"
							    										data-path="home"
							    										data-resize-large="36*36"
							    										data-resize-medium="24*24"
							    										data-resize-small="16*16"
							    									>
							    										<div class="upload-section {{ isset($value['icon']) && $value['icon']  ? 'd-none' : "" }} ">
							    											<div class="button-ref mb-3">
							    												<button class="btn btn-primary" type="button">
							    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
							    									                <span class="btn-inner--text">Upload Image</span>
							    								              	</button>
							    								              	@include('admin.partials.recommendedSize', ['width' => '36', 'height' => "36"])
							    								            </div>
							    								            <!-- PROGRESS BAR -->
							    											<div class="progress d-none">
							    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
							    							                </div>
							    							            </div>
							    						                <!-- INPUT WITH FILE URL -->
														                <textarea class="d-none" name="json[service][{{$k}}][icon]">
														                	{{ $value['icon']}}
														                </textarea>
														                <div class="show-section {{ old('json[service]['.$k.'][icon]') ? '' : 'd-none' }}">
														                	@include('admin.partials.previewFileRender', ['file' => old('image.cleaner_img') ])
														                </div>
														                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
														                	@include('admin.partials.previewFileRender', ['file' => $value['icon'] ?? '', 'relationType' => 'pages_content.data', 'relationId' => $value['id'] ?? '' ])
														                </div>
							    									</div>
							    								</div>
							    							</div>							
						    							</div>
					    							@endforeach
				    							@else
				    							    <div class="row border-dotted mt-3 audit-item py-2">
					    								<div style="text-align: right;" class="remove-item">
													        <i class="fas fa-times"></i>
													    </div>
													    <input type="hidden" value="0" class="index">
					    								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
						    								<div class="form-group">
						    									<label class="form-label">Title</label>
						    									<input type="text" class="form-control" name="json[service][0][title]" value="{{ old('json[service][0][title]' , $service->title ?? '') }}" placeholder="Enter Title" maxlength="30" required />
						    									<small>Maximun character : 30</small>
						    									<label id="json[service][0][title]-error" class="error" for="json[service][0][title]">
							    									@error('json[service][0][title]')
							    								        {{ $message }} 
							    								    @enderror
						    								    </label>
						    								</div>
						    							</div>
						    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						    								<div class="form-group">
						    									<label class="form-label">Sub Icon</label>
						    									<div 
						    										class="upload-image-section"
						    										data-type="image"
						    										data-multiple="false"
						    										data-path="home"
						    										data-resize-large="36*36"
						    										data-resize-medium="24*24"
						    										data-resize-small="16*16"
						    									>
						    										<div class="upload-section {{ isset($value['icon']) && $value['icon']  ? 'd-none' : "" }} ">
						    											<div class="button-ref mb-3">
						    												<button class="btn btn-primary" type="button">
						    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
						    									                <span class="btn-inner--text">Upload Image</span>
						    								              	</button>
						    								              	@include('admin.partials.recommendedSize', ['width' => '36', 'height' => "36"])
						    								            </div>
						    								            <!-- PROGRESS BAR -->
						    											<div class="progress d-none">
						    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
						    							                </div>
						    							            </div>
						    						                <!-- INPUT WITH FILE URL -->
													                <textarea class="d-none" name="json[service][0][icon]"></textarea>
													                <div class="show-section {{ old('json[service][0][icon]') ? '' : 'd-none' }}">
													                	@include('admin.partials.previewFileRender', ['file' => old('image.cleaner_img') ])
													                </div>
						    									</div>
						    								</div>
						    							</div>							
					    							</div>
				    							@endif
    										</div>
    									</div>    									
    								</div>
    							</div>
    						</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3" id="secure">
    			<div class="card">
    				<h5 class="card-header">Secure Future</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					@php
    					    $secureFuture = PageContent::getData('home', 'secure_future', 'data');
    					    $secureFutureImg = PageContent::getData('home', 'secure_future_img', 'image');
    					@endphp
    					<form action="{{ route('admin.pageContent',['type' => 'home']) }}#secure" method="post" class="validation3">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
    								<div class="form-group">
    									<label class="form-label">Total Employee</label>
    									<input type="number" class="form-control" name="data[secure_future][total_emp]" value="{{ old('data[secure_future][total_emp]' , $secureFuture->total_emp ?? '') }}" placeholder="Enter Total Employee" maxlength="150" required />
    									<label id="data[secure_future][total_emp]-error" class="error" for="data[secure_future][total_emp]">
	    									@error('data[secure_future][total_emp]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
    								<div class="form-group">
    									<label class="form-label">Total Inspection</label>
    									<input type="number" class="form-control" name="data[secure_future][total_inspec]" value="{{ old('data[secure_future][total_inspec]' , $secureFuture->total_inspec ?? '') }}" placeholder="Enter Total Inspection" maxlength="150" required />
    									<label id="data[secure_future][total_inspec]-error" class="error" for="data[secure_future][total_inspec]">
	    									@error('data[secure_future][total_inspec]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
    								<div class="form-group">
    									<label class="form-label">Total Location</label>
    									<input type="number" class="form-control" name="data[secure_future][total_loc]" value="{{ old('data[secure_future][total_loc]' , $secureFuture->total_loc ?? '') }}" placeholder="Enter Total Loaction" maxlength="150" required />
    									<label id="data[secure_future][total_loc]-error" class="error" for="data[secure_future][total_loc]">
	    									@error('data[secure_future][total_loc]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Title</label>
    									<input type="text" class="form-control" name="data[secure_future][title]" value="{{ old('data[secure_future][title]' , $secureFuture->title ?? '') }}" placeholder="Enter Title" maxlength="70" required />
    									<small>Maximun character : 70</small>
    									<label id="data[secure_future][title]-error" class="error" for="data[secure_future][title]">
	    									@error('data[secure_future][title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Description</label>
    									<textarea id="editor2" class="form-control" name="data[secure_future][description]" placeholder="Enter Description" required>{{ old('data[secure_future][description]', $secureFuture->description ?? '') }}</textarea>
    									<label id="data[secure_future][description]-error" class="error" for="data[secure_future][description]">
    									    @error('data[secure_future][description]') 
    									        {{ $message }} 
    									    @enderror
    									</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    								<div class="form-group">
    									<label class="form-label">Image</label>
    									<div 
    										class="upload-image-section"
    										data-type="image"
    										data-multiple="false"
    										data-path="home"
    										data-resize-large="1052*516"
    										data-resize-medium="700*342"
    										data-resize-small="350*171"
    									>
    										<div class="upload-section {{ isset($secureFutureImg->data) && $secureFutureImg->data  ? 'd-none' : "" }} ">
    											<div class="button-ref mb-3">
    												<button class="btn btn-primary" type="button">
    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
    									                <span class="btn-inner--text">Upload Image</span>
    								              	</button>
    								              	@include('admin.partials.recommendedSize', ['width' => '1052', 'height' => "516"])
    								            </div>
    								            <!-- PROGRESS BAR -->
    											<div class="progress d-none">
    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    							                </div>
    							            </div>
    						                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="image[secure_future_img]"></textarea>
							                <div class="show-section {{ !old('image.secure_future_img') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image.secure_future_img') ])
							                </div>
							                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
							                	@include('admin.partials.previewFileRender', ['file' => $secureFutureImg->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $secureFutureImg->id ?? '' ])
							                </div>
    									</div>
    								</div>
    							</div>
    						</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3" id="value">
    			<div class="card">
    				<h5 class="card-header">Our Value</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					@php
    					    $values = PageContent::getData('home', 'values', 'json');
    					    $valuesImgOne = PageContent::getData('home', 'value_img1', 'image');
    					    $valuesImgtwo = PageContent::getData('home', 'value_img2', 'image');
    					    $valuesImgthree = PageContent::getData('home', 'value_img3', 'image');
    					    $valuesImgfour = PageContent::getData('home', 'value_img4', 'image');
    					@endphp
    					<form action="{{ route('admin.pageContent',['type' => 'home']) }}#value" method="post" class="validation4">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						  <div class="row">
					            <!-- Card 1 -->
					            <div class="col-md-6 col-lg-3 mb-4">
					                <div class="card">
					                    <div class="card-body">
					                        <h5 class="card-title">Card 1</h5>
					                        <div class="form-group">
					                            <label for="title1">Title</label>
					                            <input type="text" id="title1" name="json[values][0][title]" value="{{ $values[0]['title'] ?? '' }}" class="form-control" placeholder="Enter Title" maxlength="30" required>
    									        <small>Maximun character : 30</small>
					                        </div>
					                        <div class="form-group">
					                            <label for="description1">Description</label>
					                            <textarea id="description1" name="json[values][0][description]" maxlength="150" class="form-control" placeholder="Enter Description" required>{{ $values[0]['description'] ?? ''}}</textarea>
    									        <small>Maximun character : 150</small>
					                        </div>
		    								<div class="form-group">
		    									<label class="form-label">Image</label>
		    									<div 
		    										class="upload-image-section"
		    										data-type="image"
		    										data-multiple="false"
		    										data-path="home"
		    										data-resize-large="53*53"
		    										data-resize-medium="43*43"
		    										data-resize-small="33*33"
		    									>
		    										<div class="upload-section {{ isset($valuesImgOne->data) && $valuesImgOne->data  ? 'd-none' : "" }} ">
		    											<div class="button-ref mb-3">
		    												<button class="btn btn-primary" type="button">
		    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
		    									                <span class="btn-inner--text">Upload Image</span>
		    								              	</button>
		    								              	@include('admin.partials.recommendedSize', ['width' => '53', 'height' => "53"])
		    								            </div>
		    								            <!-- PROGRESS BAR -->
		    											<div class="progress d-none">
		    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		    							                </div>
		    							            </div>
		    						                <!-- INPUT WITH FILE URL -->
									                <textarea class="d-none" name="image[value_img1]"></textarea>
									                <div class="show-section {{ !old('image.value_img1') ? 'd-none' : "" }}">
									                	@include('admin.partials.previewFileRender', ['file' => old('image.value_img1') ])
									                </div>
									                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
									                	@include('admin.partials.previewFileRender', ['file' => $valuesImgOne->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $valuesImgOne->id ?? '' ])
									                </div>
		    									</div>
		    								</div>
					                    </div>
					                </div>
					            </div>

					            <!-- Card 2 -->
					            <div class="col-md-6 col-lg-3 mb-4">
					                <div class="card">
					                    <div class="card-body">
					                        <h5 class="card-title">Card 2</h5>
					                        <div class="form-group">
					                            <label for="title2">Title</label>
					                            <input type="text" id="title2" name="json[values][1][title]" value="{{ $values[1]['title'] ?? ''}}" class="form-control" placeholder="Enter Title" maxlength="30" required>
					                            <small>Maximun character : 30</small>
					                        </div>
					                        <div class="form-group">
					                            <label for="description2">Description</label>
					                            <textarea id="description2" name="json[values][1][description]" maxlength="150"class="form-control" placeholder="Enter Description" required>{{ $values[1]['description'] ?? ''}}</textarea>
					                            <small>Maximun character : 150</small>
					                        </div>
					                        <div class="form-group">
		    									<label class="form-label">Image</label>
		    									<div 
		    										class="upload-image-section"
		    										data-type="image"
		    										data-multiple="false"
		    										data-path="home"
		    										data-resize-large="53*53"
		    										data-resize-medium="43*43"
		    										data-resize-small="33*33"
		    									>
		    										<div class="upload-section {{ isset($valuesImgtwo->data) && $valuesImgtwo->data  ? 'd-none' : "" }} ">
		    											<div class="button-ref mb-3">
		    												<button class="btn btn-primary" type="button">
		    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
		    									                <span class="btn-inner--text">Upload Image</span>
		    								              	</button>
		    								              	@include('admin.partials.recommendedSize', ['width' => '53', 'height' => "53"])
		    								            </div>
		    								            <!-- PROGRESS BAR -->
		    											<div class="progress d-none">
		    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		    							                </div>
		    							            </div>
		    						                <!-- INPUT WITH FILE URL -->
									                <textarea class="d-none" name="image[value_img2]"></textarea>
									                <div class="show-section {{ !old('image.value_img2') ? 'd-none' : "" }}">
									                	@include('admin.partials.previewFileRender', ['file' => old('image.value_img2') ])
									                </div>
									                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
									                	@include('admin.partials.previewFileRender', ['file' => $valuesImgtwo->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $valuesImgtwo->id ?? '' ])
									                </div>
		    									</div>
		    								</div>
					                    </div>
					                </div>
					            </div>

					            <!-- Card 3 -->
					            <div class="col-md-6 col-lg-3 mb-4">
					                <div class="card">
					                    <div class="card-body">
					                        <h5 class="card-title">Card 3</h5>
					                        <div class="form-group">
					                            <label for="title3">Title</label>
					                            <input type="text" id="title3" name="json[values][2][title]" value="{{ $values[2]['title'] ?? ''}}" class="form-control" placeholder="Enter Title" maxlength="30" required>
					                            <small>Maximun character : 30</small>
					                        </div>
					                        <div class="form-group">
					                            <label for="description3">Description</label>
					                            <textarea id="description3" name="json[values][2][description]" maxlength="150" class="form-control" placeholder="Enter Description" required>{{ $values[2]['description'] ?? ''}}</textarea>
					                            <small>Maximun character : 150</small>
					                        </div>
					                       <div class="form-group">
		    									<label class="form-label">Image</label>
		    									<div 
		    										class="upload-image-section"
		    										data-type="image"
		    										data-multiple="false"
		    										data-path="home"
		    										data-resize-large="53*53"
		    										data-resize-medium="43*43"
		    										data-resize-small="33*33"
		    									>
		    										<div class="upload-section {{ isset($valuesImgthree->data) && $valuesImgthree->data  ? 'd-none' : "" }} ">
		    											<div class="button-ref mb-3">
		    												<button class="btn btn-primary" type="button">
		    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
		    									                <span class="btn-inner--text">Upload Image</span>
		    								              	</button>
		    								              	@include('admin.partials.recommendedSize', ['width' => '53', 'height' => "53"])
		    								            </div>
		    								            <!-- PROGRESS BAR -->
		    											<div class="progress d-none">
		    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		    							                </div>
		    							            </div>
		    						                <!-- INPUT WITH FILE URL -->
									                <textarea class="d-none" name="image[value_img3]"></textarea>
									                <div class="show-section {{ !old('image.value_img3') ? 'd-none' : "" }}">
									                	@include('admin.partials.previewFileRender', ['file' => old('image.value_img3') ])
									                </div>
									                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
									                	@include('admin.partials.previewFileRender', ['file' => $valuesImgthree->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $valuesImgthree->id ?? '' ])
									                </div>
		    									</div>
		    								</div>
					                    </div>
					                </div>
					            </div>

					            <!-- Card 4 -->
					            <div class="col-md-6 col-lg-3 mb-4">
					                <div class="card">
					                    <div class="card-body">
					                        <h5 class="card-title">Card 4</h5>
					                        <div class="form-group">
					                            <label for="title4">Title</label>
					                            <input type="text" id="title4" name="json[values][3][title]" value="{{ $values[3]['title'] ?? ''}}" class="form-control" placeholder="Enter Title" maxlength="30" required>
					                            <small>Maximun character : 30</small>
					                        </div>
					                        <div class="form-group">
					                            <label for="description4">Description</label>
					                            <textarea id="description4" name="json[values][3][description]" maxlength="150" class="form-control" placeholder="Enter Description" required>{{ $values[3]['description'] ?? ''}}</textarea>
					                            <small>Maximun character : 150</small>
					                        </div>
					                        <div class="form-group">
		    									<label class="form-label">Image</label>
		    									<div 
		    										class="upload-image-section"
		    										data-type="image"
		    										data-multiple="false"
		    										data-path="home"
		    										data-resize-large="53*53"
		    										data-resize-medium="43*43"
		    										data-resize-small="33*33"
		    									>
		    										<div class="upload-section {{ isset($valuesImgfour->data) && $valuesImgfour->data  ? 'd-none' : "" }} ">
		    											<div class="button-ref mb-3">
		    												<button class="btn btn-primary" type="button">
		    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
		    									                <span class="btn-inner--text">Upload Image</span>
		    								              	</button>
		    								              	@include('admin.partials.recommendedSize', ['width' => '53', 'height' => "53"])
		    								            </div>
		    								            <!-- PROGRESS BAR -->
		    											<div class="progress d-none">
		    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		    							                </div>
		    							            </div>
		    						                <!-- INPUT WITH FILE URL -->
									                <textarea class="d-none" name="image[value_img4]"></textarea>
									                <div class="show-section {{ !old('image.value_img4') ? 'd-none' : "" }}">
									                	@include('admin.partials.previewFileRender', ['file' => old('image.value_img4') ])
									                </div>
									                <div class="fixed-edit-section media_sort" data-url="{{ route('admin.actions.mediaSort') }}">
									                	@include('admin.partials.previewFileRender', ['file' => $valuesImgfour->data ?? '', 'relationType' => 'pages_content.data', 'relationId' => $valuesImgfour->id ?? '' ])
									                </div>
		    									</div>
		    								</div>
					                    </div>
					                </div>
					            </div>
					        </div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3" id="testimonials">
    			<div class="card">
    				<h5 class="card-header">Testimonial's</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					@php
    					    $testimonials = PageContent::getData('home', 'testimonials', 'data');
    					@endphp
    					<form action="{{ route('admin.pageContent',['type' => 'home']) }}#testimonials" method="post" class="validation6">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Title</label>
    									<input type="text" class="form-control" name="data[testimonials][title]" value="{{ old('data[testimonials][title]' , $testimonials->title ?? '') }}" placeholder="Enter Title" maxlength="100" required />
    									<small>Maximun character : 100</small>
    									<label id="data[testimonials][title]-error" class="error" for="data[testimonials][title]">
	    									@error('data[testimonials][title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    						</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3" id="footer">
    			<div class="card">
    				<h5 class="card-header">Footer Information</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					@php
    					    $footer = PageContent::getData('home', 'footer', 'data');
    					@endphp
    					<form action="{{ route('admin.pageContent',['type' => 'home']) }}#footer" method="post" class="validation6">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Title</label>
    									<input type="text" class="form-control" name="data[footer][title]" value="{{ old('data[footer][title]' , $footer->title ?? '') }}" placeholder="Enter Title" maxlength="100" required />
    									<small>Maximun character : 100</small>
    									<label id="data[footer][title]-error" class="error" for="data[footer][title]">
	    									@error('data[footer][title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Description</label>
    									<textarea class="form-control" name="data[footer][description]" placeholder="Enter description" maxlength="200" required>{{ old('data[footer][description]', $footer->description ?? '') }}</textarea>
    									<small>Maximum character : 200</small>
    									<label id="data[footer][description]-error" class="error" for="data[footer][description]">
    									    @error('data[footer][description]') 
    									        {{ $message }} 
    									    @enderror
    									</label>
    								</div>
    							</div>
    						</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 py-3" id="meta">
    			<div class="card">
    				<h5 class="card-header">Meta Information</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					@php
    					    $meta = PageContent::getData('home', 'meta', 'data');
    					@endphp
    					<form action="{{ route('admin.pageContent',['type' => 'home']) }}#meta" method="post" class="validation6">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Title</label>
    									<input type="text" class="form-control" name="data[meta][title]" value="{{ old('data[meta][title]' , $meta->title ?? '') }}" placeholder="Enter Title" maxlength="100" required />
    									<small>Maximun character : 100</small>
    									<label id="data[meta][title]-error" class="error" for="data[meta][title]">
	    									@error('data[meta][title]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">KeyWords</label>
    									<input type="text" class="form-control" name="data[meta][keywords]" value="{{ old('data[meta][keywords]' , $meta->keywords ?? '') }}" placeholder="Enter keywords" maxlength="100" required />
    									<small>Maximun character : 100</small>
    									<label id="data[meta][keywords]-error" class="error" for="data[meta][keywords]">
	    									@error('data[meta][keywords]')
	    								        {{ $message }} 
	    								    @enderror
    								    </label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Description</label>
    									<textarea class="form-control" name="data[meta][description]" placeholder="Enter description" maxlength="200" required>{{ old('data[meta][description]', $meta->description ?? '') }}</textarea>
    									<small>Maximum character : 200</small>
    									<label id="data[meta][description]-error" class="error" for="data[meta][description]">
    									    @error('data[meta][description]') 
    									        {{ $message }} 
    									    @enderror
    									</label>
    								</div>
    							</div>
    						</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>



@endsection