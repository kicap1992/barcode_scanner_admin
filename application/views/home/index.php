<!DOCTYPE html>
<html lang="en">
<head>
  
  <?php $this->load->view('home/head');?>

</head>

<body>

<?php $this->load->view('home/header');?>


<div id="wrapper">
  <div class="main-content">
    <div class="row small-spacing">
      <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="box-content bg-success text-white">
          <div class="statistics-box with-icon">
            <i class="ico small  fa fa-users"></i>
            <p class="text text-white">Jumlah Karyawan</p>
            <h2 class="counter">??</h2>
          </div>
        </div>
        <!-- /.box-content -->
      </div>
      <!-- /.col-lg-3 col-md-6 col-xs-12 -->
      <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="box-content bg-info text-white">
          <div class="statistics-box with-icon">
            <i class="ico small fa fa-dollar"></i>
            <p class="text text-white">Tanggal</p>
            <h2 class="counter">??</h2>
          </div>
        </div>
        <!-- /.box-content -->
      </div>

      <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="box-content bg-info text-white">
          <div class="statistics-box with-icon">
            <i class="ico small fa fa-dollar"></i>
            <p class="text text-white">Karyawan Bekerja</p>
            <h2 class="counter">??</h2>
          </div>
        </div>
        <!-- /.box-content -->
      </div>

    </div>


    <?php $this->load->view('home/footer');?>

  </div>
  <!-- /.main-content -->
</div><!--/#wrapper -->
  
  <?php $this->load->view('home/script'); ?>


</body>
</html>