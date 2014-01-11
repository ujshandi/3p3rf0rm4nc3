<?php

class Sasaran_program extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
						
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rencana/rpt_rkteselon1_model');
		$this->load->model('/pengaturan/sasaran_program_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/rujukan/programkl_model');
		$this->load->model('/rujukan/kegiatankl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Sasaran Program kegiatan';		
		$data['objectId'] = 'SasaranProgram';
	  	$this->load->view('pengaturan/sasaran_program_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid($file1=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		echo $this->sasaran_program_model->easyGrid($file1);
	}
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['kode_e1'] = $this->input->post("kode_e1", TRUE); //id
		$data['tahun'] = $this->input->post("tahun", TRUE); //id
		$data['kode_sasaran_e1'] = $this->input->post("kode_sasaran_e1", TRUE);
		$data['kode_program'] = $this->input->post("kode_program", TRUE);		
		$data['kode_kegiatan'] = $this->input->post("kode_kegiatan", TRUE);		
		//$data["insert_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		//$data["update_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		return $data;
    }
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
	
		//validasi form
		$this->form_validation->set_rules("kode_e1", 'Kode Eselon 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("tahun", 'Tahun', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e1", 'Kode Sasaran Eselon 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_program", 'Kode Program', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_kegiatan", 'Kode Kegiatan', 'trim|required|xss_clean');
		$data['pesan_error'] = '';
		
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			$data["pesan_error"].=(trim(form_error("kode_e1"," "," "))==""?"":form_error("kode_e1"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("tahun"," "," "))==""?"":form_error("tahun"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("kode_sasaran_e1"," "," "))==""?"":form_error("kode_sasaran_e1"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("kode_program"," "," "))==""?"":form_error("kode_program"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("kode_kegiatan"," "," "))==""?"":form_error("kode_kegiatan"," "," ")."<br/>");
			$status = $data["pesan_error"];
			
		}else {
			if($aksi=="add"){ // add
					$result = $this->sasaran_program_model->InsertOnDb($data,$status);
					
			}else { // edit
				$result=$this->sasaran_program_model->UpdateOnDb($data,$kode);
				
			}
			$data['pesan_error'] .= $status;	
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'kode'=>$kode));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
//		echo $status;
		
		}

	}
?>