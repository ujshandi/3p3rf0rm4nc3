<?php

class Group_user extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/admin/group_user_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Grup Pengguna';		
		$data['objectId'] = 'groupUser';
	  	$this->load->view('admin/group_user_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
function grid(){
		/*
		//decode filter
		$filNip =  $this->utility->HexToAscii($filNip);
		
		//kalo string=nulll jadiin null 
		if($filNip == 'null') $filNip = NULL;
		*/
		
		echo $this->group_user_model->easyGrid();
	}
	
	
	
	function getListCombo(){
		//echo $this->dokter_model->getListCombo();
	}
	
	//utk auto complete
	public function auto_dokter(){
		$parent = $this->input->post('q',TRUE);
		if((strlen($parent)) < 1){
			echo '[]';
			exit;
		}
		$parts = $this->dokter_model->getAuto($parent);
	}
	
		private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['group_id'] = $this->input->post("group_id", TRUE);
		$data['group_name'] = $this->input->post("group_name", TRUE);
		$data['app_type'] = $this->input->post("app_type", TRUE);
		return $data;
    }
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
	
		//validasi form
		$this->form_validation->set_rules("group_name", 'Nama Grup Pengguna', 'trim|required|xss_clean');
		$this->form_validation->set_rules("app_type", 'Tipe Aplikasi', 'trim|required|xss_clean');
		
		$data['pesan_error'] = '';
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			$data["pesan_error"].=(trim(form_error("group_name"," "," "))==""?"":form_error("group_name"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("app_type"," "," "))==""?"":form_error("app_type"," "," ")."<br/>");
			$status = $data["pesan_error"];
		}else {
			if($aksi=="add"){ // add
				//if (!$this->group_user_model->isExistKode($data['kode_kl'])){
					$result = $this->group_user_model->InsertOnDb($data,$status);
				//}
				//else
					//$data['pesan_error'] .= 'Kode sudah ada';
					
			}else { // edit
				$result=$this->group_user_model->UpdateOnDb($data,$kode);
				// if (!$this->dokter_model->isExistKode($data['kode_kl'],null,$data['dokter_id'])){
					// if (!$this->dokter_model->isExistKode(null,$data['dokter_nip'],$data['dokter_id']))
						// $result=$this->dokter_model->UpdateOnDb($data,$status);
					// else						
						// $data['pesan_error'] .= 'NIP sudah ada';
				// }
				// else
					// $data['pesan_error'] .= 'Kode sudah ada';
				
					//$status = "update";
				$data['pesan_error'] .= 'Update : '.$kode;
			}
			$data['pesan_error'] .= $status;	
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