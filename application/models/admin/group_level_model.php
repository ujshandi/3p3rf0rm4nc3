<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Group_level_model extends CI_Model
{	var $level_id;
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
		
	}
	
	public function GetList() {
		
		$pdfdata = array();
		$query = $this->db->get('tbl_group_level');

		
		foreach ($query->result() as $row)
		{
			$pdfdata[] = array($row->level_id,$row->group_name);
		}
		$query->free_result();	
		return $pdfdata;		
		
		
	}
	
	public function getListLevel($level=null,$withoutSuperAdmin=null){
		
		$this->db->flush_cache();
		$this->db->select('level_id,level_name');
		$this->db->from('tbl_group_level');
		if ($level!=null){
			$this->db->where("level <=",$level);
		}
		if ($withoutSuperAdmin!=null)
			$this->db->where("lower(level_name) <> 'superadmin'");
		$this->db->order_by('level_id');
		
		$que = $this->db->get();
		
		$out = '<select name="level_id">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->level_id.'">'.$r->level_name.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListLevelFilter($objectId,$level=null,$withoutSuperAdmin=null,$withAll=TRUE,$idAsKey=false){
		
		$this->db->flush_cache();
		$this->db->select('level_id,level,level_name');
		$this->db->from('tbl_group_level');
		if ($level!=null){
			$this->db->where("level <=",$level);
		}
		if ($withoutSuperAdmin!=null)
			$this->db->where("lower(level_name) <> 'superadmin'");
		$this->db->order_by('level_id');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_level_id" id="filter_level_id'.$objectId.'">';
		if ($withAll)
			$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			if ($idAsKey)
				$out .= '<option value="'.$r->level_id.'">'.$r->level_name.'</option>';
			else
				$out .= '<option value="'.$r->level.'">'.$r->level_name.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function GetListCombo($withPilih=true,$groupLevel=-1) {		
		$pdfdata = array();
		if ($groupLevel!=-1)
			$this->db->where("level <=",$groupLevel);
		$query = $this->db->get('tbl_group_level');	
		$comma=DEFINE_COMMA;//",";//separate by commas
		
		$level_id = ($withPilih?"-1".$comma:"");
		$group_name = ($withPilih?"Pilih".$comma:"");
		foreach ($query->result() as $row){	
			$level_id .= $row->level_id.$comma;
			$group_name .= $row->group_name.$comma;			
		}
		$level_id = substr($level_id,0,strlen($level_id)-2);
		$group_name = substr($group_name,0,strlen($group_name)-2);
		$arr_level_id=split($comma,$level_id);
		$arr_group=split($comma,$group_name);		
		$pdfdata=array_combine($arr_level_id,$arr_group);		
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
			$this->db->from('tbl_group_level');
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['level_id']=$row->level_id;
				$response->rows[$i]['group_name']=$row->group_name;
				$response->rows[$i]['level_name']=$row->level_name;

				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$count]['level_id']='';
				$response->rows[$count]['group_name']='';
				$response->rows[$count]['level_name']='';
		}
		
		return json_encode($response);
	
	}

	public function isExistKode($group_name)
	{
		$this->db->where('group_name',$group_name); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_group_level');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
		public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('level_id',$data['level_id']);
		$this->db->set('group_name',$data['group_name']);
		$this->db->set('level_name',$data['level_name']);
		
		$result = $this->db->insert('tbl_group_level');
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
		$this->db->where('level_id',$kode);
		$this->db->set('group_name',$data['group_name']);
		$this->db->set('level_name',$data['level_name']);
		
		$result=$this->db->update('tbl_group_level');
		
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
		$this->db->where('level_id',$id);
		$result = $this->db->delete('tbl_group_level');

		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function SelectInDb($id){

		$this->db->where('level_id',$id); //buat edit
		$query = $this->db->get('tbl_group_level');

		return $query->row_array();
		$this->db->free_result();
	}
	
	
	//buat ambil pas edit
	public function GetFromDb($id = NULL,$group_name=NULL)
	{
		$this->db->select('level_id,group_name,level');
		$this->db->from('tbl_group_level');

		//cek id
		if($id != NULL)
			$this->db->where('level_id',$id); //buat edit
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
		$query=$this->db->from('tbl_group_level');
		return $this->db->count_all_results();
		$this->db->free_result();
	}

	public function all(){
		$this->db->select('level_id,group_name,level');
		$this->db->from('tbl_group_level');
		return $this->db->get();
		$this->db->free_result();
	}

}

//b_express/application/model/bengkel/jenis_oli_model.php
?>
