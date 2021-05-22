
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
      <input type="hidden" id="sini_no_telpon" value="<?=$no_telpon?>">
      <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="box-content card">
          <h4 class="box-title" style="background: #0055FF ;cursor: pointer;" onclick="myFunction('div_notifikasi')">No Telpon Notifikasi</h4>
          <!-- /.box-title -->
          <div class="card-content" style="overflow-x: auto;" id="div_notifikasi">
            <form id="sini_form">
              <div class="form-group">
                <label for="exampleInputEmail1">No Telpon Notifikasi</label>
                <input type="text" class="form-control"  id="no_telpon" name="no_telpon" placeholder="Masukkan No Telpon Notifikasi" maxlength="13" onkeypress="return isNumberKey(event)" value="<?=$no_telpon?>" >
              </div>


              <center><button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="tambah_notifikasi()">Tambah / Edit No Telpon</button></center>
            </form>
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

  <!-- <script src="<?=base_url()?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script> -->
  <!-- <script src="<?=base_url()?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script> -->
  
  <script async="">
    async function tambah_notifikasi(){
      
      let no_telpon = $("#no_telpon").val();

      if(no_telpon == ''){
        toastnya('Nomor Telpon Harus Terisi');
        $("#no_telpon").focus();
      }
      else if(no_telpon.length < 10){
        toastnya('Panjang Nomor Telpon Minimal 10 Karakter');
        $("#no_telpon").focus();
      }else{
        // console.log($("#sini_no_telpon").val())
        let ada_nom = ($("#sini_no_telpon").val() != '')  ? true : false

        

        swal({
          title : (ada_nom) ? `Update Nomor` : `Tambah Nomor`,
          text:  (ada_nom) ? `Update Nomor Notifkasi Dari ${$("#sini_no_telpon").val()} kepada ${no_telpon}` : `Tambah Nomor ${no_telpon}`,
          icon: "info",
          buttons: {
            cancel: false,
            confirm: true,
          },
          // timer : 3000
          // dangerMode: true,
        })
        .then((hehe) => {
          if (hehe) {
            $.ajax({
              url: url+"api_server/notifikasi",
              type: 'post',
              data: {no_telpon : no_telpon},
              beforeSend: function(res) {
                                  
                block_ui()
              },
              success: (response) => {
                console.log(response);
                $.unblockUI();
                $("#sini_no_telpon").val(no_telpon)
                swal({
                  title : "Sukses",
                  text:  "No Telpon Notifikasi Berhasil Ditambah / Diupdate ",
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
                bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,'no_telpon')
                $.unblockUI();
                
              
              } 
            });
          } 
        });

          
      }
      
    }
  </script>

</body>
</html>