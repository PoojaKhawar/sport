@extends('layouts.frontlayout')

@section('content')

<section class="error-section mt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="error-detail pb-0">
                    <div class="img-area mb-4">
                        <img src="{{ url('frontend/images/404.png') }}" alt="Page Not Found" class="img-fluid" />
                    </div>
                    <h1 class="mt-3">Oops! Page Not Found</h1>
                    <p class="mt-2">Sorry, the page you are looking for does not exist.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-5 mb-5">Go to Homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
