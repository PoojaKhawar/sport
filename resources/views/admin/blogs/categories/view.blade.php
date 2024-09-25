@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Blog Category</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.blogs.categories.edit', ['id' => $category->id]) }}" class="btn btn-default">
						<i class="far fa-edit"></i> Edit
					</a>
					<a href="{{ route('admin.blogs.categories') }}" class="btn btn-default ms-1">
						<i class="far fa-angle-left"></i> Back
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content_area">
	<div class="container-xxl flex-grow-1 container-p-y">
		<div class="row">
			<div class="col-xxl-8 col-xl-8 col-lg-7 col-md-6 col-sm-12 col-12">
				<!-- ==== Blog category Information -->
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Blog Category Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Id</th>
										<td>{{ $category->id }}</td>
									</tr>
									<tr>
										<th>Category</th>
										<td>{{ isset($category->parent->title) && $category->parent->title ? $category->parent->title : $category->title }}</td>
									</tr>

									<!-- In case of subcategory enable -->
									@if(Setting::get('sub_category_enable'))
									</tr>
										<th>Sub Category</th>
										<td>{{ $category->title }}</td>
									</tr>
									@endif
									<!-- In case of subcategory enable -->

									@if(isset($category->description) && $category->description)
									<tr>
										<td colspan="2">
											<h5>Description</h5>
											{!! $category->description !!}
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- ==== SEO Information -->
				<div class="card mt-4">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">SEO Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Meta Title</th>
										<td>{{ $category->meta_title }}</td>
									</tr>
									<tr>
										<th>Meta Keywords</th>
										<td>{{ $category->meta_keywords }}</td>
									</tr>
									<tr>
										<th>Meta Description</th>
										<td>{{ $category->meta_description }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-12 col-12">
				@if($category->image)
				<!-- ==== Attachment -->
				<div class="card mb-4">
					<div class="card-body">
						<img src="{{ url($category->image) }}" class="mw-100">
					</div>
				</div>
				@endif
				<!-- ==== Other Information -->
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Other Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Created On</th>
										<td>
											{{ _dt($category->created_at) }}
										</td>
									</tr>
									<tr>
										<th>Updated On</th>
										<td>
											{{ _dt($category->updated_at) }}
										</td>
									</tr>
									<tr>
										<th>Created By</th>
										<td>
											{{ isset($category->owner) ? $category->owner->first_name . ' ' . $category->owner->last_name : "" }}
										</td>
									</tr>
									<tr>
										<th>Status</th>
										<th>
											{!! $category->status ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-danger">Unpublish</span>' !!}
										</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection