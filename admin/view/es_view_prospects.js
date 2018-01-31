var prospects = (function(){		
	return {
		
		Hide: function(){
			$("#ProspectsView").hide(); 			
			$("#ProspectsEdit").hide(); 			
			$("#ProspectsDelete").hide();
		},
		
		Refresh: function(page){
			controller.call(
				"listView",
				"prospects", 
				page,
				prospects.View,
				function(data){console.log(data)}
			); 
		},
		
		Paginate: function(totalRecords, maxPerPage, currentPage){
			$("#ProspectsView-Pagination li").remove();
			var str = "";
			var pages = Math.ceil(totalRecords / maxPerPage);
			for (i=1; i<=pages; i++){
				str = "<li class=\"page-item" + ((i == currentPage)? " active" : "") + "\"><a id=\"lnkPage" + (i) + "\" class=\"page-link\" href=\"#\">" + (i) + "</a></li>"; 
				$("#ProspectsView-Pagination ul").append(str);

				// Binds ON_CLICK event handler dynamically
				$("#lnkPage"+i).on("click", function(e){
					controller.call(
						"listView",
						"prospects", 
						$(e.target).text(),
						prospects.View,
						function(data){console.log(data)}
					); 
					e.preventDefault();
				});
			}
			(pages > 1) ? $("#ProspectsView-Pagination").show() : $("#ProspectsView-Pagination").hide();
		},
		
		// Change cursor to waiting icon 
		Spinner: function(state){
			if (state){
				$("#icoProspects").addClass("fa-spin");
				$("body").addClass("busy-cursor");
			}
			else{
				$("#icoProspects").removeClass("fa-spin");
				$("body").removeClass("busy-cursor");
			}
		},
		
		// Controls elements visibility AFTER "prospectos" selection on the sidebar
		Select: function(what){
			switch(what){
				
				case "view":				
					$("#ProspectsEdit").hide();				
					// Set selected menu option as active
					$("#lnkProspects").parent().addClass("active");
					// Reset visibility properties for ProspectsView
					$("#ProspectsView-Records").hide();
					$("#ProspectsView-DataTable").hide();
					$("#ProspectsView-Message").hide();
					$("#ProspectsView-Pagination").hide();
					// Empty data table
					$("#ProspectsView-DataTable tbody tr").remove();	
					// Binds ON_DELETE_CONFIRMATION event handler
					$("#ProspectsDelete-Confirmation").on("click", function(e){
						$("#ProspectsDelete").modal("hide");
						prospects.Delete("remove", "prospects", $(this).data("id"), $(this).data("eventSource"));	
					});
					
					break;
					
				case "edit":
					$("#ProspectsView").hide();				
					$("#ProspectsEdit-DataView").show();
					$("ProspectsEdit-Commands").show();
					$("#ProspectsEdit").show();
					break;
			}
		},
		
		// Confirms record delete and refreshes the page
		Delete: function(action, module, data, eventSource){
			controller.call(
				action,
				module, 
				{ 
					"id" : data 
				},
				function(data){
					prospects.Select("view");
					prospects.Refresh($("#ProspectsView-Pagination li.active a").text());
				},
				function(data){console.log(data)}
			); 
		},
		
		// Shows prospects data view 
		View: function(data, currentPage = 1){
			prospects.Spinner(true);
			prospects.Select("view");
			if (data.RECORDS === 0){
				$("#ProspectsView-Message").html(data.MESSAGE);
				$("#ProspectsView-Message").show();
			}
			else {
				var str = "";
				var table = $("#ProspectsView-DataTable tbody");
				$.each(data.ROWS, function(idx, record){
					
					// Create HTML output for each record retrieved
					str  = "<tr><td style=\"width:10%\">" + (++idx) + "</td>";
					str += "<td style=\"width:40%\">" + record.FULLNAME + "</td>";
					str += "<td style=\"width:40%\">" + record.EMAIL + "</td>";
					str += "<td class=\"text-center\" style=\"width:10%\">";
					str += "<a href=\"#\" class=\"btn btn-info btn-sm\" id=\"lnkEdit" + (idx) + "\" data-id=\"" + (record.ID) + "\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i> Edit</a>&nbsp;"
					str += "<a href=\"#\" class=\"btn btn-danger btn-sm\" id=\"lnkRemove" + (idx) + "\" data-id=\"" + (record.ID) + "\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>";
					str += "</td></tr>";
					table.append(str);	

					// Binds ON_EDIT event handler dynamically
					$("#lnkEdit"+idx).on("click", function(e){
						controller.call(
							"view",
							"prospects", 
							{ 
								"id" : $(this).data("id") 
							},
							function(data){
								prospects.Spinner(true);
								prospects.Select("edit");
								$("#ProspectsEdit #fldFullName").val(data.ROWS[0].FULLNAME);
								$("#ProspectsEdit #fldEmail").val(data.ROWS[0].EMAIL);
								prospects.Spinner(false);
							},
							function(data){console.log(data)}
						); 
						e.preventDefault();
					});						

					// Binds ON_REMOVE event handler dynamically
					$("#lnkRemove"+idx).on("click", function(e){
						$("#ProspectsDelete-Confirmation").data("id", $(this).data("id"));
						$("#ProspectsDelete-Confirmation").data("eventSource", idx);
						$("#ProspectsDelete").modal("show");
						e.preventDefault();
					});
				});
				
				prospects.Paginate(data.RECORDS, 10, data.CURRPAGE);
				$("#ProspectsView-Records").html(data.RECORDS);
				$("#ProspectsView-Records").show();
				$("#ProspectsView-DataTable").show();
			}
			prospects.Spinner(false);
			$("#ProspectsView").show();				
		}
	}
})();