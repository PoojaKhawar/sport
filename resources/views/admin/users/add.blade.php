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
    		<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    			<div class="card">
    				<h5 class="card-header">Create New User Here.</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					<form action="{{ route('admin.users.add') }}" method="post" class="form-validation">
    						<!--!! CSRF FIELD !!-->
    						{{ csrf_field() }}
    						<div class="row">
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">First name</label>
    									<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Enter first name" required />
    									<label id="first_name-error" class="error" for="first_name">@error('first_name') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Last name</label>
    									<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name" required />
    									<label id="last_name-error" class="error" for="last_name">@error('last_name') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Email Address</label>
    									<input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email address" required />
    									<label id="email-error" class="error" for="email">@error('email') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
										<label class="form-label">Phone Number</label>
										<div class="input-group input-group-merge">
											<span class="input-group-text">IN (+91)</span>
											<input type="number" name="phonenumber" class="form-control" value="{{ old("phonenumber") }}" placeholder="Enter phonenumber" required />
										</div>
										<label id="phonenumber-error" class="error" for="phonenumber">@error('phonenumber') {{ $message }} @enderror</label>
									</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Date of birth</label>
    									<input type="date" class="form-control" name="dob" value="{{ old('dob') }}" placeholder="Enter dob" required/>
    									<label id="dob-error" class="error" for="dob">@error('dob') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Gender</label>
    									<select class="select2 form-select" name="gender" data-placeholder="Select Gender" data-minimum-results-for-search="-1" required>
									      	<option value=""></option>
									      	<option value="male" @if(old('gender') == 'male') {{ 'selected' }} @endif>Male</option>
									      	<option value="female" @if(old('gender') == 'female') {{ 'selected' }} @endif>Female</option>
									    </select>
    									<label id="gender-error" class="error" for="gender">@error('gender') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Address</label>
    									<textarea class="form-control" name="address" placeholder="Enter address" required>{{ old('address') }}</textarea>
    									<label id="address-error" class="error" for="address">@error('address') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
    								<div class="form-group">
    									<label class="form-label">Image</label>
    									<div 
    										class="upload-image-section"
    										data-type="image"
    										data-multiple="false"
    										data-path="users"
    										data-resize-large="300*300"
    										data-resize-medium="200*200"
    										data-resize-small="100*100"
    									>
    										<div class="upload-section">
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
							                <textarea class="d-none" name="image">{{ old('image') }}</textarea>
							                <div class="show-section {{ !old('image') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('image') ])
							                </div>
    									</div>
    								</div>
    							</div>
    							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
									<div class="form-group">
										<label class="form-label">Send credentials on email ?</label>
										<div class="form-check form-switch mt-2">
											<input type="hidden" name="send_password_email" value="0">
				                    		<input type="checkbox" name="send_password_email" class="form-check-input" id="sendPasswordEmail" value="1" {{ old('send_password_email') != '0' ? 'checked' : '' }}/>
											<label class="form-check-label" for="sendPasswordEmail">Send credentials on email ?</label>
				                      	</div>
				                      	<label id="send_password_email-error" class="error" for="send_password_email">@error('send_password_email') {{ $message }} @enderror</label>
				                    </div>

									<div class="form-group passwordGroup {{ old('send_password_email') != '0' ? 'd-none' : '' }}">
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