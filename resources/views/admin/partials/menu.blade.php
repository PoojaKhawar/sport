<!-- ==== Menu Start === -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" target="_blank" class="app-brand-link">
            <span class="app-brand-logo demo"></span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: inherit;">{{ $companyName ?? 'WoodStock'}}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- ==== Dashboard ==== -->
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.dashboard') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="bx bx-home-circle me-2"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- ==== Content's ==== -->
        @if(Permission::hasPermission('home', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.home') > -1
        @endphp
        <li class="menu-item {{ $active ? ' open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fas fa-file me-2"></i>
                <div data-i18n="Content's">Content's</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->route()->getAction()['as'] == 'admin.home' ? ' active' : '' }}">
                    <a href="{{ route('admin.home') }}" class="menu-link">
                        <div data-i18n="Account">Home</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- ==== Pages ==== -->
        @if(Permission::hasPermission('pages', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.pages') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }}">
            <a href="{{ route('admin.pages') }}" class="menu-link">
                <i class="bx bx-copy me-2"></i>
                <div data-i18n="Pages">Pages</div>
            </a>
        </li>
        @endif

        <!-- ==== Slider ==== -->
        @if(Permission::hasPermission('sliders', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.sliders') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }} d-none">
            <a href="{{ route('admin.sliders') }}" class="menu-link">
                <i class="bx bx-image me-2"></i>
                <div data-i18n="Sliders">Sliders</div>
            </a>
        </li>
        @endif

        <!-- ==== Testimonials ==== -->
        @if(Permission::hasPermission('testimonials', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.testimonials') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }} ">
            <a href="{{ route('admin.testimonials') }}" class="menu-link">
                <i class="fas fa-chalkboard-teacher me-2"></i>
                <div data-i18n="Testimonials">Testimonials</div>
            </a>
        </li>
        @endif

        <!-- ==== Faqs ==== -->
        @if(Permission::hasPermission('faqs', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.faqs') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }}">
            <a href="{{ route('admin.faqs') }}" class="menu-link">
                <i class="far fa-question-circle me-2"></i>
                <div data-i18n="Faqs">Faqs</div>
            </a>
        </li>
        @endif

        <!-- ==== Blogs ==== -->
        @if(Permission::hasPermission('blogs', 'listing') || Permission::hasPermission('blog_categories', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.blogs') > -1
        @endphp
        <li class="menu-item {{ $active ? ' open' : '' }} d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons far fa-blog"></i>
                <div data-i18n="Account Settings">Blogs</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->route()->getAction()['as'] == 'admin.blogs' ? ' active' : '' }}">
                    <a href="{{ route('admin.blogs') }}" class="menu-link">
                        <div data-i18n="Account">Blogs</div>
                    </a>
                </li>
                @php 
                    $active = strpos(request()->route()->getAction()['as'], 'admin.blogs.categories') > -1
                @endphp
                <li class="menu-item {{ ($active ? ' active' : '') }}">
                    <a href="{{ route('admin.blogs.categories') }}" class="menu-link">
                        <div data-i18n="Notifications">Categories</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- ==== Users ==== -->
        @if(Permission::hasPermission('users', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.users') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }} d-none">
            <a href="{{ route('admin.users') }}" class="menu-link">
                <i class="far fa-users me-2"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>
        @endif

        <!-- ==== Contact Us ==== -->
        @if(Permission::hasPermission('contact_us', 'listing'))
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.contactUs') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }}">
            <a href="{{ route('admin.contactUs') }}" class="menu-link">
                <i class="far fa-id-card-alt me-2"></i>
                <div data-i18n="Contact Us">Contact Us</div>
            </a>
        </li>
        @endif

        @if(AdminAuth::isAdmin())
        <!-- ==== Others ==== -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">OTHERS</span>
        </li>

        <!-- ==== Admins ==== -->
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.admins') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }} d-none">
            <a href="{{ route('admin.admins') }}" class="menu-link">
                <i class="far fa-users-class me-2"></i>
                <div data-i18n="Admins">Admins</div>
            </a>
        </li>

        <!-- ==== Roles ==== -->
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.roles') > -1
        @endphp
        <li class="menu-item {{ $active ? ' active' : '' }} d-none">
            <a href="{{ route('admin.roles') }}" class="menu-link">
                <i class="far fa-user-tag me-2"></i>
                <div data-i18n="Roles">Roles</div>
            </a>
        </li>

        <!-- ==== Activities ==== -->
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.activities') > -1
        @endphp
        <li class="menu-item {{ $active ? ' open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fas fa-list"></i>
                <div data-i18n="Activities Settings">Activities</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ (request()->route()->getAction()['as'] == 'admin.activities.logs' ? ' active' : '') }}">
                    <a href="{{ route('admin.activities.logs') }}" class="menu-link">
                        <div data-i18n="Activities Logs">Activities Logs</div>
                    </a>
                </li>
                <li class="menu-item {{ (request()->route()->getAction()['as'] == 'admin.activities.emails' ? ' active' : '') }}">
                    <a href="{{ route('admin.activities.emails') }}" class="menu-link">
                        <div data-i18n="Email Logs">Email Logs</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ==== Locations ==== -->
        @php 
            $active = strpos(request()->route()->getAction()['as'], 'admin.countries') > -1 || strpos(request()->route()->getAction()['as'], 'admin.states') > -1 || strpos(request()->route()->getAction()['as'], 'admin.cities') > -1
        @endphp
        <li class="menu-item {{ $active ? ' open active' : '' }} d-none">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons far fa-street-view"></i>
                <div data-i18n="Location Settings">Locations</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ (request()->route()->getAction()['as'] == 'admin.countries' ? ' active' : '') }}">
                    <a href="{{ route('admin.countries') }}" class="menu-link">
                        <div data-i18n="Countries">Countries</div>
                    </a>
                </li>
                <li class="menu-item {{ (request()->route()->getAction()['as'] == 'admin.states' ? ' active' : '') }}">
                    <a href="{{ route('admin.states') }}" class="menu-link">
                        <div data-i18n="States">States</div>
                    </a>
                </li>
                <li class="menu-item {{ (request()->route()->getAction()['as'] == 'admin.cities' ? ' active' : '') }}">
                    <a href="{{ route('admin.cities') }}" class="menu-link">
                        <div data-i18n="Cities">Cities</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
</aside>
<!-- ==== Menu End ==== -->