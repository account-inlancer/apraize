var is_first_time_load = true;
jQuery(document).ready(function(){ 
	order_tbl = jQuery('#order_tbl').dataTable({
        							"processing": true,
        							"serverSide": true,
									"iDisplayLength": 10,
						         	"ajaxSource": APPLICATION_URL+"dashboard/orders/dt_list",
						         	"aoColumns": [
							            { "bSortable": false },
							            { "bSortable": true },
										{ "bSortable": true },
										{ "bSortable": true },
							            // { "bSortable": true },
										{ "bSortable": true },
										{ "bSortable": true },
							            
							            { "bSortable": false },						            
						       		],
							       	"dom": 'Bfrtip',
							        "buttons": [
							            'print'
							        ],
							       	"order":[['0','desc']],
							      	"sDom": "<'row'<'col-sm-9 col-xs-9'l><'col-sm-3 col-xs-3'f>r>t<'row'<'col-sm-5 hidden-xs paging-class'i><'col-sm-7 col-xs-12 clearfix'p>>",
						       	
							       	'fnDrawCallback' : function(){
							       		jQuery('th:first-child').removeClass('sorting_desc');
							       		jQuery('th:first-child').removeClass('sorting');
							       		if(is_first_time_load){
							       			// jQuery('#order_tbl_filter').prepend('<select onchange="getval(this);" class="form-control"><option value="">All</option><option value="1">Active</option><option value="0">Inactive</option></select> &nbsp;');
							       			// jQuery('#order_tbl_length').prepend('<button class="btn btn-default change_Status pull-left disable_multiple" style="margin-right:20px;">Disable</button> &nbsp;');
							       			// jQuery('#order_tbl_length').prepend('<button class="btn btn-primary change_Status pull-left enable_multiple" style="margin-right:10px;">Enable</button> &nbsp;');
							       			jQuery('#order_tbl_length').prepend('<button class="btn btn-danger change_Status pull-left delete_multiple" id="delete_multiple" style="margin-right:10px;">Delete</button> &nbsp;');

							       			jQuery('#order_tbl_length').prepend('<button class="btn btn-info pull-left add_order change_Status" style="margin-right:10px;">Add Order</button> &nbsp;');

							       			
							       			
							       			jQuery('#order_tbl_length select').addClass("form-control");
							       			jQuery('#order_tbl_filter input').addClass("form-control");
							       			// jQuery('#order_tbl_filter input').addClass("form-control");
							       			is_first_time_load = false;
							       		}	
							       	},
    });

	jQuery(document).on("click",".add_order",function(){
		jQuery("#order_form").attr("action", APPLICATION_URL+"add-invoice");
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
				jQuery("#order_form").attr("action", APPLICATION_URL+"dashboard/orders/delete_multi_order");
			
				var url  = jQuery("#order_form").attr("action");
				var data = jQuery("#order_form").serialize();
				jQuery.ajax({
					url : url ,
					method : 'post',
					data : data,
					success : function(data){
						 
							jQuery("#checkall").prop("checked","");
							
							var json_data = jQuery.parseJSON(data);
						
							if( json_data.status == 200 )
							{
								order_tbl._fnAjaxUpdate();
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

  	jQuery('#checkall').click(function(event) { 
        if(this.checked) {  
            jQuery('.case').each(function() {  
				 
                this.checked = true;              
            });
        }else{
           jQuery('.case').each(function() {  
                this.checked = false;                        
				 
            });        
        }
    });	 
});



 
