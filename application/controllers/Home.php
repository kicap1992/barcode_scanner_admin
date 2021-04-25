<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');
	}
	
	function index()
	{
    if ($this->input->post('proses') == 'login') {
      $data = $this->model->serialize($this->input->post('data'));
      // print_r($data);
      // $cek_data = $this->model->custom_query("SELECT * FROM tb_login_admin_staff a join tb_admin b on a.nik_admin = b.nik_admin where a.username = '".$data['username']."' and a.password = '".$data['password']."'")->result();
      $cek_data = $this->model->tampil_data_where('tb_login_admin_staff',array('username' => $data['username'] , 'password' => $data['password']))->result() ;
      if (count($cek_data) > 0) {
        switch ($cek_data[0]->level) {
          case 'superadmin':
            
            $this->session->set_userdata(['level' => $cek_data[0]->level]);
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(array("res" => "ok")));
            break;

          case 'admin':
          	$cek_data = $this->model->custom_query("SELECT * FROM tb_login_admin_staff a join tb_admin b on a.nik_admin = b.nik_admin where a.username = '".$data['username']."' and a.password = '".$data['password']."'")->result();
            
            $this->session->set_userdata(['nik_admin' => $cek_data[0]->nik_admin , 'level' => $cek_data[0]->level, 'id_pengembang' => $cek_data[0]->id_pengembang]);
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(array("res" => "ok", 'level' => $cek_data[0]->level)));
            break;
          
          case 'staff':
            $cek_data = $this->model->tampil_data_where('tb_staff', ['nik_staff' => $cek_data[0]->nik_staff])->result();
						$this->session->set_userdata(['nik_staff' => $cek_data[0]->nik_staff , 'level' => 'staff', 'id_pengembang' => $cek_data[0]->id_pengembang]);
            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(array("res" => "ok", 'level' => 'staff')));
            break;
        }
      }
      else
      {
        $this->output->set_status_header(400)->set_content_type('application/json')->set_output(json_encode(array("res" => "gagal")));
      }
    }
    else
    {
      $this->load->view('home/login');
    }
		
	}


	// function login()
	// {
		// $request = $this->input->server('REQUEST_METHOD');

		// if ($request == "POST") {
		// 	if ($this->input->post("proses") == "login") {
		// 		$data = $this->model->serialize($this->input->post('data'));		
		// 		$result = $this->model->tampil_data_where('tb_user',$data)->result();
		// 		if (count($result) > 0) {
		// 			$this->session->set_userdata('login', array("level" => "admin" , "nik" => $result[0]->nik));
		// 			// print_r("data ada");
		// 			$this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(array("res" => "ok")));
		// 		}else{
		// 			$this->output->set_status_header(400)->set_content_type('application/json')->set_output(json_encode(array("res" => "gagal")));
		// 		}
		// 	}
		// 	else
		// 	{
		// 		$this->output->set_status_header(502)->set_content_type('application/json')->set_output(json_encode(array("res" => "gagal")));
		// 	}
				
		// }	
		// elseif ($request == "GET") {
		// 	print_r($this->input->get("nik"));
		// 	$username = $this->input->post('username');
		// 	print_r($this->input->post("nik"));
		// }
		// elseif ($request == "PUT") {
		// 	// $nik = $_POST['nik'];
		// 	$username = $this->input->post('nik');
		// 	$password = $this->input->post('password');
		// 	print_r($username);
		// }
		// else
		// {
		// 	$this->load->view('home/login');
		// }

	// 	$this->load->view('home/login');
    
	// }


  // function daftar(){
  //   $request = $this->input->server('REQUEST_METHOD');
  //   if ($request == "POST") {
  //     $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(array("res" => "ok")));        
  //   } 
  //   else
  //   {
  //     // redirect('/home');
  //     print_r("sini kawasan larangan");
  //   }
  // }
	



	
}
?>