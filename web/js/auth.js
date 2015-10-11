function user_login(form, event) {
    event.preventDefault();

    var $form = $(form);

    $.ajax({
        url: $form.attr('action'),
        data: $form.serialize(),
        beforeSend: function(){
            loader.show($form);
        },
        complete: null,
        success: function(resp) {
            if (resp.role) {
                if (resp.role == 'admin') {
                    location.href = resp.url;
                } else if (location.href.indexOf('auth') == -1) {
                    location.reload();
                } else {
                    location.href = '/';
                }
            } else {
                loader.hide();
                $form.html($(resp.content).html());
            }
        }
    });
}