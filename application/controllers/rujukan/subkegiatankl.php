<?php

class Subkegiatankl extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
						
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rujukan/subkegiatankl_model');
		$this->load->model('/rencana/rpt_rkteselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/rujukan/satker_model');
		$this->load->model('/rujukan/kegiatankl_model');
		$this->load->library("utility");
	}
	
	function index(){
		$data['title'] = 'Data Sub Kegiatan';	
		$data['objectId'] = 'subkegiatankl';
	  	$this->load->view('rujukan/subkegiatankls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Data Sub Kegiatan';	
		$data['objectId'] = 'subkegiatankl';
	  	$this->load->view('rujukan/subkegiatankl_v',$data);
	}
	
	public function edit($id){
		$data['title'] = 'Edit Data Sub Kegiatan';	
		$data['objectId'] = 'subkegiatankl';
		$data['result'] = $this->subkegiatankl_model->getDataEdit($id);
	  	$this->load->view('rujukan/subkegiatankl_v_edit',$data);
	}
	
	function grid($file1=null,$file2=null,$tahun=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');
			
		echo $this->subkegiatankl_model->easyGrid($file1,$file2,$tahun);
	}
	
	function getListKegiatan($objectId,$e2,$kode=null,$tahun=""){
		//echo $this->sasaran_eselon2_model->getListSasaranE2($objectId,$e2);
		$data['kode_kegiatan'] = $kode;
		$data['tahun'] = $tahun;
		$data['nama_kegiatan'] = (($kode=='')||($kode=="-1"))?'':$this->kegiatankl_model->getNamaKegiatan($kode);
		echo $this->kegiatankl_model->getListKegiatan($objectId,$e2,$data);
	}
	
	private function get_form_values() {
		$dt['tahun'] 			= $this->input->post("tahun", TRUE);
		$dt['kode_kegiatan'] 	= $this->input->post("kode_kegiatan", TRUE);
		//$dt['kode_satker']		= $this->input->post("kode_satker", TRUE);
		$dt['detail'] 			= $this->input->post("detail", TRUE);
		return $dt;
    }
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$result = "";
		
		$result = $this->subkegiatankl_model->InsertOnDB($data);
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.'));
		}
	}
	
	function save_edit(){
		$this->load->library('form_validation');
		
		$data['id_subkegiatan_kl'] = $this->input->post('id_subkegiatan_kl');
		$data['tahun'] = $this->input->post('tahun');
		$data['kode_subkegiatan'] = $this->input->post('kode_subkegiatan');
		$data['nama_subkegiatan'] = $this->input->post('nama_subkegiatan');
		$data['lokasi'] = $this->input->post('lokasi');
		$data['volume'] = $this->input->post('volume');
		$data['satuan'] = $this->input->post('satuan');
		$data['total'] = $this->input->post('total');
		$data['kode_kegiatan'] = $this->input->post('kode_kegiatan');
		$data['kode_satker'] = $this->input->post('kode_satker');
		
		$result = "";
		
		$result = $this->subkegiatankl_model->UpdateOnDB_subkegiatanKL($data);
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.'));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->subkegiatankl_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function pdf($file1=null,$file2){
		$this->load->library('cezpdf');	
		$pdfdata = $this->subkegiatankl_model->easyGrid($file1,$file2,2);
		if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
		//$pdfdata = $pdfdata->rows;
		if (($file2 != null)&&($file2 != "-1"))
			$pdfhead = array('No.','Tahun','Kode Program','Kode Kegiatan','Nama Kegiatan','Total Anggaran(Rp)');
		else
			$pdfhead = array('No.','Tahun','Kode Eselon II','Kode Program','Kode Kegiatan','Nama Kegiatan','Total Anggaran(Rp)');
			
		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		if (($file1 != null)&&($file1 != "-1"))
			// $title = $this->eselon1_model->getNamaE1($file1);
		$pdf->ezText('Daftar Kegiatan',16,array('left'=>'1'));
		if (($file2 != null)&&($file2 != "-1"))
			$pdf->ezText($this->eselon2_model->getNamaE2($file2),14,array('left'=>'1'));
		$pdf->ezText('Tahun 2012',12,array('left'=>'1'));
		$pdf->ezText('');
		//halaman 
		$pdf->ezStartPageNumbers(550,10,12,'right','',1);
		
		
		if (($file2 != null)&&($file2 != "-1")){
			$cols = array(
				 0=>array('justification'=>'center','width'=>25),
				 1=>array('width'=>75),
				 2=>array('width'=>75),
				 3=>array('width'=>100),
				 4=>array('width'=>155),
				 5=>array('width'=>90));
		}			
		else{
			$cols = array(
				 0=>array('justification'=>'center','width'=>25),
				 1=>array('width'=>50),
				 2=>array('width'=>50),
				 3=>array('width'=>75),
				 4=>array('width'=>90),
				 5=>array('width'=>140),
				 6=>array('width'=>90));
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
		$opt['Content-Disposition'] = "Kegiatan.pdf";
		$pdf->ezStream($opt);
	}
	
	public function excel($file1=null,$file2=null){
		echo  $this->subkegiatankl_model->easyGrid($file1,$file2,3);
	}
}
?>