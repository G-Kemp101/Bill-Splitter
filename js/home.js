$(document).ready(function() {


	$(".dropbtn").click(function(){
		$("#myDropdown").slideToggle("slow");
	});


	$(".link").click(function() {
		var item = $(this).attr('id');
		$("#"+item).effect("shake", { direction: "up", times: 3, distance: 2});
	});

	$.post("alert.php", function(data){
		console.log(data)
		if(data == 0) {
			$('#alert').css("display", "block");
		}
	});

	$('#clearAlert').click(function() { //displays the alert if an alert needs to be shown
		var click = {'click': 1};
		$.post("alert.php", click, function(data){
			$('#alert').css("display", "none");
		});
	});

	$("#amount").on('input', function() { //if the amount of the bill is negative to not alow submit
		var value = $(this).val();
		if (value < 0) {
			$("#amount").css({"background-color": "rgb(221, 130, 130)"});
			$('#submitBill').hide();
		} else {
			$("#amount").css({"background-color": ""});
			$('#submitBill').show();
		}
	});

});

function send() {
	document.groupinputform.submit()
}
