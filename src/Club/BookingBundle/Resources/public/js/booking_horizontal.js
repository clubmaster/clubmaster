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

function makeBookedUrl(booking, url, pixel_size, field_width, day_start)
{
  var start = Date.parse(booking.first_date);
  var end = Date.parse(booking.end_date);
  var diff=(end-start)/1000/60;
  var day_diff=(start-day_start)/1000/60;
  var ret = '';

  var height=((diff*pixel_size)-6)+'px';
  var top=(day_diff*pixel_size)+'px';
  var width=(field_width-1)+'px';
  var date = Date.parse(booking.first_date);

  if (booking.type == 'booking') {
    var left=$("#field_"+booking.field_id).css('left');

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
      var left=$("#field_"+this.id).css('left');

      if (left) ret = ret+'<div class="link team" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';" onclick="location.href=\''+url+'booking/view/team/'+booking.id+'/'+this.id+'\'">&#160;'+booking.team_name+'</div>';
    });
  } else if (booking.type == 'plan') {
    $.each(booking.fields, function() {
      var left=$("#field_"+this.id).css('left');

      if (left) ret = ret+'<div class="link plan" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';" onclick="location.href=\''+url+'booking/view/plan/'+booking.id+'/'+this.id+'/'+getDate(date)+'\'">&#160;'+booking.name+'</div>';
    });

  }

  return ret;
}

function initBookings(location, date, url, pixel_size, field_width, day_start)
{
  $.getJSON(url+'api/bookings/'+location+"/"+getDate(date), function(json) {
    $.each(json.data, function() {
      $("#bookings").append(makeBookedUrl(this, url, pixel_size, field_width, day_start));
    });
  });
}

function initTable(location, date, url, hour_height, field_width)
{
  var fields=0;
  var times=0;
  var pixel_size=hour_height/60;
  var current_time=new Date();
  var start_position=0;

  $.getJSON(url+'api/fields/'+location+"/"+getDate(date), function(json) {
    var startTime = Date.parse(json.data.info.start_time);
    var endTime = Date.parse(json.data.info.end_time);

    var day_start=startTime.getTime();

    // parse times
    var top=0;
    while (startTime.getTime() < endTime.getTime()) {
      times++;
      $("#times").append('<div style="top: '+top+'px; height: '+hour_height+'px;">&#160;'+checkTime(startTime.getHours())+':'+checkTime(startTime.getMinutes())+'</div>');
      startTime.setHours(startTime.getHours()+1);
      top = top+hour_height;
    }

    // parse fields
    var left=0;
    $.each(json.data.fields, function() {
      fields++;
    });

    var max = $("#overlay").width()-100;
    if (fields*field_width < max) {
      field_width = max/fields;
    }

    fields = 0;
    $.each(json.data.fields, function() {
      fields++;

      $("#fields").append('<div id="field_'+this.id+'" style="width: '+field_width+'px; left: '+left+'px">&#160;'+this.name+'</div>');

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
        $("div#interval_"+this.id).css('height', ((diff*pixel_size)-6)+'px');
        $("div#interval_"+this.id).css('top', (day_diff*pixel_size)+'px');
        $("div#interval_"+this.id).css('left', left+'px');
        $("div#interval_"+this.id).css('width', ((field_width)-1)+'px');

      });

      left = left+field_width;
    });

    var height=((times)*hour_height)+40;
    var fields_width=(fields*field_width)+1;
    var width=fields_width+100;

    $('div#overlay').css('height', height+'px');
    $('div#booking').css('height', height+'px');
    $('div#booking').css('width', width+'px');
    $('div#times').css('height', height+'px');
    $('div#nav_overlay').css('height', height+'px');
    $('div#nav_overlay').css('width', fields_width+'px');
    $('div#fields').css('width', $("#booking").width()+'px');
    $('div#times').css('width', '100px');

    if ($("#overlay").width() > width) {
      $("#overlay").css('width', width+'px');
    }

    initBookings(location, date, url, pixel_size, field_width, day_start);

    $('#preloader').hide();
    $('#booking').show();
  });
}

$(function() {
  $("#prev").click(function() {
    var scroll_width = getScrollWidth();
    var position = $("#fields").position();
    var new_pos = position.left+scroll_width;
    if (new_pos > 0) {
      var new_pos = 0;
    }

    $("#fields").css('left', new_pos+'px');
    $("#intervals").css('left', new_pos+'px');
    $("#bookings").css('left', new_pos+'px');
  });
  $("#next").click(function() {
    var overlay_width = $("#overlay").width();
    var fields_width = $("#booking").width();
    var scroll_width = getScrollWidth();
    var position = $("#fields").position();
    var max_left = (fields_width-overlay_width)*-1;
    var new_pos = position.left-scroll_width;
    if (new_pos < max_left) {
      new_pos = max_left;
    }

    $("#fields").css('left', new_pos+'px');
    $("#intervals").css('left', new_pos+'px');
    $("#bookings").css('left', new_pos+'px');
  });
});
