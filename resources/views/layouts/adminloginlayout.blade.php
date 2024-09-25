@php
$favicon = Setting::get('favicon');
$logo = Setting::get('logo');
$companyName = Setting::get('company_name');
$recaptchaEnabled = Setting::get('admin_recaptcha');
$recaptchaSiteKey = Setting::get('recaptcha_key');
@endphp

<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="author" content="Irfan Ahmad">
    <title>{{ $companyName }}</title>
    <!-- ==== Robots Meta ==== -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <!-- ==== Favicon ====  -->
    {{-- @if($favicon)
    <link rel="icon" type="image/x-icon" href="{{ url($favicon) }}" />
    @endif --}}
    <!-- ==== Favicon icon ==== -->
    <link rel="icon" href="{{ url('frontend/images/favicon.png'); }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/favicon.png'); }}" />
    <!-- ==== Fonts ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <!-- ==== Icons. Uncomment required icon fonts ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/fonts/boxicons.css') }}" />
    <!-- ==== Core CSS ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('admin/assets/css/demo.css') }}" />
    <!-- ==== Font Awesome CSS ==== -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />
    <!-- ==== Vendors CSS ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <!-- ==== Page ==== -->
    <link rel="stylesheet" href="{{ url('admin/assets/vendor/css/pages/page-auth.css') }}" />
    <!-- ==== Helpers ==== -->
    <script src="{{ url('admin/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('admin/assets/js/config.js') }}"></script>
    <!-- ==== Custom css ==== -->
    <link rel="stylesheet" href="{{ url('admin/dev/css/custom.css') }}" />
</head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="javascript:;" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo"></span>
                                <span class="app-brand-text demo text-body fw-bolder text-capitalize">{{ $companyName }}</span>
                            </a>
                        </div>
                        <!-- ==== yield content start ==== -->
                        @yield('content')
                        <!-- ==== yield content end ==== -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==== jquery ==== -->
    <script src="{{ url('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <!-- ==== popper ==== -->
    <script src="{{ url('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <!-- ==== bootstrap ==== -->
    <script src="{{ url('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <!-- ==== perfect scrollbar ==== -->
    <script src="{{ url('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <!-- ==== menu ==== -->
    <script src="{{ url('admin/assets/vendor/js/menu.js') }}"></script>
    <!-- ==== Main ==== -->
    <script src="{{ url('admin/assets/js/main.js') }}"></script>
    <!-- ==== Place this tag in your head or just before your close body tag.==== -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <?php if(isset($recaptchaEnabled) && $recaptchaEnabled): ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptchaSiteKey ?>"></script>
    <script>
        grecaptcha.ready(function() {
            // do request for recaptcha token
            // response is promise with passed token
            grecaptcha.execute(
                '<?php echo $recaptchaSiteKey ?>', 
                {
                    action:'validate_captcha'
                }
            ).then(function(token) {
                // add token value to form
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
     </script>
    <?php endif; ?>
    <!-- ==== jquery validate ==== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <!-- ==== Custom js ==== -->
    <script src="{{ url('admin/dev/js/admin.js') }}"></script>
</body>
</html>