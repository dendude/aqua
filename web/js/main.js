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