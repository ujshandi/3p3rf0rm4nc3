<?php

class histori_pengaturan extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
		//$this->output->enable_profiler(true);
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		$userdata = array ('logged_in' => TRUE);
				//
		$this->session->set_userdata($userdata);
				
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/utility/histori_pengaturan_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/pengaturan/sasaran_eselon2_model');
		$this->load->library("utility");
		$this->load->helper('form');
		
	}
	
	function index(){
		$data['title'] = 'HIstori utility';		
		$data['objectId'] = 'Historiutility';
	  	$this->load->view('utility/histori_pengaturan_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	
	function sasaranKL_grid($filtahun=null){
		echo $this->histori_pengaturan_model->sasaranKL_grid($filtahun,1);
	}
	
	function sasaranKL_pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_pengaturan_model->sasaranKL_grid($filtahun,2);
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
			$opt['Content-Disposition'] = "HIstori_SasaranKementerian.pdf";
			$pdf->ezStream($opt);
	}
	
	function sasaranKL_excel($filtahun=null){
		echo  $this->histori_pengaturan_model->sasaranKL_grid($filtahun,3);
	}
	
	
	function sasaranE1_grid($filtahun=null){
		echo $this->histori_pengaturan_model->sasaranE1_grid(null, $filtahun,1);
	}
	
	function sasaranE1_pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_pengaturan_model->sasaranE1_grid(null, $filtahun,2);
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
			$pdf->ezText('Daftar Sasaran Strategis Eselon I',12,array('left'=>'1'));
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
			$opt['Content-Disposition'] = "HIstori_SasaranEselon1.pdf";
			$pdf->ezStream($opt);
	}
	
	function sasaranE1_excel($filtahun=null){
		echo  $this->histori_pengaturan_model->sasaranE1_grid(null, $filtahun,3);
	}
	
	
	function sasaranE2_grid($filtahun=null,$file1=null,$file2=null){
		echo $this->histori_pengaturan_model->sasaranE2_grid($filtahun,$file1,$file2,1);
	}
	
	function sasaranE2_pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_pengaturan_model->sasaranE2_grid($filtahun,$file1,$file2,2);
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
			$pdf->ezText('Daftar Sasaran Strategis Eselon II',12,array('left'=>'1'));
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
			$opt['Content-Disposition'] = "HIstori_SasaranEselon2.pdf";
			$pdf->ezStream($opt);
	}
	
	function sasaranE2_excel($filtahun=null,$file1=null,$file2=null){
		echo  $this->histori_pengaturan_model->sasaranE2_grid($filtahun,$file1,$file2,3);
	}
	
	
	function ikukl_grid($filtahun=null){
		echo $this->histori_pengaturan_model->ikukl_grid($filtahun,1);
	}
	
	function ikukl_pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_pengaturan_model->ikukl_grid($filtahun,2);
			if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
			//$pdfdata = $pdfdata->rows;
			$pdfhead = array('No.','Tahun','Kode IKU','Deskripsi IKU','Satuan','Subsektor','Status','User','Waktu');
			$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
			$pdf->ezText('Daftar IKU Kementerian',12,array('left'=>'1'));
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
					 5=>array('width'=>50),
					 6=>array('width'=>50),
					 7=>array('width'=>50),
					 8=>array('width'=>75)
					 ),
				'width'=>'520'
			);
			$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
			$opt['Content-Disposition'] = "HIstori_IKUkementerian.pdf";
			$pdf->ezStream($opt);
	}
	
	function ikukl_excel($filtahun=null){
		echo  $this->histori_pengaturan_model->ikukl_grid($filtahun,3);
	}
	
	
	function ikue1_grid($filtahun=null){
		echo $this->histori_pengaturan_model->ikue1_grid($filtahun,1);
	}
	
	function ikue1_pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_pengaturan_model->ikue1_grid($filtahun,2);
			if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
			//$pdfdata = $pdfdata->rows;
			$pdfhead = array('No.','Tahun','Kode IKU','Deskripsi IKU','Satuan','Kode IKU Kementerian','Status','User','Waktu');
			$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
			$pdf->ezText('Daftar IKU Eselon I',12,array('left'=>'1'));
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
					 5=>array('width'=>50),
					 6=>array('width'=>50),
					 7=>array('width'=>50),
					 8=>array('width'=>75)
					 ),
				'width'=>'520'
			);
			$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
			$opt['Content-Disposition'] = "HIstori_IKUEselon1.pdf";
			$pdf->ezStream($opt);
	}
	
	function ikue1_excel($filtahun=null){
		echo  $this->histori_pengaturan_model->ikue1_grid($filtahun,3);
	}
	
	
	function ikk_grid($filtahun=null){
		echo $this->histori_pengaturan_model->ikk_grid($filtahun,1);
	}
	
	function ikk_pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_pengaturan_model->ikk_grid($filtahun,2);
			if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
			//$pdfdata = $pdfdata->rows;
			$pdfhead = array('No.','Kode IKU','Deskripsi IKU','Status','User','Waktu');
			$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
			$pdf->ezText('Daftar IKK',12,array('left'=>'1'));
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
					 5=>array('width'=>50),
					 6=>array('width'=>50),
					 7=>array('width'=>50),
					 8=>array('width'=>75)
					 ),
				'width'=>'520'
			);
			$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
			$opt['Content-Disposition'] = "HIstori_IKK.pdf";
			$pdf->ezStream($opt);
	}
	
	function ikk_excel($filtahun=null){
		echo  $this->histori_pengaturan_model->ikk_grid($filtahun,3);
	}
}
?>