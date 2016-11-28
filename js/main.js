function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ampm;
  return strTime;
}

var weekday = new Array(7);
weekday[0]=  "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";

var month = new Array();
month[0] = "January";
month[1] = "February";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "August";
month[8] = "September";
month[9] = "October";
month[10] = "November";
month[11] = "December";

function formatDateFull(d) {
	return weekday[d.getDay()] + ', ' + month[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear() + " at " + formatAMPM(d);
}

function formatDateShort(d, c) {
	var sec = (c-d)/1000;
	if(sec > 31536000) {
		return month[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
	} else if(sec > 2592000) {
		return month[d.getMonth()] + ' ' + d.getDate();
	} else if(sec > 172800) {
		return month[d.getMonth()] + ' ' + d.getDate() + ' at ' + formatAMPM(d);
	} else if(sec > 86400) {
		return 'Yesterday at ' + formatAMPM(d);
	} else if(sec > 3600) {
		var hr = (sec - (sec%3600))/3600;
		return hr + ((hr == 1)?" hr":" hrs");
	} else if(sec > 60) {
		var min = (sec - (sec%60))/60;
		return min + ((min == 1)?" min":" mins");
	} else {
		return "Just now";
	}
}

function getDuration(start, end) {
	return getDurationStr((end - start) / 1000);
}

function getDurationStr(duration) {
	duration = duration - (duration % 1);

	if(duration == 0)
		return "-";

	var sec = duration % 60;
	duration -= sec;

	if(sec > 0)
		duration += 60;

	var min = duration % 3600;
	duration -= min;
	min /= 60;


	var hr = duration % 86400;
	duration -= hr;
	hr /= 3600;

	var day = duration / 86400;

	var str = "";
	if(day > 0) {
		str += day + " day" + ((day==1)?" ":"s ");
	}
	if(hr > 0) {
		str += hr + " hour" + ((hr==1)?" ":"s ");
	}
	if(min > 0) {
		str += min + " minute" + ((min==1)?" ":"s ");
	}

	return str;
}

function endActivity(id) {
	$.ajax({
		type: 'POST',
		data: { id : id },
		url: 'php/end_activity.php',
		dataType: 'json',

		success: function(result){
			document.location.reload(true);
		},

		error: function(result) {
			alert(result.responseText);
		}
	});
}

function deleteActivity(id) {
	var r = confirm("Delete this Activity?");
	if (r == true) {
	    $.ajax({
			type: 'POST',
			data: { id : id },
			url: 'php/delete_activity.php',
			dataType: 'json',

			success: function(result){
				document.location.reload(true);
			},

			error: function(result) {
				alert(result.responseText);
			}
		});
	}
}

function pokeUser(id, name) {
	var str = "Do you want to poke \""+ name +"\" by email?";
	var r = confirm(str);
	if (r == true) {
	    $.ajax({
			type: 'POST',
			data: { id : id },
			url: 'php/send_email.php',
			dataType: 'json',

			success: function(result){
				document.location.reload(true);
			},

			error: function(result) {
				alert(result.responseText);
			}
		});
	}
}

function getActivityList(activities, userFirst) {
	var strHTML = "";
  var ownHTML = "";
  console.log(activities);
	for(var i=0; i<activities.length; i++) {
		var owner_id = activities[i].owner_id;
		var owner_name = activities[i].owner_name;
		var img;

		var status_text = " ";
		if(activities[i].status_text) {
			var status_text_arr = activities[i].status_text.split(" ");
			var tmp_str = "";

			for(var j=0; j<status_text_arr.length; j++) {
				tmp_str = status_text_arr[j];
				if(tmp_str.substring(0,1) == "#") {
					var tmp_str = status_text_arr[j].slice(1);
					tmp_str = "<code><a href='project.php?tag=" + tmp_str + "'>#" + tmp_str + "</a></code>"
				}
				tmp_str = tmp_str + " ";
				status_text = status_text + " " + tmp_str;
			}

			if(activities[i].online == 1)
				if (owner_name == "You")
					status_text = " are working on " + status_text;
				else
					status_text = " is working on " + status_text;
			else if (activities[i].online == 2) {
				if (owner_name == "You")
					status_text = " have done " + status_text;
				else
					status_text = " has done " + status_text;
			}

			img = '<img class="media-object img-circle" width="64" src="images/profile' + owner_id + '.jpg">';
		}
		else {
			if(activities[i].owner_name == "You") {
				status_text = " haven't updated anything yet.";
			} else {
				status_text = " hasn't updated anything yet.";
			}

			img = '<img class="media-object img-circle offline-img" width="64" src="images/profile' + owner_id + '.jpg">';
		}

		var str = '<div class="row"><div class="col-xs-12 col-md-12"><div class="media"><div class="media-left media-middle">' + img + '</div><div class="media-body media-middle"><p><strong>' + owner_name + '</strong>' + status_text + '';

		var startTime = activities[i].start_time;
		var updatedAt = activities[i].updated_at;
		var crT = new Date(activities[i].current_time);

		// if(updatedAt) {
		// 	var date = new Date(updatedAt);
		// 	str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
		// }
    // else if(startTime) {
		// 	var date = new Date(startTime);
		// 	str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
		// }
    //
		// var endTime = activities[i].end_time;
		// if(endTime) {
		// 	var stT = new Date(startTime);
		// 	var edT = new Date(activities[i].end_time);
		// 	str = str + '<small class="text-muted"style="line-height:10px;"> &mdash; total ' + getDuration(stT, edT) + '</small>';
		// }

    if(activities[i].owner_name != "You" && activities[i].status_text!= null){
      if(updatedAt) {
  			var date = new Date(updatedAt);
  			str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
  		}
      else if(startTime) {
  			var date = new Date(startTime);
  			str = str + '<br><small class="text-muted"style="line-height:10px;" title="' + formatDateFull(date) + '">' + formatDateShort(date, crT) + '</small>';
  		}

  		var endTime = activities[i].end_time;
  		if(endTime) {
  			var stT = new Date(startTime);
  			var edT = new Date(activities[i].end_time);
  			str = str + '<small class="text-muted"style="line-height:10px;"> &mdash; total ' + getDuration(stT, edT) + '</small>';
  		}
    }

		str = str + '</p></div>';

		if(activities[i].editable && activities[i].status_text != null) {
			str = str + '<div class="media-body media-middle" style="width:100px"><button onClick="endActivity(' + activities[i].activity_id + ')" type="button" class="btn btn-sm btn-success btn-block"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Done</button><button onClick="deleteActivity(' + activities[i].activity_id + ')" type="button" class="btn btn-sm btn-danger btn-block"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button></div>';
		}
    else if(activities[i].status_text == null) {
      if(activities[i].owner_name != "You") {
  			str = str + '<div class="media-body media-middle" style="width:100px"><button onClick="pokeUser(' + owner_id + ',\'' + owner_name + '\')" type="button" class="btn btn-sm btn-primary btn-block"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Poke</button></div>';
      }
		}

		str = str + '</div></div></div></div><hr>';
		if(userFirst && activities[i].owner_name == "You") {
      returnOwnActivity(str);
			// strHTML = str + strHTML;
		} else {
			strHTML = strHTML + str;
		}
	}
	return strHTML;
}

function returnOwnActivity(str) {
  $("#ownActivity").html(str);
  console.log(str);
}
