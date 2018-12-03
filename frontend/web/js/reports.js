$(document).ready(function () {
    $('.user__profile__container__report').click(function () {
        var button = $(this);
        var preloader = $(this).find('i.icon-preloader');
        var params = {
            'id': $(this).attr('data-id')
        };
        preloader.show();

        $.post('/report/report-profile', params, function(data) {
            preloader.hide();
            button.addClass('disabled');
            button.html(data.text);
        });
        return false;
    });
    $('.vacancy__report').click(function () {
        var button = $(this);
        var preloader = $(this).find('i.icon-preloader');
        var params = {
            'id': $(this).attr('data-id')
        };
        preloader.show();

        $.post('/report/report-vacancy', params, function(data) {
            preloader.hide();
            button.addClass('disabled');
            button.html(data.text);
        });
        return false;
    });
    $('.user__profile__container__report').click(function () {
        var button = $(this);
        var preloader = $(this).find('i.icon-preloader');
        var params = {
            'id': $(this).attr('data-id')
        };
        preloader.show();

        $.post('/report/report-resume', params, function(data) {
            preloader.hide();
            button.addClass('disabled');
            button.html(data.text);
        });
        return false;
    });
});