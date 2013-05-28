<?php

class Import extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');		
		$this->load->model('/security/sys_menu_model');		
		$this->load->model('/utility/import_model');		
		$this->load->library("utility");	
		$this->load->helper('form');
	}
	
	function index(){
		$data['title'] = 'Import Data Rujukan';	
		$data['objectId'] = 'import';
		$this->load->view('utility/import_v',$data);
	}
	
	function loadMenu(){
		echo $this->sys_menu_model->loadMenu($this->session->userdata('app_type'),1);
	}
	
	function doImport($menuId,$menuTitle,$replace,$tahun){
		$rs = $this->import_model->doImport($menuId,$menuTitle,$replace,$tahun);
		echo urldecode ($rs);
	}
}
?>