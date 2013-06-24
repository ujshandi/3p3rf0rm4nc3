<?php

class Checkpointe1 extends CI_Controller {
	
	var $objectId = 'checkpointe1';
	
	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/penetapan/penetapaneselon1_model');
		$this->load->model('/rencana/rpt_rkteselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/rencana/rkteselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Penetapan Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/penetapaneselon1s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Data Penetapan Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/penetapaneselon1_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' Data Penetapan Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->penetapaneselon1_model->getDataEdit($id);
		
	  	$this->load->view('penetapan/penetapaneselon1_v_edit',$data);
	}
	
	function grid($filtahun=null,$file1=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		echo $this->penetapaneselon1_model->easyGrid($filtahun,$file1);
	}
	
	function getListSasaranE1($objectId,$e1){
		echo $this->sasaran_eselon1_model->getListSasaranE1($objectId,$e1);
	}
	
	private function get_form_values() {
		$dt['tahun'] = $this->input->post("tahun", TRUE); 
		if ($this->session->userdata('unit_kerja_e1')=='-1')
			$dt['kode_e1'] = $this->input->post("kode_e1", TRUE); //id
		else 
			$dt['kode_e1'] = $this->session->userdata('unit_kerja_e1');
		$dt['kode_sasaran_e1'] = $this->input->post("kode_sasaran_e1", TRUE); 
		$dt['detail'] = $this->input->post("detail", TRUE); 
		
		return $dt;
    }
	
	/* function getListSasaranE1($objectId,$e1){
		echo $this->sasaran_eselon1_model->getListSasaranE1($objectId,$e1);
	} */
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$return_id = 0;
		$result = "";
		$data['pesan_error'] = '';
		$pesan = 't';
		
		// validation
		# rules
		$this->form_validation->set_rules("tahun", 'Tahun', 'trim|required|numeric|exact_length[4]|xss_clean');
		$this->form_validation->set_rules("kode_e1", 'Eselon 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e1", 'Sasaran Eselon 1', 'trim|required|xss_clean');
		
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
			$data['pesan_error'].=(trim(form_error('tahun',' ',' '))==''?'':form_error('tahun',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_e1',' ',' '))==''?'':form_error('kode_e1',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_sasaran_e1',' ',' '))==''?'':form_error('kode_sasaran_e1',' ','<br>'));
			
		}else{
			// validasi detail
			if($this->check_detail($data, $pesan)){
				$result = $this->penetapaneselon1_model->InsertOnDb($data);
			}else{
				$data['pesan_error'].= $pesan;
			}
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'status'=>$return_id));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
	}
	
	function check_detail($data, & $pesan){
		$i=1;
		foreach($data['detail'] as $r){
			if($r['penetapan'] == ''){ // nilai target null
				$pesan = 'Penetapan pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			$i++;
		}
		
		return TRUE;
	}
	
	function save_edit(){
		$this->load->library('form_validation');
		$return_id = 0;
		$result = "";
		
		$data['id_pk_e1'] = $this->input->post('id_pk_e1');
		$data['penetapan'] = $this->input->post('penetapan');
		
		// validation
		
		$result = $this->penetapaneselon1_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->penetapaneselon1_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $kode_e1="", $kode_sasaran_e1=""){
		echo $this->penetapaneselon1_model->getDetail($tahun, $kode_e1, $kode_sasaran_e1);
	}
	
}
?>
