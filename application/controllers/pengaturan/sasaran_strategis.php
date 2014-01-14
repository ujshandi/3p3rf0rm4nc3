<?php

class Sasaran_strategis extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
						
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->library("utility");
		$this->load->helper('form');
	}
	
	function index(){
		$data['title'] = 'Sasaran Kementerian';		
		$data['objectId'] = 'SasaranStrategis';
	  	$this->load->view('pengaturan/sasaran_strategis_v',$data);
	}
	
	public function copy(){
		$data['title'] = 'Copy Data Sasaran Kementerian';	
		$data['objectId'] = 'copySasaranStrategis';
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('pengaturan/sasaran_strategis_copy_v',$data);
	}
	
	function grid($filtahun=null,$filkey=null){
		echo $this->sasaran_kl_model->easyGrid($filtahun,$filkey,1);
	}
	
	function getNewCode($kl,$tahun){
		//fieldName,$tblName,$condition,$prefix,$suffix,$minLength=5
		$prefix = "SSKP";//$this->utility->getValueFromSQL("select prefix as rs from tbl_prefix where kode_e1 = '$e1'","UNSET");
		//var_dump($prefix); die;
		echo $this->utility->ourGetNextIDNum("kode_sasaran_kl","tbl_sasaran_kl"," and tahun = '$tahun'",$prefix.".","",2);
	}
	
	function getListCombo(){
		//echo $this->dokter_model->getListCombo();
	}
	
	private function get_form_values() {
		// XXS Filtering enforced for user input
		$data['tahun'] = $this->input->post("tahun", TRUE); //tahun
		$data['kode_sasaran_kl'] = $this->input->post("kode_sasaran_kl", TRUE); //id
		$data['deskripsi'] = $this->input->post("deskripsi", TRUE);
		$data['kode_kl'] = $this->input->post("kode_kl", TRUE);
		//$data["insert_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		//$data["update_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		return $data;
    }
	
	function save($aksi="", $kode="",$tahun=''){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = "";
		$result = false;
	
		//validasi form
		$this->form_validation->set_rules("kode_sasaran_kl", 'Kode Sasaran Strategis', 'trim|required|xss_clean');
		$this->form_validation->set_rules("deskripsi", 'Deskripsi', 'trim|required|xss_clean');

		$data['pesan_error'] = '';
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			$data["pesan_error"].=(trim(form_error("kode_sasaran_kl"," "," "))==""?"":form_error("kode_sasaran_kl"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("deskripsi"," "," "))==""?"":form_error("deskripsi"," "," ")."<br>");			
			$status = $data["pesan_error"];
		}else {
			if($aksi=="add"){ // add
			if (!$this->sasaran_kl_model->isExistKode($data['kode_sasaran_kl'],$data['tahun'])){
					$result = $this->sasaran_kl_model->InsertOnDb($data,$status);
				}
				else
					$data['pesan_error'] .= 'Kode sasaran dan tahun sudah ada!';
					
			}else { // edit
				$result=$this->sasaran_kl_model->UpdateOnDb($data,$kode,$tahun);
		
			}
			$data['pesan_error'] .= $status;	
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'kode'=>$kode));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
		//echo $status;
	}
	
	function saveCopy($tahun,$tahun_tujuan,$kode_kl){		
		$status = "";
		$result = false;		
		$data['pesan_error'] = '';
		
		# validasi
		# message rules
		//if ($result){
			$data['tahun'] = $tahun;
			$data['tahun_tujuan'] = $tahun_tujuan;
			$data['kode_kl'] = $kode_kl;
			
			$result = $this->sasaran_kl_model->copy($data,$status);
			$data['pesan_error'] = $status;
	//	}		
		if ($result){
			echo json_encode(array('success'=>true, 'msg'=>"Data Berhasil di copy"));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
		//echo $status;
	}
	
	function delete($tahun, $kode_sasaran_kl){
		# cek keberadaan di RKT
		// jika ada di RKT
		if($this->sasaran_kl_model->existInRKT($tahun, $kode_sasaran_kl)){
			echo json_encode(array('msg'=>'Data sasaran tidak dapat dihapus karena sudah digunakan di RKT', 'data'=> ''));
		}else{
			$result = $this->sasaran_kl_model->DeleteOnDb($tahun, $kode_sasaran_kl);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
		
	public function pdf($filtahun=null,$filkey=null){
		$this->load->library('cezpdf');	
			$pdfdata = $this->sasaran_kl_model->easyGrid($filtahun,$filkey,2);
			if (count($pdfdata)==0){
				echo "Data Tidak Tersedia";
				return;
			}
			//$pdfdata = $pdfdata->rows;
			$pdfhead = array('No.','Kode Sasaran','Deskripsi Sasaran');
			$pdf = new $this->cezpdf($paper='A4',$orientation='potrait');
			$pdf->ezSetCmMargins(1,1,1,1);
			$pdf->selectFont( APPPATH."libraries/fonts/Helvetica.afm" );

			//Judul 
			$pdf->ezText('Sasaran Strategis Kementerian Perhubungan',12,array('left'=>'1'));
			if (($filtahun != null)&&($filtahun != "-1")) {
				$thn = 'Tahun '.$filtahun;
				$pdf->ezText($thn,12,array('left'=>'1'));
			}
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
					 2=>array('width'=>420)),
				'width'=>'520'
			);
			$pdf->ezTable( $pdfdata, $pdfhead, NULL, $options );
			$opt['Content-Disposition'] = "SasaranKementerian.pdf";
			$pdf->ezStream($opt);
		}
		
		public function excel($filtahun=null,$filkey=null){
			echo  $this->sasaran_kl_model->easyGrid($filtahun,$filkey,3);
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
					var_dump($isi_file);die;	
					// baca per baris
					foreach($row as $r){
						/ keterangan
							0			1					2
							kode_kl		kode_sasaran_kl		deskripsi
						/
						
						# baca per kolom
						$col = explode(";", $r);

						$data['kode_kl'] 			= $col[0];
						$data['kode_sasaran_kl'] 	= $col[1];
						$data['deskripsi'] 			= $col[2];
						
						# proses
						$this->sasaran_kl_model->importData($data);						
					}
					
				}elseif($extensi == 'application/x-msdownload'){ */ //Excel 2003
					# load librari
					$this->load->library('excel');
					$this->excel->setOutputEncoding('CP1251');
					$this->excel->read($direktori); // baca file
				/* 	if ($error !=""){
						$result = false;
					}
					else { */
					//var_dump($this->excel->sheets[0]);die;
					# baca per baris
						for($i=2, $n=$this->excel->rowcount(0); $i<= $n; $i++){
							# data
							$data['tahun'] 				= $this->excel->val($i, 1);
							$data['kode_kl'] 			= $this->excel->val($i, 2);
							$data['kode_sasaran_kl'] 	= $this->excel->val($i, 3);
							$data['deskripsi'] 			= $this->excel->val($i, 4);
							
							# proses
							$result=$this->sasaran_kl_model->importData($data);
							if (!$result) $error = "Gagal Import, kemungkinan data yang diimport sudah ada pada database";
						}
					//}
					
				/* }else{
					$result=false;
					$error = "Format File tidak diketahui.";
				}
				 */
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
