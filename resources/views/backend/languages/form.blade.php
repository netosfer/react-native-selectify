@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($language) && $language ? __('languages.edit_language') : __('languages.add_language') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('languages.index') }}">{{ __('languages.module_title') }}</a></li>
                        <li class="breadcrumb-item active">{{ isset($language) && $language ? __('languages.edit_language') : __('languages.add_language') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ isset($language) && $language ? route('languages.edit.post', ["id" => $language->id]) : route('languages.add') }}" method="post">
                                {{ csrf_field() }}
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ isset($language) && $language ? __('languages.edit_language') : __('languages.add_language') }}</h3>
                                        <div class="card-tools">
                                            <a class="text-secondary fw-bold" href="{{ route('languages.index') }}"><i class="icon-action-undo"></i> {{ __('global.return_to_list') }}</a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 form-items">
                                        <div class="pl-3 pr-3 pt-1 pb-1">
                                                {!! MainHelper::FileManager('flag', isset($language) && $language ? $language->flag : null, __('languages.flag_image')) !!}
                                            </div>
                                        <div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('name', 'Name')->value(isset($language) && $language ? $language->name : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('shortname', 'Shortname')->value(isset($language) && $language ? $language->shortname : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::checkbox('default', 'Is Default?')->value(isset($language) && $language ? $language->default : "") !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('sort_order', 'Sort')->value(isset($language) && $language ? $language->sort_order : "")->required() !!}</div>
                                    </div>
                                    <div class="card-footer" style="border-top:1px solid #dedede;">
                                        <button type="submit" class="btn btn-success float-right" href="{{ route('languages.add') }}"><i class="fa-duotone fa-floppy-disk-circle-arrow-right"></i> {{ __('global.save_changes') }}</button>
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
