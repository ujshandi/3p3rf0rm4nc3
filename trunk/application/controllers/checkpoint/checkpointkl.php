<?php

class Checkpointkl extends CI_Controller {
	var $objectId = 'checkpointkl';
	
	function __construct()
	{
		parent::__construct();			
		
		//$this->output->enable_profiler(true);
		
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/checkpoint/checkpointkl_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->model('/rencana/rktkl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Penetapan Kinerja Kementerian';	
		$data['objectId'] = $this->objectId;
		$data['listPeriode'] = $this->utility->getListCheckpoint("");
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointkls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Checkpoint Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointkl_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' Checkpoint Kementerian';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->checkpointkl_model->getDataEdit($id);
		
	  	$this->load->view('checkpoint/checkpointkl_v_edit',$data);
	}
	
	function grid($filtahun=null){
		echo $this->checkpointkl_model->easyGrid($filtahun);
	}
	
	function griddetail($id_pk){
		echo $this->checkpointkl_model->easyGridDetail($id_pk);
	}
	
	private function get_form_values() {
		
		$dt['id_pk_kl'] = $this->input->post("id_pk_kl", TRUE); 
		$dt['id_checkpoint_kl'] = $this->input->post("id_checkpoint_kl", TRUE); 
		$dt['unit_kerja'] = $this->input->post("unitkerja", TRUE); 
		$dt['kriteria'] = $this->input->post("kriteria", TRUE); 
		$dt['ukuran'] = $this->input->post("ukuran", TRUE); 
		$dt['periode'] = $this->input->post("cmbPeriode", TRUE); 
		$dt['target'] = $this->input->post("target", TRUE); 
		$dt['keterangan'] = $this->input->post("keterangan", TRUE); 
		$dt['capaian'] = null; 
		
		return $dt;
    }
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$return_id = 0;
		$result = "";
		$data['pesan_error'] = '';
		$pesan = '';
		
		// validation
		# rules
		
		$this->form_validation->set_rules("id_pk_kl", 'ID Penetapan KL', 'trim|required|xss_clean');

		
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
			//$data['pesan_error'].=(trim(form_error('tahun'.$this->objectId,' ',' '))==''?'':form_error('tahun'.$this->objectId,' ','<br>'));
			$data['pesan_error'].=(trim(form_error('id_pk_kl',' ',' '))==''?'':form_error('id_pk_kl',' ','<br>'));
			//$data['pesan_error'].=(trim(form_error('kode_sasaran_kl',' ',' '))==''?'':form_error('kode_sasaran_kl',' ','<br>'));
			
		}else{
			// validasi detail
		//	if($this->check_detail($data, $pesan)){
				$result = $this->checkpointkl_model->InsertOnDb($data);
			//}else{
				//$data['pesan_error'].= $pesan;
		//	}
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
		
		$data['id_pk_kl'] = $this->input->post('id_pk_kl');
		$data['penetapan'] = $this->input->post('penetapan');
		
		// validation
		
		$result = $this->checkpointkl_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->checkpointkl_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $kode_kl="", $kode_sasaran_kl=""){
		echo $this->checkpointkl_model->getDetail($tahun, $kode_kl, $kode_sasaran_kl);
	}
	
}
?>
