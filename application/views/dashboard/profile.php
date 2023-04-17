<div class="main-content" style="min-height: 375px;"> 
<section id="basic-form-layouts">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header"> 
          <h4 class="card-title" id="basic-layout-colored-form-control">Update Profile: 
          </h4>
        </div>
        <div class="card-body">
          <div class="px-3">     
            <div class="form-body">
              <form name="profile" id="profile" method="POST" action="<?= base_url('dashboard/general/saveNewPassword');?>">
                <div class="row"> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="withdrawinput1">Email</label>
                      <input type="hidden" name="id" value="<?php echo $user_info['id']; ?>">
                      <input type="text" name="email" value="<?php echo $user_info['email'] ?>" class="form-control rounded"  >
                    </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="withdrawinput1">Old Password</label>
                       <input type="text" name="old_password" class="form-control rounded" placeholder="Old Password" >
                      </div>
                    </div> 
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="withdrawinput1">New Password</label>
                       <input type="text" name="password" class="form-control rounded" placeholder="New Password"  >
                      </div>
                    </div> 
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="withdrawinput1">Confirm Password</label>
                       <input type="text" name="confirm_password" class="form-control rounded" placeholder="Confirm Password" >
                      </div>
                    </div> 
                  </div>
                  <div class="row">
                    <div class="col-sm-4" style="margin-top: 20px;">
                        <button  class=" btn-primary btn">Save Password</button>
                    </div>
                </div>
                </div>
              </div> 
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
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
            profile_tbl._fnAjaxUpdate();
            jQuery('#profile').trigger("reset");
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
    jQuery("#profile").ajaxForm(dd);
});
</script>