<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Emon_program_model extends CI_Model
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
	
	public function getdata($params){
	
		$page = isset($_GET['iDisplayStart']) ? intval($_GET['iDisplayStart']) : 1;  
		$limit = isset($_GET['iDisplayLength']) ? intval($_GET['iDisplayLength']) : 10;  			
		$sortIdx = isset($_GET['iSortCol_0'])?intval($_GET['iSortCol_0']) :0;
		switch ($sortIdx){
			case 1 : $sort = 'thang';break;
			default : $sort = 'nmprogram';
		}
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : 'asc';  
		
		
		$count = $this->GetRecordCount($params);
		$response = new stdClass();
		$response->total = $count;
		
		if ($count>0){
			if (isset($params)){
				if (isset($params['tahun'])) $this->dbemon->where('thang',$params['tahun']);
			}
			
			$this->dbemon->order_by($sort." ".$order );
			$this->dbemon->limit($limit,$page);
			$this->dbemon->select("*",false);
			$this->dbemon->from('tbl_d_program');
			$query = $this->dbemon->get();
			
			$i=0;
			$no=0;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['thang']=$row->thang;
				$response->rows[$i]['kdsatker']=$row->kdsatker;
				$response->rows[$i]['kddept']=$row->kddept;
				$response->rows[$i]['kdunit']=$row->kdunit;
				$response->rows[$i]['kdfungsi']=$row->kdfungsi;
				$response->rows[$i]['kdsfung']=$row->kdsfung;
				$response->rows[$i]['kdprogram']=$row->kdprogram;
				$response->rows[$i]['nmprogram']=$row->nmprogram;
				
				
				$i++;
			} 
			
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['thang']='';
				$response->rows[$count]['kdsatker']='';
				$response->rows[$count]['kddept']='';
				$response->rows[$count]['kdunit']='';
				$response->rows[$count]['kdfungsi']='';
				$response->rows[$count]['kdsfungs']='';
				$response->rows[$count]['kdprogram']='';
				$response->rows[$count]['nmprogram']='';
				
		}
		
		
		return $response;
	
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($params){
		if (isset($params)){
			if (isset($params['tahun'])) $this->dbemon->where('thang',$params['tahun']);
		}
		$query=$this->dbemon->from('tbl_d_program');
		return $this->dbemon->count_all_results();
		$this->dbemon->free_result();
	}
	
	
}
?>
