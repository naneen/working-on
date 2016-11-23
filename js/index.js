$.ajax({
	type: 'POST',
	url: 'php/get_person.php',
	dataType: 'json',

	success: function(result){
		for(var i=0; i<result.persons.length; i++) {
			addPersonHtml(result.persons[i]);
		}
	},
	error: function(result) {
		console.log(result);
	}
});

function addPersonHtml(person) {
	var id = person.id;
	var src = 'images/profile' + id + '.jpg';
	var tmp = '<div class="col-xs-6 col-md-4 col-lg-3"><img onClick="selectPerson(' + id + ')" class="img-circle img-login"src="' + src + '"></div>';
			$("#person-list").append(tmp);
}

var selectedID = 0;

function selectPerson(id) {
	selectedID = id;
	$("#pin").val("");
	$("#fail").hide();
	$(".filter").fadeIn();
	$("#pin").focus();
}

$(document).mouseup(function (e)
{
	var container = $(".popup");

	if (!container.is(e.target) // if the target of the click isn't the container...
		&& container.has(e.target).length === 0) // ... nor a descendant of the container
	{
		$(".filter").fadeOut();
	}
});

function login() {

	id = selectedID;
	pin = $("#pin").val();
	$("#pin").val("");

	$.ajax({
		type: 'POST',
		data: { id: id,
				pin: pin
			},
		url: 'php/login.php',
		dataType: 'json',

		success: function(result){
			if(result.status == 1) {
				window.location.href = "today.php";
			}
			else {
				$("#fail").show();
			}
		},

		error: function() {
			console.log("error");
		}
	});
}

$("#pin").keyup(function(event){
	if(event.keyCode == 13){
		login();
	}
});
