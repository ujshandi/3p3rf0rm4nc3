<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Exception_kl_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
       parent::__construct();	
    }
	
	//khusus grid
	public function easyGrid($filtahun=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
			
		$count = $this->GetRecordCount($filtahun);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_iku_kl';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			
			
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				
				$this->db->where("u.tahun",$filtahun);
			}	
			
			
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("u.*,g.deskripsi",false);
			
			$this->db->from('tbl_exception_iku_kl u inner join tbl_iku_kl g on u.kode_iku_kl = g.kode_iku_kl and u.tahun=g.tahun',false);
			//var_dump($file1);
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$i++;
			} 
			
			$query->free_result();
		}else {
				
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_iku_kl']='';		
				$response->rows[$count]['deskripsi']='';
		}
		
		return json_encode($response);
	
	}	
	public function isExist($kode_iku_kl,$tahun)
	{
		$this->db->where('kode_iku_kl',$kode_iku_kl); //buat validasi
		$this->db->where('tahun',$tahun); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_exception_iku_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	

	public function saveToDb($data,& $error){
		if (!$this->isExist($data['kode_iku_kl'],$data['tahun']))
			return $this->InsertOnDb($data,$error);
		else
			return $this->UpdateOnDb($data,$error);
				
	}
	
	public function InsertOnDb($data,& $error) {
		//query insert data				
		$this->db->set('kode_iku_kl',$data['kode_iku_kl']);		
		$this->db->set('tahun',$data['tahun']);					
		$result = $this->db->insert('tbl_exception_iku_kl');
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
		
		$this->db->where('kode_iku_kl',$kode_iku_kl); 
		$this->db->where('tahun',$tahun); 	
		$this->db->set('kode_iku_kl',$data['kode_iku_kl']);		
		$this->db->set('tahun',$data['tahun']);						
		$result=$this->db->update('tbl_exception_iku_kl');		
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
	
	
	

	public function DeleteOnDb($kode_iku_kl,$tahun)
	{
		$this->db->where('kode_iku_kl',$kode_iku_kl); //buat validasi
		$this->db->where('tahun',$tahun); 
		$result = $this->db->delete('tbl_exception_iku_kl');

		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function SelectInDb($kode_iku_kl,$tahun){

		$this->db->where('kode_e1',$kode_e1); //buat edit
		$this->db->where('kode_e2',$kode_e2); //buat edit
		$query = $this->db->get('tbl_exception_iku_kl');
		$rs = $query->row_array();
		$query->free_result();		
		return $rs;
	}
	
	
	
	//jumlah data record
	public function GetRecordCount($filtahun=null){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				
				$this->db->where("u.tahun",$filtahun);
			}	
		
		$this->db->from('tbl_exception_iku_kl u inner join tbl_iku_kl g on u.kode_iku_kl = g.kode_iku_kl and u.tahun=g.tahun',false);
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
}

?>
