@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Users</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.users') }}" class="btn btn-default">
						<i class="fas fa-angle-left"></i> Back
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content_area">
    <div class="container-xxl flex-grow-1 container-p-y">
    	<!--!! FLAST MESSAGES !!-->
    	@include('admin.partials.flash_messages')
    	<div class="row">
    		<div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
    			<div class="card">
    				<h5 class="card-header">Update User Details Here.</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					<form action="{{ route('admin.users.edit', ['id' => $user->id]) }}" method="post" class="form-validation">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">First name</label>
    									<input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Enter first name" required />
    									<label id="first_name-error" class="error" for="first_name">@error('first_name') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Last name</label>
    									<input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Enter last name" required />
    									<label id="last_name-error" class="error" for="last_name">@error('last_name') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Email Address</label>
    									<input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email address" />
    									<label id="email-error" class="error" for="email">@error('email') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
										<label class="form-label">Phone Number</label>
										<div class="input-group input-group-merge">
											<span class="input-group-text">IN (+91)</span>
											<input type="number" name="phonenumber" class="form-control" value="{{ old("phonenumber", $user->phonenumber) }}" placeholder="Enter phonenumber" required />
										</div>
										<label id="phonenumber-error" class="error" for="phonenumber">@error('phonenumber') {{ $message }} @enderror</label>
									</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Date of birth</label>
    									<input type="date" class="form-control" name="dob" value="{{ old('dob', $user->dob) }}" placeholder="Enter dob" />
    									<label id="dob-error" class="error" for="dob">@error('dob') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Gender</label>
    									<select class="select2 form-select" name="gender" data-placeholder="Select Gender" data-minimum-results-for-search="-1">
									      	<option value=""></option>
									      	<option value="male" @if(old('gender', $user->gender) == 'male') {{ 'selected' }} @endif>Male</option>
									      	<option value="female" @if(old('gender', $user->gender) == 'female') {{ 'selected' }} @endif>Female</option>
									    </select>
    									<label id="gender-error" class="error" for="gender">@error('gender') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Address</label>
    									<textarea class="form-control" name="address" placeholder="Enter address">{{ old('address', $user->address) }}</textarea>
    									<label id="address-error" class="error" for="address">@error('address') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Image</label>
    									<div 
    										class="upload-image-section"
    										data-type="image"
    										data-multiple="false"
    										data-path="users"
    										data-resize-large="1920*768"
    										data-resize-medium="1820*668"
    										data-resize-small="1720*568"
    									>
    										{{-- 
    											In case of single image use in upload-section class after  
												 {{ $user->image ? 'd-none' : '' }} 
    										--}}
    										<div class="upload-section {{ $user->image ? 'd-none' : '' }}">
    											<div class="button-ref mb-3">
    												<button class="btn btn-primary" type="button">
    									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
    									                <span class="btn-inner--text">Upload Image</span>
    								              	</button>
    								            </div>
    								            <!-- PROGRESS BAR -->
    											<div class="progress d-none">
    							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    							                </div>
    							            </div>
    						                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="image"></textarea>
							                <div class="show-section {{ !old('image') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image') ])
							                </div>
							                <div class="fixed-edit-section">
							                	@include('admin.partials.previewFileRender', ['file' => $user->image, 'relationType' => 'users.image', 'relationId' => $user->id ])
							                </div>
    									</div>
    								</div>
    							</div>
    						</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    		<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12">
    			<div class="card">
    				<h5 class="card-header">Reset Password.</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					<form action="{{ route('admin.users.resetPassword', ['id' => $user->id]) }}" method="post" class="reset-password-validation">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="form-group">
								<label class="form-label">Send credentials on email ?</label>
								<div class="form-check form-switch mt-2">
									<input type="hidden" name="send_password_email" value="0">
		                    		<input type="checkbox" name="send_password_email" class="form-check-input" id="sendPasswordEmail" value="1" />
									<label class="form-check-label" for="sendPasswordEmail">Send credentials on email ?</label>
		                      	</div>
		                      	<label id="send_password_email-error" class="error" for="send_password_email">@error('send_password_email') {{ $message }} @enderror</label>
		                    </div>

							<div class="form-group passwordGroup">
								<div class="form-group">
									<div class="form-password-toggle">
									    <div class="input-group">
									        <input type="password" class="form-control" name="password" placeholder="******" aria-describedby="password" value="" />
									        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
									        <span class="input-group-text cursor-pointer regeneratePassword"><span class="fas fa-redo-alt"></span></span>
									    </div>
									    <label id="password-error" class="error" for="password">@error('password') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="form-group">
									<small class="text-danger d-block">Password must be minimum 8 characters long.</small>
									<small class="text-danger d-block">Password should contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&amp;*).</small>
								</div>
							</div>
    						<div class="form-group mt-2 clearfix">
    							<button type="submit" class="btn btn-primary float-end">Submit</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

@endsection