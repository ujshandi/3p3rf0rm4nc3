<?php

class Rpt_rktkl extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rencana/rpt_rktkl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Laporan Rencana Kinerja Tahunan Tingkat Kementrian';	
		$data['objectId'] = 'rpt_rktkl';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('rencana/rpt_rktkl_v',$data);
	}
			
	public function grid($filtahun=null,$filsasaran=null,$filiku=null){
		echo $this->rpt_rktkl_model->easyGrid($filtahun,$filsasaran,$filiku);
	}
	
	public function excel($filtahun=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		echo  $this->rpt_rktkl_model->easyGrid($filtahun,$filsasaran,$filiku,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		$this->load->library('our_pdf','our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'A4');             
		$pdfdata = $this->rpt_rktkl_model->easyGrid($filtahun,$filsasaran,$filiku,2,$page,$rows);
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
		
		 $this->our_pdf->text($posX,$posY,'Rencana Kinerja Kementerian');
		//$this->fpdf->Line(10, 12, 280, 12);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun '.$filtahun);
		}
		
					
		$this->our_pdf->setFont('Arial','B',8);
		 $posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(8,12,'No',1,0,'C',1);
		$this->our_pdf->CELL(85,12,'Sasaran Strategis',1,0,'C',1);

		$this->our_pdf->CELL(120,6,'Indikator Kinerja',1,0,'C',1);
		$this->our_pdf->CELL(35,12,'Satuan',1,0,'C',1);
		$this->our_pdf->CELL(25,12,'Target',1,0,'C',1);
		
		//$this->our_pdf->CELL(30,12,'Program & Anggaran',1,0,'C',1);
		
		
		$posY += 6;
		$posX += 93;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(8,6,'No',1,0,'C',1);
		$posX += 8;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(112,6,'Deskripsi',1,0,'C',1);
		
	
		
			
		//$yi = 18;
		$posY = 34;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
	//	 $this->our_pdf->SetWidths(array(8,90,8,82,30,30,30));
		// $this->our_pdf->SetAligns(array("C","L","C","L","R","L","L"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
			$sasaran_strategis ="";
			$program ="";
			$no=0;
	//	$this->our_pdf->addLineFormat( $cols);
		$pageNo=1;
		//var_dump(count($pdfdata));
		 for ($i=0;$i<count($pdfdata);$i++){
			//utk footer
			if ($i==count($pdfdata)-1)	$this->our_pdf->setFont('arial','B',8);	
				
			//$this->our_pdf->Row(array("","",$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5])); 
			$this->our_pdf->setFillColor(255,255,255);
			$this->our_pdf->setFont('arial','',8);	
			//$this->our_pdf->setXY($posX,$posY);
			$newHeightIndikator = $this->our_pdf->getWrapRowHeight(112,$pdfdata[$i][3]);
			$newHeightSasaran = $this->our_pdf->getWrapRowHeight(85,$pdfdata[$i][1]);
			if ($newHeightSasaran>$newHeightIndikator)				
				$newHeight=$newHeightSasaran;
			else
				$newHeight=$newHeightIndikator;
				
			$this->our_pdf->CheckPageBreakChan($newHeight,93);
			$isNewPage = $pageNo != $this->our_pdf->PageNo();
			if ($isNewPage) $pageNo = $this->our_pdf->PageNo();
			if ($sasaran_strategis!=$pdfdata[$i][1]){
				$txt= $pdfdata[$i][1];
					$no++;
				$sisa = substr($txt,80,80); 
				//$txt = substr($txt,0,90);
				$rowMerge = $this->rowMerge($pdfdata[$i][1],$pdfdata)-1;
					$sasaran_strategis=$pdfdata[$i][1];
				$border = '';
				if($this->our_pdf->GetY()+$newHeight>$this->our_pdf->PageBreakTrigger){
					$border = 'LTR';
					
				}
				else if ($i==count($pdfdata)-1)
					$border = "LTBR";
				else if (($i==count($pdfdata)-1)||($isNewPage))
					$border = "LTR";					
				else $border = 'LTR';
				$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][0] ,$border,0,'C',1);
				
				$h= 5*$rowMerge;
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				$this->our_pdf->Wrap(85, 5, trim($txt), ((($i==count($pdfdata))||($isNewPage))?1:"LTR"), 0, 'LM', false, '', 85,  $newHeight2);
				$this->our_pdf->SetXY($x+85,$y);
				}
				else{
					$sisa="tes";
					$x=$this->our_pdf->GetX();
					$y=$this->our_pdf->GetY();
					$txt = substr($txt,0,80);
					$border = 'LR';
					if ($i==count($pdfdata)-1){
						$border = "LBR";
						$this->our_pdf->Line($x,$y+$newHeight,$x+93,$y+$newHeight);
					}
					
					if ($isNewPage) 
						$this->our_pdf->Line($x,$y,$y+93,$y);
					$this->our_pdf->cell(8,$newHeightIndikator,"","LR",0,'C',1);
					//$this->our_pdf->cell(90,$newHeight,$sisa,'LR',0,'L',1);
					$this->our_pdf->SetXY($x+93,$y);
					$sisa = substr($sisa,80,80); 
				}
		
			$this->our_pdf->cell(8,$newHeightIndikator,$pdfdata[$i][2],1,0,'L',1);
			  	$h= $newHeight;
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				$this->our_pdf->Wrap(112, 5, trim($pdfdata[$i][3]), 1, 0, 'LM', false, '', 112, $newHeight2);
				$this->our_pdf->SetXY($x+112,$y); 
				
			$this->our_pdf->cell(35,$newHeightIndikator,$pdfdata[$i][5],1,0,'C',1);
			$this->our_pdf->cell(25,$newHeightIndikator,$pdfdata[$i][4],1,0,'R',1);
			
			if ($newHeightIndikator<$newHeightSasaran)
				$this->our_pdf->Ln($newHeightSasaran);
			else 
				$this->our_pdf->Ln($newHeightIndikator);
			$posY = $posY+$newHeight;
		}  
	
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("LaporanRKTKementerian.pdf","I");
	}
	//element 1= sasaran, 6 program
	private function rowMerge($val,$data,$element=1){
		//hitung beraa row merge dari data tertentu
		$row = 1;
		 for ($i=0;$i<count($data);$i++){
			if ($data[$i][$element]==$val)
				$row++;
		 }
		 return $row;
	}
	
	function getSatuan($id){
		echo $this->rpt_rktkl_model->getSatuan($id);
	}
	
	
	
}
?>
