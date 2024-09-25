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
				<div class="right_area text-right filter-dropdown">
					<a href="{{ route('admin.activities.activitiesTruncate') }}" class="btn btn-default me-1">
						<i class="fas fa-trash-alt"></i> 
						Truncate
					</a>
					@include('admin.activities.logs.filters')
				</div>
			</div>
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
							<h5 class="mb-0">HERE IS YOUR ACTIVITY LOGS!</h5>
						</div>
						<div class="actions">
							<div class="input-group input-group-merge">
		                    	<span class="input-group-text"><i class="bx bx-search"></i></span>
		                    	<input type="text" class="form-control listing-search" placeholder="Search..." value="{{ (isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : '') }}">
		                    </div>
		                    <div class="action_dropdown btn-group">
		                    	<a href="javascript:;" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                    		<i class="fas fa-ellipsis-v"></i>
		                    	</a>
		                    	<ul class="dropdown-menu dropdown-menu-end">
		                    		{{-- <li>
		                    			<a class="dropdown-item" href="javascript:;" 
		                            	onclick="bulk_actions('{{ route('admin.activities.bulkActions', ['action' => 'delete']) }}', 'delete');">
		                    				<i class="fas fa-circle text-success"></i>
		                    				<span class="status">Publish</span>
		                    			</a>
		                    		</li> --}}
		                    		{{-- <li>
		                    			<a class="dropdown-item" href="javascript:;" 
		                            	onclick="bulk_actions('{{ route('admin.activities.bulkActions', ['action' => 'delete']) }}', 'delete');">
		                    				<i class="fas fa-circle text-danger"></i>
		                    				<span class="status">Unpublish</span>
		                    			</a>
		                    		</li>
		                    		<div class="dropdown-divider"></div> --}}
		                    		<li>
		                    			<a class="dropdown-item" href="javascript:;" 
		                            	onclick="bulk_actions('{{ route('admin.activities.bulkActions', ['action' => 'delete']) }}', 'delete');">
		                    				<i class="fas fa-times text-danger"></i>
		                    				<span class="status">Delete</span>
		                    			</a>
		                    		</li>
		                    	</ul>
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
						                <th width="10%" class="sort">
											<!--- MAKE SURE TO USE PROPOER FIELD IN data-field AND PROPOER DIRECTION IN data-sort -->
											Id
											@if(isset($_GET['sort']) && $_GET['sort'] == 'activities.id' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="activities.id" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'activities.id' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="activities.id" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="activities.id" data-sort="asc"></i>
											@endif
										</th>
										<th width="20%" class="sort">
											URL
											@if(isset($_GET['sort']) && $_GET['sort'] == 'activities.url' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="activities.url" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'activities.url' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="activities.url" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="activities.url"></i>
											@endif
										</th>
										<th width="10%" class="sort">
											Client
											@if(isset($_GET['sort']) && $_GET['sort'] == 'users.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="users.first_name" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="users.first_name" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="users.first_name"></i>
											@endif
										</th>
										<th width="10%" class="sort">
											Admin
											@if(isset($_GET['sort']) && $_GET['sort'] == 'admin.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="admin.first_name" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'admin.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="admin.first_name" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="admin.first_name"></i>
											@endif
										</th>
										<th width="10%" class="sort">
											Method
											@if(isset($_GET['sort']) && $_GET['sort'] == 'activities.method' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="activities.method" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'activities.method' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="activities.method" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="activities.method"></i>
											@endif
										</th>
										<th width="10%" class="sort">
											IP
											@if(isset($_GET['sort']) && $_GET['sort'] == 'activities.ip' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="activities.ip" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'activities.ip' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="activities.ip" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="activities.ip"></i>
											@endif
										</th>
										<th width="15%" class="sort">
											Created ON
											@if(isset($_GET['sort']) && $_GET['sort'] == 'activities.created_at' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="activities.created_at" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'activities.created_at' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="activities.created_at" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="activities.created_at"></i>
											@endif
										</th>
										<th width="10%">
											Actions
										</th>
					              	</tr>
				            	</thead>
				            	<tbody class="list">
				              		@if(!empty($listing->items()))
										@include('admin.activities.logs.listingLoop')
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