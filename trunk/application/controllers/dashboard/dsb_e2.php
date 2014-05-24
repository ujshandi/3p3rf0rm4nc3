<?php

class Dsb_e2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
	//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/dashboard/dsb_e2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->library("utility");
	}
	
	function index()
	{
		
		$data = array(
				
					'title_page'=>'Biroren Kemenhub',
					'title'=>'Capaian Akhir IKU Eselon II',
					'objectId'=>'dashboardKinerjaE2',
					'sess_fullname'=>$this->session->userdata('full_name'),
					'sess_apptype'=>$this->session->userdata('app_type'),
					'js'=>array('js/easyui/jquery-1.6.min.js','js/easyui/jquery.easyui.min.js','js/uri_encode_decode.js','js/json2.js','js/jquery.autogrow.js','js/jquery.formatCurrency-1.4.0.min.js','js/formwizard.js','js/jquery.jqURL.js'),
					'css'=>array('css/themes/gray/easyui.css','css/themes/icon.css')
				);
		//$data['title'] =$this->session->userdata('userlogin');
	  
		//$data['menuList'] =  $this->sys_menu_model->prepareMenuManual();//($this->session->userdata('groupId'),'');
		
		$this->load->view('dashboard/dsb_e2_vw',$data);
		//$this->load->view('footer_vw',$data);
	}
	

	public function grid($filtahun=null,$file2=null){
		
		echo $this->dsb_e2_model->easyGrid($filtahun,$file2);
	}
	public function gride2($filtahun=null,$file1=null,$file2=null){
		
		echo $this->dsb_e2_model->easyGridE2($filtahun,$file1,$file2);
	}
	
	
	function getDataPie($filtahun=null){
		   $data = $this->dsb_e2_model->dataPie;//array("Tercapai"=>20,"Tidak Tercapai"=>3);
			echo json_encode($data);
	}
	
	function getLoginStatus(){
		echo $this->session->userdata('logged_in');
	}
	
}
?>
