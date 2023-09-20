feather.replace()
$('.add_image_button').text(lang_add_images)
if (queryString("multiple") !== 'true') {
    $('.add_image_button').text(lang_add_image)
}
function queryString(param) {
    var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < url.length; i++) {
        var urlparam = url[i].split('=');
        if (urlparam[0] == param) {
            return urlparam[1];
        }
    }
}

function selected_images() {
    var images = [];
    $('.image-container.active').each(function () {
        var elm = $(this);
        images.push(elm.find("img").attr("data-uri"));
    })
    var images_length = images.length;
    if (queryString("multiple") !== 'true') {
        if (images.length > 0) {
            images = images[0];
            images_length = 1;
        }
    }
    if (images.length > 0) {
        $('.display-selected').removeClass('d-none');
        $('.selected-count').removeClass('d-none');
        $('.selected-count').find('span').text(images_length);
        $('.selected-count').find('b').text(lang_selected_image);
        if (images.length > 1) {
            $('.selected-count').find('b').text(lang_selected_images);
        }
        $('.add_image_button').prop('disabled', false)
    } else {
        $('.display-selected').addClass('d-none');
        $('.selected-count').addClass('d-none');
        $('.add_image_button').prop('disabled', true)
        $('.popover').remove();
    }
    if (queryString('multiple') != 'true' && queryString('cropper') == 'true') {
        $('#cropper-tab').click();

    }

    return images;
}
function deselect() {
    $('.image-container').removeClass('active');
    selected_images();
}
function delete_images() {
    var images = selected_images();
    if (images.length > 0) {
        $('#delete_image').modal('show');
    }
    console.log(images)
}
function init(default_data = false, selecting_images = []) {
    var data = {
        target: queryString('target'),
        multiple: queryString('multiple'),
        start: queryString('start'),
        limit: queryString('limit'),
        dir: queryString('dir'),
        sizes: queryString('sizes'),
        _token: csrf_token
    };
    if (default_data) {
        data = default_data;
    }
    $.post(url + '/admin/imager/files', data, function (response) {
        if (response && response.files) {
            var files_html = '';
            if ($('.image-box').length > 0) {
                $('.load-more-tag').remove();
            } else {
                $('.loading-div').text('File not found to display')
            }
            $(response.files).each(function (index, file) {
                var full_uri = url + '/storage/media/' + file.uri;
                var src = url + '/img/300x300x2/media/' + file.uri;
                var uri = file.uri;
                if(queryString('dir') && queryString('dir') != 'false'){
                    src = url + '/img/300x300x2/media/' + queryString('dir') + '/' + file.uri;
                    full_uri = url + '/storage/media/' + queryString('dir') + '/' + file.uri;
                    uri = queryString('dir') + "/" + file.uri;
                }
                files_html += '<div class="col-lg-2 col-md-2 col-4 mb-4 image-container">';
                files_html += '<div class="image-box" title="' + file.uri + '">';
                files_html += '<img src="' + src + '" data-uri="' + uri + '" data-full-uri="' + url + '/storage/media/' + file.uri + '" loading="lazy" alt="">';
                files_html += '</div>';
                files_html += '<span>' + file.uri + '</span>';
                files_html += '</div>';
            })
            if (files_html != '') {
                if ($('.image-box').length > 0) {
                    $('.image-scaffold').append(files_html)
                } else {
                    $('.image-scaffold').html(files_html)
                }
                if (response.total != $('.image-box').length) {
                    $('.image-scaffold').append('<div class="text-center load-more-tag"><a class="btn btn-sm btn-outline-primary ps-4 pe-4 pl-4 pr-4 load-more">Load more</a></div>')
                }
            }
            if(selecting_images.length > 0){
              if (queryString("multiple") == 'true') {
                $(selecting_images).each(function(i, item){
                    $('div[title="'+item+'"]').parent().addClass('active')
                    selected_images();
                    $('.add_image_button').click();
                })
              } else {
                $('div[title="'+selecting_images[0]+'"]').parent().addClass('active')
                selected_images();
                $('.add_image_button').click();
              }
            }
            $('.image-container').click(function () {
                var elm = $(this);
                if (queryString("multiple") !== 'true') {
                    $('.image-container').removeClass('active');
                }
                elm.toggleClass('active');
                selected_images();
            })
            $('.load-more').click(function () {
                var default_data = {
                    target: queryString('target'),
                    multiple: queryString('multiple'),
                    start: $('.image-box').length,
                    limit: queryString('limit'),
                    _token: csrf_token
                };
                init(default_data)
            })
            $('.image-container').dblclick(function () {
                var image = $(this);
                var image_full_uri = image.find("img").attr("data-full-uri");
                $.fancybox.open([
                    {
                        src: image_full_uri,
                        opts: {
                            caption: image.find("img").attr("data-uri")
                        }
                    }
                ]);
            })
        }
    })
}
$(document).ready(function () {
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
    init();
    $('#delete_images').on('shown.bs.popover', function () {

        $('.delete-images').click(function () {
            delete_images();
        })

        $('.popover').find('.selected-count').find('span').text($('.selected-count').find('span').text());

    });
    $('.image-container').click(function () {
        var elm = $(this);
        if (queryString("multiple") !== 'true') {
            $('.image-container').removeClass('active');
        }
        elm.toggleClass('active');
        selected_images();
    })
    $('.add_image_button').click(function () {
        var images = selected_images();
        if (Array.isArray(images) && images.length > 0) {
            images = images.join(",");
        }
        if (queryString('tinymce') == 'true') {
            var base_url = "{{ url('/') }}";
            window.parent.document.querySelector('#imager').setAttribute("data-last-select", images);
        } else {
            window.parent.select_imager(images, { multiple: queryString('multiple'), target: queryString('target') });
        }
        window.parent.close_modal();
    })

    $('#upload-input').change(function () {
        $('#upload_form').submit();
    })
    $('#upload_form').on('submit', (function (e) {
      $('.uploading').addClass('active');
        e.preventDefault();
        var form_data = new FormData();
        form_data.append("_token", csrf_token);
        if(queryString('sizes') && queryString('sizes') != 'false'){
            form_data.append("sizes", queryString('sizes'));
        }
        if(queryString('dir') && queryString('dir') != 'false'){
            form_data.append("dir", queryString('dir'));
        }
        var totalfiles = document.getElementById('upload-input').files.length;
        for (var index = 0; index < totalfiles; index++) {
            form_data.append("images[]", document.getElementById('upload-input').files[index]);
        }
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data)
                if (data) {
                  $('.uploading').removeClass('active');
                    $('.image-scaffold').html('');
                    init(false, data);
                    $('#library-tab').click();
                }
            },
            error: function (data) {
                console.log(data)
                $('.uploading').removeClass('active');
                alert("The file you are trying to upload is not in the allowed formats. (jpg, jpeg, png or gif)")
            }
        });
    }));

})

