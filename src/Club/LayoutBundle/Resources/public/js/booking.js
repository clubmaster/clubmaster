function checkTime(i)
{
  if (i >= 10) {
    return i;
  }
  return '0'+i;
}

function initBookings()
{
  $.getJSON("/api/bookings/2", function(json) {
    $.each(json.data, function() {
      console.log("Found booking, id: "+this.booking.id+", interval id: "+this.id);

      var top=$('div#interval_'+this.id).css('top');
      var left=$('div#interval_'+this.id).css('left');
      var width=$('div#interval_'+this.id).css('width');
      var height=$('div#interval_'+this.id).css('height');

      console.log("Got styles; top:"+top+", left: "+left+", width: "+width+", height: "+height);

      $("#intervals").append('<div class="booking" booking="'+this.booking.id+'" style="height: '+height+'; top: '+top+'; left: '+left+'; width: '+width+';">&#160;Booked</div>');
    });
  });
}

function initSchema()
{
  // settings
  var hour_width=100;
  var field_height=45;

  var fields=0;
  var times=0;
  var pixel_size=hour_width/60

    $.getJSON("/api/fields/2", function(json) {
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

          $("#intervals").append('<div class="interval" id="interval_'+this.id+'" style="height: '+(field_height-5)+'px; top: '+top+'px; left: '+(day_diff*pixel_size)+'px; width: '+((diff*pixel_size)-1)+'px;">&#160;Available</div>');
        });

        top = top+field_height;
      });

      var height=((fields)*field_height)+40;
      var width=((times)*hour_width)+100;

      console.log('DIV height: '+height);
      console.log('DIV width: '+width);

      $('div#booking').css('height', height+'px');
      $('div#booking').css('width', width+'px');
      $('div#times').css('height', height+'px');
      $('div#fields').css('width', width+'px');

      initBookings();
    });
}

$(document).ready(function() {
  initSchema();
});
