<?php

//define("WMATA_API_KEY","g4h3sqbektjnjr738w4x4s7n");
define("WMATA_API_KEY","5d72mdq58gqj7emu526gwb4u");
$WMATAAPIKeys=array("5d72mdq58gqj7emu526gwb4u", "g4h3sqbektjnjr738w4x4s7n","uj6k2utvxnmyh3mpxdt2abyu","kza9te52c4u37qjwzy8cs42p");
//$WMATAAPIKeys=array("5d72mdq58gqj7emu526gwb4u", "g4h3sqbektjnjr738w4x4s7n");

define("MEMCACHED_HOST","127.0.0.1");
define("MEMCACHED_PREFIX","BUS_ARRIVALS_");
define("MEMCACHED_EXPIRE",1800);

define("STOPPREDICTION_URL","getStopPredictions.php");
define("STATIONPREDICTION_URL","getRailPredictions.php");
define("STOPS_FILE","stops.db");

// URL of XML for Capital Bike Share
define("CABIXMLURL","http://www.capitalbikeshare.com/data/stations/bikeStations.xml");

// Refresh rate (in seconds) for each iframe
define("REFRESH_RATE",15);

/* Page to be redirected to if user is using a mobile client */
define("MOBILE_INDEX","mobile_index.php");

/* Default Timezone */
define("TIMEZONE","America/New_York");

/* Default bus stops.  */
/* If you change these, remove the STOPS_FILE so cache will be flushed */
$busStopURLs = array(
  "work" => array( "title" => "Work/Downtown", 
                   "busStops" => array(
                                       "16th & I NW" => STOPPREDICTION_URL."?stopID=1002910",
                                       "17th & I NW" => STOPPREDICTION_URL."?stopID=1001183",
                                       "15th & I NW" => STOPPREDICTION_URL."?stopID=1001185",
                                       "Dupont Circle" => STOPPREDICTION_URL."?stopID=1001404",
                                       "1st & Independence" => STOPPREDICTION_URL."?stopID=1000736",
                                       "Capital South" =>  STATIONPREDICTION_URL."?stationID=D05",
                                       "3rd & Penn Ave SE" =>  "http://busarrivals.derricklbryant.com/getBikeStation.php?station_id=247",
                                       "4th & E Capitol St NE" =>  "http://busarrivals.derricklbryant.com/getBikeStation.php?station_id=98"
                   )
                 ),
  "condo" => array( "title" => "Condo",
                    "busStops" => array(
                                        "16th & Mt Pleasant" => STOPPREDICTION_URL."?stopID=1001947",
                                        "16th & Harvard South" => STOPPREDICTION_URL."?stopID=1002873",
                                        "16th & Harvard North" => STOPPREDICTION_URL."?stopID=1001922",
					"14th & Harvard South" => STOPPREDICTION_URL."?stopID=1003040",
                                        "14th & Harvard North" => STOPPREDICTION_URL."?stopID=1003429",
                                        "Columbia Heights" =>  STATIONPREDICTION_URL."?stationID=E04",
                                        "14th & Harvard St NW" =>  "http://busarrivals.derricklbryant.com/getBikeStation.php?station_id=19",
                                        "16th & Harvard St NW" =>  "http://busarrivals.derricklbryant.com/getBikeStation.php?station_id=17"
                    )
                  ),
  "work-display" => array( "title" => "Work Display",
                    "busStops" => array(
                                       "1st & Independence" => STOPPREDICTION_URL."?stopID=1000736",
                                       "Capital South" =>  STATIONPREDICTION_URL."?stationID=D05",
                                       "3rd & Penn Ave SE" =>  "http://busarrivals.derricklbryant.com/getBikeStation.php?station_id=247",
                                       "4th & E Capitol St NE" =>  "http://busarrivals.derricklbryant.com/getBikeStation.php?station_id=98"
                    )
                  )
);

date_default_timezone_set(TIMEZONE);

?>
