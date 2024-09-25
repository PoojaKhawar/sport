@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Contact Us</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					{{-- <a href="{{ route('admin.contactUs.edit', ['id' => $contactUs->id]) }}" class="btn btn-default">
						<i class="far fa-edit"></i> Edit
					</a> --}}
					<a href="{{ route('admin.contactUs') }}" class="btn btn-default ms-1">
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
				<!-- ==== Contact Us Information -->
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Contact Us Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Id</th>
										<td>{{ $contactUs->id }}</td>
									</tr>
									<tr>
										<th>Name</th>
										<td>{{ $contactUs->first_name.' '.$contactUs->last_name }}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>{{ $contactUs->email }}</td>
									</tr>
									<tr>
										<th>Company Name</th>
										<td>{{ $contactUs->company_name }}</td>
									</tr>
									<tr>
										<th>Country</th>
										<td>{{ $contactUs->country }}</td>
									</tr>
									<tr>
										<th>Phonenumber</th>
										<td>{{ $contactUs->phonenumber }}</td>
									</tr>
									<tr>
										<th>Subject</th>
										<td>{{ $contactUs->subject }}</td>
									</tr>
									<tr>
										<td colspan="2">
											<h5>Message</h5>
											{!! $contactUs->message !!}
										</td>
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
											{{ _dt($contactUs->created_at) }}
										</td>
									</tr>
									{{-- <tr>
										<th>Updated On</th>
										<td>
											{{ _dt($contactUs->updated_at) }}
										</td>
									</tr> --}}
									{{-- <tr>
										<th>Created By</th>
										<td>
											{{ isset($contactUs->owner) ? $contactUs->owner->first_name . ' ' . $contactUs->owner->last_name : "" }}
										</td>
									</tr> --}}
									{{-- <tr>
										<th>Status</th>
										<th>
											{!! $contactUs->status ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-danger">Unpublish</span>' !!}
										</th>
									</tr> --}}
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