<?
class Group_access extends CI_Controller{
	var $extraHeaderContent;
	
	public function __construct()	{
		parent::__construct();
		if ($this->session->userdata('logged_in') != TRUE) redirect('security/login');		
		$this->load->model('/security/sys_menu_model');
		$this->load->model('/admin/group_access_model');
		$this->load->model('/admin/group_user_model');		
		$this->load->model('/admin/group_level_model');		
		$this->load->model('/admin/user_model');		
		$this->load->helper('form');
		$tmp = '<script type="text/javascript">
				$(document).ready(function() {
					$("#loading").ajaxStart(function(){
					$(this).fadeIn();
				}).ajaxStop(function(){
					$(this).fadeOut();	});
				});	</script>';
		$tmp .= '<style type="text/css">#loading { position: absolute; top: 0; left:0; color: white; background-color: red; padding: 5px 10px; font: 12px</style>';		
		$this->extraHeaderContent= $tmp;		
	}
		
	public function index(){
	    $data['title'] = 'Group User Akses';	  	 		
	    $data['objectId'] = 'groupAkses';	  	 		
		$group_id = (isset($group_id)?$group_id:-1);
		$menu_group = (isset($menu_group)?$menu_group:-2);
	  $data['extraHeadContent'] = $this->extraHeaderContent;
	  /* $data['group_id']  = $group_id;
	  $data['menugroup']  = $menu_group;
	  $data['menuList'] =  $this->sys_menu_model->prepareMenu($this->session->userdata('groupId'),'');
	  $data['gotoList'] = $this->sys_menu_model->gotoMenuList;
	  $data['aksesList'] =  $this->group_access_model->GetListGrid( $group_id,$menu_group);
	  $data['groupList'] = $this->group_user_model->GetListCombo(false,$this->session->userdata('groupLevel'));	 
	  $data['menuGroupList'] = $this->sys_menu_model->GetListDistinctGroupModule();	  */
	  
	  $this->load->view('admin/group_access_vw',$data);
	  
	}	
	
	function loadMenu(){
		echo $this->sys_menu_model->loadMenu($this->session->userdata('app_type'),1);
	}
	
	public function save() {				
		$this->load->library('form_validation');
		$data = $this->get_form_values();
		$status = FALSE;
		
		//validasi form		
		//$this->form_validation->set_rules('cmbGroupUser', 'Group Name', 'trim|required|min_length[1]|xss_clean');
		/* if ($this->form_validation->run() == FALSE){
			//jika data tidak valid kembali ke view
			if($data['group_id']==''){
				$data["pesan_error"] = "Group User belum ditentukan";
				$data["group_id"] = "-1";
				$this->show_page($data);
			}	
			
		}else { */
		//var_dump($data);
			$result = $this->group_access_model->saveToDb($data);				
			if ($result){
				echo json_encode(array('success'=>true, 'status'=>"Penyimpanan Berhasil"));
			} else {
				echo json_encode(array('msg'=>"Data Tidak bisa disimpan"));
			}
		//}
	}
	
    public 	function get_data($level_id,$group_id,$objectId){			
		echo $this->group_access_model->getData($level_id,$group_id,$objectId);		
	}
	
	
	private function get_form_values() {				
		$data["rowcount"] = $this->input->post('rowcount', TRUE);
		$data["group_id"] = $this->input->post('group_id', TRUE);
		$data["level_id"] = $this->input->post('level_id', TRUE);
		for ($i=0;$i<$data["rowcount"];$i++){
			$data["menu_id"][$i] = $this->input->post('menu_id'.($i+1), TRUE);			
			$data["chkView"][$i] = $this->input->post('chkView'.($i+1), true);	
			$data["chkAdd"][$i] = $this->input->post('chkAdd'.($i+1), true);
			$data["chkEdit"][$i] = $this->input->post('chkEdit'.($i+1), true);
			$data["chkDelete"][$i] = $this->input->post('chkDelete'.($i+1), true);
			$data["chkPrint"][$i] = $this->input->post('chkPrint'.($i+1), true);			
			$data["chkExcel"][$i] = $this->input->post('chkExcel'.($i+1), true);
			$data["chkImport"][$i] = $this->input->post('chkImport'.($i+1), true);
			$data["chkProses"][$i] = $this->input->post('chkProses'.($i+1), true);				
			$data["chkCopy"][$i] = $this->input->post('chkCopy'.($i+1), true);				
			$data["chkAuto"][$i] = $this->input->post('chkAuto'.($i+1), true);				
		}		
		return $data;
    }
	
	
}	
?>
