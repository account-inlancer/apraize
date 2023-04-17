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
          },
          complete: function(response) 
          {
            console.log(response.responseText)
            var result = jQuery.parseJSON(response.responseText)
            jQuery("#messages").fadeIn().delay(2000).fadeOut().html(result.message);
            if (result.status=="500") 
            {}
            else
            {
              document.getElementById("edd_form").reset();
            }
            
            location.reload();
          //var result = response.responseText.split("*****");    
          },
          error: function()
          {
    
          } 
      }; 

    jQuery("#edd_form").ajaxForm(options);   
});
