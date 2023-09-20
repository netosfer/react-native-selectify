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
                            {{ __('frontend.my_appointments') }}

                        </h2>
                        <div class="card-body p-0">
                            @if(count($appointments) > 0)
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>Hizmet</th>
                                        <th width="200">Tarih</th>
                                        <th width="200">Durum</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($appointments as $appointment)
                                        @php
                                            $status = [];
                                            if($appointment->approve){
                                                if($appointment->completed){
                                                    $status = ['class' => 'success', 'text' => __('frontend.completed')];
                                                } elseif((new DateTime($appointment->appointment_date." ".$appointment->appointment_time)) > date('Y-m-d H:i')){
                                                    $status = ['class' => 'danger', 'text' => __('frontend.appointment_expired')];
                                                }
                                            } elseif((new DateTime($appointment->appointment_date." ".$appointment->appointment_time)) > date('Y-m-d H:i')){
                                                $status = ['class' => 'danger', 'text' => __('frontend.appointment_expired')];
                                            } else {
                                                 $status = ['class' => 'warning', 'text' => __('frontend.appointment_pending')];
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $appointment->services ? $appointment->services->title : 'Diğer' }}</td>
                                            <td>{{ (new DateTime($appointment->appointment_date))->format('d.m.Y') }}
                                                - {{ $appointment->appointment_time }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $status['class'] }}">{{ $status['text'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center p-4">
                                    <h5 class="text-danger h-font p-3">Hiç randevu oluşturmadınız</h5>
                                    <a href="" class="btn-two">Yeni Randevu</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
