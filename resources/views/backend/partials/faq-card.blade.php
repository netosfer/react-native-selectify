@php

    $item[$lang->shortname] =  $item[$lang->shortname];
    if(is_object($item[$lang->shortname]) && !$item[$lang->shortname]->data){
        $item[$lang->shortname]->data = [['question' => '', 'answer' => '']];
    } elseif(!is_object($item[$lang->shortname])){
        $item[$lang->shortname] = json_decode(json_encode($item[$lang->shortname]));
    }
 @endphp
<div class="card">
    <div href="javascript:;"
         class="card-header"><a href="javascript:;" data-toggle="collapse"
                                data-target="#faq_datas{{ $lang ? $lang->shortname : '' }}"
                                class="text-muted">Sıkça Sorulanlar</a>
        <a
            href="javascript:;" class="float-right text-success add-new{{ $lang ? $lang->shortname : '' }}"
            data-target=".faq-table{{ $lang ? $lang->shortname : '' }}"><i
                class="icon-plus"></i> Yeni Ekle</a></div>
    <div class="card-body p-0 collapse show" id="faq_datas{{ $lang ? $lang->shortname : '' }}">
        <table class="table table-striped faq-table{{ $lang ? $lang->shortname : '' }}" style="border: 0">
            <tbody>
            @foreach($item[$lang->shortname]->data as $key => $i)
                <tr>
                    <td width="30%">
                        <div class="form-group">
                            <label for="">Soru</label>
                            <input type="text" class="form-control"
                                   name="{{ $lang ? $lang->shortname."[data][" : 'data[' }}question][]" value="{{ $i->question }}" >
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label for="">Cevap</label>
                            <textarea name="{{ $lang ? $lang->shortname."[data][" : 'data[' }}answer][]"
                                      class="form-control editor">{{ $i->answer }}</textarea>
                        </div>
                    </td>
                    <td width="20">
                        <button type="button"
                                class="btn btn-link text-danger"
                                onClick="deleteRow(this)" {{ $key == 0 ? 'disabled' : '' }}>
                            <i class="fa-duotone fa-trash-xmark"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
    <script>
        $('.add-new{{ $lang ? $lang->shortname : '' }}').click(function () {
            var elm = $(this);
            var table = $(elm.attr('data-target'));
            var first_td = table.find('tbody').find('tr').first().clone();
            first_td.find('textarea').removeAttr('id', false)
            first_td.find('textarea').removeAttr('style')
            first_td.find('textarea').removeAttr('area-hidden')
            first_td.find('.tox-tinymce').remove()
            first_td.find('.form-control').val('');
            first_td.find('button').prop('disabled', false)
            table.find('tbody').append(first_td);
            tinymce.init({
                selector: 'textarea.editor',
                width: '100%',
                height: 500,
                resize: false,
                plugins: [
                    'advcode', 'advlist', 'anchor', 'autolink', 'codesample', 'fullscreen',
                    'image', 'editimage', 'tinydrive', 'lists', 'link', 'media', 'powerpaste', 'preview',
                    'searchreplace', 'table',  'wordcount'
                ],
                toolbar: 'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });
        })

        function deleteRow(elm) {
            elm = $(elm);
            elm.parents('tr').remove();
        }
    </script>
@endpush
