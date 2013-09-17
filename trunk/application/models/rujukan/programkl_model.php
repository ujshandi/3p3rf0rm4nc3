<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Programkl_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function easyGrid($file1=null,$filtahun=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1,$filtahun);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_program_kl.kode_e1",$file1);
			}
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tahun",$filtahun);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("tbl_program_kl.*, tbl_eselon1.nama_e1",false);
			$this->db->from('tbl_program_kl');
			$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_program_kl.kode_e1');
			$this->db->order_by("tbl_program_kl.tahun DESC,tbl_program_kl.kode_e1 ASC,tbl_program_kl.kode_program ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				//$response->rows[$i]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$i]['id_program_kl']	=$row->id_program_kl;
				$response->rows[$i]['kode_e1']			=$row->kode_e1;
				$response->rows[$i]['nama_e1']			=$row->nama_e1;
				$response->rows[$i]['tahun']			=$row->tahun;
				$response->rows[$i]['kode_program']		=$row->kode_program;
				$response->rows[$i]['nama_program']		=$row->nama_program;
				$response->rows[$i]['total']			= number_format( $row->total, 0, ',', '.');

				//utk kepentingan export excel =============================
				unset($row->nama_e1);
				unset($row->id_program_kl);
				if($file1 != '' && $file1 != '-1' && $file1 != null){
					unset($row->kode_e1);
					//tambahkan header kolom
					$colHeaders = array("Tahun","Kode Program","Nama Program","Total");
				}else{
					$colHeaders = array("Tahun","Kode Program","Nama Program","Total","Kode Sub-sektor");
				}
				//==========================================================
					
				//utk kepentingan export pdf================================
				$subsektor="";
				if($file1 != '' && $file1 != '-1' && $file1 != null){
					$pdfdata[] = array($no,
									   $response->rows[$i]['tahun'],
									   $response->rows[$i]['kode_program'],
									   $response->rows[$i]['nama_program'],
									   $response->rows[$i]['total']);
				}
				else{
					$pdfdata[] = array($no,
									   $response->rows[$i]['tahun'],
									   $response->rows[$i]['kode_program'],
									   $response->rows[$i]['nama_program'],
									   $response->rows[$i]['total'],
									   $response->rows[$i]['kode_e1']);
				}
				//==========================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['id_program_kl']	="";
				$response->rows[$count]['kode_e1']			="";
				$response->rows[$count]['nama_e1']			="";
				$response->rows[$count]['tahun']			="";
				$response->rows[$count]['kode_program']		="";
				$response->rows[$count]['nama_program']		="";
				$response->rows[$count]['total']			="";
				
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel		
		//	var_dump($query->result());die;
			to_excel($query,"Program",$colHeaders);
		}
	}
	
	public function GetRecordCount($file1,$filtahun){
	
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("kode_e1",$file1);
		}
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tahun",$filtahun);
		}
				
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from('tbl_program_kl');
		//$query = $this->db->get();
			
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_program_kl a');
		$this->db->join('tbl_eselon1 b', 'b.kode_e1 = a.kode_e1');
		$this->db->where('a.id_program_kl', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB_programKL($data){
		//query insert data		
		$this->db->set('tahun', $data['tahun']);
		$this->db->set('kode_program',$data['kode_program']);
		$this->db->set('nama_program',$data['nama_program']);
		$this->db->set('total',$data['total']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_program_kl');
		
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
	
	public function UpdateOnDB_programKL($data){
		$this->db->set('tahun', $data['tahun']);
		$this->db->set('kode_program',$data['kode_program']);
		$this->db->set('nama_program',$data['nama_program']);
		$this->db->set('total',$data['total']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$this->db->where('id_program_kl', $data['id_program_kl']);
		
		$result = $this->db->update('tbl_program_kl');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Updating to : ".$errMess." (".$errNo.")"); 
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
		$this->db->where('id_program_kl', $id);
		$result = $this->db->delete('tbl_program_kl'); 
		
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
	
	public function getListProgramKL($objectId="", $data=""){
		
		$name = isset($data['name'])?$data['name']:'kode_program';
		$value = isset($data['value'])?$data['value']:'';
		
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_program_kl');
		$this->db->order_by('kode_program');
		
		if ($data!=""){
			$tahun = isset($data['tahun'])?$data['tahun']:'-1';
			$kode_e1 = isset($data['kode_e1'])?$data['kode_e1']:'-1';
			$this->db->where('kode_e1',$kode_e1);
			$this->db->where('tahun',$tahun);
		}
			
		
		$que = $this->db->get();
		
		$out = '<select name="'.$name.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			if($value == $r->kode_program){
				$out .= '<option value="'.$r->kode_program.'" selected="selected">'.$r->nama_program.'</option>';
			}else{
				$out .= '<option value="'.$r->kode_program.'">'.$r->nama_program.'</option>';
			}
		}
		
		$out .= '</select>';
		
		return $out;
	}
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_program_kl');
		
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
		$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		return $out;
	}

}
?>
