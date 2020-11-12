jQuery(document).ready(function ($) {
    $('.create-form .btn').on('click', function () {
        let button = $(this)
            , form = button.closest('.create-form')
            , form_data = form.serializeArray()
            , valid_form = form[0].checkValidity();

        if (!valid_form) {
            $('.real-url').focus();
            return false;
        }

        button.prop('disabled', true);
        $('.alert-primary', form).remove();

        $.post(form.attr('action'), form_data, function (response) {
            if (response['message'] || response['url']) {
                form.append('<div class="alert alert-primary" role="alert">\n' +
                    [response['message'], response['url']].filter(function(el) { return el; }).join('<br>') + '<br>' +
                    '</div>')
            }
        }, 'json')
            .always(function () {
                button.prop('disabled', false);
            });
    });
});