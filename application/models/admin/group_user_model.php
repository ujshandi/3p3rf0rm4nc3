<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Group_user_model extends CI_Model
{	var $group_id;
	var $group_name;
	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
	//	$this->CI =& get_instance();
		$this->reset();
    }
	
	public function reset(){
		$this->group_id = 0;
		$this->group_name = "";
	}
	
	public function GetList() {
		
		$pdfdata = array();
		$query = $this->db->get('tbl_group_user');

		
		foreach ($query->result() as $row)
		{
			$pdfdata[] = array($row->group_id,$row->group_name);
		}
		$query->free_result();	
		return $pdfdata;		
		
		
	}
	
	public function getListAppType($level=null){
		
		$this->db->flush_cache();
		$this->db->select('group_id,app_type');
		$this->db->from('tbl_group_user');
		if ($level!=null){
			$this->db->where("level <=",$level);
		}
		$this->db->order_by('group_id');
		
		$que = $this->db->get();
		
		$out = '<select name="group_id">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->group_id.'">'.$r->app_type.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function GetListCombo($withPilih=true,$groupLevel=-1) {		
		$pdfdata = array();
		if ($groupLevel!=-1)
			$this->db->where("level <=",$groupLevel);
		$query = $this->db->get('sys_user_group');	
		$comma=DEFINE_COMMA;//",";//separate by commas
		
		$group_id = ($withPilih?"-1".$comma:"");
		$group_name = ($withPilih?"Pilih".$comma:"");
		foreach ($query->result() as $row){	
			$group_id .= $row->group_id.$comma;
			$group_name .= $row->group_name.$comma;			
		}
		$group_id = substr($group_id,0,strlen($group_id)-2);
		$group_name = substr($group_name,0,strlen($group_name)-2);
		$arr_group_id=split($comma,$group_id);
		$arr_group=split($comma,$group_name);		
		$pdfdata=array_combine($arr_group_id,$arr_group);		
		$query->free_result();
		return $pdfdata;		
		
	}

	//khusus grid
	public function easyGrid(){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount();
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'group_name';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("*",false);
			$this->db->from('tbl_group_user');
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['group_id']=$row->group_id;
				$response->rows[$i]['group_name']=$row->group_name;
				$response->rows[$i]['app_type']=$row->app_type;

				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$count]['group_id']='';
				$response->rows[$count]['group_name']='';
				$response->rows[$count]['app_type']='';
		}
		
		return json_encode($response);
	
	}

	public function isExistKode($group_name)
	{
		$this->db->where('group_name',$group_name); //buat validasi
		
		$this->db->select('*');
		$this->db->from('sys_user_group');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
		public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('group_id',$data['group_id']);
		$this->db->set('group_name',$data['group_name']);
		$this->db->set('app_type',$data['app_type']);
		
		$result = $this->db->insert('tbl_group_user');
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
		$this->db->where('group_id',$kode);
		$this->db->set('group_name',$data['group_name']);
		$this->db->set('app_type',$data['app_type']);
		
		$result=$this->db->update('tbl_group_user');
		
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

	public function DeleteOnDb($id)
	{
		$this->db->where('group_id',$id);
		$result = $this->db->delete('tbl_group_user');

		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function SelectInDb($id){

		$this->db->where('group_id',$id); //buat edit
		$query = $this->db->get('tbl_group_user');

		return $query->row_array();
		$this->db->free_result();
	}
	
	
	//buat ambil pas edit
	public function GetFromDb($id = NULL,$group_name=NULL)
	{
		$this->db->select('group_id,group_name,level');
		$this->db->from('tbl_group_user');

		//cek id
		if($id != NULL)
			$this->db->where('group_id',$id); //buat edit
		else if($group_name != NULL)
			$this->db->where('group_name',$group_name); //buat validasi
		if ($id != NULL || $group_name != NULL) {
			$query = $this->db->get();
			if($query->num_rows() == 1) {
				return $query->row(); //jika cocok
			}else {
				return FALSE; //tidak ditemukan
			}
		}
		
	}

	//jumlah data record
		public function GetRecordCount(){
		$query=$this->db->from('tbl_group_user');
		return $this->db->count_all_results();
		$this->db->free_result();
	}

	public function all(){
		$this->db->select('group_id,group_name,level');
		$this->db->from('sys_user_group');
		return $this->db->get();
		$this->db->free_result();
	}

}

//b_express/application/model/bengkel/jenis_oli_model.php
?>
