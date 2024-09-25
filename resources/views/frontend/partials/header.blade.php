<!-- Header-section---start -->
<section class="header_section " id="myHeader">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="inner_header">
                    <div class="left_area">
                        <div class="logo_area">
                            <h3>{{ $companyName ?? 'Woodstock Emissions'}}</h3>
                        </div>
                    </div>
                    <div class="right_area">
                        <div class="right_area_inner">
                            <div class="left_child d-lg-block d-none">
                                <ul>
                                    <li>
                                        <a href="{{ route('homepage.index')}}" aria-label="Home">
                                            Home
                                        </a>
                                    </li>
                                    @if(!empty($about))
                                    <li>
                                        <a href="{{ route('homepage.index')}}#aboutUs" aria-label="About">
                                            About
                                        </a>
                                    </li>
                                    @endif

                                    @if(!empty($services))
                                    <li>
                                        <a href="{{ route('homepage.index')}}#services" aria-label="Services">
                                            Services
                                        </a>
                                    </li>
                                    @endif

                                    @if(!empty($testCount) && $testCount > 0)
                                    <li>
                                        <a href="{{ route('homepage.index')}}#testimonials" aria-label="Testimonials">     Testimonials
                                        </a>
                                    </li>
                                    @endif

                                    @if(!empty($faqCount) && $faqCount >0)
                                    <li>
                                        <a  href="{{ route('homepage.index')}}#faq" aria-label="FAQ">
                                            FAQ
                                        </a>
                                    </li>
                                    @endif

                                    <li>
                                        <a href="{{ route('homepage.index')}}#contactUs" class="btn-primary" aria-label="Contact">
                                            Contact
                                        </a>
                                    </li>
                                </ul> 
                            </div>
                            <div class="right_child">
                                <form class="d-sm-block d-none">
                                    <div class="form-group">
                                        <div class="search_icon">
                                            <i class="far fa-search"></i>
                                        </div>
                                        <input class="form-control" placeholder="Search" type="text" />
                                    </div>
                                </form>
                                <div class="open_menu">
                                    <div class="bar bar1"></div>
                                    <div class="bar bar2"></div>
                                    <div class="bar bar3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="responsive_header">
        <!-- <div class="upper_area">
            <div class="upper_left">
                <div class="logo_area">
                    <h3>Woodstock Emissions</h3>
                </div>
            </div>
            <div class="upper_right">
                <div class="close_menu">
                    <i class="fal fa-times"></i>
                </div>
            </div>
        </div> -->
        <div class="lower_area">
            <ul>
                <li class="active">
                    <a href="{{ route('homepage.index')}}" aria-label="Home">
                        Home
                    </a>
                </li>

                @if(!empty($about))
                <li>
                    <a href="{{ route('homepage.index')}}#aboutUs" aria-label="About">
                        About
                    </a>
                </li>
                @endif

                @if(!empty($services))
                    <li>
                        <a href="{{ route('homepage.index')}}#services" aria-label="Services">
                            Services
                        </a>
                    </li>
                @endif

                @if(!empty($testCount) && $testCount > 0)
                    <li>
                        <a  href="{{ route('homepage.index')}}#testimonials" aria-label="Testimonials">
                            Testimonials
                        </a>
                    </li>
                @endif

                @if(!empty($faqCount) && $faqCount >0)
                    <li>
                        <a href="{{ route('homepage.index')}}#faq" aria-label="FAQ">
                            FAQ
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('homepage.index')}}#contacUs" class="btn-primary" aria-label="Contact">
                        Contact
                    </a>
                </li>
            </ul> 
        </div>
    </div>
</section>

<section class="header_2">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="parent_area">
                    <div class="lower_header d-md-block d-none">
                        <ul>
                            <li>
                                <a href="https://www.google.com/maps/search/{{ urlencode($companyAddress ?? '#') }}" aria-label="Company Address" target="_blank">
                                    <i class="far fa-map-marker-alt"></i>
                                    <span>{{ characterLimitWithRemoveTags($companyAddress , 35) ?? '#' }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:{{ $companyPhoneNumber ?? '#' }}" aria-label="Company Phone Number" target="_blank">
                                    <i class="far fa-phone-alt"></i>
                                    <span>{{ $companyPhoneNumber ?? '#' }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:{{ $companyEmail ?? '#' }}" aria-label="Company Email" target="_blank">
                                    <i class="far fa-envelope"></i>
                                    <span>{{ $companyEmail ?? '#' }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Header-section---end -->