<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model {

  public function __construct()
  {
    parent::__construct();

  }

  function index(){

  }

  function tampil_data_keseluruhan($namatabel) //gunakan ini untuk menampilkan tabel yg lebih spesifik 'where'
  {
    $this->db->select("*");
    $this->db->from($namatabel);
    
    $query = $this->db->get();
    return $query;
  }

  function tampil_data_where($namatabel,$array) //gunakan ini untuk menampilkan tabel yg lebih spesifik 'where'
  {
    $this->db->select("*");
    $this->db->from($namatabel);
    $this->db->where($array);
    // $this->db->limit(1);
    $query = $this->db->get();
    return $query;
  }

  function tampil_data_where1($namatabel,$array,$bintang) //gunakan ini untuk menampilkan tabel yg lebih spesifik 'where'
  {
    $this->db->select($bintang);
    $this->db->from($namatabel);
    $this->db->where($array);
    // $this->db->limit(1);
    $query = $this->db->get();
    return $query;
  }

  function tampil_data_keseluruhan_order_by($namatabel,$order_by,$order) //gunakan ini untuk menampilkan tabel yg lebih spesifik 'where'
  {
    $this->db->select("*");
    $this->db->from($namatabel);
    // $this->db->where($array);
    $this->db->order_by($order_by, $order);
    // $this->db->limit(1);
    $query = $this->db->get();
    return $query;
  }

  function tampil_data_where_order_by($namatabel,$array,$order_by,$order) //gunakan ini untuk menampilkan tabel yg lebih spesifik 'where'
  {
    $this->db->select("*");
    $this->db->from($namatabel);
    $this->db->where($array);
    $this->db->order_by($order_by, $order);
    // $this->db->limit(1);
    $query = $this->db->get();
    return $query;
  }

  function tampil_data_last($namatabel,$kolom)
  {
    $this->db->select("*");
    $this->db->from($namatabel);
    $this->db->limit(1);
    $this->db->order_by($kolom,"DESC");
    $query = $this->db->get();
    return $query;
  }

  function custom_query($query) 
  {
    $query1 = $this->db->query($query);
    return $query1;

  }

  function insert($namatabel,$array) 
  {
    return $this->db->insert($namatabel,$array);
  }

  function update($table,$array,$array_condition)
  {
    $this->db->where($array);
    $this->db->update($table, $array_condition);
  }

  function delete($table,$array_condition)
  {
    // $this->db->where($array);
    $this->db->delete($table, $array_condition);
    // $this->db->delete(table_name, where_clause)
  }



  function like($namatabel,$field,$like,$kategori)
  {
    if ($kategori == '') {
      $this->db->select("*");
      $this->db->from($namatabel);
      $this->db->like($field, $like, 'both'); 
      // $this->db->limit(1);
      $query = $this->db->get();
      return $query;
    }else{
      $this->db->select("*");
      $this->db->from($namatabel);
      $this->db->where(array('kategori'=>$kategori));
      $this->db->like($field, $like, 'both'); 
      // $this->db->limit(1);
      $query = $this->db->get();
      return $query;
    }
  }

  function data_user($nik,$pencarian)
  {
    $data = $this->tampil_data_where('tb_staff_kelurahan',array('nik' => $nik));
    foreach ($data->result() as $key => $value) ; 
    if ($pencarian == "data_diri") {
      return $value;
    }else if ($pencarian == "kelurahan") {
      $kelurahan = $this->tampil_data_where('tb_kelurahan',array('no' => $value->kelurahan));
      foreach ($kelurahan->result() as $key1 => $value1) ;
      return $value1->kelurahan;
    }
    
  }

  function serialize($data){
    $keys = array_column($data,'name');
    $values = array_column($data,'value');
    $data = array_combine($keys, $values);
    return $data;
  }

  function cek_penamaan_foto($imageFileType)
  {
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
        
        return 0; 
    }else{
      return 1;
    }
  }

  function upload_foto($value,$key,$cek_no,$kategori) {
		
		$data = $value; 
		$data =  substr($data, 0, -2);
		// $data = 'data:image/'.$data;
		// print_r($data);
		// define('UPLOAD_DIR', 'images/');
    $image_parts = explode(";base64,", $data);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    // if ($e == 1) {
		// 	$edit = '_edit';
		// 	$file = 'images/'.$cek_no. '/foto'.$edit.$key.'.png';
		// }
		// else
		// {
		// 	$edit = '';
    if ($kategori == 'berita') {
      $file = 'assets/admin_assets/images/berita/'.$cek_no. '/foto'.$key.'.png';
    }
    if ($kategori == 'iklan') {
      $file = 'assets/admin_assets/images/iklan/'.$cek_no. '/foto'.$key.'.png';
    }
    file_put_contents($file, $image_base64);
		
	}


  function bulan($bulan) 
  {
    
    switch ($bulan) {
      case '01':
        $bulannya = 'Januari';
        break;

      case '02':
        $bulannya = 'Februari';
        break;

      case '03':
        $bulannya = 'Maret';
        break;

      case '04':
        $bulannya = 'April';
        break;

      case '05':
        $bulannya = 'Mei';
        break;

      case '06':
        $bulannya = 'Juni';
        break;

      case '07':
        $bulannya = 'Juli';
        break;

      case '08':
        $bulannya = 'Agustus';
        break;

      case '09':
        $bulannya = 'September';
        break;

      case '10':
        $bulannya = 'Oktober';
        break;
      
      case '11':
        $bulannya = 'November';
        break;

      case '12':
        $bulannya = 'Desember';
        break;

      default:
        $bulannya = '';
        break;
    }

    return $bulannya;
  }

  function hari($hari)
  {
    // $ini = ''
    switch ($hari) {
      case 'Sunday':
        $ini = 'Ahad';
        break;
      case 'Monday':
        $ini = 'Senin';
        break;
      case 'Tuesday':
        $ini = 'Selasa';
        break;
      case 'Wednesday':
        $ini = 'Rabu';
        break;
      case 'Thursday':
        $ini = 'Kamis';
        break;
      case 'Friday':
        $ini = 'Jumat';
        break;
      case 'Saturday':
        $ini = 'Sabtu';
        break;
      
    }

    return $ini;
  }

  // function qrcode_buku($kode){
  //   include "phpqrcode/qrlib.php"; 
  //   $kode = $kode;
    
  //   // $PNG_TEMP_DIR = 'images/'.$kategori;
    
  //   $PNG_WEB_DIR = 'images/buku/';

  //   if (!file_exists($PNG_WEB_DIR))
  //     mkdir($PNG_WEB_DIR);
        
  //   $errorCorrectionLevel = 'H';

  //   $matrixPointSize = 10;

  //   $filename =$PNG_WEB_DIR.md5($kode).'.png';
  //   QRcode::png($kode, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

  //   if (file_exists($PNG_WEB_DIR.md5($kode).'.png') > 0) {
  //     return "ada";
  //   }else{
  //     return "tiada";
  //   }
  // }

  function cek_last_ai($tables){
		return $this->db->query("SELECT `AUTO_INCREMENT` as no
			FROM  INFORMATION_SCHEMA.TABLES
			WHERE TABLE_SCHEMA = '".$this->db->database."'
			AND   TABLE_NAME   = '".$tables."'")->result()[0]->no;

	}

}