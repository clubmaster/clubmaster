cmcl.ticker.initialize = function() {

  if (!(cmcl.data.tickers instanceof Array) || cmcl.data.tickers.length == 0) {
    $('.tickeroverlay').hide();
  } else {
    $('#ticker01').empty();
    $.each(cmcl.data.tickers, function (index, value) {
        chars = value.message.length;
        $('#ticker01').append('<li style="width: '+chars*6+'px;">'+value.message+'</li>');

    });
    $('.tickeroverlay').show();
  }
};
