@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <form method="post" action="{{ route('module.add') }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Responsive Hover Table</h3>
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <select name="" id="" class="form-control float-right" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                <option value="">Select Available Module</option>
                                                @foreach($modules as $m)
                                                    <option value="{{ url('admin/module/'.pathinfo($m, PATHINFO_BASENAME)) }}">{{ pathinfo($m, PATHINFO_BASENAME) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body table-responsive overflow-hidden">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       placeholder="Module Name" name="module[module]"
                                                       value="{{ $module ? $module['module'] : ''  }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="custom-control custom-checkbox" style="float: left;">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="language" id="language_support"
                                                               value="1"{{ $module && $module['language'] ? ' checked' : ''  }}>
                                                        <label class="custom-control-label" for="language_support">Language
                                                            Support</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="col">
                                                        <div class="custom-control custom-checkbox"
                                                             style="float: left;">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   name="addable" id="addable"
                                                                   value="1"{{ $module && $module['addable'] ? ' checked' : ''  }}>
                                                            <label class="custom-control-label"
                                                                   for="addable">Addable</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row items" id="sortable">
                                        @if($module)
                                            @foreach($module['fields'] as $index => $field)
                                                @include('backend.module.item', ['field' => $field, 'index' => $index])
                                            @endforeach
                                        @else
                                            @include('backend.module.item')
                                        @endif

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <button class="btn btn-success btn-block add-item" type="button">New Field
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg">Make Module</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
        const delete_row = (elm) => {
            elm = $(elm);
            elm.parents('.item').remove();
        }
        $(document).ready(function () {
            $('.add-item').click(function () {
                var elm = $(this);
                var new_html = $('.item').first().clone();
                var new_id = ($('.label-box').length + 1)
                $(new_html).find('#customCheckDisabled11').attr('id', 'customCheckDisabled11' + new_id);
                $(new_html).find('*[for="customCheckDisabled11"]').attr('for', 'customCheckDisabled11' + new_id);
                $(new_html).find('#customCheckDisabled21').attr('id', 'customCheckDisabled21' + new_id);
                $(new_html).find('*[for="customCheckDisabled21"]').attr('for', 'customCheckDisabled21' + new_id);
                $(new_html).find('#customCheckDisabled31').attr('id', 'customCheckDisabled31' + new_id);
                $(new_html).find('*[for="customCheckDisabled31"]').attr('for', 'customCheckDisabled31' + new_id);
                $(new_html).find('input, select').val('')
                $(new_html).find('.custom-control-input').each(function(){
                    var el = $(this);
                    el.attr('name', el.attr('data-name'));
                })
                $('.items').append(new_html);
            })
            $("#sortable").sortable();
            $('.attr-item').change(function () {
                var elm = $(this);
                var parent = elm.parents('.item-area');
                var name = elm.attr('data-name');
                if(!name){
                    name = elm.attr('name')
                }
                if(elm.is(':checked')){
                    parent.find('*[name="'+name+'"]').attr('data-name', name);
                    parent.find('*[name="'+name+'"]').removeAttr('name');

                    elm.attr('name', name);
                    elm.removeAttr('data-name');
                } else {
                    parent.find('*[data-name="'+name+'"]').attr('name', name);
                    parent.find('*[data-name="'+name+'"]').removeAttr('data-name');

                    elm.attr('data-name', name);
                    elm.removeAttr('name');
                }
            })
        })
    </script>
@endpush
