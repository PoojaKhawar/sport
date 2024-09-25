@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Newsletter</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					{{-- <a href="{{ route('admin.newsletters.edit', ['id' => $newsletter->id]) }}" class="btn btn-default">
						<i class="far fa-edit"></i> Edit
					</a> --}}

					<a href="javascript:;" class="btn btn-default get_edit_modal" data-id="{{ $newsletter->id }}" data-url="{{ route('admin.newsletters.get', ['id' => $newsletter->id]) }}" data-bs-toggle="modal" data-bs-target=".edit_modal_form">
						<i class="far fa-edit"></i> Edit
					</a>

					<a href="{{ route('admin.newsletters') }}" class="btn btn-default ms-1">
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
				<!-- ==== Newsletter Information -->
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Newsletter Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Id</th>
										<td>{{ $newsletter->id }}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>{{ $newsletter->email }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-12 col-12">
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
											{{ _dt($newsletter->created_at) }}
										</td>
									</tr>
									<tr>
										<th>Updated On</th>
										<td>
											{{ _dt($newsletter->updated_at) }}
										</td>
									</tr>
									{{-- <tr>
										<th>Created By</th>
										<td>
											{{ isset($newsletter->owner) ? $newsletter->owner->first_name . ' ' . $newsletter->owner->last_name : "" }}
										</td>
									</tr> --}}
									<tr>
										<th>Status</th>
										<th>
											{!! $newsletter->status ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-danger">Unpublish</span>' !!}
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

@include('admin.newsletters.editNewsletter')

@endsection