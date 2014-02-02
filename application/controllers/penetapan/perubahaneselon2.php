<?php

class Perubahaneselon2 extends CI_Controller {
	
	var $objectId = 'perubahaneselon2';
	
	function __construct()
	{
		parent::__construct();			
		//$this->output->enable_profiler(true);
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
			
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/penetapan/penetapaneselon2_model');
		$this->load->model('/rencana/rpt_rkteselon2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/pengaturan/sasaran_eselon2_model');
		$this->load->model('/rencana/rkteselon2_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Penetapan Kinerja Eselon II';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/penetapaneselon2s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add PK Eselon II';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/penetapaneselon2_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' PK Eselon II';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->penetapaneselon2_model->getDataEdit($id);
		
	  	$this->load->view('penetapan/penetapaneselon2_v_edit',$data);
	}
	
	function grid($filtahun=null, $file1=null, $file2=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');
			
		$file1 = $file1 == null?'-1':$file1;
		$file2 = $file2 == null?'-1':$file2;
			
		echo $this->penetapaneselon2_model->easyGrid($filtahun, $file1, $file2);
	}
	
	function getListSasaranE2($objectId,$e2){
		echo $this->sasaran_eselon2_model->getListSasaranE2($objectId,$e2);
	}
	
	private function get_form_values() {
		$dt['tahun'] = $this->input->post("tahun", TRUE); 
		if ($this->session->userdata('unit_kerja_e2')=='-1')
			$dt['kode_e2'] = $this->input->post("kode_e2", TRUE); //id
		else 
			$dt['kode_e2'] = $this->session->userdata('unit_kerja_e2');	
		$dt['kode_sasaran_e2'] = $this->input->post("kode_sasaran_e2", TRUE); 
		$dt['detail'] = $this->input->post("detail", TRUE); 
		
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
		$this->form_validation->set_rules("tahun", 'Tahun', 'trim|required|numeric|exact_length[4]|xss_clean');
		$this->form_validation->set_rules("kode_e2", 'Kementerian', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e2", 'Sasaran Kementerian', 'trim|required|xss_clean');
		
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
			$data['pesan_error'].=(trim(form_error('tahun',' ',' '))==''?'':form_error('tahun',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_e2',' ',' '))==''?'':form_error('kode_e2',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_sasaran_e2',' ',' '))==''?'':form_error('kode_sasaran_e2',' ','<br>'));
			
		}else{
			// validasi detail
			if($this->check_detail($data, $pesan)){
				$result = $this->penetapaneselon2_model->InsertOnDb($data);
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
		
		$data['id_pk_e2'] = $this->input->post('id_pk_e2');
		$data['penetapan'] = $this->input->post('penetapan');
		
		// validation
		
		$result = $this->penetapaneselon2_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->penetapaneselon2_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $kode_e2="", $kode_sasaran_e2=""){
		echo $this->penetapaneselon2_model->getDetail($tahun, $kode_e2, $kode_sasaran_e2);
	}
	
}
?>