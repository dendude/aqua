(function($)
{
    $.Redactor.prototype.myplugins = function()
    {
        return {
            init: function()
            {


                var undo = this.button.addFirst('undo', 'Назад');
                var redo = this.button.addAfter('undo', 'redo', 'Вперед');

                this.button.addCallback(undo, this.buffer.undo);
                this.button.addCallback(redo, this.buffer.redo);

                var und = this.button.addAfter('italic', 'underline', 'Подчеркивание');
                var sup = this.button.addAfter('deleted', 'superscript', 'Верхний индекс');
                var sub = this.button.addAfter('superscript', 'subscript', 'Нижний индекс');

                // make your added buttons as Font Awesome's icon
                this.button.setAwesome('superscript', 'fa-superscript');
                this.button.setAwesome('subscript', 'fa-subscript');

                this.button.addCallback(sup, this.myplugins.formatSup);
                this.button.addCallback(sub, this.myplugins.formatSub);
                this.button.addCallback(und, this.myplugins.formatUnd);
            },
            formatSup: function()
            {
                this.inline.format('sup');
            },
            formatSub: function()
            {
                this.inline.format('sub');
            },
            formatUnd: function()
            {
                this.inline.format('u');
            }
        };
    };

})(jQuery);