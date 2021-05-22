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
        // console.log('jalanakan')
        let	data = getFormData($("#sini_form").serializeArray())
        $.ajax({
          url: url+"api_server/karyawan",
          type: 'post',
          data: {data : data},
          beforeSend: function(res) {
                               
            block_ui()
          },
          success:   function  (response) {
            $('#sini_form')[0].reset();
            $('#table_list_karyawan').dataTable().fnDestroy();
            datatables()
            $.unblockUI();
            
            // console.log(response)
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

            qrcode_karyawan(nik_karyawan)
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            // console.log(errorThrown)
            bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,'nik_karyawan')
            $.unblockUI();
            
           
          } 
        });
      }
        
    }

    function detail_karyawan(nik_karyawan,nama){
      // console.log(nik_karyawan)
      $.ajax({
        url: url+"api_server/karyawan",
        type: 'get',
        data: {nik_karyawan : nik_karyawan},
        beforeSend: function(res) {
                              
          block_ui()
        },
        success:  function  (response) {
          $.unblockUI();
          let data_karyawan = response.data[0];
          // console.log(data_karyawan)

          let html =  `<div class="row small-spacing">
            <div class="col-lg-12 col-xs-12">
              <form class="card-content" id="sini_form_detail" >
                <div class="form-group">
                  <label for="exampleInputEmail1">NIK Karyawan</label>
                  <input type="text" class="form-control"  id="nik_karyawan_detail" name="nik_karyawan" placeholder="Masukkan NIK Karyawan" maxlength="14" onkeypress="return isNumberKey(event)" disabled="" value="${data_karyawan.nik_karyawan}">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Nama Karyawan</label>
                  <input type="text" class="form-control" id="nama_detail" name="nama" placeholder="Masukkan Nama" disabled="" value="${data_karyawan.nama}">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Tempat Lahir</label>
                  <input type="text" class="form-control" id="tempat_lahir_detail" name="tempat_lahir" placeholder="Masukkan Tempat Lahir" disabled="" value="${data_karyawan.tempat_lahir}">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="tanggal_lahir_detail" name="tanggal_lahir" title="Masukkan Tanggal Lahir" disabled="" value="${data_karyawan.tanggal_lahir}">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Jenis Kelamin</label>
                  <select name="jk" id="jk_detail" class="form-control" title="Pilih Jenis Kelamin" disabled="">
                    <option value="" disabled selected>-Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Agama</label>
                  <select name="agama" id="agama_detail" class="form-control" title="Pilih Agama" disabled="">
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
                  <select name="status" id="status_detail" class="form-control" title="Pilih Status" disabled="">
                    <option value="" disabled selected>-Pilih Status</option>
                    <option value="Sudah Menikah">Sudah Menikah</option>
                    <option value="Belum Menikah">Belum Menikah</option>
                    <option value="Janda / Duda">Janda / Duda</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Pendidikan</label>
                  <select name="pendidikan" id="pendidikan_detail" class="form-control" title="Pilih Pendidikan" disabled="">
                    <option value="" disabled selected>-Pilih Pendidikan</option>
                    <option value="SMA">SMA dan sederajatnya</option>
                    <option value="D3">D3 dan Sederajatnya</option>
                    <option value="S1">S1 dan Sederajatnya</option>
                    <option value="S2">S2 dan Sederajatnya</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Alamat</label>
                  <textarea name="alamat" id="alamat_detail" class="form-control" style="resize: none;" placeholder="Masukkan Alamat" disabled="">${data_karyawan.alamat}</textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Jabatan</label>
                  <input type="text" class="form-control" id="jabatan_detail" name="jabatan" placeholder="Masukkan Jabatan" disabled="" value="${data_karyawan.jabatan}">
                </div>
                    
              </form>
              <!-- /.card-content -->
            </div>
          </div>`

          $("#sini_modalnya .modal-body").html(html)

          let select_jk = $("#jk_detail").children();
          select_jk.each(async function (k) {
            if (data_karyawan.jk == this.value) {
              $(this).attr("selected", "");
            }
          })

          let select_agama = $("#agama_detail").children();
          select_agama.each(async function (k) {
            if (data_karyawan.agama == this.value) {
              $(this).attr("selected", "");
            }
          })

          let select_status = $("#status_detail").children();
          select_status.each(async function (k) {
            if (data_karyawan.status == this.value) {
              $(this).attr("selected", "");
            }
          })

          let select_pendidikan = $("#pendidikan_detail").children();
          select_pendidikan.each(async function (k) {
            if (data_karyawan.pendidikan == this.value) {
              $(this).attr("selected", "");
            }
          })

          let footer = `<button type="button" class="btn btn-info btn-xs" id="button_edit_data" onclick="edit_data(1)">Edit Data ? </button> <button type="button" onclick="hapus_karyawan(${data_karyawan.nik_karyawan},'${data_karyawan.nama}')" class="btn btn-danger btn-xs">Hapus Karyawan</button>`
          $("#sini_modalnya .modal-footer").html(footer)

          $("#sini_modalnya .modal-header .modal-title").html("Detail Karyawan")
          $("#sini_modalnya .modal-dialog").attr('class','modal-dialog')
          $('#sini_modalnya').modal('show');
          // $('#sini_form')[0].reset();
          // document.getElementById('head_div_pendaftaran_pembeli').click()
          
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          // console.log(errorThrown)
          bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,null)
          $.unblockUI();
          
          
        } 
      });
    }

    async function edit_data(stat){
      switch (stat) {
        case 1:
          await $("#sini_form_detail *").prop("disabled", false);
          await $("#nik_karyawan_detail").attr('disabled' ,'');
          await $("#nama_detail").focus();
          await $("#button_edit_data").attr({
            'onclick' : 'edit_data(2)',
            class: "btn btn-success btn-xs"
          });
          await $("#button_edit_data").html("Edit Data")
          break;
      
        case 2:

          const nama = $("#nama_detail").val()
          const tempat_lahir = $("#tempat_lahir_detail").val()
          const tanggal_lahir = $("#tanggal_lahir_detail").val()
          const jk = $("#jk_detail").val()
          const agama = $("#agama_detail").val()
          const status = $("#status_detail").val()
          const pendidikan = $("#pendidikan_detail").val()
          const alamat = $("#alamat_detail").val()
          const jabatan = $("#jabatan_detail").val()

          if (nama == '') {
            toastnya('Nama Karyawan Harus Terisi')
            $("#nama_detail").focus()
          }else if (tempat_lahir == '') {
            toastnya('Tempat Lahir Karyawan Harus Terisi')
            $("#tempat_lahir_detail").focus()
          }else if (tanggal_lahir == '') {
            toastnya('Tanggal Lahir Karyawan Harus Terisi')
            $("#tanggal_lahir_detail").focus()
          }else if (jk == null) {
            toastnya('Jenis Kelamin  Harus Terpilih')
            $("#jk_detail").focus()
          }else if (agama == null) {
            toastnya('Agama  Harus Terpilih')
            $("#agama_detail").focus()
          }else if (status == null) {
            toastnya('Status  Harus Terpilih')
            $("#status_detail").focus()
          }else if (pendidikan == null){
            toastnya('Pendidikan  Harus Terpilih')
            $("#pendidikan_detail").focus()
          }else if (alamat == '') {
            toastnya('Alamat Harus Terisi')
            $("#alamat_detail").focus()
          }else if (jabatan == '') {
            toastnya('Jabatan Harus Terisi')
            $("#jabatan_detail").focus()
          }else{
            // console.log('jalanakan')
            let	data = getFormData($("#sini_form_detail").serializeArray())
            let where = {nik_karyawan : $("#nik_karyawan_detail").val()}
            // console.log(where);
            $.ajax({
              url: url+"api_server/karyawan",
              type: 'put',
              data: {data : data,where : where},
              beforeSend: function(res) {
                                  
                block_ui()
              },
              success:  function  (response) {
                $('#sini_form')[0].reset();
                $('#table_list_karyawan').dataTable().fnDestroy();
                datatables()
                $('#sini_modalnya').modal('hide');
                $.unblockUI();
                swal({
                  title : "Sukses",
                  text:  "Detail Karyawan Berhasil Diubah ",
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
                bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,null)
                $.unblockUI();
                
              
              } 
            });
          }
          
          break;
      }
    }

    async function hapus_karyawan(nik_karyawan,nama){
      swal({
        title : "Hapus Data ? ",
        text:  `Karyawan ${nama} akan terhapus dari sistem`,
        icon: "warning",
        buttons: {
          cancel: true,
          confirm: true,
        },
        dangerMode: true,
      })
      .then(async (hehe) =>{
        // console.log('jalankan');
        $.ajax({
          url: url+"api_server/karyawan",
          type: 'delete',
          data: {where : {nik_karyawan : nik_karyawan}},
          beforeSend: function(res) {
                              
            block_ui()
          },
          success:  function  (response) {
            $('#sini_form')[0].reset();
            $('#table_list_karyawan').dataTable().fnDestroy();
            datatables()
            $('#sini_modalnya').modal('hide');
            $.unblockUI();
            console.log(response)
            swal({
              title : "Sukses",
              text:  `Karyawan ${nama} Berhasil Dihapus Dari Sistem `,
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
            bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,null)
            $.unblockUI();
            
          
          } 
        });

      });
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