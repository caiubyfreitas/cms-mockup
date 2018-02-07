var admin = (function(){
	
	return {
		
		init: function(){
			
		},
		
		/*
		* Function: SessionExpired
		* Redirect to login page if user session data is not available
		* @PARAMS none
		* @RETURN none
		*/
		SessionExpired: function(){
			
			// set call back page
			var url = "es_disconnect.php";
			
			// redirect to the page
			$(location).attr('href',url);			
		},
		
		/*
		* Function: Validated
		* Apply validation rules to the field before updating record data
		* @PARAMS none
		* @RETURN false is any validation rule was broken
		*/
		Validated: function(){
			
			// read field values
			var fullname = $("#G01S01-fldFullName").val();
			var name = $("#G01S01-fldName").val();
			var email = $("#G01S01-fldEmail").val();
			var password = $("#G01S01-fldPassword").val();
			
			// clear previous alerts
			$("#G01S01-Alerts").hide();
			$("#G01S01-Alerts li").remove();
			
			// check required fields
			if (fullname.length == 0){
				$("#G01S01-fldFullName").focus();
				$("#G01S01-Alerts").append("<li>Informe seu nome completo. Evite abreviações se possível.</li>"); 
			}			
			if (name.length == 0){
				$("#G01S01-fldName").focus();
				$("#G01S01-Alerts").append("<li>Informe um nome curto e significativo para acessar o sistema.</li>"); 
			}
			if (email.length == 0){
				$("#G01S01-fldEmail").focus();
				$("#G01S01-Alerts").append("<li>Indique o e-mail para receber notificações do sistema.</li>"); 
			}
			if (password.length == 0){
				$("#G01S01-fldPassword").focus();
				$("#G01S01-Alerts").append("<li>Crie uma senha que contenha números e letras para aumentar sua segurança.</li>"); 
			}
			
			// check if any alert was appended to the page to trigger proper action
			if ($("#G01S01-Alerts li").length > 0){
				$("#G01S01-Alerts").show();
				return false;
			}
			else{
				return true;
			}
		},
		
		/*
		* Function: ViewRecord
		* Show record information on the page
		* @PARAMS result set
		* @RETURN none
		*/
		ViewRecord: function(data){
			$("#G01S01-fldFullName").val(data.ROWS[0].FULLNAME);
			$("#G01S01-fldName").val(data.ROWS[0].NAME);
			$("#G01S01-fldEmail").val(data.ROWS[0].EMAIL);
			$("#G01S01").show();
		}
		
	}
})();

$(document).ready(function(){

	/*
	* Event
	* Show administrator profile page considering who is actually logged into the system
	*/
	$("#G01S01-lnk").on("click", function(e){
		$("body").addClass("busy-cursor");
		controller.call(
			"view",
			"G01",
			{
				"id" : $(this).data("id")
			},
			admin.ViewRecord,
			function(data){
				console.log(data);
			}
		);
		$("body").removeClass("busy-cursor");
		e.preventDefault();
	});

	/*
	* Event
	* Closes administrator profile page
	*/
	$("#G01S01-cmdClose").on("click", function(e){
		$("#G01S01").hide();
		e.preventDefault();		
	});

	/*
	* Event
	* Save administrator profile page changes
	*/
	$("#G01S01-cmdSave").on("click", function(e){
		
		// check if logged user id is not expired
		var id = $(this).data("id");
		if ( !(id) || (id.length == 0) ){
			admin.SessionExpired();
		}
		else{
			
			// tests if changes are valid
			if (admin.Validated()){
				
				// call to action
				$("body").addClass("busy-cursor");
				controller.call(
					"update",
					"G01",
					{
						"id" 		: $(this).data("id"),
						"fullname" 	: $("#G01S01-fldFullName").val(),
						"name" 		: $("#G01S01-fldName").val(),
						"email"		: $("#G01S01-fldEmail").val(),
						"password" 	: $("#G01S01-fldPassword").val()
					},
					function(data){
						$("#MESSAGEBOX-text").html("Alterações realizadas!");
						$("#MESSAGEBOX").modal("show");
					},
					function(data){
						console.log(data);
					}
				);		
				$("body").removeClass("busy-cursor");
			}
		}
		e.preventDefault();		
	});
	
});