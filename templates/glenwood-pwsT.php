<?php
/**
 * Template Name: PWS Overview Page
 */
/**
 * The template for displaying the Glenwood PWS
 *
 * @package sparkling
 */

 /* Global Variables */
 $pws_name = get_post_meta($post->ID, "pws_id", true);
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta name="description" content="<?php echo ucwords($pws_name); ?>" />
    <meta name="keywords" content="Cumulus, <?php echo ucwords($pws_name); ?> weather data, weather, data, weather station" />
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ucwords($pws_name); ?> Weather</title>
    <!--[if !IE]>
    <html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
    <!--[if IE 7 ]>
    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
    <!--[if IE 8 ]>
    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
    <!--[if IE 9 ]>
    <html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
    <!--[if gt IE 9]><!-->
    <html class="no-js" <?php language_attributes(); ?>>
    <!--<![endif]-->

    <?php if ( of_get_option( 'custom_favicon' ) ) { ?>
        <link rel="icon" href="<?php echo of_get_option( 'custom_favicon' ); ?>" />
    <?php } else { ?>
        <link rel="icon" sizes="any" mask href="http://aweathermoment.com/resources/img/awm_icon.svg">
        <meta name="theme-color" content="#ff5a40">
    <?php } ?>
    <!--[if IE]><?php if ( of_get_option( 'custom_favicon' ) ) { ?><link rel="shortcut icon" href="<?php echo of_get_option( 'custom_favicon' ); ?>" /><?php } ?><![endif]-->

    <?php 
    wp_head();
    ?>

  <link rel="stylesheet" href="http://aweathermoment.com/resources/bower_components/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="http://aweathermoment.com/resources/bower_components/weather-icons/css/weather-icons.min.css" />
  <style>
    #content {
      background: white;
      border: 1px solid #ddd;
      margin-bottom: 2rem;
      padding: 15px;
    }

    .standard-highstock {
        height: 500px;
        margin-bottom: 19px;
    }

    .sparkchart {
        height: 30px;
        width: 180px;
        margin: 0 auto;
    }

    .sparkcell {
        padding: 8px 0 0 0;
        width: 180px;
        text-align: center;
    }
    
    .pws-nav .navbar-toggle .fa {
        color: #5e5e5e;
        transition: 200ms transform;
    }

    tr.has-sparkline td {
        vertical-align: middle !important;
    }

    .footer {
      padding: 10px;
      color: #9d9d9d;
      margin-top: 2em;
    }
    
    .no-top-margin {
      margin-top: 0px;
    }
    
    .no-bottom-margin {
      margin-bottom: 0px;
    }

    .nowrap {
        white-space: nowrap;
    }
    
    #site-location,
    #satellite-image {
      height: 150px;
    }
    
    .temperature-additonal-conditions {
      margin-left: 5px;
    }
    .temperature-display-value {
      font-size: 300%;
      margin-top: 12px;
    }
    
    .temperature-display-units {
      font-size: 50%;
      position: relative;
      top: 4px;
      vertical-align: super;
    }
    
    /* For the Wind Direction Display */
    
    .current-wind-display {
      width: 95px;
      height: 95px;
    }
    
    .current-wind-display,
    .current-wind-details {
      float: left;
      font-size: 0.9375rem;
      margin: 0 0 10px 25px;
      position: relative;
    }
    
    .wind-compass {
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      transition: transform 500ms;
    }
    
    .dial {
      border-radius: 50%;
      width: 85px;
      height: 85px;
      border: 5px solid #a1a2a2;
      position: relative;
      -moz-box-sizing: content-box;
      -webkit-box-sizing: content-box;
      box-sizing: content-box
    }
    
    .wind-direction-display {
      width: 0;
      height: 0;
      border-left: 7px solid transparent;
      border-right: 7px solid transparent;
      border-top: 21px solid #333333;
      position: absolute;
      left: 38.5px;
      top: -6px;
      border-radius: 5px;
    }
    
    .wind-speed-display {
      top: 20px;
      left: 3px;
      width: 88px;
      position: relative;
      display: block;
      text-align: center;
      font-size: 14px;
      line-height: inherit;
    }
    
    .wind-speed-value {
      font-size: 200%;
    }
    
    .wind-speed-units {
      margin-top: -6px;
      font-size: 110%;
    }
    
    .current-wind-details {
      margin-left: 20px;
      line-height: 1.5;
      font-size: 120%;
    }
    
    .wx-value {
      font-weight: 600;
    }
    /* Desktop Adjustments */
    
    @media screen and (min-width: 461px) {
      #site-location, #satellite-image {
        height: 300px;
      }
      .current-wind-details {
        margin-top: 23px;
      }
      .temperature-display-value {
        font-size: 400%;
        margin-top: 0px;
      }
      .temperature-additional-conditions {
        margin-top: 20px;
        margin-left: 0;
        text-align: left;
      }
    }
  </style>
