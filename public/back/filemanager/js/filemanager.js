$(document).ready(function(){
    $('*[data-toggle="filemanager"]').click(function(){
        var elm = $(this);
        var modal = $('#imager');
        var label = elm.attr('data-label');
        var target = elm.attr('data-target');
        modal.modal('show');
        modal.find('.modal-title').append(label);
    })
})
