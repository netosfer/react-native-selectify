@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ isset($vehicle) && $vehicle ? __('vehicles.edit_vehicle') : __('vehicles.add_vehicle') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('vehicles.index') }}">{{ __('vehicles.module_title') }}</a></li>
                            <li class="breadcrumb-item active">{{ isset($vehicle) && $vehicle ? __('vehicles.edit_vehicle') : __('vehicles.add_vehicle') }}</li>
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
                            action="{{ isset($vehicle) && $vehicle ? route('vehicles.edit.post', ["id" => $vehicle->id]) : route('vehicles.add') }}"
                            method="post">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ isset($vehicle) && $vehicle ? __('vehicles.edit_vehicle') : __('vehicles.add_vehicle') }}</h3>
                                    <div class="card-tools">
                                        <a class="text-secondary fw-bold" href="{{ route('vehicles.index') }}"><i
                                                data-feather="list"></i> {{ __('global.return_to_list') }}</a>
                                    </div>
                                </div>
                                <div class="card-body p-0 form-items">
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('plate_no', __('vehicles.plate_no'))->value(isset($vehicle) && $vehicle ? $vehicle->plate_no : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('brand_name', __('vehicles.brand_name'))->value(isset($vehicle) && $vehicle ? $vehicle->brand_name : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('model_name', __('vehicles.model_name'))->value(isset($vehicle) && $vehicle ? $vehicle->model_name : "") !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('maintenance_date', __('vehicles.maintenance_date'))->value(isset($vehicle) && $vehicle ? $vehicle->maintenance_date : "") !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('insurance_date', __('vehicles.insurance_date'))->value(isset($vehicle) && $vehicle ? $vehicle->insurance_date : "") !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('vehicle_type', __('vehicles.vehicle_type'))->options(json_decode(\App\Models\Define::where('type', 'vehicle-types')->first()->values))->attrs(['class' => 'select2', 'data-placeholder' => __('vehicles.choose')])->value(isset($vehicle) && $vehicle ? $vehicle->vehicle_type : "") !!}</div>
                                </div>
                                <div class="card-footer" style="border-top:1px solid #dedede;">
                                    <button type="submit" class="btn btn-success float-right"
                                            href="{{ route('vehicles.add') }}"><i
                                            class="fa-duotone fa-floppy-disk-circle-arrow-right"></i> {{ __('global.save_changes') }}
                                    </button>
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
