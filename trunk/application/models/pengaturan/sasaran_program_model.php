<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Sasaran_program_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($file1=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tahun",$file1);
			}
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("*",false);
			$this->db->from('tbl_sasaran_program');
			//$this->db->join('tbl_kegiatan','tbl_kegiatan.kode_kegiatan = tbl_kegiatan_kl.kode_kegiatan');
			$this->db->order_by("tbl_sasaran_program.tahun DESC,tbl_sasaran_program.kode_e1 ASC,tbl_sasaran_program.kode_sasaran_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;
				$response->rows[$i]['kode_program']=$row->kode_program;	
				$response->rows[$i]['kode_kegiatan']=$row->kode_kegiatan;	

				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_sasaran_e1']='';
				$response->rows[$count]['kode_program']='';
				$response->rows[$count]['kode_kegiatan']='';
		}
		
		return json_encode($response);
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($file1){
		
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("kode_e1",$file1);
		}
		$query=$this->db->from('tbl_sasaran_program');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_e1',$kode); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_sasaran_program');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
		$this->db->set('kode_program',$data['kode_program']);
		$this->db->set('kode_kegiatan ',$data['kode_kegiatan']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_sasaran_program');
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
		
		$this->db->where('kode_e1',$kode);				
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
		$this->db->set('kode_program',$data['kode_program']);
		$this->db->set('kode_kegiatan ',$data['kode_kegiatan']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_sasaran_program');
		
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
	
	//hapus data
	public function DeleteOnDb($dokter_id) {
		$this->db->where('dokter_id',$dokter_id);
		$result = $this->db->delete('mst_dokter');
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
}
?>
