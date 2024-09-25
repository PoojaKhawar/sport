@extends('layouts.frontlayout')
@section('content')

@if(!empty($data['clear_air']))
    @include('frontend.home.banner')
@endif

@if(!empty($data['service_content']))
    @include('frontend.home.services')
@endif

@if(!empty($data['secure_future']))
    @include('frontend.home.aim')
@endif

@if(!empty($testimonials) && count($testimonials) > 0)
    @include('frontend.home.testimonials')
@endif

@include('frontend.home.contactUs')

@if(!empty($faq) && count($faq) >0)
    @include('frontend.home.faq')
@endif

@endsection