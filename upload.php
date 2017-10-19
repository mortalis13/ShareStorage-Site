<?php
  
  include('utils/db_class.php');
  include('utils/utils.php');
  
  function print_content($text_notes, $files){
    $text = '';
    if(count($text_notes) > 0){
      $main_note = $text_notes[0];
      $text = $main_note['text'];
    }
    
    include('tmpl_upload.php');
  }
  
  // -------------------------------------
  
  if(isset($_POST['action'])){
    $action = $_POST['action'];
    
    if($action == 'saveNote'){
      $text = $_POST['text'];
      
      $db = new DB();
      $db->connect_db();
      $db->save_text_note($text);
      $db->close();
      
      die('true');
    }
    else if($action == 'uploadFile') {
      $files = $_FILES['files'];
      $dir_path = 's';
      
      $db = new DB();
      $db->connect_db();
      
      foreach ($files['tmp_name'] as $index => $value) {
        if ($files['error'][$index] > 0){
          echo 'Error: ' . $files['error'] . '<br>';
          die('false');
        }
        else{
          $file_name = $files['name'][$index];
          $file_path = $dir_path . '/' . $file_name;
          move_uploaded_file($files['tmp_name'][$index], $file_path);
          $db->save_file_data($file_name, $dir_path);
        }
      }
        
      $db->close();
      die('true');
    }
    else if($action == 'downloadFile'){
      $file_url = $_POST['filePath'];
      header('Content-Type: application/octet-stream');
      header("Content-Transfer-Encoding: Binary"); 
      header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
      
      readfile($file_url);
      die('true');
    }
    else if($action == 'deleteFile'){
      $file_id = $_POST['fileId'];
      $db = new DB();
      $db->connect_db();
      $db->delete_file($file_id);
      
      die('true');
    }
  }
  
  $db = new DB();
  $db->connect_db();
  
  $text_notes = $db->get_text_notes();
  $files = $db->get_files();
  $db->close();
  
  print_content($text_notes, $files);
  
?>