</head>

<body <?php body_class(); ?>>
<header id="masthead" class="site-header" role="banner">
<?php if( get_header_image() != '' ) : ?>

<div id="logo" style="background: url(<?php header_image(); ?>) center center; background-size: cover;">
    <h1 class="title"><?php bloginfo('name'); ?></h1>
    <div class="subtitle">
        <span class="hidden-xs"><?php bloginfo('description'); ?></span>
    </div>
</div>
<!-- end of #logo -->
<div id="warnings" class="hidden"></div>

<?php endif; // header image was removed ?>
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="container">
                <div class="site-navigation-inner">
                    <div class="navbar-header">
                        <span class="navbar-brand visible-xs">Menu</span>
                        <button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                        <?php if( !get_header_image() ) : ?>

                        <div id="logo">
                            <span class="site-name"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="http://beta.aweathermoment.com/resources/img/awm-logo.png" style="height: 37px; padding: 0; margin-top: -7px; float: left; margin-right: 15px;" /><?php bloginfo( 'name' ); ?></a></span>
                        </div>
                        <!-- end of #logo -->

                        <?php endif; // header image was removed (again) ?>

                    </div>
                    <?php sparkling_header_menu(); ?>
                </div>
            </div>
        </nav>
        <!-- .site-navigation -->
    </header>
		<!-- #masthead -->
