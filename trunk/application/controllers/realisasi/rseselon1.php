<?php

class rseselon1 extends CI_Controller {
	
	var $objectId = 'rseselon1';
	
	function __construct()
	{
		parent::__construct();			
		//$this->output->enable_profiler(true);
		$userdata = array ('logged_in' => TRUE);
				//
		$this->session->set_userdata($userdata);
				
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/realisasi/rseselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Realisasi Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rseselon1s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Realisasi Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rseselon1_v',$data);
	}
	
	public function edit($id,$editmode=true){
		$data['title'] = 'Edit Realisasi Kinerja Eselon I';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->rseselon1_model->getDataEdit($id);
	  	$this->load->view('realisasi/rseselon1_v_edit',$data);
	}
	
	function grid($filtahun=null,$file1=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		echo $this->rseselon1_model->easyGrid($filtahun, $file1);
	}
	
	
	private function get_form_values() {
		$dt['tahun'] 		= $this->input->post("tahun", TRUE); 
		$dt['triwulan'] 	= $this->input->post("triwulan", TRUE); 
		if ($this->session->userdata('unit_kerja_e1')=='-1')
			$dt['kode_e1'] 		= $this->input->post("kode_e1", TRUE); 
		else
			$dt['kode_e1'] 		=  $this->session->userdata('unit_kerja_e1');
		$dt['kode_sasaran_e1'] = $this->input->post("kode_sasaran_e1", TRUE); 
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
		$this->form_validation->set_rules("kode_e1", 'Kementerian', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e1", 'Sasaran Kementerian', 'trim|required|xss_clean');
		
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
				$result = $this->rseselon1_model->InsertOnDb($data);
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
			
			if($r['realisasi'] == ''){ // nilai target null
				$pesan = 'Realisasi pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			
			// cek capaian bulan lalu
			if($r['realisasi'] < $r['capaian']){
				$pesan = 'Realisasi pada no. '.$i.' nilai tidak boleh lebih kecil dari nilai capaian bulan lalu.';
				return FALSE;
			}
			
			// cek ke database
			if($this->rseselon1_model->data_exist($data['tahun'], $data['triwulan'], $data['kode_e1'], $data['kode_sasaran_e1'], $r['kode_iku_e1'])){ 
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
		
		$data['id_kinerja_e1'] = $this->input->post('id_kinerja_e1');
		$data['realisasi'] = $this->input->post('realisasi');
		
		// validation
		
		$result = $this->rseselon1_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	//public function getDetail($tahun="", $kode_e1="", $kode_sasaran_e1="", $objek=""){
	public function getDetail($tahun="", $triwulan="", $kode_e1="", $kode_sasaran_e1="", $objek=""){
		if($tahun == "" || $triwulan == "" || $kode_e1 == "" || $kode_sasaran_e1 == "" || $kode_sasaran_e1 == "0" || $objek==""){
			echo '';
		}else{
			echo $this->rseselon1_model->getDetail($tahun, $triwulan, $kode_e1, $kode_sasaran_e1, $objek);
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->rseselon1_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	//chan, get combo sasaran e1
	public function getListSasaranE1($objectId,$e1=-1){
		echo $this->rseselon1_model->getListSasaranE1($objectId,$e1);
	}
	
}
?>