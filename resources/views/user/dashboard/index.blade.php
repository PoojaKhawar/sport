@extends('layouts.frontLayout')
@section('content')

<section class="dashboard_section ">
    <div class="dashboard_inner">
        @include('user.dashboard.sidebar')
        <div class="right_side_wrap top-space">
            <div class="dashboard_section profile_view">
                 <div class="dashboard_area">
                    <div class="dashboard_inner_area">
                        <div class="right_area_dashboard">
                            <div class="inner_right_dashboard">
                                <div class="user_breadcame">
                                    <div class="left_breadcame">
                                        <ul class="list-inline">
                                            <li>
                                                <a href="javascript:;">Profile</a>
                                                <span class="icon"><i class="fas fa-user"></i></span>
                                            </li>
                                            <li class="active">
                                                <a href="javascript:;">Profile View</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="right_breadcame">
                                        <div class="bars">
                                            <i class="fa-solid fa-bars-sort"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="user_panel">
                                    <div class="user_table_view">
                                        <div class="left_table_view">
                                            <div class="table_view">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th>Name</th>
                                                        <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phone Number</th>
                                                        <td>{{ $user->phonenumber }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="right_table_view">
                                            <a href="{{ route('user.editProfile') }}" class="btn btn-primary">Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection