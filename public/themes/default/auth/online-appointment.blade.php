@extends('layout')
@section('content')
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ __('frontend.user_actions') }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li>{{ __('frontend.user_actions') }}</li>
            </ul>
        </div>
    </div>
    <div class="blog-wrap-two ptb-100">
        <div class="container">
            <div class="row gx-5">
                <div class="col-xl-4 col-lg-12 col-md-12 col-12 order-xl-1 order-lg-2 order-md-2 order-2">
                    @include('auth.sidebar')
                </div>
                <div class="col-xl-8 col-lg-12 col-md-12 col-12  order-xl-2 order-lg-1 order-md-1 order-1">
                    <div class="card">
                        <h2 class="card-header h-font text-secondary">
                            {{ __('frontend.online_appointment') }}
                        </h2>
                        <form action="{{ route('auth.make-appointment') }}" method="post">
                            <div class="card-body">
                                {{ csrf_field() }}
                                <div class="form-group mb-4">
                                    <label for="service">{{ __('appointments.select_appointment_service') }}</label>
                                    <select name="service" id="service" class="form-control" required>
                                        <option value="">{{ __('appointments.choose') }}</option>
                                        @foreach($categories as $category)
                                            <optgroup label="{{ $category->title }}">
                                                @foreach($category->services as $service)
                                                    <option
                                                        value="{{ $service->uniq_key }}">{{ $service->title }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                        <option
                                            value="{{ __('appointments.other') }}">{{ __('appointments.other') }}</option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="appointment_date">{{ __('appointments.appointment_date') }}</label>
                                    <input type="date" class="form-control" name="appointment_date"
                                           id="appointment_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="appointment_time">{{ __('appointments.appointment_time') }}</label>
                                    <select name="appointment_time" id="appointment_time" class="form-control" disabled
                                            title="Lütfen önce randevu tarihi seçin" required>
                                        <option value="">{{ __('appointments.choose') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-success">Randevu Oluştur</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer')
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script>
        var _token = '{{ csrf_token() }}';
        $(document).ready(function () {
            $('#appointment_date').change(function () {
                var elm = $(this);
                var date = elm.val();
                $('#appointment_time').html('<option value="">{{ __('appointments.choose') }}</option>');
                $('#appointment_time').prop('disabled', false);
                $.post('{{ route('appointment.hours') }}', {date: date, _token: _token}, function (response) {
                    if (response.length > 0) {
                        $.each(response, function (i, item) {
                            $('#appointment_time').append('<option value="' + item + '">' + item + '</option>')
                        })
                    } else {
                        $('#appointment_time').html('')
                        $('#appointment_time').prop('disabled', true);
                        $('#appointment_time').append('<option value="">{{ __('appointments.no_available_appointment') }}</option>')
                    }

                });
            })
        })
    </script>
@endpush
