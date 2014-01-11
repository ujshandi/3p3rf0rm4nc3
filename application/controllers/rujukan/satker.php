<?php

class Satker extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
				
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rujukan/satker_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Satker';		
		$data['objectId'] = 'satker';
	  	$this->load->view('rujukan/satker_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid($file1=null){		
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		echo $this->satker_model->easyGrid($file1,1);
	}
	
	function getListCombo(){
		//echo $this->dokter_model->getListCombo();
	}
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		if ($this->session->userdata('unit_kerja_e1')=='-1')
			$data['kode_e1'] = $this->input->post("kode_e1", TRUE); //id
		else 
			$data['kode_e1'] = $this->session->userdata('unit_kerja_e1');
		$data['kode_satker'] = $this->input->post("kode_satker", TRUE); //id
		$data['nama_satker'] = $this->input->post("nama_satker", TRUE);
		$data['singkatan'] = $this->input->post("singkatan", TRUE);
		$data['nama_kasatker'] = $this->input->post("nama_kasatker", TRUE);
		//$data["insert_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		//$data["update_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		return $data;
    }
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
	
		if($aksi=="add"){ // add
			if (!$this->satker_model->isExistKode($data['kode_satker'])){
				$result = $this->satker_model->InsertOnDb($data,$status);
			}
			else
				$data['pesan_error'] .= 'Kode sudah ada';
					
		} else { // edit
			$result=$this->satker_model->UpdateOnDb($data,$kode);
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'kode'=>$kode));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
//		echo $status;
		
	}
		
	function delete($id=''){
		if($id != ''){
			$result = $this->satker_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function excel($file1=null){
		echo  $this->satker_model->easyGrid($file1,3);
	}
	
	public function pdf($file1=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('P', 'mm', 'A4'); 
		$pdfdata = $this->satker_model->easyGrid($file1,2);
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
		
		 $this->our_pdf->text($posX,$posY,'Daftar Satuan Kerja');
	
		if (($file1 != null)&&($file1 != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,$this->eselon1_model->getNamaE1($file1));
		}
		$posY += 5;
		$this->our_pdf->setFont('Arial','',10);
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->text($posX,$posY,"Kementerian Perhubungan");
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		/* $this->our_pdf->CELL(10,6,'No',1,0,'C',1);
		
		$this->our_pdf->CELL(25,6,'Kode Unit Kerja',1,0,'C',1);
		$this->our_pdf->CELL(100,6,'Nama Unit Kerja',1,0,'C',1);
		$this->our_pdf->CELL(30,6,'Singkatan',1,0,'C',1);
		$this->our_pdf->CELL(40,6,'Nama Pimpinan',1,0,'C',1);
		$this->our_pdf->CELL(25,6,'N I P',1,0,'C',1);
		$this->our_pdf->CELL(25,6,'Pangkat',1,0,'C',1);
		$this->our_pdf->CELL(25,6,'Golongan',1,0,'C',1); */
		$this->our_pdf->SetWidths(array(10,30,80,30,40));
		 $this->our_pdf->SetAligns(array("C","C","C","C","C"));
		$this->our_pdf->Row(array('No.','Kode Satuan Kerja','Nama Satuan Kerja','Singkatan','Nama Kepala Satuan Kerja')); 
			
		//$yi = 18;
		if (($file1 != null)&&($file1 != "-1"))
			$posY = 32;//44;
		else
			$posY = 27;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		// $this->our_pdf->SetWidths(array(10,25,100,30,40,25,25,25));
		 $this->our_pdf->SetAligns(array("C","L","L","L","L"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		$e1 = '';
		for ($i=0;$i<count($pdfdata);$i++){
			$this->our_pdf->setFont('arial','',8);	
			//tambah group
			if (($file1 != null)&&($file1 != "-1")) {
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4])); 
			}
			else {
				if ($e1!=$pdfdata[$i][1]){
					$e1=$pdfdata[$i][1];
					$this->our_pdf->setFont('arial','B',8);	
					$this->our_pdf->CELL(190,5,$this->eselon1_model->getNamaE1($pdfdata[$i][1]),1,0,'L',1);
					$this->our_pdf->Ln(5);
					$this->our_pdf->setFont('arial','',8);	
					
				}
				$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5])); 
			}
			
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output();
	}
	
	public function pdfOld($file1=null){
		$this->load->library('cezpdf');	
		$pdfdata = $this->satker_model->easyGrid($file1,2);
		if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
		//$pdfdata = $pdfdata->rows;
		if (($file1 != null)&&($file1 != "-1"))
			$pdfhead = array('No.','Kode Satuan Kerja','Nama Satuan Kerja','Singkatan','Nama Kepala Satuan Kerja');
		else
			$pdfhead = array('No.','Kode Eselon I','Kode Satuan Kerja','Nama Satuan Kerja','Singkatan','Nama Kepala Satuan Kerja');

		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
	//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
	//	if (($filtahun != null)&&($filtahun != "-1"))
		$title = "";
		if (($file1 != null)&&($file1 != "-1"))
			$title=$this->eselon1_model->getNamaE1($file1);
		$pdf->ezText('Daftar Satuan Kerja '.$title,12,array('left'=>'1'));
		$pdf->ezText('Kementerian Perhubungan',10,array('left'=>'1'));
		$pdf->ezText('');
		//halaman 
		$pdf->ezStartPageNumbers(550,10,8,'right','',1);
		
		if (($file1 != null)&&($file1 != "-1")){
			$cols = array(
				 0=>array('justification'=>'center','width'=>25),
				 1=>array('width'=>60),
				 2=>array('width'=>210),
				 3=>array('width'=>110),
				 4=>array('width'=>120));
		}
		else{
			$cols = array(
				 0=>array('justification'=>'center','width'=>25),
				 1=>array('width'=>40),
				 2=>array('width'=>60),
				 3=>array('width'=>200),
				 4=>array('width'=>100),
				 5=>array('width'=>100));
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
			'width'=>'525'
		);
		
		$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
		$opt['Content-Disposition'] = "SatuanKerja.pdf";
		$pdf->ezStream($opt);
	}
	
	
}
?>