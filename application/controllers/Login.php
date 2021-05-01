<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login
 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');
	}
	
	
    function index(){
        $this->load->view('login/index');      
    }


	


	
}
?>