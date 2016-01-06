$(function(){
    $('.ajax-form').on('beforeSubmit', function(){
        formSend(this);
        return false;
    });

    $('.btn-order').each(function(e){
        var send_url = $('#page_order_aqua').val();
        send_url += '?type=' + encodeURI($(this).data('order'));

        $(this).attr('href', send_url);
    });
});

function formSend(selector) {

    var $form = $(selector);

    $.ajax({
        url: $form.attr('action'),
        data: $form.serialize(),
        beforeSend: function(){
            $('.alert', $form).remove();
            loader.show($form, 0, {'background-color': 'transparent'});
        },
        success: function(resp) {

            if (resp.status == 1) {

                $form.html('<div class="alert alert-success">' + resp.message + '</div>');

            } else if (resp.error) {

                var str = [];
                if (typeof(resp.error) == 'string') {
                    str.push(resp.error);
                } else {
                    for (var k in resp.error) {
                        str.push(resp.error[k].join('<br />'));
                    }
                }
                $form.prepend('<div class="alert alert-danger">' + str.join('<br />') + '</div>');

            }
        }
    });
}

$.ajaxSetup({
    type: 'POST',
    dataType: 'JSON',
    data: {csrf: $('meta[name=csrf-token]').attr('content')},
    beforeSend: function(){

    },
    complete: function(){
        loader.hide();
    },
    error: function(jqXHR, textStatus, errorThrown) {
        loader.hide();
        console.log(jqXHR);
    }
});

/**
 * плагин для захвата полного содержимого тега
 */
jQuery.fn.outerHTML = function(s) {
    return s
        ? this.before(s).remove()
        : jQuery("<p>").append(this.eq(0).clone()).html();
};

jQuery.fn.validate = function(f) {
    // вызов встроенных clientValidation методов
    // появились ли классы ошибок
    return ($('.has-success', f).length > 0 && $('.has-error', f).length === 0);
};

var loader = {
    show: function(selector) {
        var $selector = $(selector);

        $selector.css('position','relative');
        $selector.append('<div class="loader"></div>');

        var $loader = $('.loader', $selector);
        $loader.css({height: $selector.outerHeight(),
                      width: $selector.outerWidth()})
        $loader.show();
    },
    hide: function() {
        $('.loader').remove();
    }
};

var alert = {
    show: function(selector, class_name, msg) {
        if (msg) $(selector).html(msg);
        $(selector).attr('class','alert alert-' + class_name);
    },
    hide: function(selector) {
        $(selector).attr('class','hidden');
    }
};

function show_answer(obj, event) {
    event.preventDefault();

    var $obj = $(obj);
    $obj.next().slideToggle();
}

function review_show(obj) {
    var $obj = $(obj);

    $obj.parent().css('max-height','none');
    $obj.remove();
}

function set_job_img(obj) {
    var $obj = $(obj);
    var $img = $('.index-our-job img');

    // кеш
    var $new_img = $('<img class="hidden"/>');
    $new_img.attr('src', $obj.data('img'));
    $('body').append($new_img.outerHTML());

    setTimeout(function(){
        $img.attr('src', $new_img.attr('src'));
    }, 490);

    $img.animate({
        opacity: 0.30
    }, 300, function(){
        $('.our-job-name').html($('.img-title', $obj).html());
        $('.our-job-about').html($('.img-about', $obj).html());
        $(this).animate({opacity: 1},'fast');
    });
}

function show_answer(obj, event) {
    event.preventDefault();

    var $obj = $(obj);
    var $answer = $obj.next('p');

    $answer.slideToggle();
}