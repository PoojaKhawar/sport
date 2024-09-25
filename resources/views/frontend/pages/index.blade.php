@extends('layouts.frontlayout')

@section('content')

<section class="page-section mt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="page-detail pb-0">
                    <div class="img-area mb-4">
                        <img src="{{General::renderImage(FileSystem::getAllSizeImages($page['image']), 'large')}}" alt="{{ $page['title'] ?? ''}}" class="img-fluid" />
                    </div>
                    <h1 class="mt-3">{{ $page['title'] ?? ''}}</h1>
                    <p class="mt-2">{!! $page['description'] ?? '' !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
