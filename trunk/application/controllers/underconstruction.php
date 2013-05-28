<?php

class Underconstruction extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		$userdata = array ('logged_in' => TRUE);
				//
		$this->session->set_userdata($userdata);
				
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		//$this->load->model('/security/sys_menu_model');
	}
	
	function index()
	{
		$data['title'] = 'Underconstruction';
		//$data['title'] =$this->session->userdata('userlogin');
	  
		
		$this->load->view('underconstruction_vw',$data);
		//$this->load->view('footer_vw',$data);
	}
	
}
?>