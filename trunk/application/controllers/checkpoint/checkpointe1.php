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
		$this->load->model('/checkpoint/checkpointe1_model');
		$this->load->model('/rencana/rpt_rkteselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/rencana/rkteselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Penetapan Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		$data['purpose'] = 'Rencana';
		$data['listPeriode'] = $this->utility->getListCheckpoint("","cmbPeriode".$this->objectId);
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointe1s_v',$data);
	}
	
	function capaian(){
		$data['title'] = 'Penetapan Kinerja Eselon I';	
		$this->objectId = 'checkpointCapaiane1';
		$data['objectId'] = $this->objectId;
		$data['purpose'] = 'Capaian';
		$data['listPeriode'] = $this->utility->getListCheckpoint("","cmbPeriode".$this->objectId);
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointe1s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Data Penetapan Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointe1_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' Data Penetapan Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->checkpointe1_model->getDataEdit($id);
		
	  	$this->load->view('checkpoint/checkpointe1_v_edit',$data);
	}
	function getDataEdit($id){
		echo $this->checkpointe1_model->getDataEdit($id);
	}
	
	function grid($filtahun=null,$file1=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		echo $this->checkpointe1_model->easyGrid($filtahun,$file1);
	}
	
	function griddetail($id_pk){
		echo $this->checkpointe1_model->easyGridDetail($id_pk);
	}
	
	function getListSasaranE1($objectId,$e1){
		echo $this->sasaran_eselon1_model->getListSasaranE1($objectId,$e1);
	}
	
	private function get_form_values() {
		$dt['id_pk_e1'] = $this->input->post("id_pk_e1", TRUE); 
		$dt['id_checkpoint_e1'] = $this->input->post("id_checkpoint_e1", TRUE); 
		$dt['unit_kerja'] = $this->input->post("unitkerja", TRUE); 
		$dt['kriteria'] = $this->input->post("kriteria", TRUE); 
		$dt['ukuran'] = $this->input->post("ukuran", TRUE); 
		$dt['periode'] = $this->input->post("cmbPeriode".$this->objectId, TRUE); 
		$dt['target'] = $this->input->post("target", TRUE); 
		$dt['keterangan'] = $this->input->post("keterangan", TRUE); 
		$dt['capaian'] = $this->input->post("capaian", TRUE);
		$dt['purpose'] = $this->input->post("purpose", TRUE);
		
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
/*
		$this->form_validation->set_rules("tahun", 'Tahun', 'trim|required|numeric|exact_length[4]|xss_clean');
		$this->form_validation->set_rules("kode_e1", 'Eselon 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e1", 'Sasaran Eselon 1', 'trim|required|xss_clean');
		
		
*/
		$this->form_validation->set_rules("id_pk_e1", 'ID Penetapan Eselon I', 'trim|required|xss_clean');
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
		$data['pesan_error'].=(trim(form_error('id_pk_e1',' ',' '))==''?'':form_error('id_pk_e1',' ','<br>'));
/*
			$data['pesan_error'].=(trim(form_error('tahun',' ',' '))==''?'':form_error('tahun',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_e1',' ',' '))==''?'':form_error('kode_e1',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_sasaran_e1',' ',' '))==''?'':form_error('kode_sasaran_e1',' ','<br>'));
*/
			
		}else{
			// validasi detail
		//	if($this->check_detail($data, $pesan)){
				
				if(($data['id_checkpoint_e1']!="")&&($data['id_checkpoint_e1']!=null)){
				$result = $this->checkpointe1_model->UpdateOnDb($data);
			}
			else
				$result = $this->checkpointe1_model->InsertOnDb($data);
/*
			}else{
				$data['pesan_error'].= $pesan;
			}
*/
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
		
		$result = $this->checkpointe1_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->checkpointe1_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $kode_e1="", $kode_sasaran_e1=""){
		echo $this->checkpointe1_model->getDetail($tahun, $kode_e1, $kode_sasaran_e1);
	}
	
}
?>
