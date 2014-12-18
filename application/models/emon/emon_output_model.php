<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Emon_output_model extends CI_Model
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
			case 1 : $sort = 'KDGIAT';
			default : $sort = 'NMOUTPUT';
		}
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : 'asc';  
		
		
		$count = $this->GetRecordCount($params);
		$response = new stdClass();
		$response->total = $count;
		
		if ($count>0){
			// if (isset($params)){
				// if (isset($params['tahun'])) $this->dbemon->where('KDGIAT',$params['tahun']);
			// }
			
			//$this->dbemon->order_by($sort." ".$order );
			$this->dbemon->order_by("KDGIAT,KDOUTPUT");
		//	$this->dbemon->limit($limit,$page);
			$this->dbemon->select("*",false);
			$this->dbemon->from('t_output');
			$query = $this->dbemon->get();
			
			$i=0;
			$no=0;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['KDGIAT']=$row->KDGIAT;
				$response->rows[$i]['KDOUTPUT']=$row->KDOUTPUT;
				$response->rows[$i]['SAT']=$row->SAT;
				$response->rows[$i]['NMOUTPUT']=$row->NMOUTPUT;
				
				
				$i++;
			} 
			
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['KDGIAT']='';
				$response->rows[$count]['KDOUTPUT']='';
				$response->rows[$count]['SAT']='';
				$response->rows[$count]['NMOUTPUT']='';
				
		}
		
		
		return $response;
	
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($params){
		// if (isset($params)){
			// if (isset($params['tahun'])) $this->dbemon->where('KDGIAT',$params['tahun']);
		// }
		$query=$this->dbemon->from('t_output');
		return $this->dbemon->count_all_results();
		$this->dbemon->free_result();
	}
	
	
}
?>
