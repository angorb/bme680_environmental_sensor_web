!(function ($) {
  "use strict"; // jshint ;_;

  function updateSensorData() {
    $.get(
      "http://192.168.1.172/sensor",
      function (data) {
        console.log("Sensor Update!");
        // update gauges
        $("#iaq").gaugeMeter({
          used: Math.round(data.iaq),
          showvalue: true,
          min: 50, // FIXME
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

        var tempF = cToF(data.temperature.comp);
        $("#temp").gaugeMeter({
          used: Math.round(tempF),
          min: 32, // FIXME
          total: 130,
          animationstep: 0,
          showvalue: true,
        });

        $("#humid").gaugeMeter({
          percent: data.humidity.comp,
          animationstep: 0,
        });

        $("#pressure").gaugeMeter({
          used: Math.round(data.pressure / 100),
          showvalue: true,
          min: 600, // FIXME
          total: 2060,
          animationstep: 0,
        });

        // Update gas equiv
        $("#co2Equiv span").text(parseInt(data.co2_equivalent));

        $("#vocEquiv span").text(data.breath_voc_equivalent.toFixed(3));

        // update info bar
        $("#lastUpdated").text(new Date(data.time.now * 1000));

        var uptime = toHoursAndMinutes(data.time.uptime);

        $("#uptime").text(uptime.h + "h" + uptime.m + "m" + uptime.s + "s");

        $("#iaqAccuracy").text(!!data.iaq_accuracy);
        $("#gasStab").text(!!data.status.run_in && !!data.status.stab);

        // update raw data
        $("#ajaxresult").text(JSON.stringify(data, null, 2));
      },
      "json"
    );
  }

  function updatePowerData() {
    $.get(
      "http://192.168.1.172/power",
      function (data) {
        // update gauges
        var volt_pct = ((data.power.voltage - 3) / (4.2 - 3)) * 100;
        console.log("Voltage %: " + volt_pct);
        $("#voltage").gaugeMeter({
          percent: volt_pct,
          used: data.power.voltage.toFixed(2),
          showvalue: true,
          //min: 3, // FIXME
          //total: 5,
          animationstep: 0,
        });

        $("#charge").gaugeMeter({
          percent: data.power.soc,
          used: Math.round(data.power.soc),
          showvalue: true,
          animationstep: 0,
        });

        $("#changeRate").gaugeMeter({
          percent: Math.abs(data.power.change_rate),
          used: data.power.change_rate.toFixed(),
          showvalue: true,
          animationstep: 0,
          append: "%",
          label: "Change / hr",
        });
      },
      "json"
    );
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

  function togglePower() {
    if (!$("#togglePower").is(":checked")) {
      $(".power").hide();
      return;
    }
    updatePowerData();
    $(".power").show();
  }

  function refreshDisplay() {
    updateSensorData();
    updatePowerData();
    setTimeout(refreshDisplay, 5000);
  }

  $(document).ready(function () {
    $(".GaugeMeter").gaugeMeter();
    $(".rawdata").hide();
    $(".power").hide();

    $("#showData").on("click", toggleRawData);
    $("#togglePower").on("change", togglePower);

    refreshDisplay();
  });
})(window.jQuery);
