<?php

class Rpt_pengukurane2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

						
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/pengukuran/rpt_pengukurane2_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/pengaturan/sasaran_eselon2_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Laporan Pengukuran Kinerja Kinerja Eselon II';	
		$data['objectId'] = 'rpt_pengukurane2';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('pengukuran/rpt_pengukurane2_v',$data);
	}
			
	public function grid($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$file2=null){
		echo $this->rpt_pengukurane2_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,$file2);
	}
	
	public function excel($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$file2=null,$page=null,$rows=null){
		echo  $this->rpt_pengukurane2_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,$file2,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$file2=null,$page=null,$rows=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'A4'); 
		$pdfdata = $this->rpt_pengukurane2_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,$file2,2,$page,$rows);
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		$this->our_pdf->Open();
		$this->our_pdf->addPage();
	//	$this->our_pdf->setAutoPageBreak(true,10);
		//var_dump($_REQUEST['page']);
		
		//========= setting judul ============
		
		$this->our_pdf->setFont('arial','',12);
		//$this->fpdf->setXY(100,350);
		//$this->fpdf->SetY(5);
		//$this->fpdf->Line(10, 5, 280, 5);
		$posY = 11;
		$posX = 10;
		$e2='';
		if (($file2 != null)&&($file2 != "-1"))
			$e2=$this->eselon2_model->getNamaE2($file2);
		 $this->our_pdf->text($posX,$posY,'Pengukuran Kinerja  '.($e2!=""?$e2:"Eselon II"));
		//$this->fpdf->Line(10, 12, 280, 12);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun '.$filtahun);
		}
		
		if (($filsasaran != null)&&($filsasaran != "-1")){
			$posY += 5;
			$this->our_pdf->setFont('Arial','',10);
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Sasaran');
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,$this->sasaran_eselon2_model->getDeskripsiSasaranE2($filsasaran,$filtahun));
		}
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(8,12,'No',1,0,'C',1);
		$this->our_pdf->CELL(100,12,'Indikator Kinerja Utama',1,0,'C',1);
		$this->our_pdf->CELL(30,12,'Satuan',1,0,'C',1);
		
		$this->our_pdf->CELL(70,6,'Tahun '.($filtahun-1),1,0,'C',1);
		$this->our_pdf->CELL(70,6,'Tahun '.($filtahun),1,0,'C',1);
		$posY += 6;
		$posX += 138;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(25,6,'Target',1,0,'C',1);
		$posX += 25;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(25,6,'Realisasi',1,0,'C',1);
		$posX += 25;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(20,6,'%',1,0,'C',1);
		$posX += 20;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(25,6,'Target',1,0,'C',1);
		$posX += 25;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(25,6,'Realisasi',1,0,'C',1);
		$posX += 25;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(20,6,'%',1,0,'C',1);
		
			
		//$yi = 18;
		$posY = ((($filsasaran != null)&&($filsasaran != "-1"))?44:34);//34;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		 $this->our_pdf->SetWidths(array(8,100,30,25,25,20,25,25,20));
		 $this->our_pdf->SetAligns(array("C","L","L","R","R","R","R","R","R"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		for ($i=0;$i<count($pdfdata);$i++){
			//utk footer
			if ($i==count($pdfdata)-1)	$this->our_pdf->setFont('arial','B',8);	
			
			$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5],$pdfdata[$i][6],$pdfdata[$i][7],$pdfdata[$i][8])); 
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("LaporanPengukuranEselon2.pdf","I");
	}
}
?>