<?php

class Checkpointe2 extends CI_Controller {
	
	var $objectId = 'checkpointe2';
	protected $path_img_upload_folder;
    protected $path_img_thumb_upload_folder;
    protected $path_url_img_upload_folder;
    protected $path_url_img_thumb_upload_folder;

    protected $delete_img_url;
    
	function __construct()
	{
		parent::__construct();			

		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/checkpoint/checkpointe2_model');
		$this->load->model('/rencana/rpt_rkteselon2_model');
		$this->load->model('/rujukan/eselon1_model');
		$this->load->model('/rujukan/eselon2_model');
		$this->load->model('/pengaturan/sasaran_eselon2_model');
		$this->load->model('/rencana/rkteselon2_model');
		$this->load->library("utility");
		//upload
		//Set relative Path with CI Constant
        $this->setPath_img_upload_folder("upload/pendukung/e2/");
        $this->setPath_img_thumb_upload_folder("assets/img/articles/thumbnails/");

        
//Delete img url
        $this->setDelete_img_url(base_url() . 'checkpoint/checkpointe2/deleteImage/');
 

//Set url img with Base_url()
        $this->setPath_url_img_upload_folder(base_url() . "upload/pendukung/e2/");
        $this->setPath_url_img_thumb_upload_folder(base_url() . "assets/img/articles/thumbnails/");
		
	}
	
	function index(){
		$data['title'] = 'Penetapan Kinerja Eselon II';	
		$data['objectId'] = $this->objectId;
		$data['purpose'] = 'Rencana';
		$data['listPeriode'] = $this->utility->getListCheckpoint(date("n"),"cmbPeriode".$this->objectId);
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
		$data['nama_folder'] = $this->getFolderName();
	  	$this->load->view('checkpoint/checkpointe2s_v',$data);
	}
	
	function capaian(){
		$data['title'] = 'Penetapan Kinerja Eselon II';	
		$this->objectId = 'checkpointCapaiane2';
		$data['objectId'] = $this->objectId;
		$data['purpose'] = 'Capaian';
		$data['listPeriode'] = $this->utility->getListCheckpoint("","cmbPeriode".$this->objectId);
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointe2s_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Data Penetapan Kinerja Eselon II';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointe2_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' Data Penetapan Kinerja Eselon II';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->checkpointe2_model->getDataEdit($id);
		
	  	$this->load->view('checkpoint/checkpointe2_v_edit',$data);
	}
	
	function getFolderName(){
		//fieldName,$tblName,$condition,$prefix,$suffix,$minLength=5
		$prefix = "";//$this->utility->getValueFromSQL("select prefix as rs from tbl_prefix where kode_e2 = '$e2'","UNSET");
		//var_dump($prefix); die;
		//echo $this->utility->ourGetNextIDNum("nama_folder_pendukung","tbl_checkpoint_kl","",$prefix.".","",10);
		//return date('y-m-d_H-i-s-u');
		return 'ga jadi';
	}


	function getDataEdit($id){
		echo $this->checkpointe2_model->getDataEdit($id);
	}
	
	function grid($filtahun=null,$file2=null){
		if (($file2==null)&&($this->session->userdata('unit_kerja_e2'))!=-1)
			$file2= $this->session->userdata('unit_kerja_e2');
		echo $this->checkpointe2_model->easyGrid($filtahun,$file2);
	}
	
	function griddetail($id_pk){
		echo $this->checkpointe2_model->easyGridDetail($id_pk);
	}
	
	function getListSasarane2($objectId,$e2){
		echo $this->sasaran_eselon2_model->getListSasarane2($objectId,$e2);
	}
	
