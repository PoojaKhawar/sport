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
				<div class="right_area text-right filter-dropdown">
					<a href="{{ route('admin.activities.emailLogsTruncate') }}" class="btn btn-default me-1">
						<i class="fas fa-trash-alt"></i> 
						Truncate
					</a>
					@include('admin.activities.emails.filters')
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
							<h5 class="mb-0">Here Is Your Email Logs!</h5>
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
											@if(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.id' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="email_logs.id" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.id' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="email_logs.id" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="email_logs.id" data-sort="asc"></i>
											@endif
										</th>
										<th class="sort">
											To
											@if(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.to' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="email_logs.to" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.to' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="email_logs.to" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="email_logs.to"></i>
											@endif
										</th>
										<th class="sort">
											Subject
											@if(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.subject' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="email_logs.subject" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.subject' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="email_logs.subject" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="email_logs.subject"></i>
											@endif
										</th>
										{{-- <th class="sort">
											CC
											@if(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.cc' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="email_logs.cc" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.cc' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="email_logs.cc" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="email_logs.cc"></i>
											@endif
										</th> --}}
										<th class="sort">
											Sent
											@if(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.sent' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="email_logs.sent" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.sent' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="email_logs.sent" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="email_logs.sent"></i>
											@endif
										</th>
										{{-- <th class="sort">
											Open
											@if(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.open' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="email_logs.open" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.open' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="email_logs.open" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="email_logs.open"></i>
											@endif
										</th> --}}
										<th class="sort">
											Created ON
											@if(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.created_at' && isset($_GET['direction']) && $_GET['direction'] == 'asc')
											<i class="fas fa-sort-down active" data-field="email_logs.created_at" data-sort="asc"></i>
											@elseif(isset($_GET['sort']) && $_GET['sort'] == 'email_logs.created_at' && isset($_GET['direction']) && $_GET['direction'] == 'desc')
											<i class="fas fa-sort-up active" data-field="email_logs.created_at" data-sort="desc"></i>
											@else
											<i class="fas fa-sort" data-field="email_logs.created_at"></i>
											@endif
										</th>
										<th>
											Actions
										</th>
									</tr>
				            	</thead>
				            	<tbody class="list">
				              		@if(!empty($listing->items()))
										@include('admin.activities.emails.listingLoop')
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