@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $define->name }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ $define->name }}</li>
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
                            action="{{ isset($define) && $define ? route('defines.edit.post', ["id" => $define->id]) : route('defines.add') }}"
                            method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="{{ $define->type }}">
                            <input type="hidden" name="kind" value="{{ $define->kind }}">
                            <input type="hidden" name="name" value="{{ $define->name }}">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $define->name }}</h3>
                                    <div class="card-tools">
                                        <a class="text-secondary fw-bold add-new" href="javascript:;"><i
                                                class="fa-solid fa-plus"></i> Yeni Ekle</a>
                                    </div>
                                </div>
                                <div class="card-body form-items">
                                    @foreach($define->values as $val)
                                        <div class="row form-item">
                                            <div class="col-lg-11 col-md-11">
                                                <div class="form-group">
                                                    <label for=""></label>
                                                    <input type="text" name="values[]" class="form-control" required
                                                           value="{{ $val }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1">
                                                <button type="button" disabled
                                                        class="btn btn-outline-danger btn-sm delete-row"
                                                        style="margin-top: 25px" href="javascript:;"><i
                                                        class="fa-duotone fa-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="card-footer" style="border-top:1px solid #dedede;">
                                    <button type="submit" class="btn btn-success float-right"
                                            href="{{ route('defines.add') }}"><i
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
        $('.add-new').click(function () {
            var elm = $(this);
            var item = $('.form-item');
            var items = $('.form-items');
            var clone_item = item.clone();
            clone_item = $(clone_item);
            clone_item.find('.form-control').val('');
            clone_item.find('button').prop('disabled', false);
            items.append(clone_item);
            $('.delete-row').click(function () {
                $(this).parents('.form-item').remove();
            })
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
