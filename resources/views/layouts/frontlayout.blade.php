@php
	use App\Models\Admin\Setting;
    use App\Models\User\UserAuth;
	use App\Models\Frontend\Page;
    use App\Models\Frontend\PageContent;
    use App\Models\Frontend\Testimonials;
    use App\Models\Frontend\Faq;

	$favicon = Setting::get('favicon');
    $logo = Setting::get('logo');
    $companyName = Setting::get('company_name');
    $companyEmail = Setting::get('company_email');
    $companyPhoneNumber = Setting::get('company_phonenumber');
    $companyAddress = Setting::get('company_address');
	$companyTiming = Setting::get('company_timing');
    $footer = PageContent::getRow('home','footer','data');
    $recaptchaEnabled = Setting::get('frontend_recaptcha');
    $recaptchaSiteKey = Setting::get('recaptcha_key');
    $legal = Page::where('status',1)->select('title','slug')->get();
    $faqCount = Faq::where('status',1)->count();
    $testCount = Testimonials::where('status',1)->count();
    $about = PageContent::getRow('home','clear_air','data');
    $services = PageContent::getRow('home','service_content','data');
	$version = 0.1;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">
    <title>{{ $companyName ?? 'WoodStock Emission'}}</title>

    <!-- SEO Meta -->
    <meta name="title" content="{{ $meta['meta_title'] ?? 'WoodStock Emission'}}">
    <meta name="keywords" content="{{ $meta['meta_keywords'] ?? 'WoodStock Emission'}}">
    <meta name="description" content="{{ $meta['meta_description'] ?? 'WoodStock Emission'}}">

    <!-- Robots Meta -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ $meta['meta_title'] ?? 'WoodStock Emission'}}">
    <meta property="og:site_name" content="{{ $companyName ?? 'WoodStock Emission'}}">
    <meta property="og:url" content="{{url()->full()}}">
    <meta property="og:description" content="{{ $meta['meta_description'] ?? 'WoodStock Emission'}}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $meta['image'] ?? url($logo) }}">

    <!-- Twitter Meta -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{url()->full()}}">
    <meta property="twitter:title" content="{{ $meta['meta_title'] ?? 'WoodStock'}}">
    <meta property="twitter:description" content="{{ $meta['meta_description'] ?? 'WoodStock'}}">
    <meta property="twitter:image" content="{{ $meta['image'] ??  url($logo) }}">

    <!-- Cache Control -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- ==== Favicon icon ==== -->
    @if($favicon)
        <link rel="icon" href="{{ $favicon ?? '#'}}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ $favicon ?? '#'}}" type="image/x-icon">
    @endif

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url('/frontend/css/custom.css') }}">

    <link rel="canonical" href="">
</head>
<body id="pb_scroll">

    <div class="loader_area" id="loading-image">
        <div class="loader1">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    @include('frontend.partials.header')
    @yield('content')
    @include('frontend.partials.footer')

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

      <?php if (isset($recaptchaEnabled) && $recaptchaEnabled) : ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptchaSiteKey ?>"></script>
        <script>
            let reCaptchaLoad = () => {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute(
                    '<?php echo $recaptchaSiteKey ?>', {
                        action: 'validate_captcha'
                    }
                ).then(function(token) {
                    // add token value to form
                    document.getElementById('g-recaptcha-response').value = token;
                });
            }
            grecaptcha.ready(function() {

                reCaptchaLoad()
            });
        </script>
    <?php endif; ?>

    <!-- jQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Validation JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>

    <!-- jQuery Match Height JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Bootbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

    <!-- Toast JS -->
    <script src="{{ url('/frontend/plugins/toast/jquery.toaster.js')}}"></script>

    <!-- GSAP JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" integrity="sha512-onMTRKJBKz8M1TnqqDuGBlowlH0ohFzMXYRNebz+yOcc5TQr/zAKsthzhuv0hiyUKEiQEQXEynnXCvNTOk50dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom JS -->
    <script src="{{ url('/frontend/js/custom.js') }}"></script>

    <!-- Developer JS -->
    <script src="{{ url('/frontend/js/developer.js') }}"></script>
</body>
</html>
