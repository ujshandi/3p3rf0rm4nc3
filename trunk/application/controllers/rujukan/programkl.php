<?php

class Programkl extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
				
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rujukan/programkl_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rencana/rpt_rkteselon1_model');
		$this->load->library("utility");
	}

	function index(){
		$data['title'] = 'Data Program';
		$data['objectId'] = 'programkl';
	  	$this->load->view('rujukan/programkls_v',$data);
	}

	public function add(){
		$data['title'] = 'Add Program';
		$data['objectId'] = 'programkl';
	  	//$this->load->view('rujukan/programkl_v',$data);
		$result = new stdClass();
		
		$result->tahun = '';
		$result->kode_e1 = '';
		$result->kode_program = '';
		$result->total = '';
		$result->nama_program = '';
		
		$data['result'] = $result;
		$data['editMode'] = false;
	  	$this->load->view('rujukan/programkl_v_edit',$data);
	}
	
	public function edit($tahun,$kode_program){
		$data['title'] = 'Edit Program';	
		$data['objectId'] = 'programkl';
		$data['editMode'] = true;
		$data['result'] = $this->programkl_model->getDataEdit($tahun,$kode_program);
	  	$this->load->view('rujukan/programkl_v_edit',$data);
	}

	function grid($file1=null,$filtahun=null){
		if (($file1==null)&&($this->session->userdata('unit_kerja_e1'))!=-1)
		$file1= $this->session->userdata('unit_kerja_e1');
		$data =$this->programkl_model->easyGrid($file1,$filtahun);
		//var_dump($file1);die;
		echo $this->programkl_model->easyGrid($file1,$filtahun);
	}

	private function get_form_values() {
		$dt['tahun'] = $this->input->post("tahun", TRUE);
		$dt['detail'] = $this->input->post("detail", TRUE);
		$dt['kode_e1'] = $this->input->post("kode_e1", TRUE);
		return $dt;
    }

	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$result = "";
		
		# insert to tbl_program_kl
		foreach($data['detail'] as $dt){
			$data['tahun'] = $data['tahun'];
			$data['kode_program'] = $dt['kode_program'];
			$data['nama_program'] = $dt['nama_program'];
			$data['total'] = $dt['total'];
			$result = $this->programkl_model->InsertOnDB_programKL($data);
		}
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>'Some errors occured!'));
		}
	}
	
	function save_edit(){
		$this->load->library('form_validation');
		$result = "";
		
		//$data['id_program_kl'] = $this->input->post('id_program_kl');
		$data['tahun'] = $this->input->post('tahun');
		$data['tahun_old'] = $this->input->post('tahun_old');
		
		$data['kode_e1'] = $this->input->post('kode_e1');
		$data['kode_program_old'] = $this->input->post('kode_program_old');
		$data['kode_program'] = $this->input->post('kode_program');
		$data['nama_program'] = $this->input->post('nama_program');
		$data['total'] = $this->input->post('total');
		
		# insert to tbl_program_kl
		if ($data['tahun_old']==''||$data['kode_program']=='') {
			if ($this->programkl_model->isExist($data['tahun'],$data['kode_program'])){
				$result = false;
				$msg = 'Kode Program '.$data['kode_program'].'untuk tahun '.$data['tahun'].' sudah ada.';
			}				
			else $result = $this->programkl_model->InsertOnDB_programKL($data);
				
		}else {
			if ($this->programkl_model->isExist($data['tahun'],$data['kode_program'],$data['tahun_old'],$data['kode_program_old'])){
				$result = false;
				$msg = 'Kode Program '.$data['kode_program'].'untuk tahun '.$data['tahun'].' sudah ada.';
			}				
			else $result = $this->programkl_model->UpdateOnDB_programKL($data);
		}
		
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>$msg));
		}
	}
	
	function delete($kode_program='',$tahun=''){
		if($tahun != ''){
			if ($this->programkl_model->isSaveDelete($kode_program,$tahun))
				$result = $this->programkl_model->DeleteOnDb($tahun,$kode_program);
			else
				$result = false;
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Data tidak bisa dihapus karena sudah digunakan sebagai referensi data lainnya.', 'data'=> ''));
			}
		}
	}
	
	public function excel($file1=null,$filtahun=null){
		echo  $this->programkl_model->easyGrid($file1,$filtahun,3);
	}
	
	public function pdf($file1=null,$filtahun=null){
		$this->load->library('our_pdf');
		$this->our_pdf->FPDF('P', 'mm', 'A4'); 
		$pdfdata = $this->programkl_model->easyGrid($file1,$filtahun,2);
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
		
		$e1= '';
		if (($file1 != null)&&($file1 != "-1")){
			$e1=$this->eselon1_model->getNamaE1($file1);
		}
		$this->our_pdf->text($posX,$posY,'Daftar Program '.$e1);
		$this->our_pdf->setFont('Arial','',10);
		if (($filtahun != null)&&($filtahun != "-1")){
			$posY += 5;
			$this->our_pdf->setXY($posX,$posY);
			$this->our_pdf->text($posX,$posY,'Tahun '.$filtahun);
		}
		$posY += 5;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->text($posX,$posY,"Kementerian Perhubungan");
					
		$this->our_pdf->setFont('Arial','B',8);
		$posY += 6;
		$this->our_pdf->setXY($posX,$posY);
		$this->our_pdf->setFillColor(255,255,255);
		
		$this->our_pdf->SetWidths(array(10,12,30,110,30));
		 $this->our_pdf->SetAligns(array("C","C","C","C","C"));
		$this->our_pdf->Row(array('No.','Tahun','Kode Program','Nama Program','Total Anggaran(Rp)')); 
			
		//$yi = 18;
		if (($filtahun != null)&&($filtahun != "-1"))
			$posY = 32;//44;
		else
			$posY = 27;//44;
		$posX = 10;
		$row = 0;
		
		//$posY = $yi + $row;
		$max = 31;
		$row = 6; 

		
		//================ setting isi ===========
		
		// $this->our_pdf->SetWidths(array(10,25,100,30,40,25,25,25));
		 $this->our_pdf->SetAligns(array("C","C","L","L","R"));
		//srand(microtime()*1000000);
		$this->our_pdf->setFillColor(255,255,255);
		$this->our_pdf->setFont('arial','',8);	
		$this->our_pdf->setXY($posX,$posY);
		$e1 = '';
		for ($i=0;$i<count($pdfdata);$i++){
			$this->our_pdf->setFont('arial','',8);	
			//tambah group
			if (($file1 != null)&&($file1 != "-1")) {
					$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4])); 
			}
			else {
				if ($e1!=$pdfdata[$i][5]){
					$e1=$pdfdata[$i][5];
					$this->our_pdf->setFont('arial','B',8);	
					$this->our_pdf->CELL(192,5,$this->eselon1_model->getNamaE1($pdfdata[$i][5]),1,0,'L',1);
					$this->our_pdf->Ln(5);
					$this->our_pdf->setFont('arial','',8);	
					
				}
				$this->our_pdf->Row(array($pdfdata[$i][0],$pdfdata[$i][1],$pdfdata[$i][2],$pdfdata[$i][3],$pdfdata[$i][4])); 
			}
			
		}
		$this->our_pdf->AliasNbPages();
		$this->our_pdf->Output("Program.pdf","I");
	}
	
	public function pdfOld($file1=null,$filtahun=null){
		$this->load->library('cezpdf');	
		$pdfdata = $this->programkl_model->easyGrid($file1,$filtahun,2);
		if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
		//$pdfdata = $pdfdata->rows;
		if (($file1 != null)&&($file1 != "-1"))
			$pdfhead = array('No.','Tahun','Kode Program','Nama Program','Total Anggaran(Rp)');
		else
			$pdfhead = array('No.','Tahun','Kode Program','Nama Program','Total Anggaran(Rp)','Kode Subsektor');

		$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
		
		if (($file1 != null)&&($file1 != "-1"))
			$title=$this->eselon1_model->getNamaE1($file1);
		else
			$title = "Kementerian Perhubungan";
		$pdf->ezText('Daftar Program '.$title,12,array('left'=>'1'));
		if (($filtahun != null)&&($filtahun != "-1"))
			$pdf->ezText("Tahun ".$filtahun,10,array('left'=>'1'));
		$pdf->ezText('');
		//halaman 
		$pdf->ezStartPageNumbers(550,10,8,'right','',1);
		
		
		if (($file1 != null)&&($file1 != "-1")){
			$cols = array(
				 0=>array('justification'=>'right','width'=>25),
				 1=>array('justification'=>'center','width'=>40),
				 2=>array('justification'=>'center','width'=>65),
				 3=>array('width'=>300),
				 4=>array('justification'=>'right','width'=>90));
		}
		else{
			$cols = array(
				 0=>array('justification'=>'right','width'=>25),
				 1=>array('justification'=>'center','width'=>40),
				 2=>array('justification'=>'center','width'=>65),
				 3=>array('width'=>250),
				 4=>array('justification'=>'right','width'=>90),
				 5=>array('width'=>50));
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
		$opt['Content-Disposition'] = "Program.pdf";
		$pdf->ezStream($opt);
	}
	
	public function getListTahun($objectId=null){
		echo $this->programkl_model->getListTahun($objectId);
	}

	public function loadProgram($e1,$tahun,$objectId=null){
		$data['tahun'] = $tahun;
		$data['kode_e1'] = $e1;
		echo $this->programkl_model->getListProgramKL($objectId,$data);
	}

}
?>
