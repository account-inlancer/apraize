<div class="modal fade edit_department_modal" id="edit_department_modal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header ">
              <h5 class="modal-title mt-0" id="myModalLabel">Edit New department</h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form class="form edit_form" method="post" name="edit_form" id="department"  action="<?php echo base_url('save-department')?>" enctype="multipart/form-data" > 
                    <input type="hidden" name="mode" value="edit">  
                    <input type="hidden" name="id" value="<?php echo $department_details['d_id']; ?>">
                    <div id="message"></div>   
                    <div class="form-body">  
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">    
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Name<span class="text-danger">*</span></label> 
                                                    <input type='text' id="name" name="d_name" value="<?php echo $department_details['d_name']; ?>" class="form-control"  >
                                                </div>
                                            </div> 
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Shortname<span class="text-danger">*</span></label> 
                                                    <input type='text' id="shortname" name="shortname" value="<?php echo $department_details['shortname']; ?>" class="form-control"  >
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="row">    
                                            <div class="col-12 text-right">
                                                <button type="submit"   class="btn btn-primary waves-effect waves-light">Save</button> 
                                                <button type="button" class="btn btn-outline-danger waves-effect waves-light" data-dismiss="modal">Close</button>    
                                            </div>
                                        </div> 
                                    </div> 
                                </div>  
                            </div>  
                        </div>
                    </div>  
                </form>
            </div> 
        </div> 
    </div> 
</div>


<script type="text/javascript">
    jQuery(document).ready(function() {
      var dd = { 
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
          console.log(response.responseText);
          var result = jQuery.parseJSON(response.responseText)  ;
          if (result.status == 200) 
          {
            Swal.fire({
              type: 'success',
              title: 'Successfully saved',
              showConfirmButton: false,
              timer: 1500
            });
            department_tbl._fnAjaxUpdate();
            jQuery('#department').trigger("reset");
            jQuery('.modal').modal('hide');
          }else{
            Swal.fire({
              type: 'warning',
              title: 'Oops',
              text: result.message,
              showConfirmButton: false,
              timer: 2000
            });
          } 
        },
        error: function()
        {

        } 
    }; 
    jQuery("#department").ajaxForm(dd);
});

</script>