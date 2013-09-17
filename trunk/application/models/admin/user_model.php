<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class User_model extends CI_Model
{	var $user_id;
	var $user_name;
	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
		$this->reset();
    }
	
	public function reset(){
		$this->user_id = 0;
		$this->user_name = "";
	}
	
	public function GetList() {
		
		$pdfdata = array();
		$query = $this->db->get('sys_user');

		
		foreach ($query->result() as $row)
		{
			$pdfdata[] = array($row->user_id,$row->user_name,$row->full_name,$row->group_id,$row->job_title,$row->disabled,$row->notes);
			
		}
		return $pdfdata;		
		$this->db->free_result();
		
	}
	
	public function getListGrup($app_type=null,$level=null,$withoutSuperAdmin=null){
		
		$this->db->flush_cache();
		$this->db->select('group_id,group_name');
		$this->db->from('tbl_group_user');
		//var_dump($app_type);
		if ($app_type!=null)
			$this->db->where('app_type',$app_type);
		if ($withoutSuperAdmin!=null)
			$this->db->where('app_type is not null');
		if ($level!=null){
			$this->db->where("level <=",$level);
		}	
		$this->db->order_by('group_id');
		
		$que = $this->db->get();
		
		$out = '<select name="group_id" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->group_id.'">'.$r->group_name.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListGrupFilter($objectId,$app_type=null,$level=null,$withoutSuperAdmin=null,$withAll=true,$idAsKey=false){
		
		$this->db->flush_cache();
		$this->db->select('app_type,group_id,group_name');
		$this->db->from('tbl_group_user');
		//var_dump($app_type);
		if ($app_type!=null)
			$this->db->where('app_type',$app_type);
		if ($withoutSuperAdmin!=null)
			$this->db->where('app_type is not null');
		if ($level!=null){
			$this->db->where("level <=",$level);
		}	
		$this->db->order_by('group_id');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_apptype" id="filter_apptype'.$objectId.'" required="true">';
		if ($withAll)
			$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			if ($idAsKey)
				$out .= '<option value="'.$r->group_id.'">'.$r->group_name.'</option>';
			else
				$out .= '<option value="'.$r->app_type.'">'.$r->group_name.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListUnitKerja($app_type=null,$e1=null,$label=''){
		
		$this->db->flush_cache();
		
		if (($app_type==null)||($app_type=="")){
			$out = '<select name="unit_kerja" width="300" style="width: 300px">';
			$out .= '<option value="">All</option>';
			$out .= '</select>';
		} else {
			if ($app_type=="KL"){
				$this->db->select('kode_satker as kode,nama_satker as nama');
				$this->db->from('tbl_satker');
				$this->db->order_by('kode_satker');
			}
			else if ($app_type=="E1"){
				$this->db->select('kode_e1 as kode,nama_e1 as nama');
				$this->db->from('tbl_eselon1');
				$e1 = $this->session->userdata('unit_kerja_e1');
				if (($e1!=-1)&&($e1!=null)){
					$this->db->where('kode_e1',$e1);
					$value = $e1;
				}
				//if (FILTER_E1_LOCKING) $this->db->where('kode_e1 in ('.FILTER_E1_LIST.')');
				$this->db->order_by('kode_e1');
			}
			else if ($app_type=="E2"){
				$this->db->select('kode_e2 as kode,nama_e2 as nama');
				$this->db->from('tbl_eselon2');
				$this->db->where('kode_e1',$e1);
				$this->db->order_by('kode_e2');
			}
			
			
			$que = $this->db->get();
			
			$out = $label.'<select name="unit_kerja_'.$app_type.'" id="unit_kerja_'.$app_type.'">';
			$out .= '<option selected="selected" value="-1">Semua</option>';
			foreach($que->result() as $r){
				$out .= '<option value="'.$r->kode.'">'.$r->nama.'</option>';
			}
			
			$out .= '</select>';
		  }
		
		echo $out;
	}
	
	
	//khusus grid
	public function easyGrid($file1=null,$file2=null,$filapptype=null,$fillevel=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
			
		$count = $this->GetRecordCount($file1,$file2,$filapptype,$fillevel);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'user_name';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			
			if (($fillevel==null)||($fillevel=="-1"))
			//$fillevel = $this->session->userdata('level');
				$this->db->where("l.level <=",$this->session->userdata('level'));
			else	
				$this->db->where("l.level",$fillevel);
				
			
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				
				$this->db->where("u.unit_kerja_e1",$file1);
			}	
			
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("u.unit_kerja_e2",$file2);
			}	
			
			if($filapptype != '' && $filapptype != '-1' && $filapptype != null) {
				$this->db->where("g.app_type",$filapptype);
			}	
			
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("u.*,g.*,l.*",false);
			
			$this->db->from('tbl_user u left join tbl_group_user g on u.group_id = g.group_id left join tbl_group_level l on u.level_id = l.level_id',false);
			//var_dump($file1);
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['user_id']=$row->user_id;
				$response->rows[$i]['user_name']=$row->user_name;
				$response->rows[$i]['full_name']=$row->full_name;
				$response->rows[$i]['passwd']=$row->passwd;
				$response->rows[$i]['group_id']=$row->group_id;
				$response->rows[$i]['level_id']=$row->level_id;
				$response->rows[$i]['group_name']=$row->group_name;
				$response->rows[$i]['level_name']=$row->level_name;
				$response->rows[$i]['unit_kerja_E1']= ($row->unit_kerja_e1=='-1'?'Semua':$row->unit_kerja_e1);
				$response->rows[$i]['unit_kerja_E2']=($row->unit_kerja_e2=='-1'?'Semua':$row->unit_kerja_e2);

				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$count]['user_id']='';
				$response->rows[$count]['user_name']='';
				$response->rows[$count]['full_name']='';
				$response->rows[$count]['passwd']='';
				$response->rows[$count]['group_id']='';
				$response->rows[$count]['group_name']='';
				$response->rows[$count]['level_id']='';
				$response->rows[$count]['level_name']='';
				$response->rows[$count]['unit_kerja_E1']='';
				$response->rows[$count]['unit_kerja_E2']='';
		}
		
		return json_encode($response);
	
	}	
	public function isExistKode($user_name)
	{
		$this->db->where('user_name',$user_name); //buat validasi
		
		$this->db->select('*');
		$this->db->from('sys_user');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('user_id',$data['user_id']);
		$this->db->set('user_name',$data['user_name']);
		$this->db->set('full_name',$data['full_name']);
		$this->db->set('passwd',md5($data['passwd']));
		$this->db->set('group_id',$data['group_id']);		
		$this->db->set('level_id',$data['level_id']);		
		$this->db->set('unit_kerja_E1',$data['unit_kerja_E1']);
		$this->db->set('unit_kerja_E2',$data['unit_kerja_E2']);
		$this->db->set('log_insert',$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_user');
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

	//update data
	public function UpdateOnDb($data, $kode) {
		$this->db->where('user_id',$kode);
		$this->db->set('user_name',$data['user_name']);
		$this->db->set('full_name',$data['full_name']);		
		//$this->db->set('passwd',md5($data['passwd']));
		$this->db->set('group_id',$data['group_id']);
		$this->db->set('level_id',$data['level_id']);
		$this->db->set('unit_kerja_E1',$data['unit_kerja_E1']);
		$this->db->set('unit_kerja_E2',$data['unit_kerja_E2']);
		$this->db->set('log_update',$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_user');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		//var_dump($errMess);die;
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	
	public function changePassword($id, $data) {
	
		$this->db->where('user_id',$id);				
		$this->db->set('passwd',md5($data['npass']));		
		$this->db->set('log_update',$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result=$this->db->update('tbl_user');

		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}


	public function DeleteOnDb($id)
	{
		$this->db->where('user_id',$id);
		$result = $this->db->delete('tbl_user');

		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function SelectInDb($id){

		$this->db->where('user_id',$id); //buat edit
		$query = $this->db->get('sys_user');
		$rs = $query->row_array();
		$query->free_result();		
		return $rs;
	}
	
	
	//buat ambil pas edit
	public function GetFromDb($id = NULL,$user_name=NULL)
	{
		$this->db->select('user_id,user_name,full_name,passwd,group_id,job_title,disabled,notes');
		$query=$this->db->from('tbl_user');

		//cek id
		if($id != NULL)
			$this->db->where('user_id',$id); //buat edit
		else if($user_name != NULL)
			$this->db->where('user_name',$user_name); //buat validasi
		if ($id != NULL || $user_name != NULL) {
			$query = $this->db->get();
			if($query->num_rows() == 1) {
				return $query->row(); //jika cocok
			}else {
				return FALSE; //tidak ditemukan
			}
		}
		//$this->db->free_result();
		$this->db->free_result();
	}

	public function getPassword($id){
		$this->db->flush_cache();
		$this->db->select('passwd');
		$this->db->from('tbl_user');
		$this->db->where('user_id', $id);
		$query = $this->db->get();
		
		return $query->row()->passwd;
		
	}
	
	//jumlah data record
	public function GetRecordCount($file1=null,$file2=null,$filapptype=null,$fillevel=null){
		
		if (($fillevel==null)||($fillevel=="-1"))
			//$fillevel = $this->session->userdata('level');
			$this->db->where("l.level <=",$this->session->userdata('level'));
		else	
			$this->db->where("l.level",$fillevel);
		
			
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("u.unit_kerja_e1",$file1);
		}	
		
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("u.unit_kerja_e2",$file2);
		}	
		
		if($filapptype != '' && $filapptype != '-1' && $filapptype != null) {
			$this->db->where("g.app_type",$filapptype);
		}	
		
		$query=$this->db->from('tbl_user u left join tbl_group_user g on g.group_id = u.group_id left join tbl_group_level l on u.level_id = l.level_id');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
}

	//public function all(){
		//$this->db->select('user_id,user_name,full_name,passwd,group_id,job_title,disabled,notes');
		//$this->db->from('user_id');
		//return $this->db->get();
		//$this->db->free_result();
	//}

//}

//b_express/application/model/bengkel/jenis_oli_model.php
?>
