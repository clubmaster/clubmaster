
cmcl.booking.initialize = function() {
  // Fetch initial data from server.
  cmcl.ajax.getUsers();

  // fetch locations
  cmcl.ajax.getLocations();

  // Fetch initial fields data from server.
  cmcl.ajax.getFields(cmcl.data.location_id, cmcl.data.bookingdate );
};

cmcl.booking.updateFields = function() {
    var data = cmcl.data.fields[ cmcl.data.bookingdate.toYYYYMMDD() ],
        hourWidth = cmcl.app['min_width'];
        hours = Math.ceil(new Date( new Date(data.info.end_time) - new Date(data.info.start_time) ).getHours());

    $('#overflow').children().remove();
    cmcl.data.intervalObjects = [];

    var fields = 0;
    var intervals = 0;
    var max_intervals = 0;
    var start_time = new Date();

    $.each(data.fields, function(index, field) {
        fields++;
        $.each(field.intervals, function(index, interval) {
            var c_time = new Date(interval.start_time);
            if (start_time > c_time) {
              start_time = c_time;
            }
            intervals++;
        });

        if (intervals > max_intervals) {
          max_intervals = intervals;
        }
        intervals = 0;
    });
    if (max_intervals > 0) {
      var width = $("div#overflow").width()-60;
      var nf_width = width/max_intervals;
      if (nf_width > cmcl.app['min_width']) {
        hourWidth = nf_width;
      }
    }

    $.each(data.fields, function(index, field) {
        var fieldElement = $('<div />', {
            class: "field"
        });

        fieldElement.width(hours * hourWidth - hourWidth / 2);
        $('#overflow').append(fieldElement);

        $.each(field.intervals, function(index, interval) {
            var wrapperElement = $('<div />', {
                class: "interval_wrapper"
            });
            var intervalElement = $('<div />', {
                class: "interval"
            });
            var intervalDelta = new Date( new Date(interval.end_time) - new Date(interval.start_time) ) / 1000 / 3600;
            var startDelta = new Date( new Date(interval.start_time) - new Date(data.info.start_time) ) / 1000 / 3600;
            var formatStart = new Date( interval.start_time).toString('HH:mm');
            var formatEnd = new Date( interval.end_time).toString('HH:mm');
            var past = new Date().compareTo( new Date(interval.start_time)) >= 0;
            var loggedIn = cmcl.data.user !== null;
            var intervalObject = {
                element: intervalElement,
                data: interval
            };

            cmcl.data.intervalObjects.push(intervalObject);

            intervalElement.click( function() {
                cmcl.booking.showBookingDialog(intervalObject);
            });

            wrapperElement.width(intervalDelta * hourWidth + 'px');
            wrapperElement.css('left', startDelta * hourWidth  + 'px');

            fieldElement.append(wrapperElement);
            wrapperElement.append(intervalElement);
            intervalElement.append('<div style="margin:5px;"><span style="float:left;">'+ formatStart +'</span><span style="float:right;">' + formatEnd + '</span></div>');
            intervalElement.append('<div style="margin:30px;"><span>'+field.name+'</span></div>');
        });
    });

    if (fields > 0) {
      var height = $("div#overflow").height()-35;
      var nf_height = height/fields;
      if (nf_height > cmcl.app['min_height']) {
        $(".field").css('height', (nf_height+1)+'px');
        $(".interval_wrapper").css('height', nf_height+'px');
      }
    }

    var now = new Date();
    var diff = now.getTime()-start_time.getTime();
    diff = diff/1000/60/60;
    $('#overflow').scrollLeft((hourWidth*diff)-100);
};


cmcl.booking.updateBookings = function() {
    var bookings = cmcl.data.bookings[ cmcl.data.bookingdate.toYYYYMMDD() ];

    $.each(bookings, function(index, booking) {
        var type = booking.type; // booking or team
        if(type === 'booking') {
            var fieldId = booking.field_id;
            var intervalObject = cmcl.booking.getAffectedIntervals(fieldId, new Date(booking.first_date), new Date(booking.end_date))[0];
            var past = new Date().compareTo( new Date(intervalObject.data.start_time)) >= 0;
            var userBooking = cmcl.data.user && (cmcl.data.user.id === booking.user.id || (booking.users && cmcl.data.user.id === booking.users[0].id)) && !past;
            var partner = '';

            if (booking.guest) {
              partner = 'Gæst';
            } else if (booking.users) {
              partner = booking.users[0].first_name+' '+booking.users[0].last_name;
            }
            intervalObject.element.html('<div style="margin: 5px"><span>'+booking.user.first_name+' '+booking.user.last_name+' - '+partner+'</span></div>');

            intervalObject.element.addClass(userBooking ? 'book-user' : 'book-normal');
            intervalObject.data['booking'] = booking;
        } else if(type === 'team' || type === 'plan') {
            $.each(booking.fields, function(index, field_booking) {
                var fieldId = field_booking.id;
                var intervalObjects = cmcl.booking.getAffectedIntervals(fieldId, new Date(booking.first_date), new Date(booking.end_date));

                $.each(intervalObjects, function(index, intervalObject) {
                    intervalObject.element.addClass(type === 'team' ? 'book-team' : 'book-plan');
                    if (type == 'team') {
                      intervalObject.element.html('<div style="margin: 5px"><span>'+booking.team_name+'</span></div>');
                    } else if (type == 'plan') {
                      intervalObject.element.html('<div style="margin: 5px"><span>'+booking.name+'</span></div>');
                    }
                    intervalObject.data['booking'] = booking;
                });
            });
        }
    });
};


