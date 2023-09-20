@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ isset($setting) ? __('settings.edit_setting') : __('settings.add_setting') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('settings.index') }}">{{ __('settings.module_title') }}</a></li>
                            <li class="breadcrumb-item active">{{ isset($setting) ? __('settings.edit_setting') : __('settings.add_setting') }}</li>
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
                            action="{{ isset($setting) && $setting ? route('settings.edit.post', ["uniq_key" => $uniq_key]) : route('settings.add') }}"
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
                                        @if($lang->default)
                                            <div class="card">
                                                <div class="card-header">{{ __('settings.site_images') }}</div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div
                                                            class="col-lg-3 pb-1">{!! MainHelper::FileManager('logo', isset($setting) && $setting && isset($setting[$lang->shortname]) ? $setting[$lang->shortname]->logo : null, 'Logo') !!}</div>
                                                        <div
                                                            class="col-lg-3 pb-1">{!! MainHelper::FileManager('footer_logo', isset($setting) && $setting && isset($setting[$lang->shortname]) ? $setting[$lang->shortname]->footer_logo : null, 'Footer Logo') !!}</div>
                                                        <div
                                                            class="col-lg-3 pb-1">{!! MainHelper::FileManager('favicon', isset($setting) && $setting && isset($setting[$lang->shortname]) ? $setting[$lang->shortname]->favicon : null, 'Favicon') !!}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="card">
                                            <a class="card-header text-muted" href="#site_information_card"
                                               data-toggle="collapse">{{ __('settings.site_informations') }}</a>
                                            <div class="card-body collapse show" id="site_information_card">
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('site_title['.$lang->shortname.']', __('settings.site_title'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) ? $setting[$lang->shortname]->site_title : "")->required() !!}</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('site_description['.$lang->shortname.']', __('settings.site_description'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) ? $setting[$lang->shortname]->site_description : "")->required() !!}</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('admin_email['.$lang->shortname.']', __('settings.admin_email'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) ? $setting[$lang->shortname]->admin_email : "")->required() !!}</div>
                                                <div
                                                    class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('copyright['.$lang->shortname.']', __('settings.copyright'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) ? $setting[$lang->shortname]->copyright : "")->required() !!}</div>
                                                <div class="pl-3 pr-3 pt-1 pb-1">
                                                    @if($lang->default)
                                                        {!! Form::checkbox('cookie_alert', __('settings.cookie_alert'))->value(1)->checked(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->cookie_alert ? true : false) !!}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($lang->default)
                                            <div class="card">
                                                <a href="javascript:;" data-toggle="collapse" data-target="#html_codes"
                                                   class="card-header text-muted">{{ __('settings.html_codes') }}</a>
                                                <div class="card-body collapse" id="html_codes">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div
                                                                class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('html_codes['.$lang->shortname.'][header]', __('settings.header_html_code'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->html_codes ? $setting[$lang->shortname]->html_codes['header'] : "") !!}</div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div
                                                                class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('html_codes['.$lang->shortname.'][footer]', __('settings.footer_html_code'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->html_codes ? $setting[$lang->shortname]->html_codes['footer'] : "") !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div href="javascript:;"
                                                     class="card-header"><a href="javascript:;" data-toggle="collapse"
                                                                            data-target="#social_links"
                                                                            class="text-muted">{{ __('settings.social_links') }}</a>
                                                    <a
                                                        href="javascript:;" class="float-right text-success add-new"
                                                        data-target=".price-table"><i
                                                            class="icon-plus"></i> Add New</a></div>
                                                <div class="card-body p-0 collapse" id="social_links">
                                                    <table class="table table-striped price-table" style="border: 0">
                                                        <tbody>
                                                        @foreach($socials as $key => $social)
                                                            <tr>
                                                                <td>
                                                                    <div class="input-group input-group-sm">
                                                                        <div class="input-group-prepend">
                                                                            <div
                                                                                class="dropdown input-group-text">
                                                                                <a type="button"
                                                                                   class="dropdown-toggle text-muted"
                                                                                   data-toggle="dropdown">
                                                                                    {!! $social['icon'] ? '<i class="'.$social['icon'].'"></i>' : __('settings.choose_icon') !!}
                                                                                </a>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-brands fa-twitter">Twitter</a>
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-brands fa-instagram">Instagram</a>
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-brands fa-facebook">Facebook</a>
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-brands fa-youtube">Youtube</a>
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-brands fa-linkedin">LinkedIn</a>
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-brands fa-pinterest">Pinterest</a>
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-brands fa-skype">Skype</a>
                                                                                    <a class="dropdown-item"
                                                                                       onClick="selectIcon(this)"
                                                                                       href="javascript:;"
                                                                                       data-icon="fa-solid fa-globe">Diğer</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control"
                                                                               name="social[link][]" value="{{ $social['link'] }}">
                                                                        <input type="hidden" class="form-control icon"
                                                                               name="social[icon][]" value="{{ $social['icon'] }}">
                                                                    </div>
                                                                </td>
                                                                <td width="20">
                                                                    <button type="button"
                                                                            class="btn btn-link text-danger"
                                                                            onClick="deleteRow(this)" {{ $key == 0 ? 'disabled' : '' }}>
                                                                        <i
                                                                            class="icon-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <a class="card-header text-muted" href="javascript:;"
                                                   data-toggle="collapse"
                                                   data-target="#smtp_conf">{{ __('settings.smtp_configurations') }}</a>
                                                <div class="card-body collapse" id="smtp_conf">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            {!! Form::text('smtp_configurations['.$lang->shortname.'][host]', __('settings.smtp.host'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->smtp_configurations ? $setting[$lang->shortname]->smtp_configurations['host'] : "") !!}
                                                        </div>
                                                        <div class="col-lg-2 col-md-2">
                                                            {!! Form::text('smtp_configurations['.$lang->shortname.'][port]', __('settings.smtp.port'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->smtp_configurations ? $setting[$lang->shortname]->smtp_configurations['port'] : "") !!}
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            {!! Form::text('smtp_configurations['.$lang->shortname.'][username]', __('settings.smtp.username'))->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->smtp_configurations ? $setting[$lang->shortname]->smtp_configurations['username'] : "") !!}
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            {!! Form::text('smtp_configurations['.$lang->shortname.'][password]', __('settings.smtp.password'))->type('password')->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->smtp_configurations ? $setting[$lang->shortname]->smtp_configurations['password'] : "") !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <a href="javascript:;" data-toggle="collapse" data-target="#recaptcha"
                                                   class="card-header text-muted">Google Recaptcha</a>
                                                <div class="card-body collapse" id="recaptcha">
                                                    <div class="row">
                                                        <div class="col-lg-1 col-md-2 pt-4 mt-1">
                                                            {!! Form::checkbox('google_recaptcha['.$lang->shortname.'][active]', 'Active')->value(1)->checked(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->google_recaptcha && isset($setting[$lang->shortname]->google_recaptcha['active']) ? true : false) !!}
                                                        </div>
                                                        <div class="col-lg-5 col-md-6">
                                                            {!! Form::text('google_recaptcha['.$lang->shortname.'][site]', 'Google Recaptcha Site Key')->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->google_recaptcha && isset($setting[$lang->shortname]->google_recaptcha['site']) ? $setting[$lang->shortname]->google_recaptcha['site'] : "") !!}
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            {!! Form::text('google_recaptcha['.$lang->shortname.'][secret]', 'Google Recaptcha Secret Key')->value(isset($setting) && $setting && isset($setting[$lang->shortname]) && $setting[$lang->shortname]->google_recaptcha && isset($setting[$lang->shortname]->google_recaptcha['secret']) ? $setting[$lang->shortname]->google_recaptcha['secret'] : "") !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer" style="border-top:1px solid #dedede;">
                                <button type="submit" class="btn btn-success float-right"
                                        href="{{ route('settings.add') }}"><i
                                        class="icon-paper-plane"></i> {{ __('global.save_changes') }}</button>
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
        $('.add-new').click(function () {
            var elm = $(this);
            var table = $(elm.attr('data-target'));
            var first_td = table.find('tbody').find('tr').first().clone();
            first_td.find('.form-control').val('');
            first_td.find('button').prop('disabled', false)
            table.find('tbody').append(first_td)
        })

        function deleteRow(elm) {
            elm = $(elm);
            elm.parents('tr').remove();
        }

        function selectIcon(elm) {
            var elm = $(elm);
            var icon = elm.attr('data-icon');
            elm.parents('tr').find('.icon').val(icon);
            elm.parents('tr').find('.text-muted').html('<i class="' + icon + '"></i>');
        }
    </script>
@endpush
