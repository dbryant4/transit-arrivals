<?php

// Gets bus routes from WMATA and returns a JSON decoded array
function get_bus_routes(){
  $url = "http://api.wmata.com/Bus.svc/json/JRoutes?api_key=".getWMATAAPIKey();
  //sleep(.5);
  return json_decode(file_get_contents($url));

}

// Gets bus stops 
function get_bus_stops(){
  $url="http://api.wmata.com/Bus.svc/json/JStops?api_key=".getWMATAAPIKey();
  //sleep(.5);
  return json_decode(file_get_contents($url));
}

// Gets bus schedule by route using routeID.
// Include route variations by setting variations to true. Default is false.
// Optionally, you can specify a data (default is today via WMATA API).
//   Date format = "YEAR-MONTH-DAY"
// TODO: Implement time stamp to data string
function get_bus_schedule_by_route($routeID,$variations=FALSE,$date=NULL){
  sleep(.5);
  $url="http://api.wmata.com/Bus.svc/json/JRouteSchedule?routeId=".$routeID;
  if($date != NULL){
    $url.="&date=".$date;
  }
  if($variations == TRUE){
    $url.="&includingVariations=true";
  }
  $url.="&api_key=".getWMATAAPIKey();
  return json_decode(file_get_contents($url));
  error_log($url);
}

// Returns a sequence of lat/long points which can be used to describe a specific bus route.
// routeID - identifier of route (required).
// date - Can be empty (default is today's date).
function get_bus_route_details($routeID,$date=NULL){
  //sleep(.5);
  $url="http://api.wmata.com/Bus.svc/json/JRouteDetails?routeId=".$routeID;
  if($date != NULL){
    $url.="&date=".$date;
  }
  $url.="&api_key=".getWMATAAPIKey();
  error_log($url);
  return json_decode(file_get_contents($url));
}

// Returns the real-time positions of each bus travel a specified route inside specified area.  
// Bus position information is updated every two minutes or less.
//  routeID - identifier of route. If empty, all current buses will be returned. 
//  Variations - can be empty (default is "false"). Some routes (like "10B") have variations like 
//               "10Bv1", "10Bv4". You can retrieve buses for all variations in one piece or separatelly.
//
// TODO:
//  If a lat/lon or radius is not provided or equals 0, all current buses will be returned.  Radius is expressed in meters
function get_bus_positions($routeID,$variations=FALSE){
  //sleep(.5);
  $url="http://api.wmata.com/Bus.svc/json/JBusPositions?routeId=".$routeID;
  $url.="&api_key=".getWMATAAPIKey();
  if($variations == TRUE){
    $url.="&includingVariations=true";
  }
  return json_decode(file_get_contents($url));
}

// Returns the bus schedule for a specific bus stop.
//  stopID - identifier of stop. Required
//  date - can be empty (default is today).
function get_bus_schedule_by_stop($stopID,$date=NULL){
  $url="http://api.wmata.com/Bus.svc/json/JStopSchedule?stopId=".$stopID;
  $url.="&api_key=".getWMATAAPIKey();
  if($date != NULL){
    $url.="&date=".$date;
  }

  return json_decode(file_get_contents($url));
}

function get_bus_predictions($stopID){
  $url="http://api.wmata.com/NextBusService.svc/json/JPredictions?StopId=".$stopID;
  $url.="&api_key=".getWMATAAPIKey();
  return json_decode(file_get_contents($url));
}

// Rail Functions
function get_rail_lines(){
  $url="http://api.wmata.com/Rail.svc/json/JLines?api_key=".getWMATAAPIKey();
  return json_decode(file_get_contents($url));
}

function get_rail_stations($lineCode=NULL){
  $url="http://api.wmata.com/Rail.svc/json/JStations?api_key=".getWMATAAPIKey();
  if($lineCode != NULL){
    $url.="&LineCode=".$lineCode;
  }
  return json_decode(file_get_contents($url));
}

function get_rail_station_info($stationCode){
  $url="http://api.wmata.com/Rail.svc/json/JStationInfo?api_key=".getWMATAAPIKey()."&StationCode=".$stationCode;
  return json_decode(file_get_contents($url));
}

function get_rail_paths($fromStationCode,$toStationCode){
  $url="http://api.wmata.com/Rail.svc/json/JPath?api_key=".getWMATAAPIKey();
  $url.="&FromStationCode=".$fromStationCode;
  $url.="&ToStationCode=".$toStationCode;
  return json_decode(file_get_contents($url));
}

function get_rail_predictions($stationCodes="All"){
  $url="http://api.wmata.com/StationPrediction.svc/json/GetPrediction/".$stationCodes."?api_key=".getWMATAAPIKey();
  return json_decode(file_get_contents($url));
}

function get_rail_incidents(){
  $url="http://api.wmata.com/Incidents.svc/json/Incidents?api_key=".getWMATAAPIKey();
  return json_decode(file_get_contents($url));
}

// Pull XML from Capital Bike Share, parse, then store in memory
function get_bike_stations($memcache){
  $memcache_key=MEMCACHED_PREFIX."bike_station_XML";
  $memcache_ret=$memcache->get($memcache_key);
  if($memcache_ret != null){
    $xml = $memcache_ret;
  }
  else{
    $xml = file_get_contents(CABIXMLURL);
    $memcache->set($memcache_key,$xml,0,30);
  }
  return new SimpleXMLElement($xml);
}
?>
