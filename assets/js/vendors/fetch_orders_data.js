function fetchInvoiceSeries(type_id)
    {
       if (type_id=='') 
      {
        jQuery("#seriesDiv").html('');
      }
      jQuery.ajax({
           type: "GET",
           url: APPLICATION_URL+"fetch-invoice-no/"+type_id,
           success: function(response) 
            { 
              // alert(response);
              jQuery("#invoice_no").val(response);
            },
           
        });
    } 

function fetchInvoiceNumber(series_name)
    {
      if (series_name=='') 
      {
        jQuery("#invoice_no").html('');
      }
      jQuery.ajax({
           type: "GET",
           url: APPLICATION_URL+"dashboard/orders/fetchInvoiceNumber/"+series_name,
           success: function(response) 
            { 
              alert(response);
              jQuery("#invoice_no").html(response);
            },
           
        });
    } 
 