@extends('layout')
@section('content')
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ $service->title }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li>
                    <a href="{{ route('categories.detail', ['category' => $category->slug]) }}">{{ $category->title }}</a>
                </li>
                <li>{{ $service->title }}</li>
            </ul>
        </div>
    </div>
    <div class="service-details-wrap ptb-100">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-4 col-lg-12 col-md-12 col-12 order-xl-1 order-lg-2 order-md-2 order-2">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h3 class="sidebar-widget-title">{{ $category->title }}</h3>
                            <ul class="category-list-one list-style">
                                @foreach($category->services as $catserv)
                                    <li>
                                        <a href="{{ route('services.detail', ['category' => $category->slug, 'service' => $catserv->slug]) }}">{{ $catserv->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @include('blocks.online_approve')
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12 col-md-12 col-12  order-xl-2 order-lg-1 order-md-1 order-1">
                    <div class="service-desc">
                        <div class="single-img">
                            <img src="{{ $helper->image_url($service->image, 861, 493) }}" alt="{{ $service->title }}">
                        </div>
                        {!! $service->detail !!}
                        @if($service->data)
                            @include('blocks.faq-block', ['item' => $service->data])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="mb-0">
    <div class="bg_ash">
        @include('blocks.blogBlock')
    </div>
@endsection
