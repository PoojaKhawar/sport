@php 
	$method = Setting::get('email_method');
	$secondAuth = Setting::get('admin_second_auth_factor');
	$encryption =  Setting::get('smtp_encryption');
	$favicon = Setting::get('favicon');
	$logo = Setting::get('logo');
@endphp

@extends('layouts.adminlayout')
@section('content')

<div class="header-body">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="left_area">
					<h6>Manage Settings</h6>
				</div>
			</div>
			<div class="col-lg-6 col-5">
				<div class="right_area text-right">
					{{-- <a href="javascript:;" class="btn btn-default">
						<i class="fas fa-angle-left"></i> Back
					</a> --}}
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content_area">
    <div class="container-xxl flex-grow-1 container-p-y">
    	@include('admin.partials.flash_messages')
		<div class="row">
			<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header">General Settings</h5>
					<hr class="my-0" />
					<div class="card-body">
						<form action="{{ route('admin.settings') }}" method="post" class="form-validation">
							<!--!! CSRF FIELD !!-->
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Company Name</label>
										<input type="text" class="form-control" name="company_name" value="{{ Setting::get('company_name') }}" placeholder="Company name" required />
										<label id="company_name-error" class="error" for="company_name">@error('company_name') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Company Email</label>
										<input type="text" class="form-control" name="company_email" value="{{ Setting::get('company_email') }}" placeholder="Company Email" required />
										<label id="company_email-error" class="error" for="company_email">@error('company_email') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Company Phone Number</label>
										<input type="text" class="form-control" name="company_phonenumber" value="{{ Setting::get('company_phonenumber') }}" placeholder="Company Phone Number" required />
										<label id="company_phonenumber-error" class="error" for="company_phonenumber">@error('company_phonenumber') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Company Timing</label>
										<input type="text" class="form-control" name="company_timing" value="{{ Setting::get('company_timing') }}" placeholder="Company Timing" required />
										<label id="company_timing-error" class="error" for="company_timing">@error('company_timing') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Company Address</label>
										<input type="text" class="form-control" name="company_address" value="{{ Setting::get('company_address') }}" placeholder="Company address" required />
										<label id="company_address-error" class="error" for="company_address">@error('company_address') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label class="form-label">Logo</label>
										<div 
											class="upload-image-section"
											data-type="image"
											data-multiple="false"
											data-path="logos"
											data-resize-large="1366*250"
											data-resize-medium="400*75"
											data-resize-small="150*27"
										>
											<div class="upload-section {{ isset($logo) && $logo ? 'd-none' : '' }}">
												<div class="button-ref mb-3">
													<button class="btn btn-primary" type="button">
										                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
										                <span class="btn-inner--text">Upload Logo</span>
									              	</button>
									            </div>
									            <!-- PROGRESS BAR -->
												<div class="progress d-none">
								                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
								                </div>
								            </div>
							                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="logo"></textarea>
							                <div class="show-section {{ !old('logo') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('logo') ])
							                </div>
							                 <div class="fixed-edit-section">
							                	@include('admin.partials.previewFileRender', ['file' => $logo, 'relationType' => 'settings.logo', 'relationId' => "" ])
							                </div>
										</div>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label class="form-label">favicon</label>
										<div 
											class="upload-image-section"
											data-type="image"
											data-multiple="false"
											data-path="logos"
											data-resize-large="1366*250"
											data-resize-medium="400*75"
											data-resize-small="150*27"
										>
											<div class="upload-section {{ isset($favicon) && $favicon ? 'd-none' : '' }}">
												<div class="button-ref mb-3">
													<button class="btn btn-primary" type="button">
										                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
										                <span class="btn-inner--text">Upload Favicon</span>
									              	</button>
									            </div>
									            <!-- PROGRESS BAR -->
												<div class="progress d-none">
								                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
								                </div>
								            </div>
							                <!-- INPUT WITH FILE URL -->
							                <textarea class="d-none" name="favicon"></textarea>
							                <div class="show-section {{ !old('favicon') ? 'd-none' : "" }}">
							                	@include('admin.partials.previewFileRender', ['file' => old('favicon') ])
							                </div>
							                 <div class="fixed-edit-section">
							                	@include('admin.partials.previewFileRender', ['file' => $favicon, 'relationType' => 'settings.favicon', 'relationId' => "" ])
							                </div>
										</div>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">2nd Factor Authentication</label>
										<div class="form-check form-switch mt-2">
											<input type="hidden" name="admin_second_auth_factor" value="0">
				                    		<input type="checkbox" name="admin_second_auth_factor" class="form-check-input" id="2ndfactor" value="1" {{ $secondAuth ? 'checked' : '' }}/>
											<label class="form-check-label" for="2ndfactor">Enable/Disable</label>
				                      	</div>
				                    </div>
				                </div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Notificaiton Email</label>
										<input type="text" class="form-control" name="admin_notification_email" value="{{ Setting::get('admin_notification_email') }}" placeholder="info@example.com" required />
										<label id="admin_notification_email-error" class="error" for="admin_notification_email">@error('admin_notification_email') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label class="form-label">Currency Code</label>
										<input type="text" class="form-control" name="currency_code" value="{{ Setting::get('currency_code') }}" placeholder="USD" required/>
										<label id="currency_code-error" class="error" for="currency_code">@error('currency_code') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label class="form-label">Currency Symbol</label>
										<input type="text" class="form-control" name="currency_symbol" value="{{ Setting::get('currency_symbol') }}" required />
										<label id="currency_symbol-error" class="error" for="currency_symbol">@error('currency_symbol') {{ $message }} @enderror</label>
									</div>
								</div>
							</div>
							<div class="form-group mt-2 clearfix">
								<button type="submit" class="btn btn-primary float-end">Submit</button>
							</div>
						</form>
					</div>
				</div>
				<div class="card mt-4">
					<h5 class="card-header">Recaptcha V3 Settings</h5>
					<hr class="my-0" />
					<div class="card-body">
						<form method="post" action="{{ route('admin.settings.recaptcha') }}" class="recapcha-validation">
							<!--!! CSRF FIELD !!-->
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Recaptcha Key</label>
										<input type="text" class="form-control" name="recaptcha_key" value="{{ Setting::get('recaptcha_key') }}" required />
										<label id="recaptcha_key-error" class="error" for="recaptcha_key">@error('recaptcha_key') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Recaptcha Secret</label>
										<input type="text" class="form-control" name="recaptcha_secret" value="{{ Setting::get('recaptcha_secret') }}" required />
										<label id="recaptcha_secret-error" class="error" for="recaptcha_secret">@error('recaptcha_secret') {{ $message }} @enderror</label>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
									<div class="form-group">
										<div class="form-check form-switch mb-2">
											<input type="hidden" name="admin_recaptcha" value="0">
				                    		<input type="checkbox" class="form-check-input" name="admin_recaptcha" value="1" {{  Setting::get('admin_recaptcha') ? 'checked' : '' }} />
											<label class="form-check-label">Enable Recaptcha for Admin</label>
				                      </div>
				                    </div>
				                </div>
				                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
									<div class="form-group">
										<div class="form-check form-switch mb-2">
											<input type="hidden" name="frontend_recaptcha" value="0">
				                    		<input type="checkbox" class="form-check-input" name="frontend_recaptcha" value="1" {{  Setting::get('frontend_recaptcha') ? 'checked' : '' }} />
											<label class="form-check-label">Enable Recaptcha for Frontend</label>
				                      </div>
				                    </div>
				                </div>
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<p>
											<small>
												<b>Generate your Recaptch V3 here.</b><br>
												<a href="https://www.google.com/recaptcha/admin/create" target="_blank">https://www.google.com/recaptcha/admin/create</a>
											</small>
										</p>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="mt-2 clearfix">
									<button type="submit" class="btn btn-primary float-end">Submit</button>
								</div>		
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="card">
					<h5 class="card-header">Date & Time Formats</h5>
					<hr class="my-0" />
					<div class="card-body">
						<form method="post" action="{{ route('admin.settings.dateTimeFormats') }}" class="date-time-validation">
							<!--!! CSRF FIELD !!-->
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label class="form-label">Date Format</label>
										<select class="select2 form-select" name="date_format">
											<option value="d-m-Y" {{ Setting::get('date_format') == 'd-m-Y' ? 'selected' : '' }}>d-m-Y</option>
							                <option value="d/m/Y" {{ Setting::get('date_format') == 'd/m/Y' ? 'selected' : '' }}>d/m/Y</option>
							                <option value="d.m.Y" {{ Setting::get('date_format') == 'd.m.Y' ? 'selected' : '' }}>d.m.Y</option>
							                <option value="m-d-Y" {{ Setting::get('date_format') == 'm-d-Y' ? 'selected' : '' }}>m-d-Y</option>
							                <option value="m/d/Y" {{ Setting::get('date_format') == 'm/d/Y' ? 'selected' : '' }}>m/d/Y</option>
							                <option value="m.d.Y" {{ Setting::get('date_format') == 'm.d.Y' ? 'selected' : '' }}>m.d.Y</option>
							                <option value="Y-m-d" {{ Setting::get('date_format') == 'Y-m-d' ? 'selected' : '' }}>Y-m-d</option>
										</select>
									</div>
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label class="form-label">Time Format</label>
										<select class="select2 form-select" name="time_format">
											<option value="h:iA" {{ Setting::get('time_format') == 'h:iA' ? 'selected' : '' }}>12 Hours</option>
									        <option value="H:i" {{ Setting::get('time_format') == 'H:i' ? 'selected' : '' }}>24 Hours</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="mt-2 clearfix">
									<button type="submit" class="btn btn-primary float-end">Submit</button>
								</div>		
							</div>
						</form>
					</div>
				</div>
				<div class="mt-4"></div>
				<div class="card">
					<h5 class="card-header">Email Settings</h5>
					<hr class="my-0" />
					<div class="card-body">
						<form method="post" action="{{ route('admin.settings.email') }}" class="smtp-validation">
							<!--!! CSRF FIELD !!-->
							{{ csrf_field() }}
							<div class="row">
								{{-- <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">Method Information</label>
										<div class="form-group mt-2">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="email_method" id="smtpOption" value="smtp" {{ $method && $method == 'smtp' ? 'checked' : '' }} onclick="$('.smtp-section').removeClass('d-none');$('.sendgrid-section').addClass('d-none')"/>
												<label class="form-check-label" for="smtpOption">SMTP</label>
											</div>
											<div class="form-check form-check-inline">
												<input type="radio" class="form-check-input" name="email_method" id="sendgridOption" value="sendgrid" {{ $method && $method == 'sendgrid' ? 'checked' : '' }} onclick="$('.smtp-section').addClass('d-none');$('.sendgrid-section').removeClass('d-none')"/>
												<label class="form-check-label" for="sendgridOption">Send Grid</label>
											</div>
										</div>
									</div>
								</div> --}}
								<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label class="form-label">From Email Address</label>
										<input type="email" class="form-control" name="from_email" placeholder="info@example.com" value="{{ Setting::get('from_email') }}" required>
										<label id="from_email-error" class="error" for="from_email">@error('from_email') {{ $message }} @enderror</label>
									</div>
								</div>
							</div>
							<!-- SMTP Fields -->
							<div class="smtp-section {{ $method != 'smtp' ? 'd-none' : '' }}">
								<div class="row">
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label class="form-label">SMTP Host</label>
											<input type="text" class="form-control" name="smtp_host" required placeholder="smtp.google.com" value="{{ Setting::get('smtp_host') }}">
											<label id="smtp_host-error" class="error" for="smtp_host">@error('smtp_host') {{ $message }} @enderror</label>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label class="form-label">SMTP Encryption</label>
											<select class="select2 form-select" name="smtp_encryption" required>
												<option value="ssl" {{ $encryption == 'ssl' ? 'selected' : '' }}>SSL (Secure Socket Layer)</option>
												<option value="tls" {{ $encryption == 'tls' ? 'selected' : ''}}>TLS (Transport Layer Security)</option>
											</select>
											<label id="smtp_encryption-error" class="error" for="smtp_encryption">@error('smtp_encryption') {{ $message }} @enderror</label>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label class="form-label">SMTP Port</label>
											<input type="text" class="form-control" name="smtp_port" placeholder="465 or 587" value="{{ Setting::get('smtp_port') }}" required>
											<label id="smtp_port-error" class="error" for="smtp_port">@error('smtp_port') {{ $message }} @enderror</label>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label class="form-label">SMTP Username</label>
											<input type="text" class="form-control" name="smtp_username" placeholder="" value="{{ Setting::get('smtp_username') }}" required>
											<label id="smtp_username-error" class="error" for="smtp_username">@error('smtp_username') {{ $message }} @enderror</label>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label class="form-label">SMTP Email</label>
											<input type="email" class="form-control" name="smtp_email" placeholder="" value="{{ Setting::get('smtp_email') }}" required>
											<label id="smtp_email-error" class="error" for="smtp_email">@error('smtp_email') {{ $message }} @enderror</label>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<div class="form-password-toggle">
											    <div class="d-flex justify-content-between">
											        <label class="form-label" for="password">SMTP Password</label>
											    </div>
											    <div class="input-group">
											        <input type="password" class="form-control" name="smtp_password" placeholder="******" aria-describedby="password" value="{{ Setting::get('smtp_password') }}" required />
											        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
											    </div>
											    <label id="smtp_password-error" class="error" for="smtp_password">@error('smtp_password') {{ $message }} @enderror</label>
											</div>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<p>
												<small>
													<b>Google SMTP Reference</b><br>
													Go to your gmail settings. Follow below link.<br>
													SMTP Details: <a href="https://www.digitalocean.com/community/tutorials/how-to-use-google-s-smtp-server" target="_blank">https://www.digitalocean.com/community/tutorials/how-to-use-google-s-smtp-server</a>
													<br>
													Allow less secure apps in your google account. Follow below link.<br>
													<a href="https://support.google.com/accounts/answer/6010255?hl=en" target="_blank">https://support.google.com/accounts/answer/6010255?hl=en</a>
												</small>
											</p>
										</div>
									</div>
								</div>
							</div>
							<!-- SMTP Fields -->

							<!-- SendGrid Fields -->
							<div class="sendgrid-section {{ $method != 'sendgrid' ? 'd-none' : '' }}">
								<div class="row">
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label class="form-label">Send Grid Email</label>
											<input type="email" class="form-control" name="sendgrid_email" placeholder="info@example.com" value="{{ Setting::get('sendgrid_email') }}" required>
											<label id="sendgrid_email-error" class="error" for="sendgrid_email">@error('sendgrid_email') {{ $message }} @enderror</label>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label class="form-label">Send Grid Key</label>
											<input type="text" class="form-control" name="sendgrid_api_key" placeholder="SG...." value="{{ Setting::get('sendgrid_api_key') }}" required>
											<label id="sendgrid_api_key-error" class="error" for="sendgrid_api_key">@error('sendgrid_api_key') {{ $message }} @enderror</label>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<p>
												<small>
													<b>Send Grid Reference</b><br>
													<a href="https://sendgrid.com/docs/ui/account-and-settings/api-keys/" target="_blank">https://sendgrid.com/docs/ui/account-and-settings/api-keys/</a>
												</small>
											</p>
										</div>
									</div>
								</div>
							</div>
							<!-- SendGrid Fields -->
							<div class="form-group">
								<div class="mt-2 clearfix">
									<button type="submit" class="btn btn-primary float-end">Submit</button>
								</div>		
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection