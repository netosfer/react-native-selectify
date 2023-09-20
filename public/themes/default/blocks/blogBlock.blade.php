<div class="pt-100 pb-75">
    <div class="container">
        <div class="row align-items-end mb-30">
            <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8">
                <div class="section-title-one">
                    <span>Blog</span>
                    <h2>{{ __('frontend.blog_main_title') }}</h2>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-6 col-lg-5 col-md-4 text-md-end sm-none">
                <a href="{{ route('blog.index') }}" class="btn-one">{{ __('frontend.all_blogs') }}</a>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($blogs as $blog)
                <div class="col-xl-4 col-lg-6 col-md-6" data-aos="fade-up" data-aos-duration="1200"
                     data-aos-delay="200">
                    <div class="blog-card-two">
                        <div class="blog-card-img">
                            <a href="{{ route('blog.detail', ['detail' => $blog->slug]) }}"><img src="{{ $helper->image_url($blog->image, 320, 213) }}" alt="{{ $blog->title }}"></a>
                            <a href="{{ route('blog.detail', ['detail' => $blog->slug]) }}" class="blog-date">
                                <span>{{ (new DateTime($blog->created_at))->format('d') }}</span>{{ (new DateTime($blog->created_at))->format('F') }} </a>
                        </div>
                        <div class="blog-card-info">
                            <h3>
                                <a href="{{ route('blog.detail', ['detail' => $blog->slug]) }}">{{ $blog->title }}</a>
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center d-md-none">
            <a href="{{ route('blog.index') }}" class="btn-one">{{ __('frontend.all_blogs') }}</a>
        </div>
    </div>
</div>
