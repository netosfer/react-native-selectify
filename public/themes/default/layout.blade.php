<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/flaticon_zigo.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/swiper.bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset(config('app.theme_path').'/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/brands.min.css') }}">
    <title>{{ $meta && isset($meta['title']) ? $meta['title'] : $settings->site_title }}{{ isset($meta['title']) && $settings->site_title != $meta['title'] ? " - ".$settings->site_title : ''}}</title>
    <meta name="description"
          content="{{ $meta && isset($meta['description']) ? $meta['description'] : $settings->site_description }}">
    <meta name="keywords"
          content="{{ $meta && isset($meta['description']) ? $meta['description'] : $settings->site_description }}">
    <link rel="canonical" href="https://www.example.com/dr-ozlem-aras">
    <meta name="language" content="English">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ $meta && isset($meta['title']) ? $meta['title'] : $settings->site_title }}">
    <meta property="og:description"
          content="{{ $meta && isset($meta['description']) ? $meta['description'] : $settings->site_description }}">
    <meta property="og:image" content="https://www.example.com/images/og-image.jpg">
    <meta property="og:url" content="https://www.example.com/dr-ozlem-aras">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta && isset($meta['title']) ? $meta['title'] : $settings->site_title }}">
    <meta name="twitter:description"
          content="{{ $meta && isset($meta['description']) ? $meta['description'] : $settings->site_description }}">
    <meta name="twitter:image" content="https://www.example.com/images/twitter-image.jpg">
    <link rel="icon" type="image/png" href="{{ $helper->image_url($settings->favicon, 32, 32, 2) }}">
    @stack('links')
