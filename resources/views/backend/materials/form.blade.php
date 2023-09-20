@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ isset($material) && $material ? __('materials.edit_material') : __('materials.add_material') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('materials.index') }}">{{ __('materials.module_title') }}</a></li>
                            <li class="breadcrumb-item active">{{ isset($material) && $material ? __('materials.edit_material') : __('materials.add_material') }}</li>
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
                            action="{{ isset($material) && $material ? route('materials.edit.post', ["id" => $material->id]) : route('materials.add') }}"
                            method="post">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ isset($material) && $material ? __('materials.edit_material') : __('materials.add_material') }}</h3>
                                    <div class="card-tools">
                                        <a class="text-secondary fw-bold" href="{{ route('materials.index') }}"><i
                                                data-feather="list"></i> {{ __('global.return_to_list') }}</a>
                                    </div>
                                </div>
                                @php
                                    $material_types = ['' => ''];
                                    $material_types = array_merge($material_types, json_decode(\App\Models\Define::where('type', 'material-types')->first()->values, true));
                                @endphp
                                <div class="card-body p-0 form-items">
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! MainHelper::FileManager('image', isset($material) && $material ? $material->image : null, 'Image') !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('name', __('materials.name'))->value(isset($material) && $material ? $material->name : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('material_type', __('materials.material_type'))->options($material_types)->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($material) && $material ? $material->material_type : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('material_code', __('materials.material_code'))->value(isset($material) && $material ? $material->material_code : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('rfid_code', __('materials.rfid_code'))->value(isset($material) && $material ? $material->rfid_code : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('received_date', __('materials.received_date'))->value(isset($material) && $material ? $material->received_date : "")->type('date') !!}</div>
                                </div>
                                <div class="card-footer" style="border-top:1px solid #dedede;">
                                    <button type="submit" class="btn btn-success float-right"
                                            href="{{ route('materials.add') }}"><i
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
