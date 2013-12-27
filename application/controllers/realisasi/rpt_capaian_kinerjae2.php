<?php

class Rpt_capaian_kinerjae2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/realisasi/rpt_capaian_kinerjae2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Laporan Realisasi Kinerja Eselon II';	
		$data['objectId'] = 'rpt_capaian_kinerjae2';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rpt_capaian_kinerjae2_v',$data);
	}
			
	public function grid($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$file2=null,$filStart=null,$filEnd=null){
		echo $this->rpt_capaian_kinerjae2_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,$file2,$filStart,$filEnd);
	}
	
	public function excel($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$file2=null,$filStart=null,$filEnd=null,$page=null,$rows=null){
		echo  $this->rpt_capaian_kinerjae2_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,$file2,$filStart,$filEnd,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$file2=null,$filStart=null,$filEnd=null,$page=null,$rows=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'legal'); 
		$pdfdata = $this->rpt_capaian_kinerjae2_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,$file2,$filStart,$filEnd,2,$page,$rows);
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
		$e2 = "";
		if (($file2 != null)&&($file2 != "-1"))
			$e2=$this->eselon2_model->getNamaE2($file2);
		 $this->our_pdf->text($posX,$posY,'Realisasi Kinerja '.($e2!=""?$e2:"Eselon II"));
		//$this->fpdf->Line(10, 12, 280, 12);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun '.$filtahun);
		}
		if (($filStart != null)&&($filStart != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Bulan '.$this->utility->getBulanValue($filStart-1)." s/d ".$this->utility->getBulanValue($filEnd-1));
			
		}
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(8,12,'No',1,0,'C',1);
		$this->our_pdf->CELL(80,12,'Indikator Kinerja Utama',1,0,'C',1);
		$this->our_pdf->CELL(25,12,'Satuan',1,0,'C',1);
		$this->our_pdf->CELL(15,12,'Target',1,0,'C',1);
		$this->our_pdf->CELL(195,6,'Realisasi',1,0,'C',1);
		$posY += 6;
		$posX += 128;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Jan',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Feb',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Mar',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Apr',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Mei',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Jun',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Jul',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Ags',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Sep',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Okt',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Nov',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'Des',1,0,'C',1);
		$posX += 15;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(15,6,'%',1,0,'C',1);
		
			
		//$yi = 18;
		$posY = 39;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		$this->our_pdf->SetWidths(array(8,80,25,15,15,15,15,15,15,15,15,15,15,15,15,15,15));
		 $this->our_pdf->SetAligns(array("C","L","L","R","R","R","R","R","R","R","R","R","R","R","R","R","R"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		for ($i=0;$i<count($pdfdata);$i++){
			$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5],$pdfdata[$i][6],$pdfdata[$i][7],$pdfdata[$i][8],$pdfdata[$i][9],$pdfdata[$i][10],$pdfdata[$i][11],$pdfdata[$i][12],$pdfdata[$i][13],$pdfdata[$i][14],$pdfdata[$i][15],$pdfdata[$i][16])); 
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("CapaianKinerjaEselon2.pdf","I");
	}
	
	
}
?>