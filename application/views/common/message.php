<?php
	$errors = $this->session->flashdata("errors");
	
	if ( $errors)
	{ ?>
		 <div class="alert alert-danger alert-dismissable" style="margin:10px 15px;"> 
           <?php echo $errors; ?>
       </div>
		
	<?php } 


	$success = $this->session->flashdata("success");
	
	if ( $success)
	{
		?>
		 <div class="alert alert-success alert-dismissable" style="margin:10px 15px;"> 
           <?php echo $success; ?>
         </div>
		
	<?php } 

?>
