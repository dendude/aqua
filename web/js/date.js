/**
 * время с учётом временной зоны
 */
function utcToLocal(u) {

    if (u == 0) return '';

    var n = new Date(); // текущая дата
    var t = new Date(n.getTime() - 3600*24*1000); // вчерашняя дата

    var d = new Date(u*1000/* - n.getTimezoneOffset() * 60 * 1000*/);
    var m = wZ(d.getMonth()+1);

    switch (m) {
        case '01': m = 'янв'; break;
        case '02': m = 'фев'; break;
        case '03': m = 'мар'; break;
        case '04': m = 'апр'; break;
        case '05': m = 'май'; break;
        case '06': m = 'июн'; break;
        case '07': m = 'июл'; break;
        case '08': m = 'авг'; break;
        case '09': m = 'сен'; break;
        case '10': m = 'окт'; break;
        case '11': m = 'ноя'; break;
        case '12': m = 'дек'; break;
    }

    var cur_date = n.getDate()+''+n.getMonth()+''+n.getFullYear();
    var tom_date = t.getDate()+''+t.getMonth()+''+t.getFullYear();
    var dat_date = d.getDate()+''+d.getMonth()+''+d.getFullYear();
    var dat_time = wZ(d.getHours()) + ':' + wZ(d.getMinutes());
    var dl;

    if (dat_date === cur_date) {
        dl = 'Сегодня ' + dat_time;
    } else if (dat_date === tom_date) {
        dl = 'Вчера ' + dat_time;
    } else {
        dl = wZ(d.getDate()) + ' ' + m + ' ' + d.getFullYear() + ' ' + dat_time;
    }

    return dl;
}
function wZ(x) { if (x <= 9) return '0' + x; return x; }
function doCurrentDate(selector) {
    if (typeof(selector) == 'number') {
        // если передано число
        return utcToLocal(selector);
    }
    $(selector).each(function() {
        var $this = $(this);
        if ($this.hasClass('timeset') === false) {
            $this.text(utcToLocal($this.text()));
            $this.addClass('timeset');
        }
    });
}