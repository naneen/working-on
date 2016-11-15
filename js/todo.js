function addToDo(text){
  var todo = text.substring(1, text.length).trim();;
  var markup = '<li><div class="checkbox"><label><input type="checkbox" value="" />'+ todo +'</label></div></li>';
  $("#sortable").append(markup);
  $("#activity-input").val('')

  $.ajax({
    type: 'POST',
    data: { status_text: text },
    url: 'php/post_status.php',
    dataType: 'json',

    success: function(result){
      if(result.status == 1) {
        document.location.reload(true);
        console.log('post result : success');
      }
      // else {
      //   $("#input-group").addClass("has-error");
      //   $("#help-block").show();
      // }
      // waitToPost = false;
      // $("#activity-input").attr("disabled",false);
    },

    error: function(result) {
      alert(result.responseText);
      waitToPost = false;
      $("#activity-input").attr("disabled",false);
    }
  });
}
