<?php
/* Simply downloads data from $_GET['URL'] and spits it back to the browser. 
This gets around the "Origin is not allowed by Access-Control-Allow-Origin" error */
exit;

if(isset($_GET['URL'])){
  echo file_get_contents($_GET['URL']);
}
?>
