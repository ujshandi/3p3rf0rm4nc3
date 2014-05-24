<?php

class Rkteselon2 extends CI_Controller {
	
	var $objectId = 'rkteselon2';
	
	function __construct()
	{
		parent::__construct();			
		
		//$this->output->enable_profiler(true);
		
		
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rencana/rkteselon2_model');
		$this->load->model('/rencana/rpt_rkteselon2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/pengaturan/sasaran_eselon2_model');
		$this->load->model('/pengaturan/ikk_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Rencana Kinerja Tahunan Eselon II';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('rencana/rkteselon2s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Rencana Kinerja Tahunan Eselon II';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('rencana/rkteselon2_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' Rencana Kinerja Tahunan Eselon II';
		$data['objectId'] = $this->objectId;
		
		$data['result'] = $this->rkteselon2_model->getDataEdit($id);
		
	  	$this->load->view('rencana/rkteselon2_v_edit',$data);
	}
	
	function grid($filtahun=null, $file1=null, $file2=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');
		
		$file1 = $file1 == null?'-1':$file1;
		$file2 = $file2 == null?'-1':$file2;
		
		echo $this->rkteselon2_model->easyGrid($filtahun, $file1, $file2);
	}
	
	function getListSasaranE2($objectId,$kode="",$tahun=""){
		//echo $this->sasaran_eselon2_model->getListSasaranE2($objectId,$e2);
		$data['tahun'] = $tahun;
		$data['kode'] = $kode;
		$data['deskripsi'] = ($kode=='')?'':$this->sasaran_eselon2_model->getDeskripsiSasaranE2($kode, $tahun);
		echo $this->sasaran_eselon2_model->getListSasaranE2($objectId,$kode,$data);
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
	
	function save($menu_id=""){
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
				$result = $this->rkteselon2_model->saveToDb($data);
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
			if($r['kode_ikk'] == '0'){ // cek kode
				$pesan = 'Kode IKK pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			
			if($r['target'] == ''){ // nilai target null
				$pesan = 'Target pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			
			// cek ke database  ga perlu coz cek if id sudah ada update aja jika belum ada maka insert
			/* if($this->rkteselon2_model->data_exist($data['tahun'], $data['kode_e2'], $data['kode_sasaran_e2'], $r['kode_ikk'])){ 
				$pesan = 'Kode IKK pada no. '.$i.' sudah terdapat di dalam database.';
				//$pesan = 'Kode IKU '.$r['kode_iku_kl'].' sudah terdapat di database';
				return FALSE;
			} */
			
			$i++;
		}
		
		// cek kode ikk di list (takut kalau ada yang sama ^-^)
		for($x=0, $n=count($data['detail'])-1; $x<$n; $x++){
			for($y=$x+1; $y<=$n; $y++){
				if($data['detail'][$x+1]['kode_ikk'] == $data['detail'][$y+1]['kode_ikk']){
					$pesan = 'Kode IKK pada list tidak tidak boleh sama <br> Kode yang sama terdapat pada baris '.($x+1).' dan '.($y+1);
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	function save_edit(){
		$this->load->library('form_validation');
		$return_id = 0;
		$result = "";
		$error = '';
		
		$data['id_rkt_e2'] 			= $this->input->post('id_rkt_e2');
		$data['tahun'] 				= $this->input->post('tahun');
		$data['kode_e2']			= $this->input->post('kode_e2');
		$data['kode_sasaran_e2'] 	= $this->input->post('kode_sasaran_e2');
		$data['kode_ikk'] 			= $this->input->post('old_kode_ikk');
		$data['old_kode_ikk'] 		= $this->input->post('old_kode_ikk');
		$data['target'] 			= $this->input->post('target');
		
		// validation
		if($data['target'] == '' || $data['target'] == null){
			$result = false;
			$error = 'Isi target dengan benar.';
		}else{
			if($data['old_kode_ikk'] != $data['kode_ikk']){ // jika ada perubahan kode ikk
				if(!$this->rkteselon2_model->data_exist($data['tahun'], $data['kode_e2'], $data['kode_sasaran_e2'], $data['kode_ikk'])){
					$result = $this->rkteselon2_model->UpdateOnDb($data);
				}else{
					$result = false;
					$error = 'IKU sudah digunakan, ganti dengan yang lain';
				}
			}else{
				$result = $this->rkteselon2_model->UpdateOnDb($data);
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
			$data=$this->rkteselon2_model->getDataEdit($id);
			if (!$this->rkteselon2_model->isSaveDelete($data->tahun,$data->kode_e2,$data->kode_sasaran_e2,$data->kode_ikk)){
				echo json_encode(array('msg'=>'Data tidak bisa dihapus. karena sudah ada di PK', 'data'=> ''));
			}
			else {
				$result = $this->rkteselon2_model->DeleteOnDb($id);
				if ($result){
					echo json_encode(array('success'=>true, 'haha'=>''));
				} else {
					echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
				}
			}
		}
	}
	
	function getSatuan($id){
		if($id != '0'){
			echo $this->rkteselon2_model->getSatuan($id);
		}
	}
	
	function getIKK($kode, $tahun="", $sasaran=""){
		if($kode != '0' && $tahun != ""){
			echo $this->rkteselon2_model->getIKK($this->objectId, $kode, $tahun,$sasaran);
		}
	}
	
	public function pdf($file1=null,$file2){
		$this->load->library('cezpdf');	
		$pdfdata = $this->rkteselon2_model->easyGrid($file1,$file2,2);
		
		//$pdfdata = $pdfdata->rows;
		if (($file1 != null)&&($file1 != "-1"))
			if (($file2 != null)&&($file2 != "-1"))
				$pdfhead = array('No.','Kode Sasaran','Indikator Kinerja Kegiatan','Target','Satuan');
			else
				$pdfhead = array('No.','Kode Unit Kerja','Kode Sasaran','Indikator Kinerja Kegiatan','Target','Satuan');
		else
			$pdfhead = array('No.','Kode Unit Kerja','Kode Sasaran','Indikator Kinerja Kegiatan','Target','Satuan');
			
		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		$title = "Tingkat Eselon II";
			if (($file1 != null)&&($file1 != "-1"))
				// $title = $this->eselon1_model->getNamaE1($file1);
			if (($file2 != null)&&($file2 != "-1"))
				$title = $this->eselon2_model->getNamaE2($file2);
				// $pdf->ezText($this->eselon2_model->getNamaE2($file2),11,array('left'=>'1'));
			$pdf->ezText('Rencana Kinerja Tahunan '.$title,16,array('left'=>'1'));
			$pdf->ezText('Tahun 2012',12,array('left'=>'1'));
			$pdf->ezText('');
		//halaman 
		$pdf->ezStartPageNumbers(550,10,12,'right','',1);
		
		
		if (($file1 != null)&&($file1 != "-1")){
			if (($file2 != null)&&($file2 != "-1")){
				$cols = array(
					 0=>array('justification'=>'center','width'=>25),
					 1=>array('width'=>75),
					 2=>array('width'=>245),
					 3=>array('width'=>75),
					 4=>array('width'=>100));
					 //2=>array('width'=>75),
					 //3=>array('width'=>245),
					 //4=>array('width'=>100));
			}
			else{
				$cols = array(
					 0=>array('justification'=>'center','width'=>25),
					 1=>array('width'=>75),
					 2=>array('width'=>75),
					 3=>array('width'=>170),
					 4=>array('width'=>75),
					 5=>array('width'=>100));
					 //3=>array('width'=>75),
					 //4=>array('width'=>170),
					 //5=>array('width'=>100));
			}
		}			
		else{
			$cols = array(
				 0=>array('justification'=>'center','width'=>25),
				1=>array('width'=>75),
				 2=>array('width'=>75),
				 3=>array('width'=>170),
				 4=>array('width'=>75),
				 5=>array('width'=>100));
				 //3=>array('width'=>75),
				 //4=>array('width'=>170),
				 //5=>array('width'=>100));
		}
		
		$options = array(
			'showLines' => 2,
			'showHeadings' => 1,
			'fontSize' => 8,
			'rowGap' => 1,
			'shaded' => 0,
			'colGap' => 5,
			'xPos' => 40,
			'xOrientation' => 'right',
				'cols'=>$cols,
			'width'=>'520'
		);
		$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
		$opt['Content-Disposition'] = "RKTEselon2.pdf";
		$pdf->ezStream($opt);
	}
	
	public function excel($file1=null,$file2=null){
		echo  $this->rkteselon2_model->easyGrid($file1,$file2,3);
	}
}
?>