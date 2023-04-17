jQuery(document).ready(function() {
  
  jQuery(document).on("click",".new_order",function(){
    var customer_id = document.getElementById("customer_id").value;
    jQuery("#new").attr("action", APPLICATION_URL+"dashboard/orders/order/"+customer_id);
  });

  jQuery(document).on("click",".save_order",function(){
    var customer_id = document.getElementById("customer_id").value;
    console.log(customer_id);
    jQuery("#save_order").attr("action", APPLICATION_URL+"customer/customer/save_order/"+customer_id);
  });


});
