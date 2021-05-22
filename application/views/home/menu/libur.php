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

      <div class="col-lg-2 col-md-2"></div>
      <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="box-content card">
          <h4 class="box-title" style="background: #0055FF ;cursor: pointer;" onclick="myFunction('div_table_user')">List Karyawan</h4>
          <!-- /.box-title -->
          <div class="card-content" style="overflow-x: auto; display: none;" id="div_table_user">
            <table id="table_list_karyawan" class="table table-striped table-bordered display" style="width:100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              
            </table>
            <hr>
            <center><button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Cetak Laporan</button></center>
          </div>
          <!-- /.card-content -->
        </div>
        <!-- /.box-content -->
      </div>
      <div class="col-lg-2 col-md-2"></div>
      
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
      table = $('#table_list_karyawan').DataTable({ 
        // "searching": false,
        "lengthMenu": [ [5, 10, 15, -1], [5, 10, 15, "All"] ],
        "pageLength": 15,
        "ordering": true,
        "processing": true, 
        "serverSide": true, 
        "order": [], 
         
        "ajax": {
          "url": url+"home/karyawan",
          "type": "POST",
          data : {proses : 'table_karyawan'}
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

    async function detail_karyawan(nik_karyawan,nama){
      // console.log(nik_karyawan);
      await block_ui();
      let html = await `<div class="row small-spacing">
        <div class="col-lg-12 col-xs-12">
          <form class="card-content" id="sini_form_detail" >
            <div class="form-group">
              <label for="exampleInputEmail1">NIK Karyawan</label>
              <input type="text" class="form-control"  id="nik_karyawan_detail" name="nik_karyawan" placeholder="Masukkan NIK Karyawan" maxlength="14" onkeypress="return isNumberKey(event)" disabled="" value="${nik_karyawan}">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Nama Karyawan</label>
              <input type="text" class="form-control" id="nama_detail" name="nama" placeholder="Masukkan Nama" disabled="" value="${nama}">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Tanggal Mulai Libur</label>
              <input type="date" class="form-control" id="tanggal_mulai_libur" name="tanggal_mulai_libur"  value="${get_tomorrow('hari')}" min="${get_tomorrow('hari')}">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Tanggal Selesai Libur</label>
              <input type="date" class="form-control" id="tanggal_selesai_libur" name="tanggal_selesai_libur"  value="${get_tomorrow('hari')}" min="${get_tomorrow('hari')}">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Keterangan Libur</label>
              <textarea style="resize:none" class="form-control" id="keterangan_libur" name="keterangan_libur" placeholder="Masukkan Ketrangan Libur"></textarea>
            </div>

            <div class="form-group"><center><button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="tambah_libur()">Tambah Libur</button></center></div>

            <hr>
            <div class="form-group" style="overflow-x:auto">
              <table id="table_libur_detail" class="table table-striped table-bordered display" style="width:100%"></table>
            </div>

          </form>
          <!-- /.card-content -->
        </div>
      </div>`

      
      await $("#sini_modalnya .modal-body").html(html)

      await $('#table_libur_detail').DataTable({
        responsive: true,
        "ajax": {
          "type": "POST",
          "url": url+'home/libur/',
          "data" :{'proses' : 'table_libur_detail', nik_karyawan : nik_karyawan},
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
              "title": "Keterangan",
              "render": function (data, row, type, meta) {
                  return data.keterangan;
              }
          },
          

        ]
      });
      


      
      await $("#sini_modalnya .modal-header .modal-title").html("Pengaturan Libur Karyawan")
      await $("#sini_modalnya .modal-dialog").attr('class','modal-dialog')

      await $.unblockUI();
      await $('#sini_modalnya').modal('show');
      
    }

    async function tambah_libur(){
      let nik_karyawan = $("#nik_karyawan_detail").val();
      let tanggal_mulai_libur = $("#tanggal_mulai_libur").val();
      let tanggal_selesai_libur = $("#tanggal_selesai_libur").val();
      let keterangan_libur = $("#keterangan_libur").val();

      if (tanggal_mulai_libur > tanggal_selesai_libur) {
        toastnya('Tanggal Mulai Libur Lebih Besar Dari Tanggal Selesai Libur<br>Sila Atur Kembali Tanggal Libur');
        $("#tanggal_mulai_libur").focus();
      }else if (keterangan_libur == '') {
        toastnya('Keterangan Libur Harus Diisi');
        $("#keterangan_libur").focus();
      }else{

        const listDate = [];
        const startDate =tanggal_mulai_libur;
        const endDate = tanggal_selesai_libur;
        const dateMove = new Date(startDate);
        let strDate = startDate;
        let array;

        if (startDate == endDate) {
          array = {tanggal : startDate, ket : keterangan_libur}
          listDate.push(array);
        } else {
          while (strDate < endDate) {
            strDate = dateMove.toISOString().slice(0, 10);
            array = {tanggal : strDate, ket : keterangan_libur}
            listDate.push(array);
            dateMove.setDate(dateMove.getDate() + 1);
          }
        }
        
        let where = {nik_karyawan : nik_karyawan}
        let detail = {detail : JSON.stringify(listDate)}

        // console.log(listDate)
        $.ajax({
          url: url+"api_server/libur",
          type: 'put',
          data: {where : where, detail : detail},
          beforeSend: function(res) {
            block_ui()
          },
          success:  function  (response) {
            $.unblockUI();
            // console.log(response)
            swal({
              title : "Sukses",
              text:  "Libur Berhasil Ditambah ",
              icon: "success",
              buttons: {
                cancel: false,
                confirm: true,
              },
              timer : 3000
              // dangerMode: true,
            })
            $('#sini_modalnya').modal('hide');
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            // console.log(errorThrown)
            bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,null)
            $.unblockUI();
          } 
        });

      }
    }
   
    async function qrcode_karyawan(nik_karyawan){
      let html = await  `<div class="row small-spacing">
          <div class="col-lg-12 col-xs-12" style="overflow-x: auto; ">
            <iframe src="${url}home/print_id_karyawan/${nik_karyawan}"  width="100%" height="450px"></iframe>
          </div>
        </div>`

      await $("#sini_modalnya .modal-body").html(html)
          
      await $('#sini_modalnya').modal('show');
    }
  </script>

</body>
</html>