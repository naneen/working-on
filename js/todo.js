getToDoRequest("own");

$(window).load(function() {
  $('#cb-infrontof-input').attr('disabled', true);
  $('#cb-infrontof-input').css("cursor", "default");
});

$("#checkboxlist").on("click", "input[class^=cb]", function (td) {
  var classname = td.currentTarget.className;
  var id = classname.slice(2)
  console.log("click at "+classname);
  if($(this).is(':checked')) {
    $("."+classname).prop("checked", true);
    $(".sp"+id).css("textDecoration","line-through");
  }
  else {
    $("."+classname).prop("checked", false);
    $(".sp"+id).css("textDecoration","none");
  }
  updateStatus(id);
});

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

function addToDo(todo, place){
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

function showOthersToDo() { //for only admin account
  for (var i = 0; i < currentEmployee.length; i++) {
    var id = currentEmployee[i].id
    if(id != admin) {
      getToDoRequest(id);
    }
  }
}

function getToDoRequest(owner){
  $.ajax({
    type: 'POST',
    data: { owner: owner },
    url: 'php/get_to_do.php',
    dataType: 'json',

    success: function(result) {
      if(result.todos.length > 0) {
        var list_owner_id = result.todos[0].owner_id;
        var tableHTML = getToDoList(result.todos);

        if (owner == "own") {
          $('#ownTodogroup').show();
          $('#td-dropdown').css("display", "");
          $("#checkboxlist").append(tableHTML);

          if(list_owner_id == admin) {
            showOthersToDo();
          }
        }
        else {
          $("#activity"+owner).append(tableHTML);
          $("#activity"+owner).find("input[type='checkbox']").attr('disabled', true);
          $("#activity"+owner).find("input[type='checkbox']").css("cursor", "default");
          $("#activity"+owner).find("label").css("cursor", "default");
        }
        isCrossout(result.todos);

        $("#activity-input").on('keydown', function(e){
          $('#dropdown-group').removeClass('open');
          $('.dropdown').css("aria-expanded", "false");
        });

        $( "#activity-input" ).click(function() {
          var input = $("#activity-input").val().trim();
          if( input.length > 0 ) {
            $('.dropdown-toggle').removeAttr( "data-toggle" )
          }
          else {
            $(".dropdown-toggle").attr("data-toggle", "dropdown");
          }
        });

        $('.dropdown li > a').click(function(e){
          $('#activity-input').focus().val(this.innerHTML);
        });
      }
      return true;
    },

    error: function(result) {
      console.log(result.responseText);
    }
  });
}

function isChecked(allCB, id) {
  for(var i=0; i< allCB.length; i++){
    if(allCB[i].checked){
      return true;
    }
  }
  return false;
}

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
