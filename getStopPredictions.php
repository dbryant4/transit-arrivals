<?php

require("config.php");
require("include/api_functions.php");
require("include/memcached.php");
require("include/functions.php");

if(isset($_GET['stopID'])){
  $memcache_key=MEMCACHED_PREFIX."stop_predictions_".$_GET['stopID'];
  //print_r(PDO::getAvailableDrivers());

  $memcache_ret=$memcache->get($memcache_key);
  if($memcache_ret != null){ // Check memcache
    echo $memcache_ret;
    echo "</br><small><small>Last Refresh: ".date("r")."</small></small>";
    echo "\n<!--From cache-->";
  }
  else{
    $output="";
    $predictions=get_bus_predictions($_GET['stopID']);
    if(count($predictions->Predictions) > 0){
      foreach($predictions->Predictions as $prediction){
        $output.="<b>".$prediction->Minutes." min</b>";
        $output.=" (".date('g:i a', strtotime('+'.$prediction->Minutes."minutes")).") ";
        $output.="(".$prediction->RouteID." ".$prediction->DirectionText.") (Bus #".$prediction->VehicleID.")<br/>\n";
      } 
    }
    else{
      $output.="<b>No Predictions</b><br/>";
    }
    $output.="<small><small>Last Cache Update: ".date("r")."</small></small>";
    echo $output;
    echo "<br/><small><small>Last Refresh: ".date("r")."</small></small>";
    $memcache->set($memcache_key,$output,0,30);
  }
}
else{
  echo "No Stop ID Provided";
}
?>
