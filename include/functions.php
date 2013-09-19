<?php

function getBusStopURLs($busStopURLs){
  global $memcache;
  /* If DB file does not exist, assume new install, write defaults,
     and place into memcache */
  $memcache_key=MEMCACHED_PREFIX."_bus_stop_urls";
  if(!file_exists(STOPS_FILE)){
    file_put_contents(STOPS_FILE,serialize($busStopURLs));
    $memcache->set($memcache_key,serialize($busStopURLs),0,0);
  }
  else{
    $memcache_ret=$memcache->get($memcache_key);
    if($memcache_ret != null){ // Check memcache
      $busStopURLs=unserialize($memcache_ret);
    }
    else{
      $busStopURLs=unserialize(file_get_contents(STOPS_FILE));
      $memcache->set($memcache_key,serialize($busStopURLs),0,0);
    }
  }
  return $busStopURLs;
}

/* Cycle through apikeys to avoid rate limiting */
function getWMATAAPIKey(){
  global $WMATAAPIKeys;
  global $memcache;
  $memcache_key=MEMCACHED_PREFIX."_WMATA_API_KEYS";
  $memcache_ret=$memcache->get($memcache_key);
  if($memcache_ret == null){ // Check memcache
    $WMATAAPIKeysCached=$WMATAAPIKeys;
  }
  else{
    $WMATAAPIKeysCached=unserialize($memcache_ret);
  }
  $key=array_shift($WMATAAPIKeysCached);
  $WMATAAPIKeysCached[]=$key;
  $memcache->set($memcache_key,serialize($WMATAAPIKeysCached),0,0);
  return $key;
}

?>
