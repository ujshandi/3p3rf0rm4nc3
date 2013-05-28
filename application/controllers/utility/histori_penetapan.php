<?php

class histori_penetapan extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		$userdata = array ('logged_in' => TRUE);
				//
		$this->session->set_userdata($userdata);
				
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/utility/histori_penetapan_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/penetapan/penetapankl_model');
		$this->load->model('/penetapan/penetapaneselon1_model');
		$this->load->model('/penetapan/penetapaneselon2_model');
		$this->load->library("utility");
		$this->load->helper('form');
		
	}
	
	function index(){
		$data['title'] = 'Histori utility';		
		$data['objectId'] = 'historiPenetapan';
	  	$this->load->view('utility/histori_penetapan_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	
	function KL_grid($filtahun=null){
		echo $this->histori_penetapan_model->KL_grid($filtahun,1);
	}
	
	function KL_pdf($filtahun=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_penetapan_model->KL_grid($filtahun,2);
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
	
	function KL_excel($filtahun=null){
		echo  $this->histori_penetapan_model->KL_grid($filtahun,3);
	}
	
	
	function E1_grid($filtahun=null,$file1=null){
		echo $this->histori_penetapan_model->E1_grid($filtahun,$file1,1);
	}
	
	function E1_pdf($filtahun=null,$file1=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_penetapan_model->E1_grid($filtahun,$file1,2);
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
			$opt['Content-Disposition'] = "Histori_RencanaEselon1.pdf";
			$pdf->ezStream($opt);
	}
	
	function E1_excel($filtahun=null,$file1=null){
		echo  $this->histori_penetapan_model->E1_grid($filtahun,$file1,3);
	}
	
	
	function E2_grid($filtahun=null,$file1=null,$file2=null){
		echo $this->histori_penetapan_model->E2_grid($filtahun,$file1,$file2,1);
	}
	
	function E2_pdf($filtahun=null,$file1=null,$file2=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->histori_penetapan_model->E2_grid($filtahun,$file1,$file2,2);
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
			$opt['Content-Disposition'] = "Histori_RencanaEselon1.pdf";
			$pdf->ezStream($opt);
	}
	
	function E2_excel($filtahun=null,$file1=null,$file2=null){
		echo  $this->histori_penetapan_model->E2_grid($filtahun,$file1,$file2,3);
	}
	
}
?>