function close_modal_parent() {
    window.parent.close_modal();
}
function close_modal() {
    $('.modal').modal('hide')
    $('#imager').find('iframe').attr("src", base_url + "/admin/imager?");
}
function open_imager(options) {
    var multiple = options.multiple ? options.multiple : false;
    var target = options.target ? options.target : '.image';
    var start = options.start ? options.start : 0;
    var tinymce = options.tinymce ? options.tinymce : 'false';
    var sizes = options.sizes ? options.sizes : 'false';
    var dir = options.dir ? options.dir : 'false';
    $('#imager').find('iframe').attr("src", base_url + "/admin/imager?" + "multiple=" + multiple + "&target=" + target + "&start=" + start + "&tinymce=" + tinymce + "&sizes=" + sizes + "&dir=" + dir);
    $('#imager').modal('show')
}
function select_imager(image, options) {
    var target = options.target ? options.target : null;
    var multiple = options.multiple ? options.multiple : false;
    if (multiple == 'false') {
        $(target).val('media/' + image);
        var id = $('*[data-target="' + target + '"]').attr("data-id");
        $('#select-' + id).removeClass('show active');
        $('#already-' + id).find("img").attr("src", base_url + "/img/300x300x2/media/" + image);
        $('#already-' + id).addClass('show active');
    } else if(multiple == 'true') {
        var images = image.split(',');
        var id = $('*[data-target="' + target + '"]').attr("data-id");
        $.each(images, function(i, item){
            $('.gallery-container').append('<figure style="float:left; max-width: 200px; padding: 10px;"><img src="'+base_url+'/img/300x300x2/media/'+item+'" data-img="'+item+'" class="rounded border" /><a href="javascript:;" onClick="multiple_delete(this)" class="remove-button-multiple btn btn-text text-danger"><i class="fa fa-times"></i></a></figure>')
        })
        var imgs = []
        $('.gallery-container').find('figure').each(function(i, item){
            var im = $(item).find('img').attr('data-img');
            if(im){
                imgs.push("media/" + im)
            }
        })
        $(target).val(imgs);
        $('#already-' + id).addClass('show active');
    }
}
$(document).ready(function () {
    $('.remove-button').click(function () {
        var elm = $(this)
        var id = elm.parents('.tab-content').attr("data-id");
        var target = elm.parents('.tab-content').attr("data-target");
        elm.parents('.already-image').find("img").attr("src", "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
        $('#select-' + id).addClass('show active');
        $('#already-' + id).removeClass('show active');
        $(target).val("")
    })
})
function single_delete(elm){
    var elm =  $(elm)
    var id = elm.parents('.tab-content').attr("data-id");
    var target = elm.parents('.tab-content').attr("data-target");
    elm.parents('.already-image').find("img").attr("src", "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
    $('#select-' + id).addClass('show active');
    $('#already-' + id).removeClass('show active');
    $(target).val("")
}
function multiple_delete(elm){
    var elm =  $(elm)
    var img = elm.parents('figure').find('img').attr('data-img')
    console.log(img);

    var id = elm.parents('.tab-content').attr("data-id");
    var target = elm.parents('.tab-content').attr("data-target");
    var input = target.replace('#', '.');
    var images = $(input).val();
    images = images.split(',');
    var new_images = []
    $.each(images, function(i, item){
        if(item != img){
            new_images.push(item)
        }
    })
    $(target).val(new_images.join(','))
    elm.parents('figure').remove();
}
