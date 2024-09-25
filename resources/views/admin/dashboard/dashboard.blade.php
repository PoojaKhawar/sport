@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Dashboard</h6>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content_area">
    <div class="container-xxl flex-grow-1 container-p-y">
		<div class="row">
			<!-- ==== Disk Space ==== -->
			<div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
				<div class="card h-100">
					<div class="card-header d-flex align-items-center justify-content-between pb-0">
						<div class="card-title mb-0">
							<h5 class="mb-4 me-2">Disk Space</h5>
						</div>
					</div>
					<div class="card-body">
						<ul class="p-0 m-0">
							<li class="d-flex mb-2 pb-1">
								<div class="avatar flex-shrink-0 me-3">
									<span class="avatar-initial rounded bg-label-primary">
										<i class="fas fa-hdd"></i>
									</span>
								</div>
								<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
									<div class="me-2">
										<h6 class="mb-0">Total Space</h6>
									</div>
									<div class="user-progress">
										<small class="fw-semibold">0</small>
									</div>
								</div>
							</li>
							<li class="d-flex mb-2 pb-1">
								<div class="avatar flex-shrink-0 me-3">
									<span class="avatar-initial rounded bg-label-success">
										<i class="bx bx-hdd"></i>
									</span>
								</div>
								<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
									<div class="me-2">
										<h6 class="mb-0">Free Space</h6>
									</div>
									<div class="user-progress">
										<small class="fw-semibold">0</small>
									</div>
								</div>
							</li>
							<li class="d-flex">
								<div class="avatar flex-shrink-0 me-3">
									<span class="avatar-initial rounded bg-label-danger">
										<i class="bx bxs-hdd"></i>
									</span>
								</div>
								<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
									<div class="me-2">
										<h6 class="mb-0">Used Space</h6>
									</div>
									<div class="user-progress">
										<small class="fw-semibold">0</small>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection