<?php

class pengukurankl extends CI_Controller {
	
	var $objectId = 'pengukurankl';
	
	function __construct()
	{
		parent::__construct();		
		
		//$this->output->enable_profiler(true);
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/pengukuran/pengukurankl_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Pengukuran Kinerja Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('pengukuran/pengukurankls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Pengukuran Kinerja Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('pengukuran/pengukurankl_v',$data);
	}
	
	public function edit($id,$editmode=true){
		$data['title'] = 'Edit Pengukuran Kinerja Kementerian';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->pengukurankl_model->getDataEdit($id);
		
	  	$this->load->view('pengukuran/pengukurankl_v_edit',$data);
	}	
	
	function grid($filtahun=null){
		echo $this->pengukurankl_model->easyGrid($filtahun);
	}
	
	
	private function get_form_values() {
		$dt['tahun'] 		= $this->input->post("tahun", TRUE); 
		$dt['triwulan'] 	= $this->input->post("triwulan", TRUE); 
		$dt['kode_kl'] 		= $this->input->post("kode_kl", TRUE); 
		$dt['kode_sasaran_kl'] = $this->input->post("kode_sasaran_kl", TRUE); 
		$dt['detail'] 		= $this->input->post("detail", TRUE); 
		
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
		$this->form_validation->set_rules("kode_kl", 'Kementerian', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_kl", 'Sasaran Kementerian', 'trim|required|xss_clean');
		

		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
			$data['pesan_error'].=(trim(form_error('tahun',' ',' '))==''?'':form_error('tahun',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_kl',' ',' '))==''?'':form_error('kode_kl',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_sasaran_kl',' ',' '))==''?'':form_error('kode_sasaran_kl',' ','<br>'));
			
		}else{
			// validasi detail
			if($this->check_detail($data, $pesan)){
				$result = $this->pengukurankl_model->InsertOnDb($data);
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
			// if($r['kode_iku_e1'] == '0'){ // cek kode iku
				// $pesan = 'Kode IKU pada no. '.$i.' harus diisi.';
				// return FALSE;
			// }
			
			if($r['opini'] == ''){ // nilai target null
				$pesan = 'Opini pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			
			// cek ke database
			if($this->pengukurankl_model->data_exist($data['tahun'], $data['triwulan'], $data['kode_kl'], $data['kode_sasaran_kl'], $r['kode_iku_kl'])){ 
				$pesan = 'Kode IKU pada no. '.$i.' sudah terdapat di dalam database.';
				//$pesan = 'Kode IKU '.$r['kode_iku_kl'].' sudah terdapat di database';
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
		
		$data['id_pengukuran_kl'] = $this->input->post('id_pengukuran_kl');
		$data['opini'] = $this->input->post('opini');
		$data['persetujuan'] = $this->input->post('persetujuan');
		// validation
		
		$result = $this->pengukurankl_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->pengukurankl_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $kode_kl="", $kode_sasaran_kl="", $objek=""){
		if($tahun == "" || $kode_kl == "" || $kode_sasaran_kl == "" || $kode_sasaran_kl == "" || $objek==""){
			echo '';
		}else{
			echo $this->pengukurankl_model->getDetail($tahun, $kode_kl, $kode_sasaran_kl, $objek);
		}
		
	}
	
}
?>