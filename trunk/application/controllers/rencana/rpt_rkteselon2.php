<?php

class Rpt_rkteselon2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rencana/rpt_rkteselon2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Laporan Rencana Kinerja Tahunan Tingkat Eselon 2';	
		$data['objectId'] = 'rpt_rkteselon2';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('rencana/rpt_rkteselon2_v',$data);
	}
	
	
	function grid($filtahun=null,$file2=null,$filsasaran=null,$filikk=null){
		echo $this->rpt_rkteselon2_model->easyGrid($filtahun,$file2,$filsasaran,$filikk);
	}
	
	public function excel($filtahun=null,$file2=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		echo  $this->rpt_rkteselon2_model->easyGrid($filtahun,$file2,$filsasaran,$filiku,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$file2=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		$this->load->library('our_pdf','our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'A4');             
		
		$pdfdata = $this->rpt_rkteselon2_model->easyGrid($filtahun,$file2,$filsasaran,$filiku,2,$page,$rows);
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		$this->our_pdf->Open();
		$this->our_pdf->addPage();
		//========= setting judul ============
		
		$this->our_pdf->setFont('arial','',12);
		
		$posY = 11;
		$posX = 10;
		
		$e2='';
		 $this->our_pdf->text($posX,$posY,'FORMULIR RENCANA KINERJA TAHUNAN');
		 $posY += 5;
		 $this->our_pdf->text($posX,$posY,'TINGKAT UNIT ORGANISASI ESELON II');
		 $posY += 10;
		 
		if (($file2 != null)&&($file2 != "-1")){
			$e2=$this->eselon2_model->getNamaE2($file2);
		 $this->our_pdf->text($posX,$posY,'Unit Organisasi Eselon II : '.$e2);
		}
		else{
			$this->our_pdf->text($posX,$posY,'Unit Organisasi Eselon II : Seluruh Unit Organisasi');
		}
		//$this->fpdf->Line(10, 12, 280, 12);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun Anggaran : '.$filtahun);
		}
		
					
		$this->our_pdf->setFont('Arial','B',8);
		 $posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(8,12,'No',1,0,'C',1);
		$this->our_pdf->CELL(100,12,'Sasaran Strategis',1,0,'C',1);

		$this->our_pdf->CELL(140,6,'Indikator Kinerja',1,0,'C',1);
		$this->our_pdf->CELL(25,12,'Target',1,0,'C',1);
		
		
		
		
		$posY += 6;
		$posX += 108;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(8,6,'No',1,0,'C',1);
		$posX += 8;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->CELL(132,6,'Deskripsi',1,0,'C',1);
		
	
		
			
		//$yi = 18;
		$posY = 49;//34;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
			$sasaran_strategis ="";
			$program ="";
			$no=0;
		$pageNo=1;
		for ($i=0;$i<count($pdfdata);$i++){
			//utk footer
			if ($i==count($pdfdata)-1)	$this->our_pdf->setFont('arial','B',8);	
			
				
		
		//var_dump($sasaran_strategis);
			
			$this->our_pdf->setFillColor(255,255,255);
			$this->our_pdf->setFont('arial','',8);	
			//$this->our_pdf->setXY($posX,$posY);
			$newHeight = $this->our_pdf->getWrapRowHeight(132,$pdfdata[$i][3]);
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
				$border = '';
				if($this->our_pdf->GetY()+$newHeight>$this->our_pdf->PageBreakTrigger){
					$border = 'LTR';					
				}
				else if ($i==count($pdfdata)-1)
					$border = "LTBR";
				else if (($i==count($pdfdata)-1)||($isNewPage))
					$border = "LTR";					
				else $border = 'LTR';
				$xLeftNumber = $this->our_pdf->GetX();
				$yLeftNumber = $this->our_pdf->GetY();
				$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][0] ,$border,0,'C',1);
					
				$h= 5*$rowMerge;
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				
			//((($i==count($pdfdata)-1)||($isNewPage))?1:"LTR")
				$this->our_pdf->Wrap(100, 5, trim($txt),$border , 0, 'LT', false, '', 100,  $newHeightSasaran);
				//var_dump($pdfdata[$i][0].'.=='.$newHeight."=".$rowMerge."=".($newHeightSasaran)."=====>".(($newHeight*$rowMerge)<($y-$newHeightSasaran)));
				$numpuk = (($newHeight*$rowMerge)<($y-$newHeightSasaran));
				if ($numpuk){
					
					$newHeight2 =ceil(($y-$newHeightSasaran)/$rowMerge);
					$newHeight=$newHeight2+(($newHeight2%($newHeight*$rowMerge))==0?0:5);
					//$this->our_pdf->Line($xLeftNumber,$yLeftNumber,$xLeftNumber,$yLeftNumber+$newHeight);
					$this->our_pdf->SetXY($xLeftNumber,$yLeftNumber);
					$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][0] ,$border,0,'C',1);
					//var_dump('----->$newHeight2='.($newHeight2).'--$newHeight='.$newHeight);
					
					
				}
				
				if ($i==count($pdfdata)-1)
					$this->our_pdf->SetXY($x+100,$y);
				else
					$this->our_pdf->SetXY($x+100,$y);
				
			
			}
			else{
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				$border = 'LR';
				if ($i==count($pdfdata)-1){
					$border = "LBR";
					$this->our_pdf->Line($x,$y+$newHeight,$x+108,$y+$newHeight);
				}
				
				if ($isNewPage) 
					$this->our_pdf->Line($x,$y,$y+108,$y);
				$this->our_pdf->cell(8,$newHeight,"",$border,0,'C',1);
				$this->our_pdf->SetXY($x+108,$y);
			}
			//var_dump($this->our_pdf->GetY()+$newHeight."=".$this->our_pdf->PageBreakTrigger);
			//if(($this->our_pdf->PageBreakTrigger-($this->our_pdf->GetY()+$newHeight))<5);
				//$this->our_pdf->Line($x,$y+$newHeight,$x+108,$y+$newHeight);
					
			$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][2],1,0,'L',1);
			
			  	$h= $newHeight;
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				//var_dump("NEWheight=".($numpuk?$newHeight:5));
				$this->our_pdf->Wrap(132, ($numpuk?$newHeight:5), trim($pdfdata[$i][3]), "LBRT", 0, 'LM', false, '', 132,  $newHeight2);
				$this->our_pdf->SetXY($x+132,$y); 
				
			$this->our_pdf->cell(25,$newHeight,$pdfdata[$i][4],1,0,'R',1);
			//$this->our_pdf->cell(35,$newHeight,$pdfdata[$i][5],1,0,'L',1);
			$this->our_pdf->Ln($newHeight);
			$posY = $posY+$newHeight;
		}   
	
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("LaporanRKTEselon2.pdf","I");
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
		echo $this->rktkl_model->getSatuan($id);
	}
	
}
?>
