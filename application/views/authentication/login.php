
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <link rel="icon" href="<?=base_url('assets/favicon.ico')?>" type="image/x-icon">
  <!-- General CSS Files -->
  <title>Login</title>
  <link rel="stylesheet" href="<?=base_url('wp-includes/assets/modules/bootstrap/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('wp-includes/assets/modules/fontawesome/css/all.min.css')?>">

  <!-- CSS Libraries -->
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url('wp-includes/assets/css/style.css')?>">

  
  <script src="<?= base_url('wp-includes/assets/modules/jquery.min.js')?>"></script>
  <script type="text/javascript" src="<?=base_url('assets/js/jquery.form.js');?>"></script>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-4">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="<?=base_url('assets/icons/logo.svg')?>" alt="logo" width="250" >
            </div>

            <div class="card card-primary">
             
                 <?php  $this->load->view("common/message");  ?>
              <div class="card-body">
                <form method="POST" action="<?php echo base_url('do-login');?>" >
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" class="form-control"  name="email" required>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" required>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-block btn-primary"  type="submit">Sign in</button> 
                  </div>
                </form>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  </div>


  <script src="<?= base_url('wp-includes/assets/js/stisla.js')?>"></script>
  
    <!-- Page Specific JS File -->
  <script src="<?= base_url('wp-includes/assets/js/page/index.js')?>"></script>
  
  <!-- Template JS File -->
  <script src="<?= base_url('wp-includes/assets/js/scripts.js')?>"></script>
  <script src="<?= base_url('wp-includes/assets/js/custom.js')?>"></script>
</body>
</html>