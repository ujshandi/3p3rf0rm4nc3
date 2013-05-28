<?php

class Sasaran_eselon1 extends CI_Controller {
	var $objectId ='SasaranEselon1';
	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		$userdata = array ('logged_in' => TRUE);
				//
		$this->session->set_userdata($userdata);
				
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/pengaturan/sasaran_eselon1_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->model('/rencana/rpt_rkteselon1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->library("utility");
		
		$this->load->helper('form');
	
	}
	
	function index(){
		$data['title'] = 'Sasaran Eselon I';
		$data['objectId'] = $this->objectId;
	  	$this->load->view('pengaturan/sasaran_eselon1_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid($file1=null,$filtahun=null,$filkey=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		echo $this->sasaran_eselon1_model->easyGrid($file1,$filtahun,$filkey);
	}
	
	function getNewCode($e1,$tahun){
		//fieldName,$tblName,$condition,$prefix,$suffix,$minLength=5
		$prefix = $this->utility->getValueFromSQL("select prefix as rs from tbl_prefix where kode_e1 = '$e1'","UNSET");
		//var_dump($prefix); die;
		echo $this->utility->ourGetNextIDNum("kode_sasaran_e1","tbl_sasaran_eselon1"," and tahun = '$tahun'",$prefix.".","",2);
	}
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['tahun'] = $this->input->post("tahun", TRUE); //tahun
		$data['kode_sasaran_e1'] = $this->input->post("kode_sasaran_e1", TRUE); //id
		
		if ($this->session->userdata('unit_kerja_e1')=='-1')
			$data['kode_e1'] = $this->input->post("kode_e1", TRUE); //id
		else 
			$data['kode_e1'] = $this->session->userdata('unit_kerja_e1');
		
		$data['kode_sasaran_kl'] = $this->input->post("kode_sasaran_kl", TRUE);		
		$data['deskripsi'] = $this->input->post("deskripsi", TRUE);
		
		//$data["insert_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		//$data["update_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		return $data;
    }
	
	//chan
	function getListSasaranE1($objectId,$e1){
		echo $this->sasaran_eselon1_model->getListSasaranE1($objectId,$e1);
	}
	
	function getListSasaranKL($objectId,$tahun){
		$data = array('tahun' => $tahun);
		echo $this->sasaran_kl_model->getListSasaranKL($objectId,$data);
	}
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
	    
		$data['pesan_error'] = '';
		
