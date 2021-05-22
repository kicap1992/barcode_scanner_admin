<div class="main-menu">
  <header class="header">
    <a href="<?=base_url()?>home" class="logo">Absensi Karyawan</a>
    <button type="button" class="button-close fa fa-times js__menu_close"></button>
    <div class="user">
      <a href="#" class="avatar"><img src="<?=base_url()?>/assets/images/admin.png" alt=""><span class="status online"></span></a>
      <h5 class="name">Admin</h5>
      <h5 class="position">Admin</h5>
      <!-- /.name -->
     
    </div>
    <!-- /.user -->
  </header>
  <!-- /.header -->
  <div class="content">

    <div class="navigation">
      <h5 class="title">Navigasi</h5>
      <!-- /.title -->
      <ul class="menu js__accordion">
        <li <?php if ($this->uri->segment(2) == ""): ?>class="current"<?php endif ?>>
          <a class="waves-effect" href="<?=base_url()?>home/"><i class="menu-icon fa fa-home"></i><span>Halaman Utama</span></a>
        </li>
        <li <?php if ($this->uri->segment(2) == "karyawan"): ?>class="current"<?php endif ?>>
          <a class="waves-effect" href="<?=base_url()?>home/karyawan"><i class="menu-icon fa fa-users"></i><span>Halaman Karyawan</span></a>
        </li>
        <li <?php if ($this->uri->segment(2) == "libur"): ?>class="current"<?php endif ?>>
          <a class="waves-effect" href="<?=base_url()?>home/libur"><i class="menu-icon fa fa-calendar-minus-o"></i><span>Pengaturan Libur</span></a>
        </li>
        <li <?php if ($this->uri->segment(2) == "laporan"): ?>class="current"<?php endif ?>>
          <a class="waves-effect" href="<?=base_url()?>home/laporan"><i class="menu-icon zmdi zmdi-storage"></i><span>Laporan Absensi</span></a>
        </li>
        <li <?php if ($this->uri->segment(2) == "notifikasi"): ?>class="current"<?php endif ?>>
          <a class="waves-effect" href="<?=base_url()?>home/notifikasi"><i class="menu-icon fa fa-phone"></i><span>No Telpon Notifikasi</span></a>
        </li>
        
      </ul>
      <!-- /.menu js__accordion -->
      <h5 class="title">Komponen Lain</h5>
      <!-- /.title -->
      <ul class="menu js__accordion">
       
        <li>
          <a class="waves-effect" onclick="logout()"><i class="menu-icon icon icon-logout"></i><span>Logout</span></a>
        </li>
      
      </ul>
     
    </div>
    <!-- /.navigation -->
  </div>
  <!-- /.content -->
</div>
<!-- /.main-menu -->

<div class="fixed-navbar">
  <div class="pull-left">
    <button type="button" class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button>
    <h1 class="page-title"><?=$header?></h1>
    <!-- /.page-title -->
  </div>
  
</div>
<!-- /.fixed-navbar -->