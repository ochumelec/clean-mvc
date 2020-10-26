jQuery(document).ready(function () {
    jQuery('#scrollup img').mouseover(function () {
        jQuery(this).animate({opacity: 0.65}, 100);
    }).mouseout(function () {
        jQuery(this).animate({opacity: 1}, 100);
    }).click(function () {
        window.scroll(0, 0);
        return false;
    });

    jQuery(window).scroll(function () {
        if (jQuery(document).scrollTop() > 0) {
            jQuery('#scrollup').fadeIn('fast');
        } else {
            jQuery('#scrollup').fadeOut('fast');
        }
    });

    function init_alerts() {
        var domain = window.location.hostname;
        $.ajax({
            method: "GET",
            url: 'http://' + domain + '/alert/get_all',
            dataType: 'json',
            data: {},
        }).done(function (msg) {
            var alerts = msg;
            if (alerts != 'false') {

                $(alerts).each(function (i, data) {
                    show_alert_body(data.type, data.msg);
                });
            }

        });

    }


    init_alerts();
});

function show_alert_body(type, msg) {
    var alert_type = type;
    var alert_msg = msg;
    var alert_body = '<div class="alert alert-' + alert_type + ' fade in">' +
        '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' +
        '<strong>' + alert_type + '! </strong>' +
        alert_msg
        + '</div>';
    $('#alerts').append(alert_body);
}

function set_alert(type, msg) {

    var domain = window.location.hostname;
    var alerts = [{
        'type': type,
        'msg': msg
    }];
    var json = JSON.stringify(alerts);
    //console.log(json);
    $.ajax({
        method: "POST",
        url: 'http://' + domain + '/alert/set',
        dataType: 'json',
        data: {'alerts': json},
    }).done(function (data) {
        show_alert_body(type, msg);
    });
}


function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return '';
}

function get(name) {
    if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}