@extends('layout')
@section('content')
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ $category->title }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li>{{ $category->title }}</li>
            </ul>
        </div>
    </div>
    <div class="ptb-100">
        <div class="container">
            <div class="row gx-5">
                @foreach($category->services as $service)
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6" data-aos="fade-up" data-aos-duration="1200"
                         data-aos-delay="200">
                        <div class="service-card-two">
                      <span class="service-icon">
                        <a href="{{ route('services.detail', ['category' => $category->slug, 'service' => $service->slug]) }}"><img src="{{ $helper->image_url($service->image, 600, 400) }}" alt="{{ $service->title }}"></a>
                      </span>
                            <div class="service-info">
                                <h3>
                                    <a href="{{ route('services.detail', ['category' => $category->slug, 'service' => $service->slug]) }}">{{ $service->title }}</a>
                                </h3>
                                <a href="{{ route('services.detail', ['category' => $category->slug, 'service' => $service->slug]) }}" class="link-two">Detaylı Bilgi</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
