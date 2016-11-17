function addToDo(todo){
  $.ajax({
    type: 'POST',
    data: { status_text: todo },
    url: 'php/post_to_do.php',
    dataType: 'json',

    success: function(result){
      if(result.status == 1) {
        document.location.reload(true);
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

	success: function(result) {
    if(result.todos.length > 0) {
      var tableHTML = '<table class="table table-bordered"><thead><tr id="tag_text">' + getTagInList(result.todos) + '</tr></thead><tbody><tr><td><ul id="todolist" class="list-unstyled">' + getToDoList(result.todos) + '</ul></td><td>Otto</td><td>@mdo</td></tr></tbody></table>';

      $(".panel-body").append(tableHTML);
      // $("#tag_text").append(getTagInList(result.todos));
  		// $("#todolist").append(getToDoList(result.todos));
    }
    else {
      var tableHTML = "You didn't add anything to the list.";
      $(".panel-body").append(tableHTML);
    }
	},

	error: function(result) {
		console.log(result.responseText);
	}
});

function getTagInList(lists) {
  var tag_list = [];
  var unique = [];
  var theadHTML = "";

  for (var i = 0; i < lists.length; i++) {
    tag_list.push(lists[i].tag_id);
  }
  // unique values in an array
  unique = tag_list.filter((v, i, a) => a.indexOf(v) === i);

  for (var i = 0; i < unique.length; i++) {
    theadHTML += "<th>" + unique[i] + "</th>";
  }
  return theadHTML;
}

function getToDoList(lists) {
	var strHTML = ""

	for(var i=0; i<lists.length; i++) {
		var owner_id = lists[i].owner_id;
		var owner_name = lists[i].owner_name;

		var task = " ";
		if(lists[i].task) {
			var task_arr = lists[i].task.split(" ");
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

		strHTML = strHTML + str;
	}
	return strHTML;
}

// $.ajax({
// 	type: 'POST',
// 	url: 'php/get_to_do.php',
// 	dataType: 'json',
//
// 	success: function(result){
// 		console.log(result);
// 		$("#todolist").append(getToDoList(result.lists));
// 	},
//
// 	error: function(result) {
// 		console.log(result.responseText);
// 	}
// });
//
// function getToDoList(lists) {
// 	var strHTML = ""
//
// 	for(var i=0; i<lists.length; i++) {
// 		var owner_id = lists[i].owner_id;
// 		var owner_name = lists[i].owner_name;
//
// 		var task = " ";
// 		if(lists[i].task) {
// 			var task_arr = lists[i].task.split(" ");
// 			var tmp_str = "";
// 			for(var j=0; j<task_arr.length; j++) {
// 				tmp_str = task_arr[j];
// 				if(tmp_str.substring(0,1) == "#") {
// 					var tmp_str = task_arr[j].slice(1);
// 					tmp_str = "<code><a href='project.php?tag=" + tmp_str + "'>#" + tmp_str + "</a></code>"
// 				}
// 				tmp_str = tmp_str + " ";
// 				task = task + " " + tmp_str;
// 			}
// 		}
//
//
// 		var str = '<li><div class="checkbox"><label><input type="checkbox" value="" />'+ task +'</label></div></li>';
// 		// var startTime = lists[i].start_time;
// 		// var updatedAt = lists[i].updated_at;
// 		// var crT = new Date(lists[i].current_time);
// 		// if(updatedAt) {
// 		// 	var date = new Date(updatedAt);
// 		// 	str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
// 		// }else if(startTime) {
// 		// 	var date = new Date(startTime);
// 		// 	str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
// 		// }
//     //
// 		// str = str + '</p></div>';
//     //
// 		// if(lists[i].editable && lists[i].task != null) {
// 		// 	str = str + '<div class="media-body media-middle" style="width:100px"><button onClick="endActivity(' + lists[i].activity_id + ')" type="button" class="btn btn-sm btn-success btn-block"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Done</button><button onClick="deleteActivity(' + lists[i].activity_id + ')" type="button" class="btn btn-sm btn-danger btn-block"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button></div>';
// 		// }else if(lists[i].task == null) {
// 		// 	str = str + '<div class="media-body media-middle" style="width:100px"><button onClick="pokeUser(' + owner_id + ',\'' + owner_name + '\')" type="button" class="btn btn-sm btn-primary btn-block"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Poke</button></div>';
// 		// }
//     //
// 		// str = str + '</div></div></div></div><hr>';
// 		// if(userFirst && lists[i].owner_name == "You") {
// 		// 	strHTML = str + strHTML;
// 		// } else {
// 			strHTML = strHTML + str;
// 		// }
// 	}
// 	return strHTML;
// }
