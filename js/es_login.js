$(document).ready(function() {

	$("#fAuth").submit(function(e){
		
		$(".form-group").removeClass("has-danger"); // remove the error class
		$(".form-control-feedback").remove(); // remove the error text		
	
		if ($("#fldName").val().length === 0){
			$("#fldName-group").addClass("has-danger"); // add the error class to show red input
			$("#fldName-group").append("<div class=\"form-control-feedback\">Informe seu nome de usuário</div>"); // add the actual error message under our input
		}
		
		if ($("#fldPassword").val().length === 0) {
			$("#fldPassword-group").addClass("has-danger"); // add the error class to show red input
			$("#fldPassword-group").append("<div class=\"form-control-feedback\">A senha de acesso deve ser informada.<div>"); // add the actual error message under our input
		}
		
		if (!$("div").hasClass("has-danger")){
		
			// get the form data
			// there are many ways to get this data using jQuery (you can use the class or id also)
			var formData = {
				"fldName"     : $("#fldName").val(),
				"fldPassword" : $("#fldPassword").val()
			};		
			
			// process the form
			controller.call(
				"validate",
				"admin",
				formData,
				function(data){
					// If record is found...
					if (data.RECORDS > 0){
						window.location.replace("../admin/es_dashboard.php");
					}
					else{
						$("#fldName-group").addClass("has-danger"); // add the error class to show red input
						$("#fldPassword-group").addClass("has-danger"); // add the error class to show red input
						$("#fldPassword-group").append("<div class=\"form-control-feedback\">" + data.MESSAGE + "<div>"); // add the actual error message under our input
					}
				},
				function(data){
					console.log(data);
				}
			);
		}
		// avoid to execute the actual submit of the form.
		e.preventDefault(); 
		
	});
	
});