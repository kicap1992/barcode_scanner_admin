<?php
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
// header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
// header('Access-Control-Allow-Credentials: true');
// header('Content-Type: application/json');

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api_server extends RestController
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('model');;
    date_default_timezone_set("Asia/Kuala_Lumpur");
    // $this->db->query("SET sql_mode = '' ");
    
  }

  public function index_get()
  {

    $this->response(['message' => 'Halo Bosku'], 200);
    // print_r()
    // redirect(base_url());

  }
  // -----------------------------------------------------------------------------------------------------------


  function login_get(){
    $username = $this->get('username');
    $password = md5($this->get('password'));

    $data = $this->model->tampil_data_where('tb_login',['username' => $username , 'password' => $password])->result();

    if (count($data) > 0) {
      if ($data[0]->level == 'admin') {
        $this->session->set_userdata('level','admin');
        $this->response(['message' => 'ok'], 200);
      }elseif ($data[0]->level == 'karyawan') {
        $this->session->set_userdata('level','karyawan');
        $this->response(['message' => 'ok'], 200);
      }
    }else{
      $this->response(['message' => 'Username dan Password Salah'], 401);
    }
    
  }

  function karyawan_post(){
    $data = $this->post('data');
    $cek_data = $this->model->tampil_data_where('tb_karyawan' ,['nik_karyawan' => $data['nik_karyawan']])->result();
    
    if(count($cek_data) > 0){
      $this->response(['message' => 'NIK <i>'.$data['nik_karyawan'].'</i> telah terdaftar dalam sistem sebelumnya'], 400);
    }else{
      $this->model->insert('tb_karyawan',$data);
      $this->model->insert('tb_login',['username' => $data['nik_karyawan'],'password' => md5($data['nik_karyawan'])]);
      $this->response(['message' => 'ok'], 200);
    }
    
  }

  function karyawan_get(){
    $nik_karyawan = $this->get('nik_karyawan');
    $cek_data = $this->model->tampil_data_where('tb_karyawan' ,['nik_karyawan' => $nik_karyawan])->result();
    
    if(count($cek_data) > 0){
      $this->response(['message' => 'sini ada','data' => $cek_data], 200);
    }else{
      $this->response(['message' => 'tiada data'], 401);
    }
    
  }

  function karyawan_put(){
    $where = $this->put('where');
    $data = $this->put('data');
    $cek_data = $this->model->tampil_data_where('tb_karyawan' ,$where)->result();
    
    if(count($cek_data) > 0){
      $this->model->update('tb_karyawan',$where,$data);
      $this->response(['message' => 'ok'], 200);
    }else{
      $this->response(['message' => 'tiada data'], 401);
    }
    
  }

  function karyawan_delete(){
    $where = $this->delete('where');
    // $data = $this->put('data');
    $cek_data = $this->model->tampil_data_where('tb_karyawan' ,$where)->result();
    
    if(count($cek_data) > 0){
      $this->model->delete('tb_karyawan',$where);
      $this->response(['message' => 'ok',$where], 200);
    }else{
      $this->response(['message' => 'tiada data'], 401);
    }
    
  }

  function libur_put(){
    $where = $this->put('where');
    $detail = $this->put('detail');

    $cek_data = $this->model->tampil_data_where('tb_karyawan',$where)->result();
    $detail_libur = $cek_data[0]->detail;

    if ($detail_libur == null) {
      $this->model->update('tb_karyawan',$where,$detail);
      $this->response(['message' => 'ok'], 200);
    }else{
      $detail_libur = json_decode($detail_libur,true);
      $array_libur = json_decode($detail['detail'],true);
      $ada_tanggal_sama = false;
      $tanggal_sama = null;

      foreach ($detail_libur as $key => $value) {
        $ko = false;
        foreach ($array_libur as $key1 => $value1) {
          if($value['tanggal'] == $value1['tanggal']){
            $tanggal_sama =$value1['tanggal'];
            $ko = true;
            break;
          }
        }

        if ($ko == true) {
          $ada_tanggal_sama = true;
          break;
        }
      }

      if ($ada_tanggal_sama == false) {
        $detail_libur = array_merge($detail_libur,$array_libur);
        $this->model->update('tb_karyawan',$where,['detail' => json_encode($detail_libur)]);
        $this->response(['message' => $detail_libur], 200);
      }else{
        $this->response(['message' => 'Libur pada tanggal '.$tanggal_sama.' telah diatur sebelumnya <br>Sila periksa log libur dibawah untuk info lebih lanjut'], 400);
      }

      
    }
    

    
  }


  function login_petugas_get(){
    $username = $this->get('username');
    $password = $this->get('password');

    $cek_data = $this->model->tampil_data_where('tb_login',['username' => $username , 'password' => md5($password), 'level' => 'petugas'])->result();

    if (count($cek_data) > 0) {
      $this->response(['username' => $username, 'password' => $password, 'level' => 'petugas'], 200);
    }else{
      $this->response(['message' => 'Username dan Password Salah'], 401);
    }
    
  }
  

  function cek_karyawan_by_qrcode_get(){
    $nik = $this->get('nik');
    $cek_data = $this->model->tampil_data_where('tb_karyawan',['nik_karyawan' => $nik])->result();

    if (count($cek_data) > 0) {      
      $cek_absensi = $this->model->tampil_data_where('tb_absensi',['bulan' => date('m'),'tahun' => date('Y')])->result();
      if(count($cek_absensi) > 0){
        $array_absensi = json_decode($cek_absensi[0]->detail,true);
        $tanggal_ada = false;
        $nik_ada = false;
        $key_array = null;
        $key_detail = null;
        $jam_keluar = false;
        foreach ($array_absensi as $key => $value) {
          if($value['tanggal'] == date('d')){
            $tanggal_ada = true;
            $key_array = $key;
            foreach ($value['absensi'] as $key1 => $value1) {
              if($value1['nik_karyawan'] == $nik ){
                $nik_ada = true;
                $key_detail = $key1;
                if($value1['jam_keluar'] != '-'){
                  $jam_keluar = true;
                }
              }
            }
          }
        
          
        }

        if ($jam_keluar == true){
          $this->response(['message' => $cek_data[0]->nama.' telah diabsensi masuk kerja dan pulang kerja pada hari ini'], 401);
        }
        elseif ($nik_ada == true) {
          $this->response(['message' => 'ok','nama' => $cek_data[0]->nama,'nik' => $cek_data[0]->nik_karyawan, 'tanggal' => date('d-m-Y'), "jam_masuk" =>  $array_absensi[$key_array]['absensi'][$key_detail]['jam_masuk'], "jam_keluar" => date('H:i:s')], 200);
        }else{
          $this->response(['message' => 'ok','nama' => $cek_data[0]->nama,'nik' => $cek_data[0]->nik_karyawan, 'tanggal' => date('d-m-Y'), "jam_masuk" => date('H:i:s'), "jam_keluar" => '-' ], 200);
        }
        // $this->response(['message' => $nik_ada], 200);
      }else{
        $this->response(['message' => 'ok','nama' => $cek_data[0]->nama,'nik' => $cek_data[0]->nik_karyawan, 'tanggal' => date('d-m-Y'), "jam_masuk" => date('H:i:s'), "jam_keluar" => '-'], 200);
      }
      
    }else{
      $this->response(['message' => 'Belum Melakukan Scan atau QRCode yang discan tiada dalam sistem'], 404);
    }

    
  }

  function absensi_karyawan_post(){
    $nik_karyawan = $this->post('nik_karyawan');
    $jam_masuk = $this->post('jam_masuk');
    $jam_keluar = $this->post('jam_keluar');
    $tanggal = explode("-", $this->post('tanggal'));

    $cek_absensi = $this->model->tampil_data_where('tb_absensi',['bulan' => $tanggal[1], 'tahun' => $tanggal[2]])->result();

    $array = array(array(
      'tanggal' => $tanggal[0],
      'absensi' => array(
        array(
          'nik_karyawan' => $nik_karyawan,
          'jam_masuk' => $jam_masuk,
          'jam_keluar' => $jam_keluar,
        )
      )
    ));

    if (count($cek_absensi) > 0) {
      $array_absensi = json_decode($cek_absensi[0]->detail,true);
      $tanggal_ada = false;
      $nik_ada = false;
      $key_array = null;
      $key_detail = null;
      // $jam_keluar = false;
      foreach ($array_absensi as $key => $value) {
        if($value['tanggal'] == date('d')){
          $tanggal_ada = true;
          $key_array = $key;
          foreach ($value['absensi'] as $key1 => $value1) {
            if($value1['nik_karyawan'] == $nik_karyawan ){
              $nik_ada = true;
              $key_detail = $key1;
            }
          }
        }
      
        
      }

      if ($nik_ada == true) {
        $array_absensi[$key_array]['absensi'][$key_detail] = array(
          'nik_karyawan' => $nik_karyawan,
          'jam_masuk' => $jam_masuk,
          'jam_keluar' => $jam_keluar,
        );

        $this->model->update('tb_absensi',['bulan' => $tanggal[1], 'tahun' => $tanggal[2]],['detail' => json_encode($array_absensi)]);
        $this->response(['message' => 'ini yang ada nik'], 200);

      }elseif ($tanggal_ada == true){
        $arraynya = $array_absensi[$key_array]['absensi'];
        $arraynya = array_merge($arraynya,array(array(
          'nik_karyawan' => $nik_karyawan,
          'jam_masuk' => $jam_masuk,
          'jam_keluar' => $jam_keluar,
        )));
        $array_absensi[$key_array]['absensi'] = $arraynya;
        $this->model->update('tb_absensi',['bulan' => $tanggal[1], 'tahun' => $tanggal[2]],['detail' => json_encode($array_absensi)]);
        $this->response(['message' => 'ini yang ada bulan'], 200);
      }else{
        $arraynya = array_merge($array_absensi,$array);
        $this->model->update('tb_absensi',['bulan' => $tanggal[1], 'tahun' => $tanggal[2]],['detail' => json_encode($arraynya)]);
        $this->response(['message' => 'ini yang tidak ada bulan'], 200);
      }
        
    }else{
      
      $this->model->insert('tb_absensi',['bulan' => $tanggal[1], 'tahun' => $tanggal[2],'detail' => json_encode($array)]);

      $this->response(['message' => $nik_karyawan, 'message1' => $jam_masuk,'message2' => $jam_keluar, 'message3' => $tanggal[1]], 200);
    }

    

  }

  function list_karyawan_get(){
    $cek_data = $this->model->tampil_data_keseluruhan_as('tb_karyawan','nik_karyawan,nama')->result();
    $this->response($cek_data, 200);
  }

}

