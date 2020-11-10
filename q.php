<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><link rel="shortcut icon" href="about:blank"/><title>Quick Note</title></head>
<?php
  include('utils/db_class.php');
  include('utils/utils.php');
  
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
    else if($action == 'deleteAllNotes'){
      $db = new DB();
      $db->connect_db();
      $db->delete_all_text_notes();
      $db->close();
      die('true');
    }
  }
  
  $db = new DB();
  $db->connect_db();
  $text_notes = $db->get_text_notes();
  $db->close();
  
  $text = '';
  if(count($text_notes) > 0){
    $main_note = $text_notes[0];
    $text = $main_note['text'];
  }
?>
<body>
<div><textarea id="main-note" cols="50" rows="15"><?=$text?></textarea></div>
<div><button onclick="saveNote()">Save</button> <button onclick="deleteNotes()">Delete All</button></div>
<div id="note-messages"></div>
<script>
  function saveNote(){
    var messages=document.getElementById("note-messages")
    messages.innerHTML='Saving note...'
    
    var formData=new FormData()
    formData.append('action', 'saveNote')
    formData.append('text', document.getElementById("main-note").value)
    
    fetch('q.php', {method: 'POST', body: formData})
      .then(r => {console.log('ajax-ok', r);messages.innerHTML='&#x02713; Note saved';})
      .catch(e => {console.log('ajax-error', e);messages.innerHTML='&#x02717; Error saving note, check the Console';})
  }
  function deleteNotes(){
    var messages=document.getElementById("note-messages")
    messages.innerHTML='Deleting notes...'
    
    var formData=new FormData()
    formData.append('action', 'deleteAllNotes')
    
    fetch('q.php', {method: 'POST', body: formData})
      .then(r => {console.log('ajax-ok', r);messages.innerHTML = '&#x02713; Notes deleted';})
      .catch(e => {console.log('ajax-error', e);messages.innerHTML = '&#x02717; Error deleting notes, check the Console';})
  }
</script>
</body></html>