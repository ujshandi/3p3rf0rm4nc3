<?php

class rseselon1 extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		//$this->output->enable_profiler(true);
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/realisasi/rseselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Realisasi Kinerja Tingkat Eselon 1';	
		$data['objectId'] = 'rseselon1';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rseselon1s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'realisasi Kinerja Tingkat Eselon 1';	
		$data['objectId'] = 'rseselon1Add';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rseselon1_v',$data);
	}
	
	function grid(){
		echo $this->rseselon1_model->easyGrid();
	}
	
	
	private function get_form_values() {
		$dt['tahun'] 		= $this->input->post("tahun", TRUE); 
		$dt['triwulan'] 	= $this->input->post("triwulan", TRUE); 
		$dt['kode_e1'] 		= $this->input->post("kode_e1", TRUE); 
		$dt['kode_sasaran_e1'] = $this->input->post("kode_sasaran_e1", TRUE); 
		$dt['detail'] 		= $this->input->post("detail", TRUE); 
		
		return $dt;
    }
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$return_id = 0;
		$result = "";

		// validation
		
		foreach($data['detail'] as $dt){
			$data['tahun'] 			= $data['tahun'];
			$data['triwulan'] 		= $data['triwulan'];
			$data['kode_e1'] 		= $data['kode_e1'];
			$data['kode_sasaran_e1'] = $data['kode_sasaran_e1'];
			$data['kode_iku_e1'] 	= $dt['kode_iku_e1'];
			$data['realisasi'] 		= $dt['realisasi'];
			
			$result = $this->rseselon1_model->InsertOnDb($data);
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> $return_id));
		}
	}
	
	public function getDetail($tahun="", $kode_e1="", $kode_sasaran_e1="", $objek=""){
		if($tahun == "" || $kode_e1 == "" || $kode_sasaran_e1 == "" || $kode_sasaran_e1 == "0" || $objek==""){
			echo '';
		}else{
			echo $this->rseselon1_model->getDetail($tahun, $kode_e1, $kode_sasaran_e1, $objek);
		}
	}
	
}
?>