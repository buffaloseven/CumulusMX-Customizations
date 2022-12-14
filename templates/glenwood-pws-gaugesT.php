<?php
/**
 * Template Name: Steelseries Gauges Template
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
    <meta name="description" content="<#location> weather data" />
    <meta name="keywords" content="Cumulus, <#location> weather data, weather, data, weather station" />
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><#location> Weather</title>
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

  <link rel="stylesheet" href="http://aweathermoment.com/resources/bower_components/weather-icons/css/weather-icons.min.css" />
  <link rel="stylesheet" href="http://aweathermoment.com/resources/steelseries/css/gauges-ss.css">
  <style>
    #content {
      background: white;
      border: 1px solid #ddd;
      margin-bottom: 2rem;
      padding: 15px;
    }

    .pws-nav .navbar-toggle .fa {
        color: #5e5e5e;
        transition: 200ms transform;
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
                    <li><a href="../"><i class="wi wi-fw wi-thermometer"></i> Current Conditions</a></li>
                    <li class="active"><a href="#"><i class="wi wi-fw wi-barometer"></i> Gauges</a></li>
                    <li class="dropdown disabled">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-table"></i> Summaries <span class="caret"></span></a>
                        <!-- <ul class="dropdown-menu">
                        <li><a href="?page=summary-today">Today</a></li>
                        <li><a href="?page=summary-yesterday">Yesterday</a></li>
                        <li><a href="?page=summary-month">This Month</a></li>
                        <li><a href="?page=summary-year">This Year</a></li>
                        </ul> -->
                    </li>
                    <li><a href="../graphs/"><i class="fa fa-fw fa-area-chart"></i> Graphs</a></li>
                </ul>
            </div>
        <!-- /.navbar-collapse -->
        </div>
    <!-- /.container -->
    </nav>

<noscript>
  <h2 style="color:red; text-align:center">&gt;&gt;This pages requires JavaScript enabling in your browser.&lt;&lt;<br>&gt;&gt;Please enable scripting it to enjoy
    this site at its best.&lt;&lt;</h2>
</noscript>
<div class="row">
  <div class="col-sm-12">
    <h2>Real-Time Gauges <small>30-second Updates of the <?php echo ucwords($pws_name); ?> PWS</small></h2>
  </div>
</div>

<div class="row text-center">
  <canvas id="canvas_led" width="25" height="25"></canvas>&nbsp;&nbsp;&nbsp;
  <!--<canvas id="canvas_status" width="550" height="25"></canvas>&nbsp;&nbsp;-->
  <canvas id="canvas_timer" width="70" height="25"></canvas>
</div>

<div class="row text-center">

  <div class="col-sm-4">
    <div id="tip_0">
      <canvas id="canvas_temp" width="221" height="221"></canvas>
    </div>
    <form>
      <label for="rad_temp1" class="checbox-inline">
                        <input id="rad_temp1" type="radio" name="rad_temp" value="out" checked onclick="gauges.doTemp(this);"> Outside
                    </label>
      <label for="rad_temp2" class="checkbox-inline">
                        <input id="rad_temp2" type="radio" name="rad_temp" value="in" onclick="gauges.doTemp(this);"> Inside
                    </label>
    </form>
  </div>

  <div class="col-sm-4">
    <div id="tip_1">
      <canvas id="canvas_dew" width="221" height="221"></canvas>
    </div>
    <input id="rad_dew1" type="radio" name="rad_dew" value="dew" onclick="gauges.doDew(this);"><label id="lab_dew1" for="rad_dew1">Dew Point</label>
    <input id="rad_dew2" type="radio" name="rad_dew" value="app" checked onclick="gauges.doDew(this);"><label id="lab_dew2"
      for="rad_dew2">Apparent</label>
    <br>
    <input id="rad_dew3" type="radio" name="rad_dew" value="wnd" onclick="gauges.doDew(this);"><label id="lab_dew3" for="rad_dew3">Wind Chill</label>
    <input id="rad_dew4" type="radio" name="rad_dew" value="hea" onclick="gauges.doDew(this);"><label id="lab_dew4" for="rad_dew4">Heat Index</label>
    <br>
    <input id="rad_dew5" type="radio" name="rad_dew" value="hum" onclick="gauges.doDew(this);"><label id="lab_dew5" for="rad_dew5">Humidex</label>
  </div>

  <div class="col-sm-4">
    <div id="tip_4">
      <canvas id="canvas_hum" width="221" height="221"></canvas>
    </div>
    <input id="rad_hum1" type="radio" name="rad_hum" value="out" checked onclick="gauges.doHum(this);"><label id="lab_hum1"
      for="rad_hum1">Outside</label>
    <input id="rad_hum2" type="radio" name="rad_hum" value="in" onclick="gauges.doHum(this);"><label id="lab_hum2" for="rad_hum2">Inside</label>
  </div>
</div>

<div class="row text-center">
  <div class="col-sm-4">
    <div id="tip_6">
      <canvas id="canvas_wind" width="221" height="221"></canvas>
    </div>
  </div>
  <div class="col-sm-4">
    <div id="tip_7">
      <canvas id="canvas_dir" width="221" height="221"></canvas>
    </div>
  </div>
  <div class="col-sm-4">
    <div id="tip_10">
      <canvas id="canvas_rose" width="221" height="221"></canvas>
    </div>
  </div>
</div>

<div class="row text-center">
  <div class="col-sm-4">
    <div id="tip_5">
      <canvas id="canvas_baro" width="221" height="221"></canvas>
    </div>
  </div>
  <div class="col-sm-4">
    <div id="tip_2">
      <canvas id="canvas_rain" width="221" height="221"></canvas>
    </div>
  </div>
  <div class="col-sm-4">
    <div id="tip_3">
      <canvas id="canvas_rrate" width="221" height="221"></canvas>
    </div>
  </div>
</div>

<div class="row">
  <div id="tip_8" class="gauge">
    <canvas id="canvas_uv" width="221" height="221"></canvas>
  </div>
  <div id="tip_9" class="gauge">
    <canvas id="canvas_solar" width="221" height="221"></canvas>
  </div>
  <div id="tip_11" class="gauge">
    <canvas id="canvas_cloud" class="gaugeSizeStd"></canvas>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <p class="lead">Settings</p>
    <div class="unitsTable">
      <div style="display:table-row">
        <div id="temperature" class="cellRight">
          <span id="lang_temperature">Temperature</span>:
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsTemp1" type="radio" name="rad_unitsTemp" value="C" checked onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsTemp1" for="rad_unitsTemp1">&deg;C</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsTemp2" type="radio" name="rad_unitsTemp" value="F" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsTemp2" for="rad_unitsTemp2">&deg;F</label>
        </div>
      </div>
      <div style="display:table-row">
        <div id="rainfall" class="cellRight">
          <span id="lang_rainfall">Rainfall</span>:
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsRain1" type="radio" name="rad_unitsRain" value="mm" checked onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsRain1" for="rad_unitsRain1">mm</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsRain2" type="radio" name="rad_unitsRain" value="in" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsRain2" for="rad_unitsRain2">Inch</label>
        </div>
      </div>
      <div style="display:table-row">
        <div id="pressure" class="cellRight">
          <span id="lang_pressure">Pressure</span>:
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsPress1" type="radio" name="rad_unitsPress" value="hPa" checked onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsPress1" for="rad_unitsPress1">hPa</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsPress2" type="radio" name="rad_unitsPress" value="inHg" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsPress2" for="rad_unitsPress2">inHg</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsPress3" type="radio" name="rad_unitsPress" value="mb" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsPress3" for="rad_unitsPress3">mb</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsPress4" type="radio" name="rad_unitsPress" value="kPa" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsPress4" for="rad_unitsPress4">kPa</label>
        </div>
      </div>
      <div style="display:table-row">
        <div id="wind" class="cellRight">
          <span id="lang_windSpeed">Wind Speed</span>:
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsWind4" type="radio" name="rad_unitsWind" value="km/h" checked onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsWind4" for="rad_unitsWind4">km/h</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsWind3" type="radio" name="rad_unitsWind" value="m/s" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsWind3" for="rad_unitsWind3">m/s</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsWind1" type="radio" name="rad_unitsWind" value="mph" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsWind1" for="rad_unitsWind1">mph</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsWind2" type="radio" name="rad_unitsWind" value="kts" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsWind2" for="rad_unitsWind2">knots</label>
        </div>
      </div>
      <div style="display:table-row">
        <div id="cloud" class="cellRight">
          <span id="lang_cloudbase">CloudBase</span>:
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsCloudBase1" type="radio" name="rad_unitsCloud" value="m" checked onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsCloudBase1" for="rad_unitsCloudBase1">m</label>
        </div>
        <div style="display:table-cell">
          <input id="rad_unitsCloudBase2" type="radio" name="rad_unitsCloud" value="ft" onclick="gauges.setUnits(this);">
          <label
            id="lab_unitsCloudBase2" for="rad_unitsCloudBase2">ft</label>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <p class="lead">Attribution</p>
    <p class="text-muted">
      Scripts by Mark Crossley - version <span id="scriptVer"></span><br> Gauges drawn using Gerrit Grunwald's <a href="http://harmoniccode.blogspot.com"
        target="_blank">SteelSeries</a> <a href="https://github.com/HanSolo/SteelSeries-Canvas">JavaScript library</a>
      <span id="rgraph_attrib"><br>Wind Rose drawn using RGraph</span>
    </p>
  </div>
</div>

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
    <script src="http://aweathermoment.com/resources/steelseries/scripts/steelseries_tween.min.js"></script>
    <script src="http://aweathermoment.com/resources/steelseries/scripts/language.min.js"></script>
    <script src="http://aweathermoment.com/resources/steelseries/scripts/gauges.js"></script>
    <script src="http://aweathermoment.com/resources/steelseries/scripts/RGraph.common.core.min.js"></script>
    <script src="http://aweathermoment.com/resources/steelseries/scripts/RGraph.rose.min.js"></script>

    <script src="http://aweathermoment.com/resources/bower_components/leaflet/dist/leaflet.js"></script>
    <script src="http://aweathermoment.com/resources/bower_components/leaflet/dist/leaflet-providers.js"></script>


    <?php get_footer(); ?>