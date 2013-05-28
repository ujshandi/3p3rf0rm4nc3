<?php

class Rktkl extends CI_Controller {
	
	var $objectId = 'rktkl';
	
	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rencana/rktkl_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->model('/pengaturan/iku_kl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Rencana Kinerja Tahunan Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('rencana/rktkls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Rencana Kinerja Tahunan Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('rencana/rktkl_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' Rencana Kinerja Tahunan Kementerian';	
		$data['objectId'] = $this->objectId;
		
		$data['result'] = $this->rktkl_model->getDataEdit($id);
		
	  	$this->load->view('rencana/rktkl_v_edit',$data);
	}
	
	public function grid($filtahun=null){
		echo $this->rktkl_model->easyGrid($filtahun);
	}
	
	
	private function get_form_values() {

		$dt['tahun'] = $this->input->post("tahun", TRUE); 
		$dt['kode_kl'] = $this->input->post("kode_kl", TRUE); 
		$dt['kode_sasaran_kl'] = $this->input->post("kode_sasaran_kl", TRUE); 
		$dt['detail'] = $this->input->post("detail", TRUE); 
		
		return $dt;
    }
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$return_id = 0;
		$result = false;
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
				$result = $this->rktkl_model->InsertOnDb($data);
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
			if($r['kode_iku_kl'] == '0'){ // cek kode iku
				$pesan = 'Kode IKU pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			
			if($r['target'] == ''){ // nilai target null
				$pesan = 'Target pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			
			// cek ke database
			if($this->rktkl_model->data_exist($data['tahun'], $data['kode_kl'], $data['kode_sasaran_kl'], $r['kode_iku_kl'])){ 
				$pesan = 'Kode IKU pada no. '.$i.' sudah terdapat di dalam database.';
				//$pesan = 'Kode IKU '.$r['kode_iku_kl'].' sudah terdapat di database';
				return FALSE;
			}
			
			$i++;
		}
		
		// cek kode iku di list (takut kalau ada yang sama ^-^)
		for($x=0, $n=count($data['detail'])-1; $x<$n; $x++){
			for($y=$x+1; $y<=$n; $y++){
				if($data['detail'][$x+1]['kode_iku_kl'] == $data['detail'][$y+1]['kode_iku_kl']){
					$pesan = 'Kode IKU pada list tidak tidak boleh sama <br> Kode yang sama terdapat pada baris '.($x+1).' dan '.($y+1);
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	function save_edit(){
		//$this->load->library('form_validation');
		$return_id = 0;
		$result = "";
		$error = '';
		
		$data['id_rkt_kl'] 			= $this->input->post('id_rkt_kl');
		$data['tahun'] 				= $this->input->post('tahun');
		$data['kode_kl']			= $this->input->post('kode_kl');
		$data['kode_sasaran_kl'] 	= $this->input->post('kode_sasaran_kl');
		$data['kode_iku_kl'] 		= $this->input->post('kode_iku_kl');
		$data['old_kode_iku_kl'] 	= $this->input->post('old_kode_iku_kl');
		$data['target'] 			= $this->input->post('target');
		
		// validation
		if($data['target'] == '' || $data['target'] == null){
			$result = false;
			$error = 'Isi target dengan benar.';
		}else{
			if($data['old_kode_iku_kl'] != $data['kode_iku_kl']){ // jika ada perubahan kode iku
				if(!$this->rktkl_model->data_exist($data['tahun'], $data['kode_kl'], $data['kode_sasaran_kl'], $data['kode_iku_kl'])){
					$result = $this->rktkl_model->UpdateOnDb($data);
				}else{
					$result = false;
					$error = 'IKU sudah digunakan, ganti dengan yang lain';
				}
			}else{
				$result = $this->rktkl_model->UpdateOnDb($data);
			}
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'target'=>$data['target']));
		} else {
			echo json_encode(array('msg'=>$error));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->rktkl_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	function getSatuan($id){
		if($id != '0'){
			echo $this->rktkl_model->getSatuan($id);
		}
	}
	
	function getIKU_kl($tahun=""){
		if($tahun != ""){
			echo $this->rktkl_model->getIKU_kl($this->objectId, $tahun);
		}
	}
	
	public function pdf(){
		$this->load->library('cezpdf');	
			$pdfdata = $this->rktkl_model->easyGrid(2);
			
			//$pdfdata = $pdfdata->rows;
			$pdfhead = array('No.','Kode Sasaran','Indikator Kinerja Utama','Target','Satuan');
			$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
			$pdf->ezText('Rencana Kinerja Tahunan Kementerian',12,array('left'=>'1'));
			$pdf->ezText('Tahun 2012',12,array('left'=>'1'));
			$pdf->ezText('');
		//	if (($filtahun != null)&&($filtahun != "-1"))
			
			// if (($file1 != null)&&($file1 != "-1"))
				// $pdf->ezText($this->eselon1_model->getNamaE1($file1),12,array('left'=>'1'));
			
			//halaman 
			$pdf->ezStartPageNumbers(550,10,12,'right','',1);
			$options = array(
				'showLines' => 2,
				'showHeadings' => 1,
				'fontSize' => 8,
				'rowGap' => 1,
				'shaded' => 0,
				'colGap' => 5,
				'xPos' => 40,
				'xOrientation' => 'right',
					'cols'=>array(
					 0=>array('justification'=>'center','width'=>25),
					 1=>array('width'=>75),
					 2=>array('width'=>220),
					 3=>array('width'=>100),
					 4=>array('width'=>100)),
				'width'=>'520'
			);
			$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
			$opt['Content-Disposition'] = "RKTKementrian.pdf";
			$pdf->ezStream($opt);
		}
		
		public function excel(){
			echo  $this->rktkl_model->easyGrid(3);
		}
	
}
?>