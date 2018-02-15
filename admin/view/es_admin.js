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
			$("#G01S01-fldFullName").val(data.ROWS[0].FULLNAME);
			$("#G01S01-fldName").val(data.ROWS[0].NAME);
			$("#G01S01-fldEmail").val(data.ROWS[0].EMAIL);
			$("#G01S01").show();
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

	$("#G01S01-lnk").on("click", function(e){
		global.UIReset();
		admin.GetRecord({"id" : $(this).data("id")});
		$("#Section-Admin").show();
		e.preventDefault();
	});

	$("#G01S01-cmdClose").on("click", function(e){
		$("#G01S01").hide();
		e.preventDefault();		
	});

	$("#G01S01-cmdSave").on("click", function(e){
		// check if logged user id is not expired
		var id = $(this).data("id");
		if ( !(id) || (id.length == 0) ){
			global.Authenticate();
		}
		else{
			admin.UpdateRecord(
				{
					"id" 		: $(this).data("id"),
					"fullname" 	: $("#G01S01-fldFullName").val(),
					"name" 		: $("#G01S01-fldName").val(),
					"email"		: $("#G01S01-fldEmail").val(),
					"password" 	: $("#G01S01-fldPassword").val()
				}
			);		
		}
		e.preventDefault();		
	});
	
});