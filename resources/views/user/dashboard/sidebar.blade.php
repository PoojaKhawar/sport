<div class="side_bar_section">
    <div class="side_bar_area sticky-top">
        <div class="box_area">
            <div class="image_area">
                <a href="javascript:;">
                    <div class="user-img-warp">
                        <div class="user_img">
                            <img src="{{ General::renderImageUrl($user->image, 'medium') }}" alt="..." />  
                        </div>
                   </div>
                </a>
                <div class="name">{{ $user->first_name.' '.$user->last_name }}</div>
          </div>
            <div class="menu_area">
                <ul class="d-none d-md-block">
                    @php 
                        $active = strpos(request()->route()->getAction()['as'], 'user.profile') > -1;
                    @endphp
                    <li class="{{ isset($active) && $active ? 'active' : '' }}">
                        <a href="{{ route('user.profile') }}">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <div class="text">Profile</div>
                        </a>
                    </li>
                    @php 
                        $active = strpos(request()->route()->getAction()['as'], 'user.changePassword') > -1;
                    @endphp
                    <li class="{{ isset($active) && $active ? 'active' : '' }}">
                        <a href="{{ route('user.changePassword') }}">
                            <div class="icon"><i class="far fa-lock"></i></div>
                            <div class="text">Change password</div>
                        </a>
                    </li>
                     <li>
                        <a href="{{ route('user.logout') }}">
                            <div class="icon"><i class="far fa-sign-out"></i></div>
                            <div class="text">Logout</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
