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
            var redirect_url = result.return;
            // jQuery("#message").fadeIn().delay(2000).fadeOut().html(result.message);
            Swal.fire({
              type: 'success',
              title: 'Successfully Edited',
              showConfirmButton: false,
              timer: 1500
            })
              
          },
          error: function()
          {
    
          } 
      }; 

      jQuery("#edit_form").ajaxForm(options);   
  });