@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Contact Us</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					<a href="{{ route('admin.contactUs') }}" class="btn btn-default">
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
    				<h5 class="card-header">Create New Contact Us Here.</h5>
    				<hr class="my-0" />
    				<div class="card-body">
    					<form action="{{ route('admin.contactUs.add') }}" method="post" class="form-validation">
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
    									<input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email address" required/>
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
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Subject</label>
    									<input type="text" class="form-control" name="subject" value="{{ old('subject') }}" placeholder="Enter subject" required />
    									<label id="subject-error" class="error" for="subject">@error('subject') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Message</label>
    									<textarea class="form-control" name="message" placeholder="Enter message" required>{{ old('message') }}</textarea>
    									<label id="message-error" class="error" for="message">@error('message') {{ $message }} @enderror</label>
    								</div>
    							</div>
    							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    								<div class="form-group">
    									<label class="form-label">Publish or Unpublish Contact Us</label>
    									<div class="form-check form-switch mt-2">
    										<input type="hidden" name="status" value="0">
    			                    		<input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status') != '0' ? 'checked' : '' }}/>
    										<label class="form-check-label" for="status">Do you want to publish this contact us ?</label>
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