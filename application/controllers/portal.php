<?php

class Portal extends CI_Controller {

	var $data;

	function __construct()
	{
		parent::__construct();	
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');					
		$this->load->model('/security/sys_menu_model');		
		$this->load->model('portal_model');		
		
		$this->data = array(
				
			'title_page'=>'Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan',
			'sess_fullname'=>$this->session->userdata('full_name'),
			'sess_apptype'=>$this->session->userdata('app_type'),
			'js'=>array('js/easyui/jquery-1.6.min.js','js/jquery-easyui-1.3.3/jquery.easyui.min.js','js/easyui/plugins/datagrid-detailview.js','js/uri_encode_decode.js','js/json2.js','js/jquery.autogrow.js','js/jquery.formatCurrency-1.4.0.min.js','js/formwizard.js','js/jquery.jqURL.js','js/ckeditor/ckeditor.js'),
			'css'=>array('css/portal/style.css')
		);
	}
	
	function index()
	{

		$this->loadView('portal/home_vw',$this->data);
	}

	function content($menu){
		switch ($menu) {
			case 1:
				$this->load->view('portal/backend/home_v',$this->data);
				break;
			case 2:
				$data['title'] = 'Berita Portal';
				$data['objectId'] = 'portalnews';
				$this->load->view('portal/backend/news_v', $data);
				break;
			case 3:
				$this->load->view('portal/backend/about_v', $data);
				break;
			case 4:
				$data['title'] = 'AKIP Portal';
				$data['objectId'] = 'portalakip';
				$this->load->view('portal/backend/akip_v', $data);
				break;
			case 5:
				$data['title'] = 'Regulasi Portal';
				$data['objectId'] = 'portalreg';
				$this->load->view('portal/backend/regulasi_v', $data);
				break;
			case 6:
				$data['title'] = 'FAQ Portal';
				$data['objectId'] = 'portalfaq';
				$this->load->view('portal/backend/faq_v', $data);
				break;
			case 7:
				$data['title'] = 'Kontak Portal';
				$data['objectId'] = 'portalfaq';
				$this->load->view('portal/backend/kontak_v', $data);
				break;
			case 8:
				$data['title'] = 'Link Portal';
				$data['objectId'] = 'portallink';
				$this->load->view('portal/backend/link_v', $data);
				break;
			default:
				# code...
				break;
		}
	}
	
	// -------------- WHOLE NEWS FUNCTION --------------

	function grid($category_id=1){
		echo $this->portal_model->easyGrid($category_id);
	}

	private function getFormValues($category_id=1) {
		// XXS Filtering enforced for user input
		$data['category_id'] = $category_id;
		$data['content_title'] = $this->input->post("content_title", TRUE);
		$data['content'] = $this->input->post("content", TRUE); 
		$data['summary'] = $this->input->post("summary", TRUE);		
		$data['url'] = $this->input->post("url", TRUE);
		
		//$data["insert_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		//$data["update_log"] = $this->session->userdata("userLogin").",".$this->utility->getFullSystemDate();
		return $data;
    }

    private function validateRules($category_id=1){
    	switch ($category_id) {	
			case 1:
				break;
			case 2:
				$this->form_validation->set_rules("content_title", 'Judul Berita', 'trim|required|xss_clean');
				$this->form_validation->set_rules("content", 'Isi Berita', 'trim|required|xss_clean');
				$this->form_validation->set_rules("summary", 'Ringkas Berita', 'trim|required|xss_clean');
				break;
			case 3:
				break;
			case 4:
				break;
			case 5:
				break;
			case 6:
				break;
			case 7:
				break;
			case 8:
				$this->form_validation->set_rules("content_title", 'Judul Tautan', 'trim|required|xss_clean');
				$this->form_validation->set_rules("url", 'Tautan', 'trim|required|xss_clean');
				break;
			default:
				# code...
				break;
    	}
    }

	function save($category_id=1, $aksi="", $kode=""){
		$this->load->library('form_validation');
		$data = $this->getFormValues($category_id);
		$status = "";
		$result = false;
	    
		$data['pesan_error'] = '';
		
		# validasi rules
		$this->validateRules($category_id);

		# message rules
		$this->form_validation->set_message('required', 'Field %s harus diisi.');
		
		if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			$data["pesan_error"].=(trim(form_error("content_title"," "," "))==""?"":form_error("content_title"," "," ")."<br>");
			//$data["pesan_error"].=(trim(form_error("kode_sasaran_kl"," "," "))==""?"":form_error("kode_sasaran_kl"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("content"," "," "))==""?"":form_error("content"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("summary"," "," "))==""?"":form_error("summary"," "," ")."<br>");
			$data["pesan_error"].=(trim(form_error("url"," "," "))==""?"":form_error("url"," "," ")."<br>");
			$status = $data["pesan_error"];
			
		}else {
			if($aksi=="add"){ // add
				// $result = !$this->sasaran_eselon1_model->isExistKode($data['kode_sasaran_e1']);
				// if ($result)
					$result = $this->portal_model->InsertOnDb($data,$status);
				// else
				//    $data['pesan_error'] = 'Kode sudah ada.';
					
			}else { // edit
				$result=$this->portal_model->UpdateOnDb($data,$kode);
				
			}
			//$data['pesan_error'] .= $status;	
		}
		
		if ($result){
			echo json_encode(array('success'=>true, 'kode'=>$kode));
		} else {
			echo json_encode(array('msg'=>$data['pesan_error']));
		}
		
	}
		
	function delete($category_id, $kode){
		# cek keberadaan di RKT
		// jika ada di RKT
		$result = $this->portal_model->DeleteOnDb($kode);
		if ($result){
			echo json_encode(array('success'=>true, 'haha'=>''));
		} else {
			echo json_encode(array('msg'=>'Some errors occured uy.', 'data'=> ''));
		}
		
	}
	
	function getLoginStatus(){
		echo $this->session->userdata('logged_in');
	}

	function loadView($view='', $data=''){
		$this->load->view('portal/top_vw',$data);
		$this->load->view($view,$data);
		$this->load->view('portal/bottom_vw',$data);
	}
	
}
?>
