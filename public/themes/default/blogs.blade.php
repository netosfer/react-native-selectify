@extends('layout')
@section('content')
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ __('frontend.blog') }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li>{{ __('frontend.blog') }}</li>
            </ul>
        </div>
    </div>
    <div class="ptb-100">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-8">
                    <div class="row justify-content-center">
                        @if(count($blogs) > 0)
                            @foreach($blogs as $blog)
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="blog-card-one">
                                        <div class="blog-card-img">
                                            <a href="{{ route('blog.detail', ['detail' => $blog->slug]) }}">
                                                <img src="{{ $helper->image_url($blog->image, 418, 326) }}"
                                                     alt="{{ $blog->title }}">
                                            </a>
                                        </div>
                                        <div class="blog-card-info">
                                            <div class="blog-title">
                                                <a href="{{ route('blog.detail', ['detail' => $blog->slug]) }}"
                                                   class="blog-date"><span>{{ (new DateTime($blog->created_at))->format('d') }}</span>{{ (new DateTime($blog->created_at))->format('F') }}
                                                </a>
                                                <h3>
                                                    <a href="{{ route('blog.detail', ['detail' => $blog->slug]) }}">{{ $blog->title }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                                <h2 class="h-font">{{ __('blogs.no_content_found') }}</h2>
                        @endif
                    </div>
                    {!! $blogs->links() !!}
                </div>
                <div class="col-xl-4">
                    <div class="sidebar">
                        <form action="{{ route('blog.index') }}" class="sidebar-widget search-box">
                            <input type="search" name="perm" placeholder="{{ __('blogs.search') }}">
                            <button type="submit">
                                <i class="ri-search-line"></i>
                            </button>
                        </form>
                        <div class="sidebar-widget">
                            <h3 class="sidebar-widget-title">{{ __('blogs.latest_posts') }}</h3>
                            <div class="popular-post-widget">
                                @foreach($latest_posts as $post)
                                    <div class="pp-post-item">
                                        <a href="{{ route('blog.detail', ['detail' => $post->slug]) }}"
                                           class="pp-post-img">
                                            <img src="{{ $helper->image_url($post->image, 85, 91) }}"
                                                 alt="{{ $post->title }}">
                                        </a>
                                        <div class="pp-post-info">
                                            <span>{{ (new DateTime($post->created_at))->format('d.m.Y') }}</span>
                                            <h6>
                                                <a href="{{ route('blog.detail', ['detail' => $post->slug]) }}">
                                                    {{ $post->title }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <h3 class="sidebar-widget-title">{{ __('services.module_title') }}</h3>
                            <ul class="category-list-one list-style">
                                @foreach($categories as $category)
                                    <li><a href="{{ route('categories.detail', ['category' => $category->slug]) }}">
                                            <ion-icon
                                                name="arrow-forward-circle-outline"></ion-icon>{{ $category->title }}
                                        </a></li>
                                @endforeach
                            </ul>
                        </div>
                        @include('blocks.online_approve')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
