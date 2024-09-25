@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Admins</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.admins.edit', ['id' => $admin->id]) }}" class="btn btn-default">
						<i class="far fa-edit"></i> Edit
					</a>
					<a href="{{ route('admin.admins') }}" class="btn btn-default ms-1">
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
				<!-- ==== Admin Information -->
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Admin Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Id</th>
										<td>{{ $admin->id }}</td>
									</tr>
									<tr>
										<th>Name</th>
										<td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>{{ $admin->email }}</td>
									</tr>
									<tr>
										<th>Account Type</th>
										<td>
											@if($admin->is_admin == 1)
											<span class="badge bg-primary">Super Admin</span>
											@else
											<span class="badge bg-secondary">Sub Admin</span>
											@endif
										</td>
									</tr>
									<tr>
										<th>Phone Number</th>
										<td>{{ $admin->phonenumber }}</td>
									</tr>
									<tr>
										<th>Full Address</th>
										<td>{{ nl2br($admin->address) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				@if($admin->is_admin != 1)
				<!-- ==== Admin Permission -->
				<div class="card mt-4">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Permissions</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap" id="permissionTable">
							<table class="table">
								<thead class="thead-light">
									<tr>
										<th>Modules</th>
										<th>Listing</th>
										<th>Create</th>
										<th>Update</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
									@foreach($permissions as $p)
									@php 
										$permission = json_decode($p['permissions'],true);
									@endphp
									<tr>
										<td>{{ $p['title'] }}</td>
										<td>
											@if($permission['listing'])
											<div class="form-check form-switch mt-2">
					                    		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="listing" {{ (isset($adminPermissions[$p['id']]) && in_array('listing', $adminPermissions[$p['id']]) ? 'checked' : '') }} disabled/>
					                      	</div>
											@endif
										</td>
										<td>
											@if($permission['create'])
											<div class="form-check form-switch mt-2">
					                    		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="create" {{ (isset($adminPermissions[$p['id']]) && in_array('create', $adminPermissions[$p['id']]) ? 'checked' : '') }} disabled/>
					                      	</div>
											@endif
										</td>
										<td>
											@if($permission['update'])
											<div class="form-check form-switch mt-2">
					                    		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="update" {{ (isset($adminPermissions[$p['id']]) && in_array('update', $adminPermissions[$p['id']]) ? 'checked' : '') }} disabled/>
					                      	</div>
											@endif
										</td>
										<td>
											@if($permission['delete'])
											<div class="form-check form-switch mt-2">
					                    		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="delete" {{ (isset($adminPermissions[$p['id']]) && in_array('delete', $adminPermissions[$p['id']]) ? 'checked' : '') }} disabled/>
					                      	</div>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endif
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-12 col-12">
				@if($admin->image)
				<!-- ==== Attachment -->
				<div class="card mb-4">
					<div class="card-body">
						<img src="{{ url($admin->image) }}" class="mw-100">
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
											{{ _dt($admin->created_at) }}
										</td>
									</tr>
									<tr>
										<th>Updated On</th>
										<td>
											{{ _dt($admin->updated_at) }}
										</td>
									</tr>
									<tr>
										<th>Last Login</th>
										<td>
											{{ $admin->last_login ? _dt($admin->last_login) : '' }}
										</td>
									</tr>
									<tr>
										<th>Status</th>
										<th>
											{!! $admin->status ? '<span class="badge bg-success">Publish</span>' : '<span class="badge bg-danger">Unpublish</span>' !!}
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