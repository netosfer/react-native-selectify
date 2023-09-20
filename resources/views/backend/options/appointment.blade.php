@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('appointments.appointment_options') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('appointments.appointment_options') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form
                            action="{{ route('admin.options.save', ["key" => 'appointment_hours', 'format' => 'json']) }}"
                            method="post">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">Randevu Saatleri</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="pazar">Pazar</label>
                                        <select name="options[Pazar][]" id="pazar" class="form-control select2"
                                                multiple>
                                            <option value="">Seçim Yapın</option>
                                            @foreach($hours as $hour)
                                                <option
                                                    value="{{ $hour }}"{{ isset($options['Pazar']) && in_array($hour, $options['Pazar']) ? ' selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="pazartesi">Pazartesi</label>
                                        <select name="options[Pazartesi][]" id="pazartesi" class="form-control select2"
                                                multiple>
                                            <option value="">Seçim Yapın</option>
                                            @foreach($hours as $hour)
                                                <option
                                                    value="{{ $hour }}"{{ isset($options['Pazartesi']) && in_array($hour, $options['Pazartesi']) ? ' selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="sali">Salı</label>
                                        <select name="options[Salı][]" id="sali" class="form-control select2" multiple>
                                            <option value="">Seçim Yapın</option>
                                            @foreach($hours as $hour)
                                                <option
                                                    value="{{ $hour }}"{{ isset($options['Salı']) && in_array($hour, $options['Salı']) ? ' selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="carsamba">Çarşamba</label>
                                        <select name="options[Çarşamba][]" id="carsamba" class="form-control select2"
                                                multiple>
                                            <option value="">Seçim Yapın</option>
                                            @foreach($hours as $hour)
                                                <option
                                                    value="{{ $hour }}"{{ isset($options['Çarşamba']) && in_array($hour, $options['Çarşamba']) ? ' selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="persembe">Perşembe</label>
                                        <select name="options[Perşembe][]" id="persembe" class="form-control select2"
                                                multiple>
                                            <option value="">Seçim Yapın</option>
                                            @foreach($hours as $hour)
                                                <option
                                                    value="{{ $hour }}"{{ isset($options['Perşembe']) && in_array($hour, $options['Perşembe']) ? ' selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cuma">Cuma</label>
                                        <select name="options[Cuma][]" id="cuma" class="form-control select2" multiple>
                                            <option value="">Seçim Yapın</option>
                                            @foreach($hours as $hour)
                                                <option
                                                    value="{{ $hour }}"{{ isset($options['Cuma']) && in_array($hour, $options['Cuma']) ? ' selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cumartesi">Cumartesi</label>
                                        <select name="options[Cumartesi][]" id="cumartesi" class="form-control select2"
                                                multiple>
                                            <option value="">Seçim Yapın</option>
                                            @foreach($hours as $hour)
                                                <option
                                                    value="{{ $hour }}"{{ isset($options['Cumartesi']) && in_array($hour, $options['Cumartesi']) ? ' selected' : '' }}>{{ $hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer" style="border-top:1px solid #dedede;">
                                    <button type="submit" class="btn btn-success float-right"><i
                                            class="icon-paper-plane"></i> {{ __('global.save_changes') }}</button>
                                </div>
                            </div>
                        </form>
                        <form
                            action="{{ route('admin.options.save-closed-hours') }}"
                            method="post" id="closed-hours-form">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">Randevuları Engelle <a href="javascript:;"
                                                                                class="float-right add-hour"><i
                                            class="fa-solid fa-plus"></i> Ekle</a></div>
                                <div class="card-body">
                                    <div class="hours">
                                        <div class="row hour-item d-none" data-id="1">
                                            <div class="col-lg-4 col-md-4">
                                                {!! Form::text('options[1][close_date]', __('appointments.close_date'))->type('date') !!}
                                            </div>
                                            <div class="col-lg-8 col-md-8">
                                                <div class="form-group">
                                                    <label>{{ __('appointments.close_hours') }}</label>
                                                    <select name="options[1][close_hours][]" class="form-control"
                                                            multiple>
                                                        @foreach($hours as $hour)
                                                            <option
                                                                value="{{ $hour }}"{{ isset($options['Cumartesi']) && in_array($hour, $options['Cumartesi']) ? ' selected' : '' }}>{{ $hour }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach($closed_hours as $ky => $chours)
                                            <div class="row hour-item">
                                                <div class="col-lg-4 col-md-4">
                                                    {!! Form::text('options['.$i.'][close_date]', __('appointments.close_date'))->type('date')->value($ky) !!}
                                                </div>
                                                <div class="col-lg-8 col-md-8">
                                                    <div class="form-group">
                                                        <label>{{ __('appointments.close_hours') }}</label>
                                                        <select name="options[{{ $i }}][close_hours][]"
                                                                class="form-control select2"
                                                                multiple>
                                                            @foreach($hours as $hour)
                                                                <option
                                                                    value="{{ $hour }}"{{ in_array($hour, $chours) ? ' selected' : '' }}>{{ $hour }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer" style="border-top:1px solid #dedede;">
                                    <button type="submit" class="btn btn-success float-right"><i
                                            class="icon-paper-plane"></i> {{ __('global.save_changes') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('links')
    <link rel="stylesheet" href="{{ asset('/') }}back/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}back/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@push('scripts')
    <script src="{{ asset('/') }}back/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4'
        })
        @if (session()->has('flash_notification.message'))
        $(document).ready(function () {
            $(document).Toasts('create', {
                class: 'bg-{{ session()->get('flash_notification.level') }} w-250',
                title: 'Information about the last process',
                autohide: true,
                delay: 4000,
                body: '{!! session()->get('flash_notification.message') !!}'
            })
        });
        @endif
        $(document).ready(function(){
            $('.add-hour').click(function(){
                var elm = $(this);
                var item = $('.hours').find('.hour-item').first().clone();
                var index = parseInt(item.attr('data-id'));
                item.find('.form-control').each(function(){
                    var inp = $(this);
                    var name = inp.attr('name');
                    var new_name = name.replace('options[1]', 'options['+(index)+']');
                    inp.attr('name', new_name)
                    inp.attr('id', new_name)
                    inp.parents('label').attr('for', new_name)
                })
                item.attr('data-id', (index + 1));
                $('.hours').find('.hour-item').first().attr('data-id', (index + 1));
                item.find('.form-control').val('');
                item.find('select.form-control').addClass('select2');
                item.find('.select2').val('')
                item.removeClass('d-none')
                $('.hours').append(item);
                $('.select2').select2({
                    theme: 'bootstrap4'
                })
            })
            $('#closed-hours-form').submit(function(){
                var elm = $(this);
                elm.find('.hour-item.d-none').remove();
            })
        })
    </script>
@endpush
