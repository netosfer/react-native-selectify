@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($location) && $location ? __('locations.edit_location') : __('locations.add_location') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('locations.index') }}">{{ __('locations.module_title') }}</a></li>
                        <li class="breadcrumb-item active">{{ isset($location) && $location ? __('locations.edit_location') : __('locations.add_location') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ isset($location) && $location ? route('locations.edit.post', ["id" => $location->id]) : route('locations.add') }}" method="post">
                                {{ csrf_field() }}
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ isset($location) && $location ? __('locations.edit_location') : __('locations.add_location') }}</h3>
                                        <div class="card-tools">
                                            <a class="text-secondary fw-bold" href="{{ route('locations.index') }}"><i data-feather="list"></i> {{ __('global.return_to_list') }}</a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 form-items">
                                        <div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('company_name', __('locations.company_name'))->value(isset($location) && $location ? $location->company_name : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('city', __('locations.city'))->options(\Illuminate\Support\Facades\DB::table('cities')->get()->prepend('Choose your city', ''), 'city_name', 'city_no')->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($location) && $location ? $location->city : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('address', __('locations.address'))->value(isset($location) && $location ? $location->address : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('related_person', __('locations.related_person'))->value(isset($location) && $location ? $location->related_person : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('phone_number', __('locations.phone_number'))->value(isset($location) && $location ? $location->phone_number : "")->required() !!}</div>
                                    </div>
                                    <div class="card-footer" style="border-top:1px solid #dedede;">
                                        <button type="submit" class="btn btn-success float-right" href="{{ route('locations.add') }}"><i class="fa-duotone fa-floppy-disk-circle-arrow-right"></i> {{ __('global.save_changes') }}</button>
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
