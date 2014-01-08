<?php

class rseselon2 extends CI_Controller {
	
	var $objectId = 'rseselon2';
	
	function __construct()
	{
		parent::__construct();

		//$this->output->enable_profiler(true);
		$userdata = array ('logged_in' => TRUE);
				//
		$this->session->set_userdata($userdata);
				
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/realisasi/rseselon2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->library("utility");
		
	}
	
	function index(){
	
		$data['title'] = 'Data Realisasi Kinerja Eselon II';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rseselon2s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Realisasi Kinerja Eselon II';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rseselon2_v',$data);
	}
	
	public function edit($id,$editmode=true){
		$data['title'] = 'Edit Realisasi Kinerja Eselon II';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->rseselon2_model->getDataEdit($id);
		
	  	$this->load->view('realisasi/rseselon2_v_edit',$data);
	}
	
	function grid($filtahun=null, $file1=null, $file2=null,$filbulan=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');
		
		$file1 = $file1 == null?'-1':$file1;
		$file2 = $file2 == null?'-1':$file2;
		
		echo $this->rseselon2_model->easyGrid($filtahun, $file1, $file2,$filbulan);
	}
	
	//chan, get combo sasaran e2
	public function getListSasaranE2($objectId,$e2=-1){
		echo $this->rseselon2_model->getListSasaranE2($objectId,$e2);
	}
	
	private function get_form_values() {
		$dt['tahun'] 		= $this->input->post("tahun", TRUE); 
		$dt['triwulan'] 	= $this->input->post("triwulan", TRUE); 
		$dt['kode_e2'] 		= $this->input->post("kode_e2", TRUE); 
		$dt['kode_sasaran_e2'] = $this->input->post("kode_sasaran_e2", TRUE); 
		$dt['detail'] 		= $this->input->post("detail", TRUE); 
		$dt['action_plan'] = $this->input->post('action_plan');
		$dt['keterangan'] = $this->input->post('keterangan');
		
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
		$this->form_validation->set_rules("kode_e2", 'Eselon 2', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e2", 'Sasaran Eselon 2', 'trim|required|xss_clean');
		
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
				$result = $this->rseselon2_model->InsertOnDb($data);
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
			if($this->rseselon2_model->data_exist($data['tahun'], $data['triwulan'], $data['kode_e2'], $data['kode_sasaran_e2'], $r['kode_ikk'])){ 
				$pesan = 'Kode IKK pada no. '.$i.' sudah terdapat di dalam database.';
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
		
		$data['id_kinerja_e2'] = $this->input->post('id_kinerja_e2');
		$data['realisasi'] = $this->input->post('realisasi');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['action_plan'] = $this->input->post('action_plan');
		
		// validation
		
		$result = $this->rseselon2_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->rseselon2_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $triwulan="", $kode_e1="", $kode_sasaran_e1="", $objek=""){
		if($tahun == "" || $triwulan == "" || $kode_e1 == "" || $kode_sasaran_e1 == "" || $kode_sasaran_e1 == "0" || $objek==""){
			echo '';
		}else{
			echo $this->rseselon2_model->getDetail($tahun, $triwulan, $kode_e1, $kode_sasaran_e1, $objek);
		}
	}
	
}
?>