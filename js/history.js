var cDate = new Date();
$("#input-year").val(cDate.getFullYear());
$("#input-month").val(cDate.getMonth()+1);
$("#input-day").val(cDate.getDate());
update();

function update () {
	var year = $("#input-year").val();
	var month = $("#input-month").val();
	var day = $("#input-day").val();
	var tmpDate = new Date(year + "/" + month + "/" + day);
	var selectedDate = tmpDate.getFullYear() + "/" + (tmpDate.getMonth()+1) + "/" + tmpDate.getDate();
	tmpDate.setDate(tmpDate.getDate()+1);
	var endDate = tmpDate.getFullYear() + "/" + (tmpDate.getMonth()+1) + "/" + tmpDate.getDate();
	$.ajax({
		type: 'POST',
		url: 'php/get_activity_by_date.php',
		data: {
			start_time: selectedDate,
			end_time: endDate
		},
		dataType: 'json',

		success: function(result){
			if(result.activities.length > 0) {
				$("#activity").html(getActivityList(result.activities, false));
			}
			else {
				$("#activity").html('<div style="padding:10px 0 40px 0"><h2>No Result!</h2></div>');
			}
		},

		error: function(result) {
			console.log(result.responseText);
		}
	});
}