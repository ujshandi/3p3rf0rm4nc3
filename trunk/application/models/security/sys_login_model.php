<?
class Sys_login_model extends CI_Model{
	var $groupId;
	var $fullName;
	var $userId;
	var $access_level;
	function __construct(){
		parent::__construct();
		$this->groupId = 0;
		$this->userId = 0;
		$this->access_level= 0;
		$this->fullName = '';
	}

	function cek_login($username,$passwd){

		$new_password = md5($passwd);
		$this->db->select('u.user_name,u.full_name, u.passwd,u.group_id,u.user_id,g.app_type, u.unit_kerja_e1,u.unit_kerja_e2,l.level,l.level_id');
		$this->db->from('tbl_user u');
		$this->db->join('tbl_group_user g','g.group_id = u.group_id');
		$this->db->join('tbl_group_level l','l.level_id = u.level_id',"left");
		$this->db->where('user_name', $username);
		$this->db->where('passwd', $new_password);
		//$this->db->where('disabled_date', null);
		//var_dump('kadieu');die;
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			 $row = $query->row_array();		   
			$this->groupId = $row['group_id'];
			//$this->fullName = $row['full_name'];
			$this->userId = $row['user_id'];
			$this->fullName = $row['full_name'];
			$this->level_id= $row['level_id'];
			//var_dump($this->groupId);die;
			$this->create_session($row['user_id'], $row['user_name'], (($row['user_name']=='superadmin')?'':$row['app_type']), $row['full_name'],true,$row['unit_kerja_e1'],$row['unit_kerja_e2'],$row['level'],$row['group_id'],$row['level_id']);
			$query->free_result();
			$data['user_id']=$row['user_id'];
			$data['user_name']=$row['user_name'];
			$data['unit_kerja_e1']=$row['unit_kerja_e1'];
			$data['unit_kerja_e2']=$row['unit_kerja_e2'];
			return $this->insertLoginLog($data);
			}else {
				$query->free_result();
			return FALSE;
		}
	 
		  
	}
	
	private function create_session($user_id, $user_name, $app_type,$full_name,$logged_in,$unit_kerja_e1,$unit_kerja_e2,$level,$group_id,$level_id) {
		$this->session->set_userdata('user_id',$user_id);
		$this->session->set_userdata('user_name',$user_name);
		$this->session->set_userdata('app_type',$app_type);		
		$this->session->set_userdata('full_name',$full_name);		
		$this->session->set_userdata('logged_in',$logged_in);		
		$this->session->set_userdata('unit_kerja_e1',(($unit_kerja_e1=="")||($unit_kerja_e1=="0")?"-1":$unit_kerja_e1));		
		$this->session->set_userdata('unit_kerja_e2',(($unit_kerja_e2=="")||($unit_kerja_e2=="0")?"-1":$unit_kerja_e2));		
		$this->session->set_userdata('level',$level);		
		$this->session->set_userdata('level_id',$level_id);		
		$this->session->set_userdata('group_id',$group_id);		
	}
	
	private function insertLoginLog($data){
	
		$data['ip'] = $this->input->ip_address();
		$this->db->set('login_time',date('Y-m-d H:i:s'));
		$this->db->set('ip',$data['ip']);
		$this->db->set('user_info','id='.$data['user_id'].';name='.$data['user_name'].';e1='.$data['unit_kerja_e1'].';e2='.$data['unit_kerja_e2']);
			
		$result = $this->db->insert('login_log');
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Inserting to : ".$errMess." (".$errNo.")"); 
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function logout() {
		try {
			$this->session->sess_destroy();
			return true;
		}catch(Exception $err) {
			return false;
		}
	}
}
?>