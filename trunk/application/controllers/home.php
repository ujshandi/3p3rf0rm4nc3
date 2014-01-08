<?php

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();			
		
	//	$userdata = array ('userLogin' => $userLogin,'logged_in' => TRUE,'groupId'=>$this->sys_login_model->groupId,'fullName'=>$this->sys_login_model->fullName,'userId'=>$this->sys_login_model->userId,'groupLevel'=>$this->sys_login_model->level);
		//$userdata = array ('logged_in' => TRUE);
				//
		//$this->session->set_userdata($userdata);
			//var_dump($this->session->userdata('user_id'));	
		if ($this->session->userdata('user_id') != TRUE) redirect(base_url());					
		$this->load->model('/security/sys_menu_model');
		//$this->load->library("utility");
	}
	
	function index()
	{
		$data = array(
				
					'title_page'=>'Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan',
					'sess_fullname'=>$this->session->userdata('full_name'),
					'sess_apptype'=>$this->session->userdata('app_type'),//easyui/jquery-1.6.min.js
					'js'=>array('js/jquery-easyui-1.3.3/jquery.min.js','js/jquery-easyui-1.3.3/jquery.easyui.min.js','js/jquery-easyui-1.3.3/plugins/jquery-easyui-datagridview/datagrid-detailview.js','js/jquery-easyui-1.3.3/plugins/jquery-easyui-datagridview/datagrid-groupview.js','js/uri_encode_decode.js','js/json2.js','js/jquery.autosize.min.js','js/jquery.formatCurrency-1.4.0.min.js','js/formwizard.js','js/jquery.jqURL.js','js/ckeditor/ckeditor.js','js/purl.js','js/autoNumeric.js'),
					/* 'js'=>array('js/jquery-easyui-1.3.3/jquery.min.js','js/jquery-easyui-1.3.3/jquery.easyui.min.js','js/easyui/plugins/datagrid-detailview.js','js/uri_encode_decode.js','js/json2.js','js/jquery.autogrow.js','js/jquery.formatCurrency-1.4.0.min.js','js/formwizard.js','js/jquery.jqURL.js','js/ckeditor/ckeditor.js',
					'js/purl.js'), */
					'css'=>array('css/jquery-easyui-1.3.3/themes/gray/easyui.css','css/themes/icon.css','css/head_style.css')
				);
		//$data['title'] =$this->session->userdata('userlogin');
	  
		//$data['menuList'] =  $this->sys_menu_model->prepareMenuManual();//($this->session->userdata('groupId'),'');
		$data['listAutoTab'] = $this->sys_menu_model->getAutoTab($this->session->userdata('group_id'));
		$this->load->view('home_vw',$data);
		//$this->load->view('footer_vw',$data);
	}
	
	public function loadMenu(){
	//	var_dump('tes');
		echo $this->sys_menu_model->loadMenu($this->session->userdata('app_type'),null,true);
	}
	
	function getLoginStatus(){
		echo $this->session->userdata('logged_in');
	}
	
}
?>
