<!DOCTYPE html>
<html lang="en">
<head>
  
  <?php $this->load->view('home/head');?>

  <link rel="stylesheet" href="<?=base_url()?>assets/plugin/datatables/media/css/dataTables.bootstrap.min.css">
</head>

<body>

<?php $this->load->view('home/header');?>

<div class="modal fade" id="sini_modalnya" role="dialog">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body row">
        <p>This is a small modal.</p>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<div id="wrapper">
  <div class="main-content">
    <div class="row small-spacing">
      
      <div class="col-lg-2 col-md-2 col-xs-12"></div>
      <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="box-content card">
          <h4 class="box-title" style="background: #0055FF ;cursor: pointer;" onclick="myFunction('div_laporan')">Laporan Absensi</h4>
          <!-- /.box-title -->
          <div class="card-content" style="overflow-x: auto; display: none;" id="div_laporan">
            <table id="table_absensi" class="table table-striped table-bordered display" style="width:100%">
              <thead>
                <tr>
                  <th>Tahun</th>
                  <th>Bulan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              
            </table>
          </div>
          <!-- /.card-content -->
        </div>
        <!-- /.box-content -->
      </div>
      <div class="col-lg-2 col-md-2 col-xs-12"></div>

    </div>


    <?php $this->load->view('home/footer');?>

  </div>
  <!-- /.main-content -->
</div><!--/#wrapper -->
  
  <?php $this->load->view('home/script'); ?>

  <script src="<?=base_url()?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>
  
  <script>
    var table;
    function datatables() {
      table = $('#table_absensi').DataTable({ 
        // "searching": false,
        "lengthMenu": [ [5, 10, 15, -1], [5, 10, 15, "All"] ],
        "pageLength": 15,
        "ordering": true,
        "processing": true, 
        "serverSide": true, 
        "order": [], 
         
        "ajax": {
          "url": url+"home/laporan",
          "type": "POST",
          data : {proses : 'table_all'}
        },

        "columnDefs": [
          { 
            "targets": [ 0 ], 
            "orderable": false, 
          },
        ],
      });
    }

    datatables()
  </script>

</body>
</html>