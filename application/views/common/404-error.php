	  <div class="site-output no-page">
		 	<?php
					$this->load->view('blocks/left-sidbar'); 
			?>
        <div id="all-output" class="col-md-10 error-page">
			<div class="row">

				<div class="col-md-5">
                	<h1 class="error-no">404</h1>
                </div>

				<div class="col-md-5">
                	<p class="error-text">
							Sorry, an error has occured, Requested page not found!
                    </p>
                    <a href="<?php echo base_url(); ?>" class="btn btn-primary" style="background: #32304a;border:#32304a">
		    <i class="icon-home icon-white"></i> Take Me Home </a>
                </div>

            </div>
		</div>
      </div>