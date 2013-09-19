<?php

include("config.php");
include("include/memcached.php");
require("include/functions.php");
include("include/mobileFunctions.php");


$busStopURLs=getBusStopURLs($busStopURLs);

if(isset($_GET['loc']) and array_key_exists($_GET['loc'],$busStopURLs)){
  $loc=$_GET['loc'];
}
else{
  $loc='condo';
}

$title = "Bus Arrivals - ".$busStopURLs[$loc]['title'];
$busStops = $busStopURLs[$loc]['busStops'];

if(is_mobile()){
  if($_SERVER['PHP_SELF'] != "/".MOBILE_INDEX){
    header("Location: ".MOBILE_INDEX);
    exit;
  }
  echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN"
  "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">';
}
?>
<html>
  <head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.16.custom.css">
    <link rel="stylesheet" href="css/site.css" />
    <style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
	#sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
	html>body #sortable li { height: 1.5em; line-height: 1.2em; }
	.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
	</style>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#sortable").sortable({
          placeholder: "ui-state-highlight"
        });
        $("#sortable").disableSelection();
        $("#addStopDialog").dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"Add Bus Stop": function() { 
                                  var error=0;
                                  if($("#stopDescription").val() == ""){
                                    $("#stopDescription").addClass('ui-state-error',250);
                                    $("#stopDescription").focus();
                                    error=1;
                                  }
                                  if($("#stopID").val() == ""){
                                    $("#stopID").addClass('ui-state-error',250);
                                    $("#stopID").focus();
                                    error=1;
                                  }
                                  if(error > 0){ return; }
                                  $("#stopID").removeClass('ui-state-error');
                                  $("#stopID").removeClass('ui-state-error');
                                  $("#stopID").removeClass('ui-state-error');
                                  
                                },
                                "Cancel": function() { $(this).dialog("close"); }
                        }
        });
        $("#addStopButton").click(function () { $("#addStopDialog").dialog("open"); $("#stopID").focus(); });
        loadIframes();
        var refreshInterval = setInterval(function (){
          $('.predictionDiv').each(function(index) {
            $(this).load($(this).attr("src"));
          });
      },<?php echo REFRESH_RATE;?>000);
        
      });

      function loadIframes(){
        $('.predictionDiv').each(function(index) {
          $(this).load($(this).attr("src"), function() {
            $(this).parent().animate({height:$(this).height()+19},250);
          });
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
  <div style="text-align:right">
  <button id="addStopButton" class=".ui-icon-circle-plus" style="height:19px;width:19px">+</button>
  </div>
  <ul id="sortable">  
<?php

foreach($busStops as $busStop=>$URL){ ?>
    <li class="ui-state-default">
      <b><u><?php echo $busStop;  ?></u></b>
      <div class="predictionDiv" src="<?php echo $URL; ?>" style="text-align:left;;border-bottom-style:solid;border-bottom-color:#ff9900;border-bottom-width:1px">
      Loading...
      </div>
    </li>
  <?php  
} ?>
  </ul>
<?php
?>
  <div id="addStopDialog" title="Add Stop">
    Add a stop to the current page.
    <form id="addStopForm" action="addStop.php" method="POST">
      <input type="hidden" name="loc" value="<?php echo $loc;?>" />
      <input type="hidden" name="transitAuthority" value="WMATA" />
      Stop ID: <input type="text" name="stopID" id="stopID" /><br/>
      Description: <input type="text" name="stopDescription" id="stopDescription" /><br/>
    </form>
  </div>
  </body>
</html>
