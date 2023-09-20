@php
    $imager_id =  $target;
@endphp
<input type="hidden" name="{{ isset($name) ? $name : $target }}" id="{{ $target }}" value="{{ isset($selected_image) ? $selected_image : '' }}">
<div class="tab-content" id="single-imager-{{ $imager_id }}" data-target="#{{ $target }}" data-id="{{ $imager_id }}">
    <div class="tab-pane fade{{ !$selected_image ? ' show active' : '' }}" id="select-{{ $imager_id }}" role="tabpanel" aria-labelledby="select-{{ $imager_id }}-tab">
        <div class="mini-tab-container">
             <a href="javascript:;" onClick="open_imager({multiple: 'false', target: '#{{ $target }}', sizes: '{{isset($sizes) ? implode(',', $sizes) : 'false' }}', dir: '{{ isset($dir) ? $dir : 'false' }}'})" class="btn-block btn"><i class="fa fa-image"></i> {{ $info_text ? $info_text : __('imager.Select Image') }}</a>
        </div>
    </div>
    <div class="tab-pane fade{{ isset($selected_image) && $selected_image ? ' show active' : '' }}" id="already-{{ $imager_id }}" role="tabpanel" aria-labelledby="already-{{ $imager_id }}-tab">
        <div class="already-image text-center pt-3 pl-3 pr-3 pb-0">
            <img src="{{ isset($selected_image) ? image_url($selected_image, false) : 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' }}" style="border :1px solid #dedede" alt="" class="rounded" height="50">
            <a href="javascript:;" class="remove-button btn btn-text text-danger"><i class="fa fa-times"></i> {{ __('imager.Remove') }}</a>
        </div>
    </div>
  </div>
