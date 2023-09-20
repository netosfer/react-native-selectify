<div class="hero-wrap hero-two">
    <img src="{{ asset(config('app.theme_path').'/assets/img/hero/hero-shape-3.webp') }}" alt="Image"
         class="hero-shape-one moveHorizontal md-none">
    <img src="{{ asset(config('app.theme_path').'/assets/img/hero/hero-shape-4.webp') }}" alt="Image"
         class="hero-shape-two moveHorizontal md-none">
    <div class="hero-slider swiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="hero-item">
                        <div class="container">
                            <div class="row gx-5 align-items-center">
                                <div class="col-lg-6">
                                    <div class="hero-content">
                                        <span data-aos="fade-up" data-aos-duration="1200"
                                              data-aos-delay="200">{{ $slider->short_title }} </span>
                                        <h1 data-aos="fade-up" data-aos-duration="1200"
                                            data-aos-delay="300">{{ $slider->title }}
                                        </h1>
                                        @if($slider->link)
                                            <a href="{{ $slider->link }}" class="btn-one" data-aos="fade-up"
                                               data-aos-duration="1200"
                                               data-aos-delay="500">{{ __('frontend.detailed_info') }}</a>
                                        @endif
                                        <div class="hero-doc-card" data-aos="fade-left" data-aos-duration="1200"
                                             data-aos-delay="200">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="doc-img">
                                                        <img
                                                            src="{{ (new MainHelper())->image_url($options['homepage']['infobox_avatar'], 72, 72) }}"
                                                            alt="Image">
                                                        <span class="online-status"></span>
                                                    </div>
                                                    <div class="doc-info">
                                                        <h3>{{ $options['homepage'][config('app.locale')]['infobox_name'] }}</h3>
                                                        <span>{{ $options['homepage'][config('app.locale')]['infobox_title'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 text-md-end">
                                                    <a href="{{ route('auth.online-appointment') }}" class="btn-three"
                                                       style="font-size: 13px">{{ __('frontend.online_appointment') }}</a>
                                                    <div class="ratings">
                                                        <ul class="rating list-style">
                                                            <li><i class="ri-star-fill"></i></li>
                                                            <li><i class="ri-star-fill"></i></li>
                                                            <li><i class="ri-star-fill"></i></li>
                                                            <li><i class="ri-star-fill"></i></li>
                                                            <li><i class="ri-star-fill"></i></li>
                                                        </ul>
                                                        <span><small>({{ $options['homepage'][config('app.locale')]['infobox_review_count'] }} {{ __('frontend.reviews') }})</small></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="hero-img-wrap">
                                        <img src="{{ $helper->image_url($slider->image, 740, 740) }}"
                                             alt="{{ $slider->short_title }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="hero-pagination"></div>

    </div>
</div>
