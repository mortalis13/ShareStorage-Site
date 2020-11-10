<?php
  
  include_once('db_class.php');
  
  function fix_file_size($file_id, $file_path){
    $file_size = filesize($_SERVER['DOCUMENT_ROOT'].$file_path);
    $db = new DB();
    $db->connect_db();
    $db->update_file_size($file_id, $file_size);
  }
  
  function fix_file_size_all(){
    $db = new DB();
    $db->connect_db();
    
    $files = $db->get_files();
    foreach ($files as $file) {
      $file_id = $file['id'];
      $file_path = '/' . $file['dir_path'] . '/' . $file['name'];
      
      echo 'Processing file \'' . $file_path . '\'<br>';
      fix_file_size($file_id, $file_path);
    }
  }
  
  function format_size($file_size){
    if ($file_size >= 1073741824) {
        $file_size = number_format($file_size / 1073741824, 2) . ' GB';
    }
    elseif ($file_size >= 1048576) {
        $file_size = number_format($file_size / 1048576, 2) . ' MB';
    }
    elseif ($file_size >= 1024) {
        $file_size = number_format($file_size / 1024, 2) . ' KB';
    }
    else {
        $file_size = $file_size . 'B';
    }

    return $file_size;
  }
  
  if(isset($_GET['action'])){
    $action = $_GET['action'];
    if($action == 'ffs'){
      fix_file_size_all();
    }
  }
  
?>