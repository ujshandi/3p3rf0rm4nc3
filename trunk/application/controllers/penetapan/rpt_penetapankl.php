<?php

class Rpt_penetapankl extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/penetapan/rpt_penetapankl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Laporan Penetapan Kinerja Kementerian';	
		$data['objectId'] = 'rpt_penetapankl';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('penetapan/rpt_penetapankl_v',$data);
	}
			
	public function grid($filtahun=null,$filsasaran=null,$filiku=null){
		echo $this->rpt_penetapankl_model->easyGrid($filtahun,$filsasaran,$filiku);
	}
	function getSatuan($id){
		echo $this->rpt_penetapankl_model->getSatuan($id);
	}
						   
	public function excel($filtahun=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		echo  $this->rpt_penetapankl_model->easyGrid($filtahun,$filsasaran,$filiku,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		$this->load->library('our_pdf','our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'A4');             
		$pdfdata = $this->rpt_penetapankl_model->easyGrid($filtahun,$filsasaran,$filiku,2,$page,$rows);
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
		
		$this->our_pdf->text($posX,$posY,'FORMULIR PENETAPAN KINERJA');
		$posY += 5;
		$this->our_pdf->text($posX,$posY,'TINGKAT KEMENTERIAN/LEMBAGA');
		$posY += 10;
		$this->our_pdf->text($posX,$posY,'Kementerian/Lembaga : Kementerian Perhubungan');
		//$this->fpdf->Line(10, 12, 280, 12);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun Anggaran           : '.$filtahun);
		}
		
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(8,12,'No',1,0,'C',1);
		$this->our_pdf->CELL(100,12,'Sasaran Strategis',1,0,'C',1);

		$this->our_pdf->CELL(110,6,'Indikator Kinerja',1,0,'C',1);
		$this->our_pdf->CELL(25,12,'Target',1,0,'C',1);
		$this->our_pdf->CELL(35,12,'Satuan',1,0,'C',1);
		//$this->our_pdf->CELL(30,12,'Program & Anggaran',1,0,'C',1);
		
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
		 for ($i=0;$i<count($pdfdata)-1;$i++){
			//utk footer
			//if ($i==count($pdfdata)-1)	$this->our_pdf->setFont('arial','B',8);	
			
				
		
		//var_dump($sasaran_strategis);
			//$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5])); 
			//$this->our_pdf->Row(array("","",$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5])); 
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
					//$response->rows[$i]['no']= $no;
				//	$newHeight = $this->our_pdf->getWrapRowHeight(90,$pdfdata[$i][1]);
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
				//Draw the border
				//$this->our_pdf->Rect($x,$y,90,$h); 
				///Print the text
				//$this->our_pdf->MultiCell(90,5,$pdfdata[$i][1],1,"L");
				//$this->our_pdf->cell(90,$h,"tes".$pdfdata[$i][1],1,0,'L',1);
							//		$w, $h=0, $txt='', $border=0, $ln=0, $align='LRB', $fill=false, $link='', $actwidth=88, & $newHeight)
				$this->our_pdf->Wrap(100, 5, trim($txt), $border, 0, 'LM', false, '', 90,  $newHeightSasaran);
				//$this->our_pdf->WordWrap($pdfdata[$i][1],90);
				//Put the position to the right of the cell
				//$this->our_pdf->SetXY($x+90,$y);
				
				$numpuk = (($newHeight*$rowMerge)<($y-$newHeightSasaran));
				if ($numpuk){
					
					$newHeight2 =ceil(($y-$newHeightSasaran)/$rowMerge);
					//var_dump($newHeight2.'='.($newHeight*$rowMerge));
					$newHeight=$newHeight2+(($newHeight2%($newHeight*$rowMerge))==0?0:5);
					//$this->our_pdf->Line($xLeftNumber,$yLeftNumber,$xLeftNumber,$yLeftNumber+$newHeight);
					$this->our_pdf->SetXY($xLeftNumber,$yLeftNumber);
					$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][0] ,$border,0,'C',1);
				}
				
				
				$this->our_pdf->SetXY($x+100,$y);
				
				//	$this->our_pdf->cell(90,$newHeight,$pdfdata[$i][1],((($i==count($pdfdata)-1)||($isNewPage))?1:"LTR"),0,'L',1);
				}
				else{
					//$pdfdata[$i][1]="";
					//$pdfdata[$i][0]="";
					$sisa="tes";
					$x=$this->our_pdf->GetX();
					$y=$this->our_pdf->GetY();
					$txt = substr($txt,0,90);
					$border = 'LR';
					if ($i==count($pdfdata)-2){
						$border = "LBR";
						$this->our_pdf->Line($x,$y+$newHeight,$x+108,$y+$newHeight);
					}
					
					if ($isNewPage) 
						$this->our_pdf->Line($x,$y,$y+108,$y);
					$this->our_pdf->cell(8,$newHeight,"",$border,0,'C',1);
					//$this->our_pdf->cell(90,$newHeight,$sisa,'LR',0,'L',1);
					$this->our_pdf->SetXY($x+108,$y);
					$sisa = substr($sisa,90,90); 
				}
			
			//$w, $h=0, $txt='', $border=0, $ln=0, $align='LRB', $fill=false, $link='', $actwidth=88, & $newHeight
			//$this->our_pdf->Wrap(100,$newHeight,$pdfdata[$i][1],1,0,'L',1,'',100,$newHeight);
			//($w, $h, $txt, $border=0, $align='J', $fill=0, $maxline=0)
				
			//$this->our_pdf->cell(90,$newHeight,$pdfdata[$i][1],1,0,'L',1);
		
			$this->our_pdf->cell(8,$newHeight,$pdfdata[$i][2],1,0,'L',1);
		//	$this->our_pdf->cell(82,$newHeight,$pdfdata[$i][3],1,0,'L',1);
			//$this->our_pdf->MultiCell(82,6,$pdfdata[$i][3],0,'L');
			
			  	$h= $newHeight;
				$x=$this->our_pdf->GetX();
				$y=$this->our_pdf->GetY();
				//Draw the border
				//$this->our_pdf->Rect($x,$y,82,$h); 
				//Print the text
				//$this->our_pdf->MultiCell(82,5,$pdfdata[$i][3],0,"L");
				$this->our_pdf->Wrap(102, ($numpuk?$newHeight:5), trim($pdfdata[$i][3]), 1, 0, 'LM', false, '', 102,  $newHeight2);
				//Put the position to the right of the cell
				$this->our_pdf->SetXY($x+102,$y); 
				
			$this->our_pdf->cell(25,$newHeight,$pdfdata[$i][4],1,0,'R',1);
			$this->our_pdf->cell(35,$newHeight,$pdfdata[$i][5],1,0,'L',1);
			//$this->our_pdf->MultiCell(30,5,$pdfdata[$i][5],"LBRT","L");
			//$this->our_pdf->Wrap(30, 5, trim($pdfdata[$i][5]), 'LTB', 0, 'LM', false, '', 90, & $newHeight2);
		
			$this->our_pdf->Ln($newHeight);
			$posY = $posY+$newHeight;
		}  

		$this->our_pdf->setFont('arial','B',8);	
		$this->our_pdf->CheckPageBreakChan($newHeight,108);		
		$this->our_pdf->Wrap(100, 5, $pdfdata[$i][1]." : ".$pdfdata[$i][3], 0, 0, 'LM', false, '', 100, $newHeight2);
		$this->our_pdf->Ln($newHeight);
		$program = $this->rpt_penetapankl_model->getProgram(true);
		foreach($program->result() as $r){
			$this->our_pdf->CheckPageBreak($newHeight);		
		$this->our_pdf->Wrap(250, 5, 'Program : '.$r->nama_program.'. Anggaran : '.$this->utility->cekNumericFmt($r->total), 0, 0, 'LM', false, '', 250, $newHeight2);
			$this->our_pdf->Ln($newHeight);
		}
		

		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("LaporanPenetapanKementerian.pdf","I");
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
