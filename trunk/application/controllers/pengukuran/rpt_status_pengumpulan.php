<?php

class Rpt_status_pengumpulan extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/admin/user_model');
		$this->load->model('/pengukuran/rpt_status_pengumpulan_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Laporan Status Pengumpulan Data Kinerja';	
		$data['objectId'] = 'rpt_status_pengukuran';
		
	  	$this->load->view('pengukuran/rpt_status_pengumpulan_v',$data);
	}
			
	public function grid($filtahun=null,$filAppType=null,$file1=null,$file2=null,$filStart=null,$filEnd=null){
		echo $this->rpt_status_pengumpulan_model->easyGrid($filtahun,$filAppType,$file1,null,$filStart,$filEnd);
	}
	
	public function excel($filtahun=null,$filAppType=null,$file1=null,$file2=null,$filStart=null,$filEnd=null,$page=null,$rows=null){
		echo  $this->rpt_status_pengumpulan_model->easyGrid($filtahun,$filAppType,$file1,null,$filStart,$filEnd,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$filAppType=null,$file1=null,$file2=null,$filStart=null,$filEnd=null,$page=null,$rows=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'A4'); 
		$pdfdata = $this->rpt_status_pengumpulan_model->easyGrid($filtahun,$filAppType,$file1,null,$filStart,$filEnd,2,$page,$rows);
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
		$e1='';
		if (($file1 != null)&&($file1 != "-1"))
			$e1=$this->eselon1_model->getNamaE1($file1);
		 $this->our_pdf->text($posX,$posY,'Status Pengumpulan Data Kinerja '.($filAppType=="KL"?"Tingkat Kementerian":($filAppType=="E1"?"Tingkat Eselon 1":($filAppType=="E2"?"Tingkat Eselon 2":""))));
		//$this->fpdf->Line(10, 12, 280, 12);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun '.$filtahun);
		}
		if (($filStart != null)&&($filStart != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Bulan '.$this->utility->getBulanValue($filStart)." s/d ".$this->utility->getBulanValue($filEnd-1));
			
		}
		
		
		/* if (($filsasaran != null)&&($filsasaran != "-1")){
			$posY += 5;
			$this->our_pdf->setFont('Arial','',10);
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Sasaran');
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,$this->sasaran_eselon1_model->getDeskripsiSasaranE1($filsasaran));
		} */
		
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(8,6,'No',1,0,'C',1);
		$this->our_pdf->CELL(150,6,'Unit Kerja',1,0,'C',1);
		
		
		
		//$posY += 6;
		$posX += 158;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Jan',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Feb',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Mar',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Apr',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Mei',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Jun',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Jul',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Ags',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Sep',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Okt',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Nov',1,0,'C',1);
		$posX += 10;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(10,6,'Des',1,0,'C',1);
		
			
		//$yi = 18;
		$posY = 33;//34;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		 $this->our_pdf->SetWidths(array(8,150,10,10,10,10,10,10,10,10,10,10,10,10));
		 $this->our_pdf->SetAligns(array("C","L","C","C","C","C","C","C","C","C","C","C","C","C"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		for ($i=0;$i<count($pdfdata);$i++){
			//utk footer
		//	if ($i==count($pdfdata)-1)	$this->our_pdf->setFont('arial','B',8);	
			$color = array($this->getColor($pdfdata[$i][0]),$this->getColor($pdfdata[$i][1]),$this->getColor($pdfdata[$i][2]),$this->getColor($pdfdata[$i][3]),$this->getColor($pdfdata[$i][4]),$this->getColor($pdfdata[$i][5]),$this->getColor($pdfdata[$i][6]),$this->getColor($pdfdata[$i][7]),$this->getColor($pdfdata[$i][8]),$this->getColor($pdfdata[$i][9]),$this->getColor($pdfdata[$i][10]),$this->getColor($pdfdata[$i][11]),$this->getColor($pdfdata[$i][12]),$this->getColor($pdfdata[$i][13]));
			$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5],$pdfdata[$i][6],$pdfdata[$i][7],$pdfdata[$i][8],$pdfdata[$i][9],$pdfdata[$i][10],$pdfdata[$i][11],$pdfdata[$i][12],$pdfdata[$i][13]),$color); 
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("StatusPengumpulanDataKinerja.pdf","I");
	}
	
	public function getColor($val){
		switch ($val){
			case "K" : return "red";
			case "TL" : return "yellow";
			case "L" : return "green";
			default : return "white";
		}
	}
}
?>