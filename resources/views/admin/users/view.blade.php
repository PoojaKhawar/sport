@php
	use Carbon\Carbon;
@endphp
@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Users</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" class="btn btn-default">
						<i class="far fa-edit"></i> Edit
					</a>
					<a href="{{ route('admin.users') }}" class="btn btn-default ms-1">
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
				<!-- ==== Page Information -->
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">User Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Id</th>
										<td>{{ $user->id }}</td>
									</tr>
									<tr>
										<th>Name</th>
										<td>{{ $user->first_name . ' ' . $user->last_name }}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>
											<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
										</td>
									</tr>
									<tr>
										<th>Phone Number</th>
										<td>{{ '+91-'.$user->phonenumber }}</td>
									</tr>
									
									@if(isset($user->dob) && $user->dob)
									<tr>
										<th>Date of Birth</th>
										<td>{{ $user->dob ? Carbon::parse($user->dob)->format('jS F, Y') : "" }}</td>
									</tr>
									@endif
									
									@if(isset($user->gender) && $user->gender)
									<tr>
										<th>Gender</th>
										<td>{!! isset($user->gender) && $user->gender ? '<span class="badge bg-warning">'.ucfirst($user->gender).'</span>' : '' !!}</td>
									</tr>
									@endif

									@if(isset($user->address) && $user->address)
									<tr>
										<th>Full Address</th>
										<td>{{ nl2br($user->address) }}</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-12 col-12">
				@if($user->image)
				<!-- ==== Attachment -->
				<div class="card mb-4">
					<div class="card-body">
						<img src="{{ General::renderImageUrl($user->image, 'large') }}" class="mw-100">
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
											{{ _dt($user->created_at) }}
										</td>
									</tr>
									<tr>
										<th>Updated On</th>
										<td>
											{{ _dt($user->updated_at) }}
										</td>
									</tr>
									<tr>
										<th>Last Login</th>
										<td>
											{{ $user->last_login ? _dt($user->last_login) : '' }}
										</td>
									</tr>
									<tr>
										<th>Status</th>
										<th>
											{!! $user->status ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-danger">Unpublish</span>' !!}
										</th>
									</tr>
									@if(isset($exp) && !empty($exp))
									<tr>
										<th>Experience</th>
										<th>
											{{ $exp }}
										</th>
									</tr>
									@endif
									
									@if(isset($user->dol) && $user->dol)
									<tr>
										<th>Date Of Leaving</th>
										<td>
											{!! $user->dol ? '<span class="badge bg-danger">'.Carbon::parse($user->dol)->format('jS F, Y').'</span>' : "" !!}
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			@if($user->document)
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<!-- ==== User Documents -->
				<div class="card mt-3">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Documents</h5>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
						@foreach($user->document as $key => $val)
							@php
								$extension = pathinfo($val, PATHINFO_EXTENSION);
								$extension = strtolower($extension);
							@endphp
							
							@if(in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'svg']))
								<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
									<div class="file_list">
										<a href="{{ url($val) }}" target="_blank">
											<img src="{{ General::renderImageUrl($val, 'large') }}" alt="..." />
											<span class="view_file"><i class="fas fa-eye"></i></span>
										</a>
									</div>
								</div>
							@endif
							
							@if(in_array($extension, ['pdf']))
								<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
									<div class="file_list">
										<a href="{{ url($val) }}" target="_blank">
											<img src="{{ url('admin/dev/images/pdf.png') }}" alt="..." />
											<span class="view_file"><i class="fas fa-eye"></i></span>
										</a>
									</div>
								</div>
							@endif

							@if(in_array($extension, ['docx', 'doc']))
								<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
									<div class="file_list">
										<a href="{{ url($val) }}" target="_blank">
											<img src="{{ url('admin/dev/images/docx.png') }}" alt="..." />
											<span class="view_file"><i class="fas fa-eye"></i></span>
										</a>
									</div>
								</div>
							@endif
						@endforeach
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection