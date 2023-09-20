@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('translations.module_title') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ MainHelper::admin_url() }}">{{ __('global.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('translations.module_title') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('translations.index_save', ['translate' => $current]) }}" method="post">
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <select name="" id="" class="form-control"
                                            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                        @foreach($files as $file)
                                            <option
                                                value="{{ route('translations.index_translate', ['translate' => basename($file, '.php')]) }}"{{ $current == basename($file, '.php') ? ' selected' : '' }}>{{ ucfirst(basename($file, '.php')) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="card-body table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                        @foreach($translations as $key => $trans)
                                            <tr>
                                                <td colspan="20"
                                                    class="text-center">{{ $trans[config('app.locale')] }}</td>
                                            </tr>
                                            <tr>
                                                @foreach($trans as $kay => $lang)
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"
                                                                      id="basic-addon1">{{ strtoupper($kay) }}</span>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                   name="{{ $key }}[{{ $kay }}]"
                                                                   value="{{ $trans[$kay] }}">
                                                        </div>

                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-success btn-sm float-right" type="submit">Save Changes</button>
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

@endpush
@push('scripts')
    <script>
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
