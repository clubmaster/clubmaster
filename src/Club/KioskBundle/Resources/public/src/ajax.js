cmcl.ajax.always = function(data, textStatus, error) {
    cmcl.decrementLoading();
}
cmcl.ajax.beforeSend = function(jqXHR, settings) {
    cmcl.incrementLoading();
}
cmcl.ajax.defaultError = function() {
    $('#error_message').text('Fejl med internettet prøv igen...');
    $('#error_dialog').dialog('open');
}

cmcl.ajax.login = function(username, password) {

    $("#booking_dialog").dialog("close");
    $("#interval_dialog").dialog("close");

    var authValue = username + ':' + password;
    var authHeader = { 'Authorization': 'Basic ' + $.base64.encode(authValue), 'API_KEY': this.api_key };
    var success = function(json, textStatus, jqXHR) {
        $('#login_dialog').dialog('close');
        $('#button_logout').show();
        $('#button_login').hide();
        $('#auth_dialog').show();

        cmcl.data.user = $.parseJSON(json).data;
        cmcl.booking.updateFields();
        cmcl.booking.updateBookings();

        $('#auth_user').text(cmcl.data.user.first_name+' '+cmcl.data.user.last_name);
    };
    var settings = {
        headers: authHeader,
        url: this.base + 'auth',
        type: 'POST',
        always: cmcl.ajax.complete,
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    cmcl.user.authHeader = authHeader;

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        $('#login_dialog_error').text('Forkert brugernavn el. password');
    })
    ;
};

cmcl.ajax.getTickers = function() {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.tickers = $.parseJSON(json).data;
        cmcl.ticker.initialize();
    };
    var settings = {
        url: this.base + 'news',
        type: 'GET',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        cmcl.ajax.defaultError();
    })
    ;
};

cmcl.ajax.getUsers = function() {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.users = $.parseJSON(json).data;
    };
    var settings = {
        url: this.base + 'users',
        type: 'GET',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        cmcl.ajax.defaultError();
    })
    ;
};

cmcl.ajax.getLocations = function() {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.locations = $.parseJSON(json).data;
    };
    var settings = {
        url: this.base + 'locations',
        type: 'GET',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        cmcl.ajax.defaultError();
    })
    ;
};

cmcl.ajax.getFields = function(locationid, date) {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.fields[date.toYYYYMMDD()] = $.parseJSON(json).data;
        cmcl.booking.updateFields();

        cmcl.ajax.getBookings(locationid, date);
    };
    var settings = {
        url: this.base + 'fields/' + locationid + '/' + date.toYYYYMMDD(),
        type: 'GET',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        cmcl.ajax.defaultError();
    })
    ;
};

cmcl.ajax.getBookings = function(locationid, date) {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.bookings[date.toYYYYMMDD()] = $.parseJSON(json).data;
        cmcl.booking.updateBookings();
    };
    var settings = {
        url: this.base + 'bookings/' + locationid + '/' + date.toYYYYMMDD(),
        type: 'GET',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        cmcl.ajax.defaultError();
    })
    ;
};

cmcl.ajax.bookField = function(date, interval_id, user_id) {
    var success = function(text, textStatus, jqXHR) {
        $('#user_search_dialog').dialog('close');
        $('#interval_dialog').dialog('close');
        $('#booking_dialog').dialog('close');
        cmcl.ajax.getFields(cmcl.data.location_id, cmcl.data.bookingdate);
    };
    var settings = {
        headers: cmcl.user.authHeader,
        url: this.base + 'bookings/book/' + date.toYYYYMMDD() + '/' + interval_id + '/' + user_id,
        type: 'POST',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        $('#user_search_dialog').dialog('close');
        if (jqXHR.status === 403) {
            var message = $.parseJSON( jqXHR.responseText ).data;
            $('#error_message').text(message);
            $('#error_dialog').dialog('open');
        } else {
            cmcl.ajax.defaultError();
        }
    })
    ;
};

cmcl.ajax.bookFieldGuest = function(date, interval_id) {
    var success = function(text, textStatus, jqXHR) {
        $('#interval_dialog').dialog('close');
        $('#booking_dialog').dialog('close');
        cmcl.ajax.getFields(cmcl.data.location_id, cmcl.data.bookingdate);
    };
    var settings = {
        headers: cmcl.user.authHeader,
        url: this.base + 'bookings/book/' + date.toYYYYMMDD() + '/' + interval_id + '/guest',
        type: 'POST',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        $('#interval_dialog').dialog('close');
        $('#booking_dialog').dialog('close');
        if (jqXHR.status === 403) {
            var message = $.parseJSON( jqXHR.responseText ).data;
            $('#error_message').text(message);
            $('#error_dialog').dialog('open');
        } else {
            cmcl.ajax.defaultError();
        }
    })
    ;
};

cmcl.ajax.cancelBooking = function(booking_id) {
    var success = function(text, textStatus, jqXHR) {
        cmcl.ajax.getFields(cmcl.data.location_id, cmcl.data.bookingdate);
        $('#booking_dialog').dialog('close');
    };
    var settings = {
        headers: cmcl.user.authHeader,
        url: this.base + 'bookings/cancel/' + booking_id,
        type: 'POST',
        success: success,
        beforeSend: cmcl.ajax.beforeSend
    };

    $.ajax( settings )
        .always(function() {
            cmcl.ajax.always();
        })
    .fail(function(jqXHR, textStatus) {
        cmcl.ajax.defaultError();
    })
    ;
};
