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
        cmcl.decrementLoading();

        $('#auth_user').text(cmcl.data.user.first_name+' '+cmcl.data.user.last_name);
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#login_dialog_error').text('Forkert brugernavn el. password');
        cmcl.decrementLoading();
    };
    var settings = {
        headers: authHeader,
        url: this.base + 'auth',
        type: 'POST',
        success: success,
        error: error
    };

    cmcl.user.authHeader = authHeader;

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.getTickers = function() {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.tickers = $.parseJSON(json).data;
        cmcl.ticker.initialize();
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#error_message').text('Fejl med internettet pr�v igen...');
        $('#error_dialog').dialog('open');
        cmcl.decrementLoading();
    };
    var settings = {
        url: this.base + 'news',
        type: 'GET',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.getUsers = function() {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.users = $.parseJSON(json).data;
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#error_message').text('Fejl med internettet pr�v igen...');
        $('#error_dialog').dialog('open');
        cmcl.decrementLoading();
    };
    var settings = {
        url: this.base + 'users',
        type: 'GET',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.getLocations = function() {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.locations = $.parseJSON(json).data;
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#error_message').text('Fejl med internettet pr�v igen...');
        $('#error_dialog').dialog('open');
        cmcl.decrementLoading();
    };
    var settings = {
        url: this.base + 'locations',
        type: 'GET',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.getFields = function(locationid, date) {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.fields[date.toYYYYMMDD()] = $.parseJSON(json).data;
        cmcl.booking.updateFields();

        cmcl.ajax.getBookings(locationid, date);
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#error_message').text('Fejl med internettet pr�v igen...');
        $('#error_dialog').dialog('open');
        cmcl.decrementLoading();
    };
    var settings = {
        url: this.base + 'fields/' + locationid + '/' + date.toYYYYMMDD(),
        type: 'GET',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.getBookings = function(locationid, date) {
    var success = function(json, textStatus, jqXHR) {
        cmcl.data.bookings[date.toYYYYMMDD()] = $.parseJSON(json).data;
        cmcl.booking.updateBookings();
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#error_message').text('Fejl med internettet pr�v igen...');
        $('#error_dialog').dialog('open');
        cmcl.decrementLoading();
    };
    var settings = {
        url: this.base + 'bookings/' + locationid + '/' + date.toYYYYMMDD(),
        type: 'GET',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.bookField = function(date, interval_id, user_id) {
    var success = function(text, textStatus, jqXHR) {
        $('#user_search_dialog').dialog('close');
        $('#interval_dialog').dialog('close');
        $('#booking_dialog').dialog('close');
        cmcl.ajax.getFields(cmcl.data.location_id, cmcl.data.bookingdate);
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#user_search_dialog').dialog('close');
        if (jqXHR.status === 403) {
            var message = $.parseJSON( jqXHR.responseText ).data;
            $('#error_message').text(message);
            $('#error_dialog').dialog('open');
        } else {
            $('#error_message').text('Fejl med internettet pr�v igen...');
            $('#error_dialog').dialog('open');
        }
        cmcl.decrementLoading();
    };
    var settings = {
        headers: cmcl.user.authHeader,
        url: this.base + 'bookings/book/' + date.toYYYYMMDD() + '/' + interval_id + '/' + user_id,
        type: 'POST',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.bookFieldGuest = function(date, interval_id) {
    var success = function(text, textStatus, jqXHR) {
        $('#interval_dialog').dialog('close');
        $('#booking_dialog').dialog('close');
        cmcl.ajax.getFields(cmcl.data.location_id, cmcl.data.bookingdate);
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#interval_dialog').dialog('close');
        $('#booking_dialog').dialog('close');
        if (jqXHR.status === 403) {
            var message = $.parseJSON( jqXHR.responseText ).data;
            $('#error_message').text(message);
            $('#error_dialog').dialog('open');
        } else {
            $('#error_message').text('Fejl med internettet pr�v igen...');
            $('#error_dialog').dialog('open');
        }
        cmcl.decrementLoading();
    };
    var settings = {
        headers: cmcl.user.authHeader,
        url: this.base + 'bookings/book/' + date.toYYYYMMDD() + '/' + interval_id + '/guest',
        type: 'POST',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};

cmcl.ajax.cancelBooking = function(booking_id) {
    var success = function(text, textStatus, jqXHR) {
        cmcl.ajax.getFields(cmcl.data.location_id, cmcl.data.bookingdate);
        $('#booking_dialog').dialog('close');
        cmcl.decrementLoading();
    };
    var error = function(jqXHR, textStatus, errorThrown) {
        $('#error_message').text('Fejl med internettet pr�v igen...');
        $('#error_dialog').dialog('open');
        cmcl.decrementLoading();
    };
    var settings = {
        headers: cmcl.user.authHeader,
        url: this.base + 'bookings/cancel/' + booking_id,
        type: 'POST',
        success: success,
        error: error
    };

    $.ajax( settings );
    cmcl.incrementLoading();
};
