<?php

class Rpt_penetapaneselon1 extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/penetapan/rpt_penetapaneselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Laporan Penetapan Kinerja Unit Kerja Eselon I';	
		$data['objectId'] = 'rpt_penetapaneselon1';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/rpt_penetapaneselon1_v',$data);
	}
	
	
	function grid($filtahun=null,$file1=null,$filsasaran=null,$filiku=null){
		echo $this->rpt_penetapaneselon1_model->easyGrid($filtahun,$file1,$filsasaran,$filiku);
	}
	
	public function excel($filtahun=null,$file1=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		echo  $this->rpt_penetapaneselon1_model->easyGrid($filtahun,$file1,$filsasaran,$filiku,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$file1=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		$this->load->library('our_pdf','our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'A4');             
		$pdfdata = $this->rpt_penetapaneselon1_model->easyGrid($filtahun,$file1,$filsasaran,$filiku,2,$page,$rows);
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
		 $this->our_pdf->text($posX,$posY,'FORMULIR PENETAPAN KINERJA');
			$posY += 5;
		 $this->our_pdf->text($posX,$posY,'TINGKAT UNIT ORGANISASI ESELON I KEMENTERIAN/LEMBAGA');
			$posY += 10;
		 $this->our_pdf->text($posX,$posY,'Unit Organisasi Eselon I : '.($e1!=""?$e1:"Semua Unit Kerja"));
		//$this->fpdf->Line(10, 12, 280, 12);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun Anggaran             : '.$filtahun);
		}
		
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(8,12,'No',1,0,'C',1);
		$this->our_pdf->CELL(100,12,'Sasaran Strategis',1,0,'C',1);

		$this->our_pdf->CELL(110,6,'Indikator Kinerja Utama',1,0,'C',1);
		$this->our_pdf->CELL(25,12,'Target',1,0,'C',1);
		$this->our_pdf->CELL(35,12,'Satuan',1,0,'C',1);
		
		$posY += 6;
		$posX += 108;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(8,6,'No',1,0,'C',1);
		$posX += 8;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(102,6,'Deskripsi',1,0,'C',1);
		
		//$yi = 18;
		$posY = 49;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		//$this->our_pdf->SetWidths(array(8,90,8,82,30,30,30));
		//$this->our_pdf->SetAligns(array("C","L","C","L","R","L","L"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
			$sasaran_strategis ="";
			$program ="";
			$no=0;
		//$this->our_pdf->addLineFormat( $cols);
		$pageNo=1;
		//var_dump(count($pdfdata));
		for ($i=0;$i<count($pdfdata)-1;$i++){ //tanpa footer
			//utk footer
		//	if ($i==count($pdfdata)-1)	$this->our_pdf->setFont('arial','B',8);	
			
				
		
		//var_dump($sasaran_strategis);
			
			$this->our_pdf->setFillColor(255,255,255);
			$this->our_pdf->setFont('arial','',8);	
			//$this->our_pdf->setXY($posX,$posY);
			$newHeight = $this->our_pdf->getWrapRowHeight(102,$pdfdata[$i][3]);
			$this->our_pdf->CheckPageBreakChan($newHeight,108);
			$isNewPage = $pageNo != $this->our_pdf->PageNo();
			if ($isNewPage) $pageNo = $this->our_pdf->PageNo();
			if ($sasaran_strategis!=$pdfdata[$i][1]){
				$txt= $pdfdata[$i][1];
					$no++;
			
				$sisa = substr($txt,90,90); 
				//$txt = substr($txt,0,90);
				$rowMerge = $this->rowMerge($pdfdata[$i][1],$pdfdata)-1;
					$sasaran_strategis=$pdfdata[$i][1];
				if($this->our_pdf->GetY()+$newHeight>$this->our_pdf->PageBreakTrigger){
					$border = 'LTR';					
				}
				else if ($i==count($pdfdata)-2)
					$border = "LTBR";
				else if (($i==count($pdfdata)-2)||($isNewPage))
					$border = "LTR";					
				else $border = 'LTR';
				$xLeftNumber = $this->our_pdf->GetX();
				$yLeftNumber = $this->our_pdf->GetY();
				$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][0] ,$border,0,'C',1);
					
				$h= 5*$rowMerge;
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
			
				$this->our_pdf->Wrap(100, 5, trim($txt),$border, 0, 'LM', false, '', 100,  $newHeightSasaran);
				
				//var_dump($pdfdata[$i][0].'.=='.$newHeight."=".$rowMerge."=".($newHeightSasaran)."=====>".(($newHeight*$rowMerge)<($y-$newHeightSasaran)));
				$numpuk = (($newHeight*$rowMerge)<($y-$newHeightSasaran));
				if ($numpuk){
					
					$newHeight2 =ceil(($y-$newHeightSasaran)/$rowMerge);
					//var_dump($newHeight2.'='.($newHeight*$rowMerge));
					$newHeight=$newHeight2+(($newHeight2%($newHeight*$rowMerge))==0?0:5);
					//$this->our_pdf->Line($xLeftNumber,$yLeftNumber,$xLeftNumber,$yLeftNumber+$newHeight);
					$this->our_pdf->SetXY($xLeftNumber,$yLeftNumber);
					$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][0] ,$border,0,'C',1);
				}
				
				if ($i==count($pdfdata)-2)
					$this->our_pdf->SetXY($x+100,$y);
				else
					$this->our_pdf->SetXY($x+100,$y);
				
			
			}
			else{
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				$border = 'LR';
				if ($i==count($pdfdata)-2){
					$border = "LBR";
					$this->our_pdf->Line($x,$y+$newHeight,$x+108,$y+$newHeight);
				}
				
				if ($isNewPage) 
					$this->our_pdf->Line($x,$y,$y+108,$y);
				$this->our_pdf->cell(8,$newHeight,"",$border,0,'C',1);
				$this->our_pdf->SetXY($x+108,$y);
			}
			
			
			$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][2],1,0,'L',1);
			
			  	$h= $newHeight;
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				$this->our_pdf->Wrap(102, ($numpuk?$newHeight:5), trim($pdfdata[$i][3]), 1, 0, 'LM', false, '', 102,  $newHeight2);
				$this->our_pdf->SetXY($x+102,$y); 
				
			$this->our_pdf->cell(25,$newHeight,$pdfdata[$i][4],1,0,'R',1);
			$this->our_pdf->cell(35,$newHeight,$pdfdata[$i][5],1,0,'L',1);
			$this->our_pdf->Ln($newHeight);
			$posY = $posY+$newHeight;
		}  
		$this->our_pdf->setFont('arial','B',8);	
		$this->our_pdf->CheckPageBreakChan($newHeight,108);		
		$this->our_pdf->Wrap(100, 5, $pdfdata[$i][3], 0, 0, 'LM', false, '', 100,  $newHeight2);
		$this->our_pdf->Ln($newHeight);
		$this->our_pdf->CheckPageBreakChan($newHeight,108);		
		$this->our_pdf->Wrap(250, 5, $pdfdata[$i][1], 0, 0, 'LM', false, '', 250,  $newHeight2);
		
		
			//add TTD
		$this->our_pdf->setFont('arial','B',10);	
		$this->our_pdf->CheckPageBreakChan($newHeight,108);	
		$menteri = '';
		$x=$this->our_pdf->GetX();
		$y=$this->our_pdf->GetY();
		$this->our_pdf->SetXY($x+220,$y); 
		$this->our_pdf->Wrap(550, 5, 'JAKARTA, '.date('Y'), 0, 0, 'RM', false, '', 250, $newHeight2);
		$this->our_pdf->Ln($newHeight);
		$x=$this->our_pdf->GetX();
		$y=$this->our_pdf->GetY();
		$this->our_pdf->SetXY($x+20,$y); 
		$this->our_pdf->Wrap(250, 5, 'MENTERI PERHUBUNGAN '.$menteri, 0, 0, 'LM', false, '', 250, $newHeight2);
		$this->our_pdf->SetXY($x+220,$y); 
		$this->our_pdf->Wrap(250, 5, 'PEJABAT '.$menteri, 0, 0, 'LM', false, '', 250, $newHeight2);
		$this->our_pdf->Ln($newHeight);
		//end TTD
		
		
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("LaporanPenetapanEselon1.pdf","I");
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
	
}
?>
