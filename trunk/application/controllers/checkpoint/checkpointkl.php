<?php

class Checkpointkl extends CI_Controller {
	var $objectId = 'checkpointkl';
	
	
    protected $path_img_upload_folder;
    protected $path_img_thumb_upload_folder;
    protected $path_url_img_upload_folder;
    protected $path_url_img_thumb_upload_folder;

    protected $delete_img_url;
    
    
	function __construct()
	{
		parent::__construct();			
		
		//$this->output->enable_profiler(true);
		
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
				
		//if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/checkpoint/checkpointkl_model');
		$this->load->model('/rujukan/kl_model');
		$this->load->model('/pengaturan/sasaran_kl_model');
		$this->load->model('/rencana/rktkl_model');
		$this->load->library("utility");
		
		//upload
		//Set relative Path with CI Constant
        $this->setPath_img_upload_folder("upload/pendukung/kl/");
        $this->setPath_img_thumb_upload_folder("assets/img/articles/thumbnails/");

        
//Delete img url
        $this->setDelete_img_url(base_url() . 'checkpoint/checkpointkl/deleteImage/');
 

//Set url img with Base_url()
        $this->setPath_url_img_upload_folder(base_url() . "upload/pendukung/kl/");
        $this->setPath_url_img_thumb_upload_folder(base_url() . "assets/img/articles/thumbnails/");
		
	}
	
	function index(){
		
		$data['title'] = 'Penetapan Kinerja Kementerian';	
		$this->objectId = 'checkpointkl';
		$data['purpose'] = 'Rencana';
		$data['objectId'] = $this->objectId; 
		$data['listPeriode'] = $this->utility->getListCheckpoint(date("n"),"cmbPeriode".$this->objectId);
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
		$data['nama_folder'] = $this->getFolderName();
	  	$this->load->view('checkpoint/checkpointkls_v',$data);
	}
	
	function capaian(){
		$data['title'] = 'Penetapan Kinerja Kementerian';	
		$this->objectId = 'checkpointCapaiankl';
		$data['objectId'] = $this->objectId;
		$data['purpose'] = 'Capaian';
		$data['listPeriode'] = $this->utility->getListCheckpoint("","cmbPeriode".$this->objectId);
		
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointkls_v',$data);
	}
	
	public function add(){
		$data['title'] = 'Add Checkpoint Kementerian';	
		$data['objectId'] = $this->objectId;
		//$data['formLookupTarif'] = $this->tarif_model->lookup('#winLookTarif'.$data['objectId'],"#medrek_id".$data['objectId']);
	  	$this->load->view('checkpoint/checkpointkl_v',$data);
	}
	
	public function edit($id, $editmode='true'){
		$editmode = ($editmode=='true'?TRUE:FALSE);	
		$data['editmode'] = $editmode;
		$data['title'] = ($editmode==TRUE?'Edit':'View').' Checkpoint Kementerian';	
		$data['objectId'] = $this->objectId;
		$data['editMode'] = $editmode;
		
		$data['result'] = $this->checkpointkl_model->getDataEdit($id);
		
	  	$this->load->view('checkpoint/checkpointkl_v_edit',$data);
	}
	
	function getFolderName(){
		//fieldName,$tblName,$condition,$prefix,$suffix,$minLength=5
		$prefix = "";//$this->utility->getValueFromSQL("select prefix as rs from tbl_prefix where kode_e1 = '$e1'","UNSET");
		//var_dump($prefix); die;
		//echo $this->utility->ourGetNextIDNum("nama_folder_pendukung","tbl_checkpoint_kl","",$prefix.".","",10);
		//return date('y-m-d_H-i-s-u');
		return 'ga jadi';
	}
	
	function getDataEdit($id){
		echo $this->checkpointkl_model->getDataEdit($id);
	}
	
	function grid($filtahun=null){
		echo $this->checkpointkl_model->easyGrid($filtahun);
	}
	
	function griddetail($id_pk){
		echo $this->checkpointkl_model->easyGridDetail($id_pk);
	}
	
