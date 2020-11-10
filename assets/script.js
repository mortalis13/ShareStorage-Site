
function set_message(text, type) {
  var messages = $("#note-messages");
  messages.removeClass('note-operation-error');
  messages.removeClass('note-operation-ok');
  messages.html(text);
  
  if (type == 'ok') {
    messages.addClass('note-operation-ok');
  }
  else if (type == 'error') {
    messages.addClass('note-operation-error');
  }
}


$(function(){
  
  var uploadUrl = 'upload.php';
  
  $("#note-messages").click(function(){
    $(this).empty();
  });
  
  $("#save-note").click(function(){
    var url = uploadUrl;
    var text = $("#main-note").val();
    
    set_message('Saving note...');
    
    $.ajax({
      url: url,
      method: 'POST',
      data: {
        action: 'saveNote',
        text: text
      },
      success: function(data){
        console.log('ajax-ok', data);
        set_message('&#x02713; Note saved', 'ok');
      },
      error: function(a1, a2, a3){
        console.log('ajax-error', a1, a2, a3);
        set_message('&#x02717; Error saving note, check the Console', 'error');
      }
    });
  });
  
  
  $("#delete-all-notes").click(function(e){
    var url = uploadUrl;
    var data = {
      action: 'deleteAllNotes',
    };
    
    set_message('Deleting notes...');
    
    $.ajax({
      url: url,
      method: 'POST',
      data: data,
      success: function(data){
        console.log('ajax-ok', data);
        set_message('&#x02713; Notes deleted', 'ok');
      },
      error: function(a1, a2, a3){
        console.log('ajax-error', a1, a2, a3);
        set_message('&#x02717; Error deleting notes, check the Console', 'error');
      }
    });
    
    return false;
  });
  
  
  $(".download-file").click(function(){
    var url = uploadUrl;
    var filePath = $(this).parent('td').siblings('.file-link').find('a').attr('href').substring(1);
    
    var formId = 'download-form';
    var form = $('#'+formId).empty();
    
    if(!form.length){
      form = $("<form>");
      form.attr("id", formId);
      form.attr("action", url);
      form.attr("method", "POST");
      form.attr("enctype", "multipart/form-data");
      form.css('display', 'none');
    }
    
    var params = [
      ['action', 'downloadFile'],
      ['filePath', filePath],
    ];
    
    params.forEach(function(item){
      var input = $("<input>");
      input.attr("type", "hidden");
      input.attr("name", item[0]);
      input.attr("value", item[1]);
      form.append(input);
    });
    
    $(document.body).append(form);
    form.submit();
  });
  
  $(".delete-file").click(function(){
    var url = uploadUrl;
    
    var fileId = $(this).parent('td').siblings('.file-link').attr('id');
    var data = {
      action: 'deleteFile',
      fileId: fileId
    };
    
    $.ajax({
      url: url,
      method: 'POST',
      data: data,
      success: function(data){
        console.log('ajax-ok', data);
        location.reload();
      },
      error: function(a1, a2, a3){
        console.log('ajax-error', a1, a2, a3);
      }
    });
  });
  
  
  // -----------------------------------------------------
  
  var dropZoneTarget = $('.dropzone');
  var inDropZone = false;
  
  $(".dropzone").bind("dragover", function(e){
    if (!inDropZone) {
      inDropZone = true;
      console.log('DropZone enter');
      $(this).addClass('in');
    }
  });
  
  $(".dropzone").bind("dragleave", function(e) {
    var stopDrag = false;
    if (!e.relatedTarget) stopDrag = true;
    else {
      var parentDrop = $(e.relatedTarget).parents('.dropzone');
      if (e.relatedTarget != this && !parentDrop.length) stopDrag = true;
    }
    
    if (stopDrag) {
      inDropZone = false;
      console.log('DropZone exit');
      $(this).removeClass('in');
    }
  });
  
  
  var uploadData = {
    action: 'uploadFile'
  };
  
  $('#fileupload').fileupload({
    url: uploadUrl,
    dataType: 'json',
    formData: uploadData,
    dropZone: dropZoneTarget,
    
    done: function (e, data) {
      console.log('ajax-ok', data);
      location.reload();
    },
    
    progressall: function (e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      $('#upload-progress .progress-bar').css('width', progress + '%');
    },
  })
  .prop('disabled', !$.support.fileInput)
  .parent().addClass($.support.fileInput ? undefined : 'disabled')
  
})