@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ isset($task) && $task ? __('tasks.edit_task') : __('tasks.add_task') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">{{ __('tasks.module_title') }}</a></li>
                        <li class="breadcrumb-item active">{{ isset($task) && $task ? __('tasks.edit_task') : __('tasks.add_task') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ isset($task) && $task ? route('tasks.edit.post', ["id" => $task->id]) : route('tasks.add') }}" method="post">
                                {{ csrf_field() }}
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ isset($task) && $task ? __('tasks.edit_task') : __('tasks.add_task') }}</h3>
                                        <div class="card-tools">
                                            <a class="text-secondary fw-bold" href="{{ route('tasks.index') }}"><i data-feather="list"></i> {{ __('global.return_to_list') }}</a>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 form-items">
                                        <div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('employess', __('tasks.employess'))->options(\App\Models\Employee::get()->prepend('', ''), 'full_name')->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($task) && $task ? $task->employess : "")->required()->multiple() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('location', __('tasks.location'))->options(\App\Models\Location::get()->prepend('', ''), 'company_name')->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($task) && $task ? $task->location : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('materials', __('tasks.materials'))->options(\App\Models\Material::get()->prepend('', ''), 'name')->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($task) && $task ? $task->materials : "")->required()->multiple() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('vehicle', __('tasks.vehicle'))->options(\App\Models\Vehicle::get()->prepend('', ''), 'plate_no')->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($task) && $task ? $task->vehicle : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('start_date', __('tasks.start_date'))->value(isset($task) && $task ? $task->start_date : "")->required()->type('date') !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('end_date', __('tasks.end_date'))->value(isset($task) && $task ? $task->end_date : "")->type('date') !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::select('task_type', __('tasks.task_type'))->options()->attrs(['class' => 'select2', 'data-placeholder' => __('global.choose')])->value(isset($task) && $task ? $task->task_type : "")->required() !!}</div>
<div class="pl-3 pr-3 pt-1 pb-1">{!! Form::textarea('notes', __('tasks.notes'))->value(isset($task) && $task ? $task->notes : "") !!}</div>
                                    </div>
                                    <div class="card-footer" style="border-top:1px solid #dedede;">
                                        <button type="submit" class="btn btn-success float-right" href="{{ route('tasks.add') }}"><i class="fa-duotone fa-floppy-disk-circle-arrow-right"></i> {{ __('global.save_changes') }}</button>
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
