<?php

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		$userdata = array ('logged_in' => TRUE);
				//
		$this->session->set_userdata($userdata);
				
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/admin/user_model');
		$this->load->model('/admin/group_level_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Pengguna';		
		$data['objectId'] = 'user';
	  	$this->load->view('admin/user_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid($file1=null,$file2=null,$filapptype=null,$fillevel=null){
		/*
		//decode filter
		$filNip =  $this->utility->HexToAscii($filNip);
		
		//kalo string=nulll jadiin null 
		if($filNip == 'null') $filNip = NULL;
		*/
		//$this->session->userdata('level')
		echo $this->user_model->easyGrid($file1,$file2,$filapptype,$fillevel);
	}
	
	
	
	function loadE2($e1){
		echo $this->user_model->getListUnitKerja("E2",$e1,'<label style="width:120px;vertical-align:top">Unit Kerja Eselon 2:</label>');
	}
	
	//utk auto complete
	// public function auto_dokter(){
		// $parent = $this->input->post('q',TRUE);
		// if((strlen($parent)) < 1){
			// echo '[]';
			// exit;
		// }
		// $parts = $this->dokter_model->getAuto($parent);
	// }
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['user_id'] = $this->input->post("user_id", TRUE);
		$data['user_name'] = $this->input->post("user_name", TRUE);
		$data['full_name'] = $this->input->post("full_name", TRUE);		
		$data['passwd'] = $this->input->post("passwd", TRUE);
		$data['unit_kerja_E1'] = $this->input->post("unit_kerja_E1", TRUE);
		$data['unit_kerja_E2'] = $this->input->post("unit_kerja_E2", TRUE);
		
		$data['group_id'] = $this->input->post("group_id", TRUE);
		$data['level_id'] = $this->input->post("level_id", TRUE);
		return $data;
    }
	
	function changePasswd(){
		
		$data['opass'] = $this->input->post("opass", TRUE);
		$data['npass'] = $this->input->post("npass", TRUE);
		$data['cpass'] = $this->input->post("cpass", TRUE);
		$data['pesan_error']= '';
		$result = false;
		if ($this->user_model->getPassword($this->session->userdata('user_id'))!=md5($data['opass']))			
			$data['pesan_error'] = "Password lama tidak sesuai";
		else if ($data['cpass']!=$data['npass'])
			$data['pesan_error'] = "Password baru tidak sama dengan konfirmasi password";
		else
			$result = $this->user_model->changePassword($this->session->userdata('user_id'),$data);
		if ($result){
			echo json_encode(array('success'=>true,'status'=>'Ubah password berhasil'));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
	}
	
	
	
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
	
		$data['pesan_error'] = '';
		//validasi form
		$this->form_validation->set_rules("group_id", 'Grup Pengguna', 'trim|required|xss_clean');
	/*	$this->form_validation->set_rules("user_name", 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules("full_name", 'Nama Lengkap', 'trim|required|xss_clean');
		$this->form_validation->set_rules("passwd", 'Password', 'trim|required|xss_clean');
	*/	
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
		//	$data["pesan_error"].=(trim(form_error("user_name"," "," "))==""?"":form_error("user_name"," "," ")."<br/>");
			//$data["pesan_error"].=(trim(form_error("full_name"," "," "))==""?"":form_error("full_name"," "," ")."<br/>");
		//	$data["pesan_error"].=(trim(form_error("passwd"," "," "))==""?"":form_error("passwd"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("group_id"," "," "))==""?"":form_error("group_id"," "," ")."<br>");
			$status = $data["pesan_error"];
		}else { 
			if($aksi=="add"){ // add
				//if (!$this->user_model->isExistKode($data['kode_kl'])){
					$result = $this->user_model->InsertOnDb($data,$status);
				//}
				//else
					//$data['pesan_error'] .= 'Kode sudah ada';
					
			}else { // edit
				$result=$this->user_model->UpdateOnDb($data,$kode);
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