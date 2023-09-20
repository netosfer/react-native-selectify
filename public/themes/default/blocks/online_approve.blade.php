<div class="sidebar-widget contact-widget">
    <div class="contact-item">
        <img src="{{ asset(config('app.theme_path').'/assets/img/icons/phone.svg') }}" alt="Image">
        <h4>{{ __('frontend.contact_me') }}</h4>
        <a href="tel:{{ $options['contact']['contact_number'] }}">{{ $options['contact']['contact_number'] }}</a>
    </div>
    <p><b class="text-white">{{ __('contact.contact_address') }} : </b>{{ $options['contact']['contact_address'] }} </p>
    <a href="{{ route('auth.online-appointment') }}" class="btn-one d-block w-100">{{ __('frontend.online_appointment') }}</a>
</div>
