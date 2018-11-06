$(document).ready(function() {

	$("body").on('click','.checkmark',function() {
		// Get the id from the grandparent (We store it on the table row)
		var bill_id = $(this).parent().attr('id');

		// Now post the data to the server using ajax

		function getParameterByName(name, url) {
			if (!url) url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
			if (!results) return null;
			if (!results[2]) return '';
			return decodeURIComponent(results[2].replace(/\+/g, " "));
		}


		var user_id = getParameterByName('id'); //getting the userid

		$.post("pay.php",{"billid":bill_id, "userid":user_id},function(data) { //sends the data to pay.php which clears the bill then removes that element.
			var received = JSON.parse(data);

			console.log("Updated " +  bill_id + " amount to 0");
			console.log("Recieved Data: " + received.id);
			$("#"+received.id).css("background-color", "rgb(115, 239, 115)");
			$("#user"+user_id).html("<h2>"+received.userB+"</h2>They owe you £"+received.debt/100);
		});
		html = "<label id="+bill_id+">Bill Cleared!</label>";
		$(this).parent().html(html);
		$("#"+bill_id).fadeOut("slow");

	});
});
