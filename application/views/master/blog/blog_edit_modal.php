<div class="modal fade edit_blog_modal" id="edit_blog_modal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header ">
              <h5 class="modal-title mt-0" id="myModalLabel">Edit New blog</h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form class="form edit_form" method="post" name="edit_form" id="blog" action="<?php echo base_url('save-blog')?>" enctype="multipart/form-data" > 
                    <input type="hidden" name="mode" value="edit">  
                    <input type="hidden" name="id" value="<?php echo $blog_details['blog_id']; ?>">
                    <div id="message"></div>   
                    <div class="form-body">  
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                          <div class="col-md-12">
                                                <label for="withdrawinput1">Select Department <span style="color: red">*</span></label>
                                                <select class="form-control" name="department" id="department">
                                                    <option value="">Select Department</option>
                                                       <?php if($department){ foreach ($department as $key => $value) { 
                                                            $selected = "";
                                                            if($blog_details['department'] == $value->d_id){
                                                                $selected = "selected"; } ?>
                                                                <option value="<?php echo $value->d_id;?>" <?php echo $selected;?>><?php echo $value->d_name;?></option>
                                                        <?php } } ?>                      
                                                </select>
                                            </div>
                                            &nbsp;
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Title<span class="text-danger">*</span></label> 
                                                    <input type='text' id="title" name="title" value="<?php echo $blog_details['title']; ?>" class="form-control"  >
                                                    <input type="hidden" name="slug" id="slug">
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Details<span class="text-danger">*</span></label> 
                                                    <textarea name="body" id="editor1" class="form-control" ><?php echo $blog_details['body']; ?></textarea>
                                                </div>
                                            </div> 
                                        </div> 
                                        <div class="row">    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Image<span class="text-danger">*</span></label> 
                                                    <input type='file' name="post_image" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type='hidden' name="current_picture" 
                                                    value="<?php echo $blog_details['post_image'];?>" >
                                                    <br>
                                                    <img  style="height: 100px" src="<?php echo $blog_details['post_image_url']; ?>"> 
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
        followingToolbar: false, 
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul','ol','paragraph']],
            ["view", ["fullscreen", "codeview"]]
        ],
    });
  /*For Slug */
  $('#title').bind('keyup keypress blur', function() 
    {  
        var myStr = $(this).val()
        myStr=myStr.toLowerCase();
        myStr=myStr.replace(/[^a-zA-Z0-9]/g,'-').replace(/\s+/g, "-");

        $('#slug').val(myStr); 
        $('#slug').val(); 
    }
  );
  $('#slug').bind('keyup keypress blur', function() 
    {  
        var myStr = $(this).val()
        myStr=myStr.toLowerCase();
        myStr=myStr.replace(/[^a-zA-Z0-9]/g,'-').replace(/\s+/g, "-");

        $('#slug').val(myStr); 
        $('#slug').val(); 
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
            blog_tbl._fnAjaxUpdate();
            jQuery('#blog').trigger("reset");
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

    jQuery("#blog").ajaxForm(dd);


});
</script>