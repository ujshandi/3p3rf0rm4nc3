<?php

class login_log extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
						
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rujukan/eselon1_model');	
		$this->load->model('/rujukan/eselon2_model');	
		$this->load->model('/utility/login_log_model');	
		$this->load->library("utility");
		$this->load->helper('form');
		
	}
	
	function index(){
		$data['title'] = 'Histori Login';		
		$data['objectId'] = 'historiLogin';
	  	$this->load->view('utility/login_logs_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	
	function grid($fileawal=null,$fileakhir=null,$file1=null,$file2=null){
		$fileawal = $this->utility->ourDeFormatSQLDate($fileawal);
		$fileakhir = $this->utility->ourDeFormatSQLDate($fileakhir);
		echo $this->login_log_model->easyGrid($fileawal,$fileakhir,$file1,$file2,1);
	}
	
	function pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->login_log_model->easyGrid($filtahun,2);
			if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
			//$pdfdata = $pdfdata->rows;
			$pdfhead = array('No.','Kode Sasaran','Deskripsi Sasaran','Status','User','Waktu');
			$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
			$pdf->ezText('Daftar Sasaran Strategis Kementerian Perhubungan',12,array('left'=>'1'));
		//	if (($filtahun != null)&&($filtahun != "-1"))
		//	$pdf->ezText('Tahun 2012',12,array('left'=>'1'));
			// if (($file1 != null)&&($file1 != "-1"))
				// $pdf->ezText($this->eselon1_model->getNamaE1($file1),12,array('left'=>'1'));
			$pdf->ezText('');
			//halaman 
			$pdf->ezStartPageNumbers(550,10,8,'right','',1);
			
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
					 1=>array('width'=>75),
					 2=>array('width'=>200),
					 3=>array('width'=>50),
					 4=>array('width'=>30),
					 5=>array('width'=>50)
					 ),
				'width'=>'520'
			);
			$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
			$opt['Content-Disposition'] = "Histori_RencanaKementerian.pdf";
			$pdf->ezStream($opt);
	}
	
	function excel($filtahun=null){
		echo  $this->login_log_model->easyGrid($filtahun,3);
	}
	
	
}
?>
