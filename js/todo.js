function addToDo(todo){
  var markup = '<li><div class="checkbox"><label><input type="checkbox" value="" />'+ todo +'</label></div></li>';
  $("#sortable").append(markup);
  $("#activity-input").val('');

  $.ajax({
    type: 'POST',
    data: { status_text: todo },
    url: 'php/post_to_do.php',
    dataType: 'json',

    success: function(result){
      if(result.status == 1) {
        // document.location.reload(true);
        console.log(todo);
      }
      else {
        $("#input-group").addClass("has-error");
        $("#help-block").show();
      }
      $("#activity-input").attr("disabled",false);
    },

    error: function(result) {
      alert(result.responseText);
      $("#activity-input").attr("disabled",false);
    }
  });
}
