<div class="modal fade edit_pricelist_modal" id="edit_pricelist_modal" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header ">
              <h5 class="modal-title mt-0" id="myModalLabel">Edit New pricelist</h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form class="form edit_form" method="post" name="edit_form" id="pricelist"  action="<?php echo base_url('save-pricelist')?>" enctype="multipart/form-data" > 
                    <input type="hidden" name="mode" value="edit">  
                    <input type="hidden" name="id" value="<?php echo $pricelist_details['id']; ?>">
                    <div id="message"></div>   
                    <div class="form-body">  
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">    
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold bg-primary">name</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="name" value="<?php echo $pricelist_details['name']; ?>" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold tex bg-primary">Unit</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="unit" value="<?php echo $pricelist_details['unit']; ?>" placeholder="Unit">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row mb-2">    

                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold bg-primary">MRP</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="mrp" value="<?php echo $pricelist_details['mrp']; ?>" placeholder="MRP">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold bg-primary">PTR</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="ptr" value="<?php echo $pricelist_details['ptr']; ?>" placeholder="PTR">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">    

                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold bg-primary">PTS</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="pts" value="<?php echo $pricelist_details['pts']; ?>" placeholder="PTS">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold bg-primary">Rate</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="netrate" value="<?php echo $pricelist_details['netrate']; ?>" placeholder="Net Rate">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">    

                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold bg-primary">TAX</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="tax" value="<?php echo $pricelist_details['tax']; ?>" placeholder="TAX">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text font-weight-bold bg-primary">HSN</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="hsn" value="<?php echo $pricelist_details['hsn']; ?>" placeholder="HSN">
                                                </div>
                                            </div>
                                        </div>
                                        &nbsp;
                                        <div class="row mb-10">
                                            <div class="col-md-12">
                                                <label for="withdrawinput1">Select Department <span style="color: red">*</span></label>
                                                <select class="form-control" name="department" id="department">
                                                    <option value="">Select Department</option>
                                                       <?php if($department){ foreach ($department as $key => $value) { 
                                                            $selected = "";
                                                            if($pricelist_details['department'] == $value->d_id){
                                                                $selected = "selected"; } ?>
                                                                <option value="<?php echo $value->d_id;?>" <?php echo $selected;?>><?php echo $value->d_name;?></option>
                                                        <?php } } ?>                      
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <br>
                                                    <label for="withdrawinput1">Notes<span class="text-danger">*</span></label> 
                                                    <textarea name="notes" id="editor1" class="form-control" ><?php echo $pricelist_details['notes']; ?></textarea>
                                                </div>
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
        jQuery("#editor1").summernote({
        height: 100,
        placeholder: 'Enter your description',
        followingToolbar: false,  
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul','ol','paragraph']],
            ["view", ["fullscreen", "codeview"]]
        ],
    });

    jQuery('i.note-recent-color').each(function(){
        jQuery(this).attr('style','background-color: transparent;');
    });
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
            pricelist_tbl._fnAjaxUpdate();
            jQuery('#pricelist').trigger("reset");
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
    jQuery("#pricelist").ajaxForm(dd);
});

</script>