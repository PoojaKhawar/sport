@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Blogs</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.blogs') }}" class="btn btn-default">
						<i class="fas fa-angle-left"></i> Back
					</a>
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
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    			<div class="card">
    				<h5 class="card-header">Create New Blog Here.</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					<form action="{{ route('admin.blogs.add') }}" method="post" class="form-validation">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Category</label>
    									<select class="select2 form-select" name="category[]">
    										<option value="">Select</option>
									      	@foreach($categories as $c)
									      		@if($c->sub_categories()->count() > 0)
									      			<optgroup label="{{ $c->title }}">
									      				@foreach($c->sub_categories as $c)
									      					<option 
									      						value="{{ $c->id }}" 
									      						{{ old('category') && in_array($c->id, old('category'))  ? 'selected' : '' }}
									      					>{{ $c->title }}</option>
									      				@endforeach
									      			</optgroup>
									      		@else
									      			<option 
									      				value="{{ $c->id }}" 
									      				{{ old('category') && in_array($c->id, old('category'))  ? 'selected' : '' }}
									      			>{{ $c->title }}</option>
									      		@endif
									  		@endforeach
									    </select>
    									<label id="category[]-error" class="error" for="category[]">@error('category[]') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Title</label>
    									<input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Enter title" required />
    									<label id="title-error" class="error" for="title">@error('title') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Description</label>
    									<textarea id="editor1" class="form-control" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
    									<label id="description-error" class="error" for="description">@error('description') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Meta title</label>
    									<input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}" placeholder="Enter meta title" />
    									<label id="meta_title-error" class="error" for="meta_title">@error('meta_title') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Meta keywords</label>
    									<input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="Enter meta keywords" />
    									<label id="meta_keywords-error" class="error" for="meta_keywords">@error('meta_keywords') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Meta description</label>
    									<textarea class="form-control" name="meta_description" placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
    									<label id="meta_description-error" class="error" for="meta_description">@error('meta_description') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    								<div class="form-group">
    									<label class="form-label">Image</label>
    									<div 
    										class="upload-image-section"
    										data-type="image"
    										data-multiple="false"
    										data-path="blogs"
    										data-resize-large="500*500"
    										data-resize-medium="1820*668"
    										data-resize-small="1720*568"
    									>
    										<div class="upload-section">
    											<div class="button-ref mb-3">
    												<button class="btn btn-primary" type="button">
    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
    									                <span class="btn-inner--text">Upload Image</span>
    								              	</button>
    								            </div>
    								            <!-- PROGRESS BAR -->
    											<div class="progress d-none">
    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    							                </div>
    							            </div>
    						                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="image">{{ old('image') }}</textarea>
							                <div class="show-section {{ !old('image') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image') ])
							                </div>
    									</div>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    								<div class="form-group">
    									<label class="form-label">Publish or Unpublish Blog</label>
    									<div class="form-check form-switch mt-2">
    										<input type="hidden" name="status" value="0">
    			                    		<input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status') != '0' ? 'checked' : '' }}/>
    										<label class="form-check-label" for="status">Do you want to publish this blog ?</label>
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
    	</div>
    </div>
</div>

@endsection