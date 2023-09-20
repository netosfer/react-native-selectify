@extends('layout')
@section('content')
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ $blog->title }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li><a href="{{ url(config('app.prefix'))."/blog" }}">{{ __('frontend.blog') }}</a></li>
                <li>{{ $blog->title }}</li>
            </ul>
        </div>
    </div>
    <div class="ptb-100">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-8">
                    <article>
                        <div class="post-img">
                            <img src="{{ $helper->image_url($blog->image, 861, 483) }}" alt="{{ $blog->title }}">
                        </div>
                        <div class="blog-title">
                            <a href="posts-by-date.html"
                               class="blog-date"><span>{{ (new DateTime($blog->created_at))->format('d') }}</span>{{ (new DateTime($blog->created_at))->format('F') }}
                            </a>
                            <h2>{{ $blog->title }}</h2>
                        </div>
                        <div class="post-para">
                            {!! $blog->content !!}
                        </div>
                    </article>
                    @if($blog->data)
                        @include('blocks.faq-block', ['item' => $blog->data])
                    @endif
                    <div class="post-meta-option">
                        <div class="row gx-0 align-items-center">
                            <div class="col-md-7 col-12">
                                <div class="post-tag">
                                    <span>{{ __('blogs.tags') }} : </span>
                                    <ul class="tag-list-two list-style">
                                        @foreach(explode(',', $blog->tags) as $tag)
                                            <li><a href="projects.html"
                                                   class="badge bg-secondary text-white">{{ trim($tag) }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-5 col-12 text-md-end text-start">
                                <div class="post-share w-100">
                                    <span>Share</span>
                                    <ul class="social-profile list-style">
                                        <li>
                                            <a href="https://facebook.com/">
                                                <i class="ri-facebook-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/">
                                                <i class="ri-twitter-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://linkedin.com/">
                                                <i class="ri-linkedin-fill"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://instagram.com/">
                                                <i class="ri-instagram-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="sidebar position-sticky">
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
