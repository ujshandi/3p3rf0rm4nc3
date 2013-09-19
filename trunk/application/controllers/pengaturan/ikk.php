<?php

class Ikk extends CI_Controller {

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
		$this->load->model('/pengaturan/ikk_model');
		$this->load->model('/pengaturan/iku_e1_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->library("utility");
		$this->load->helper('form');
		
	}
	
	function index(){
		$data['title'] = 'IKK';		
		$data['objectId'] = 'ikk';
	  	$this->load->view('pengaturan/ikk_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid($file1=null, $file2=null,$filtahun=null,$filkey=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');

		echo $this->ikk_model->easyGrid($file1, $file2,$filtahun,$filkey,1);
	}
	
	function getListIKU_E1($objectId,$e1,$tahun){
		echo $this->iku_e1_model->getListIKU_E1($objectId,$e1,$tahun);
	}
	
	function getNewCode($e2,$tahun,$kodesasaran){
		//fieldName,$tblName,$condition,$prefix,$suffix,$minLength=5
		$prefix = $this->utility->getValueFromSQL("select prefix_iku as rs from tbl_prefix where kode_e2 = '$e2'","-").$kodesasaran;//UNSET
		//var_dump($prefix); die;
		echo $this->utility->ourGetNextIDNum("kode_ikk","tbl_ikk"," and tahun = '$tahun'",$prefix.".","",2);
	}
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['kode_ikk'] = $this->input->post("kode_ikk", TRUE); //id
		$data['deskripsi'] = $this->input->post("deskripsi", TRUE);
		$data['satuan'] = $this->input->post("satuan", TRUE);
		$data['kode_iku_e1'] = $this->input->post("kode_iku_e1", TRUE);
		$data['tahun'] = $this->input->post("tahun", TRUE);
		$data['kode_sasaran_e2'] = $this->input->post("kode_sasaran_e2", TRUE);	
		if ($this->session->userdata('unit_kerja_e2')=='-1')
			$data['kode_e2'] = $this->input->post("kode_e2", TRUE); //id
		else 
			$data['kode_e2'] = $this->session->userdata('unit_kerja_e2');	
		//$data["insert_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		//$data["update_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		return $data;
    }
	
	function save($aksi="", $kode="",$tahun=''){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
		
		$data['pesan_error'] = '';
	
		# validasi form
		$this->form_validation->set_rules("kode_ikk", 'Kode IKK', 'trim|required|xss_clean');
		$this->form_validation->set_rules("deskripsi", 'Deskripsi', 'trim|required|xss_clean');
		$this->form_validation->set_rules("satuan", 'Satuan', 'trim|required|xss_clean');
		//$this->form_validation->set_rules("kode_iku_e1", 'Kode Indikator Kinerja Utama Eselon 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_e2", 'Unit Kerja Eselon II', 'trim|required|xss_clean');
		$this->form_validation->set_rules("tahun", 'Tahun', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e2", 'Sasaran Eselon II', 'trim|required|xss_clean');
		
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			//$data["pesan_error"].=(trim(form_error("kode_iku_e1"," "," "))==""?"":form_error("kode_iku_e1"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("kode_e2"," "," "))==""?"":form_error("kode_e2"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("kode_ikk"," "," "))==""?"":form_error("kode_ikk"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("deskripsi"," "," "))==""?"":form_error("deskripsi"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("satuan"," "," "))==""?"":form_error("satuan"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("tahun"," "," "))==""?"":form_error("tahun"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("kode_sasaran_e2"," "," "))==""?"":form_error("kode_sasaran_e2"," "," ")."<br>");
			$status = $data["pesan_error"];
			
		}else {
			if($aksi=="add"){ // add
			if (!$this->ikk_model->isExistKode($data['kode_ikk'],$data['tahun'])){
					$result = $this->ikk_model->InsertOnDb($data,$status);
					
					}
					else
					$data['pesan_error'] .= 'Kode sudah ada';
			}else { // edit
				$result=$this->ikk_model->UpdateOnDb($data,$kode,$tahun);
			}
			//$data['pesan_error'] .= $status;	
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'kode'=>$kode));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
//		echo $status;
		
		}
		
	function delete($tahun, $kode_ikk){
		# cek keberadaan di RKT
		// jika ada di RKT
		if($this->ikk_model->existInRKT($tahun, $kode_ikk)){
			echo json_encode(array('msg'=>'Data tidak bisa dihapus. karena sudah ada di RKT', 'data'=> ''));
		}else{
			$result = $this->ikk_model->DeleteOnDb($tahun, $kode_ikk);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
		
	}
	
	public function getListTahun($objectId=null){
		echo $this->ikk_model->getListTahun($objectId);
	}

	public function excel($file1=null,$file2=null,$filtahun=null,$filkey=null){
		echo  $this->ikk_model->easyGrid($file1,$file2,$filtahun,$filkey,3);
	}
	
	public function pdf($file1=null,$file2=null,$filtahun=null,$filkey=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('P', 'mm', 'A4'); 
		$pdfdata = $this->ikk_model->easyGrid($file1,$file2,$filtahun,$filkey,2);
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
		$e1="";
		if (($file1 != null)&&($file1 != "-1")){
			$e1=$this->eselon1_model->getNamaE1($file1);
		}
		$this->our_pdf->text($posX,$posY,'Daftar Indikator Kinerja Kegiatan '.$e1);
		if (($file2 != null)&&($file2 != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,$this->eselon2_model->getNamaE2($file2));
		}
		
		$posY += 5;
		$this->our_pdf->setFont('Arial','',10);
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->text($posX,$posY,"Kementerian Perhubungan");
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->CELL(10,6,'No',1,0,'C',1);
	
		$this->our_pdf->CELL(12,6,'Tahun',1,0,'C',1);
		$this->our_pdf->CELL(30,6,'Kode IKK',1,0,'C',1);
		$this->our_pdf->CELL(83,6,'Deskripsi IKK',1,0,'C',1);
		$this->our_pdf->CELL(30,6,'Satuan',1,0,'C',1);
		$this->our_pdf->CELL(30,6,'IKU Eselon I terkait',1,0,'C',1);
		
		
			
		//$yi = 18;
		if (($file1 != null)&&($file1 != "-1")){
			$posY = 27;//44;
			if (($file2 != null)&&($file2 != "-1"))
				$posY = 33;//44;
		}	
		else
			$posY = 27;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		 $this->our_pdf->SetWidths(array(10,12,30,83,30,30));
		 $this->our_pdf->SetAligns(array("C","L","L","L","L","L"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		$e2 = '';
		for ($i=0;$i<count($pdfdata);$i++){
			$this->our_pdf->setFont('arial','',8);	
			//tambah group
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5])); 
			}
			else {
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					$idxE2 = 2;
				else
					$idxE2 = 2;
					
				if ($e2!=$pdfdata[$i][$idxE2]){
					$e2=$pdfdata[$i][$idxE2];
					$this->our_pdf->setFont('arial','B',8);	
					$this->our_pdf->CELL(195,5,$this->eselon2_model->getNamaE2($pdfdata[$i][$idxE2]),1,0,'L',1);
					$this->our_pdf->Ln(5);
					$this->our_pdf->setFont('arial','',8);	
					
				}
			//	if($file1 != '' && $file1 != '-1' && $file1 != null)
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5],$pdfdata[$i][6])); 
				//else
					//$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][4])); 
			}
			
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("IKK.pdf","I");
	}
	
	//to pdf  --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>dinon-aktifkan by Chan
	public function pdfOld($file1=null,$file2){
			$this->load->library('cezpdf');	
			$pdfdata = $this->ikk_model->easyGrid($file1,$file2,2);
			if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
			//$pdfdata = $pdfdata->rows;
			if (($file1 != null)&&($file1 != "-1"))
				if (($file2 != null)&&($file2 != "-1"))
					$pdfhead = array('No.','Kode IKK','Deskripsi','Satuan');
					//$pdfhead = array('No.','Kode IKK','Kode IKU Eselon I','Deskripsi IKK','Satuan');
				else
					$pdfhead = array('No.','Kode Eselon II','Kode IKK','Deskripsi','Satuan');
					//$pdfhead = array('No.','Kode Eselon II','Kode IKK','Kode IKU Eselon I','Deskripsi IKK','Satuan');
			else
				$pdfhead = array('No.','Kode Eselon II','Kode IKK','Deskripsi','Satuan');
				//$pdfhead = array('No.','Kode Eselon II','Kode IKK','Kode IKU Eselon I','Deskripsi IKK','Satuan');
				
			$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
			$pdf->ezText('Indikator Kinerja Kegiatan',16,array('left'=>'1'));
		//	if (($filtahun != null)&&($filtahun != "-1"))
			//	$pdf->ezText('Tahun '.$filtahun,12,array('left'=>'1'));
			if (($file1 != null)&&($file1 != "-1"))
				$pdf->ezText($this->eselon1_model->getNamaE1($file1),12,array('left'=>'1'));
			if (($file2 != null)&&($file2 != "-1"))
				$pdf->ezText($this->eselon2_model->getNamaE2($file2),11,array('left'=>'1'));
			if (($file1 == "-1")&&($file2 == "-1"))
				$pdf->ezText('Unit Kerja Eselon II',12);
			$pdf->ezText('');
			//halaman 
			$pdf->ezStartPageNumbers(550,10,12,'right','',1);
			
			
			if (($file1 != null)&&($file1 != "-1")){
				if (($file2 != null)&&($file2 != "-1")){
					$cols = array(
						 0=>array('justification'=>'center','width'=>30),
						 1=>array('width'=>80),
						 2=>array('width'=>300),
						 3=>array('width'=>100));
						 //2=>array('width'=>75),
						 //3=>array('width'=>245),
						 //4=>array('width'=>100));
				}
				else{
					$cols = array(
						 0=>array('justification'=>'center','width'=>30),
						 1=>array('width'=>80),
						 2=>array('width'=>80),
						 3=>array('width'=>230),
						 4=>array('width'=>100));
						 //3=>array('width'=>75),
						 //4=>array('width'=>170),
						 //5=>array('width'=>100));
				}
			}			
			else{
				$cols = array(
					 0=>array('justification'=>'center','width'=>30),
					 1=>array('width'=>80),
					 2=>array('width'=>80),
					 3=>array('width'=>230),
					 4=>array('width'=>100));
					 //3=>array('width'=>75),
					 //4=>array('width'=>170),
					 //5=>array('width'=>100));
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
			$opt['Content-Disposition'] = "IKK.pdf";
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
							0			1				2				3			4				5
							tahun 		kode_ikk 		deskripsi 		satuan 		kode_iku_e1 	kode_e2
						/
						
						# baca per kolom
						$col = explode(";", $r);

						$data['tahun'] 			= $col[0];
						$data['kode_ikk'] 		= $col[1];
						$data['deskripsi'] 		= $col[2];
						$data['satuan'] 		= $col[3];
						$data['kode_iku_e1'] 	= $col[4];
						$data['kode_e2'] 		= $col[5];
						
						# proses
						$this->ikk_model->importData($data);						
					}
					
				}elseif($extensi == 'application/x-msdownload'){ */ //Excel 2003
					# load librari
					$this->load->library('excel');
					$this->excel->setOutputEncoding('CP1251');
					$this->excel->read($direktori); // baca file
					
					# baca per baris
					for($i=2, $n=$this->excel->rowcount(0); $i<= $n; $i++){
						# data
						$data['tahun'] 			= $this->excel->val($i, 1);
						$data['kode_ikk'] 		= $this->excel->val($i, 2);
						$data['deskripsi'] 		= $this->excel->val($i, 3);
						$data['satuan'] 		= $this->excel->val($i, 4);
						//chan $data['kode_iku_e1'] 	= $this->excel->val($i, 5);
						$data['kode_e2'] 		= $this->excel->val($i, 5);
						
						# proses
						$result = $this->ikk_model->importData($data);
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
