$(document).ready(function () {
    $('.resume__delete').click(function () {
        var button = $(this);
        var preloader = $(this).find('i.icon-preloader');
        var params = {
            'id': $(this).attr('data-id')
        };
        preloader.show();

        $.post('/resume/resume/delete', params, function(data) {
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

        $.post('/vacancy/vacancy/delete', params, function(data) {
            preloader.hide();
            button.addClass('disabled');
            button.html(data.text);
        });
        return false;
    });
});