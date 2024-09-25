<a href="javascript:;" class="btn btn-default web-filter" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	@if(isset($_GET) && !empty($_GET))
	<span class="filter-dot text-info"><i class="fas fa-circle"></i></span>
	@endif
	<i class="fas fa-filter"></i> Filters
</a>
<div class="dropdown-menu dropdown-menu-end">
	<form action="{{ route('admin.admins') }}" id="filters-form">
		<a href="javascript:;" class="float-end px-2 closeit">
			<i class="fa fa-times-circle"></i>
		</a>
		<div class="dropdown-item">
			<div class="row">
				<div class="col-md-6">
					<label class="form-label">Last Login</label>
					<input class="form-control" type="date" name="last_login[0]" value="{{ (isset($_GET['last_login'][0]) && !empty($_GET['last_login'][0]) ? $_GET['last_login'][0] : '' ) }}" placeholder="DD-MM-YYYY" >
				</div>
				<div class="col-md-6">
					<label class="form-label">&nbsp;</label>
					<input class="form-control" type="date" name="last_login[1]" value="{{ (isset($_GET['last_login'][1]) && !empty($_GET['last_login'][1]) ? $_GET['last_login'][1] : '' ) }}" placeholder="DD-MM-YYYY">
				</div>
			</div>
		</div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item">
			<div class="form-group mt-2 mb-0">
				<label class="form-label d-none">Status</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="admins" id="allAdmins" value="" {{ (!isset($_GET['admins']) || $_GET['admins'] === '' || $_GET['admins'] === null ? 'checked' : '') }}/>
					<label class="form-check-label" for="allAdmins">All</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" class="form-check-input" name="admins" id="onlyAdmins" value="admin" {{ (isset($_GET['admins']) && $_GET['admins'] == 'admin' ? 'checked' : '') }}/>
					<label class="form-check-label" for="onlyAdmins">Sub Admins</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" class="form-check-input" name="admins" id="super_admin" value="super_admin" {{ (isset($_GET['admins']) && $_GET['admins'] == 'super_admin' ? 'checked' : '') }}/>
					<label class="form-check-label" for="super_admin">Super Admins</label>
				</div>
			</div>
		</div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-item">
			<div class="form-group mt-2 mb-0">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="status" id="all" value="" {{ (!isset($_GET['status']) || $_GET['status'] === '' || $_GET['status'] === null ? 'checked' : '') }}/>
					<label class="form-check-label" for="all">All</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" class="form-check-input" name="status" id="active" value="active" {{ (isset($_GET['status']) && $_GET['status'] == 'active' ? 'checked' : '') }}/>
					<label class="form-check-label" for="active">Active</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" class="form-check-input" name="status" id="non_active" value="non_active" {{ (isset($_GET['status']) && $_GET['status'] == 'non_active' ? 'checked' : '') }}/>
					<label class="form-check-label" for="non_active">Non-Active</label>
				</div>
			</div>
		</div>
		<div class="dropdown-divider"></div>
		<div class="dropdown-bottom clearfix">
			<a href="{{ route('admin.admins') }}" class="btn btn-sm btn-danger px-3 float-start">Reset All</a>
			<button type="submit" class="btn btn-sm px-3 btn-primary float-end">Submit</button>
		</div>
	</form>
</div>