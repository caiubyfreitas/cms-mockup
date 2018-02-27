/*
* ****************************************************************************************************************************
*
* PROSPECTS VIEW IMPLEMENTATION
* jan-2018
* By Caiuby Freitas
*
* Defines what happens when user clicks on prospects menu options and implements presentation features.
* This is the VIEW counterpart of the MVC-based abstraction implemented herein.
*
* ****************************************************************************************************************************
*/

var prospect = (function(){		
	
	// All the functions bellow are called externally
	return {

	
		/*
		* ------------------------------------------------------------------------------------------------------------------
		* Initialization routine
		* ------------------------------------------------------------------------------------------------------------------
		*/
	
	
		Init: function(){
			$("#Prospect-View").hide(); 			
			$("#Prospect-Edit").hide(); 			
			$("#Prospect-Delete").hide();
		},
		
		
		/*
		* ------------------------------------------------------------------------------------------------------------------
		* Data manipulation functions
		* ------------------------------------------------------------------------------------------------------------------
		*/
		

		// Retrieve all records related to a specific page. If none provided, first page is assumed by default.
		GetAll: function(page = 1){
			controller.call(
				"getAllRecords", 
				"Prospect", 
				page, 
				this.ShowGridView, 
				function(data){ 
					console.log(data); 
				}
			);
		},
		
		// Retrieve all fields related to the record id number.
		GetRecord: function(id){
			controller.call(
				"findById",
				"Prospect", 
				id,
				this.ShowRecordView,
				function(data){
					console.log(data)
				}
			); 
		},
		
		// Deletion confirmation dialog passing on the id of the selected record.
		Delete: function(action, module, data, eventSource){
			controller.call(
				"remove",
				"Prospect", 
				{ 
					"id" : data 
				},
				function(data){
					this.ShowGridView($("#Prospect-View-Pagination li.active a").text());
				},
				function(data){
					console.log(data)
				}
			); 
		},
	
	
		/*
		* ------------------------------------------------------------------------------------------------------------------
		* Presentation functions
		* ------------------------------------------------------------------------------------------------------------------
		*/
	
	
		// Shows grid view page
		ShowGridView: function(data, currentPage = 1){
			
			global.ShowWaitCursor(true);

			// Set user interface
			$("#Prospect-Edit").hide();				
			$("#lnkProspects").parent().addClass("active");
			$("#Prospect-View-Records").hide();
			$("#Prospect-View-DataTable").hide();
			$("#Prospect-View-Message").hide();
			$("#Prospect-View-Pagination").hide();
			$("#Prospect-View-DataTable tbody tr").remove();	

			// Binds ON DELETE event to the handler
			$("#Prospect-Delete-Confirmation").on("click", function(e){
				$("#Prospect-Delete").modal("hide");
				this.Delete($(this).data("id"), $(this).data("eventSource"));	
			});					

			// If empty
			if (data.RECORDS === 0){
				$("#Prospect-View-Message").html(data.MESSAGE);
				$("#Prospect-View-Message").show();
			}
			else {
				var str = "";
				var table = $("#Prospect-View-DataTable tbody");
				$.each(data.ROWS, function(idx, record){
					
					// Create HTML output for each record retrieved
					str  = "<tr><td style=\"width:10%\">" + (++idx) + "</td>";
					str += "<td style=\"width:40%\">" + record.NAME + "</td>";
					str += "<td style=\"width:40%\">" + record.EMAIL + "</td>";
					str += "<td class=\"text-center\" style=\"width:10%\">";
					str += "<a href=\"#\" class=\"btn btn-info btn-sm\" id=\"lnkEdit" + (idx) + "\" data-id=\"" + (record.ID) + "\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i> Ver</a>&nbsp;"
					str += "<a href=\"#\" class=\"btn btn-danger btn-sm\" id=\"lnkRemove" + (idx) + "\" data-id=\"" + (record.ID) + "\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>";
					str += "</td></tr>";
					table.append(str);	

					// Binds ON_EDIT event handler dynamically
					$("#lnkEdit"+idx).on("click", function(e){
						prospect.GetRecord({"id" : $(this).data("id")});
						e.preventDefault();
					});						

					// Binds ON_REMOVE event handler dynamically
					$("#lnkRemove"+idx).on("click", function(e){
						$("#Prospect-Delete-Confirmation").data("id", $(this).data("id"));
						$("#Prospect-Delete-Confirmation").data("eventSource", idx);
						$("#Prospect-Delete").modal("show");
						e.preventDefault();
					});
				});
				
				// Creates pagination if needed
				if (data.RECORDS > 0){

					var maxPerPage = 10;
					var totalRecords = data.RECORDS;
					var currentPage = data.CURRPAGE;

					$("#Prospect-View-Pagination li").remove();
					var str = "";
					var pages = Math.ceil(totalRecords / maxPerPage);
					for (i=1; i<=pages; i++){
						str = "<li class=\"page-item" + ((i == currentPage)? " active" : "") + "\"><a id=\"lnkPage" + (i) + "\" class=\"page-link\" href=\"#\">" + (i) + "</a></li>"; 
						$("#Prospect-View-Pagination ul").append(str);

						// Binds ON CLICK event to the handler dynamically, so that the page number can be passed on to the controller
						$("#lnkPage"+i).on("click", function(e){
							prospect.GetAll($(e.target).text());
							e.preventDefault();
						});
					}
					(pages > 1) ? $("#Prospect-View-Pagination").show() : $("#Prospect-View-Pagination").hide();


					$("#Prospect-View-Records").html(data.RECORDS);
					$("#Prospect-View-Records").show();
				}
				$("#Prospect-View-DataTable").show();
			}
			$("#Prospect-View").show();				
			global.ShowWaitCursor(false);
		},
		
		// Shows record view page
		ShowRecordView: function(data){
			global.ShowWaitCursor(true);
			$("#Prospect-Edit #fldFullName").val(data.ROWS[0].NAME);
			$("#Prospect-Edit #fldEmail").val(data.ROWS[0].EMAIL);
			$("#Prospect-View").hide();				
			$("#Prospect-Edit-DataView").show();
			$("Prospect-Edit-Commands").show();
			$("#Prospect-Edit").show();
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

	$("#lnkProspects").on("click", function(e){	
		global.UIReset();
		prospect.GetAll();
		$("#Section-Prospect").show();
		e.preventDefault();
	});
	
});