$(document).ready(function() {

	$("#selector").change(function(){
		$(".joinGroup").slideToggle("slow");
	});


	$("#pass, #repPass").keyup(function () {
		var password = $("#pass").val();
		var confirmPassword = $("#repPass").val();

		if (password.length < 8) {
			$("#pass").css({"background-color": "rgb(221, 130, 130)"});
		} else {
			$("#pass").css({"background-color": ""});
		}

		if (password != confirmPassword && confirmPassword != "")
		$("#repPass").css({"background-color": "rgb(221, 130, 130)"});
		else {
			$("#repPass").css({"background-color": ""});
			return true;
		}
		return false;
	});

	$('#register').submit(function() { //submits via ajax and creates a group id if none supplied
		var name = $("#name").val();
		var email = $("#email").val();
		var groupId = $("#groupid").val();
		var group = $("#selector").val();
		var password = $("#pass").val();

		if (name == "" && email == ""){
			$("#pname").show();
			$("#pemail").show();
			return false;
		} else if (name == ""){
			$("#pname").show();
			return false;
		} else if (email == ""){
			$("#pemail").show();
			return false;
		}

		if (group === "makeGroup") {
			groupId = Math.floor((Math.random() * 1000000) + 1);
			console.log(groupId);
		}

		data = {"name": name, "email": email, "groupid": groupId, "group": group, "password": password}

		var emailExist;
		var groupExist;03
		var header;

		$.post("process_register.php", data, function(data){

			var received = JSON.parse(data);
		   	console.log(received);

			emailExist = received.emailExist;
			groupExist = received.groupExist;
			header = received.header;

			console.log(emailExist);
			console.log(groupExist);

			if(emailExist == 1){
				$("#pemail").html("Sorry email already taken");
				$("#pemail").show();
			}

			if(groupExist == 0){
				$("#pgroup").html("Sorry group does not exist");
				$("#pgroup").show();
			}

			if (groupExist == 1 && emailExist == 0){
				console.log("navigate");
				location.pathname = header;
			}

		});
		return false;


	});
});
