<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Emon_satker_model extends CI_Model
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
			case '1' : $sort = 'uraian_satker';break;
			default : $sort = 'kode_satker';
		}
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : 'asc';  
		$tableName = 'satker_'.$params['tahun'];
	//	var_dump($tableName);die;
		if (!$this->dbemon->table_exists($tableName)) {
			// $response = 'Tabel tidak ada';
			// return $response;
			$count = 0;
		 }
		//try{
		else {
			$count = $this->GetRecordCount($tableName,$params);
		}
		// }
		// catch  (Exception $e){
			//return $this->dbemon->_error_message(); ;
			// $count =0;
		// }
		$response = new stdClass();
		$response->total = $count;
		
		if ($count>0){			
			$this->dbemon->order_by($sort." ".$order );
			//$this->dbemon->limit($limit,$page);
			$this->dbemon->select("*",false);
			$this->dbemon->from($tableName);
			$this->dbemon->where('status_satker',1);
			$query = $this->dbemon->get();
			
			$i=0;
			$no=0;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_satker']=$row->kode_satker;
				$response->rows[$i]['uraian_satker']=$row->uraian_satker;
				$response->rows[$i]['unit_satker']=$row->unit_satker;
				$response->rows[$i]['lokasi_satker']=$row->lokasi_satker;
				$i++;
			} 
			
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_satker']='';
				$response->rows[$count]['uraian_satker']='';				
				$response->rows[$count]['unit_satker']='';				
				$response->rows[$count]['lokasi_satker']='';				
		}
				
		return $response;
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($tableName,$params){
		
		$query=$this->dbemon->from($tableName);
		$this->dbemon->where('status_satker',1);
		return $this->dbemon->count_all_results();
		$this->dbemon->free_result();
	}
	
	
}
?>
