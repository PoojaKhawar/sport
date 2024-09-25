@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Activity Logs</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.activities.logs') }}" class="btn btn-default">
						<i class="fas fa-angle-left"></i> Back
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
				<div class="card">
					<div class="card-header view_header">
			        	<div class="heading">
							<h5 class="mb-0">Activities Information</h5>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive text-nowrap">
							<table class="table">
								<tbody>
									<tr>
										<th>Id</th>
										<td>{{ $log->id }}</td>
									</tr>
									<tr>
										<th>Url</th>
										<td>{{ $log->url }}</td>
									</tr>
									<tr>
										<th>Method</th>
										<td>{{ $log->method }}</td>
									</tr>
									<tr>
										<th>IP</th>
										<td>{{ $log->ip }}</td>
									</tr>
									<tr>
										<td colspan="2">
											<h5>Data</h5>
											<code>
												@php 
													$data = $log->data ? General::decrypt($log->data) : ""; 
												@endphp
												{{ $data ? json_encode(json_decode($data, TRUE), JSON_PRETTY_PRINT) : 'null' }}
											</code>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-12 col-12">
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
										<th scope="row">
											Admin
										</th>
										<td>
											{{ isset($log->staff) && $log->staff ? $log->staff->first_name . ' ' . $log->staff->last_name : "-" }}
										</td>
									</tr>
									<tr>
										<th scope="row">
											Client
										</th>
										<td>
											{{ isset($log->user) && $log->user ? $log->user->first_name . ' ' . $log->user->last_name : "-" }}
										</td>
									</tr>
									<tr>
										<th scope="row">
											Created On
										</th>
										<td>
											{{ _dt($log->created_at) }}
										</td>
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