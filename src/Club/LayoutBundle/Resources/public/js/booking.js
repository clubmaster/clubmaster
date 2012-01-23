function getScrollWidth()
{
  alert
  return 200;
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
  var start = new Date(interval.start_time);
  var end = new Date(interval.end_time);

  return getTime(start)+'-'+getTime(end);
}

function makeIntervalUrl(interval, date, url)
{
  var start = new Date(interval.start_time);
  var end = new Date(interval.end_time);

  return '<a href="'+url+'booking/'+getDate(date)+'/'+interval.id+'" title="'+getTime(start)+'-'+getTime(end)+'">'+getTime(start)+'-'+getTime(end)+'</a>';
}

function makeBookedUrl(interval,url)
{
  if (interval.booking) {
    var date = new Date(interval.booking.date);
    return '<a href="'+url+'booking/'+getDate(date)+'/'+interval.id+'" title="'+interval.booking.user.first_name+' '+interval.booking.user.last_name+'">'+interval.booking.user.first_name+' '+interval.booking.user.last_name+'</a>';
  } else {
    var date = new Date(interval.start_time);
    return '<a href="'+url+'booking/'+getDate(date)+'/'+interval.id+'" title="'+interval.schedule.team_name+'">'+interval.schedule.team_name+'</a>';

  }
}

function initBookings(location, date, url)
{
  $.getJSON(url+'api/bookings/'+location+"/"+getDate(date), function(json) {
    $.each(json.data, function() {
      if (this.booking) {
        console.log("Found booking, id: "+this.booking.id+", interval id: "+this.id);

        var top=$('div#interval_'+this.id).css('top');
        var left=$('div#interval_'+this.id).css('left');
        var width=$('div#interval_'+this.id).css('width');
        var height=$('div#interval_'+this.id).css('height');

        console.log("Got styles; top:"+top+", left: "+left+", width: "+width+", height: "+height);

        $("#intervals").append('<div class="booking" booking="'+this.booking.id+'" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';">&#160;'+makeBookedUrl(this,url)+'</div>');
      } else {
        console.log("Found team, id: "+this.schedule.id+", interval id: "+this.id);

        var top=$('div#interval_'+this.id).css('top');
        var left=$('div#interval_'+this.id).css('left');
        var width=$('div#interval_'+this.id).css('width');
        var height=$('div#interval_'+this.id).css('height');

        console.log("Got styles; top:"+top+", left: "+left+", width: "+width+", height: "+height);

        $("#intervals").append('<div class="booking" team="'+this.schedule.id+'" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';">&#160;'+makeBookedUrl(this,url)+'</div>');
      }
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
    var startTime=new Date(json.data.info.start_time);
    var endTime=new Date(json.data.info.end_time);
    console.log("Found start time: "+startTime);
    console.log("Found end time: "+endTime);

    var day_start=startTime.getTime();
    console.log("Field unix start_time: "+day_start);

    // parse times
    var left=0;

    while (startTime.getTime() < endTime.getTime()) {
      times++;
      $("#times").append('<div class="time" style="width: '+hour_width+'px; left: '+left+'px">'+checkTime(startTime.getHours())+':'+checkTime(startTime.getMinutes())+'</div>');
      left = left+hour_width;
      startTime.setHours(startTime.getHours()+1);
    }

    // parse fields
    var top=0;
    $.each(json.data.fields, function() {
      fields++;

      $("#fields").append('<div class="field" style="top: '+top+'px">&#160;'+this.name+'</div>');
      console.log("Found field, id: "+this.id+", name: "+this.name+", top: "+top);

      // parse intervals
      $.each(this.intervals, function() {
        var start=new Date(this.start_time);
        var end=new Date(this.end_time);
        var diff=(end-start)/1000/60;
        var day_diff=(start-day_start)/1000/60;
        console.log("Interval ID: "+this.id+", diff: "+diff+", day_diff: "+day_diff+", start: "+start);

        if (start_position == 0 && start.getHours() == current_time.getHours()) {
          start_position = day_diff*pixel_size*-1;
        }

        if (start < current_time) {
          $("#intervals").append('<div class="past" id="interval_'+this.id+'">&#160;'+makePastIntervalUrl(this)+'</div>');
        } else {
          $("#intervals").append('<div class="future" id="interval_'+this.id+'">&#160;'+makeIntervalUrl(this,date,url)+'</div>');
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
    var nav_overlay_width=((times)*hour_width);
    var width=nav_overlay_width+100;

    console.log('DIV height: '+height);
    console.log('DIV width: '+width);

    $('div#overlay').css('height', height+'px');
    $('div#booking').css('height', height+'px');
    $('div#booking').css('width', width+'px');
    $('div#times').css('height', height+'px');
    $('div#nav_overlay').css('height', height+'px');
    $('div#nav_overlay').css('width', nav_overlay_width+'px');
    $('div#fields').css('width', width+'px');

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

    $('#preloader').hide();
    $('#booking').show();

    initBookings(location, date, url);
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
  });
});