</head>
<body>
<div class="loader-wrapper">
    <div class="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<div class="navbar-area header-two" id="navbar">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ url(config('app.prefix')) }}">
                <img class="logo-light" src="{{ $helper->image_url($settings->logo, 192, 60, 2) }}" alt="logo">
            </a>
            <a class="navbar-toggler" data-bs-toggle="offcanvas" href="#navbarOffcanvas" role="button"
               aria-controls="navbarOffcanvas">
            <span class="burger-menu">
              <span class="top-bar"></span>
              <span class="middle-bar"></span>
              <span class="bottom-bar"></span>
            </span>
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ url(config('app.prefix')) }}"
                           class="nav-link{{ Route::is('sliders.index') ? ' active' : '' }}"> <i class="ri-home-line"></i>
                        </a>
                    </li>
                    <li class="nav-item"><a href="{{ route('pages.detail', ['page' => $about->slug]) }}"
                                            class="nav-link{{ Route::is('pages.detail', ['template' => 'about_us']) ? ' active' : '' }}">
                            {{ $about->title }} </a></li>
                    @foreach($categories as $category)
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                {{ $category->title }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($category->services as $service)
                                    <li class="nav-item">
                                        <a href="{{ route('services.detail', ['category' => $category->slug, 'service' => $service->slug]) }}"
                                           class="nav-link">
                                            {{ $service->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                    <li class="nav-item"><a href="{{ route('blog.index') }}"
                                            class="nav-link{{ Route::is('blog.index') ? ' active' : '' }}">
                            {{ __('frontend.blog') }} </a></li>
                    <li class="nav-item"><a href="{{ route('home.contact') }}"
                                            class="nav-link{{ Route::is('home.contact') ? ' active' : '' }}">
                            {{ __('frontend.contact_me') }} </a></li>
                </ul>
                <div class="others-option ms-4 d-flex align-items-center">
                    <div class="option-item">
                        <a href="{{ route('auth.online-appointment') }}" class="btn-header btn-two btn-sm br-ol"
                           style="float:left">{{ __('frontend.online_appointment') }}</a>
                        @if(Auth::user())
                            <a href="{{ route('auth.dashboard') }}"
                               class="btn-header btn-one btn-sm br-or">{{ __('frontend.actions') }}</a>
                        @else
                            <a href="{{ route('auth.login') }}"
                               class="btn-header btn-one btn-sm br-or">{{ __('frontend.login') }}</a>
                        @endif
                    </div>
                    <div class="option-item">
                        <div class="dropdown">
                            <button class="btn btn-text dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ $helper->image_url($helper->active_lang($languages)->flag, 35, 35) }}" width="35" class="flag"
                                     alt="">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                               @foreach($languages as $lang)
                                <li><a class="dropdown-item" href="{{ url("/".($lang->default ? '' : $lang->shortname)) }}">{{ $lang->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="responsive-navbar offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="navbarOffcanvas">
    <div class="offcanvas-header">
        <a href="{{ url(config('app.prefix')) }}" class="logo d-inline-block">
            <img class="logo-light" src="{{ $helper->image_url($settings->logo, 224, 70, 2) }}" alt="logo">
        </a>
        <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion" id="navbarAccordion">
            <div class="accordion-item">
                <a class="accordion-button active" href="{{ route('frontend.home') }}"> {{ __('frontend.home') }}</a>
            </div>
            @foreach($categories as $category)
                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapZigour" aria-expanded="false" aria-controls="collapZigour"> {{ $category->title }}
                    </button>
                    <div id="collapZigour" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordion45">
                                @foreach($category->services as $service)
                                    <div class="accordion-item">
                                        <a class="accordion-link" href="{{ route('services.detail', ['category' => $category->slug, 'service' => $service->slug]) }}"> {{ $service->title }} </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="accordion-item">
                <a class="accordion-button without-icon" href="{{ route('blog.index') }}"> {{ __('frontend.blog') }} </a>
            </div>
            <div class="accordion-item">
                <a class="accordion-button without-icon" href="{{ route('home.contact') }}"> {{ __('frontend.contact_me') }} </a>
            </div>

        </div>
        <div class="offcanvas-contact-info">
            <h4>{{ __('frontend.contact_informations') }}</h4>
            <ul class="contact-info list-style">
                <li>
                    <i class="ri-map-pin-fill"></i>
                    <p>{{ $options['contact']['contact_address'] }}</p>
                </li>
                <li>
                    <i class="ri-mail-fill"></i>
                    <a href="mailto:{{ $options['contact']['contact_email'] }}">
                        <span>{{ $options['contact']['contact_email'] }}</span>
                    </a>
                </li>
                <li>
                    <i class="ri-phone-fill"></i>
                    <a href="tel:{{ $options['contact']['contact_number'] }}">{{ $options['contact']['contact_number'] }}</a>
                </li>
            </ul>
            <ul class="social-profile list-style">
                @foreach($settings->social_links as $link)
                <li>
                    <a href="{{ $link['link'] }}" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="others-option d-flex d-lg-none align-items-center">
            <div class="option-item">
                <a href="{{ route('auth.online-appointment') }}" class="btn-two">{{ __('frontend.online_appointment') }}</a>
            </div>
        </div>
    </div>
</div>
@yield('content')

<footer class="footer-wrap">
    <div class="footer-top">
        <img src="{{ asset(config('app.theme_path').'/assets/img/footer-shape-1.webp') }}" alt="Image"
             class="footer-shape-one md-none">
        <img src="{{ asset(config('app.theme_path').'/assets/img/footer-shape-2.webp') }}" alt="Image"
             class="footer-shape-two md-none">
        <div class="container">
            <div class="row pt-100 pb-75">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <a href="{{ url(config('app.prefix')) }}" class="footer-logo">
                            <img class="logo-light" src="{{ $helper->image_url($settings->logo, 224, 70) }}"
                                 alt="{{ $settings->site_title }}">
                        </a>
                        <p class="comp-desc">{{ $settings->site_description }}</p>
                        <ul class="social-profile list-style">
                            @foreach($settings->social_links as $link)
                                <li>
                                    <a href="{{ $link['link'] }}" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="footer-widget-title">{{ __('frontend.site_links') }}</h3>
                        <ul class="footer-menu list-style">
                            <li>
                                <a href="{{ route('pages.detail', ['page' => $about->slug]) }}"> {{ __('frontend.about_me') }} </a>
                            </li>
                            <li>
                                <a href="{{ route('home.contact') }}"> {{ __('frontend.contact_me') }} </a>
                            </li>
                            <li>
                                <a href="{{ route('auth.online-appointment') }}"> {{ __('frontend.online_appointment') }} </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-2 col-lg-2 col-md-6 col-sm-6 ps-xl-4">
                    <div class="footer-widget">
                        <h3 class="footer-widget-title">{{ __('frontend.services') }}</h3>
                        <ul class="footer-menu list-style">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('categories.detail', ['category' => $category->slug]) }}">{{ $category->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 ps-xl-5">
                    <div class="footer-widget">
                        <h3 class="footer-widget-title">{{ __('frontend.contact_informations') }}</h3>
                        <ul class="contact-info list-style">
                            <li>
                    <span>
                      <i class="ri-phone-fill"></i>
                    </span>
                                <a href="tel:{{ $options['contact']['contact_number'] }}">{{ $options['contact']['contact_number'] }}</a>
                            </li>
                            <li>
                    <span>
                      <i class="ri-mail-fill"></i>
                    </span>
                                <a href="mailto:{{ $options['contact']['contact_email'] }}">
                                    {{ $options['contact']['contact_email'] }}
                                </a>
                            </li>
                            <li>
                    <span>
                      <i class="ri-map-pin-2-fill"></i>
                    </span>
                                <p>{{ $options['contact']['contact_address'] }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <p class="copyright-text text-left">
                        {!! $settings->copyright !!}
                    </p>
                </div>
                <div class="col-lg-4 col-md-4">
                    <a href="https://netosfer.net" target="_blank" class="netosfer-logo" title="Netosfer - Kurumsal Yazılım Çözümleri">
                        <img src="{{ asset(config('app.theme_path').'/assets/img/netosfer-net-logo.png') }}" alt="Netosfer - Kurumsal Yazılım Çözümleri">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<button type="button" id="backtotop" class="position-fixed text-center border-0 p-0">
    <i class="ri-arrow-up-line"></i>
</button>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Person",
  "name": "Dr. Özlem Aras",
  "jobTitle": "Gynecology Specialist",
  "url": "https://www.example.com/dr-ozlem-aras",
  "image": "https://www.example.com/images/doctor-image.jpg",
  "description": "Experienced physician specialized in gynecology, obstetrics, and infertility.",
  "sameAs": [
    "https://www.facebook.com/ozlem.aras",
    "https://www.twitter.com/ozlemaras",
    "https://www.linkedin.com/in/ozlemaras"
  ]
}


</script>
<script src="{{ asset(config('app.theme_path').'/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset(config('app.theme_path').'/assets/js/swiper.bundle.min.js') }}"></script>
<script src="{{ asset(config('app.theme_path').'/assets/js/aos.js') }}"></script>
@stack('footer')
<script src="{{ asset(config('app.theme_path').'/assets/js/main.js') }}"></script>
</body>
</html>
