function getScrollWidth()
{
  return 300;
}

function checkTime(i)
{
  if (i >= 10) {
    return i;
  }
  return '0'+i;
}

function getDate(date)
{
    return date.getFullYear()+'-'+checkTime(date.getMonth()+1)+'-'+checkTime(date.getDate());
}

function getTime(date)
{
    return date.getHours()+':'+checkTime(date.getMinutes());
}

function makePastIntervalUrl(interval)
{
  var start = Date.parse(interval.start_time);
  var end = Date.parse(interval.end_time);

  return '<div class="past" id="interval_'+interval.id+'">&#160;'+getTime(start)+'-'+getTime(end)+'</div>';
}

function makeIntervalUrl(interval, date, url)
{
  var start = Date.parse(interval.start_time);
  var end = Date.parse(interval.end_time);

  return '<div class="future link" id="interval_'+interval.id+'" onclick="location.href = \''+url+'booking/'+getDate(date)+'/'+interval.id+'\'">&#160;'+getTime(start)+'-'+getTime(end)+'</div>';
}

function makeBookedUrl(booking, url, pixel_size, field_height, day_start)
{
  var start = Date.parse(booking.first_date);
  var end = Date.parse(booking.end_date);
  var diff=(end-start)/1000/60;
  var day_diff=(start-day_start)/1000/60;
  var ret = '';

  var width=((diff*pixel_size)-1)+'px';
  var left=(day_diff*pixel_size)+'px';
  var height=(field_height-6)+'px';
  var date = Date.parse(booking.first_date);

  if (booking.type == 'booking') {
    var top=$("#field_"+booking.field_id).css('top');

    var book_str = booking.user.first_name+' '+booking.user.last_name+' - ';
    if (booking.guest == true) {
      book_str = book_str+'Guest';
    } else {
      $.each(booking.users, function() {
        book_str = book_str+this.first_name+' '+this.last_name;
      });
    }
    ret='<div class="link booking" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';" onclick="location.href=\''+url+'booking/view/booking/'+booking.id+'\'">&#160;'+book_str+'</div>';
  } else if (booking.type == 'team') {
    $.each(booking.fields, function() {
      var top=$("#field_"+this.id).css('top');

      if (top) ret = ret+'<div class="link team" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';" onclick="location.href=\''+url+'booking/view/team/'+booking.id+'/'+this.id+'\'">&#160;'+booking.team_name+'</div>';
    });
  } else if (booking.type == 'plan') {
    $.each(booking.fields, function() {
      var top=$("#field_"+this.id).css('top');

      if (top) ret = ret+'<div class="link plan" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';" onclick="location.href=\''+url+'booking/view/plan/'+booking.id+'/'+this.id+'\'">&#160;'+booking.name+'</div>';
    });

  }

  return ret;
}

function initBookings(location, date, url, pixel_size, field_height, day_start)
{
  $.getJSON(url+'api/bookings/'+location+"/"+getDate(date), function(json) {
    $.each(json.data, function() {
      $("#bookings").append(makeBookedUrl(this, url, pixel_size, field_height, day_start));
    });
  });
}

function initTable(location, date, url, hour_width, field_height)
{
  var fields=0;
  var times=0;
  var pixel_size=hour_width/60;
  var current_time=new Date();
  var start_position=0;

  $.getJSON(url+'api/fields/'+location+"/"+getDate(date), function(json) {
    var startTime = Date.parse(json.data.info.start_time);
    var endTime = Date.parse(json.data.info.end_time);

    var day_start=startTime.getTime();

    // parse times
    var left=0;

    while (startTime.getTime() < endTime.getTime()) {
      times++;
      $("#times").append('<div style="width: '+hour_width+'px; left: '+left+'px">'+checkTime(startTime.getHours())+':'+checkTime(startTime.getMinutes())+'</div>');
      left = left+hour_width;
      startTime.setHours(startTime.getHours()+1);
    }

    // parse fields
    var top=0;
    $.each(json.data.fields, function() {
      fields++;

      $("#fields").append('<div id="field_'+this.id+'" class="field" style="top: '+top+'px; height: '+field_height+'px;">&#160;'+this.name+'</div>');

      // parse intervals
      $.each(this.intervals, function() {
        var start = Date.parse(this.start_time);
        var end = Date.parse(this.end_time);
        var diff=(end-start)/1000/60;
        var day_diff=(start-day_start)/1000/60;

        if (start.getTime() < current_time.getTime() && (start.getHours() == current_time.getHours() || start.getHours() < current_time.getHours())) {
          start_position = day_diff*pixel_size*-1;
        }

        if (start < current_time) {
          $("#intervals").append(makePastIntervalUrl(this));
        } else {
          $("#intervals").append(makeIntervalUrl(this,date,url));
        }
        $("div#interval_"+this.id).addClass('interval');
        $("div#interval_"+this.id).css('height', (field_height-6)+'px');
        $("div#interval_"+this.id).css('top', top+'px');
        $("div#interval_"+this.id).css('left', (day_diff*pixel_size)+'px');
        $("div#interval_"+this.id).css('width', ((diff*pixel_size)-1)+'px');

      });

      top = top+field_height;
    });

    var height=((fields)*field_height)+40;
    var times_width=((times)*hour_width)-(times*2);
    var width=times_width+100;

    $('div#overlay').css('height', height+'px');
    $('div#booking').css('height', height+'px');
    $('div#booking').css('width', width+'px');
    $('div#times').css('height', height+'px');
    $('div#nav_overlay').css('height', height+'px');
    $('div#nav_overlay').css('width', times_width+'px');
    $('div#fields').css('width', $("#booking").width()+'px');

    if ($("#overlay").width() > width) {
      $("#overlay").css('width', width+'px');
    }

    // set booking position
    var overlay_width = $("#overlay").width();
    var times_width = $("#booking").width();
    var max_left = (times_width-overlay_width)*-1;
    if (times_width < overlay_width) {
      start_position = 0;
    } else if (start_position < max_left) {
      start_position = max_left;
    }

    $('div#times').css('left', start_position+'px');
    $('div#intervals').css('left', start_position+'px');
    $('div#bookings').css('left', start_position+'px');

    initBookings(location, date, url, pixel_size, field_height, day_start);

    $('#preloader').hide();
    $('#booking').show();
  });
}

$(function() {
  $("#prev").click(function() {
    var scroll_width = getScrollWidth();
    var position = $("#times").position();
    var new_pos = position.left+scroll_width;
    if (new_pos > 0) {
      var new_pos = 0;
    }

    $("#times").css('left', new_pos+'px');
    $("#intervals").css('left', new_pos+'px');
    $("#bookings").css('left', new_pos+'px');
  });
  $("#next").click(function() {
    var overlay_width = $("#overlay").width();
    var times_width = $("#booking").width();
    var scroll_width = getScrollWidth();
    var times = $("#times").position();
    var position = $("#times").position();
    var max_left = (times_width-overlay_width)*-1;
    var new_pos = position.left-scroll_width;
    if (new_pos < max_left) {
      new_pos = max_left;
    }

    $("#times").css('left', new_pos+'px');
    $("#intervals").css('left', new_pos+'px');
    $("#bookings").css('left', new_pos+'px');
  });
});
