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
      var tableHTML = "<table class='table table-bordered'><thead><tr id='tag_text'>" + getTagInList(result.todos) + getToDoList(result.todos);

      $(".panel-body").append(tableHTML);
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
	var strHTML = "<tbody><tr>";
  var previousTag = "";
console.log(lists);
	for(var i=0; i<lists.length; i++) {
    var owner_id = lists[i].owner_id;
		var owner_name = lists[i].owner_name;
    var task = " ";

    if (lists[i].tag_id != previousTag){
      previousTag = lists[i].tag_id;
      strHTML += "<td><ul class='list-unstyled'>";

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
    }
    else {
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
    }

		var str = '<li><div class="checkbox"><label onClick="crossOut('+lists[i].to_do_id+')"><input type="checkbox" value="'+ lists[i].to_do_id +'"/><span class="sp'+ lists[i].to_do_id +'">'+ task +'</span></label></div></li>';

		strHTML = strHTML + str;
	}
  strHTML += "</td></tr></tbody>";
	return strHTML;
}

function crossOut(to_do_id) {
  console.log("to do id = "+to_do_id);
  $('.sp'+to_do_id).css('textDecoration','line-through');
}

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
// 		var str = '<li><div class="checkbox"><label><input type="checkbox" value="" />'+ task +'</label></div></li>';
//
// 		strHTML = strHTML + str;
// 	}
// 	return strHTML;
// }
