<?php

class pengesahan_penetapankl extends CI_Controller {
	var $objectId = 'pengesahanpenetapankl';
	
	function __construct()
	{
		parent::__construct();			
		
		//$this->output->enable_profiler(true);
		
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/penetapan/penetapankl_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/rujukan/programkl_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->model('/penetapan/Pengesahan_penetapankl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Pengesahan Kinerja Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/pengesahan_penetapankl_v',$data);
	}
	
	function save(){
		$return_id = 0;
		$result = "";
		$data['pesan_error'] = '';
		$pesan = '';
		
		# data
		$data['tahun'] 			= $this->input->post('tahun'.$this->objectId);
		$data['kode_kl'] 		= $this->input->post('kode_kl'.$this->objectId);
		$data['detail'] 		= $this->input->post('detail');
		$data['program'] 		= $this->input->post('program');
		
		$data['id_masterpk_kl'] = $this->input->post('id_masterpk_kl');
		$data['kode_program'] 	= $this->input->post('kode_program');
		
		# proses pengesahan data pk
		$status='0';
		foreach($data['detail'] as $r){
			if(isset($r['approve'])){
				$status = '1';
			}else{
				$status = '0';
			}
			$result = $this->Pengesahan_penetapankl_model->UpdateDataPK($r['id_pk_kl'], $r['penetapan'], $status);
		}
		
		# proses insert ke data master pk
		foreach($data['program'] as $r){
			if(isset($r['approve'])){
				$result = $this->Pengesahan_penetapankl_model->InsertDataMasterPK($data['tahun'], $data['kode_kl'], $r['kode_program']);
			}
		}
		
		// validation
		//$result = $this->Pengesahan_penetapankl_model->InsertOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'status'=>$return_id));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
	}
	
	public function getDetail($tahun="", $kode_kl=""){
		echo $this->Pengesahan_penetapankl_model->getDetail($tahun, $kode_kl, $this->objectId);
	}
	
}
?>