$(document).ready(function(){
	
	// Get current date and time
	$("#fldToday").html(new Date()); 
	
	prospects.Hide();
	
	/*
	* Menu event handlers
	*/
	$("#lnkProspects").on("click", function(e){	
		// Request data from DB
		controller.call(
			"listView", 
			"prospects", 
			"1", 
			prospects.View, 
			function(data){ 
				console.log(data); 
			}
		);
		// remove waiting icon from cursor
		$("body").removeClass("busy-cursor");
		// Stop event propagation
		e.preventDefault();
	});
	
});