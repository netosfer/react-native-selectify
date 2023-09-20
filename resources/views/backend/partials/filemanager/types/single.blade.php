@php
    $imager_id =  $target;
    if($selected_image == 'placeholders/lg.jpg'){
      $selected_image = null;
    }
@endphp
<input type="hidden" name="{{ isset($name) ? $name : $target }}" id="{{ $target }}" value="{{ isset($selected_image) ? $selected_image : '' }}">
<div class="card" style="max-width: 380px">
    <div class="card-header font-weight-bold">{{ $label }}</div>
    <div class="card-body">
<div class="tab-content" id="single-imager-{{ $imager_id }}" data-target="#{{ $target }}" data-id="{{ $imager_id }}">
    <div class="tab-pane fade{{ !$selected_image ? ' show active' : '' }}" id="select-{{ $imager_id }}" role="tabpanel" aria-labelledby="select-{{ $imager_id }}-tab">
        <div class="single-tab-container">
             <a href="javascript:;" onClick="open_imager({multiple: 'false', target: '#{{ $target }}', sizes: '{{isset($sizes) ? implode(',', $sizes) : 'false' }}', dir: '{{ isset($dir) ? $dir : 'false' }}'})" class="btn-block btn"><i class="fa fa-image"></i> {{ isset($info_text) ? $info_text : __('imager.Select Image') }}</a>
        </div>
    </div>
    <div class="tab-pane fade{{ isset($selected_image) && $selected_image ? ' show active' : '' }}" id="already-{{ $imager_id }}" role="tabpanel" aria-labelledby="already-{{ $imager_id }}-tab">
        <div class="already-image text-center pt-3 pl-3 pr-3 pb-0">
            <img src="{{ $selected_image ? $helper->image_url($selected_image, 300, 300, 2) : 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' }}" style="border :1px solid #dedede; background:#f5f5f5" alt="" class="rounded">
            <a href="javascript:;" onClick="single_delete(this)" class="remove-button btn btn-text text-danger"><i class="fa fa-times"></i> {{ __('imager.Remove') }}</a>
        </div>
    </div>
  </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('back/plugins/imager/js/imager.js') }}"></script>
@endpush
