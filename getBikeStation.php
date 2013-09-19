<?php

include("config.php");
include("include/memcached.php");
require("include/functions.php");
include("include/mobileFunctions.php");
include("include/api_functions.php");

header('Access-Control-Allow-Origin: *');

if(!isset($_GET['station_id'])){
  echo "station_id not provided.";
  exit;
}

$memcache_key=MEMCACHED_PREFIX."bike_station_".$_GET['station_id'];

if(isset($_GET['json'])){
  $memcache_key.="format_json";
}

if(is_mobile()){
  echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN"
  "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">';
}

$memcache_ret=$memcache->get($memcache_key);
if($memcache_ret != null){ // Check memcache
    echo $memcache_ret;
    if(!isset($_GET['json'])){
      echo "</br><small><small>Last Refresh: ".date("r")."</small></small>";
      echo "\n<!--From cache-->";
    }
    exit;
}
else{
  $bikeStations = get_bike_stations($memcache);
  foreach($bikeStations->station as $station){
    if ($station->id == $_GET['station_id']){
      if(isset($_GET['json'])){
        $output = json_encode($station);
        $memcache->set($memcache_key,$output,0,30);
        echo $output;
      }
      else{
        $output = "";
        $output .= "<b>Bikes:</b> ".$station->nbBikes."</br>\n";
        $output .= "<b>Empty Docks:</b> ".$station->nbEmptyDocks."\n";
        $memcache->set($memcache_key,$output,0,30);
        echo $output;
      }
      exit;
    }
  }
}
echo "Station ".$_GET['station_id']." was not found.";

?>
