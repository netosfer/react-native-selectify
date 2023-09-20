@extends('layout')
@section('content')
    @php
        $contact = $options['contact'];
    @endphp
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ __('frontend.contact_me') }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li>{{ __('frontend.contact_me') }}</li>
            </ul>
        </div>
    </div>
    <div class="pt-100">
        <div class="container">
            <div class="row gx-5 pb-75">
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="contact-item-wrap">
                        <div class="contact-item">
<span class="contact-icon">
<i class="ri-phone-fill"></i>
</span>
                            <div class="contact-info">
                                <h3>{{ __('contact.contact_number') }}</h3>
                                <a href="tel:$contact['contact_number']">{{ $contact['contact_number'] }}</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">
                             <i class="ri-mail-fill"></i>
                            </span>
                            <div class="contact-info">
                                <h3>{{ __('contact.contact_email') }}</h3>
                                <a href="mailto:{{ $contact['contact_email'] }}">{{ $contact['contact_email'] }}</a>
                            </div>
                        </div>
                        <div class="contact-item">
<span class="contact-icon">
<i class="ri-map-pin-fill"></i>
</span>
                            <div class="contact-info">
                                <h3>{{ __('contact.contact_address') }}</h3>
                                <p>{{ $contact['contact_address'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-12">
                    <div class="section-title-one  mb-30">
                        <span>{{ __('frontend.have_a_question') }}</span>
                        <h2>{{ __('frontend.reach_me') }}</h2>
                    </div>
                    <form class="form-wrap" id="contactForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" placeholder="{{ __('frontend.name') }}" required=""
                                           data-error="{{ __('frontend.required_area') }}">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" placeholder="{{ __('frontend.email_address') }}" required=""
                                           data-error="{{ __('frontend.required_area') }}">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="number" name="phone" id="phone" placeholder="{{ __('frontend.phone_number') }}" required=""
                                           data-error="{{ __('frontend.required_area') }}">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="msg_subject" id="msg_subject" placeholder="{{ __('frontend.subject') }}"
                                           data-error="{{ __('frontend.required_area') }}">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" cols="30" rows="10"
                                              placeholder="{{ __('frontend.message') }}" required=""
                                              data-error="{{ __('frontend.required_area') }}"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-one d-block w-100">{{ __('frontend.send_message') }}</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="comp-map-area">
        <div class="container">
            <div class="comp-map" style="border-radius: 10px; overflow: hidden; border: 1px solid #dedede">
                {!! $contact['contact_map'] !!}
            </div>
        </div>
    </div>
@endsection
