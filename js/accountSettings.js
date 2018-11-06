$(document).ready(function() {
	$(".dropbtn").click(function(){
		$("#myDropdown").slideToggle("slow");
	});

	$(".personBox").click(function() { //animation for clicing box
		var item = $(this).attr('id');
		$("#"+item).effect("shake", { direction: "up", times: 3, distance: 4});
	});
});

function send() {
	document.groupinputform.submit()
}

function checkPasswordMatch() { //checking if both passwords match
	var password = $("#pass").val();
	var confirmPassword = $("#repPass").val();

	if (password != confirmPassword && confirmPassword != "")
	$("#repPass").css({"background-color": "rgb(221, 130, 130)"});
	else {
		$("#repPass").css({"background-color": ""});
		return true;
	}
	return false;
}

function checkPasswordLength() { //checking if length is greater than 8
	var password = $("#pass").val();

	if (password.length != 0 && password.length < 8) {
		$("#pass").css({"background-color": "rgb(221, 130, 130)"});
		return false;
	} else {
		$("#pass").css({"background-color": ""});
	}
	return true;
}

function checkPassword() {
	if (!checkPasswordMatch()) {
		alert("Passwords do not match");
		return false;
	}
	else if (!checkPasswordLength()) {
		alert ("New password too short");
		return false;
	}
	return false;

}

$(document).ready(function() {
	$("#pass").keyup(checkPasswordLength);
	$("#pass, #repPass").keyup(checkPasswordMatch);



});
