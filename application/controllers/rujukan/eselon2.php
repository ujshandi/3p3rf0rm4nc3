<?php

class Eselon2 extends CI_Controller {
	var $objectId = 'Eselon2';
	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
							
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Eselon 2';		
		$data['objectId'] = $this->objectId;
	  	$this->load->view('rujukan/eselon2_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid($file1=null,$file2=null){		
		//chan
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
			$file1= $this->session->userdata('unit_kerja_e1');
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');
		
		echo $this->eselon2_model->easyGrid($file1,$file2);
	}
	
	function loadFilterE2($e1,$objectId){
		echo $this->eselon2_model->getListFilterEselon2($objectId,$e1);
	}
	
	function loadE2($e1, $objectId,$val=null){
		echo $this->eselon2_model->getListEselon2($objectId, array('e1'=>$e1,'value'=>$val));
	}
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['kode_e2'] = $this->input->post("kode_e2", TRUE); //id
		$data['kode_e1'] = $this->input->post("kode_e1", TRUE);
		
		$data['nama_e2'] = $this->input->post("nama_e2", TRUE);
		$data['singkatan'] = $this->input->post("singkatan", TRUE);
		$data['nama_direktur'] = $this->input->post("nama_direktur", TRUE);
		$data['nip'] = $this->input->post("nip", TRUE);
		$data['pangkat'] = $this->input->post("pangkat", TRUE);
		$data['gol'] = $this->input->post("gol", TRUE);
		//$data["insert_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		//$data["update_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		return $data;
    }
	
	function save($aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
		$data['pesan_error'] = '';
		//validasi form
		/* $this->form_validation->set_rules("kode_e2", 'Kode ESELON 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_e1", 'Kode ESELON 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("nama_e2", 'Nama ESELON 2', 'trim|required|xss_clean');
		$this->form_validation->set_rules("singkatan", 'Singkatan', 'trim|required|xss_clean');
		$this->form_validation->set_rules("nama_direktur", 'Nama Direktur', 'trim|required|xss_clean');
		$this->form_validation->set_rules("nip", 'NIP', 'trim|required|xss_clean');
		$this->form_validation->set_rules("pangkat", 'Pangkat', 'trim|required|xss_clean');
		$this->form_validation->set_rules("gol", 'Golongan', 'trim|required|xss_clean');
		
		
		if ($this->form_validation->run() == FALSE){ 
			//jika data tidak valid kembali ke view
			$data["pesan_error"].=(trim(form_error("kode_e2"," "," "))==""?"":form_error("kode_e2"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("kode_e1"," "," "))==""?"":form_error("kode_e1"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("nama_e2"," "," "))==""?"":form_error("nama_e2"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("singkatan"," "," "))==""?"":form_error("singkatan"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("nama_direktur"," "," "))==""?"":form_error("nama_direktur"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("nip"," "," "))==""?"":form_error("nip"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("pangkat"," "," "))==""?"":form_error("pangkat"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("gol"," "," "))==""?"":form_error("gol"," "," ")."<br/>");
			$status = $data["pesan_error"];
		}else {*/
			if($aksi=="add"){ // add
				if (!$this->eselon2_model->isExistKode($data['kode_e2'])){
					$result = $this->eselon2_model->InsertOnDb($data,$status);
				}
				else
					$data['pesan_error'] .= 'Kode sudah ada';
					
			}else { // edit
				$result=$this->eselon2_model->UpdateOnDb($data,$kode);
			}
			//$data['pesan_error'] .= $status;	
		//}
		
		if ($result){
			echo json_encode(array('success'=>true, 'kode'=>$kode));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
//		echo $status;
		
		}
		
	function delete($id=''){
		if($id != ''){
			if ($this->eselon2_model->isSaveDelete($id))
				$result = $this->eselon2_model->DeleteOnDb($id);
			else
				$result = false;
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Data tidak bisa dihapus karena sudah digunakan sebagai referensi data lainnya.', 'data'=> ''));
			}
		}
	}
	
	public function excel($file1=null,$file2=null){
		echo  $this->eselon2_model->easyGrid($file1,$file2,3);
	}
		
	//to pdf  --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>dinon-aktifkan by Chan
	public function pdfOld($file1=null,$file2){
			$this->load->library('cezpdf');	
			$pdfdata = $this->eselon2_model->easyGrid($file1,$file2,2);
			
			//$pdfdata = $pdfdata->rows;
			if (($file1 != null)&&($file1 != "-1"))
				$pdfhead = array('No.','Kode Unit Kerja','Nama Unit Kerja','Singkatan','Nama Pimpinan','N I P','Pangkat','Golongan');
			else
				$pdfhead = array('No.','Kode Unit Kerja','Kode Eselon I','Nama Unit Kerja','Singkatan','Nama Pimpinan','N I P','Pangkat','Golongan');
				
			$pdf = new $this->cezpdf($paper='A4',$orientation='landscape');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
		//	if (($filtahun != null)&&($filtahun != "-1"))
			//if (($file2 != null)&&($file2 != "-1"))
				//$title = $this->eselon2_model->getNamaE2($file2);
				// $pdf->ezText($this->eselon2_model->getNamaE2($file2),11,array('left'=>'1'));
			$pdf->ezText('Daftar Unit Kerja Eselon II',16,array('left'=>'1'));
			if (($file1 != null)&&($file1 != "-1"))
				$pdf->ezText($this->eselon1_model->getNamaE1($file1),14,array('left'=>'1'));
			$pdf->ezText('Kementerian Perhubungan',12,array('left'=>'1'));
			$pdf->ezText('');
			//halaman 
			$pdf->ezStartPageNumbers(760,10,12,'right','',1);
			
			
			if (($file1 != null)&&($file1 != "-1")){
				$cols = array(
					 0=>array('justification'=>'center','width'=>25),
					 1=>array('width'=>50),
					 2=>array('width'=>210),
					 3=>array('width'=>100),
					 4=>array('width'=>120),
					 5=>array('width'=>100),
					 6=>array('width'=>110),
					 7=>array('width'=>60));
			}			
			else{
				$cols = array(
					 0=>array('justification'=>'center','width'=>25),
					 1=>array('width'=>50),
					 2=>array('width'=>50),
					 3=>array('width'=>200),
					 4=>array('width'=>100),
					 5=>array('width'=>100),
					 6=>array('width'=>100),
					 7=>array('width'=>100),
					 8=>array('width'=>60));
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
				'width'=>'700'
			);
			//print_r($pdfdata);
			$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
			$opt['Content-Disposition'] = "Eselon2.pdf";
			$pdf->ezStream($opt);
		}
		
		public function pdf($file1=null,$file2){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('L', 'mm', 'A4'); 
		$pdfdata = $this->eselon2_model->easyGrid($file1,$file2,2);
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
		
		 $this->our_pdf->text($posX,$posY,'Daftar Unit Kerja Eselon II');
	
		if (($file1 != null)&&($file1 != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,$this->eselon1_model->getNamaE1($file1));
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
		
		$this->our_pdf->CELL(25,6,'Kode Unit Kerja',1,0,'C',1);
		$this->our_pdf->CELL(100,6,'Nama Unit Kerja',1,0,'C',1);
		$this->our_pdf->CELL(30,6,'Singkatan',1,0,'C',1);
		$this->our_pdf->CELL(40,6,'Nama Pimpinan',1,0,'C',1);
		$this->our_pdf->CELL(25,6,'N I P',1,0,'C',1);
		$this->our_pdf->CELL(25,6,'Pangkat',1,0,'C',1);
		$this->our_pdf->CELL(25,6,'Golongan',1,0,'C',1);
		
		
			
		//$yi = 18;
		if (($file1 != null)&&($file1 != "-1"))
			$posY = 33;//44;
		else
			$posY = 27;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		 $this->our_pdf->SetWidths(array(10,25,100,30,40,25,25,25));
		 $this->our_pdf->SetAligns(array("C","L","L","L","L","L","L","L"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		$e1 = '';
		for ($i=0;$i<count($pdfdata);$i++){
			$this->our_pdf->setFont('arial','',8);	
			//tambah group
			if (($file1 != null)&&($file1 != "-1")) {
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5],$pdfdata[$i][6],$pdfdata[$i][7])); 
			}
			else {
				if ($e1!=$pdfdata[$i][2]){
					$e1=$pdfdata[$i][2];
					$this->our_pdf->setFont('arial','B',8);	
					$this->our_pdf->CELL(280,5,$this->eselon1_model->getNamaE1($pdfdata[$i][2]),1,0,'L',1);
					$this->our_pdf->Ln(5);
					$this->our_pdf->setFont('arial','',8);	
					
				}
				$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][3],$pdfdata[$i][4],$pdfdata[$i][5],$pdfdata[$i][6],$pdfdata[$i][7],$pdfdata[$i][8])); 
			}
			
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("Eselon2.pdf","I");
	}

}
?>