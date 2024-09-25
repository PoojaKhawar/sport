@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Blog Categories</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.blogs.categories') }}" class="btn btn-default">
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
    				<h5 class="card-header">Update Blog Category Details Here.</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					<form action="{{ route('admin.blogs.categories.edit', ['id' => $category->id]) }}" method="post" class="form-validation">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							@if(Setting::get('sub_category_enable'))
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Parent Category</label>
    									<select class="select2 form-select" name="parent_id">
    										<option value="" selected>No Parent</option>
									      	@foreach($categories as $c)
									      		<option value="{{ $c->id }}" {{ $category->parent_id && $category->parent_id == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
									  		@endforeach
									    </select>
    									<label id="parent_id-error" class="error" for="parent_id">@error('parent_id') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							@endif
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Title</label>
    									<input type="text" class="form-control" name="title" value="{{ old('title', $category->title) }}" placeholder="Enter title" required />
    									<label id="title-error" class="error" for="title">@error('title') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Description</label>
    									<textarea id="editor1" class="form-control" name="description" placeholder="Enter description">{{ old('description', $category->description) }}</textarea>
    									<label id="description-error" class="error" for="description">@error('description') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Meta title</label>
    									<input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" placeholder="Enter meta title" />
    									<label id="meta_title-error" class="error" for="meta_title">@error('meta_title') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Meta keywords</label>
    									<input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords', $category->meta_keywords) }}" placeholder="Enter meta keywords" />
    									<label id="meta_keywords-error" class="error" for="meta_keywords">@error('meta_keywords') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Meta description</label>
    									<textarea class="form-control" name="meta_description" placeholder="Enter meta description">{{ old('meta_description', $category->meta_description) }}</textarea>
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
    										data-path="blog_categories"
    										data-resize-large="1920*768"
    										data-resize-medium="1820*668"
    										data-resize-small="1720*568"
    									>
    										{{-- 
    											In case of single image use in upload-section class after  
												 {{ $category->image ? 'd-none' : '' }} 
    										--}}
    										<div class="upload-section {{ $category->image ? 'd-none' : '' }}">
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
							                <textarea class="d-none" name="image"></textarea>
							                <div class="show-section {{ !old('image') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image') ])
							                </div>
							                <div class="fixed-edit-section">
							                	@include('admin.partials.previewFileRender', ['file' => $category->image, 'relationType' => 'blog_categories.image', 'relationId' => $category->id ])
							                </div>
    									</div>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    								<div class="form-group">
    									<label class="form-label">Publish or Unpublish Page</label>
    									<div class="form-check form-switch mt-2">
    										<input type="hidden" name="status" value="0">
    			                    		<input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', $category->status) == 1 ? 'checked' : '' }}/>
    										<label class="form-check-label" for="status">Do you want to publish this page ?</label>
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