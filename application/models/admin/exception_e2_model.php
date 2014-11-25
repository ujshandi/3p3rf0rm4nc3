<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Exception_e2_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
       parent::__construct();	
    }
	
	//khusus grid
	public function easyGrid($file1=null,$file2=null,$filapptype=null,$fillevel=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
			
		$count = $this->GetRecordCount($file1,$file2,$filapptype,$fillevel);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nama_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			
			/* if (($fillevel==null)||($fillevel=="-1"))
			//$fillevel = $this->session->userdata('level');
				$this->db->where("l.level <=",$this->session->userdata('level'));
			else	
				$this->db->where("l.level",$fillevel); */
				
			
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				
				$this->db->where("u.kode_e1",$file1);
			}	
			
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("u.kode_e2",$file2);
			}	
			
			/* if($filapptype != '' && $filapptype != '-1' && $filapptype != null) {
				$this->db->where("g.app_type",$filapptype);
			}	 */
			
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("u.*,g.nama_e1,l.nama_e2",false);
			
			$this->db->from('tbl_exception_iku_eselon1 u left join tbl_eselon1 g on u.kode_e1 = g.kode_e1 left join tbl_eselon2 l on u.kode_e2 = l.kode_e2',false);
			//var_dump($file1);
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				
				$response->rows[$i]['unit_kerja_E1']=$row->kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['unit_kerja_E2']=$row->kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['deskripsi']=($row->kode_e2==""?$row->nama_e1:$row->nama_e2);
				$response->rows[$i]['prefix']=$row->prefix;
				$response->rows[$i]['prefix_iku']=$row->prefix_iku;
				

				$i++;
			} 
			
			$query->free_result();
		}else {
				
				$response->rows[$count]['unit_kerja_E1']='';
				$response->rows[$count]['nama_e1']='';				
				$response->rows[$count]['unit_kerja_E2']='';
				$response->rows[$count]['nama_e2']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['prefix']='';
				$response->rows[$count]['prefix_iku']='';
		}
		
		return json_encode($response);
	
	}	
	public function isExist($kode_e1,$kode_e2)
	{
		$this->db->where('kode_e1',$kode_e1); //buat validasi
		$this->db->where('kode_e2',$kode_e2); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_exception_iku_eselon1');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function isExistPrefix($prefix,$prefix_old)
	{
		$this->db->where('prefix',$prefix); //buat validasi
		if ($prefix_old!="")
			$this->db->where('prefix !=',$prefix_old); //buat validasi
		
		
		$this->db->select('*');
		$this->db->from('tbl_exception_iku_eselon1');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function saveToDb($data,& $error){
		if (!$this->isExist($data['kode_e1'],$data['kode_e2']))
			return $this->InsertOnDb($data,$error);
		else
			return $this->UpdateOnDb($data,$error);
				
	}
	
	public function InsertOnDb($data,& $error) {
		//query insert data				
		$this->db->set('kode_e1',$data['kode_e1']);		
		$this->db->set('kode_e2',$data['kode_e2']);		
		$this->db->set('prefix',$data['prefix']);		
		$this->db->set('prefix_iku',$data['prefix_iku']);				
		$result = $this->db->insert('tbl_exception_iku_eselon1');
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
	public function UpdateOnDb($data, & $error) {
		
		$this->db->where('kode_e1',$data['kode_e1']);		
		$this->db->where('kode_e2',$data['kode_e2']);		
		$this->db->set('prefix',$data['prefix']);		
		$this->db->set('prefix_iku',$data['prefix_iku']);						
		$result=$this->db->update('tbl_exception_iku_eselon1');		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
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
		$this->db->where('user_id',$id);
		$result = $this->db->delete('tbl_exception_iku_eselon1');

		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function SelectInDb($kode_e1,$kode_e2){

		$this->db->where('kode_e1',$kode_e1); //buat edit
		$this->db->where('kode_e2',$kode_e2); //buat edit
		$query = $this->db->get('tbl_exception_iku_eselon1');
		$rs = $query->row_array();
		$query->free_result();		
		return $rs;
	}
	
	
	
	//jumlah data record
	public function GetRecordCount($file1=null,$file2=null,$filapptype=null,$fillevel=null){
		
		/* if (($fillevel==null)||($fillevel=="-1"))
			//$fillevel = $this->session->userdata('level');
			$this->db->where("l.level <=",$this->session->userdata('level'));
		else	
			$this->db->where("l.level",$fillevel);
		 */
			
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("u.kode_e1",$file1);
		}	
		
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("u.kode_e2",$file2);
		}	
		
		/* if($filapptype != '' && $filapptype != '-1' && $filapptype != null) {
			$this->db->where("g.app_type",$filapptype);
		}	 */
		
		$query=$this->db->from('tbl_exception_iku_eselon1 u left join tbl_eselon1 g on u.kode_e1 = g.kode_e1 left join tbl_eselon2 l on u.kode_e2 = l.kode_e2',false);
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
}

?>
