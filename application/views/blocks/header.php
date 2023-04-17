<div class="main-wrapper main-wrapper-1">
  <div class="navbar-bg"></div>
  <nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
    </div>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown">
          <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <div class="d-sm-none d-lg-inline-block">Hi, Admin</div>
          </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-title">Logged in 5 min ago</div>
          <a href="<?php echo base_url('profile') ?>" class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile </a>
          <a href="<?=base_url('logout')?>" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i> Logout </a>
        </div>
      </li>
    </ul>
  </nav>
  <div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand"> <a href="<?=base_url('main')?>">HYPERISE</a> </div>
      <div class="sidebar-brand sidebar-brand-sm"> </div>
      <ul class="sidebar-menu">
        
        <li>
          <a class="nav-link" href="<?=base_url('blog')?>"><i class="fas fa-th"></i> <span>Blog Master</span></a>
        </li>

        <li>
          <a class="nav-link" href="<?=base_url('pricelist')?>"><i class="fas fa-tags"></i> <span>Pricelist Master</span></a>
        </li>

        <li>
          <a class="nav-link" href="<?=base_url('gallery')?>"><i class="fas fa-images"></i> <span>Gallery Master</span></a>
        </li>

        <li>
          <a class="nav-link" href="<?=base_url('department')?>"><i class="fas fa-pencil-ruler"></i> <span>Department</span></a>
        </li>

         <li>
          <a class="nav-link" href="<?=base_url('app-user')?>"><i class="fab fa-app-store-ios"></i> <span>App User</span></a>
        </li>
      </ul>
    </aside>
  </div>