<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');
		$this->load->model('m_tabel_ss');

		if ($this->session->userdata('level') == 'admin') {
      // redirect('/home');
    }
    else
    {
      $this->session->unset_userdata(array('nik_admin','nik_staff','level'));
      redirect('/login');
    }
	}

	function index(){
		// print_r('sini home');
		$main['header'] = 'Halaman Utama Admin';
		
		$this->load->view('home/index', $main);
		
	}

	function karyawan(){
		// print_r('sini home');
		if ($this->input->post('proses') == "table_karyawan") {
      $list = $this->m_tabel_ss->get_datatables(array('nik_karyawan','nama'),array(null, 'nik_karyawan','nama',null),array('nik_karyawan' => 'desc'),"tb_karyawan",null,null,"*");
      $data = array();
      $no = 0;
      foreach ($list as $field) {
        
        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $field->nik_karyawan;
        $row[] = $field->nama;
        $row[] = '<center><button type="button" onclick="detail_karyawan('.$field->nik_karyawan.')" class="btn btn-primary btn-circle btn-sm waves-effect waves-light"><i class="ico fa fa-edit"></i></button></center>';
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_karyawan",null,null,"*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('nik_karyawan','nama'),array(null, 'nik_karyawan','nama',null),array('nik_karyawan' => 'desc'),"tb_karyawan",null,null,"*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }

		else{
			$main['header'] = 'Halaman Karyawan';
			
			$this->load->view('home/menu/karyawan', $main);
		}

		
		
	}



	function laporan($tahun = null, $bulan = null){
		if ($this->input->post('proses') == "table_all") {
      $list = $this->m_tabel_ss->get_datatables(array('bulan','tahun'),array('tahun','bulan',null),array('id_absensi' => 'desc'),"tb_absensi",null,null,"*");
      $data = array();
      $no = 0;
      foreach ($list as $field) {
      
        $no++;
        $row = array();
        $row[] = $this->model->bulan($field->bulan);
        $row[] = $field->tahun;
        $row[] = '<center><a href="'.base_url().'home/laporan/'.$field->tahun.'/'.$field->bulan.'"><button type="button" class="btn btn-primary btn-circle btn-sm waves-effect waves-light"><i class="ico fa fa-edit"></i></button></a></center>';
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_absensi",null,null,"*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('bulan','tahun'),array('tahun','bulan',null),array('id_absensi' => 'desc'),"tb_absensi",null,null,"*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }

    else if ($tahun != null) {
      if (is_numeric($tahun) and is_numeric($bulan)) {
        $cek_data = $this->model->tampil_data_where('tb_absensi',['tahun' => $tahun,'bulan' => $bulan])->result();

        if (count($cek_data) > 0) {
          
        }else{
          redirect('/home/laporan');
        }

      }else{
        redirect('/home/laporan');
      }
    }

		else{
      $main['header'] = 'Halaman Laporan Absensi';
      
      $this->load->view('home/menu/laporan', $main);
    }
		
	}
	
	
	function logout()
  {
    // $this->session->unset_userdata('penyuluh');
    $this->session->unset_userdata(array('nik_staff','nik_staff','level'));
    // $this->session->set_flashdata('success', '<b>Anda Berhasil Logout</b><br>Terima Kasih Telah Menggunakan Sistem Ini');
    redirect('/login');
  }


  function try2(){
    $cek_absensi = $this->model->tampil_data_where('tb_absensi',['bulan' => 4,'tahun' => 2021])->result();
    $array_absensi = json_decode($cek_absensi[0]->detail,true);
    foreach ($array_absensi as $key => $value) {
      if($value['tanggal'] == 29){
        foreach ($value['absensi'] as $key1 => $value1) {
          if($value1['nik_karyawan'] == 56465456465465 ){
            if ($value1['jam_keluar'] == '-') {
              $array_absensi[$key]['absensi'][$key1] = array(
                'nik_karyawan' => 56465456465465 ,
                'jam_masuk' => "21:32:50",
                'jam_keluar' => "23:32:50",
              );
            }
          }
        }
      }

      
    }
    print_r($array_absensi);
  }
	


	
}
?>