var controller = (function(){
	return {
		call: function(action, module, params, e_OnSuccess, e_OnError){
			// set data package to send
			var pack = {
				"action" : action,
				"module" : module,
				"params" : params
			};
			var url = "es_controller.php";
			$.ajax({
				context	: this,
				type	: "POST", 
				url		: url, 
				data	: pack, 
				dataType: "json", 
				encode	: true,
			})
			.done(function(data){
				e_OnSuccess(data);
			})
			.fail(function(data){	
				e_OnError(data);
			});
		}
	}
})();