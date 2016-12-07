$.ajax({
	type: 'POST',
	url: 'php/get_tag.php',
	dataType: 'json',

	success: function(result){
		for(var i=0; i<result.tags.length; i++) {
			if(i==0 && currentTag == null) {
				location.href = "project.php?tag=" + result.tags[i];
			}
			var str = "<a id='tag-" + result.tags[i] + "' class='btn btn-sm btn-primary' href='project.php?tag=" + result.tags[i] + "' style='margin:2px 0'>#" + result.tags[i] + "</a>&nbsp";
			$("#tag").append(str);
		}
		$("#tag-" + currentTag).addClass("active");

	},

	error: function() {
		console.log("can't get tags");
	}
});

$("#project-name").html((currentTag==null?"":"#"+currentTag));

$.ajax({
	type: 'POST',
	data: {tag:currentTag},
	url: 'php/get_tag_detail.php',
	dataType: 'json',

	success: function(result){
		$("#project-name").html("#"+currentTag);
		start = new Date(result.detail.created_time);
		end = new Date(result.detail.last_use);
		$("#created-time").html(formatDateFull(start));
		$("#last-use").html(formatDateFull(end));
	},

	error: function() {
		console.log("can't get tags");
	}
});

$("#start-time").html("#"+currentTag);

$.ajax({
	type: 'POST',
	url: 'php/get_activity_by_tag.php',
	data: {tag: currentTag},
	dataType: 'json',

	success: function(result){
		console.log(result);
		if(result.activities.length > 0) {
			$("#activity").html(getActivityList(result.activities, false));
			var sumDuration = 0;
			for(var i=0; i<result.activities.length; i++) {
				if(result.activities[i].end_time) {
					var edT = new Date(result.activities[i].end_time);
					var stT = new Date(result.activities[i].start_time);

					tmpDuration = (edT - stT) / 1000;
					tmpDuration = tmpDuration - (tmpDuration%1);
					sumDuration += tmpDuration;
				}
			}
			$("#total-time").html(getDurationStr(sumDuration));
		}
		else {
			$("#activity").html('<div style="padding:10px 0 40px 0"><h2>No Result!</h2></div>');
		}
	},

	error: function(result) {
		console.log(result.responseText);
	}
});