<div id="content" class="container">
    <nav class="navbar navbar-default pws-nav">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#pws-nav-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-fw fa-chevron-circle-down"></i>
                </button>
                <a class="navbar-brand" href="#"><?php echo ucwords($pws_name); ?> PWS</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="pws-nav-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#"><i class="wi wi-fw wi-thermometer"></i> Conditions</a></li>
                    <li><a href="./gauges/"><i class="wi wi-fw wi-barometer"></i> Gauges</a></li>
                    <li class="dropdown disabled">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-table"></i> Summaries <span class="caret"></span></a>
                        <!-- <ul class="dropdown-menu">
                        <li><a href="?page=summary-today">Today</a></li>
                        <li><a href="?page=summary-yesterday">Yesterday</a></li>
                        <li><a href="?page=summary-month">This Month</a></li>
                        <li><a href="?page=summary-year">This Year</a></li>
                        </ul> -->
                    </li>
                    <li><a href="./graphs/"><i class="fa fa-fw fa-area-chart"></i> Graphs</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="row">
        <!-- Map Container -->
        <div class="col-sm-4">
            <div class="well well-sm">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#site-location" aria-controls="site-location" role="tab" data-toggle="tab">Location</a></li>
                    <li role="presentation"><a href="#satellite-image" aria-controls="profile" role="tab" data-toggle="tab">Satellite</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="site-location"></div>
                    <div role="tabpanel" class="tab-pane" id="satellite-image"><i class="fa fa-fw fa-4x fa-reload fa-spin"></i></div>
                </div>
            </div>
        </div>
        <!-- Current Temperatures & Stuff -->
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="no-top-margin no-bottom-margin">Current Conditions</h2>
                    <p class="text-muted small">Updated at <span data-cumulus="update-time">--</span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="temperature-display-value text-center">
                                <span class="wx-value" cumulus-data="outside-temperature">--</span><span class="temperature-display-units" cumulus-data="temperature-units"></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="temperature-additional-conditions">
                                <div class="dew-point-display">
                                    <i class="wi wi-fw wi-raindrop hidden-xs"></i><span class="hidden-md hidden-lg"> Dewpoint:</span>                                    <span class="wx-value" cumulus-data="dewpoint">--</span><span cumulus-data="temperature-units"></span>
                                </div>
                                <div class="humidity-display">
                                    <i class="wi wi-fw wi-humidity hidden-xs"></i><span class="hidden-md hidden-lg"> Humidity:</span>                                    <span class="wx-value" cumulus-data="relative-humidity">--</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="current-wind-display">
                        <div class="wind-compass">
                            <div class="dial"></div>
                            <div class="wind-direction-display"></div>
                        </div>
                        <div class="wind-speed-display">
                            <div class="wind-speed-value wx-value" cumulus-data="wind-speed"></div>
                            <div class="wind-speed-units" cumulus-data="wind-units"></div>
                        </div>
                    </div>
                    <div class="current-wind-details">
                        <div class="wind-dir-variable">
                            Wind from <span class="wx-value" cumulus-data="wind-direction">--</span>
                        </div>
                        <div class="wind-gust-variable">
                            Gusts <span class="wx-value" cumulus-data="wind-gust"></span><span cumulus-data="wind-units"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-center lead text-muted">Lots still to do here. Big updates ahead. Currently the "Summary" pages are not operational yet.</p>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-sm-12 text-center text-muted">
            <p>The weather station in use is the
                <#stationtype>, and these pages are updated every
                    <#interval> minutes. The meteorological day used at this station ends at
                        <#rollovertime>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <table class="table table-collapse">
                <thead>
                    <tr>
                        <th colspan="3" class="bg-primary text-primary">Temperature and Humidity </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="td_temperature_data has-sparkline">
                        <td>Temperature</td>
                        <td class="spark-cell">
                            <div class="sparkchart" id="temp-spark"></div>
                        </td>
                        <td class="nowrap">
                            <#temp>
                                <#tempunit>
                        </td>
                    </tr>
                    <tr class="td_dewpoint_data has-sparkline">
                        <td>Dew Point</td>
                        <td class="spark-cell">
                            <div class="sparkchart" id="dew-spark"></div>
                        </td>
                        <td class="nowrap">
                            <#dew>
                                <#tempunit>
                        </td>
                    </tr>
                    <tr class="td_temperature_data">
                        <td>Windchill</td>
                        <td colspan="2">
                            <#wchill>
                        </td>
                    </tr>
                    <tr>
                        <td>Humidity</td>
                        <td colspan="2">
                            <#hum>%</td>
                    </tr>
                    <tr class="td_temperature_data">
                        <td>Heat Index</td>
                        <td colspan="2">
                            <#heatindex>
                                <#tempunit>
                        </td>
                    </tr>
                    <tr>
                        <td>Apparent Temperature</td>
                        <td colspan="2">
                            <#apptemp>
                                <#tempunit>
                        </td>
                    </tr>
                    <tr class="td_temperature_data">
                        <td>THW Index</td>
                        <td colspan="2">
                            <#THWindex>
                        </td>
                    </tr>
                    <tr>
                        <td>Temp change last hour</td>
                        <td colspan="2">
                            <#TempChangeLastHour>&nbsp;
                                <#tempunit>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-12 col-md-6">
            <table class="table table-collapse">
                <tbody>
                    <thead>
                        <tr>
                            <th colspan="2" class="bg-primary text-primary">Rainfall</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="td_rainfall_data">
                            <td>Rainfall&nbsp;Today</td>
                            <td>
                                <#rfall>&nbsp;
                                    <#rainunit>
                            </td>
                        </tr>
                        <tr>
                            <td>Rainfall&nbsp;Rate</td>
                            <td>
                                <#rrate>&nbsp;
                                    <#rainunit>/hr</td>
                        </tr>
                        <tr class="td_rainfall_data">
                            <td>Rainfall&nbsp;This&nbsp;Month</td>
                            <td>
                                <#rmonth>&nbsp;
                                    <#rainunit>
                            </td>
                        </tr>
                        <tr>
                            <td>Rainfall&nbsp;This&nbsp;Year</td>
                            <td>
                                <#ryear>&nbsp;
                                    <#rainunit>
                            </td>
                        </tr>
                        <tr class="td_rainfall_data">
                            <td>Rainfall&nbsp;Last Hour</td>
                            <td>
                                <#rhour>&nbsp;
                                    <#rainunit>
                            </td>
                        </tr>
                        <tr>
                            <td>Last rainfall</td>
                            <td>
                                <#LastRainTipISO>
                            </td>
                        </tr>
                        <tr class="td_rainfall_data">
                            <td>Rainfall&nbsp;Since&nbsp;Midnight</td>
                            <td>
                                <#rmidnight>&nbsp;
                                    <#rainunit>
                            </td>
                        </tr>
                        <tr>
                            <td>Rainfall&nbsp;Last&nbsp;24&nbsp;Hours</td>
                            <td>
                                <#r24hour>&nbsp;
                                    <#rainunit>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <table class="table table-collapse">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-primary">Wind & Pressure</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="td_wind_data">
                        <td>Wind&nbsp;Speed&nbsp;(gust)</td>
                        <td>
                            <#wgust>&nbsp;
                                <#windunit>
                        </td>
                    </tr>
                    <tr>
                        <td>Wind&nbsp;Speed&nbsp;(avg)</td>
                        <td>
                            <#wspeed>&nbsp;
                                <#windunit>
                        </td>
                    </tr>
                    <tr class="td_wind_data">
                        <td>Wind Bearing</td>
                        <td>
                            <#avgbearing>&deg;
                                <#wdir>
                        </td>
                    </tr>
                    <tr>
                        <td>Beaufort&nbsp;
                            <#beaufort>
                        </td>
                        <td>
                            <#beaudesc>
                        </td>
                    </tr>
                    <tr class="td_wind_data">
                        <td>Wind Variation (last 10 minutes)</td>
                        <td>From
                            <#BearingRangeFrom>&deg to
                                <#BearingRangeTo>&deg;</td>
                    </tr>
                    <tr class="td_pressure_data">
                        <td>Barometer&nbsp;</td>
                        <td>
                            <#press>&nbsp;
                                <#pressunit>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <#presstrend>
                        </td>
                        <td>
                            <#presstrendval>&nbsp;
                                <#pressunit>/hr</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-12 col-md-6">
            <table class="table table-collapse">
                <thead>
                    <th class="bg-primary text-primary" colspan="2">Almanac</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Dawn</td>
                        <td>
                            <#dawn>
                        </td>
                    </tr>
                    <tr>
                        <td>Sunrise</td>
                        <td>
                            <#sunrise>
                        </td>
                    </tr>
                    <tr>
                        <td>Sunset</td>
                        <td>
                            <#sunset>
                        </td>
                    </tr>
                    <tr>
                        <td>Dusk</td>
                        <td>
                            <#dusk>
                        </td>
                    </tr>
                    <tr>
                        <td>Daylight</td>
                        <td>
                            <#daylightlength>
                        </td>
                    </tr>
                    <tr>
                        <td>Day Length</td>
                        <td>
                            <#daylength>
                        </td>
                    </tr>
                    <tr>
                        <td class="labels">Moon Phase</td>
                        <td>
                            <#moonphase>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-collapse">
                <thead>
                    <tr class="bg-primary text-primary text-center">
                        <th colspan="2">Station Statistics</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Remote ISS Battery</th>
                        <td style="text-transform: small-caps">
                            <#txbattery>
                        </td>
                    </tr>
                    <tr>
                        <th>Packets Recieved</th>
                        <td>
                            <#DavisTotalPacketsReceived>
                        </td>
                    </tr>
                    <tr>
                        <th>Packets Missed</th>
                        <td>
                            <#DavisTotalPacketsMissed>
                        </td>
                    </tr>
                    <tr>
                        <th>Longest Consecutive Packet Streak</th>
                        <td>
                            <#DavisMaxInARow>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<script src="http://aweathermoment.com/resources/bower_components/leaflet/dist/leaflet.js"></script>
