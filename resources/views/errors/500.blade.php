@extends('layouts.frontlayout')
@section('content')

<section class="errorpage">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-md-12 col-sm-12 col-12">
                <div class="eror_inner">
                    <div class="img_area">
                        <img src="{{ url('frontend/images/404.png') }}" alt="Page Not Found" class="img-fluid"/>
                    </div>
                    <div class="content">
                        <h5>
                            Sorry<br>Page not found!
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection