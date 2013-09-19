<?php

include("config.php");
include("include/memcached.php");
require("include/functions.php");
include("include/mobileFunctions.php");


$busStopURLs=getBusStopURLs($busStopURLs);

if(isset($_GET['loc']) and array_key_exists($_GET['loc'],$busStopURLs)){
  $title = "Bus Arrivals - ".$busStopURLs[$_GET['loc']]['title'];
  $busStops = $busStopURLs[$_GET['loc']]['busStops'];
}
else{
  $title = "Bus Arrivals - ".$busStopURLs['condo']['title'];
  $busStops = $busStopURLs['condo']['busStops'];
}

if(is_mobile()){
  header("Location: mobile_index.php");
  exit;
  echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN"
  "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">';
}
?>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/site.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        loadIframes();
        var refreshInterval = setInterval(function (){
          $('iframe').each(function(index) {
            $(this).attr("src", $(this).attr("src"));
          });
      },<?php echo REFRESH_RATE;?>000);
        
      });

      function loadIframes(){
        $('iframe').each(function(index) {
          $(this).attr("src", $(this).attr("src"));
          //setTimeout("loadIframes()",<?php echo REFRESH_RATE;?>000);
        });
      }
    </script>
  </head>
  <body>
    <div style="width:100%;height:30;text-align:center;">
      <h3><?php echo $title; ?></h3>
    </div>
    <div style="width:100%;height:20;background-image:url('button-background-gradient.png');background-repeat:repeat-x;">
<?php
  echo "      ";
  foreach($busStopURLs as $key => $busStopUrl){
    echo "<a href='?loc=".$key."'>".$busStopURLs[$key]['title']."</a> | ";
  }
?>

    </div>  
<?php

foreach($busStops as $busStop=>$URL){ ?>
  <div style="width:550;height:340;text-align:center;float:left;">
    <b><?php echo $busStop;  ?></b>
    <iframe name="predictionFrame"  id="predictionFrame" src="<?php echo $URL; ?>" width=550 height=340  frameborder=0>
      Your browser does not support frames. What decade is your browser from?
    </iframe>
  </div>
  <?php  
}

?>
  </body>
</html>
