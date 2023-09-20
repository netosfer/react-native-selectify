@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($email_template) ? __('email_templates.edit_email_template') : __('email_templates.add_email_template') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('email_templates.index') }}">{{ __('email_templates.module_title') }}</a></li>
                        <li class="breadcrumb-item active">{{ isset($email_template) ? __('email_templates.edit_email_template') : __('email_templates.add_email_template') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ isset($email_template) && $email_template ? route('email_templates.edit.post', ["uniq_key" => request()->route('uniq_key')]) : route('email_templates.add') }}" method="post">
                                {{ csrf_field() }}
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        @foreach($languages as $key => $lang)
                                        <li class="nav-item">
                                            <a class="nav-link{{ $key == 0 ? ' active' : '' }}" id="{{ $lang->shortname }}_lang_tab" data-toggle="pill" href="#{{ $lang->shortname }}_lang" role="tab" aria-controls="{{ $lang->shortname }}_lang" aria-selected="true">{{ $lang->name }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        @foreach($languages as $key => $lang)
                                            <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="{{ $lang->shortname }}_lang" role="tabpanel" aria-labelledby="{{ $lang->shortname }}_lang_tab">
                                                <div class="pl-3 pr-3 pt-1 pb-1">@if($lang->default){!! Form::text('title', __('email_templates.title'))->value(isset($email_template) && $email_template && isset($email_template[$lang->shortname]) ? $email_template[$lang->shortname]->title : "")->required() !!}@endif</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('template['.$lang->shortname.']', __('email_templates.template'))->value(isset($email_template) && $email_template && isset($email_template[$lang->shortname]) ? $email_template[$lang->shortname]->template : "")->required() !!}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer" style="border-top:1px solid #dedede;">
                                    <button type="submit" class="btn btn-success float-right" href="{{ route('email_templates.add') }}"><i class="fa-duotone fa-floppy-disk-circle-arrow-right"></i> {{ __('global.save_changes') }}</button>
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
</script>
@endpush
