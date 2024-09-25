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
					<a href="{{ route('admin.blogs.edit', ['id' => $blog->id]) }}" class="btn btn-default">
						<i class="far fa-edit"></i> Edit
					</a>
					<a href="{{ route('admin.blogs') }}" class="btn btn-default ms-1">
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
				<!-- ==== Blog Information -->
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Blog Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Id</th>
										<td>{{ $blog->id }}</td>
									</tr>
									<tr>
										<th>Category</th>
										<td>
											@foreach($blog->categories as $c => $v)
											<span class="badge bg-primary">{{ $v->title }}</span>
											@endforeach
										</td>
									</tr>
									<tr>
										<th>Title</th>
										<td>{{ $blog->title }}</td>
									</tr>
									<tr>
										<td colspan="2">
											<h5>Description</h5>
											{!! $blog->description !!}
										</td>
									</tr>
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
										<td>{{ $blog->meta_title }}</td>
									</tr>
									<tr>
										<th>Meta Keywords</th>
										<td>{{ $blog->meta_keywords }}</td>
									</tr>
									<tr>
										<th>Meta Description</th>
										<td>{{ $blog->meta_description }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-12 col-12">
				@if($blog->image)
				<!-- ==== Attachment -->
				<div class="card mb-4">
					<div class="card-body">
						<img src="{{ url($blog->image) }}" class="mw-100">
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
											{{ _dt($blog->created_at) }}
										</td>
									</tr>
									<tr>
										<th>Updated On</th>
										<td>
											{{ _dt($blog->updated_at) }}
										</td>
									</tr>
									<tr>
										<th>Created By</th>
										<td>
											{{ isset($blog->owner) ? $blog->owner->first_name . ' ' . $blog->owner->last_name : "" }}
										</td>
									</tr>
									<tr>
										<th>Status</th>
										<th>
											{!! $blog->status ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-danger">Unpublish</span>' !!}
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