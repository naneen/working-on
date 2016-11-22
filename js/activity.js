function addTag(tag) {
	var str = $("#activity-input").val();
	var last = str.charAt(str.length-1);
	if(last == "" || last == " ") {
		$("#activity-input").val(str + "#" + tag + " ");
	} else {
		$("#activity-input").val(str + " #" + tag + " ");
	}
	$("#activity-input").focus();
}

$.ajax({
	type: 'POST',
	url: 'php/get_tag.php',
	dataType: 'json',

	success: function(result){
		var tagsList = [];
		for(var i=0; i<result.tags.length; i++) {
			tagsList.push(result.tags[i]);

			// Only create shortcuts for the first 20 recent tags
			if (i < 20)
			{
				var str = "<kbd onClick='addTag(\"" + result.tags[i] + "\")' style='cursor:pointer'>#" + result.tags[i] + "</kbd> ";
				$("#tag").append(str);
			}
		}
		$('#activity-input').triggeredAutocomplete({
			hidden: '#hidden_inputbox',
			source: tagsList,
			trigger: "#",
			allowDuplicates: false
		});
	},

	error: function() {
		console.log("can't get tags");
	}
});

$.ajax({
	type: 'POST',
	url: 'php/get_activity.php',
	dataType: 'json',

	success: function(result){
		// console.log(result);
		$("#activity").html(getActivityList(result.activities, true));
	},

	error: function(result) {
		console.log(result.responseText);
	}
});

function addActivity(text) {
	$("#activity-input").attr("disabled",true);
	$.ajax({
		type: 'POST',
		url: 'php/end_activity.php',
		dataType: 'json',
		success: function(result){
			$.ajax({
				type: 'POST',
				data: { status_text: text },
				url: 'php/post_status.php',
				dataType: 'json',

				success: function(result){
					if(result.status == 1) {
						document.location.reload(true);
					} else {
						$("#input-group").addClass("has-error");
						$("#help-block").show();
					}
					waitToPost = false;
					$("#activity-input").attr("disabled",false);
				},

				error: function(result) {
					alert(result.responseText);
					waitToPost = false;
					$("#activity-input").attr("disabled",false);
				}
			});
		},

		error: function(result) {
			alert(result.responseText);
		}
	});
}

var waitToPost = false;
$("#activity-input").keypress(function(event){
	if (event.keyCode != 13) { //enter key
		return;
	}
	else {
		//disable enter key
		var msg = $("#activity-input").val().replace(/\n/g, "");

		//post activity
		if(!waitToPost) {
			waitToPost = true;
			var text = $("#activity-input").val();
			var firstTwo = text.substring(0, 2);
			if(firstTwo == "+ "){
				addToDo(text.substring(2, text.length));
				var waitToPost = false;
			}
			else {
				// var text = $("#activity-input").val().trim();
				addActivity(text.trim());
			}
		}
  	return false;
	}
});

$('#logout-btn').on('click', function(event) {
	location.href("php/logout.php");
});
