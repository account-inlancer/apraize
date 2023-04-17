var is_first_time_load = true;
jQuery(document).ready(function(){
	//-----DATATABLE-START-----


//withdraw DataTable Starts From Here****

	withdraw_tbl = jQuery('#withdraw_tbl').dataTable({
        							"processing": false,
        							"serverSide": true,
									"iDisplayLength": 10,
						         "ajaxSource": APPLICATION_URL+"dashboard/withdraws/dt_list",
						         "aoColumns": [
						            { "bSortable": false },
						            { "bSortable": true },
									{ "bSortable": true },
									{ "bSortable": true },
						            { "bSortable": true },
						            { "bSortable": true }, 
						            { "bSortable": false },						            
						       	],
						       	"dom": 'Bfrtip',
						        "buttons": [
						            'print'
						        ],
						       	"withdraw":[['0','desc']],
						      	"sDom": "<'row'<'col-sm-9 col-xs-9'l><'col-sm-3 col-xs-3'f>r>t<'row'<'col-sm-5 hidden-xs paging-class'i><'col-sm-7 col-xs-12 clearfix'p>>",
						       	
						       	'fnDrawCallback' : function(){
						       		jQuery('th:first-child').removeClass('sorting_desc');
						       		jQuery('th:first-child').removeClass('sorting');
						       		if(is_first_time_load){
						       			// jQuery('#withdraw_tbl_filter').prepend('<select onchange="getval(this);" class="form-control"><option value="">All</option><option value="1">Active</option><option value="0">Inactive</option></select> &nbsp;');
						       			// jQuery('#withdraw_tbl_length').prepend('<button class="btn btn-default change_Status pull-left disable_multiple" style="margin-right:20px;">Disable</button> &nbsp;');
						       			// jQuery('#withdraw_tbl_length').prepend('<button class="btn btn-primary change_Status pull-left enable_multiple" style="margin-right:10px;">Enable</button> &nbsp;');
						       			jQuery('#withdraw_tbl_length').prepend('<button class="btn btn-danger change_Status pull-left delete_multiple" id="delete_multiple" style="margin-right:10px;">Delete</button> &nbsp;');
						       			jQuery('#withdraw_tbl_length').prepend('<button class="btn btn-info pull-left add_withdraw change_Status" style="margin-right:10px;">Add Withdraw</button> &nbsp;');

						       			
						       			
						       			jQuery('#withdraw_tbl_length select').addClass("form-control");
						       			jQuery('#withdraw_tbl_filter input').addClass("form-control");
						       			// jQuery('#withdraw_tbl_filter input').addClass("form-control");
						       			is_first_time_load = false;
						       		}	
						       	},
    	});

	jQuery(document).on("click",".add_withdraw",function(){
		jQuery("#withdraw_form").attr("action", APPLICATION_URL+"add-withdraw");
	});



	  	jQuery(document).on("click",".delete_multiple",function(e){
		e.preventDefault();
			
		if (!jQuery(".case").is(':checked') )
		{
			   Swal.fire({
	                type: 'warning',
	                title: 'Oops',
	                text: 'Please select at least one check box.',
	                showConfirmButton: false,
	                timer: 3000
              	})		
		}
		else
		{
			swal.fire({
	          title: "Confirm",
        	  text: "Are you sure you want to delete these data!",
	          type: "warning",
	          showCancelButton: true,
	          confirmButtonColor: "#1FAB45",
	          confirmButtonText: "Yes, Delete it.",
	          cancelButtonText: "Cancel",
	          buttonsStyling: true
	      }).then((result) => {
	        if (result.value == true) 
	        {
				jQuery("#withdraw_form").attr("action", APPLICATION_URL+"dashboard/withdraws/delete_multi_withdraw");
			
				var url  = jQuery("#withdraw_form").attr("action");
				var data = jQuery("#withdraw_form").serialize();
				jQuery.ajax({
					url : url ,
					method : 'post',
					data : data,
					success : function(data){
						//console.log(data);
							jQuery("#checkall").prop("checked","");
							
							var json_data = jQuery.parseJSON(data);
						
							if( json_data.status == 200 )
							{
								withdraw_tbl._fnAjaxUpdate();
								 swal.fire({
				                  title: "Success!",
				                  text: "Data deleted successfully!",
				                  type: "success",
				                  timer: 1000})
							}
							else
							{
								swal.fire(
			                    "Internal Error",
			                    "Oops,Error Occurred.",
			                    "error"
			                    )
							}
					}
				});
			}
			else
			{
				swal.fire({
	            title: "Cancelled",
	            text: "Your data is safe Now! ",
	            type:"error",
	            timer:800
	            })
			}
		  });
		}
	});

  	jQuery('#checkall').click(function(event) {  //on click
        if(this.checked) { // check select status
            jQuery('.case').each(function() { //loop through each checkbox
				//alert("check");
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
           jQuery('.case').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
				//alert("uncheck");
            });        
        }
    });	
  
});


 
 


 
