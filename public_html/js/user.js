$(document).ready(function () {
    $('#signUp form').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var action = 'user/signup.php';
        $.post(action, data)
            .done(function (data) {
                window.location.replace('index.php', data);
            })
            .fail(function (jqXHR) {
                if (jqXHR.responseText !== '') {
                    $('.errors').addClass('open').find('li').text(jqXHR.responseText);
                }
            });
    });
});