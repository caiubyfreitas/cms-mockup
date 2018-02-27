/*
*
* DASHBOARD JAVASCRIPT MODULE
* jan-2018
* by Caiuby Freitas
* 
* Dashboard entry point
*
*/

var global = (function (){

	return{
		
		UIReset: function(){
			$("#Section-Admin").hide();
			$("#Section-Prospect").hide();
		},
		
		// Redirect to login page if user session data is not available anymore
		Authenticate: function(){			
			// set call back page
			var url = "es_disconnect.php";
			// redirect to the page
			$(location).attr('href',url);			
		},		

		// Change cursor to waiting icon 
		ShowWaitCursor: function(state){
			if (state){
				$("#icoProspects").addClass("fa-spin");
				$("body").addClass("busy-cursor");
			}
			else{
				$("#icoProspects").removeClass("fa-spin");
				$("body").removeClass("busy-cursor");
			}
		}		
		
	}
		
})();


$(document).ready(function(){
	
	// Get current date and time
	$("#fldToday").html(new Date()); 
	
	// Initializes controllers
	admin.Init();	
	prospect.Init();
	
});