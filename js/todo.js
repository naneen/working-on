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
      // var tableHTML = "<div class='table-responsive'><table class='table table-bordered'><thead><tr id='tag_text'>" + getTagInList(result.todos) + getToDoList(result.todos) + "</div>";
      var tableHTML = getToDoList(result.todos);

      $(".checkboxlist").append(tableHTML);
    }
    else {
      var tableHTML = "You didn't add anything to the list.";
      $(".checkboxlist").append(tableHTML);
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
    tag_list.push(lists[i].tag_name);
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
  var strHTML = "";
  var previousTag = "";

	for(var i=0; i<lists.length; i++) {
    var owner_id = lists[i].owner_id;
		var owner_name = lists[i].owner_name;
    var task = " ";

    if (lists[i].tag_id != previousTag){
      // tag title is clickable
      // previousTag = lists[i].tag_id;
      // var tag = "<code><a href='project.php?tag=" + lists[i].tag_name + "'>#" + lists[i].tag_name + "</a></code>"
      // strHTML += "<h5 style='margin-top: 10px;'>" + tag + "</h5>";

      // tag title is unclickable
      strHTML += "<h5 style='margin-top: 10px;'>" + lists[i].tag_name + "</h5>";

      // if(lists[i].task) {
  		// 	var task_arr = lists[i].task.split(" ");
  		// 	var tmp_str = "";
  		// 	for(var j=0; j<task_arr.length; j++) {
  		// 		tmp_str = task_arr[j];
  		// 		if(tmp_str.substring(0,1) == "#") {
  				// 	var tmp_str = task_arr[j].slice(1);
  				// 	tmp_str = "<code><a href='project.php?tag=" + tmp_str + "'>#" + tmp_str + "</a></code>"
  				// }
  		// 		tmp_str = tmp_str + " ";
  		// 		task = task + " " + tmp_str;
  		// 	}
  		// }
    }
    // else {
    //   if(lists[i].task) {
  	// 		var task_arr = lists[i].task.split(" ");
  	// 		var tmp_str = "";
  	// 		for(var j=0; j<task_arr.length; j++) {
  	// 			tmp_str = task_arr[j];
  	// 			if(tmp_str.substring(0,1) == "#") {
  	// 				var tmp_str = task_arr[j].slice(1);
  	// 				tmp_str = "<code><a href='project.php?tag=" + tmp_str + "'>#" + tmp_str + "</a></code>"
  	// 			}
  	// 			tmp_str = tmp_str + " ";
  	// 			task = task + " " + tmp_str;
  	// 		}
  	// 	}
    // }

    var str = '<div class="checkbox"><label onClick="crossOut(' + lists[i].to_do_id + ')"><input type="checkbox" value="" />'+ lists[i].task +'</label></div>';

		strHTML = strHTML + str;
	}
  // strHTML += "</td></tr></tbody>";
	return strHTML;
}

function isChecked(allCB) {
  for(var i=0; i< allCB.length; i++){
    if(allCB[i].checked){
      return true;
    }
  }
  return false;
}

function crossOut(id) {
//   console.log("click");
  var allCB = document.querySelectorAll("input");
  console.log(allCB);
  // for(var i=0; i< allCB.length; i++){
  //   if(isChecked(allCB)){
  //     for(var j=0; j< allCB.length; j++){
  //       console.log("allBB["+j+"] = " + allCB[j].checked);
  //       allCB[j].checked=true;
  //
  //       $('.sp'+id).css('textDecoration','line-through');
  //       console.log("-----------");
  //     }
  //   }
  //   else {
  //     for(var j=0; j< allCB.length; j++){
  //         allCB[j].checked=false;
  //         $('.sp'+id).css('textDecoration','none');
  //     }
  //   }
  // }
  //
  // console.log("========");
}
