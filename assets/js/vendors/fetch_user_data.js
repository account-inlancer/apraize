jQuery(document).ready(function(){

  jQuery(document).on("click",".tour_plan",function()
  {
  	var id=jQuery('#user_id').val();
  			jQuery.ajax({
    			url: APPLICATION_URL+"dashboard/tour/tours",
    			cache: false,
    			type:"GET",
    			success: function(response){
            console.log(response);
      		jQuery("#user_page").html(response);
    			}
  		});	
  }); 


  jQuery(document).on("click",".dr_sample",function()
  {
    var id=jQuery('#user_id').val();
        jQuery.ajax({
          url: APPLICATION_URL+"dashboard/dr_sample/samples",
          cache: false,
          type:"GET",
          success: function(response){
            console.log(response);
          jQuery("#user_page").html(response);
          }
      }); 
  }); 

  
  jQuery(document).on("click",".daily_expense",function()
  {
    var id=jQuery('#user_id').val();
        jQuery.ajax({
          url: APPLICATION_URL+"dashboard/daily_expense/expenses",
          cache: false,
          type:"GET",
          success: function(response){
            console.log(response);
          jQuery("#user_page").html(response);
          }
      }); 
  }); 


});

