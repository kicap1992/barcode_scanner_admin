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
    if ($this->session->userdata('level') != 'Admin' && $this->session->userdata('level') != 'superadmin' && $this->session->userdata('level') != 'staff') {
    $this->session->unset_userdata(array('nik_admin','nik_staff','level'));
    redirect('/home');
    }
    else
    {
      if ($this->session->userdata('level') == 'Admin') {
        $cek_data = $this->model->tampil_data_where('tb_admin',array('nik_admin' => $this->session->userdata('nik_admin')))->result();
        if (count($cek_data) > 0) {
          # code...
        }
        else
        {
          $this->session->unset_userdata(array('nik_admin','nik_staff','level'));
          redirect('/home');
        }
      }
      elseif ($this->session->userdata('level') == 'staff') {
        $cek_data = $this->model->tampil_data_where('tb_staff',array('nik_staff' => $this->session->userdata('nik_staff')))->result();
        if (count($cek_data) > 0) {
          # code...
        }
        else
        {
          $this->session->unset_userdata(array('nik_admin','nik_staff','level'));
          redirect('/home');
        }
      }
        
    }
  }

  public function index_get()
  {

    $this->response(['message' => 'Halo Bosku'], 200);
    // print_r()
    // redirect(base_url());

  }
  // -----------------------------------------------------------------------------------------------------------

  public function bank_post()
  {
    $cek_data = $this->model->tampil_data_keseluruhan('tb_bank')->result();
    $this->response(['message' => 'ok' , 'bank' => $cek_data], 200);

  }

  public function bank_get()
  {
    // $cek_data = $this->model->tampil_data_keseluruhan('tb_bank')->result();
    $id_bank = $this->get('id_bank');
    $cek_data = $this->model->tampil_data_where('tb_bank',['id_bank' => $id_bank])->result();
    $this->response(['message' => 'ok' , 'bank' => $cek_data[0]], 200);

  }

  public function pembeli_post()
  {
    $data = $this->post('data');
    $data = $this->model->serialize($data);
    $data = array_merge($data, array('pendaftaran' => 'Web'));
    $username = $this->post('username');
    $password = $this->post('password');

    if ($data != null) {
      // $this->model->insert('tb_pembeli',$data);
      $cek_data = $this->model->tampil_data_where('tb_pembeli', array('nik_pembeli' => $data['nik_pembeli']))->result();

      if (count($cek_data) > 0) {
        $this->response(['message' => 'ada' ], 200);
      }
      else
      {
        $this->model->insert('tb_pembeli',$data);
        $this->model->insert('tb_login_pembeli',array('nik_pembeli' => $data['nik_pembeli'], 'username' => $username , 'password' =>$password, 'status' => 'ok'));
        $this->response(['message' => 'tiada' ], 200);
      }
    }
    else
    {
      $this->response(['message' => 'ko' ], 400);
    }
    
  }

  public function pembeli_get()
  {
    $nik_pembeli = $this->get('nik_pembeli');
    $cek_data = $this->model->tampil_data_where('tb_pembeli',['nik_pembeli' => $nik_pembeli])->result();
    if (count($cek_data) > 0) {
      $this->response(['message' => 'ada' , 'data' => $cek_data[0]], 200);
    }
    else
    {
      $this->response(['message' => 'tiada' ], 200);
    }
  }

  public function pembeli_put()
  {
    $nik_pembeli = $this->put('nik_pembeli');
    $data = $this->put('data');
    $data = $this->model->serialize($data);
    $this->model->update('tb_pembeli', array('nik_pembeli' => $nik_pembeli), $data);
    $this->response(['message' => 'ada' , 'data' => $data], 200);
  }

  public function pembeli_delete()
  {
    $nik_pembeli = $this->delete('nik_pembeli');
    // $data = $this->put('data');
    // $data = $this->model->serialize($data);
    $this->model->delete('tb_pembeli', array('nik_pembeli' => $nik_pembeli));
    $this->response(['message' => 'ada' , 'data' => $nik_pembeli], 200);
  }

  public function pembeliRumah_get()
  {
    $nik_pembeli = $this->get("nik_pembeli");
    $cek_data = $this->model->tampil_data_where('tb_pembelian_rumah',['nik_pembeli' => $nik_pembeli])->result();

    if (count($cek_data) > 0){
      $this->response(['message' => 'ok' ,'data' => $cek_data[0]], 200);
    }else{
      $this->response(['message' => 'ok' ,'data' => null], 200);
    }
    
  }


  public function pembelianRumah_post()
  {

    $detail_pembelian = $this->post("detail_pembelian");
    $detail_pembelian = $this->model->serialize($detail_pembelian);
    if($detail_pembelian['id_tipe'] == ''){
      unset($detail_pembelian['id_tipe']);
    }
    $ket = $detail_pembelian['ket'];
    unset($detail_pembelian['ket']);
    $cek_data = $this->model->tampil_data_where('tb_pembelian_rumah',['id_rumah' => $detail_pembelian['id_rumah'], 'id_area' => $detail_pembelian['id_area']])->result();
    if(count($cek_data) > 0){
      $this->model->update('tb_pembelian_rumah',['id_rumah' => $detail_pembelian['id_rumah'], 'id_area' => $detail_pembelian['id_area']],$detail_pembelian);
    }else{
      $this->model->insert('tb_pembelian_rumah',$detail_pembelian);
    }
    
    if($ket != ''){
      $array = array(
        array(
          'tanggal_update' => date("Y-m-d").' | '.date("h:i:sa"),
          'ket' => $ket
        )
      );
      // $this->model->update('tb_pembelian_rumah',array('id_area' => $detail_pembelian['id_area'] , 'id_rumah' => $detail_pembelian['id_rumah']), array('ket' => json_encode($array)));
      $cek_data = $this->model->tampil_data_where('tb_pembelian_rumah',array('id_area' => $detail_pembelian['id_area'] , 'id_rumah' => $detail_pembelian['id_rumah']))->result();
      if($cek_data[0]->ket != null or $cek_data[0]->ket != ''){
        $ketnya = json_decode($cek_data[0]->ket);
        $array = array_merge($ketnya,$array);
      }
      $this->model->update('tb_pembelian_rumah',array('id_area' => $detail_pembelian['id_area'] , 'id_rumah' => $detail_pembelian['id_rumah']), array('ket' => json_encode($array))); 
    }
    $this->response(['message' => 'ok'], 200);

  }

  public function pembelianRumahFix_get()
  {
    $where = $this->get("where");
    $cek_data = $this->model->tampil_data_where('tb_pembelian_rumah',$where)->result();

    if(count($cek_data) > 0) {
      $this->response(['message' => 'ok' ,'data' => $cek_data[0]], 200);
    }else{
      $this->response(['message' => 'ok' ,'data' => null], 200);
    }
    
    // if (count($cek_data) > 0){
    //   $this->response(['message' => 'ok' ,'data' => $cek_data[0]], 200);
    // }else{
    //   $this->response(['message' => 'ok' ,'data' => null], 200);
    // }
    
  }

  public function pembelianRumah_put()
  {

    $where = $this->put("where");
    $detail_pembelian = $this->put("detail_pembelian");
    $detail_pembelian = $this->model->serialize($detail_pembelian);
    $tipenya = $detail_pembelian['id_tipe'] ?? null;
    if ($tipenya != null) {
      if($detail_pembelian['id_tipe'] == ''){
        unset($detail_pembelian['id_tipe']);
      }
    }
      
    // $ket = $detail_pembelian['ket'];
    $ketnya = $detail_pembelian['ket'] ?? null;
    if ($ketnya != null) {
      unset($detail_pembelian['ket']);
    }
    
    $this->model->update('tb_pembelian_rumah',$where,$detail_pembelian);

    if ($ketnya != null) {
      if($detail_pembelian['ket'] != ''){
        $array = array(
          array(
            'tanggal_update' => date("Y-m-d").' | '.date("h:i:sa"),
            'ket' => $detail_pembelian['ket']
          )
        );
        // $this->model->update('tb_pembelian_rumah',array('id_area' => $detail_pembelian['id_area'] , 'id_rumah' => $detail_pembelian['id_rumah']), array('ket' => json_encode($array)));
        $cek_data = $this->model->tampil_data_where('tb_pembelian_rumah',$where)->result();
        if($cek_data[0]->ket != null or $cek_data[0]->ket != ''){
          $ketnya = json_decode($cek_data[0]->ket);
          $array = array_merge($ketnya,$array);
        }
        $this->model->update('tb_pembelian_rumah',$where, array('ket' => json_encode($array)));
      }
    }
    $this->response(['message' => 'ok' ], 200);
  }

  public function pembelianRumah_delete()
  {

    $where = $this->delete("where");
    $data = $this->delete("data");
    $data = $this->model->serialize($data);
    $detail = ['nik_pembeli' => null , 'id_bank' => null,'status' => null,'tanggal_booking' => null , 'tanggal_pembelian' => null, 'no_spr' => null, 'persyaratan' => null, 'tambahan_dp' => null, 'tanggal_akad_bayar' => null , "nilai_akad" => null , "biaya_adm" => null, "kurang_biaya" => null, "agen" => null , "legalitas_rumah" => null];
    // $ket = $detail_pembelian['ket'];
    // unset($detail_pembelian['ket']);
    $this->model->update('tb_pembelian_rumah',$where,$detail);
    if($data['ket'] != ''){
      $array = array(
        array(
          'tanggal_update' => date("Y-m-d").' | '.date("h:i:sa"),
          'ket' => $data['ket']
        )
      );
      // $this->model->update('tb_pembelian_rumah',array('id_area' => $detail_pembelian['id_area'] , 'id_rumah' => $detail_pembelian['id_rumah']), array('ket' => json_encode($array)));
      $cek_data = $this->model->tampil_data_where('tb_pembelian_rumah',$where)->result();
      if($cek_data[0]->ket != null or $cek_data[0]->ket != ''){
        $ketnya = json_decode($cek_data[0]->ket);
        $array = array_merge($ketnya,$array);
      }
      $this->model->update('tb_pembelian_rumah',$where, array('ket' => json_encode($array))); 
    }
    $this->response(['message' => 'ok' ,'data' => $array ?? null], 200);
  }

  

  public function pembelianRumah_get()
  {
    $id_area = $this->get("id_area");
    $cek_data = $this->model->tampil_data_where('tb_pembelian_rumah',['id_area' => $id_area])->result();
    $this->response(['message' => 'ok' ,'data' => $cek_data], 200);

  }

  public function pembelianRumahPembeli_get()
  {
    $id_area = $this->get("id_area");
    $id_rumah = $this->get("id_rumah");
    $cek_data = $this->model->custom_query("SELECT  * FROM tb_pembelian_rumah a join tb_pembeli b on a.nik_pembeli = b.nik_pembeli where a.id_area = $id_area and a.id_rumah = '$id_rumah'")->result();

    if (count($cek_data) > 0) {
      $this->response(['message' => 'ok' ,'data' => $cek_data[0]], 200);
    }
    else
    {
      $this->response(['message' => 'ok' ,'data' => null], 200);
    }
    

  }

  public function progressRumah_get()
  {
    $id_area = $this->get("id_area");
    $id_rumah = $this->get("id_rumah");
    $cek_data = $this->model->tampil_data_where('tb_progress_rumah',['id_area' => $id_area, 'id_rumah' => $id_rumah])->result();

    if (count($cek_data) > 0) {
      $this->response(['message' => 'ok' ,'data' => $cek_data[0]], 200);
    }
    else
    {
      $this->response(['message' => 'ok' ,'data' => null], 200);
    }
    

  }


  public function dataPerumahan_post()
  {
    // $array = $this->put("dataPerumahan");
    $where = json_decode($this->post("where"),true);
    $detail = json_decode($this->post("detail"),true);

    if($where['value_foto'] == 1){
      $files = $_FILES['files'];
      $dir = 'assets/admin_assets/images/area/'.$where['id_area'].'/';
      if(is_dir($dir) === false )
      {
        mkdir($dir);
      }

      $files1 = glob($dir.'*');
      foreach($files1 as $file){ // iterate files
        if(is_file($file)) {
          unlink($file); // delete file
        }
      }
      // rmdir($dir);

      $array_images = array();
      for($index = 0;$index < count($files['name']) ;$index++){
      
        $filename = $_FILES['files']['name'][$index];
        // print_r($filename);
        $path = $dir.$filename;
        $array_images[] = $path;
        move_uploaded_file($_FILES['files']['tmp_name'][$index],$path);
        // $array_images = array_push($array_images,$path );
      }
      unset($where['value_foto']);
      $detail = array_merge($detail,array('images' => json_encode($array_images)));
      $this->model->update('tb_area',$where,$detail);
      $this->response(['message' => 'ok' ,'data' => $detail], 200);
    }else{
      // $files = 'tiada';
      unset($where['value_foto']);
      $this->model->update('tb_area',$where,$detail);
      $this->response(['message' => 'ok' ,'data' => $detail], 200);
    }


    // $id_area = $this->put("id_area");
    
    // $this->model->update('tb_area',array('id_area' => $id_area),array('data' => $array));
    

  }
  
  
  public function cetakBerkas_get()
  {
    $id_area = $this->get("id_area");
    $id_rumah = $this->get("id_rumah");
    $nik_pembeli = $this->get("nik_pembeli");

    $cek_data = $this->model->custom_query("SELECT a.id_area as id_area, a.id_rumah as id_rumah, a.nik_pembeli as nik_pembeli, b.function as nama_bank, d.id_pengembang as id_pengembang FROM tb_pembelian_rumah a join tb_bank b join tb_pembeli c join tb_pengembang d join tb_area e on a.id_bank = b.id_bank and a.nik_pembeli = c.nik_pembeli and a.id_area = e.id_area and e.id_pengembang = d.id_pengembang where a.id_area = $id_area and a.id_rumah='$id_rumah' and a.nik_pembeli = $nik_pembeli")->result();

    if (count($cek_data) > 0) {
      $this->response(['res' => 'ok', 'bank' => $cek_data[0]], 200);
    }
    else
    {
      $this->response(['res' => 'ko'], 400);
    }

    
  }

  public function dataArea_get()
  {
    $id_area = $this->get('id_area');
    $data = $this->model->tampil_data_where('tb_area',array('id_area' => $id_area))->result();
    $this->response(['res' => 'sini dia','data' => $data[0]], 200);
    
  }

  public function areaFromPengembang_get()
  {
    $id_pengembang = $this->get('id_pengembang');
    $data = $this->model->tampil_data_where('tb_area',array('id_pengembang' => $id_pengembang))->result();
    $this->response(['res' => 'sini dia','data' => $data], 200);
    
  }

  public function dataPengembang_post()
  {
    $data = $this->post('data');
    $data = $this->model->serialize($data);
    // $id_pengembang = $this->put('id_pengembang');
    $this->model->insert('tb_pengembang',$data);
    $this->response(['res' => 'ok', 'data' => $data], 200);
    
  }

  public function dataPengembang_get()
  {
    $id_pengembang = $this->get('id_pengembang');
    $data = $this->model->tampil_data_where('tb_pengembang',array('id_pengembang' => $id_pengembang))->result();
    $this->response(['res' => 'ok','data' => $data[0]], 200);
    
  }

  public function dataPengembang_put()
  {
    $data = $this->put('data');
    $data = $this->model->serialize($data);
    $id_pengembang = $this->put('id_pengembang');
    $this->model->update('tb_pengembang',array('id_pengembang' => $id_pengembang),$data);
    $this->response(['res' => 'ok'], 200);
    
  }

  public function dataPengembangFix_put()
  {
    $where = $this->put('where');
    $data = $this->put('data');
    $data = $this->model->serialize($data);
    $this->model->update('tb_pengembang',$where,$data);
    $this->response(['res' => 'ok','data' => $data], 200);
    
  }

  public function statusSite_put()
  {
    $id_area = $this->put('id_area');
    $info = $this->put('info');
    $this->model->update('tb_area',array('id_area' => $id_area),array('info' => $info));
    $this->response(['res' => 'ok'], 200);
    
  }


  public function kerjasamaBank_put()
  {
    $id_pengembang = $this->put('id_pengembang');
    $data = $this->put('data');
    $cek_data = $this->model->tampil_data_where('tb_pengembang',array('id_pengembang' => $id_pengembang))->result();

    $this->model->update('tb_pengembang',array('id_pengembang' => $id_pengembang),array('kerjasama_bank' => $data));


    
    if ($cek_data[0]->persyaratan != null or $cek_data[0]->persyaratan != '') {
      $array_data = json_decode($data,true);
      $array_persyaratan = json_decode($cek_data[0]->persyaratan,true);
      $ada = '';
      
      foreach ($array_persyaratan as $key => $value) {
        $true = false;
        foreach ($array_data as $key1 => $value1) {
          if ($value['id_bank'] ==$value1 ) {
            $true = true;
            break;
          }
        }

        if ($true == false) {
          $ada .= $key.',';
        }
      }

      if ($ada != '') {
        $ada = substr($ada, 0, -1);
        $ada = json_decode('['.$ada.']');
        foreach ($ada as $key => $value) {
          // $this->model->custom_query("UPDATE tb_pengembang set persyaratan=JSON_REMOVE(persyaratan, JSON_UNQUOTE(JSON_SEARCH(persyaratan, 'one', '$value'))) where id_pengembang = $id_pengembang");
          unset($array_persyaratan[$value]);
        }
        $this->model->update('tb_pengembang',array('id_pengembang' => $id_pengembang),array('persyaratan' => json_encode(array_merge($array_persyaratan))));
      }

      // $this->response(['res' => 'ok','data' => $array_persyaratan], 200);
    }

    if ($cek_data[0]->no_giro != null or $cek_data[0]->no_giro != '') {
      $array_data = json_decode($data,true);
      $array_giro = json_decode($cek_data[0]->no_giro,true);
      $ada = '';
      
      foreach ($array_giro as $key => $value) {
        $true = false;
        foreach ($array_data as $key1 => $value1) {
          if ($value['id_bank'] ==$value1 ) {
            $true = true;
            break;
          }
        }

        if ($true == false) {
          $ada .= $key.',';
        }
      }

      if ($ada != '') {
        $ada = substr($ada, 0, -1);
        $ada = json_decode('['.$ada.']');
        foreach ($ada as $key => $value) {
          // $this->model->custom_query("UPDATE tb_pengembang set persyaratan=JSON_REMOVE(persyaratan, JSON_UNQUOTE(JSON_SEARCH(persyaratan, 'one', '$value'))) where id_pengembang = $id_pengembang");
          unset($array_giro[$value]);
        }
        $this->model->update('tb_pengembang',array('id_pengembang' => $id_pengembang),array('no_giro' => json_encode(array_merge($array_giro))));
      }

      // $this->response(['res' => 'ok','data' => $array_persyaratan], 200);
    }
    // else
    // {

    // }
    $this->response(['res' => 'ok','data' => $data], 200);
    
  }


  public function persyaratanBank_put()
  {
    $id_pengembang = $this->put('id_pengembang');
    $data = $this->put('data');
    $this->model->update('tb_pengembang',array('id_pengembang' => $id_pengembang),array('persyaratan' => json_encode($data)));
    $this->response(['res' => 'ok'], 200);
    
  }

  public function staff_post()
  {
    $data = $this->post('data');
    $data = $this->model->serialize($data);

    $cek_data = $this->model->tampil_data_where('tb_staff',['nik_staff' => $data['nik_staff']])->result();

    if (count($cek_data) > 0) {
      $this->response(['res' => 'ko'], 400);
    }
    else
    {
      $this->model->insert('tb_staff',$data);    
      $this->model->insert('tb_login_admin_staff',['username' => $data['nik_staff'], 'password' => $data['nik_staff'] , 'level' => 'staff' , 'nik_staff' => $data['nik_staff']]);
      $this->response(['res' => 'ok', 'data' => $data], 200);
    }
    // 
  }

  public function staff_put()
  {
    $nik_staff = $this->put('nik_staff');
    $data = $this->put('data');
    $data = $this->model->serialize($data);

    $this->model->update('tb_staff',['nik_staff' => $nik_staff], $data);
    $this->response(['res' => 'ok'], 200);
  }

  public function staff_delete()
  {
    $nik_staff = $this->delete('nik_staff');
  
    $this->model->delete('tb_staff',['nik_staff' => $nik_staff]);
    $this->response(['res' => 'ok'], 200);
  }

  public function staff_get()
  {
    $nik_staff = $this->get('nik_staff');
    $data = $this->model->tampil_data_where('tb_staff', ['nik_staff' => $nik_staff])->result();
    $this->response(['res' => 'ok', 'data' => $data[0]], 200);
  }

  public function tipe_get()
  {
    $where = $this->get('where');
    $data = $this->model->tampil_data_where('tb_tipe', $where)->result();
    $this->response(['res' => 'ok', 'data' => $data], 200);
  }

  public function tipe_delete()
  {
    $where = $this->delete('where');
    $data = $this->model->tampil_data_where('tb_tipe',$where)->result()[0];

    $dir = 'assets/admin_assets/images/tipe_rumah/'.$data->id_area.'/'.$data->tipe_rumah.'-'.$data->status_tipe.'/';
    $files1 = glob($dir.'*'); // get all file names
    foreach($files1 as $file){ // iterate files
      if(is_file($file)) {
        unlink($file); // delete file
      }
    }
    rmdir($dir);
    $this->model->delete('tb_tipe', $where);
    $this->response(['res' => 'ok', 'data' => $where], 200);
  }

  public function berita_post()
  {
    $data1 = $this->post('berita');
    $detail = json_decode($this->post('detail'));
    $detail = $this->model->serialize($detail);
    $foto = $_FILES['foto'];

			
    $cek_no = $this->model->cek_last_ai('tb_berita');

    // print_r($cek_no);
    $dir = 'assets/admin_assets/images/berita/'.$cek_no;
    if( is_dir($dir) === false )
    {
        mkdir($dir);
    }

    $dir_foto = 'assets/admin_assets/images/berita/'.$cek_no.'/foto/';
    if( is_dir($dir_foto) === false )
    {
        mkdir($dir_foto);
    }

    move_uploaded_file($_FILES['foto']['tmp_name'],$dir_foto.$_FILES['foto']['name']);
    
    
    $header = strstr($data1, '</h1>', true);
    $header = substr($header, 4);
    // print_r($header);

    $data = explode('<img src="',$data1);
    foreach ($data as $key => $value) {
      if ($key != 0) {
        $cek_dulu = mb_substr($value, 0, 5);
        if ($cek_dulu == 'data:') {
          $value = strstr($value, '</figure>', true);
          $figcaption = '';
          $alt = '';

          if (strpos($value, '<figcaption>') != false) {
            $figcaption = strstr($value, '</figcaption>', true);
            $figcaption = explode('<figcaption>',$figcaption);
            $figcaption = '<figcaption>'.$figcaption[1].'</figcaption>';
          }

          if (strpos($value, 'alt="') != false) {
            $alt = strstr($value, 'alt="', false);
            $alt = explode('"',$alt);
            $alt = ' alt="'.$alt[1].'"';
          }
          $this->model->upload_foto($value,$key,$cek_no,'berita');
          // print_r($figcaption);
          $data1 = str_replace($value,base_url().'assets/admin_assets/images/berita/'.$cek_no .'/foto'.$key.'.png" '.$alt.'>'.$figcaption,$data1);
          // print_r(base_url().'images/'.$cek_no .'/foto'.$key.'.png" '.$alt.'>'.$figcaption);
        }					
      }
    }
    $detail = array_merge($detail,array('image' => $dir_foto.$_FILES['foto']['name'], 'content' => $data1));
    $this->model->insert('tb_berita',$detail);
    $this->model->insert('tb_notifikasi_superadmin',['jenis' => 'Berita', 'id_berita' => $cek_no ,'id_pengembang' => $this->session->userdata('id_pengembang')]);

    // print_r($data1);
    // rename('images/temp/'.$cek_no, 'images/'.$cek_no);
    $this->response(['res' => 'ok' ], 200);
  }

  public function berita_get()
  {
    $where = $this->get('where');
    $status = $where['status'] ?? null;
    $all = $where['all'] ?? null;
    if($all != null){
      $data = $this->model->tampil_data_keseluruhan('tb_berita')->result();
    }
    elseif($status != null){
      $data = $this->model->tampil_data_where('tb_berita',$where)->result();
    }else{
      $data = $this->model->tampil_data_where('tb_berita',$where)->result()[0];
    }
    
    $this->response(['res' => 'ok' ,'data' => $data], 200);
  }

  public function berita_put()
  {
    $where = $this->put('where');
    $detail = $this->put('detail');

    $this->model->update('tb_berita',$where,$detail);
    $this->model->update('tb_notifikasi_superadmin',$where,['status_terima' => $detail['status']]);
    $this->model->insert('tb_notifikasi_pengembang',['id_pengembang' => $where['id_pengembang'] , 'jenis' => 'Berita', 'id_berita' => $where['id_berita'],'status' => $detail['status']]);
    $this->response(['res' => 'ok' ,'data' => $where], 200);
  }

  public function iklan_post()
  {
    $data1 = $this->post('iklan');
    $detail = json_decode($this->post('detail'));
    $detail = $this->model->serialize($detail);
    $foto = $_FILES['foto'];

			
    $cek_no = $this->model->cek_last_ai('tb_iklan_pengembang');

    // print_r($cek_no);
    $dir = 'assets/admin_assets/images/iklan/'.$cek_no;
    if( is_dir($dir) === false )
    {
        mkdir($dir);
    }

    $dir_foto = 'assets/admin_assets/images/iklan/'.$cek_no.'/foto/';
    if( is_dir($dir_foto) === false )
    {
        mkdir($dir_foto);
    }

    move_uploaded_file($_FILES['foto']['tmp_name'],$dir_foto.$_FILES['foto']['name']);
    
    
    $header = strstr($data1, '</h1>', true);
    $header = substr($header, 4);
    // print_r($header);

    $data = explode('<img src="',$data1);
    foreach ($data as $key => $value) {
      if ($key != 0) {
        $cek_dulu = mb_substr($value, 0, 5);
        if ($cek_dulu == 'data:') {
          $value = strstr($value, '</figure>', true);
          $figcaption = '';
          $alt = '';

          if (strpos($value, '<figcaption>') != false) {
            $figcaption = strstr($value, '</figcaption>', true);
            $figcaption = explode('<figcaption>',$figcaption);
            $figcaption = '<figcaption>'.$figcaption[1].'</figcaption>';
          }

          if (strpos($value, 'alt="') != false) {
            $alt = strstr($value, 'alt="', false);
            $alt = explode('"',$alt);
            $alt = ' alt="'.$alt[1].'"';
          }
          $this->model->upload_foto($value,$key,$cek_no,'iklan');
          // print_r($figcaption);
          $data1 = str_replace($value,base_url().'assets/admin_assets/images/iklan/'.$cek_no .'/foto'.$key.'.png" '.$alt.'>'.$figcaption,$data1);
          // print_r(base_url().'images/'.$cek_no .'/foto'.$key.'.png" '.$alt.'>'.$figcaption);
        }					
      }
    }
    $detail = array_merge($detail,array('image' => $dir_foto.$_FILES['foto']['name'], 'content' => $data1));
    $this->model->insert('tb_iklan_pengembang',$detail);
    $this->model->insert('tb_notifikasi_superadmin',['jenis' => 'Iklan', 'id_iklan' => $cek_no ,'id_pengembang' => $this->session->userdata('id_pengembang')]);

    // print_r($data1);
    // rename('images/temp/'.$cek_no, 'images/'.$cek_no);
    $this->response(['res' => 'ok' ], 200);
  }

  public function iklan_get()
  {
    $where = $this->get('where');
    $status = $where['status'] ?? null;
    $all = $where['all'] ?? null;

    if($status != null){
      $data = $this->model->tampil_data_where('tb_iklan_pengembang',$where)->result();
    }
    elseif($all != null){
      $data = $this->model->tampil_data_keseluruhan('tb_iklan_pengembang')->result();
    }
    else{
      $data = $this->model->tampil_data_where('tb_iklan_pengembang',$where)->result()[0];
    }
    $this->response(['res' => 'ok' ,'data' => $data], 200);
  }

  public function iklan_put()
  {
    $where = $this->put('where');
    $detail = $this->put('detail');

    $this->model->update('tb_iklan_pengembang',$where,$detail);
    $this->model->update('tb_notifikasi_superadmin',$where,['status_terima' => $detail['status']]);
    $this->model->insert('tb_notifikasi_pengembang',['id_pengembang' => $where['id_pengembang'] , 'jenis' => 'Iklan', 'id_iklan' => $where['id_iklan'],'status' => $detail['status']]);
    $this->response(['res' => 'ok' ,'data' => $where], 200);
  }


  public function foto_post()
  {
    $files = $_FILES['files'];
    $detail = json_decode($this->post('detail'));
    $detail = $this->model->serialize($detail);
    $cek_no = $this->model->cek_last_ai('tb_foto');

    // print_r($cek_no);
    $dir = 'assets/admin_assets/images/foto/'.$cek_no.'/';
    if( is_dir($dir) === false )
    {
      mkdir($dir);
    }

    $array_images = array();
    for($index = 0;$index < count($files['name']) ;$index++){
    
      $filename = $_FILES['files']['name'][$index];
      // print_r($filename);
      $path = $dir.$filename;
      $array_images[] = $path;
      move_uploaded_file($_FILES['files']['tmp_name'][$index],$path);
      // $array_images = array_push($array_images,$path );
    }
    $detail = array_merge($detail,array('foto'=> json_encode($array_images)));


    $this->model->insert('tb_foto',$detail);
    $this->model->insert('tb_notifikasi_superadmin',['jenis' => 'Foto', 'id_foto' => $cek_no ,'id_pengembang' => $this->session->userdata('id_pengembang')]);
    
    $this->response(['res' => 'ok' ,'data' => $array_images], 200);
  }

  public function foto_get()
  {
    $where = $this->get('where');
    $status = $where['status'] ?? null;
    $all = $where['all'] ?? null;

    if($status != null){
      $data = $this->model->tampil_data_where('tb_foto',$where)->result();
    }elseif($all != null){
      $data = $this->model->tampil_data_keseluruhan('tb_foto')->result();
    }else{
      $data = $this->model->tampil_data_where('tb_foto',$where)->result()[0];
    }
    
    $this->response(['res' => 'ok' ,'data' => $data], 200);
  }

  public function foto_put()
  {
    $where = $this->put('where');
    $detail = $this->put('detail');

    $this->model->update('tb_foto',$where,$detail);
    $this->model->update('tb_notifikasi_superadmin',$where,['status_terima' => $detail['status']]);
    $this->model->insert('tb_notifikasi_pengembang',['id_pengembang' => $where['id_pengembang'] , 'jenis' => 'Foto', 'id_foto' => $where['id_foto'],'status' => $detail['status']]);
    $this->response(['res' => 'ok' ,'data' => $where], 200);
  }

  public function notifikasi_superadmin_get()
  {
    $where = $this->get('where');
    $status_baca = $where['status_baca'] ?? null;
    $all = $where['all'] ?? null;
    if($status_baca != null){
      $notif = $where['notif'] ?? null;
      if ($notif != null) {

        $data = $this->model->custom_query("SELECT * FROM tb_notifikasi_superadmin a join tb_pengembang c on  a.id_pengembang = c.id_pengembang where a.status_baca = 'Belum Dibaca' order by id_notifikasi desc")->result();
      }
      else
      {
        $data = $this->model->tampil_data_where('tb_notifikasi_superadmin',$where)->result();
      }
      
    }
    elseif($all != null){
      $data = $this->model->tampil_data_keseluruhan('tb_notifikasi_superadmin')->result();
    }
    else{
      $data = $this->model->tampil_data_where('tb_notifikasi_superadmin',$where)->result()[0];
    }
    
    $this->response(['res' => 'ok' ,'data' => $data], 200);
  }

  public function notifikasi_superadmin_put()
  {
    $where = $this->put('where');

    $jenis = $where['jenis'] ?? null;
    $detail = $this->put('detail');

    if($jenis != null){
      switch ($where['jenis']) {
        case 'Berita':
          $this->model->update('tb_berita',['id_berita' => $where['idnya']] , ['status' => $detail['status_terima'] ,'ket' => $detail['ket'] ?? null]);
          $this->model->insert('tb_notifikasi_pengembang',['jenis' => 'Berita' , 'id_berita' => $where['idnya'],'status' =>  $detail['status_terima'],'id_pengembang' => $where['id_pengembang']]);
          break;
        
        case 'Iklan':
          $this->model->update('tb_iklan_pengembang',['id_iklan' => $where['idnya']] , ['status' => $detail['status_terima'] ,'ket' => $detail['ket'] ?? null]);
          $this->model->insert('tb_notifikasi_pengembang',['jenis' => 'Iklan' , 'id_iklan' => $where['idnya'],'status' =>  $detail['status_terima'],'id_pengembang' => $where['id_pengembang']]);
          break;

        case 'Foto':
          # code...
          $this->model->update('tb_foto',['id_foto' => $where['idnya']] , ['status' => $detail['status_terima'] ,'ket' => $detail['ket'] ?? null]);
          $this->model->insert('tb_notifikasi_pengembang',['jenis' => 'Foto' , 'id_foto' => $where['idnya'],'status' =>  $detail['status_terima'],'id_pengembang' => $where['id_pengembang']]);
          break;
          
          
      }
      unset($where['idnya']);
      unset($where['jenis']);

      if(isset($detail['ket'])){
        unset($detail['ket']);
      }
    }

    
    

    
    $this->model->update('tb_notifikasi_superadmin',$where,$detail);
    $this->response(['res' => 'ok', 'data'=>$where], 200);
  }

  public function notifikasi_superadmin_delete()
  {
    $where = $this->delete('where');
        
    $this->model->delete('tb_notifikasi_superadmin',$where);
    $this->response(['res' => 'ok'], 200);
  }

  public function notifikasi_pengembang_get()
  {
    $where = $this->get('where');
    
    $data = $this->model->tampil_data_where('tb_notifikasi_pengembang',$where)->result();
    $this->response(['res' => 'ok' ,'data' => $data], 200);
  }

  public function notifikasi_pengembang_put()
  {
    $where = $this->put('where');
    $detail = $this->put('detail');
    
    $this->model->update('tb_notifikasi_pengembang',$where,$detail);
    $this->response(['res' => 'ok' ,'data' => $detail], 200);
  }


  public function notifikasi_pengembang_delete()
  {
    $where = $this->delete('where');
    
        
    $this->model->delete('tb_notifikasi_pengembang',$where);
    $this->response(['res' => 'ok'], 200);
  }

  public function staff_login_put()
  {
    $where = $this->put('where');
    $detail = $this->put('detail');
    
    $this->model->update('tb_login_admin_staff',$where,$detail);
    $this->response(['res' => 'ok' ,'data' => $detail], 200);
  }
}

