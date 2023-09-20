

feather.replace()
const swalert = (elm) => {
    elm = $(elm);
    var url = elm.attr("data-url");
    var http_method = elm.attr("data-method") ? elm.attr("data-method") : 'get';
    var title = elm.attr("data-title") ? elm.attr("data-title") : false;
    var text = elm.attr("data-text") ? elm.attr("data-text") : 'Are you sure you want to continue processing?';
    var reload_datatable = elm.attr("data-table") ? elm.attr("data-table") : false
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, continue...'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax( { url: url, method: http_method})
                .done(function() {
                    $(document).Toasts('create', {
                        class: 'bg-info w-250',
                        title: 'Information',
                        autohide: true,
                        delay: 4000,
                        body: 'The operation was successful!'
                    })
                    if(reload_datatable){
                        $(reload_datatable).DataTable().ajax.reload();
                    }
                })
                .fail(function() {
                    alert( "error" );
                });

        }
    })
}

$(function () {
    $('.select2').select2({
        theme: 'bootstrap4'
    })
    $('.bulk-check-main').change(function(){
        var elm = $(this);
        if(elm.is(':checked')){
            $('.bulk-item').prop('checked', true);
        } else {
            $('.bulk-item').prop('checked', false);
        }
    })
    setTimeout(function () {
        $('.bulk-item, .bulk-check-main').change(function () {
            if ($('.bulk-item').is(':checked')) {
                $('.bulk-delete-button').removeClass('d-none')
            }
            else
            {
                $('.bulk-delete-button').addClass('d-none')
            }
        })
    }, 1000)

    $('.bulk-delete-button').click(function(){
        var elm = $(this);
        var url = elm.attr('data-post');
        var token = elm.attr('token');
        var ids = [];
        $(".bulk-item").each(function()
        {
            if($(this).is(':checked')){
                ids.push($(this).val())
            }
        });
        var data = {'_token': token, 'ids': ids}
        Swal.fire({
            title: 'Bulk Delete',
            text: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({url: url, method: 'post', data: data})
                    .done(function () {
                        $(document).Toasts('create', {
                            class: 'bg-danger w-250',
                            title: 'Bulk Delete',
                            autohide: true,
                            delay: 4000,
                            body: 'The operation was successful!'
                        })
                        $('table').DataTable().ajax.reload();
                        $('.bulk-delete-button').addClass('d-none');
                    })
                    .fail(function () {
                        alert("error");
                    });
            }
        });
    })

});

$(document).ready(function(){
    $('.datetime-picker').datetimepicker();
    $('.dateranger').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
})
