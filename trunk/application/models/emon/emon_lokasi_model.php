<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Emon_lokasi_model extends CI_Model
{	
	/**
	* constructor
	*/
	
	var $dbemon;
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
		$this->dbemon = $this->load->database('emon', TRUE);
    }
	
	public function getdata($params=null){
	
		$page = isset($_GET['iDisplayStart']) ? intval($_GET['iDisplayStart']) : 1;  
		$limit = isset($_GET['iDisplayLength']) ? intval($_GET['iDisplayLength']) : 10;  			
		$sortIdx = isset($_GET['iSortCol_0'])?intval($_GET['iSortCol_0']) :0;
		switch ($sortIdx){
			case '1' : $sort = 'nmlokasi';break;
			default : $sort = 'kdlokasi';
		}
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : 'asc';  
		
		
		$count = $this->GetRecordCount($params);
		$response = new stdClass();
		$response->total = $count;
		
		if ($count>0){			
			$this->dbemon->order_by($sort." ".$order );
			//$this->dbemon->limit($limit,$page);
			$this->dbemon->select("*",false);
			$this->dbemon->from('tbl_lokasi');
			$this->dbemon->where('status',1);
			$query = $this->dbemon->get();
			
			$i=0;
			$no=0;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kdlokasi']=$row->kdlokasi;
				$response->rows[$i]['nmlokasi']=$row->nmlokasi;
				$i++;
			} 
			
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kdlokasi']='';
				$response->rows[$count]['nmlokasi']='';				
		}
				
		return $response;
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($params){
		
		$query=$this->dbemon->from('tbl_lokasi');
		return $this->dbemon->count_all_results();
		$this->dbemon->free_result();
	}
	
	
}
?>
