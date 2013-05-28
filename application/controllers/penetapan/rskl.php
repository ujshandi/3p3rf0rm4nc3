<?php

class rskl extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		

		//$this->output->enable_profiler(true);
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/realisasi/rskl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'realisasi Kinerja Tingkat Kementerian';	
		$data['objectId'] = 'rskl';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rskls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'realisasi Kinerja Tingkat Kementerian';	
		$data['objectId'] = 'rsklAdd';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rskl_v',$data);
	}
	
	function grid(){
		echo $this->rskl_model->easyGrid();
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

		// validation
		
		foreach($data['detail'] as $dt){
				$data['tahun'] 			= $data['tahun'];
				$data['triwulan'] 		= $data['triwulan'];
				$data['kode_kl'] 		= $data['kode_kl'];
				$data['kode_sasaran_kl'] = $data['kode_sasaran_kl'];
				$data['kode_iku_kl'] 	= $dt['kode_iku_kl'];
				$data['realisasi'] 		= $dt['realisasi'];
				
				$result = $this->rskl_model->InsertOnDb($data);
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	public function getDetail($tahun="", $kode_kl="", $kode_sasaran_kl="", $objek=""){
		if($tahun == "" || $kode_kl == "" || $kode_sasaran_kl == "" || $kode_sasaran_kl == "0" || $objek==""){
			echo '';
		}else{
			echo $this->rskl_model->getDetail($tahun, $kode_kl, $kode_sasaran_kl, $objek);
		}
		
	}
	
}
?>