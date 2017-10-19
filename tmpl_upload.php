<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Storage Upload</title>

  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/jquery.fileupload/css/jquery.fileupload.css">

  <link rel="stylesheet" href="assets/style.css">

  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="assets/jquery.fileupload/js/vendor/jquery.ui.widget.js"></script>
  <script src="assets/jquery.fileupload/js/jquery.fileupload.js"></script>

  <script src="assets/script.js"></script>
</head>

<body>
<div class="main-content">
  
  <div class="text-notes">
    <div class="main-note-text">
      <textarea name="main_note" id="main-note" cols="30" rows="10"><?=$text?></textarea>
    </div>
    <div class="note-controls">
      <button id="save-note" class="s_button">Save</button>
    </div>
    <div id="note-messages"></div>
  </div>
  
  <div class="files">
    <div class="upload-form dropzone">
      <div class="upload-zone">
        <span class="btn fileinput-button s_button">
          <i class="glyphicon glyphicon-plus"></i>
          <span>Select files...</span>
          <input id="fileupload" type="file" name="files[]" multiple>
        </span>
      </div>
      <div id="upload-progress" class="progress">
        <div class="progress-bar"></div>
      </div>
      <div id="drop-text">Drop files...</div>
    </div>
    
    <div class="files-info">
      <table class="files-table">
        <tr class="header">
          <td>File</td>
          <td>Size</td>
          <td>Date</td>
          <td>Actions</td>
        </tr>
        
        <?php
          foreach($files as $file){
            $file_id = $file['id'];
            $file_name = $file['name'];
            $file_path = '/' . $file['dir_path'] . '/' . $file_name;
            $file_date = $file['date'];
            $file_size = $file['size'];
            $file_size = format_size($file_size);
          ?>
            <tr>
              <td id="<?=$file_id?>" class="file-link"><a href="<?=$file_path?>" target="_blank"><?=$file_name?></a></td>
              <td class="auto-width"><?=$file_size?></td>
              <td class="auto-width"><?=$file_date?></td>
              <td class="auto-width">
                <button class="s_button download-file">Download</button>
                <button class="s_button delete-file">Delete</button>
              </td>
            </tr>
          <?php
          }
        ?>
      </table>
    </div>
  </div>
</div>

</body>
</html>
