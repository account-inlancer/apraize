



var is_first_time_load = true;
jQuery(document).ready(function(){
	//-----DATATABLE-START-----


//User DataTable Starts From Here****

	user_tbl = jQuery('#user_tbl').dataTable({
        							"processing": true,
        							"serverSide": true,
									"iDisplayLength": 10,
						         "ajaxSource": APPLICATION_URL+"dashboard/users/dt_list",
						         "aoColumns": [
						            { "bSortable": false },
						            { "bSortable": true },
									{ "bSortable": true },
									{ "bSortable": true },
									{ "bSortable": true },
									{ "bSortable": true },
									{ "bSortable": true },
						            { "bSortable": false },						            
						       	],
						       	"order":[['0','desc']],
						      	"sDom": "<'row'<'col-sm-9 col-xs-9'l><'col-sm-3 col-xs-3'f>r>t<'row'<'col-sm-5 hidden-xs paging-class'i><'col-sm-7 col-xs-12 clearfix'p>>",
						       	
						       	'fnDrawCallback' : function(){
						       		jQuery('th:first-child').removeClass('sorting_desc');
						       		jQuery('th:first-child').removeClass('sorting');
						       		if(is_first_time_load){
						       			jQuery('#user_tbl_length').prepend('<button class="btn btn-default change_Status pull-left disable_multiple" style="margin-right:20px;">Disable</button> &nbsp;');
						       			jQuery('#user_tbl_length').prepend('<button class="btn btn-primary change_Status pull-left enable_multiple" style="margin-right:10px;">Enable</button> &nbsp;');
						       			jQuery('#user_tbl_length').prepend('<button class="btn btn-info change_Status pull-left delete_multiple" id="delete_multiple" style="margin-right:10px;">Delete</button> &nbsp;');
						       			jQuery('#user_tbl_length').prepend('<button class="btn btn-info change_Status pull-left add" id="add" style="margin-right:10px;">Add User</button> &nbsp;');

						       			
						       			
						       			jQuery('#user_tbl_length select').addClass("form-control");
						       			jQuery('#user_tbl_filter input').addClass("form-control");
						       			is_first_time_load = false;
						       		}	
						       	},
    	});

	jQuery(document).on("click",".add",function(){

		jQuery("#user_form").attr("action", APPLICATION_URL+"dashboard/users/add");
	});
 	
  	jQuery(document).on("click",".delete_multiple",function(e){
		e.preventDefault();
			
		if ( !jQuery(".case").is(':checked') )
		{
			alert("Please select at least one check box.");
			return false;	
		}
		else
		{
			if(confirm('Are you sure you want to delete these user?') == true)
 	 		{
					jQuery("#user_form").attr("action", APPLICATION_URL+"dashboard/users/delete_multi_user");
				
					var url  = jQuery("#user_form").attr("action");
					var data = jQuery("#user_form").serialize();
					jQuery.ajax({
						url : url ,
						method : 'post',
						data : data,
						success : function(data){
							//console.log(data);
								user_tbl._fnAjaxUpdate();
								jQuery("#checkall").prop("checked","");
								
								var json_data = jQuery.parseJSON(data);
							
								if( json_data.status == 200 )
								{
									msg_display( 200, json_data.message );
								}
								else
								{
									msg_display( 500, json_data.message );
								}
						}
					});
				}
			else
			{
				return false;
			}
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
  
      
// jQuery(document).on("click",".remove",function(e){
//     	if(confirm('Are you sure you want to delete these user ?') == true)
//     	{
//     		return true;
//     	}
//     	return false;
//     });
    
 });
 
 
 jQuery(document).on("click",".enable_multiple",function(e){
			
			e.preventDefault();
			
		if ( !jQuery(".case").is(':checked') )
		{
				 alert("Please select at least one check box.");
				
				return false;	
		}
		else
		{
			if(confirm('Are you sure you want to enable these user ?') == true)
 	 		{
					jQuery("#user_form").attr("action", APPLICATION_URL+"dashboard/users/change_multi_user/"+1);
				
					var url  = jQuery("#user_form").attr("action");
					var data = jQuery("#user_form").serialize();
					jQuery.ajax({
						url : url ,
						method : 'post',
						data : data,
						success : function(data){
							console.log(data);
								user_tbl._fnAjaxUpdate();
								jQuery("#checkall").prop("checked","");
								
								var json_data = jQuery.parseJSON(data);
							
								if( json_data.status == 200 )
								{
									msg_display( 200, json_data.message );
								}
								else
								{
									msg_display( 500, json_data.message );
								}
						}
					});
				}
				else
				{
					return false;
				}
			}
			
});

jQuery(document).on("click",".disable_multiple",function(e){
			
			e.preventDefault();
			
		if ( !jQuery(".case").is(':checked') )
		{
				 alert("Please select at least one check box.");
				
				return false;	
		}
		else
		{
			if(confirm('Are you sure you want to disable these user member?') == true)
 	 		{
					jQuery("#user_form").attr("action", APPLICATION_URL+"dashboard/users/change_multi_user/"+0);
				
					var url  = jQuery("#user_form").attr("action");
					var data = jQuery("#user_form").serialize();
					jQuery.ajax({
						url : url ,
						method : 'post',
						data : data,
						success : function(data){
							console.log(data);
								user_tbl._fnAjaxUpdate();
								jQuery("#checkall").prop("checked","");
								
								var json_data = jQuery.parseJSON(data);
							
								if( json_data.status == 200 )
								{
									msg_display( 200, json_data.message );
									location.reload();
								}
								else
								{
									msg_display( 500, json_data.message );
								}
						}
					});
				}
				else
				{
					return false;
				}
			}
			
});