@extends('layout')
@section('content')
    <div class="error-wrap ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="error-content">
                        <img src="{{ asset(config('app.theme_path')."/assets/img/page-404.png") }}" alt="Iamge">
                        <h2>Sayfa Bulunamadı</h2>
                        <p>Aradığınız sayfa değiştirilmiş ya da kaldırılmış olabilir.</p>
                        <a href="{{ url(config('app.prefix')) }}" class="btn-one">Anasayfaya Dönün</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @include('blocks.servicesBlock')
@endsection
