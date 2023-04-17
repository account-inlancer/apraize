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
            if (result.status == "200") 
            {
              Swal.fire({
                type: 'success',
                title: 'Successfully saved',
                showConfirmButton: false,
                timer: 1500
              })
            }else{
              Swal.fire({
                type: 'warning',
                title: 'Oops',
                text: result.message,
                showConfirmButton: false,
                timer: 2000
              })
            }
            if (result.status == "200") 
            {
                document.getElementById("add_form").reset()
                document.getElementById("target").focus();
            }else{
                // document.getElementById("add_form").reset()
            }
            // jQuery("#message").html(result.message);
          //var result = response.responseText.split("*****");    
          },
          error: function()
          {
    
          } 
      }; 

    jQuery("#add_form").ajaxForm(options);   
});

      // jQuery('#div1').scrollTop(jQuery('#div1')[0].scrollHeight)
