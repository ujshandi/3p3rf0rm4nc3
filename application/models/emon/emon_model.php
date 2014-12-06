<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Emon_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function getdata($params){
	
		$page = isset($_GET['iDisplayStart']) ? intval($_GET['iDisplayStart']) : 1;  
		$limit = isset($_GET['iDisplayLength']) ? intval($_GET['iDisplayLength']) : 10;  			
		$sortIdx = isset($_GET['iSortCol_0'])?intval($_GET['iSortCol_0']) :0;
		switch ($sortIdx){
			case 1 : $sort = 'tbl_eselon2.nama_e2';
			default : $sort = 'tbl_eselon2.kode_e2';
		}
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : 'asc';  
		
		
		$count = $this->GetRecordCount();
		$response = new stdClass();
		$response->total = $count;
		
		if ($count>0){
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$page);
			$this->db->select("*",false);
			$this->db->from('tbl_kl');
			$query = $this->db->get();
			
			$i=0;
			$no=0;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['nama_kl']=$row->nama_kl;
				$response->rows[$i]['singkatan']=$row->singkatan;
				$response->rows[$i]['nama_menteri']=$row->nama_menteri;
				
				
				$i++;
			} 
			
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['nama_kl']='';
				$response->rows[$count]['singkatan']='';
				$response->rows[$count]['nama_menteri']='';
				$response->lastNo = 0;	
		}
		
		
		return $response;
	
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($params){
		
		$query=$this->db->from('tbl_kl');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
}
?>
