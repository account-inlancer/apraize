jQuery(document).ready(function() {

  var options = { 
      beforeSend: function() 
      { 
        
      },
      uploadProgress: function(event, position, total, percentComplete) 
      {
          
      },
      success: function() 
      {
        var customer_id = document.getElementById("customer_id").value;
        var invoice_id = document.getElementById("invoice_id").value;
        jQuery.ajax({
            type: "GET",
             url: APPLICATION_URL+"dashboard/orders/fetchTempOrder/"+customer_id+'/'+invoice_id,
            success: function(response) 
              { 
                jQuery("#fetch_temp_orders").html(response);
                // jQuery("#refresh").removeClass("fa-spin");
              }, 
        });

      
        
      },
      complete: function(response) 
      {    
        document.getElementById("add_form").reset()
        console.log(response.responseText);
        var result = jQuery.parseJSON(response.responseText)
        jQuery("#message").fadeIn().delay(3000).fadeOut().html(result.message);
        // var dv = document.getElementById("message");
        // jQuery("#chat-area").animate({ scrollTop: jQuery('#chat-area').prop("scrollHeight")}, 3000);
      },
      error: function()
      {

      } 
  }; 

  jQuery("#add_form").ajaxForm(options);

  jQuery(document).on("click",".save_order",function(){
    var customer_id = document.getElementById("customer_id").value;
    console.log(customer_id);
    jQuery("#save_order").attr("action", APPLICATION_URL+"dashboard/orders/saveOrder/"+customer_id);
  });

  jQuery("#price").focus(function(){
    // alert("df");
      var customer_id = document.getElementById("customer_id").value;
      var product_id = document.getElementById("product_id").value;
        jQuery.ajax({
            type: "GET",
             url: APPLICATION_URL+"dashboard/orders/fetchCustomerPrice/"+customer_id+"/"+product_id,
            success: function(response) 
              { 
                // console.log(response);
                jQuery(".pricetag").html(response);
                jQuery(".pricetag").fadeIn().delay(3000).fadeOut().html(response);
                // jQuery("#refresh").removeClass("fa-spin");
              }, 
        });
  });

});


