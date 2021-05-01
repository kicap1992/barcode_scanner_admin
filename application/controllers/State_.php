<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State_ extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    
    if ($this->session->userdata('level') == 'admin') {
      redirect('/home');
    }
    else
    {
      $this->session->unset_userdata(array('nik_admin','nik_staff','level'));
      redirect('/login');
    }
  }

  function index()
  {
    $this->session->unset_userdata(array('nik_admin','nik_staff','level'));
    redirect('/login');

    // print_r($this->session->userdata('level'));
  }

    
}
?>