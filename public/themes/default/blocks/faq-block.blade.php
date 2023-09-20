<h3 class="h-font mb-4">{{ __('frontend.faq') }}</h3>
<div class="accordion" id="accordionExample">
    @foreach($item as $key => $data)
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading{{$key}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" aria-controls="collapse{{$key}}">
                  <span>
                    <i class="ri-arrow-up-s-line minus"></i>
                    <i class="ri-arrow-down-s-line plus "></i>
                  </span> <i class="ri-question-fill text-muted"></i> &nbsp;{{ $data->question }} </button>
        </h2>
        <div id="collapse{{$key}}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <p>{!!  $data->answer  !!} </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
