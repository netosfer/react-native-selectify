@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ isset($user) && $user ? __('users.edit_user') : __('users.add_user') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('users.index') }}">{{ __('users.module_title') }}</a></li>
                            <li class="breadcrumb-item active">{{ isset($user) && $user ? __('users.edit_user') : __('users.add_user') }}</li>
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
                            action="{{ isset($user) && $user ? route('users.edit.post', ["id" => $user->id]) : route('users.add') }}"
                            method="post">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ isset($user) && $user ? __('users.edit_user') : __('users.add_user') }}</h3>
                                    <div class="card-tools">
                                        <a class="text-secondary fw-bold" href="{{ route('users.index') }}"><i
                                                class="icon-action-undo"></i> {{ __('global.return_to_list') }}</a>
                                    </div>
                                </div>
                                <div class="card-body p-0 form-items">
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! MainHelper::FileManager('profile_photo_path', isset($user) && $user ? $user->profile_photo_path : null, 'Profile Photo Path') !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('name', __('users.name'))->value(isset($user) && $user ? $user->name : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('email', __('users.email'))->value(isset($user) && $user ? $user->email : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('phone_number', __('users.phone_number'))->value(isset($user) && $user ? $user->phone_number : "")->required() !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1">{!! Form::text('password', __('users.password')) !!}</div>
                                    <div
                                        class="pl-3 pr-3 pt-1 pb-1 mb-4">{!! Form::checkbox('is_admin', __('users.is_admin'))->value(1)->checked(isset($user) && $user && $user->is_admin ?? false) !!}</div>
                                </div>
                                <div class="card-footer" style="border-top:1px solid #dedede;">
                                    <button type="submit" class="btn btn-success float-right"
                                            href="{{ route('users.add') }}"><i
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
    </script>
@endpush
