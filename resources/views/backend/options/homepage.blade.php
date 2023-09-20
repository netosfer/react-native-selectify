@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('homepage.homepage_options') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('homepage.homepage_options') }}</li>
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
                            action="{{ route('admin.options.save', ["key" => 'homepage', 'format' => 'json']) }}"
                            method="post">
                            {{ csrf_field() }}
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        @foreach($languages as $key => $lang)
                                            <li class="nav-item">
                                                <a class="nav-link{{ $key == 0 ? ' active' : '' }}"
                                                   id="{{ $lang->shortname }}_lang_tab" data-toggle="pill"
                                                   href="#{{ $lang->shortname }}_lang" role="tab"
                                                   aria-controls="{{ $lang->shortname }}_lang"
                                                   aria-selected="true">{{ $lang->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                @foreach($languages as $key => $lang)
                                    <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}"
                                         id="{{ $lang->shortname }}_lang" role="tabpanel"
                                         aria-labelledby="{{ $lang->shortname }}_lang_tab">
                                        <div class="card">
                                            <div class="card-header">Bilgi Kartı Ayarları</div>
                                            <div class="card-body">
                                                <div class="pl-3 pr-3 pt-1 pb-1">@if($lang->default)
                                                        {!! MainHelper::FileManager('options[infobox_avatar]', isset($options) && $options && isset($options['infobox_avatar']) ? $options['infobox_avatar'] : null, __('homepage.infobox_avatar')) !!}
                                                    @endif</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('options['.$lang->shortname.'][infobox_name]', __('homepage.infobox_name'))->value(isset($options) && $options  && isset($options[$lang->shortname]['infobox_name']) ? $options[$lang->shortname]['infobox_name'] : null)->required() !!}</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('options['.$lang->shortname.'][infobox_title]', __('homepage.infobox_title'))->value(isset($options) && $options  && isset($options[$lang->shortname]['infobox_title']) ? $options[$lang->shortname]['infobox_title'] : null)->required() !!}</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('options['.$lang->shortname.'][infobox_review_count]', __('homepage.infobox_review_count'))->value(isset($options) && $options  && isset($options[$lang->shortname]['infobox_review_count']) ? $options[$lang->shortname]['infobox_review_count'] : null) !!}</div>

                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">Hakkımızda Kısmı Ayarları</div>
                                            <div class="card-body">

                                                <div class="pl-3 pr-3 pt-1 pb-1">@if($lang->default)
                                                        {!! MainHelper::FileManager('options[about_image]', isset($options) && $options && isset($options['about_image']) ? $options['about_image'] : null, __('homepage.about_image')) !!}
                                                    @endif</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('options['.$lang->shortname.'][about_top_title]', __('homepage.about_top_title'))->value(isset($options) && $options  && isset($options[$lang->shortname]['about_top_title']) ? $options[$lang->shortname]['about_top_title'] : null)->required() !!}</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('options['.$lang->shortname.'][about_main_title]', __('homepage.about_main_title'))->value(isset($options) && $options  && isset($options[$lang->shortname]['about_main_title']) ? $options[$lang->shortname]['about_main_title'] : null)->required() !!}</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('options['.$lang->shortname.'][about_description]', __('homepage.about_description'))->value(isset($options) && $options  && isset($options[$lang->shortname]['about_description']) ? $options[$lang->shortname]['about_description'] : null)->attrs(['class' => 'editor'])->required() !!}</div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                            </div>

                            <div class="card-footer" style="border-top:1px solid #dedede;">
                                <button type="submit" class="btn btn-success float-right"
                                        href="{{ route('blogs.add') }}"><i
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
        $(document).ready(function(){
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