	private function get_form_values() {
		$dt['id_pk_e2'] = $this->input->post("id_pk_e2", TRUE); 
		$dt['id_checkpoint_e2'] = $this->input->post("id_checkpoint_e2", TRUE); 
		$dt['unit_kerja'] = $this->input->post("unitkerja", TRUE); 
		$dt['kriteria'] = $this->input->post("kriteria", TRUE); 
		$dt['ukuran'] = $this->input->post("ukuran", TRUE); 
		$dt['periode'] = $this->input->post("cmbPeriode".$this->objectId, TRUE); 
		$dt['target'] = $this->input->post("target", TRUE); 
		$dt['keterangan'] = $this->input->post("keterangan", TRUE); 
		$dt['capaian'] = $this->input->post("capaian", TRUE);
		$dt['purpose'] = $this->input->post("purpose", TRUE);
		$dt['nama_folder_pendukung'] = $this->input->post("nama_folder_pendukung", TRUE);
		if ($dt['nama_folder_pendukung']=="")
			$dt['nama_folder_pendukung'] = base_url().'upload/pendukung/e2/'.$dt['id_pk_e2'].'/'.$dt['periode'];
		
		return $dt;
    }
	
	/* function getListSasarane2($objectId,$e2){
		echo $this->sasaran_eselon2_model->getListSasarane2($objectId,$e2);
	} */
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$return_id = 0;
		$result = "";
		$data['pesan_error'] = '';
		$pesan = 't';
		
