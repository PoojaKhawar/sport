@extends('layouts.frontlayout')
@section('content')

<section class="succuess_section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="succes">
                    <div class="row">
                        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12 m-auto text-center"> 
                            <div class="succes_inner text-center">
                                <div class="sign">
                                    <i class="far fa-check"></i>
                                </div>
                                <div class="dspt">
                                    <h5>
                                        Success
                                    </h5>
                                    @if(@$_GET['message'])
                                    <p>{{ $_GET['message'] }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('user.login') }}" class="btn btn-primary-1"><i class="fal fa-long-arrow-left me-2"></i>Go to Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection