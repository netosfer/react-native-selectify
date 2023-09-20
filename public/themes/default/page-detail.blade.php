@extends('layout')
@section('content')
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ $page->title }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li>{{ $page->title }}</li>
            </ul>
        </div>
    </div>
    <div class=" pt-100"
         style="background:linear-gradient(-45deg, #e0e0e0 20%,#FFFFFF 70%)">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-10 offset-lg-1">
                    <div class="service-desc">
                        <img src="{{ asset(config('app.theme_path').'/assets/img/ozlemaras-profile.png') }}"
                             alt="{{ $page->title }}" width="400" class="float-end ms-4">
                        <div class="about-content">
                            <div class="content-title-one">
                                <span>{{ $options['homepage'][config('app.locale')]['about_top_title'] }}</span>
                                <h2 class="mb-5">{{ $options['homepage'][config('app.locale')]['about_main_title'] }}</h2>
                            </div>
                        </div>
                        {!!  explode('<hr>', $page->detail)[0]  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('blocks.servicesBlock')
@endsection
