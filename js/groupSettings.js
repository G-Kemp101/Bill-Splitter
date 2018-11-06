$(document).ready(function() {
	var allowed;
	var post;

	$(".dropbtn").click(function(){
		$("#myDropdown").slideToggle("slow");
	});

	$('#submit').click(function(){
		group = {"newGroup" : $('#newGroupId').val()}

		var post = $.post("leaveGroup.php", group, function(data) {

			// This is the raw data
			console.log(data);
			allowed = data;
			console.log(allowed);
		});

		$.when(post).done(function() {

			html="<br><p>Sorry that group does not exist</p>"; //if trying to change group checks if the group exists and displays a paragraph tag.
			console.log("beforeif"+allowed);
			if(allowed == 0) {
				$('.groupSettings').append(html);
			}
		});
	});
});
