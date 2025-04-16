let messagesCookies = document.getElementById('messages_cookies');

$(document).ready(function () {
    $('.messages_cookies-close').click(function () {
        messagesCookies.classList.remove('uk-position-bottom', 'uk-position-fixed', 'uk-background-muted');
        messagesCookies.classList.add('uk-hidden');
        document.cookie = "messages_cookies=true; samesite=strict; max-age=1209600; path=/";
        return false;
    });
});
