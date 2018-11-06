$(document).ready(function() {


	$(".dropbtn").click(function(){
		$("#myDropdown").slideToggle("slow");
	});


	$(".link").click(function() {
		var item = $(this).attr('id');
		$("#"+item).effect("shake", { direction: "up", times: 3, distance: 2});
	});
});
