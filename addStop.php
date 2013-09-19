<?php

require("config.php");
require("include/api_functions.php");
require("include/memcached.php");
require("include/functions.php");

$busStopURLs=getBusStopURLs($busStopURLs);

if(isset($_GET['loc']) and array_key_exists($_GET['loc'],$busStopURLs)){
  $title = "Bus Arrivals - ".$busStopURLs[$_GET['loc']]['title'];
  $busStops = $busStopURLs[$_GET['loc']]['busStops'];
}
else{
  $title = "Bus Arrivals - ".$busStopURLs['condo']['title'];
  $busStops = $busStopURLs['condo']['busStops'];
}

?>
