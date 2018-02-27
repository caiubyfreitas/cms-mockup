/*
* ****************************************************************************************************************************
*
* ADMINISTRATOR VIEW IMPLEMENTATION
* jan-2018
* By Caiuby Freitas
*
* Implements a module that holds all the functions related to presentation features.
* This is the VIEW counterpart of the MVC-based abstraction implemented herein.
*
* ****************************************************************************************************************************
*/

var admin = (function(){

	function ValidChanges(){
		
		// read field values
		var fullname = $("#Admin-fldFullName").val();
		var name = $("#Admin-fldName").val();
		var email = $("#Admin-fldEmail").val();
		var password = $("#Admin-fldPassword").val();
		
		// clear previous alerts
		$("#Admin-Alerts").hide();
		$("#Admin-Alerts li").remove();
		
		// check required fields
		if (fullname.length == 0){
			$("#Admin-fldFullName").focus();
			$("#Admin-Alerts").append("<li>Informe seu nome completo. Evite abreviações se possível.</li>"); 
		}			
		if (name.length == 0){
			$("#Admin-fldName").focus();
			$("#Admin-Alerts").append("<li>Informe um nome curto e significativo para acessar o sistema.</li>"); 
		}
		if (email.length == 0){
			$("#Admin-fldEmail").focus();
			$("#Admin-Alerts").append("<li>Indique o e-mail para receber notificações do sistema.</li>"); 
		}
		if (password.length == 0){
			$("#Admin-fldPassword").focus();
			$("#Admin-Alerts").append("<li>Crie uma senha que contenha números e letras para aumentar sua segurança.</li>"); 
		}
		
		// check if any alert was appended to the page to trigger proper action
		if ($("#Admin-Alerts li").length > 0){
			$("#Admin-Alerts").show();
			return false;
		}
		else{
			return true;
		}
	}

	// All the functions bellow are called externally	
	return {

	
		/*
		* ------------------------------------------------------------------------------------------------------------------
		* Initialization routine
		* ------------------------------------------------------------------------------------------------------------------
		*/
	
		
		Init: function(){
			
		},
		
		
		/*
		* ------------------------------------------------------------------------------------------------------------------
		* Data manipulation functions
		* ------------------------------------------------------------------------------------------------------------------
		*/


		GetRecord: function(id){
			controller.call(
				"findById",
				"Admin", 
				id,
				this.ShowRecordView,
				function(data){
					console.log(data)
				}
			);
		},
		
		UpdateRecord: function(changes){
			if (ValidChanges()){	
				global.ShowWaitCursor(true);
				controller.call(
					"update",
					"Admin",
					changes,				
					function(data){
						$("#MESSAGEBOX-text").html("Alterações realizadas!");
						$("#MESSAGEBOX").modal("show");
					},
					function(data){
						console.log(data);
					}
				);
				global.ShowWaitCursor(false);
			}
		},
	
	
		/*
		* ------------------------------------------------------------------------------------------------------------------
		* Presentation functions
		* ------------------------------------------------------------------------------------------------------------------
		*/
			
			
		// Show record view page
		ShowRecordView: function(data){
			global.ShowWaitCursor(true);
			$("#Admin-Alerts").hide();
			$("#Admin-Alerts li").remove();
			$("#Admin-fldFullName").val(data.ROWS[0].FULLNAME);
			$("#Admin-fldName").val(data.ROWS[0].NAME);
			$("#Admin-fldEmail").val(data.ROWS[0].EMAIL);
			$("#Admin").show();
			global.ShowWaitCursor(false);
		}
		
	}
})();


/*
* ------------------------------------------------------------------------------------------------------------------
* Event handlers
* ------------------------------------------------------------------------------------------------------------------
*/

$(document).ready(function(){

	$("#Admin-lnk").on("click", function(e){
		global.UIReset();
		admin.GetRecord({"id" : $(this).data("id")});
		$("#Section-Admin").show();
		e.preventDefault();
	});

	$("#Admin-cmdClose").on("click", function(e){
		$("#Admin").hide();
		e.preventDefault();		
	});

	$("#Admin-cmdSave").on("click", function(e){
		// check if logged user id is not expired
		var id = $(this).data("id");
		if ( !(id) || (id.length == 0) ){
			global.Authenticate();
		}
		else{
			admin.UpdateRecord(
				{
					"id" 		: $(this).data("id"),
					"fullname" 	: $("#Admin-fldFullName").val(),
					"name" 		: $("#Admin-fldName").val(),
					"email"		: $("#Admin-fldEmail").val(),
					"password" 	: $("#Admin-fldPassword").val()
				}
			);		
		}
		e.preventDefault();		
	});
	
});