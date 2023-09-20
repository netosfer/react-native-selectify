<div class="service-wrap ptb-100 bg_ash ">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xxl-2 col-xl-3 col-lg-3" data-aos="fade-right" data-aos-duration="1200"
                 data-aos-delay="200">
                <div class="service-content">
                    <div class="content-title-one">
                        <span>{{ __('frontend.my_services_subtitle') }}</span>
                        <h2>{{ __('frontend.my_services') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-10 col-xl-9 col-lg-9">
                <div class="swiper service-slider-one">
                    <div class="swiper-wrapper">
                        @foreach($categories as $service)
                        <div class="swiper-slide">
                            <div class="service-card-one bg-white">
                                <div class="service-img">
                                    <a href="{{ route('categories.detail', ['category' => $service->slug]) }}"><img src="{{ $helper->image_url($service->image, 600, 400) }}" alt="{{ $service->title }}"></a>
                                </div>
                                <div class="service-info">
                                    <h3>
                                        <a href="{{ route('categories.detail', ['category' => $service->slug]) }}">{{ $service->title }}</a>
                                    </h3>
                                    <p style="height: 52px">{{ \Str::limit($service->description, 80) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
