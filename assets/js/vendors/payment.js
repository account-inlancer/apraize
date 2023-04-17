jQuery(document).ready(function(){

    jQuery("#payment_date").focus(function(){
    var customer_id = document.getElementById("customer_id").value;
      if (customer_id!='') 
      {
        jQuery.ajax({
            type: "GET",
             url: APPLICATION_URL+"dashboard/payments/fetchCustomerDueAmount/"+customer_id,
            success: function(response) 
              { 
                // console.log(response);
                jQuery(".dueamount").html(response);
                // jQuery("#refresh").removeClass("fa-spin");
              }, 
        }); 
      }
    });

    jQuery("#spayment_date").focus(function(){
    var supplier_id = document.getElementById("supplier_id").value;
      if (supplier_id!='') 
      {
        jQuery.ajax({
            type: "GET",
             url: APPLICATION_URL+"dashboard/payments/fetchSupplierDueAmount/"+supplier_id,
            success: function(response) 
              { 
                // console.log(response);
                jQuery(".dueamount").html(response);
                // jQuery("#refresh").removeClass("fa-spin");
              }, 
        }); 
      }
    });

    jQuery("#wpayment_date").focus(function(){
    var worker_id = document.getElementById("worker_id").value;
      if (worker_id!='') 
      {
        jQuery.ajax({
            type: "GET",
             url: APPLICATION_URL+"dashboard/payments/fetchWorkerDueAmount/"+worker_id,
            success: function(response) 
              { 
                // console.log(response);
                jQuery(".dueamount").html(response);
              }, 
        }); 
      }
    });

    jQuery('#search').on('keyup', function(){
      var search_text = document.getElementById("search").value;
      var search_text=search_text.replace(" ",'');
      if(search_text!='') 
      {
        jQuery.ajax({
           type: "GET",
           url: APPLICATION_URL+"dashboard/reports/fetchCollection/"+search_text,
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
           url: APPLICATION_URL+"dashboard/reports/fetchAllCollection/",
           success: function(response) 
            { 
              jQuery("#collect").html(response);  
              console.log(response);
            },
        }); 
      }  
    }); 

});
