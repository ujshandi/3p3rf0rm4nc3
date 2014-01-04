<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Kl_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount();
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'nama_kl';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("*",false);
			$this->db->from('tbl_kl');
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['nama_kl']=$row->nama_kl;
				$response->rows[$i]['singkatan']=$row->singkatan;
				$response->rows[$i]['nama_menteri']=$row->nama_menteri;
				
				//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['kode_kl'],$response->rows[$i]['nama_kl'],$response->rows[$i]['singkatan'],$response->rows[$i]['nama_menteri']);
			//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			//$query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['nama_kl']='';
				$response->rows[$count]['singkatan']='';
				$response->rows[$count]['nama_menteri']='';
				$response->lastNo = 0;	
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Kode","Nama Kementerian","Singkatan","Nama Menteri");		
			//var_dump($query->result());die;
			to_excel($query,"Kementerian",$colHeaders);
		}
		else if ($purpose==4) { //WEB SERVICE
			return $response;
		}
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount(){
		
		$query=$this->db->from('tbl_kl');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_kl',$kode); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function isSaveDelete($kode){	
		
		$this->db->where('kode_kl',$kode); //buat validasi		
		$this->db->select('*');
		$this->db->from('tbl_sasaran_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		$isSave = ($rs==0);
		if ($isSave){
			$this->db->flush_cache();
			$this->db->where('kode_kl',$kode); //buat validasi		
			$this->db->select('*');
			$this->db->from('tbl_iku_kl');
							
			$query = $this->db->get();
			$rs = $query->num_rows() ;		
			$query->free_result();
			$isSave = ($rs==0);
		}
		return $isSave;
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('nama_kl',$data['nama_kl']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_menteri',$data['nama_menteri']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_kl');
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
		$this->db->where('kode_kl',$kode);
		$this->db->set('nama_kl',$data['nama_kl']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_menteri',$data['nama_menteri']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_kl');
		
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
	public function DeleteOnDb($id){
		$this->db->flush_cache();
		$this->db->where('kode_kl', $id);
		$result = $this->db->delete('tbl_kl'); 
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Update to : ".$errMess." (".$errNo.")"); 
		//return
		
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function getListKL($objectId=""){
		
		$this->db->flush_cache();
		$this->db->select('kode_kl,nama_kl');
		$this->db->from('tbl_kl');
		$this->db->order_by('kode_kl');
		
		$que = $this->db->get();
		
		$out = '<select name="kode_kl" id="kode_kl'.$objectId.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_kl.'">'.$r->nama_kl.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
}
?>
