<div class="about-wrap-two pb-100 pt-100">
    <img src="{{ asset(config('app.theme_path').'/assets/img/about/about-shape-4.webp') }}" alt="Image"
         class="about-shape-one md-none">
    <div class="container">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="200">
                <div class="about-img-wrap">
                    <img src="{{ (new MainHelper())->image_url($options['homepage']['about_image'], 705, 543) }}"
                         alt="Image">
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                <div class="about-content">
                    <div class="content-title-one">
                        <span>{{ $options['homepage'][config('app.locale')]['about_top_title'] }}</span>
                        <h2 class="mb-5">{{ $options['homepage'][config('app.locale')]['about_main_title'] }}</h2>
                        <p class="mt-4">{!! $options['homepage'][config('app.locale')]['about_description'] !!}</p>
                    </div>
                    <a href="{{ route('pages.detail', ['page' => $about->slug]) }}" class="btn-one mt-4">{{ __('frontend.detailed_info') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
