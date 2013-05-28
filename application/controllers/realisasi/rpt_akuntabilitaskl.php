<?php

class Rpt_akuntabilitaskl extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/realisasi/rpt_akuntabilitaskl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Sebaran IKU Kementerian';	
		$data['objectId'] = 'rpt_akuntabilitaskl';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rpt_akuntabilitaskl_v',$data);
	}
			
	public function grid($filtahun=null,$filsasaran=null,$filiku=null){
		echo $this->rpt_akuntabilitaskl_model->easyGrid($filtahun,$filsasaran,$filiku);
	}
	
	public function excel($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$page=null,$rows=null){
		echo  $this->rpt_akuntabilitaskl_model->easyGrid($filtahun,$filsasaran,$filiku,3,$page,$rows);
	}
	
	public function pdf($filtahun=null,$filsasaran=null,$filiku=null,$page=null,$rows=null){
		$this->load->library('cezpdf');	
		$pdfdata = $this->rpt_akuntabilitaskl_model->easyGrid($filtahun,$filsasaran,$filiku,2,$page,$rows);
		
		//$pdfdata = $pdfdata->rows;
		$pdfhead = array('No.','Sasaran','Jumlah Indikator Kinerja','Keterangan');
		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
		$pdf->ezText('Sebaran IKU Kementerian',16,array('left'=>'1'));
		if (($filtahun != null)&&($filtahun != "-1"))
			$pdf->ezText('Tahun '.$filtahun,12,array('left'=>'1'));
		$pdf->ezText('');
		
		$pdf->ezStartPageNumbers(550,10,12,'right','',1);
		
		$options = array(
			'showLines' => 2,
			'showHeadings' => 1,
			'fontSize' => 8,
			'rowGap' => 1,
			'shaded' => 0,
			'colGap' => 5,
			'xPos' => 40,
			'xOrientation' => 'right',
			'cols'=>array(
                 0=>array('justification'=>'center','width'=>25),
				 1=>array('width'=>300),
				 2=>array('width'=>80),
				 3=>array('width'=>120)),
			'width'=>'700'
		);
		$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
		$opt['Content-Disposition'] = "SebaranIkuKementerian.pdf";
		$pdf->ezStream($opt);
	}
	
	
	/* //BELUM TERPAKAI----
	public function printgrid2($filtahun=null,$filsasaran=null,$filiku=null){
		
		$this->load->library('fpdf');

		//=========== setting general =================== 
		
		$this->fpdf->FPDF('L', 'mm', 'A4'); 
		$pdfdata = $this->absensi_model->GetList();
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		$this->fpdf->Open();
		$this->fpdf->addPage();
		$this->fpdf->setAutoPageBreak(false);

		
		//========= setting judul ============
		
		$this->fpdf->setFont('arial','',12);
		//$this->fpdf->setXY(100,350);
		//$this->fpdf->SetY(5);
		$this->fpdf->Line(10, 5, 280, 5);
		$this->fpdf->text(10,11,'Karyawan');
		$this->fpdf->Line(10, 12, 280, 12);
		
					
		$this->fpdf->setFont('Arial','B',8);
		$this->fpdf->setXY(10,13);
		$this->fpdf->setFillColor(255,255,255);
		$this->fpdf->CELL(8,6,'No',1,0,'C',1);
		$this->fpdf->CELL(20,6,'NIP',1,0,'C',1);
		$this->fpdf->CELL(20,6,'Nama',1,0,'C',1);
		$this->fpdf->CELL(30,6,'Tanggal Masuk',1,0,'C',1);
		$this->fpdf->CELL(20,6,'Kode',1,0,'C',1);
		$this->fpdf->CELL(20,6,'Status',1,0,'C',1);
		$this->fpdf->CELL(40,6,'Jenis Karyawan',1,0,'C',1);
			
		$yi = 18;
		$ya = 44;
		$row = 0;
		
		$ya = $yi + $row;
		$max = 31;
		$row = 6;

		
		//================ setting isi ===========
		
		for ($i=0;$i<count($pdfdata);$i++)
		{

		$this->fpdf->setFillColor(255,255,255);
		$this->fpdf->setFont('arial','',8);	
		$this->fpdf->setXY(10,$ya);
		$this->fpdf->cell(8,6,$i+1,1,0,'C',1);
		$this->fpdf->cell(20,6,$pdfdata[$i][0],1,0,'L',1);
		$this->fpdf->cell(20,6,$pdfdata[$i][1],1,0,'L',1);
		$this->fpdf->cell(30,6,$pdfdata[$i][2],1,0,'L',1);
		$this->fpdf->cell(20,6,$pdfdata[$i][3],1,0,'L',1);
		$this->fpdf->cell(20,6,$pdfdata[$i][4],1,0,'L',1);
		$this->fpdf->cell(40,6,$pdfdata[$i][5],1,0,'L',1);
		$ya = $ya+$row;
		}
		$this->fpdf->AliasNbPages();
		$this->fpdf->Output();
	} */
	
	
}
?>