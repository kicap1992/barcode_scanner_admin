<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Aplikasi Absensi Barcode Karyawan</title>
	<link rel="stylesheet" href="<?=base_url()?>assets/styles/style.min.css">

	<!-- Waves Effect -->
	<link rel="stylesheet" href="<?=base_url()?>assets/plugin/waves/waves.min.css">

  <link rel="stylesheet" href="<?=base_url()?>assets/sweet-alert/sweetalert.css">
  <style type="text/css">
    .swal-modal .swal-text {
      text-align: center;
    }
  </style>

</head>

<body>

<div id="single-wrapper">
	<form class="frm-single" id="sini_form">
		<div class="inside">
			<!-- <div class="title"><strong>Ninja</strong>Admin</div> -->
      <h4 style="text-align: center;">Halaman <br> <strong>Admin</strong></h4>
			<!-- /.title -->
			<div class="frm-title">Login</div>
			<!-- /.frm-title -->
			<div class="frm-input"><input type="text" placeholder="Username" class="frm-inp" id="username" name="username"><i class="fa fa-user frm-ico"></i></div>
			<!-- /.frm-input -->
			<div class="frm-input"><input type="password" placeholder="Password" class="frm-inp" id="password" name="password"><i class="fa fa-lock frm-ico"></i></div>
			<!-- /.frm-input -->
			<!-- /.clearfix -->
			<button type="button" class="frm-submit" onclick="login()">Login<i class="fa fa-arrow-circle-right"></i></button>
			
			<!-- <a href="page-register.html" class="a-link"><i class="fa fa-key"></i>New to NinjaAdmin? Register.</a> -->
			<div class="frm-footer">Kicap Karan © 2021.</div>
			<!-- /.footer -->
		</div>
		<!-- .inside -->
	</form>
	<!-- /.frm-single -->
</div><!--/#single-wrapper -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/script/html5shiv.min.js"></script>
		<script src="<?=base_url()?>assets/script/respond.min.js"></script>
	<![endif]-->
	<!-- 
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?=base_url()?>assets/scripts/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/scripts/modernizr.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/plugin/nprogress/nprogress.js"></script>
	<script src="<?=base_url()?>assets/plugin/waves/waves.min.js"></script>


  <script src="<?=base_url()?>assets/sweet-alert/sweetalert.js"></script>
  <script src="<?=base_url()?>assets/sweet-alert/toastr/toastr.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/sweet-alert/toastr/toastr.min.css">
	<script src="<?=base_url()?>assets/scripts/main.min.js"></script>
  <script src="<?=base_url()?>assets/sweet-alert/block/jquery.blockUI.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/url.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/js/main.js"></script>

	<script>
		function login(){
			const username = $("#username").val();
			const password = $("#password").val();

			if (username == '') {
				toastnya('Username Harus Terisi');
				$("#username").focus();
			}else if (password == '') {
				toastnya('Password Harus Terisi');
				$("#password").focus();
			}else{
				// console.log('jalankan');
				let data = $("#sini_form").serializeArray();
				data = getFormData(data)
				// console.log(data);

				$.ajax({
					url: url+"api_server/login",
					type: 'get',
					data: data,
					beforeSend: function(res) {
						block_ui()
					},
					success:  function  (response) {
						$.unblockUI();
						console.log(response)
						swal({
							title : "Success",
							text:  "Selamat Kembali",
							icon: "success",
							buttons: {
								cancel: false,
								confirm: false,
							},
							timer : 1500
							// dangerMode: true,
						})
						.then((hehe) =>{
							window.location.replace(url+'state_')
						});
						
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { 
						bad_request(errorThrown,JSON.parse(XMLHttpRequest.responseText).message,'username')
						// console.log(errorThrown)
						// console.log(JSON.parse(XMLHttpRequest.responseText).message)
						$.unblockUI();
						
					
					} 
				});

			}
		}
	</script>
</body>
</html>