	private function get_form_values() {
		
		$dt['id_pk_kl'] = $this->input->post("id_pk_kl", TRUE); 
		$dt['id_checkpoint_kl'] = $this->input->post("id_checkpoint_kl", TRUE); 
		$dt['unit_kerja'] = $this->input->post("unitkerja", TRUE); 
		$dt['kriteria'] = $this->input->post("kriteria", TRUE); 
		$dt['ukuran'] = $this->input->post("ukuran", TRUE); 
		$dt['periode'] = $this->input->post("cmbPeriode".$this->objectId, TRUE); 
		//var_dump($dt['periode']);die;
		$dt['target'] = $this->input->post("target", TRUE); 
		$dt['keterangan'] = $this->input->post("keterangan", TRUE); 
		$dt['capaian'] = $this->input->post("capaian", TRUE); 
		$dt['purpose'] = $this->input->post("purpose", TRUE);
		
		$dt['nama_folder_pendukung'] = $this->input->post("nama_folder_pendukung", TRUE);
		if ($dt['nama_folder_pendukung']=="")
			$dt['nama_folder_pendukung'] = base_url().'upload/pendukung/kl/'.$dt['id_pk_kl'].'/'.$dt['periode'];
		return $dt;
    }
	
	function save(){
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$return_id = 0;
		$result = "";
		$data['pesan_error'] = '';
		$pesan = '';
		
		// validation
		# rules
		
		$this->form_validation->set_rules("id_pk_kl", 'ID Penetapan KL', 'trim|required|xss_clean');

		
		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		$this->form_validation->set_message('numeric', 'Isi field %s dengan angka');
		$this->form_validation->set_message('exact_length', 'Isi field %s dengan 4 karakter angka');
		
		if ($this->form_validation->run() == FALSE){ // jika tidak valid
			//$data['pesan_error'].=(trim(form_error('tahun'.$this->objectId,' ',' '))==''?'':form_error('tahun'.$this->objectId,' ','<br>'));
			$data['pesan_error'].=(trim(form_error('id_pk_kl',' ',' '))==''?'':form_error('id_pk_kl',' ','<br>'));
			//$data['pesan_error'].=(trim(form_error('kode_sasaran_kl',' ',' '))==''?'':form_error('kode_sasaran_kl',' ','<br>'));
			
		}else{
			// validasi detail
			
			if(($data['id_checkpoint_kl']!="")&&($data['id_checkpoint_kl']!=null)){
				$result = $this->checkpointkl_model->UpdateOnDb($data);
			}
			else{
		//	var_dump("kadieuvalid=".(!$this->checkpointkl_model->isExist($data['id_pk_kl'],$data['periode'])));die;
				if (!$this->checkpointkl_model->isExist($data['id_pk_kl'],$data['periode'])){
				
					$result = $this->checkpointkl_model->InsertOnDb($data);
				//	var_dump("kadieu=".$result);die;
				}
				else
					$data['pesan_error'] .= 'Data Checkpoint untuk periode ini sudah ada!';	
			}
				
			//}else{
				//$data['pesan_error'].= $pesan;
		//	}
		}
	//	var_dump("kadieueeee=".$result);die;
		if ($result){
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error'] ));
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
		
		$data['id_pk_kl'] = $this->input->post('id_pk_kl');
		
		
		// validation
		
		$result = $this->checkpointkl_model->UpdateOnDb($data);
		
		if ($result){
			echo json_encode(array('success'=>true, 'tindakan_rwj_id'=>$return_id));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
	}
	
	function deleteFile($kd_kl,$id_pk_kl,$periode,$file){
		$url = "./".$this->getPath_img_upload_folder().$kd_kl.'/'.$id_pk_kl.'/'.$periode.'/'.urldecode($file);
		$success = is_file($url);
		 if ($success) {
			 $success=unlink($url); 
		}
		echo $success;
	}
	
	function delete($id=''){
		if($id != ''){
			$result = $this->checkpointkl_model->DeleteOnDb($id);
			if ($result){
				echo json_encode(array('success'=>true, 'haha'=>''));
			} else {
				echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
			}
		}
	}
	
	public function getDetail($tahun="", $kode_kl="", $kode_sasaran_kl=""){
		echo $this->checkpointkl_model->getDetail($tahun, $kode_kl, $kode_sasaran_kl);
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
    
    
	
	 function uploadifyUploader()
        {
           
           if (!empty($_FILES))
               {
                $tempFile = $_FILES['Filedata']['tmp_name'];
                $targetPath = './uploads/';
                $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

                 if ( ! @copy($tempFile,$targetFile))
                        {
                                if ( ! @move_uploaded_file($tempFile,$targetFile))
                                {
                                        echo "error";
                                }
                                else echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
                        }
                 else echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
            } 
        }
	
	
	
	public function upload_img() {
        $name = $_FILES['fileupload']['name'];
       
        $name = strtr($name, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

// remplacer les caracteres autres que lettres, chiffres et point par _

         $newname = preg_replace('/([^.a-z0-9]+)/i', '_', $name);
 //var_dump($name);die;
        //Your upload directory, see CI user guide
        $config['upload_path'] = $this->getPath_url_img_upload_folder();
  //var_dump( $config['upload_path']);die;
        $config['allowed_types'] = 'docx|doc|xls|xlsx|ppt|pptx|gif|jpg|png|JPG|GIF|PNG';
        $config['max_size'] = '10000';
        $config['file_name'] = $name;

       //Load the upload library
        $this->load->library('upload', $config);
	//	$newname = preg_replace('/([^.a-z0-9]+)/i', '_', $name);
       if ($this->do_upload("fileupload")) {
		   chmod(base_url."upload/barang/".$tmp['file_name'], 755); 
            
/*
            //If you want to resize 
            $config['new_image'] = $this->getPath_img_thumb_upload_folder();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->getPath_img_upload_folder() . $name;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 193;
            $config['height'] = 94;

            $this->load->library('image_lib', $config);

            $this->image_lib->resize();
*/

           $data = $this->upload->data();

            //Get info 
            $info = new stdClass();
            
            $info->name = $name;
            $info->size = $data['file_size'];
            $info->type = $data['file_type'];
            $info->url = $this->getPath_img_upload_folder() . $name;
           // $info->thumbnail_url = $this->getPath_img_thumb_upload_folder() . $name; //I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$name
            $info->delete_url = $this->getDelete_img_url() . $name;
            $info->delete_type = 'DELETE';


           //Return JSON data
           if (IS_AJAX) {   //this is why we put this in the constants to pass only json data
                echo json_encode(array($info));
                //this has to be the only the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
            } else {   // so that this will still work if javascript is not enabled
                $file_data['upload_data'] = $this->upload->data();
                echo json_encode(array($info));
            }
        } else {

           // the display_errors() function wraps error messages in <p> by default and these html chars don't parse in
           // default view on the forum so either set them to blank, or decide how you want them to display.  null is passed.
            $error = array('error' => $this->upload->display_errors('',''));

            echo json_encode(array($error));
        }


       }
  


//Function for the upload : return true/false
  public function do_upload() {

        if (!$this->upload->do_upload()) {

            return false;
        } else {
            //$data = array('upload_data' => $this->upload->data());

            return true;
        }
     }

public function deleteImage() {

        //Get the name in the url
        $file = $this->uri->segment(3);
        
        $success = unlink($this->getPath_img_upload_folder() . $file);
    //    $success_th = unlink($this->getPath_img_thumb_upload_folder() . $file);

        //info to see if it is doing what it is supposed to 
        $info = new stdClass();
        $info->sucess = $success;
        $info->path = $this->getPath_url_img_upload_folder() . $file;
        $info->file = is_file($this->getPath_img_upload_folder() . $file);
        if (IS_AJAX) {//I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } else {     //here you will need to decide what you want to show for a successful delete
            var_dump($file);
        }
    }

    public function get_files() {

        $this->get_scan_files();
    }

    public function get_scan_files() {

        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }

    protected function get_file_object($file_name) {
        $file_path = $this->getPath_img_upload_folder() . $file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {

            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->getPath_url_img_upload_folder() . rawurlencode($file->name);
      //      $file->thumbnail_url = $this->getPath_url_img_thumb_upload_folder() . rawurlencode($file->name);
            //File name in the url to delete 
            $file->delete_url = $this->getDelete_img_url() . rawurlencode($file->name);
            $file->delete_type = 'DELETE';
            
            return $file;
        }
        return null;
    }

    protected function get_file_objects() {
        return array_values(array_filter(array_map(
             array($this, 'get_file_object'), scandir($this->getPath_img_upload_folder())
                   )));
    }
	
	public function getListFile($kd_kl,$id_pk_kl,$periode){
		$url = "./".$this->getPath_img_upload_folder().$kd_kl.'/'.$id_pk_kl.'/'.$periode.'/';
		$data =get_dir_file_info($url);
		$rs = '';
		if ($data != null) {
			foreach($data as $row){
				if ($row['name']=='thumbnail') continue;
				$rs .= '<tr class="template-download fade">';	
				//$fileInfo=get_file_info($url.$row['name'],"size,date");
				$filename=$row['name'];
				$urlDelete="'".$kd_kl."','".$id_pk_kl."','".$periode."','".$filename."'";
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
