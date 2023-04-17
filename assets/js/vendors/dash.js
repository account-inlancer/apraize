jQuery(document).ready(function() {
  
  jQuery(document).on("click","#s_id",function(){
    var supplier_id = document.getElementById("supplier_id").value;
    if (supplier_id=='')
    {
      alert("Please Select Supplier First");
    }
    else
    {
      window.open(APPLICATION_URL+"dashboard/suppliers/view_supplier/"+supplier_id);
    // jQuery("#save_order").attr("action", APPLICATION_URL+"customer/customer/save_order/"+customer_id);
    }
  });


  jQuery(document).on("click","#p_id",function(){
    var product_id = document.getElementById("product_id").value;
    if (product_id=='')
    {
      alert("Please Select Product First");
    }
    else
    {
      window.open(APPLICATION_URL+"dashboard/products/view_product/"+product_id);
    }
  });

});
