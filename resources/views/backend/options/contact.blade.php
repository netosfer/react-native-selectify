@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('contact.contact_options') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('contact.contact_options') }}</li>
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
                            action="{{ route('admin.options.save', ["key" => 'contact', 'format' => 'json']) }}"
                            method="post">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-body">
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('options[contact_number]', __('contact.contact_number'))->value(isset($options) && $options  && isset($options['contact_number']) ? $options['contact_number'] : null)->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('options[contact_email]', __('contact.contact_email'))->value(isset($options) && $options  && isset($options['contact_email']) ? $options['contact_email'] : null)->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('options[contact_address]', __('contact.contact_address'))->value(isset($options) && $options  && isset($options['contact_address']) ? $options['contact_address'] : null) !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('options[contact_map]', __('contact.contact_map'))->value(isset($options) && $options  && isset($options['contact_map']) ? $options['contact_map'] : null) !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('options[contact_sendmail]', __('contact.contact_sendmail'))->value(isset($options) && $options  && isset($options['contact_sendmail']) ? $options['contact_sendmail'] : null)->required() !!}</div>

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
    </script>
@endpush
