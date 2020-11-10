<?php

$d = 's';
$files = scandir($d);

if(count($files)){
  foreach($files as $f){
    if(substr($f, -3) == '.zi'){
      $from_name = $d . '/' . $f;
      $to_name = $from_name . 'p';
      
      rename($from_name, $to_name);
    }
  }
}

echo 'Finish rename';
?>
