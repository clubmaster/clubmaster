$(document).ready(function() {

    $.ajax({
        url: currUrl,
        crossDomain: true
    }).done(function(data) {
        if (data.cod == "404") {
            $('h3#status').html('Error fetching weather informations...');
        } else {
            var sunrise = new Date(data.sys.sunrise*1000);
            var sunset = new Date(data.sys.sunset*1000);

            $('img#curr-weather').attr('alt', data.weather[0].description);
            $('img#curr-weather').attr('src', 'http://openweathermap.org/img/w/'+data.weather[0].icon+'.png');
            $('span#curr-location').html(data.sys.country+', '+data.name);
            $('span#curr-rise').html(getHour(sunrise));
            $('span#curr-set').html(getHour(sunset));
            $('span#curr-temp').html(Math.round(data.main.temp));
            $('span#curr-speed').html(Math.round(data.wind.speed));
            $('span#curr-dir').html(getDirection(data.wind.deg));

            $('div#status').css('display', 'none');
            $('div#overview').css('display', 'block');
        }
    });

    $.ajax({
        url: forecastUrl
    }).done(function(data) {
        if (data.cod == "404") {
            $('h3#status').html('Error fetching weather informations...');
        } else {

            var i = -1;
            var lastInt = 0;

            $.each(data.list, function(key,value) {

                if (i > -1) {
                    if (i%3 == 0) {
                        lastInt = i;
                        $('div#overview').append('<div class="row-fluid" id="weather-list-'+lastInt+'">');
                    }

                    var date = new Date(value.dt*1000);
                    $('div#weather-list-'+lastInt).append('<div class="span4 well" id="weather-list-int-'+i+'">');
                    $('div#weather-list-int-'+i).append('<h2><img alt="'+value.weather[0].description+'" src="http://openweathermap.org/img/w/'+value.weather[0].icon+'.png" /> <small>'+getDay(date)+'</small></h2>');
                    $('div#weather-list-int-'+i).append('<p id="weather-list-p-'+i+'"></p>');
                    $('p#weather-list-p-'+i).append('Temperature: '+Math.round(value.temp.min)+degree+'/'+Math.round(value.temp.max)+degree+'<br>');
                    $('p#weather-list-p-'+i).append('Wind: '+Math.round(value.speed)+units+', '+getDirection(value.deg)+'<br>');
                }

                i++;
            });
        }
    });
});

function getHour(date)
{
    var string;
    if (date.getHours() > 9) {
        string = date.getHours();
    } else {
        string = "0"+date.getHours();
    }

    if (date.getMinutes() > 9) {
        string = string+':'+date.getMinutes();
    } else {
        string = string+':0'+date.getMinutes();
    }

    return string;
}

function getDirection(deg)
{
    var string;
    var p = 22;
    var i = 45;
    deg = Number(Math.round(deg));

    switch (true) {
        case ((deg > 360-p) && (deg < (i*0)+i)):
            string = 'North';
            break;

        case ((deg > (i*1)-p) && (deg < (i*1)+p)):
            string = 'Northwest';
            break;

        case ((deg > (i*2)-p) && (deg < (i*2)+p)):
            sring = 'West';
            break;

        case ((deg > (i*3)-p) && (deg < (i*3)+p)):
            string = 'Southwest';
            break;

        case ((deg > (i*4)-p) && (deg < (i*4)+p)):
            string = 'South';
            break;

        case ((deg > (i*5)-p) && (deg < (i*5)+p)):
            string = 'Southeast';
            break;

        case ((deg > (i*6)-p) && (deg < (i*6)+p)):
            string = 'East';
            break;

        case ((deg > (i*7)-p) && (deg < (i*7)+p)):
            string = 'Northeast';
            break;

        default:
            string = 'North';
            break;
    }

    return string;
}

function getDay(date)
{
    var string;

    switch (true) {
        case (date.getDay() == 0):
            string = "Sunday";
            break;

        case (date.getDay() == 1):
            string = "Monday";
            break;

        case (date.getDay() == 2):
            string = "Tuesday";
            break;

        case (date.getDay() == 3):
            string = "Wednesday";
            break;

        case (date.getDay() == 4):
            string = "Thursday";
            break;

        case (date.getDay() == 5):
            string = "Friday";
            break;

        case (date.getDay() == 6):
            string = "Saturday";
            break;
    }

    return string;
}
