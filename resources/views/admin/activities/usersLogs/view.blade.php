@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Users Logs</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.activities.users') }}" class="btn btn-default">
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
							<h5 class="mb-0">Users Information</h5>
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
									{{-- <?php pr($log->toArray()); die; ?> --}}
									<tr>
										<th>User</th>
										<td>{{ isset($log->users_first_name) && $log->users_first_name ? ($log->users_first_name) . ' ' . $log->users_last_name :'' }}</td>
									</tr>
									<tr>
										<th>IP</th>
										<td>{!! isset($log->ip) && $log->ip ? '<span class="badge bg-info">'.($log->ip).'</span>' :'' !!}</td>
									</tr>
									<tr>
										<th>Timing</th>
										<td>{{ isset($log->updated_at) && $log->updated_at ? (new DateTime($log->updated_at))->format('j F, Y h:iA' ) : '' }}</td>
									</tr>
									<tr>
										<th>Type</th>
										<td>
											{!! isset($log->type) && $log->type ? '<span class="badge bg-primary">'.ucfirst($log->type).'</span>' : '' !!}
										</td>
									</tr>
									@if(isset($log->location) && count($log->location) > 0)
									<tr>
										<th>City</th>
										<td>
											@foreach($log->location as $key => $val )
												@if($key == 'city')
													{{ ($key == 'city' ? $val['name'] : '')}}
												@endif
											@endforeach
										</td>
									</tr>
									@endif
									@if(isset($log->location) && count($log->location) > 0)
									<tr>
										<th>State</th>
										<td>
											@foreach($log->location as $key => $val )
												@if($key == 'state')
													{{ ($key == 'state' ? $val['name'] : '')}}
												@endif
											@endforeach
										</td>
									</tr>
									@endif
									@if(isset($log->location) && count($log->location) > 0)
									<tr>
										<th>Country</th>
										<td>
											@foreach($log->location as $key => $val )
												@if($key == 'country')
													{{ ($key == 'country' ? $val['name'] : '')}}
												@endif
											@endforeach
										</td>
									</tr>
									@endif
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
											Updated on
										</th>
										<td>
											{{ _dt($log->updated_at) }}
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