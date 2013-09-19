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
          $('.predictionDiv').each(function(index) {
            $(this).load($(this).attr("src"));
          });
      },<?php echo REFRESH_RATE;?>000);
        
      });

      function loadIframes(){
        $('.predictionDiv').each(function(index) {
          $(this).load($(this).attr("src"));
          //setTimeout("loadIframes()",<?php echo REFRESH_RATE;?>000);
        });
      }
    </script>
  </head>
  <body>
    <div style="width:100%;height:30;text-align:center;">
      <h3><?php echo $title; ?></h3>
    </div>
    <div style="width:100%;height:20;">
      <select style="width:100%" onchange="window.location=$(this).val()">
<?php
  foreach($busStopURLs as $key => $busStopUrl){
    echo "<option value='?loc=".$key."' ";
    if($key==$_GET['loc']) echo "selected='selected'";
    elseif(!isset($_GET['loc']) and $key=="condo") echo "selected='selected'";
    echo ">".$busStopURLs[$key]['title']."</option>";
  }
?>
      </select>
    </div><br> 
<?php

foreach($busStops as $busStop=>$URL){ ?>
  <div style="text-align:center;float:center;border-bottom-style:solid;border-bottom-color:#ff9900;border-bottom-width:1px;border-right-style:dotted;border-right-width:1px;">
    <b><u><?php echo $busStop;  ?></u></b>
    <div class="predictionDiv" src="<?php echo $URL; ?>" style="text-align:left;">
      Loading...
    </div>
  </div>
  <?php  
}

?>
  </body>
</html>
