function addToDo(todo){
  var markup = '<li><div class="checkbox"><label><input type="checkbox" value="" />'+ todo +'</label></div></li>';
  // $("#sortable").append(markup);

  $.ajax({
    type: 'POST',
    data: { status_text: todo },
    url: 'php/post_to_do.php',
    dataType: 'json',

    success: function(result){
      if(result.status == 1) {
        document.location.reload(true);
        // $("#activity-input").val('');
        // $("#help-block").hide();
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

$.ajax({
	type: 'POST',
	url: 'php/get_to_do.php',
	dataType: 'json',

	success: function(result){
		console.log(result);
		$("#sortable").append(getToDoList(result.todos));
	},

	error: function(result) {
		console.log(result.responseText);
	}
});

function getToDoList(todos) {
	var strHTML = ""

	for(var i=0; i<todos.length; i++) {
		var owner_id = todos[i].owner_id;
		var owner_name = todos[i].owner_name;

		var task = " ";
		if(todos[i].task) {
			var task_arr = todos[i].task.split(" ");
			var tmp_str = "";
			for(var j=0; j<task_arr.length; j++) {
				tmp_str = task_arr[j];
				if(tmp_str.substring(0,1) == "#") {
					var tmp_str = task_arr[j].slice(1);
					tmp_str = "<code><a href='project.php?tag=" + tmp_str + "'>#" + tmp_str + "</a></code>"
				}
				tmp_str = tmp_str + " ";
				task = task + " " + tmp_str;
			}
		}


		var str = '<li><div class="checkbox"><label><input type="checkbox" value="" />'+ task +'</label></div></li>';
		// var startTime = todos[i].start_time;
		// var updatedAt = todos[i].updated_at;
		// var crT = new Date(todos[i].current_time);
		// if(updatedAt) {
		// 	var date = new Date(updatedAt);
		// 	str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
		// }else if(startTime) {
		// 	var date = new Date(startTime);
		// 	str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
		// }
    //
		// str = str + '</p></div>';
    //
		// if(todos[i].editable && todos[i].task != null) {
		// 	str = str + '<div class="media-body media-middle" style="width:100px"><button onClick="endActivity(' + todos[i].activity_id + ')" type="button" class="btn btn-sm btn-success btn-block"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Done</button><button onClick="deleteActivity(' + todos[i].activity_id + ')" type="button" class="btn btn-sm btn-danger btn-block"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button></div>';
		// }else if(todos[i].task == null) {
		// 	str = str + '<div class="media-body media-middle" style="width:100px"><button onClick="pokeUser(' + owner_id + ',\'' + owner_name + '\')" type="button" class="btn btn-sm btn-primary btn-block"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Poke</button></div>';
		// }
    //
		// str = str + '</div></div></div></div><hr>';
		// if(userFirst && todos[i].owner_name == "You") {
		// 	strHTML = str + strHTML;
		// } else {
			strHTML = strHTML + str;
		// }
	}
	return strHTML;
}
