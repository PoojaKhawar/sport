@extends('layouts.adminlayout')
@section('content')

@if($admin->is_admin != 1)
<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Permissions</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					{{-- <a href="javascript:;" class="btn btn-default">
						<i class="fas fa-angle-left"></i> Back
					</a> --}}
				</div>
			</div>
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="button_area">
					<a class="btn btn-default me-1" href="{{ route('admin.profile') }}"><i class="bx bx-user me-1"></i> Account</a>
					<a class="btn btn-default me-1" href="{{ route('admin.changePassword') }}"><i class="bx bx-cog me-1"></i> Change Password</a>
					@if(AdminAuth::isAdmin() != 1)
					{{-- <a class="btn btn-default me-1" href="{{ route('admin.permissions') }}"><i class="bx bx-link-alt me-1"></i> Permissions</a> --}}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content_area">
	<div class="container-xxl flex-grow-1 container-p-y">
		<div class="row">
			<div class="col-md-12">
				<div class="card mb-4">
					@include('admin.partials.flash_messages')
					<h5 class="card-header">Permission Details</h5>
					<div class="card-body">
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
			</div>
		</div>
	</div>
</div>
@endif
	
@endsection