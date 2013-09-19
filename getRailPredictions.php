<?php

require("config.php");
require("include/api_functions.php");
require("include/memcached.php");
require("include/functions.php");
if(isset($_GET['stationID'])){
  $memcache_key=MEMCACHED_PREFIX."station_predictions_".$_GET['stationID'];
  //print_r(PDO::getAvailableDrivers());

  $memcache_ret=$memcache->get($memcache_key);
  if($memcache_ret != null){ // Check memcache
    echo $memcache_ret;
    echo "</br><small><small>Last Refresh: ".date("r")."</small></small>";
    echo "\n<!--From cache-->";
  }
  else{
    $output="";
    $predictions=get_rail_predictions($_GET['stationID']);
    if(count($predictions->Trains) > 0){
      foreach($predictions->Trains as $prediction){
        $output.="<span class='circle ".$prediction->Line."'>".$prediction->Line."</span>&nbsp;&nbsp;<b>".$prediction->Min." min</b>";
        $output.=" <span class='small'>(".date('g:i a', strtotime('+'.$prediction->Min."minutes")).")</span> ";
        $output.=$prediction->Destination."<br/>\n";
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