		// validation
		# rules
/*
		$this->form_validation->set_rules("tahun", 'Tahun', 'trim|required|numeric|exact_length[4]|xss_clean');
		$this->form_validation->set_rules("kode_e2", 'Eselon 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules("kode_sasaran_e2", 'Sasaran Eselon 1', 'trim|required|xss_clean');
		
		
*/
		$this->form_validation->set_rules("id_pk_e2", 'ID Penetapan Eselon II', 'trim|required|xss_clean');
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
		$data['pesan_error'].=(trim(form_error('id_pk_e2',' ',' '))==''?'':form_error('id_pk_e2',' ','<br>'));
/*
			$data['pesan_error'].=(trim(form_error('tahun',' ',' '))==''?'':form_error('tahun',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_e2',' ',' '))==''?'':form_error('kode_e2',' ','<br>'));
			$data['pesan_error'].=(trim(form_error('kode_sasaran_e2',' ',' '))==''?'':form_error('kode_sasaran_e2',' ','<br>'));
*/
			
		}else{
			// validasi detail
		//	if($this->check_detail($data, $pesan)){
				
			if(($data['id_checkpoint_e2']!="")&&($data['id_checkpoint_e2']!=null)){
				$result = $this->checkpointe2_model->UpdateOnDb($data);
			}
			else
				if (!$this->checkpointe2_model->isExist($data['id_pk_e2'],$data['periode'])){
					$result = $this->checkpointe2_model->InsertOnDb($data);
				}
				else
					$data['pesan_error'] .= 'Data Checkpoint untuk periode ini sudah ada!';	
/*
			}else{
				$data['pesan_error'].= $pesan;
			}
*/
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'status'=>$return_id));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
	}
	
	function check_detail($data, & $pesan){
		$i=1;
		foreach($data['detail'] as $r){
			if($r['penetapan'] == ''){ // nilai target null
				$pesan = 'Penetapan pada no. '.$i.' harus diisi.';
				return FALSE;
			}
			$i++;
		}
		
		return TRUE;
	}
	
	function save_edit(){
		$this->load->library('form_validation');
		$return_id = 0;
		$result = "";
		
		$data['id_pk_e2'] = $this->input->post('id_pk_e2');
		$data['penetapan'] = $this->input->post('penetapan');
		
		// validation
		
		$result = $this->checkpointe2_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->checkpointe2_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $kode_e2="", $kode_sasaran_e2=""){
		echo $this->checkpointe2_model->getDetail($tahun, $kode_e2, $kode_sasaran_e2);
	}
	
	function deleteFile($kd_e2,$id_pk_e2,$periode,$file){
		$url = "./".$this->getPath_img_upload_folder().$kd_e2.'/'.$id_pk_e2.'/'.$periode.'/'.urldecode($file);
		$success = is_file($url);
		 if ($success) {
			 $success=unlink($url); 
		}
		echo $success;
	}
	
	
	public function upload($kd_kl,$id_pk_kl,$periode)
    {
        error_reporting(E_ALL | E_STRICT);

        $this->load->helper("upload.class");
	//	$name = $_FILES['fileupload']['name'];
       // $name = strtr($name, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

// remplacer les caracteres autres que lettres, chiffres et point par _

        // $name = preg_replace('/([^.a-z0-9]+)/i', '_', $name);

        //Your upload directory, see CI user guide
        $config['upload_dir'] = $this->getPath_img_upload_folder().'/'.$kd_kl.'/'.$id_pk_kl.'/'.$periode.'/';
        $config['upload_url'] = $this->getPath_img_upload_folder().'/'.$kd_kl.'/'.$id_pk_kl.'/'.$periode.'/';
  
        $config['allowed_types'] = 'docx|doc|xls|xlsx|ppt|pptx|gif|jpg|png|JPG|GIF|PNG';
        $config['max_size'] = '1000';
     //   $config['file_name'] = $name;
      //  $config['script_url'] = $name;
        ///$upload_handler = new UploadHandler($config);
        $upload_handler = new UploadHandler($config,false);

        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
                if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $upload_handler->delete();
                } else {
                    $upload_handler->post();
                }
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }

    }
    
    public function getListFile($kd_e2,$id_pk_e2,$periode){
		$url = "./".$this->getPath_img_upload_folder().$kd_e2.'/'.$id_pk_e2.'/'.$periode.'/';
		$data =get_dir_file_info($url);
		$rs = '';
		if ($data != null) {
			foreach($data as $row){
				if ($row['name']=='thumbnail') continue;
				$rs .= '<tr class="template-download fade">';	
				//$fileInfo=get_file_info($url.$row['name'],"size,date");
				$filename=$row['name'];
				$urlDelete="'".$kd_e2."','".$id_pk_e2."','".$periode."','".$filename."'";
				//
				$rs .= ''
				.'<td class="name">'.$row['name'].'</td>'
				.'<td  class="size"></td><td colspan="2"></td>'			
				.'<td><button class="btn btn-danger delete" onclick="deleteFilePendukung('.$urlDelete.');return false;"><i class="icon-bootstrap-trash icon-bootstrap-white"></i><span>Delete</span></button> ' 
										.'</td>'
				.'</tr>';
			}
		}	
		
		echo $rs;
		//$rs = scandir($url);
		//header('Content-type: application/json');
        //echo json_encode($rs);           
	}
	
	public function getPath_img_upload_folder() {
        return $this->path_img_upload_folder;
    }

    public function setPath_img_upload_folder($path_img_upload_folder) {
        $this->path_img_upload_folder = $path_img_upload_folder;
    }

    public function getPath_img_thumb_upload_folder() {
        return $this->path_img_thumb_upload_folder;
    }

    public function setPath_img_thumb_upload_folder($path_img_thumb_upload_folder) {
        $this->path_img_thumb_upload_folder = $path_img_thumb_upload_folder;
    }

    public function getPath_url_img_upload_folder() {
        return $this->path_url_img_upload_folder;
    }

    public function setPath_url_img_upload_folder($path_url_img_upload_folder) {
        $this->path_url_img_upload_folder = $path_url_img_upload_folder;
    }

    public function getPath_url_img_thumb_upload_folder() {
        return $this->path_url_img_thumb_upload_folder;
    }

    public function setPath_url_img_thumb_upload_folder($path_url_img_thumb_upload_folder) {
        $this->path_url_img_thumb_upload_folder = $path_url_img_thumb_upload_folder;
    }

    public function getDelete_img_url() {
        return $this->delete_img_url;
    }

    public function setDelete_img_url($delete_img_url) {
        $this->delete_img_url = $delete_img_url;
    }
	
}
?>
