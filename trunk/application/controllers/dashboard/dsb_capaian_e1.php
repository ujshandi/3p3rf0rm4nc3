<?php

class Dsb_capaian_e1 extends CI_Controller {
	var $dataPie = array();
	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
	//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/dashboard/dsb_capaian_e1_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->library("utility");
	}
	
	function index()
	{
		
		$data = array(
				
					'title_page'=>'Biroren Kemenhub',
					'title'=>'Capaian Akhir IKU Kementerian',
					'objectId'=>'dashboardCapaianE1',
					'sess_fullname'=>$this->session->userdata('full_name'),
					'sess_apptype'=>$this->session->userdata('app_type'),
					'js'=>array('js/easyui/jquery-1.6.min.js','js/easyui/jquery.easyui.min.js','js/uri_encode_decode.js','js/json2.js','js/jquery.autogrow.js','js/jquery.formatCurrency-1.4.0.min.js','js/formwizard.js','js/jquery.jqURL.js'),
					'css'=>array('css/themes/gray/easyui.css','css/themes/icon.css')
				);
		//$data['title'] =$this->session->userdata('userlogin');
	  
		//$data['menuList'] =  $this->sys_menu_model->prepareMenuManual();//($this->session->userdata('groupId'),'');
		
		$this->load->view('dashboard/dsb_capaian_e1_vw',$data);
		//$this->load->view('footer_vw',$data);
	}
	

	public function grid($filtahun=null,$filsasaran=null){
		
		echo $this->dsb_capaian_e1_model->easyGrid($filtahun,$filsasaran);
		 $this->dataPie = $this->dsb_capaian_e1_model->dataPie;
		 // $data = array("Tercapai"=>20,"Tidak Tercapai"=>3);
			//var_dump($this->dataPie );die;
	}
	
	
	function getDataPie($filtahun=null){
		//  $data = $this->dsb_capaian_e1_model->dataPie;// 
		  
		// $this->dsb_capaian_e1_model->easyGrid($filtahun);
		// $this->dataPie = $this->dsb_capaian_e1_model->dataPie;
		//  $data = array("Tercapai"=>20,"Tidak Tercapai"=>3);
		//	var_dump($this->dataPie);die;
			echo json_encode($this->dataPie);
	}
	
	function getLoginStatus(){
		echo $this->session->userdata('logged_in');
	}
	
}
?>
