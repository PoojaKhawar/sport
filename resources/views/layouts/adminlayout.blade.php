@php
$favicon = Setting::get('favicon');
$logo = Setting::get('logo');
$companyName = Setting::get('company_name');
$recaptchaEnabled = Setting::get('admin_recaptcha');
$recaptchaSiteKey = Setting::get('recaptcha_key');
@endphp
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard</title>
    <!-- ==== Robots Meta ==== -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <!-- ==== Favicon ====  -->
    <link rel="icon" href="{{ url('frontend/images/favicon.png'); }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/favicon.png'); }}" />
    <!-- ==== Fonts ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- ==== Icons. Uncomment required icon fonts ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/fonts/boxicons.css') }}" />
    <!-- ==== Core CSS ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('admin/assets/css/demo.css') }}" />
    <!-- ==== daterange picker css ==== -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- ==== date picker css ==== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <!-- ==== Font Awesome CSS ==== -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />
    <!-- ==== Vendors CSS ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <!-- ==== Page CSS ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/libs/select2/select2.css') }}" />
    <!-- ==== Helpers ==== -->
    <script src="{{ url('admin/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('admin/assets/js/config.js') }}"></script>
    <!-- ==== Custom css ==== -->
    <link rel="stylesheet" href="{{ url('admin/dev/css/custom.css') }}" />

    <style type="text/css">
        .cke_notifications_area{
            display: none;
        }
    </style>
</head>
<body>
	<!-- Layout wrapper -->
	<div class="layout-wrapper layout-content-navbar">
	    <div class="layout-container">
	        @include('admin.partials.menu')

	        <!-- ==== Layout container ==== -->
	        <div class="layout-page">
	        	<div class="header_background">
	            	@include('admin.partials.header')
	            </div>

	            <!-- ==== Content wrapper start ==== -->
	            <div class="content-wrapper">
                    <!-- ==== yield content start ==== -->
                    @yield('content')
                    <!-- ==== yield content end ==== -->

	                {{-- @include('admin.partials.footer') --}}
	            
	                <div class="content-backdrop fade"></div>
	            </div>
	            <!-- ==== Content wrapper end ==== -->
	        </div>
	    </div>

	    <!-- Overlay -->
	    <div class="layout-overlay layout-menu-toggle"></div>
	</div>

	<!-- ==== Toaster ==== -->
	<div class="notificaiton_toaster"></div>
	
	<!-- ==== Page Loader ==== -->
	<div class="admin_loader">
		<div class="spinner-border spinner-border-lg text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
	</div>
		
	<form method="post" action="{{ route('admin.actions.uploadFile') }}"  enctype="multipart/form-data" class="d-none" id="fileUploadForm">
		{{ csrf_field() }}
		<input type="hidden" name="path" value="">
		<input type="hidden" name="file_type" value="">
		<input type="file" name="file">
		<input type="hidden" name="resize_large">
		<input type="hidden" name="resize_medium">
		<input type="hidden" name="resize_small">
	</form>
	
	<!-- Core -->
	<script>
		var site_url = "{{ url('/') }}";
		var admin_url = "{{ url("/admin/") }}";
		var current_url = "{{ url()->current() }}";
		var current_full_url = "{{ url()->full() }}";
		var previous_url = "{{ url()->previous() }}";
		var csrf_token = function(){
			return "{{ csrf_token() }}";
		}
	</script>

	<!-- ==== jQuery JS ==== -->
    <script src="{{ url('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <!-- ==== jQuery UI JS ==== -->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <!-- ==== Moment JS ==== -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<!-- ==== Popper JS ==== -->
    <script src="{{ url('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <!-- ==== Bootstrap JS ==== -->
    <script src="{{ url('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <!-- ==== Perfect Scrollbar JS ==== -->
    <script src="{{ url('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <!-- ==== Menu JS ==== -->
    <script src="{{ url('admin/assets/vendor/js/menu.js') }}"></script>
    <!-- ==== Select2 ==== -->
    <script src="{{ url('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <!-- ==== Main JS ==== -->
    <script src="{{ url('admin/assets/js/main.js') }}"></script>
    <!-- ==== Form layouts JS ==== -->
    <script src="{{ url('admin/assets/js/form-layouts.js') }}"></script>
    <!-- ==== Main JS ==== -->
    <script src="{{ url('admin/assets/js/ui-toasts.js') }}"></script>
    <!-- ==== Page JS ==== -->
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- ==== jquery form ==== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <!-- ==== jquery validate ==== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <!-- ==== Daterangepicker JS ==== -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- ==== Datepicker JS ==== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    @if(strpos(request()->route()->getAction()['as'], 'admin.users.calender.view') > -1)
    <!-- ==== Calender JS ==== -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    @endif
    <!-- ==== Ckeditor JS ==== -->
    {{-- <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script> 
	<script src="{{ url('admin/dev/js/ckeditor_image_plugin.js') }}"></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script> 
    <script src="<?php echo url('admin/dev/js/handle_ckeditor5.js') ?>"></script>

    <!-- ==== Custom js ==== -->
    <script src="{{ url('admin/dev/js/custom.js') }}"></script>

    <!-- ==== Developer js ==== -->
    <script src="{{ url('admin/dev/js/developer.js') }}"></script>
</body>
</html>