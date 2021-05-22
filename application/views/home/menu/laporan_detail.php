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
      
      <div class="col-lg-2 col-md-2 col-xs-12">
        <input type="hidden" id="val_bulan" value="<?=$bulan?>">
        <input type="hidden" id="val_tahun" value="<?=$tahun?>">
      </div>
      <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="box-content card">
          <h4 class="box-title" style="background: #0055FF ;cursor: pointer;" onclick="myFunction('div_laporan')">Laporan Absensi</h4>
          <!-- /.box-title -->
          <div class="card-content" style="overflow-x: auto; display: none;" id="div_laporan">
            <table id="table_absensi" class="table table-striped table-bordered display" style="width:100%">
              <!-- <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
              </thead> -->
              
            </table>
            <!-- <hr>
            <center><button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="cetak_laporan()">Cetak Laporan</button></center> -->
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
      $('#table_absensi').DataTable({
        responsive: true,
        "ajax": {
          "type": "POST",
          "url": url+'home/laporan/',
          "data" :{'proses' : 'table_absensi_detail', 'bulan' : $("#val_bulan").val(), 'tahun' : $("#val_tahun").val()},
          "timeout": 120000,
          "dataSrc": function (json) {
            // console.log(json);
            if(json != null){
              return json
            } else {
              return "";
            }
          }
        },
        "sAjaxDataProp": "",
        "width": "100%",
        "order": [[ 0, "asc" ]],
        "aoColumns": [
          {
              "mData": null,
              "title": "No",
              render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }
          },
          
          {
              "mData": null,
              "title": "Tanggal",
              "render": function (data, row, type, meta) {
                  return data.tanggal;
              }
          },
          {
              "mData": null,
              "title": "Hari",
              "render": function (data, row, type, meta) {
                  return data.hari;
              }
          },
          {
              "mData": null,
              "title": "Aksi",
              "sortable": false,
              "render": function (data, row, type, meta) {
                let btn = '';

                
                btn += `<button title="Lihat Detail Absensi Tanggal ${data.tanggal}" class="btn btn-primary btn-circle btn-sm waves-effect waves-light" onclick="detail_absensi('${data.tanggal}')"><i class="fa fa-search"></i></button>`;
                

                return btn;
              }
          }

        ]
      });


    }
    datatables();

    async function detail_absensi(tanggal){
      var tanggal = await tanggal.split('-');
      // console.log(tanggal);
      await block_ui(); 
      await $("#sini_modalnya .modal-header .modal-title").html(`Absensi Tanggal ${tanggal[0]}-${tanggal[1]}-${tanggal[2]}`)
      await $("#sini_modalnya .modal-dialog").attr('class','modal-dialog')

      let html = await  `<div class="row small-spacing">
            <div class="col-lg-12 col-xs-12" style="overflow-x: auto; ">
              <table id="table_absensi_detail" class="table table-striped table-bordered display" style="width:100%"></table>
            </div>
          </div>`

      await $("#sini_modalnya .modal-body").html(html)

      

      $('#table_absensi_detail').DataTable({
        responsive: true,
        "ajax": {
          "type": "POST",
          "url": url+'home/laporan/',
          "data" :{'proses' : 'table_absensi_detail_tanggal', 'bulan' : tanggal[1], 'tahun' : tanggal[2], 'tanggal' : tanggal[0]},
          "timeout": 120000,
          "dataSrc": function (json) {
            // console.log(json);
            if(json != null){
              return json
            } else {
              return "";
            }
          }
        },
        "sAjaxDataProp": "",
        "width": "100%",
        "order": [[ 0, "asc" ]],
        "aoColumns": [
          {
              "mData": null,
              "title": "NIK",
              render: function (data, type, row, meta) {
                  return data.nik_karyawan;
              }
          },
          
          {
              "mData": null,
              "title": "Nama",
              "render": function (data, row, type, meta) {
                  return data.nama;
              }
          },
          {
              "mData": null,
              "title": "Jam Masuk",
              "render": function (data, row, type, meta) {
                  return data.jam_masuk;
              }
          },
          {
              "mData": null,
              "title": "Jam Masuk",
              "render": function (data, row, type, meta) {
                  return data.jam_keluar;
              }
          },
          // {
          //     "mData": null,
          //     "title": "Jam Keluar",
          //     "sortable": false,
          //     "render": function (data, row, type, meta) {
          //       let btn = '';

                
          //       btn += `<button title="Lihat Detail Absensi Tanggal ${data.tanggal}" class="btn btn-primary btn-circle btn-sm waves-effect waves-light" onclick="detail_absensi('${data.tanggal}')"><i class="fa fa-search"></i></button>`;
                

          //       return btn;
          //     }
          // }

        ]
      });

      // let footer = await `<button type="button" class="btn btn-info btn-xs" id="button_edit_data" onclick="cetak(1)">Edit Data ? </button> <button type="button" onclick="hapus_karyawan(${data_karyawan.nik_karyawan},'${data_karyawan.nama}')" class="btn btn-danger btn-xs">Hapus Karyawan</button>`
      // await $("#sini_modalnya .modal-footer").html(footer)

      await $.unblockUI()

      await $('#sini_modalnya').modal('show');
    }

    async function cetak_laporan(){
      await block_ui(); 
      await $("#sini_modalnya .modal-header .modal-title").html(`Laporan Bulan ${$("#val_bulan").val()} , Tahun ${$("#val_tahun").val()}`)
      await $("#sini_modalnya .modal-dialog").attr('class','modal-dialog modal-lg')

      // console.log(``)
      let html = await  `<div class="row small-spacing">
            <div class="col-lg-12 col-xs-12" style="overflow-x: auto; ">
              <iframe src="${url}home/cetak/${$("#val_tahun").val()}/${$("#val_bulan").val()}" title="W3Schools Free Online Web Tutorials" width="100%" height="600px"></iframe>
            </div>
          </div>`

      await $("#sini_modalnya .modal-body").html(html)

      await $.unblockUI()
      await $('#sini_modalnya').modal('show');
    }
  </script>

</body>
</html>