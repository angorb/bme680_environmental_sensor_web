!(function ($) {
  "use strict"; // jshint ;_;

  function updateSensorData() {
    $.get(
      "http://192.168.1.172",
      function (data) {
        // update gauges
        $("#iaq").gaugeMeter({
          used: Math.round(data.iaq),
          showvalue: true,
          min: 0,
          total: 500,
          animationstep: 0,
        });

        $("#staticIaq").gaugeMeter({
          used: Math.round(data.static_iaq),
          animationstep: 0,
        });

        $("#gas").gaugeMeter({
          percent: data.gas,
          animationstep: 0,
        });

        $("#temp").gaugeMeter({
          percent: cToF(data.temperature.comp),
          animationstep: 0,
        });

        $("#humid").gaugeMeter({
          percent: data.humidity.comp,
          animationstep: 0,
        });

        $("#pressure").gaugeMeter({
          used: 830, //(data.pressure.toFixed() / 100).toFixed()
        });

        // Update gas equiv
        $("#co2Equiv span").text(parseInt(data.co2_equivalent));

        $("#vocEquiv span").text(data.breath_voc_equivalent.toFixed());

        // update info bar
        $("#lastUpdated").text(new Date(data.time.now * 1000));

        var uptime = toHoursAndMinutes(data.time.uptime);

        $("#uptime").text(
          uptime.h + " hours, " + uptime.m + " min, " + uptime.s + " sec"
        );

        $("#iaqAccuracy").text(!!data.iaq_accuracy);
        $("#statusStab").text(!!data.status.stab);
        $("#statusRunIn").text(!!data.status.run_in);

        // update raw data
        $("#ajaxresult").text(JSON.stringify(data, null, 2));
      },
      "json"
    );
    setTimeout(updateSensorData, 5000);
  }

  function cToF(celsius) {
    return (celsius * 9) / 5 + 32;
  }

  function toHoursAndMinutes(totalSeconds) {
    const totalMinutes = Math.floor(totalSeconds / 60);

    const seconds = totalSeconds % 60;
    const hours = Math.floor(totalMinutes / 60);
    const minutes = totalMinutes % 60;

    return {
      h: hours,
      m: minutes,
      s: seconds,
    };
  }

  function toggleRawData() {
    if ($(".rawdata").is(":visible")) {
      $(".rawdata").hide();
      return;
    }

    $(".rawdata").show();
  }

  $(document).ready(function () {
    $(".GaugeMeter").gaugeMeter();
    $(".rawdata").hide();
    updateSensorData();

    $("#showData").on("click", toggleRawData);
  });
})(window.jQuery);
