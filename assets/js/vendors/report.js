jQuery(document).ready(function(){

    jQuery('#search').on('keyup', function(){
      var search_text = document.getElementById("search").value;
      var search_text=search_text.replace(" ",'');
      if(search_text!='') 
      {
        jQuery.ajax({
           type: "GET",
           url: APPLICATION_URL+"dashboard/reports/fetchCustomerReport/"+search_text,
           success: function(response) 
            { 
              jQuery("#collect").html(response);  
              console.log(response);
            },
        });  
      }
      else
      {
         jQuery.ajax({
           type: "GET",
           url: APPLICATION_URL+"dashboard/reports/fetchAllCustomerReport/",
           success: function(response) 
            { 
              jQuery("#collect").html(response);  
              console.log(response);
            },
        }); 
        
      }  
    }); 

});
