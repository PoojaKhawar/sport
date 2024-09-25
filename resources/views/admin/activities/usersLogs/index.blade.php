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
				<div class="right_area text-right filter-dropdown">
					<a href="{{ route('admin.activities.userLogsTruncate') }}" class="btn btn-default me-1">
						<i class="fas fa-trash-alt"></i> 
						Truncate
					</a>
					@include('admin.activities.usersLogs.filters')
				</div>
			</div>
			@if(isset($user) && $user)
				@include("admin.users.viewHead")
			@endif
		</div>
	</div>
</div>

<div class="content_area">
	<div class="container-xxl flex-grow-1 container-p-y">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<!--!!!!! DO NOT REMOVE listing-block CLASS. INCLUDE THIS IN PARENT DIV OF TABLE ON LISTING PAGES !!!!!-->
				<div class="card listing-block">
			        <div class="card-header">
			        	<div class="heading">
							<h5 class="mb-0">Here Is Your Users Logs!</h5>
						</div>
						<div class="actions">
							<div class="input-group input-group-merge">
		                    	<span class="input-group-text"><i class="bx bx-search"></i></span>
		                    	<input type="text" class="form-control listing-search" placeholder="Search..." value="{{ (isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : '') }}">
		                    </div>
						</div>
					</div>
			        <!--!!!!! DO NOT REMOVE listing-table, mark_all  CLASSES. INCLUDE THIS IN ALL TABLES LISTING PAGES !!!!!-->
			        <div class="card-body p-0">
				        <div class="table-responsive text-nowrap">
				          	<table class="table listing-table">
				            	<thead class="thead-light">
					              	<tr>
					              		<th width="5%">
			              					<div class="form-check">
			              			        	<input type="checkbox" class="form-check-input mark_all" id="mark_all">
			              			        	<label class="form-check-label" for="mark_all"></label>
			              			      	</div>
					              		</th>
						                <th class="sort">
											<!--- MAKE SURE TO USE PROPOER FIELD IN data-field AND PROPOER DIRECTION IN data-sort -->
											ID
											@if(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.id' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="user_logs.id" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.id' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="user_logs.id" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="user_logs.id" data-sort="asc"></i>
											@endif
										</th>
										<th class="sort">
											IP Address
											@if(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.ip' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="user_logs.ip" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.ip' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="user_logs.ip" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="user_logs.ip"></i>
											@endif
										</th>
										<th class="sort">
											User's Name
											@if(isset($_GET['sort']) && $_GET['sort'] == 'users.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="users.first_name" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="users.first_name" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="users.first_name"></i>
											@endif
										</th>
										<th class="sort">
											Address
											@if(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.location' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="user_logs.location" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.location' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="user_logs.location" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="user_logs.location"></i>
											@endif
										</th>
										<th class="sort">
											Type
											@if(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.type' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="user_logs.type" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.type' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="user_logs.type" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="user_logs.type"></i>
											@endif
										</th>
										{{--  --}}
										{{-- <th class="sort">
											Sent
											@if(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.sent' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="user_logs.sent" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.sent' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="user_logs.sent" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="user_logs.sent"></i>
											@endif
										</th> --}}
										<th class="sort">
											Timing
											@if(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.updated_at' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="user_logs.updated_at" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.updated_at' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="user_logs.updated_at" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="user_logs.updated_at"></i>
											@endif
										</th>
										{{-- <th class="sort">
											Created ON
											@if(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.created_at' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="user_logs.created_at" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'user_logs.created_at' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="user_logs.created_at" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="user_logs.created_at"></i>
											@endif
										</th> --}}
										<th>
											Actions
										</th>
									</tr>
				            	</thead>
				            	<tbody class="list">
				              		@if(!empty($listing->items()))
										@include('admin.activities.usersLogs.listingLoop')
									@else
									<td align="left" colspan="7">
			                        	No records found!
			                        </td>
									@endif
				            	</tbody>

								<tfoot>
			                        <tr>
			                            <th align="left" colspan="20">
			                            	@include('admin.partials.pagination', ["pagination" => $listing])
			                            </th>
			                        </tr>
			                    </tfoot>
			                    
							</table>
						</div>
					</div>
		    	</div>
			</div>
		</div>
	</div>
</div>

@endsection