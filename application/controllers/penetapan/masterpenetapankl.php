<?php

class Masterpenetapankl extends CI_Controller {
	var $objectId = 'masterpenetapankl';
	
	function __construct()
	{
		parent::__construct();			
		
		//$this->output->enable_profiler(true);
		
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/penetapan/master_penetapankl_model');
		$this->load->model('/penetapan/penetapankl_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/rujukan/programkl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Program Penetapan Kinerja Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/master_penetapankls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Program Penetapan Kinerja Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/master_penetapankl_v',$data);
	}
	
	function grid($filtahun=null){
		echo $this->master_penetapankl_model->easyGrid($filtahun);
	}
	
	
	private function get_form_values() {
		$dt['tahun'] = $this->input->post("tahun", TRUE); 
		$dt['kode_kl'] = $this->input->post("kode_kl", TRUE); 
		$dt['kode_program'] = $this->input->post("kode_program", TRUE); 
		// print_r($dt);
		return $dt;
    }
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$return_id = 0;
		$result = "";
		$pesan = '';
		
		// validation
		
		# rules
		$this->form_validation->set_rules("tahun", 'Tahun', 'trim|required|numeric|exact_length[4]|xss_clean');
		$this->form_validation->set_rules("kode_kl", 'Kementerian', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_program", 'Program Kementerian', 'trim|required|xss_clean');
		
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
			$data['pesan_error'] = '';
			$data['pesan_error'].=(trim(form_error('tahun',' ',' '))==''?'':form_error('tahun',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_kl',' ',' '))==''?'':form_error('kode_kl',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_program',' ',' '))==''?'':form_error('kode_program',' ','<br>'));
			
		}else{
			if($aksi=="add"){ // add
				if($this->master_penetapankl_model->dataCheck($data)){
					$data['pesan_error'] = 'Data Program Unit Ini Sudah Ditetapkan';
				}else{
					$result = $this->master_penetapankl_model->InsertOnDb($data);
				}
			}else { // edit
				$result = $this->master_penetapankl_model->UpdateOnDb($data,$kode);
			}
			// validasi detail
			//if($this->check_detail($data, $pesan)){
			/*}else{
				$data['pesan_error'].= $pesan;
			}*/
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'status'=>$return_id));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
	}
	
	/*function check_detail($data, & $pesan){
		$i=1;
		foreach($data['detail'] as $r){
			if($r['penetapan'] == ''){ // nilai target null
				$pesan = 'Penetapan pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			$i++;
		}
		
		return TRUE;
	}*/
	
	function delete($id=''){
		if($id != ''){
			$result = $this->master_penetapankl_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun, $kode_kl, $kode_sasaran_kl){
		echo $this->master_penetapankl_model->getDetail($tahun, $kode_kl, $kode_sasaran_kl);
	}
	
}
?>