cmcl.booking.showBookingDialog = function(intervalObject) {
    var data = intervalObject.data;
    var loggedIn = cmcl.data.user !== null;
    var past = new Date().compareTo( new Date(data.start_time)) >= 0;

    cmcl.data.bookinginterval = data;

    var start=new Date( data.start_time);
    var end=new Date( data.end_time);

    var location_name = '';
    $.each(cmcl.data.locations, function(index, location) {
        if (location.id == cmcl.data.location_id) {
          location_name = location.location_name;
        }
    });

    var field_name = '';
    var d = new Date();
    $.each(cmcl.data.fields[d.toString('yyyy-MM-dd')].fields, function(index, field) {
        if (field.id == data.field) {
          field_name = field.name;
        }
    });

    $('.interval_location span').text(location_name);
    $('.interval_field span').text(field_name);
    $('.interval_date span').text(start.toString('dd/MM/yyyy'));
    $('.interval_time span').text(start.toString('HH:mm')+' - '+end.toString('HH:mm'));

    if (data.booking) {
      $('.interval_confirmed').hide();
      $('.interval_booker').show();

      if (data.booking.type == 'booking') {
        $('.interval_confirmed').show();

        if (data.booking.confirmed) {
          $('.interval_confirmed span').text('Ja');
        } else {
          $('.interval_confirmed span').text('Nej');
        }

        var userBooking = cmcl.data.user && (cmcl.data.user.id === data.booking.user.id || (data.booking.users && cmcl.data.user.id === data.booking.users[0].id)) && !past;
        if (userBooking) {
          $(".ui-dialog-buttonpane button:contains('Slet')").button("enable");
        } else {
          $(".ui-dialog-buttonpane button:contains('Slet')").button("disable");
        }

        $('.interval_partner').show();

        $('.interval_booker span').text(data.booking.user.first_name+' '+data.booking.user.last_name);
        if (data.booking.guest) {
          $('.interval_partner span').text('Gæst');
        } else if (data.booking.users) {
          $('.interval_partner span').text(data.booking.users[0].first_name+' '+data.booking.users[0].last_name);
        }
      } else if (data.booking.type == 'team') {
        $(".ui-dialog-buttonpane button:contains('Slet')").button("disable");
        $('.interval_booker span').text(data.booking.team_name);
        $('.interval_partner').hide();
      } else if (data.booking.type == 'plan') {
        $(".ui-dialog-buttonpane button:contains('Slet')").button("disable");
        $('.interval_booker span').text(data.booking.name);
        $('.interval_partner').hide();
      }
    } else {
      $(".ui-dialog-buttonpane button:contains('Slet')").button("disable");
      $('.interval_booker').hide();
      $('.interval_partner').hide();
      $('.interval_confirmed').hide();
    }

    if (past || data.booking) {
      $(".ui-dialog-buttonpane button:contains('Find medlem')").button("disable");
      $(".ui-dialog-buttonpane button:contains('Book')").button("disable");
    } else {
      $(".ui-dialog-buttonpane button:contains('Find medlem')").button("enable");
      $(".ui-dialog-buttonpane button:contains('Book')").button("enable");
    }

    if (loggedIn) {
      $('#booking_dialog').dialog('open');
    } else {
      $('#interval_dialog').dialog('open');
    }
};


cmcl.booking.getAffectedIntervals = function(fieldId, inStartTime, inEndTime) {
    var intervalObjects = cmcl.data.intervalObjects;
    var foundElements = [];

    $.each(intervalObjects, function(index, intervalObject) {
        var data = intervalObject.data;
        var startTime = new Date(data.start_time);
        var endTime = new Date(data.end_time);

        if(data.field == fieldId) {
            if(
               (inStartTime.compareTo(startTime) <= 0 && inEndTime.compareTo(endTime) >= 0) ||
               (startTime.compareTo(inStartTime) == -1 && endTime.compareTo(inStartTime) == 1) ||
               (startTime.compareTo(inEndTime) == -1 && endTime.compareTo(inEndTime) == 1)
            ) {
                foundElements.push(intervalObject);
            }
        }
    });

    return foundElements;
};


cmcl.booking.updateDialogButton = function() {
    var user_id = $('#search_results').val();
    if(user_id) {
        $(".ui-dialog-buttonpane button:contains('Book Bane')").button("enable");
    } else {
        $(".ui-dialog-buttonpane button:contains('Book Bane')").button("disable");
    }
};
