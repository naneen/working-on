function addToDo(todo, place){
  $.ajax({
    type: 'POST',
    data: { status_text: todo },
    url: 'php/post_to_do.php',
    dataType: 'json',

    success: function(result){
      // console.log('[server] ' + result);
      if(result.status == 1) {
        document.location.reload(true);
      }
      else {
        if(place == "head") {
          $("#input-group").addClass("has-error");
          $("#help-block").show();
        }
        else if(place == "underlist") {
          $("#todo-textarea").addClass("has-error");
          $("#td-error").show();
        }
      }
      $("#activity-input").attr("disabled",false);
    },

    error: function(result) {
      alert(result.responseText);
      $("#activity-input").attr("disabled",false);
    }
  });
}

function isCrossout(lists) {
  for (var i = 0; i < lists.length; i++) {
    if (lists[i].status == "crossout") {
      var id = lists[i].to_do_id;
      $(".cb"+id).prop("checked", true);
      $(".sp"+id).css("textDecoration","line-through");
    }
  }
}

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
  var strHTML = "";
  var previousTag = "";
  var strDropdown = "";

	for(var i=0; i<lists.length; i++) {
    var owner_id = lists[i].owner_id;
		var owner_name = lists[i].owner_name;
    var task = " ";
    var task_id = lists[i].to_do_id;
    var tag_id = lists[i].tag_id;
    var tag_name = lists[i].tag_name;

    if (tag_id != previousTag){
      previousTag = tag_id;
      var tag = "<code><a href='project.php?tag=" + tag_name + "'>#" + tag_name + "</a></code>"
      strHTML += "<h5 class='tag_subtitle'>" + tag + "</h5>";
    }

    var str = '<div class="checkbox"><label style="word-wrap:break-word"><input type="checkbox" class="cb' + task_id + '" value="' + task_id + '"><span class="sp' + task_id + '">'+ lists[i].task +'</span></input></label></div>';
		strHTML = strHTML + str;

    strDropdown += "<li><a href='#'>" + lists[i].task + "</a></li>";
	}
  $("#td-dropdown").append(strDropdown);

	return strHTML;
}

$.ajax({
	type: 'POST',
	url: 'php/get_to_do.php',
	dataType: 'json',

	success: function(result) {
    if(result.todos.length > 0) {
      $('#todogroup').show();
      $('#td-dropdown').css("display", "");
      var tableHTML = getToDoList(result.todos);
      $("#checkboxlist").append(tableHTML);
      isCrossout(result.todos);

      $( "#activity-input" ).keypress(function() {
        console.log( "Handler for .keypress() called." );
        $('#dropdown-group').removeClass('open');
        $('.dropdown').css("aria-expanded", "false");
      });

      $('.dropdown li > a').click(function(e){
        $('#activity-input').val(this.innerHTML);
      });
      // $( "#activity-input" ).click(function() {
      //   console.log( "Handler for .click() called." );
      // });

      // $(document).click(function(){
      //   $("#dropdown").hide();
      // });
    }
    else {
      // console.log("You didn't add anything to the list.");
    }
	},

	error: function(result) {
		console.log(result.responseText);
	}
});

function isChecked(allCB, id) {
  for(var i=0; i< allCB.length; i++){
    if(allCB[i].checked){
      return true;
    }
  }
  return false;
}

$("#checkboxlist").on("click", "input[class^=cb]", function (td) {
  var classname = td.currentTarget.className;
  var id = classname.slice(2)
  if ($(this).is(':checked')) {
    $("."+classname).prop("checked", true);
    $(".sp"+id).css("textDecoration","line-through");
  }
  else {
    $("."+classname).prop("checked", false);
    $(".sp"+id).css("textDecoration","none");
  }
  updateStatus(id);
});

function updateStatus (id) {
  $.ajax({
    type: 'POST',
    data: { activity_id: id },
    url: 'php/update_td_status.php',
    dataType: 'json',

    success: function(result){
      console.log(result);
    },

    error: function(result) {
      alert(result.responseText);
    }
  })
};

$("#todo-input").keypress(function(event){
	if (event.keyCode != 13) { //enter key
		return;
	}
	else {
		var text = $("#todo-input").val().trim();
    console.log("[underlist] " + text);
		var firstChar = text.substring(0, 1);
		if(firstChar == "+"){
			addToDo(text.substring(1, text.length).trim(), "underlist");
		}
		else {
      addToDo(text, "underlist");
		}
    return false;
	}
});
