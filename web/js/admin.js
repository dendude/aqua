/**
 * Created by dendude on 09.03.15.
 */
$(document).ready(function(){

    // клик по кнопке получения алиаса
    var $btn_alias = $('.btn-alias');
    if ($btn_alias.length) {
        $btn_alias.on('click', function (e) {
            e.preventDefault();
            var $a = $(this);
            $.ajax({
                url: $a.attr('href'),
                dataType: 'text',
                data: {
                    csrf: $('meta[name=csrf-token]').attr('content'),
                    str: $('#' + $a.data('from')).val()
                },
                beforeSend: function(){
                    loader.show($btn_alias.closest('.form-group'));
                },
                success: function(alias) {
                    $('#' + $a.data('to')).val(alias);
                }
            })
        });
    }

    // отправка формы
    $('form').on('submit', function(){
        loader.show($('.well', this));
    })
});

function add_breadcrumb(selector, dest) {
    var $sel = $(selector);
    var $dest = $(dest);

    var page_id = $sel.val();
    var crumb = $('option[value=' + page_id + ']', $sel).text();

    if ($('span.crumb-' + page_id, $dest).length == 0) {
        var cont = '<span> &raquo; ' +
                        '<span class="crumb-' + page_id + '">' + $('option[value=' + page_id + ']', $sel).text() +
                            '<input type="hidden" name="Pages[breadcrumbs][]" value="' + page_id + '" />' +
                            ' (<a href="" onclick="$(this).parent().parent().remove();return false">удалить</a>)' +
                        '</span>' +
                    '</span>';

        $(cont).insertBefore($('#put_crumb', $dest));
    }
}

function add_vbreadcrumb(selector, dest) {
    var $sel = $(selector);
    var $dest = $(dest);

    var page_id = $sel.val();
    var crumb = $('option[value=' + page_id + ']', $sel).text();

    if ($('span.crumb-' + page_id, $dest).length == 0) {
        var cont = '<span>' +
            '<span class="crumb-' + page_id + '">' + $('option[value=' + page_id + ']', $sel).text() +
            '<input type="hidden" name="Pages[vcrumbs][]" value="' + page_id + '" />' +
            ' (<a href="" onclick="$(this).parent().parent().remove();return false">удалить</a>)' +
            '</span>' +
            '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

        $dest.append(cont);
    }
}

function set_crumb(obj, dest) {
    var $obj = $(obj);
    var $dest = $(dest);

    if ($obj.val() != '') {
        $dest.html(' &raquo; ' + $obj.val());
    } else {
        $dest.html('');
    }
}

function charsCalculate(obj) {
    var $obj = $(obj);
    var $group = $obj.closest('.form-group');
    var length = $obj.val().length;

    if (length > 0) {
        $('.help-block', $group).text('Введено символов: ' + length);
    } else {
        $('.help-block', $group).text('');
    }
}

function set_auto_alias(obj) {
    var $obj = $(obj);

    if ($obj.prop('checked')) {
        $('#pages_content').addClass('hidden');
    } else {
        $('#pages_content').removeClass('hidden')
    }
}

function set_upload_button(sel) {

    var $btn = $('#save_photos');
    var $drop_zone = $('#dropzone');
    var $append_zone = $('#appendzone');
    var $status = $('#upload_status');
    var $loader = $('.drop-loader', $drop_zone);

    var msg, $p, prev_progress = 0;

    $(sel).fileupload({
        dataType: 'JSON',
        dropZone: $('body'),
        sequentialUploads: true,
        beforeSend: null,
        dragover: function (e) {
            $drop_zone.addClass('active');
        },
        dragleave: function (e) {
            $drop_zone.removeClass('active');
        },
        add: function (e, data) {
            data.submit();
        },
        change: function (e, data) {
            $status.html('').addClass('hidden');
        },
        submit: function(e, data) {

            var reg_exp = /(\.|\/)(gif|jpe?g|png)$/i;
            var max_size = 10*Math.pow(1024,2);
            var file_name, file_size;

            file_name = data.files[0].name;
            file_size = data.files[0].size;

            if (!reg_exp.test(file_name)) {

                $p = $('<p>').text(file_name);
                msg = 'Файл <strong>' + $p.text() + '</strong> имеет недопустимый формат.<br />Доступные форматы фотографий для загрузки: <strong>jpg, jpeg, gif, png</strong>';

                $status.html($status.html() + '<div>' + msg + '</div>').removeClass('hidden');
                return false;

            } else if (file_size > max_size) {

                $p = $('<p>').text(file_name);
                msg = 'Файл <strong>' + $p.text() + '</strong> имеет слишком большой размер.<br />Максимально допустимый размер файла: <strong>10 MB</strong>';

                $status.html($status.html() + '<div>' + msg + '</div>').removeClass('hidden');
                return false;
            }
        },
        success: function(resp) {

            var $photo = $($('#photo_template').html());

            $('img', $photo).attr('src', resp.img_small);
            $('#photos-img_small_arr', $photo).attr('value', resp.img_small);
            $('#photos-img_big_arr', $photo).attr('value', resp.img_big);

            $append_zone.append($photo.outerHTML());
            $btn.prop('disabled', false);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);

            if (progress < 100) {
                $drop_zone.removeClass('active');
                $drop_zone.addClass('loading');
                if (prev_progress < progress) {
                    prev_progress = progress;
                    $loader.css('width', progress + '%');
                }
            } else {
                $drop_zone.removeClass('active loading');
                $loader.css('width', 0);
                prev_progress = 0;
            }
        }
    });
}

function remove_uploaded_photo(obj) {
    $(obj).closest('.photo-uploaded').remove();
    if ($('#appendzone .photo-uploaded').length == 0) {
        $('#save_photos').prop('disabled', true);
    }
}