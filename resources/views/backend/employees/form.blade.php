@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($employee) && $employee ? __('employees.edit_employee') : __('employees.add_employee') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">{{ __('employees.module_title') }}</a></li>
                        <li class="breadcrumb-item active">{{ isset($employee) && $employee ? __('employees.edit_employee') : __('employees.add_employee') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ isset($employee) && $employee ? route('employees.edit.post', ["id" => $employee->id]) : route('employees.add') }}" method="post">
                                {{ csrf_field() }}
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ isset($employee) && $employee ? __('employees.edit_employee') : __('employees.add_employee') }}</h3>
                                        <div class="card-tools">
                                            <a class="text-secondary fw-bold" href="{{ route('employees.index') }}"><i data-feather="list"></i> {{ __('global.return_to_list') }}</a>
                                        </div>
                                    </div>
                                    @php
                                        $employee_types = ['' => ''];
                                        $employee_types = array_merge($employee_types, json_decode(\App\Models\Define::where('type', 'employee-types')->first()->values, true));

                                        $employee_classes = ['' => ''];
                                        $employee_classes = array_merge($employee_classes, json_decode(\App\Models\Define::where('type', 'employee-classes')->first()->values, true));
                                    @endphp
                                    <div class="card-body p-0 form-items">
                                        <div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('employee_type', __('employees.employee_type'))->options($employee_types)->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($employee) && $employee ? $employee->employee_type : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('employee_id', __('employees.employee_id'))->value(isset($employee) && $employee ? $employee->employee_id : "") !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('full_name', __('employees.full_name'))->value(isset($employee) && $employee ? $employee->full_name : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('employee_duty', __('employees.employee_duty'))->options($employee_classes)->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($employee) && $employee ? $employee->employee_duty : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('start_date_of_work', __('employees.start_date_of_work'))->value(isset($employee) && $employee ? $employee->start_date_of_work : "")->type('date') !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('end_date_of_work', __('employees.end_date_of_work'))->value(isset($employee) && $employee ? $employee->end_date_of_work : "")->type('date') !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! MainHelper::FileManager('files', isset($employee) && $employee ? $employee->files : null, 'Files', true) !!}</div>
                                    </div>
                                    <div class="card-footer" style="border-top:1px solid #dedede;">
                                        <button type="submit" class="btn btn-success float-right" href="{{ route('employees.add') }}"><i class="fa-duotone fa-floppy-disk-circle-arrow-right"></i> {{ __('global.save_changes') }}</button>
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
