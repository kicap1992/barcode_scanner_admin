<!DOCTYPE html>
<html lang="en">
<head>
  
  <?php $this->load->view('home/head');?>

  <link rel="stylesheet" href="<?=base_url()?>assets/plugin/datatables/media/css/dataTables.bootstrap.min.css">
</head>

<body>

<?php $this->load->view('home/header');?>


<div id="wrapper">
  <div class="main-content">
    <div class="row small-spacing">
      <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="box-content card">
          <h4 class="box-title" style="background: #0055FF ;cursor: pointer;" onclick="myFunction('div_tambah_user')">Form Penambahan Karyawan</h4>
          <!-- /.box-title -->
          <div class="card-content" style="overflow-x: auto; display: none;" id="div_tambah_user">
            <form id="sini_form">
              <div class="form-group">
                <label for="exampleInputEmail1">NIK Karyawan</label>
                <input type="text" class="form-control"  id="nik_karyawan" name="nik_karyawan" placeholder="Masukkan NIK Karyawan" maxlength="14" onkeypress="return isNumberKey(event)" >
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Nama Karyawan</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" title="Masukkan Tanggal Lahir">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Jenis Kelamin</label>
                <select name="jk" id="jk" class="form-control" title="Pilih Jenis Kelamin">
                  <option value="" disabled selected>-Pilih Jenis Kelamin</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Agama</label>
                <select name="agama" id="agama" class="form-control" title="Pilih Agama">
                  <option value="" disabled selected>-Pilih Agama</option>
                  <option value="Islam">Islam</option>
                  <option value="Kristen Protestan">Kristen Protestan</option>
                  <option value="Katolik">Katolik</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Buddha">Buddha</option>
                  <option value="Khonghucu">Khonghucu</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Status</label>
                <select name="status" id="status" class="form-control" title="Pilih Status">
                  <option value="" disabled selected>-Pilih Status</option>
                  <option value="Sudah Menikah">Sudah Menikah</option>
                  <option value="Belum Menikah">Belum Menikah</option>
                  <option value="Janda / Duda">Janda / Duda</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Pendidikan</label>
                <select name="pendidikan" id="pendidikan" class="form-control" title="Pilih Pendidikan">
                  <option value="" disabled selected>-Pilih Pendidikan</option>
                  <option value="SMA">SMA dan sederajatnya</option>
                  <option value="D3">D3 dan Sederajatnya</option>
                  <option value="S1">S1 dan Sederajatnya</option>
                  <option value="S2">S2 dan Sederajatnya</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" style="resize: none;" placeholder="Masukkan Alamat"></textarea>
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan">
              </div>

              <center><button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="tambah_karyawan()">Tambah Karyawan</button></center>
            </form>
          </div>
          <!-- /.card-content -->
        </div>
        <!-- /.box-content -->
      </div>
      <!-- /.col-lg-6 col-xs-12 -->

      <div class="col-lg-6 col-md-6 col-xs-12">
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

    function tambah_karyawan(){
      const nik_karyawan = $("#nik_karyawan").val()
      const nama = $("#nama").val()
      const tempat_lahir = $("#tempat_lahir").val()
      const tanggal_lahir = $("#tanggal_lahir").val()
      const jk = $("#jk").val()
      const agama = $("#agama").val()
      const status = $("#status").val()
      const pendidikan = $("#pendidikan").val()
      const alamat = $("#alamat").val()
      const jabatan = $("#jabatan").val()

      if (nik_karyawan == '') {
        toastnya('NIK Karyawan Harus Terisi')
        $("#nik_karyawan").focus()
      }else if (nik_karyawan.length != 14) {
        toastnya('Panjang NIK Karyawan Harus 14 Karakter')
        $("#nik_karyawan").focus()
      }else if (nama == '') {
        toastnya('Nama Karyawan Harus Terisi')
        $("#nama").focus()
      }else if (tempat_lahir == '') {
        toastnya('Tempat Lahir Karyawan Harus Terisi')
        $("#tempat_lahir").focus()
      }else if (tanggal_lahir == '') {
        toastnya('Tanggal Lahir Karyawan Harus Terisi')
        $("#tanggal_lahir").focus()
      }else if (jk == null) {
        toastnya('Jenis Kelamin  Harus Terpilih')
        $("#jk").focus()
      }else if (agama == null) {
        toastnya('Agama  Harus Terpilih')
        $("#agama").focus()
      }else if (status == null) {
        toastnya('Status  Harus Terpilih')
        $("#status").focus()
      }else if (pendidikan == null){
        toastnya('Pendidikan  Harus Terpilih')
        $("#pendidikan").focus()
      }else if (alamat == '') {
        toastnya('Alamat Harus Terisi')
        $("#alamat").focus()
      }else if (jabatan == '') {
        toastnya('Jabatan Harus Terisi')
        $("#jabatan").focus()
      }else{
        console.log('jalanakan')
      }
        let	data = getFormData($("#sini_form").serializeArray())
        $.ajax({
          url: url+"api_server/karyawan",
          type: 'post',
          data: {data : data},
          beforeSend: function(res) {
                               
            block_ui()
          },
          success:  function  (response) {
            $.unblockUI();
            console.log(response)
            // $('#sini_form')[0].reset();
            // document.getElementById('head_div_pendaftaran_pembeli').click()
            swal({
              title : "Sukses",
              text:  "NIK "+nik_karyawan+" suskes didaftar dalam sistem ",
              icon: "success",
              buttons: {
                cancel: false,
                confirm: true,
              },
              timer : 3000
              // dangerMode: true,
            })
            

                
            
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            // console.log(errorThrown)
            bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,'nik_karyawan')
            $.unblockUI();
            
           
          } 
        });
    }
  </script>

</body>
</html>