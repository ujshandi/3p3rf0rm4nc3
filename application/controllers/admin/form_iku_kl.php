<?php

class Form_iku_kl extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
							
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/admin/exception_kl_model');
		
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Formulasi IKU Kementerian';		
		$data['objectId'] = 'formiku_kl';
	  	$this->load->view('admin/form_iku_kl_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid($filtahun=null){
		/*
		//decode filter
		$filNip =  $this->utility->HexToAscii($filNip);
		
		//kalo string=nulll jadiin null 
		if($filNip == 'null') $filNip = NULL;
		*/
		//$this->session->userdata('level')
		echo $this->exception_kl_model->easyGrid($filtahun);
	}
	

	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		
		$kode_e1 = $this->input->post("unit_kerja_E1", TRUE);
		$kode_e2 = $this->input->post("unit_kerja_E2", TRUE);
		
		$data['prefix_old'] = $this->input->post("prefix_old", TRUE);
		$data['prefix'] = $this->input->post("prefix", TRUE);
		$data['prefix_iku'] = $this->input->post("prefix_iku", TRUE);
		
		$data['kode_e1']= ($kode_e1=="-1"?"":$kode_e1);
		$data['kode_e2']= ($kode_e2=="-1"?"":$kode_e2);
		return $data;
    }
	
	public function getprefix($kode_e1,$kode_e2){
		$prefix ='';
		$prefix_iku ='';
		$data = $this->exception_kl_model->SelectInDb(($kode_e1=="-1"?"":$kode_e1),($kode_e2=="-1"?"":$kode_e2));
		//var_dump($data);
		if ($data!=null){
			$prefix = $data['prefix'];
			$prefix_iku = $data['prefix_iku'];
		}
			
		echo json_encode(array('prefix'=>$prefix,'prefix_iku'=>$prefix_iku));
	}
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
	
		$data['pesan_error'] = '';
		//validasi form
		$this->form_validation->set_rules("prefix", 'Prefix Sasaran', 'trim|required|xss_clean');
		$this->form_validation->set_rules("prefix_iku", 'Prefix IKU/IKK', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE){
			$data["pesan_error"].=(trim(form_error("prefix"," "," "))==""?"":form_error("prefix"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("prefix_iku"," "," "))==""?"":form_error("prefix_iku"," "," ")."<br>");
			$status = $data["pesan_error"];
			
		}else { 
			if (!$this->exception_kl_model->isExistPrefix($data['prefix'],$data['prefix_old'])){
				$result = $this->exception_kl_model->saveToDb($data,$status);
				$data["pesan_error"] = $status;
			}	
			else
			  $data["pesan_error"] = 'Prefix '.$data['prefix'].' sudah digunakan.';
		}
		
		
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
//		echo $status;

	}
	
}
?>