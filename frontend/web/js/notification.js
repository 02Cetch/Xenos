$(document).ready(function () {
    $('.resume__report').click(function () {
        var params = {
            'receiverId': $(this).attr('receiver-id'),
            'resumeId': $(this).attr('resume-id')
        };

        $.post('/notifications/create/type-liked-resume-by-company', params, function(data) {
            // preloader.hide();
            // button.addClass('disabled');
            // button.html(data.text);
        });
        return false;
    });
});