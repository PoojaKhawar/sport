@php
	use App\Models\Admin\Setting;
	use App\Models\User\UserAuth;
	$favicon = Setting::get('favicon');
	$companyName = Setting::get('company_name');
	$version = 2.2;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ isset($companyName) && $companyName ? $companyName : 'Globiz' }}</title>

	<!-- ==== Favicon icon ==== -->
    <link rel="icon" href="{{ url('frontend/images/favicon.png'); }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/favicon.png'); }}" />

    <!-- ==== SEO Meta ==== -->
    <meta name="title" content="{{ isset($companyName) && $companyName ? $companyName : 'Globiz' }}">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- ==== Robots Meta ==== -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">

    <!-- ==== og Meta ==== -->
    <meta property="og:title" content="">
    <meta property="og:site_name" content="">
    <meta property="og:url" content="">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta property="og:image" content="">

    <!-- ==== Twitter ==== -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="">
    <meta property="twitter:title" content="">
    <meta property="twitter:description" content="">
    <meta property="twitter:image" content="">

    <!-- ==== Cache Clear ==== -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

	<!-- ==== Bootstrap CSS ==== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- ==== Open Sans Fonts ==== -->
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- ==== Roboto Condensed Fonts ==== -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- ==== Poppins Fonts ==== -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
	<!-- ==== Font Awesome CSS ==== -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />
	@if(isset(request()->route()->getAction()['as']) && (strpos(request()->route()->getAction()['as'], 'user.dashboard') > -1 || strpos(request()->route()->getAction()['as'], 'user.task') > -1 || strpos(request()->route()->getAction()['as'], 'user.meeting.add') > -1 || strpos(request()->route()->getAction()['as'], 'user.leave.compose') > -1) || strpos(request()->route()->getAction()['as'], 'requestView') > -1)
	<!-- ==== Select 2 ==== -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endif
	<!-- ==== Custom CSS ==== -->
	<link rel="stylesheet" href="{{ url('frontend/css/custom.min.css') }}" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="canonical" href="{{ url()->full() }}" />
</head>
<body id="pb_scroll">
	<!-- Header -->
	@include('frontend.partials.header')
	<!-- Header -->

	<!-- Content render here -->
	@yield('content')
	<!-- Content -->
	@include('frontend.partials.footer')
	
	<form method="post" action="<?php echo route('actions.uploadFile') ?>"  enctype="multipart/form-data" class="d-none" id="fileUploadForm">
		<?php echo csrf_field() ?>
		<input type="hidden" name="path" value="">
		<input type="hidden" name="file_type" value="">
		<input type="file" name="file">
		<input type="hidden" name="resize_large">
		<input type="hidden" name="resize_medium">
		<input type="hidden" name="resize_small">
	</form>
	<script>
		var site_url 					= "{{ url("/") }}";
		var admin_url 					= "{{ url("/admin/") }}";
		var current_url 				= "{{ url()->current() }}";
		var current_full_url 			= "{{ url()->full() }}";
		var previous_url 				= "{{ url()->previous() }}";
		var pagination_limit 			= "12";
		var authId 		= "{{ UserAuth::getLoginId() }}";
		var csrf_token = function(){
			return "{{csrf_token()}}";
		}
	</script>

	<!-- ==== jQuery JS ==== -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<!-- ==== jQuery form js ==== -->	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
	<!-- ==== Bootstrap JS ==== -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- ==== jQuery validation JS ==== -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
	<!-- ==== jQuery Additional method validation JS ==== -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>
	<!-- ==== jQuery matchHeight JS === -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>
	@if(isset(request()->route()->getAction()['as']) && (strpos(request()->route()->getAction()['as'], 'user.dashboard') > -1 || strpos(request()->route()->getAction()['as'], 'user.task') > -1 || strpos(request()->route()->getAction()['as'], 'user.meeting.add') > -1 || strpos(request()->route()->getAction()['as'], 'user.leave.compose') > -1) || strpos(request()->route()->getAction()['as'], 'requestView') > -1)
	<!-- ==== Select 2 JS ==== -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    @endif
	<!-- ==== Toast ==== -->
	<script src="{{ url('frontend/plugins/toast/jquery.toaster.js') }}"></script>
	<!-- ==== Chart ==== -->
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> --}}
	@if(isset(request()->route()->getAction()['as']) && strpos(request()->route()->getAction()['as'], 'user.attendance.calender') > -1)
    	<!-- ==== Calender JS ==== -->
    	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    @endif

    @if(isset(request()->route()->getAction()['as']) && (strpos(request()->route()->getAction()['as'], 'user.dashboard') > -1 || strpos(request()->route()->getAction()['as'], 'user.leave.compose') > -1) || strpos(request()->route()->getAction()['as'], 'requestView') > -1)
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    @endif

    <!-- ==== Custom js ==== -->
    <script src="{{ url("frontend/js/custom.js?v={$version}") }}"></script>
    <!-- ==== Validation js === -->
	<script src="{{ url("frontend/js/developer.js?v={$version}") }}"></script>
	
</body>
</html>