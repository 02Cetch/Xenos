$(document).ready(function () {
    $('.resume__delete').click(function () {
        var button = $(this);
        var preloader = $(this).find('i.icon-preloader');
        var params = {
            'id': $(this).attr('data-id')
        };
        preloader.show();

        $.post('/delete/delete-resume', params, function(data) {
            preloader.hide();
            button.addClass('disabled');
            button.html(data.text);
        });
        return false;
    });
    $('.vacancy__delete').click(function () {
        var button = $(this);
        var preloader = $(this).find('i.icon-preloader');
        var params = {
            'id': $(this).attr('data-id')
        };
        preloader.show();

        $.post('/delete/delete-vacancy', params, function(data) {
            preloader.hide();
            button.addClass('disabled');
            button.html(data.text);
        });
        return false;
    });
});