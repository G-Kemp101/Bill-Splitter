$(document).ready(function() {
	$("#submit").hide();

	$(".dropbtn").click(function(){
		$("#myDropdown").slideToggle("slow");
	});

	$("#title, #newnote").on('input', function() { //dont allow submit if no title, no text or text > 140 characters
		var title = $('#title').val();
		var text = $('#newnote').val();

		if (title.length == 0) {
			$("#submit").hide();
			$("#count").css("color","#ad2929")
		}else if (text.length > 140 || text.length == 0) {
			$("#submit").hide();
			$("#count").css("color","#ad2929");
		} else {
			$("#count").css("color","black");
			$("#submit").show();
		}
		$("#count").text(text.length + "/140");
	});

	$("body").on('click','#submit',function() { //posting the note via ajax so can appear instantly

		var title = $('#title').val();
		var text = $('#newnote').val();

		var t = new Date();
		var d = t.getDate();
		var m = t.getMonth() + 1;
		var y = t.getFullYear();
		var date = d+"/"+m+"/"+y;
		var send = {"text": text, "title": title, "date": date}
		// Send the data!
		$.post("createNote.php", send, function(data) {

			// This is the raw data
			console.log(data);
			var received = JSON.parse(data);
			console.log(received);
			html = "<div class='note'><h1>"+received.title+"<h2><p>"+received.note+"</p><h3>Created by: "+received.name+" on "+received.date+" </h3></div>";
			$('#createNew').after(html);

			$('#newnote').val("");
			$('#title').val("");
			$('#count').html("");
		});


		return false;
	});
});
