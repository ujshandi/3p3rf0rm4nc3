<?php

class Rpt_akuntabilitase1 extends CI_Controller {

	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/realisasi/rpt_akuntabilitase1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Sebaran IKU Eselon I';	
		$data['objectId'] = 'rpt_akuntabilitase1';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('realisasi/rpt_akuntabilitase1_v',$data);
	}
			
	public function grid($filtahun=null,$filsasaran=null,$filiku=null,$file1=null){
		echo $this->rpt_akuntabilitase1_model->easyGrid($filtahun,$filsasaran,$filiku,$file1);
	}
	
	public function excel($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$page=null,$rows=null){
		echo  $this->rpt_akuntabilitase1_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,3,$page,$rows);
	}
	
	//to pdf
	public function pdf($filtahun=null,$filsasaran=null,$filiku=null,$file1=null,$page=null,$rows=null){
		$this->load->library('cezpdf');	
		$pdfdata = $this->rpt_akuntabilitase1_model->easyGrid($filtahun,$filsasaran,$filiku,$file1,2,$page,$rows);
		
		//$pdfdata = $pdfdata->rows;
		$pdfhead = array('No.','Sasaran','Jumlah Indikator Kinerja','Keterangan');
		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
	//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
		$e1 = "";
		if (($file1 != null)&&($file1 != "-1"))
			$e1=$this->eselon1_model->getNamaE1($file1);
		$pdf->ezText('Sebaran IKU '.($e1!=""?$e1:"Eselon I "),16,array('left'=>'1'));
	//	if (($filtahun != null)&&($filtahun != "-1"))
		//	$pdf->ezText('Tahun '.$filtahun,12,array('left'=>'1'));
		
		$pdf->ezText('');
		//halaman 
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
		$opt['Content-Disposition'] = "SebaranIkuEselon1.pdf";
		$pdf->ezStream($opt);
	}
	
	
}
?>