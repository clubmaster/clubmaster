cmcl.user.logout = function() {
  var date = new Date();
  cmcl.data.bookingdate = date;
  $("#booking_date_picker").datepicker('setDate', date);

  if (cmcl.data.user != null) {
    cmcl.data.user = null;
    $('#button_logout').hide();
    $('#auth_dialog').hide();
    $('#button_login').show();

    cmcl.user.authHeader = null;
    cmcl.booking.updateFields();
    cmcl.booking.updateBookings();
  }
};
