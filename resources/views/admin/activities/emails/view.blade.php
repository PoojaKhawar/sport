@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Email Logs</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.activities.emails') }}" class="btn btn-default">
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
							<h5 class="mb-0">Email Information</h5>
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
										<th>From</th>
										<td>{{ $log->from }}</td>
									</tr>
									<tr>
										<th>To</th>
										<td>{{ $log->to }}</td>
									</tr>
									<tr>
										<th>Subject</th>
										<td>{{ $log->subject }}</td>
									</tr>
									<tr>
										<td colspan="2">
											<h5>Message</h5>
											{!! $log->description !!}
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
										<th>
											Created On
										</th>
										<td>
											{{ _dt($log->created_at) }}
										</td>
									</tr>
									<tr>
										<th>
											Status
										</th>
										<th class="text-center">
											{!! $log->sent ? '<span class="badge bg-success">Sent</span>' : '<span class="badge bg-danger">Not Sent</span>' !!}
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