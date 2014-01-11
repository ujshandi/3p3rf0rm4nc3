<?php

class Eselon1 extends CI_Controller {
	var $objectId = 'Eselon1';
	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
						
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->library("utility");
		
	}
	
	function index(){
		$data['title'] = 'Eselon 1';		
		$data['objectId'] = $this->objectId;
	  	$this->load->view('rujukan/eselon1_v',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	function grid(){
		//decode filter
		
		echo $this->eselon1_model->easyGrid();
	}
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['kode_e1'] = $this->input->post("kode_e1", TRUE); //id
		$data['kode_kl'] = $this->input->post("kode_kl", TRUE);
		
		$data['nama_e1'] = $this->input->post("nama_e1", TRUE);
		$data['singkatan'] = $this->input->post("singkatan", TRUE);
		$data['nama_dirjen'] = $this->input->post("nama_dirjen", TRUE);
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
		/* $this->form_validation->set_rules("kode_e1", 'Kode ESELON 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_kl", 'Kode KL', 'trim|required|xss_clean');
		$this->form_validation->set_rules("nama_e1", 'Nama ESELON 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("singkatan", 'Singkatan', 'trim|required|xss_clean');
		$this->form_validation->set_rules("nama_dirjen", 'Nama Menteri', 'trim|required|xss_clean');
		$this->form_validation->set_rules("nip", 'NIP', 'trim|required|xss_clean');
		$this->form_validation->set_rules("pangkat", 'Pangkat', 'trim|required|xss_clean');
		$this->form_validation->set_rules("gol", 'Golongan', 'trim|required|xss_clean');
		
		
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			$data["pesan_error"].=(trim(form_error("kode_e1"," "," "))==""?"":form_error("kode_e1"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("kode_kl"," "," "))==""?"":form_error("kode_kl"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("nama_e1"," "," "))==""?"":form_error("nama_e1"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("singkatan"," "," "))==""?"":form_error("singkatan"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("nama_dirjen"," "," "))==""?"":form_error("nama_dirjen"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("nip"," "," "))==""?"":form_error("nip"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("pangkat"," "," "))==""?"":form_error("pangkat"," "," ")."<br/>");
			$data["pesan_error"].=(trim(form_error("gol"," "," "))==""?"":form_error("gol"," "," ")."<br/>");
			//$status = $data["pesan_error"];
		}else { */
			if($aksi=="add"){ // add
				if (!$this->eselon1_model->isExistKode($data['kode_e1'])){
					$result = $this->eselon1_model->InsertOnDb($data,$status);
				}
				else
					$data['pesan_error'] .= 'Kode sudah ada';
					
			}else { // edit
				$result=$this->eselon1_model->UpdateOnDb($data,$kode);
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
			if ($this->eselon1_model->isSaveDelete($id))
				$result = $this->eselon1_model->DeleteOnDb($id);
			else
				$result = false;
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Data tidak bisa dihapus karena sudah digunakan sebagai referensi data lainnya.', 'data'=> ''));
			}
		}
	}
	
	//to pdf
	public function pdf(){
		$this->load->library('cezpdf');	
		$pdfdata = $this->eselon1_model->easyGrid(2);
		if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
		//$pdfdata = $pdfdata->rows;
		//$pdfhead = array('No.','Kode Eselon I','Kode Kementerian','Nama Unit Kerja','Singkatan','Nama Pimpinan','N I P','Pangkat','Golongan');
		$pdfhead = array('No.','Kode Unit Kerja','Nama Unit Kerja','Singkatan','Nama Pimpinan','N I P','Pangkat','Golongan');
		$pdf = new $this->cezpdf($paper='A4',$orientation='landscape');
		$pdf->ezSetCmMargins(1,1,1,1);
		$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );
	//	$pdf->ezText('Biroren Kemenhub',8,array('left'=>'1'));
		$pdf->ezText('Daftar Unit Kerja Eselon I',12,array('left'=>'1'));
		$pdf->ezText('Kementerian Perhubungan',10,array('left'=>'1'));
	//	if (($filtahun != null)&&($filtahun != "-1"))
		//	$pdf->ezText('Tahun '.$filtahun,12,array('left'=>'1'));
		$pdf->ezText('');
		//halaman 
		$pdf->ezStartPageNumbers(760,10,8,'right','',1);
		
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
				 //1=>array('width'=>40),
				 //2=>array('width'=>70),
				 1=>array('width'=>60),
				 2=>array('width'=>220),
				 3=>array('width'=>100),
				 4=>array('width'=>120),
				 5=>array('width'=>100),
				 6=>array('width'=>110),
				 7=>array('width'=>60),
				 ),
			'width'=>'700'
		);
		$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
		$opt['Content-Disposition'] = "Eselon1.pdf";
		$pdf->ezStream($opt);
	}
	
	public function excel(){
		echo $this->eselon1_model->easyGrid(3);
	}
}
?>