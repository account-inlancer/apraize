<div class="modal fade edit_appusers_modal" id="edit_appusers_modal" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header ">
              <h5 class="modal-title mt-0" id="myModalLabel">Edit App Users</h5>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form class="form edit_form" method="post" name="edit_form" id="appusers"  action="<?php echo base_url('save-appusers')?>" enctype="multipart/form-data" > 
                    <input type="hidden" name="mode" value="edit">  
                    <input type="hidden" name="id" value="<?php echo $appusers_details['id'] ;?>">
                    <div id="message"></div>   
                    <div class="form-body">  
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Name<span class="text-danger">*</span></label> 
                                                    <input type='text' id="name" name="name" class="form-control" value="<?php echo $appusers_details['name'] ;?>" >
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Email<span class="text-danger">*</span></label> 
                                                    <input type='email' id="email" name="email" class="form-control" value="<?php echo $appusers_details['email'] ;?>"  >
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Contact<span class="text-danger">*</span></label> 
                                                    <input type='text' id="contact" name="contact" class="form-control" value="<?php echo $appusers_details['contact'] ;?>"  >
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Address<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="address" id="address"><?php echo $appusers_details['address'] ;?></textarea> 
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Username<span class="text-danger">*</span></label> 
                                                    <input type='text' id="username" name="username"  class="form-control" value="<?php echo $appusers_details['username'] ;?>" >
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Password<span class="text-danger">*</span></label> 
                                                    <input type='password' id="password" name="password" value="<?php echo $appusers_details['password'] ;?>" class="form-control"  >
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="withdrawinput1">Date Of Birth<span class="text-danger">*</span></label> 
                                                    <input type='date' id="dob" name="dob" class="form-control" value="<?php echo $appusers_details['dob'] ;?>" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <label for="withdrawinput1">Gender<span class="text-danger">*</span></label> 
                                                    <br>
                                                <label class="selectgroup-item mr-2">
                                                  <input type="radio" name="gender" value="Male"<?php if($appusers_details["gender"]=="Male"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">M</span>
                                                </label>

                                                <label class="selectgroup-item">
                                                  <input type="radio" name="gender" value="Female" <?php if($appusers_details["gender"]=="Female"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">F</span>
                                                </label>
                                            </div> 
                                            <div class="col-md-3">
                                                    <label for="withdrawinput1">Aesthetix<span class="text-danger">*</span></label> 
                                                    <br>
                                                <label class="selectgroup-item mr-2">
                                                  <input type="radio" name="A" value="1" <?php if($appusers_details["A"]=="1"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">YES</span>
                                                </label>

                                                <label class="selectgroup-item">
                                                  <input type="radio" name="A" value="0" <?php if($appusers_details["A"]=="0"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">NO</span>
                                                </label>
                                            </div>  
                                            <div class="col-md-3">
                                                    <label for="withdrawinput1">Bioderma<span class="text-danger">*</span></label> 
                                                    <br>
                                                <label class="selectgroup-item mr-2">
                                                  <input type="radio" name="B" value="1" <?php if($appusers_details["B"]=="1"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">YES</span>
                                                </label>

                                                <label class="selectgroup-item">
                                                  <input type="radio" name="B" value="0" <?php if($appusers_details["B"]=="0"){ echo "checked";}?>  class="selectgroup-input">
                                                  <span class="selectgroup-button">NO</span>
                                                </label>
                                            </div> 
                                             <div class="col-md-3">
                                                    <label for="withdrawinput1">Cytoz<span class="text-danger">*</span></label> 
                                                    <br>
                                                <label class="selectgroup-item mr-2">
                                                  <input type="radio" name="C" value="1" <?php if($appusers_details["C"]=="1"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">YES</span>
                                                </label>

                                                <label class="selectgroup-item">
                                                  <input type="radio" name="C" value="0" <?php if($appusers_details["C"]=="0"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">NO</span>
                                                </label>
                                            </div>  
                                            <div class="col-md-3">
                                                    <label for="withdrawinput1">Dermatix<span class="text-danger">*</span></label> 
                                                    <br>
                                                <label class="selectgroup-item mr-2">
                                                  <input type="radio" name="D" value="1" <?php if($appusers_details["D"]=="1"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">YES</span>
                                                </label>

                                                <label class="selectgroup-item">
                                                  <input type="radio" name="D" value="0" <?php if($appusers_details["D"]=="0"){ echo "checked";}?> class="selectgroup-input">
                                                  <span class="selectgroup-button">NO</span>
                                                </label>
                                            </div>   
                                        </div>    
                                        <hr>
                                        <div class="row">    
                                            <div class="col-12 ">
                                                <button type="submit" class="btn btn-outline-primary waves-effect waves-light">Save</button> 
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
            appusers_tbl._fnAjaxUpdate();
            jQuery('#appusers').trigger("reset");
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
    jQuery("#appusers").ajaxForm(dd);
});

</script>