<script src="http://aweathermoment.com/resources/bower_components/leaflet/dist/leaflet-providers.js"></script>
<script type="text/javascript">
    var globals = {
        locationMap: null,
        markerArray: [],
    }
    var initialize = {
        locationMap: function(id, latitude, longitude) {
        globals.locationMap = L.map(id, {
            center: [latitude, longitude],
            zoom: 10,
            dragging: false
        });
        L.tileLayer.provider('OpenStreetMap.HOT').addTo(globals.locationMap);
        },
        mapMarker: function(latitude, longitude, infoPopup) {
            var marker = L.marker([latitude, longitude]).addTo(globals.locationMap);
            if (infoPopup !== undefined && infoPopup === true) {
                marker.bindPopup("<table class=\"table table-collapse\"><tr><th class=\"text-right\">Latitude</th><td><#latitude></td></tr><tr><th class=\"text-right\">Longitude</th><td><#longitude></td></tr><tr><th class=\"text-right\">Altitude</th><td><#altitude></td></tr></table>");
            }
            globals.markerArray.push(marker);
        },
        satelliteImage: function() {
            var imageURL = "http://www.umanitoba.ca/environment/envirogeog/weather/images/sat/ManitobaShortN25.jpg?23.3";
            jQuery("a[href='#satellite-image']").on("click", function() {
                var satImg = new Image();
                satImg.src = imageURL;
                satImg.onload = function() {
                    jQuery(".tab-pane#satellite-image").html("<img src=\"" + imageURL + "\" class=\"img-responsive text-center\" style=\"display: block; margin: 0 auto;\" />");
                }
                jQuery("a[href='#satellite-image']").off("click");
            });
        },
        sparklines: function() {
            jQuery.getJSON("../pws/<?php echo $pws_name; ?>/tempdata.json", function(data) {
                var now = new Date().getTime();
                var old = now - (12 * 60 * 60 * 1000);
                var tempData = [];
                var dewData = [];
                for (var i = 0; i < data.temp.length; i++) {
                    if (data.temp[i][0] > old) {
                        tempData.push(data.temp[i]);
                    }
                }
                var tempSpark = new Highcharts.Chart({
                    chart:{
                        renderTo: 'temp-spark',
                        margin:[0, 0, 0, 0],
                        backgroundColor:'transparent'
                    },
                    title:{
                        text:''
                    },
                    credits:{
                        enabled:false
                    },
                    xAxis:{
                        labels:{
                            enabled:false
                        }
                    },
                    yAxis:{
                        maxPadding:0,
                        minPadding:0,
                        gridLineWidth: 0,
                        endOnTick:false,
                        labels:{
                            enabled:false
                        },
                        plotLines: [{
                            color: "#06ABD1",
                            width: 1,
                            value: 0
                        }]
                    },
                    legend:{
                        enabled:false
                        },
                    tooltip:{
                        enabled:false
                    },
                    plotOptions:{
                        series:{
                            enableMouseTracking:false,
                            lineWidth:1,
                            shadow:false,
                            states:{
                                hover:{
                                    lineWidth:1
                                }
                            },
                            marker:{
                                //enabled:false,
                                radius:0,
                                states:{
                                    hover:{
                                        radius:2
                                    }
                                }
                            }
                        }
                    },
                    series: [{type:'area',
                        color: "#E85B56",
                        fillColor: "rgba(232, 91, 86, 0.3)",
                        data: tempData
                    }]
                });
                for (i = 0; i < data.dew.length; i++) {
                    if (data.dew[i][0] > old) {
                        dewData.push(data.dew[i]);
                    }
                }

                var dewSpark = new Highcharts.Chart({
                    chart:{
                        renderTo: 'dew-spark',
                        margin:[0, 0, 0, 0],
                        backgroundColor:'transparent'
                    },
                    title:{
                        text:''
                    },
                    credits:{
                        enabled:false
                    },
                    xAxis:{
                        labels:{
                            enabled:false
                        }
                    },
                    yAxis:{
                        maxPadding:0,
                        minPadding:0,
                        gridLineWidth: 0,
                        endOnTick:false,
                        labels:{
                            enabled:false
                        },
                        plotLines: [{
                            color: "#06ABD1",
                            width: 1,
                            value: 0
                        }]
                    },
                    legend:{
                        enabled:false
                        },
                    tooltip:{
                        enabled:false
                    },
                    plotOptions:{
                        series:{
                            enableMouseTracking:false,
                            lineWidth:1,
                            shadow:false,
                            states:{
                                hover:{
                                    lineWidth:1
                                }
                            },
                            marker:{
                                //enabled:false,
                                radius:0,
                                states:{
                                    hover:{
                                        radius:2
                                    }
                                }
                            }
                        }
                    },
                    series: [{type:'area',
                        color: "#42AE4C",
                        fillColor: "rgba(66, 174, 76, 0.3)",
                        data: dewData
                    }]
                });
            });
        }
    }

    jQuery(document).ready(function() {
        $.getJSON("../pws/<?php echo $pws_name; ?>/stationOverview.json", function(data) {
            jQuery(".wind-compass").css("transform", "rotate(" + data.wind.bearing + "deg)");
            initialize.locationMap("site-location", data._meta.latitude, data._meta.longitude, globals.mapHeight);
            initialize.mapMarker(data._meta.latitude, data._meta.longitude, true);
            initialize.satelliteImage(globals.mapHeight);

            // Time to fill in values
            jQuery("span[cumulus-data='update-time"]).text(data._meta.updateTime);
            jQuery("span[cumulus-data='outside-temperature']").text(data.temperature.outside);
            jQuery("span[cumulus-data='temperature-units']").text(data.temperature.unit);
            
            // Initialize the Sparklines
            initialize.sparklines();
        })
    });
  </script>
        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || '0' != get_comments_number() ) :
            echo "<hr style=\"margin-top: 32px; margin-bottom: 19px;\" /><div class=\"row\" style=\"margin-bottom: 10px;\"><div class=\"col-sm-10 col-sm-offset-1\"><h2 id=\"comments\">Comments</h2>";
            comments_template();
            echo "</div></div>";
        endif;
    ?>
    <hr />
    <div class="row">
        <div class="col-xs-12 text-center">
            PWS Updates Powered by <i class="wi wi-fw wi-cloudy"></i> <a href="http://sandaysoft.com/products/cumulus" target="_blank">Cumulus</a> v
            <#version> <span class="hidden-xs">(<#build>)</span>
        </div>
    </div>

    <!-- Required Librairies -->
    <script type="text/javascript">
        window.jQuery = window.$ = jQuery;
    </script>
    <script src="http://code.highcharts.com/stock/highstock.js"></script>
    <script type="text/javascript">
        // Default Link Blocker
        jQuery("a[href=\"#\"]").on("click", function(e) {
            e.preventDefault();
        });

        jQuery("#pws-nav-collapse").on("show.bs.collapse", function() {
            console.log("Showing");
            jQuery(".pws-nav .fa-chevron-circle-down").css("transform", "rotate(180deg)");
        }).on("hide.bs.collapse", function() {
            jQuery(".pws-nav .fa-chevron-circle-down").css("transform", "rotate(0deg)");
        });
    </script>

    <?php get_footer(); ?>