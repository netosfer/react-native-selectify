@extends('layout')
@section('content')
    <div class="breadcrumb-wrap">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-1.webp') }}" alt="Image"
             class="br-shape-one moveHorizontal">
        <img src="{{ asset(config('app.theme_path').'/assets/img/br-shape-2.webp') }}" alt="Image"
             class="br-shape-two animationFramesTwo">
        <div class="breadcrumb-content">
            <h2>{{ __('frontend.personal_informations') }}</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="{{ url(config('app.prefix')) }}">{{ __('frontend.home') }}</a></li>
                <li>{{ __('frontend.personal_informations') }}</li>
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
                            {{ __('frontend.personal_informations') }}
                        </h2>
                        <div class="card-body">
                            <form action="{{ route('auth.update-informations') }}" method="post">
                                {{ csrf_field() }}
                                {!! Form::text('name', __('frontend.name'))->value(Auth::user()->name)->attrs(['class' => 'mb-4'])->required() !!}
                                {!! Form::text('phone_number', __('frontend.phone_number'))->value(Auth::user()->phone_number)->attrs(['class' => 'mb-4'])->required() !!}
                                {!! Form::text('email_address', __('frontend.email_address'))->value(Auth::user()->email)->required() !!}
                                <button class="btn btn-success mt-4"><i class="fa fa-save"></i> {{ __('frontend.save_changes') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <h2 class="card-header h-font text-secondary">
                            {{ __('frontend.change_password') }}
                        </h2>
                        <div class="card-body">
                            <div class="alert alert-warning p-1">
                                <small>Bu alanı, yalnızca şifre yenileme işlemi için kullanın.</small>
                            </div>
                            <form action="{{ route('auth.update-informations') }}" method="post">
                                {{ csrf_field() }}
                                {!! Form::text('password', __('frontend.password'))->attrs(['class' => 'mb-4'])->type('password')->required() !!}
                                {!! Form::text('confirm_password', __('frontend.confirm_password'))->attrs(['class' => 'mb-4'])->type('password')->required() !!}
                                <button class="btn btn-success"><i class="fa fa-save"></i> {{ __('frontend.save_changes') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
