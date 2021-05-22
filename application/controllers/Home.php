<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');
		$this->load->model('m_tabel_ss');
    $this->load->library('pdf');

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
        $row[] = '<center><button type="button" onclick="detail_karyawan('.$field->nik_karyawan.','."'".$field->nama."'".')" class="btn btn-primary btn-circle btn-sm waves-effect waves-light"><i class="ico fa fa-edit"></i></button> <button type="button" onclick="qrcode_karyawan('.$field->nik_karyawan.')" class="btn btn-info btn-circle btn-sm waves-effect waves-light"><i class="ico fa fa-qrcode"></i></button></center>';
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

  function libur($nik_karyawan = null){
    if ($this->input->post('proses') == 'table_libur_detail') {
      $i = 1;
      $cek_data = $this->model->tampil_data_where('tb_karyawan',['nik_karyawan' => $this->input->post('nik_karyawan')])->result();
     
      
      if(count($cek_data) > 0){
        $ket = ($cek_data[0]->detail != null) ? json_decode($cek_data[0]->detail,true) : null;
        
        if ($ket != null) {
          foreach ($ket as $key => $value) {
            $day = explode("-",$value['tanggal']);
            $hari = date('l', strtotime($value['tanggal']));

            // $data[$i]['no'] = $i;
            $data[$i]['tanggal'] = $day[2].'-'.$day[1].'-'.$day[0];
            $data[$i]['hari'] = $this->model->hari($hari);
            $data[$i]['keterangan'] = $value['ket'];
            // $data[$i]['ket'] = 'Rp. '. number_format($value['simpanan']);
            // $data[$i]['foto'] = $value['foto'];

            $i++;
            
          }
          $data = array_reverse($data, true);
          $out = array_values($data);
          echo json_encode($out);
        }else{
          echo json_encode(array());
        }
          
      }
      else
      {
        echo json_encode(array());
      }
    }else{
      $main['header'] = "Halaman Pengaturan Libur";
      $this->load->view('home/menu/libur', $main);
    }
      

  }


	function laporan($tahun = null, $bulan = null){
    $main['header'] = 'Halaman Laporan Absensi';

    if ($this->input->post('proses') == 'table_absensi_detail_tanggal') {
      $i = 1;
      $cek_data = $this->model->tampil_data_where('tb_absensi',['bulan' => $this->input->post('bulan'), ' tahun' => $this->input->post('tahun')])->result();
     
      
      if(count($cek_data) > 0){
        $ket = json_decode($cek_data[0]->detail,true);
        $ket_detail = null;
        
        /// atur kembali array berdasarkan tanggal
        foreach ($ket as $key => $value) {

          if ($value['tanggal'] == $this->input->post('tanggal')) {
            # code...
            $ket_detail = $value['absensi'];
            break;
          }          
        }

        $cek_karyawan = $this->model->tampil_data_keseluruhan('tb_karyawan')->result_array();

        foreach ($cek_karyawan as $key => $value) {
          $hadir = false;
          $jam_masuk = 'Tidak Masuk Kerja';
          $jam_keluar = 'Tidak Masuk Kerja';
          foreach ($ket_detail as $key1 => $value1) {
            if ($value['nik_karyawan'] == $value1['nik_karyawan']) {
              $jam_masuk = $value1['jam_masuk'];
              $jam_keluar = $value1['jam_keluar'];
              $hadir = true;
              break;
            }
          }

               
          if($hadir != true){
            $cek_libur = ($value['detail'] != null) ? json_decode($value['detail'],true) : $value['detail'] ;

            if ($cek_libur != null) {
              foreach ($cek_libur as $key1 => $value1) {
                if ($value1['tanggal'] == $this->input->post('tahun').'-'.$this->input->post('bulan').'-'.$this->input->post('tanggal')) {
                  $jam_masuk = 'Ambil Cuti';
                  $jam_keluar = 'Ket : '.$value1['ket'];
                  break;
                }
              }
            }

            elseif ($value['tanggal_daftar'] > $this->input->post('tahun').'-'.$this->input->post('bulan').'-'.$this->input->post('tanggal')) {
              $jam_masuk = 'Belum Masuk Kerja';
              $jam_keluar = 'Belum Masuk Kerja';
            }

          }

          $data[$i]['nik_karyawan'] = $value['nik_karyawan'];
          $data[$i]['nama'] = $value['nama'];
          $data[$i]['jam_masuk'] = $jam_masuk;
          $data[$i]['jam_keluar'] = $jam_keluar;
          $i++;     
        }

        // foreach ($ket_detail as $key => $value) {

        //   $data[$i]['nik_karyawan'] = $value['nik_karyawan'];
        //   $data[$i]['jam_masuk'] = $value['jam_masuk'];
        //   $data[$i]['jam_keluar'] = $value['jam_keluar'];
        //   $i++;       
        // }

        // $data = array_reverse($data, true);
        $out = array_values($data);
        echo json_encode($out);
      }
      else
      {
        echo json_encode(array());
      }
    }

    elseif ($this->input->post('proses') == 'table_absensi_detail') {
      $i = 1;
      $cek_data = $this->model->tampil_data_where('tb_absensi',['bulan' => $this->input->post('bulan'), ' tahun' => $this->input->post('tahun')])->result();
     
      
      if(count($cek_data) > 0){
        $ket = json_decode($cek_data[0]->detail,true);
        
        /// atur kembali array berdasarkan tanggal
        foreach ($ket as $key => $value) {
          $day = date('l', strtotime($this->input->post('tahun').'-'.$this->input->post('bulan').'-'.$value['tanggal']));

          // $data[$i]['no'] = $i;
          $data[$i]['tanggal'] = $value['tanggal'].'-'.$this->input->post('bulan').'-'.$this->input->post('tahun');
          $data[$i]['hari'] = $this->model->hari($day);
          // $data[$i]['ket'] = 'Rp. '. number_format($value['simpanan']);
          // $data[$i]['foto'] = $value['foto'];

          $i++;
          
        }
        $data = array_reverse($data, true);
        $out = array_values($data);
        echo json_encode($out);
      }
      else
      {
        echo json_encode(array());
      }
    }

		elseif ($this->input->post('proses') == "table_all") {
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
          $main['tahun'] = $tahun;
          $main['bulan'] = $bulan;
          $this->load->view('home/menu/laporan_detail', $main);
          
        }else{
          redirect('/home/laporan');
        }

      }else{
        redirect('/home/laporan');
      }
    }

		else{
      
      
      $this->load->view('home/menu/laporan', $main);
    }
		
	}
	
  function notifikasi(){
    $cek_data = $this->model->tampil_data_keseluruhan('tb_notifikasi')->result();

    if (count($cek_data) > 0) {
      $main['no_telpon'] = $cek_data[0]->no_telpon;
    }else{
      $main['no_telpon'] = '';
    }

    $main['header'] = 'Halaman No Notifikasi';
    $this->load->view('home/menu/notifikasi', $main);
  }

  function cetak($tahun = null, $bulan = null){
    if (is_numeric($bulan) && is_numeric($tahun)) {
      $cek_data = $this->model->tampil_data_where('tb_absensi',['bulan' => $bulan, 'tahun' => $tahun])->result();
      // print_r($b)

      if (count($cek_data) > 0) {
        
        $pdf = new TCPDF('p', 'mm', 'LEGAL', false, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        // $pdf->SetFont('Arial','I',16);

        $html = '
          <style>
            
            .ini {
              border-bottom: 1px dotted black;
            }

            .ada  {
              border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;
            }

            .tiada {
              border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;
            }

            .tiada1 {
              border-left: 1px solid black;border-right: 1px solid black;
            }
      
          </style>
          <table width="100%" style="font-size: 12px;">         
            <tr>
              <td width="15%"></td>
              <td width="70%" align="center" style="font-size: 13px;font-weight:bold" class="ini">LAPORAN ABSENSI TAHUN '.$tahun.' , BULAN '.strtoupper($this->model->bulan($bulan)).'</td>
              <td width="15%"></td>
            </tr>         
          </table>
          <div></div>
          
          
        ';

        $array_absensi = json_decode($cek_data[0]->detail, true);

        $cek_karyawan = $this->model->tampil_data_keseluruhan('tb_karyawan')->result_array();

        foreach ($array_absensi as $key => $value) {
          $html .= '<table width="100%" style="font-size: 11px;">         
              <tr>
                <td width="35%" align="left" style="font-weight:bold" class="ini">Absensi Tanggal '.$value['tanggal']. ', Hari '.$this->model->hari(date('l', strtotime($tahun.'-'.$bulan.'-'.$value['tanggal']))).'</td>
                <td width="65%"></td>
              </tr>         
            </table>
            
            <table width="100%" border="1" style="font-size: 11px;">         
              <tr style="font-weight:bold">
                <td>NIK </td>
                <td>Nama </td>
                <td>Jam Masuk </td>
                <td>Jam Keluar </td>
              </tr>
            
           
          ';

          $ket_detail = $value['absensi'];
          foreach ($cek_karyawan as $key2 => $value2) {
            $hadir = false;
            $jam_masuk = 'Tidak Masuk Kerja';
            $jam_keluar = 'Tidak Masuk Kerja';
            foreach ($ket_detail as $key1 => $value1) {
              if ($value2['nik_karyawan'] == $value1['nik_karyawan']) {
                $jam_masuk = $value1['jam_masuk'];
                $jam_keluar = $value1['jam_keluar'];
                $hadir = true;
                break;
              }
            }
  
                 
            if($hadir != true){
              $cek_libur = ($value2['detail'] != null) ? json_decode($value2['detail'],true) : $value2['detail'] ;
  
              if ($cek_libur != null) {
                foreach ($cek_libur as $key1 => $value1) {
                  if ($value1['tanggal'] == $this->input->post('tahun').'-'.$this->input->post('bulan').'-'.$this->input->post('tanggal')) {
                    $jam_masuk = 'Ambil Cuti';
                    $jam_keluar = 'Ket : '.$value1['ket'];
                    break;
                  }
                }
              }
  
              elseif ($value2['tanggal_daftar'] > $this->input->post('tahun').'-'.$this->input->post('bulan').'-'.$this->input->post('tanggal')) {
                $jam_masuk = 'Belum Masuk Kerja';
                $jam_keluar = 'Belum Masuk Kerja';
              }
  
            }
  
            
            $html .= '<tr>
                  <td>'.$value2['nik_karyawan'].'</td>
                  <td>'.$value2['nama'].'</td>
                  <td>'.$jam_masuk.'</td>
                  <td>'.$jam_keluar.'</td>
                </tr>
              ';
          }

          

          $html.=' </table><div></div>';
        }

        // print_r($array_absensi);

        // $pdf->SetLineWidth(0.2);
        // $pdf->Rect(127,232,23,6);
        
        

        // $pdf->WriteHTML($html, true, 0, true, 0);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output();

      }else{
        redirect('/home/laporan');
      }
      // print_r('jalankan');
    }else{
      redirect('/home/laporan');
    }
  }

  function print_id_karyawan($nik_karyawan = null)
	{
		// print_r($this->uri->segment(3));

    if ($nik_karyawan != null) {
      $cek_data = $this->model->tampil_data_where('tb_karyawan',array('nik_karyawan' => $nik_karyawan))->result();
      if (count($cek_data) > 0) {
        $this->model->qrcode_karyawan($nik_karyawan);
        $pdf = new TCPDF('P','mm',array(80,60));
        $pdf->setPrintHeader(false);
        $pdf->AddPage();
        // $pdf->Image(base_url('images/karyawan/'.$nik_karyawan.'.png'),5,7,30);

        $html = '
          <style>
            
            .ini {
              border-bottom: 1px dotted black;
            }

            .ada  {
              border-left: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;
            }

            .tiada {
              border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;
            }

            .tiada1 {
              border-left: 1px solid black;border-right: 1px solid black;
            }
      
          </style>
          <table width="100%" style="font-size: 10px;">         
            <tr>
              <td width="15%"></td>
              <td width="70%" align="center"><img src="'.base_url().'images/karyawan/'.$nik_karyawan.'.png" ></td>
              <td width="15%"></td>
            </tr> 
            <tr>
              <td width="15%"></td>
              <td width="70%" align="center">'.$cek_data[0]->nama.'</td>
              <td width="15%"></td>
            </tr>         
          </table>
        ';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->output();
      }else{
        redirect('/home');
      }
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
    if('2021-04-01' > '2021-04-07'){
      print_r('tanggal lebih besar');
    }else{
      print_r('tanggal lebih kecil');
    }
  }
	


	
}
?>