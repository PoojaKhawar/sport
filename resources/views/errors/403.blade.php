@php
    use App\Models\Admin\Setting;
    use App\Models\User\UserAuth;
    $favicon = Setting::get('favicon');
    $companyName = Setting::get('company_name');
    $version = 0.1;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($companyName) && $companyName ? $companyName : 'Attendance' }}</title>

    <!-- ==== Favicon icon ==== -->
    <link rel="icon" href="{{ url('frontend/images/favicon.png'); }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/favicon.png'); }}" />

    <!-- ==== Robots Meta ==== -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">

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
<body>

    <!-- ==== Manual_header Start ==== -->
    <section class="manual_header">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="inner_header">
                        <div class="logo_img">
                            <img src="{{asset('/frontend/images/img_logo.png')}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Manual_header end ==== -->

    <!-- ==== Error_404 Section Start ==== -->
    <section class="error_section lost_page">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="error_section_details">
                        <div class="row">
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                <div class="img_section">
                                    <div class="img_area">
                                        <img src="{{asset('/frontend/images/lost_img.png')}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-6 col-sm-6 col-12">
                                <div class="content_area">
                                    <h3>Looks like you are lost?</h3>
                                    <div class="txt_w">
                                        <p>Why don’t you try going back to, where you came from? & see if it helps?</p>
                                        <p>Be Quick, you are losing Production Hours.</p>
                                    </div>
                                    <div class="btn_back">
                                        <a href="javascript:;" class="btn-primary">Go Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Error_404 Section End ==== -->

    <!-- ==== Manual_Footer Start ==== -->
    <section class="manual_footer">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="inner_footer">
                        <div class="text">© Copyright 2023 | All Right Reserved | Powered By <a href="javascript:;">Globiz Technology Inc.</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Manual_Footer End ==== -->

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
    <!-- ==== Bootbox ==== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <!-- ==== Toast ==== -->
    <script src="{{ url('frontend/plugins/toast/jquery.toaster.js') }}"></script>
    <!-- ==== Chart ==== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- ==== Custom js ==== -->
    <script src="{{ url('frontend/js/custom.js') }}"></script>
    <!-- ==== Validation js === -->
    <script src="{{ url('frontend/js/developer.js') }}"></script>
</body>
</html>