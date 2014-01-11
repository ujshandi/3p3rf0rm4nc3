<?php

class Kegiatankl extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rujukan/kegiatankl_model');
		$this->load->model('/rencana/rpt_rkteselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/rujukan/programkl_model');
		$this->load->library("utility");
	}
	
	function index(){
		$data['title'] = 'Data Kegiatan';	
		$data['objectId'] = 'kegiatankl';
	  	$this->load->view('rujukan/kegiatankls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Data Kegiatan';	
		$data['objectId'] = 'kegiatankl';
		$result = new stdClass();
		
		$result->tahun = '';
		$result->kode_e1 = $this->session->userdata('unit_kerja_e1');
		$result->kode_e2 = '';
		$result->kode_program = '';
		$result->nama_program = '';
		$result->total = '';
		$result->kode_kegiatan = '';
		$result->nama_kegiatan = '';
		$data['result'] = $result;
		$data['editMode'] = false;
	  	//$this->load->view('rujukan/kegiatankl_v',$data);
	  	$this->load->view('rujukan/kegiatankl_v_edit',$data);
	}
	
	public function edit($tahun,$kode_kegiatan){
		$data['title'] = 'Edit Data Kegiatan';	
		$data['objectId'] = 'kegiatankl';
		$data['editMode'] = true;
		$data['result'] = $this->kegiatankl_model->getDataEdit($tahun,$kode_kegiatan);
	  	$this->load->view('rujukan/kegiatankl_v_edit',$data);
	}
	
	function grid($file1=null,$file2=null,$filtahun=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');
		echo $this->kegiatankl_model->easyGrid($file1,$file2,$filtahun);
	}
	
	private function get_form_values() {
		$dt['kode_e2'] 		= $this->input->post("kode_e2", TRUE);
		$dt['tahun'] 		= $this->input->post("tahun", TRUE);
		$dt['kode_program'] = $this->input->post("kode_program", TRUE);
		$dt['detail'] 		= $this->input->post("detail", TRUE);
		return $dt;
    }
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$result = "";
		//var_dump($data['detail']);die;
		foreach($data['detail'] as $dt){
			$data['tahun'] 			= $data['tahun'];
			$data['kode_program'] 	= $data['kode_program'];
			$data['kode_kegiatan'] 	= $dt['kode_kegiatan'];
			$data['nama_kegiatan'] 	= $dt['nama_kegiatan'];
			$data['total']			= $dt['total'];
			$data['kode_e2'] 		= $data['kode_e2'];
			$result = $this->kegiatankl_model->InsertOnDB_kegiatanKL($data);
		}
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.'));
		}
	}
	
	function save_edit(){
		$this->load->library('form_validation');
		
		//$data['id_kegiatan_kl'] = $this->input->post('id_kegiatan_kl');
		$data['tahun'] = $this->input->post('tahun');
		$data['tahun_old'] = $this->input->post('tahun_old');
		$data['kode_kegiatan'] = $this->input->post('kode_kegiatan');
		$data['kode_kegiatan_old'] = $this->input->post('kode_kegiatan_old');
		$data['nama_kegiatan'] = $this->input->post('nama_kegiatan');
		$data['total'] = $this->input->post('total');
		$data['kode_e2'] = $this->input->post('kode_e2');
		$data['kode_program'] = $this->input->post('kode_program');
		
		$result = false;
		
		if ($data['tahun_old']==''||$data['kode_program']=='') {
			if ($this->kegiatankl_model->isExist($data['tahun'],$data['kode_kegiatan'])){
				$result = false;
				$msg = 'Kode Kegiatan '.$data['kode_kegiatan'].'untuk tahun '.$data['tahun'].' sudah ada.';
			}				
			else $result = $this->kegiatankl_model->InsertOnDB_kegiatanKL($data);
				
		}else {
			if ($this->kegiatankl_model->isExist($data['tahun'],$data['kode_kegiatan'],$data['tahun_old'],$data['kode_kegiatan_old'])){
				$result = false;
				$msg = 'Kode Kegiatan '.$data['kode_kegiatan'].'untuk tahun '.$data['tahun'].' sudah ada.';
			}				
			else $result = $this->kegiatankl_model->UpdateOnDB_kegiatanKL($data);
		}
		
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>$msg));
		}
	}
	
	function delete($tahun='',$kode_kegiatan=''){
		if($tahun != ''){
			if ($this->kegiatankl_model->isSaveDelete($kode_kegiatan,$tahun))
				$result = $this->kegiatankl_model->DeleteOnDb($tahun,$kode_kegiatan);
			else
				$result = false;
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Data tidak bisa dihapus karena sudah digunakan sebagai referensi data lainnya.', 'data'=> ''));
			}
		}
	}
	
	public function excel($file1=null,$file2=null,$filtahun=null){
		echo  $this->kegiatankl_model->easyGrid($file1,$file2,$filtahun,3);
	}
	
	public function pdf($file1=null,$file2=null,$filtahun=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('P', 'mm', 'A4'); 
		$pdfdata = $this->kegiatankl_model->easyGrid($file1,$file2,$filtahun,2);
		if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		$this->our_pdf->Open();
		$this->our_pdf->addPage();
	
		//========= setting judul ============
		
		$this->our_pdf->setFont('arial','',12);
		$posY = 11;
		$posX = 10;
		
		$e1= '';
		if (($file1 != null)&&($file1 != "-1")){
			$e1=$this->eselon1_model->getNamaE1($file1);
		}
		$this->our_pdf->text($posX,$posY,'Daftar Program '.$e1);
		$this->our_pdf->setFont('Arial','',10);

		if (($file2 != null)&&($file2 != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,$this->eselon2_model->getNamaE2($file2));
		}
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun '.$filtahun);
		}
		
		$posY += 5;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->text($posX,$posY,"Kementerian Perhubungan");
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		
		$this->our_pdf->SetWidths(array(10,12,25,25,90,30));
		 $this->our_pdf->SetAligns(array("C","C","C","C","C","C"));
		$this->our_pdf->Row(array('No.','Tahun','Kode Program','Kode Kegiatan','Nama Kegiatan','Total Anggaran(Rp)')); 
			
		//$yi = 18;
		if (($filtahun != null)&&($filtahun != "-1")&&($file2 != null)&&($file2 != "-1"))
			$posY = 37;//44;
		else if (($file2 != null)&&($file2 != "-1"))
			$posY = 32	;//44;
		else
			$posY = 27;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		// $this->our_pdf->SetWidths(array(10,25,100,30,40,25,25,25));
		 $this->our_pdf->SetAligns(array("C","C","L","L","L","R"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		$e1 = '';
		for ($i=0;$i<count($pdfdata);$i++){
			$this->our_pdf->setFont('arial','',8);	
			//tambah group
			if (($file2 != null)&&($file2 != "-1")) {
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5])); 
			}
			else {
				if ($e1!=$pdfdata[$i][6]){
					$e1=$pdfdata[$i][6];
					$this->our_pdf->setFont('arial','B',8);	
					$this->our_pdf->CELL(192,5,$this->eselon2_model->getNamaE2($pdfdata[$i][6]),1,0,'L',1);
					$this->our_pdf->Ln(5);
					$this->our_pdf->setFont('arial','',8);	
					
				}
				$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5])); 
			}
			
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("Kegiatan.pdf","I");
	}
	
	public function pdfOld($file1=null,$file2){
		$this->load->library('cezpdf');	
		$pdfdata = $this->kegiatankl_model->easyGrid($file1,$file2,2);
		if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
		//$pdfdata = $pdfdata->rows;
		if (($file2 != null)&&($file2 != "-1"))
			$pdfhead = array('No.','Tahun','Kode Program','Kode Kegiatan','Nama Kegiatan','Total Anggaran(Rp)');
		else
			$pdfhead = array('No.','Tahun','Kode Program','Kode Kegiatan','Nama Kegiatan','Total Anggaran(Rp)','Kode Bidang');
			
		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );

		if (($file1 != null)&&($file1 != "-1"))
			$title=$this->eselon1_model->getNamaE1($file1);
		else
			$title = "Kementerian Perhubungan";
		$pdf->ezText('Daftar Kegiatan '.$title,16,array('left'=>'1'));
		if (($file2 != null)&&($file2 != "-1"))
			$pdf->ezText($this->eselon2_model->getNamaE2($file2),14,array('left'=>'1'));
		$pdf->ezText('Tahun 2012',12,array('left'=>'1'));
		$pdf->ezText('');
		//halaman 
		$pdf->ezStartPageNumbers(550,10,12,'right','',1);
		
		
		if (($file2 != null)&&($file2 != "-1")){
			$cols = array(
				 0=>array('justification'=>'right','width'=>25),
				 1=>array('justification'=>'center','width'=>40),
				 2=>array('justification'=>'center','width'=>65),
				 3=>array('justification'=>'center','width'=>75),
				 4=>array('width'=>230),
				 5=>array('justification'=>'right','width'=>85));
		}			
		else{
			$cols = array(
				 0=>array('justification'=>'right','width'=>25),
				 1=>array('justification'=>'center','width'=>40),
				 2=>array('justification'=>'center','width'=>65),
				 3=>array('justification'=>'center','width'=>75),
				 4=>array('width'=>180),
				 5=>array('justification'=>'right','width'=>85),
				 6=>array('width'=>50));
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
	
	public function getListTahun($objectId=null){
		echo $this->kegiatankl_model->getListTahun($objectId);
	}
}
?>