		# validasi rules
		$this->form_validation->set_rules("kode_sasaran_e1", 'Kode Sasaran Eselon 1', 'trim|required|xss_clean');
		//$this->form_validation->set_rules("kode_sasaran_kl", 'Kode Sasaran Kementerian', 'trim|required|xss_clean');
		$this->form_validation->set_rules("deskripsi", 'Deskripsi', 'trim|required|xss_clean');
		
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			$data["pesan_error"].=(trim(form_error("kode_sasaran_e1"," "," "))==""?"":form_error("kode_sasaran_e1"," "," ")."<br>");
			//$data["pesan_error"].=(trim(form_error("kode_sasaran_kl"," "," "))==""?"":form_error("kode_sasaran_kl"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("deskripsi"," "," "))==""?"":form_error("deskripsi"," "," ")."<br>");
			$status = $data["pesan_error"];
			
		}else {
			if($aksi=="add"){ // add
				$result = !$this->sasaran_eselon1_model->isExistKode($data['kode_sasaran_e1']);
				if ($result)
					$result = $this->sasaran_eselon1_model->InsertOnDb($data,$status);
				else
				   $data['pesan_error'] = 'Kode sudah ada.';
					
			}else { // edit
				$result=$this->sasaran_eselon1_model->UpdateOnDb($data,$kode);
				
			}
			//$data['pesan_error'] .= $status;	
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'kode'=>$kode));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
		
	}
		
	function delete($tahun, $kode_sasaran_e1){
		# cek keberadaan di RKT
		// jika ada di RKT
		if($this->sasaran_eselon1_model->existInRKT($tahun, $kode_sasaran_e1)){
			echo json_encode(array('msg'=>'Data tidak bisa dihapus. karena sudah ada di RKT', 'data'=> ''));
		}else{
			$result = $this->sasaran_eselon1_model->DeleteOnDb($tahun, $kode_sasaran_e1);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
		
	}

	public function getDeskripsiSasaran($kode_sasaran_e1){
		$deskripsi = $this->sasaran_eselon1_model->getDeskripsiSasaran($kode_sasaran_e1);
		echo $deskripsi;
	}
	
	public function excel($file1=null,$filtahun=null,$filkey=null){
		echo  $this->sasaran_eselon1_model->easyGrid($file1,$filtahun,$filkey,3);
	}
	
	public function pdf($file1=null,$filtahun=null,$filkey=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('P', 'mm', 'A4'); 
		$pdfdata = $this->sasaran_eselon1_model->easyGrid($file1,$filtahun,$filkey,2);
		if (count($pdfdata)==0){
			echo "Data Tidak Tersedia";
			return;
		}
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		$this->our_pdf->Open();
		$this->our_pdf->addPage();
	
		//========= setting judul ============
		
		$this->our_pdf->setFont('arial','',12);
		$posY = 11;
		$posX = 10;
		
		$title = "Tingkat Eselon I";
	//	if (($file1 != null)&&($file1 != "-1"))
			// $title = $this->eselon1_model->getNamaE1($file1);
		// $pdf->ezText($this->eselon2_model->getNamaE2($file2),11,array('left'=>'1'));
		
		
		$this->our_pdf->text($posX,$posY,'Daftar Sasaran Strategis '.$title);
		if (($file1 != null)&&($file1 != "-1")&&($file1 != "")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,$this->eselon1_model->getNamaE1($file1));
		}
			
		
		/* $posY += 5;
		$this->our_pdf->setFont('Arial','',10);
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->text($posX,$posY,"Kementerian Perhubungan"); */
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(10,6,'No',1,0,'C',1);
			
		$this->our_pdf->CELL(25,6,'Kode Sasaran',1,0,'C',1);
		$this->our_pdf->CELL(110,6,'Deskripsi Sasaran',1,0,'C',1);
		
		$this->our_pdf->CELL(45,6,'Kode Sasaran Kementerian',1,0,'C',1);
		
		
		
			
		//$yi = 18;
		if (($file1 != null)&&($file1 != "-1"))
			$posY = 28;//44;
		else
			$posY = 23;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		 $this->our_pdf->SetWidths(array(10,25,110,45));
		 $this->our_pdf->SetAligns(array("C","L","L","L"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		$e2 = '';
		for ($i=0;$i<count($pdfdata);$i++){
			$this->our_pdf->setFont('arial','',8);	
			//tambah group
			if (($file1 != null)&&($file1 != "-1")) {
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3])); 
			}
			else {
			
					$idxE2 = 1;
				
				if ($e2!=$pdfdata[$i][$idxE2]){
					$e2=$pdfdata[$i][$idxE2];
					$this->our_pdf->setFont('arial','B',8);	
					
						$this->our_pdf->CELL(190,5,$this->eselon1_model->getNamaE1($pdfdata[$i][$idxE2]),1,0,'L',1);
					$this->our_pdf->Ln(5);
					$this->our_pdf->setFont('arial','',8);	
					
				}
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4])); 
				else
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4])); 
			}
			
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("SasaranEselon1.pdf","I");
	}
	
	
	
	public function pdfOld($file1=null,$filtahun=null){
		$this->load->library('cezpdf');	
		$pdfdata = $this->sasaran_eselon1_model->easyGrid($file1,$filtahun,2);
		if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
		//$pdfdata = $pdfdata->rows;
		if (($file1 != null)&&($file1 != "-1"))
			$pdfhead = array('No.','Kode Sasaran','Deskripsi Sasaran','Kode Sasaran Kementerian Terkait');
		else
			$pdfhead = array('No.','Kode Eselon I','Kode Sasaran','Deskripsi Sasaran','Kode Sasaran Kementerian Terkait');
			
		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
	//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
	//	if (($filtahun != null)&&($filtahun != "-1"))
		$title = "Unit Kerja Eselon I";
		if (($file1 != null)&&($file1 != "-1"))
			$title=$this->eselon1_model->getNamaE1($file1);
		$pdf->ezText('Sasaran Strategis '.$title,14,array('left'=>'1'));
		$pdf->ezText('Kementerian Perhubungan',12,array('left'=>'1'));
		$pdf->ezText('');
		//halaman 
		$pdf->ezStartPageNumbers(550,10,12,'right','',1);
		
		
		if (($file1 != null)&&($file1 != "-1")){
			$cols = array(
				 0=>array('justification'=>'center','width'=>25),
				 1=>array('width'=>75),
				 2=>array('width'=>345),
				 3=>array('width'=>75));
		}
		else{
			$cols = array(
				 0=>array('justification'=>'center','width'=>25),
				 1=>array('width'=>75),
				 2=>array('width'=>75),
				 3=>array('width'=>270),
				 4=>array('width'=>75));
		}
		
		$options = array(
			'showLines' => 2,
			'showHeadings' => 1,
			'fontSize' => 8,
			'rowGap' => 1,
			'shaded' => 0,
			'colGap' => 5,
			'xPos' => 40,
			'xOrientation' => 'right',
				'cols'=>$cols,
			'width'=>'520'
		);
		$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
		$opt['Content-Disposition'] = "SasaranEselon1.pdf";
		$pdf->ezStream($opt);
	}
	
	function import(){
		# --
		$error='';
		$result=true;
		$extensi = '';
		
		# load
		$this->load->helper('file');
		
		# upload filenya
		$fupload = $_FILES['datafile'];
		$nama = $_FILES['datafile']['name'];
		$extensi = $_FILES['datafile']['type'];
		//chan
		  $allowedExtensions = array("xls"); 
       
			  if (!in_array(end(explode(".", 
					strtolower($nama))), 
					$allowedExtensions)) { 
					echo json_encode(array('success'=>false, 'msg'=>'File yang akan disuport hanya untuk tipe Excel (xls)'));
				
					return;
			   /* die($file['name'].' is an invalid file type!<br/>'. 
				'<a href="javascript:history.go(-1);">'. 
				'&lt;&lt Go Back</a>');  */
			  } 
			  
			  
		if(isset($fupload)){
			$lokasi_file 	= $fupload['tmp_name'];
			$direktori		= "restore/$nama";
			
			if(move_uploaded_file($lokasi_file, $direktori)){ // proses upload
				
				# baca file
				/* if($extensi == 'application/vnd.ms-excel'){ // file CSV
					$isi_file		= file_get_contents($direktori);
					$row	= rtrim($isi_file, "\n" );
					$row	= explode("\n", $row);

					// baca per baris
					foreach($row as $r){
						/ keterangan
							0			1					2				3
							kode_e1		kode_sasaran_e1		deskripsi		kode_sasaran_kl
						/
						
						# baca per kolom
						$col = explode(";", $r);

						$data['kode_e1'] 			= $col[0];
						$data['kode_sasaran_e1'] 	= $col[1];
						$data['deskripsi'] 			= $col[2];
						$data['kode_sasaran_kl'] 	= $col[3];
						
						# proses
						$this->sasaran_eselon1_model->importData($data);						
					}
					
				}elseif($extensi == 'application/x-msdownload'){ */ //Excel 2003
					# load librari
					$this->load->library('excel');
					$this->excel->setOutputEncoding('CP1251');
					$this->excel->read($direktori); // baca file
					
					# baca per baris
					for($i=2, $n=$this->excel->rowcount(0); $i<= $n; $i++){
						# data
						$data['tahun'] 				= $this->excel->val($i, 1);
						$data['kode_e1'] 			= $this->excel->val($i, 2);
						$data['kode_sasaran_e1'] 	= $this->excel->val($i, 3);
						$data['deskripsi'] 			= $this->excel->val($i, 4);
						$data['kode_sasaran_kl'] 	= $this->excel->val($i, 5);
						
						# proses
						$result=$this->sasaran_eselon1_model->importData($data);
						if (!$result) $error = "Gagal Import, kemungkinan data yang diimport sudah ada pada database";
					}
					
				/* }else{
					$result=false;
					$error = "Format File tidak diketahui.";
				} */
				
				# clear folder temporari
				delete_files('restore');
				
			}else{
				$result=false;
				$error = "Gagal upload";
			}
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'msg'=>'Data berhasil diimport'));
		} else {
			echo json_encode(array('msg'=>$error));
		}
		
	}
	

}
?>