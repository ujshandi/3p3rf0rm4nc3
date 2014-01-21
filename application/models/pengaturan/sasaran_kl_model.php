<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Sasaran_kl_model extends CI_Model
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
	public function easyGrid($filtahun=null,$filkey=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun,$filkey);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_sasaran_kl';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tahun",$filtahun);
			}
			if($filkey != '' && $filkey != '-1' && $filkey != null) {
				$this->db->like("deskripsi",$filkey);
			}
			//$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("*",false);
			$this->db->from('tbl_sasaran_kl');
			$this->db->order_by('tbl_sasaran_kl.tahun ASC, tbl_sasaran_kl.kode_sasaran_kl ASC');
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
			//utk kepentingan export excel ==========================
				unset($row->kode_kl);
			//============================================================
				
			//utk kepentingan export pdf===================
				$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_kl'],$response->rows[$i]['deskripsi']);
			//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['deskripsi']='';
				$response->lastNo = 0;				
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Tahun","Kode","Deskripsi");		
			//var_dump($query->result());die;
			to_excel($query,"SasaranKementerian",$colHeaders);
		}
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($filtahun=null,$filkey=null){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tahun",$filtahun);
		}
		if($filkey != '' && $filkey != '-1' && $filkey != null) {
			$this->db->like("deskripsi",$filkey);
		}
		$query=$this->db->from('tbl_sasaran_kl');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null,$tahun=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_sasaran_kl',$kode); //buat validasi
		if ($tahun!=null)//utk update
			$this->db->where('tahun',$tahun); //buat validasi
			
		$this->db->select('*');
		$this->db->from('tbl_sasaran_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function existInRKT($tahun, $kode_sasaran_kl){
		$this->db->flush_cache();
		
		$this->db->select('*');
		$this->db->from('tbl_rkt_kl');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_sasaran_kl', $kode_sasaran_kl);
		
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);	
		$this->db->set('log_insert',$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));		
		
		$result = $this->db->insert('tbl_sasaran_kl');
		
		# insert to log
		$this->db->flush_cache();
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);	
		$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_sasaran_kl_log');
		
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
	public function UpdateOnDb($data,$kode,$tahun) {
		
		$this->db->where('kode_sasaran_kl',$kode);
		$this->db->where('tahun',$tahun);

		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('log_update',$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_sasaran_kl');
		
		# insert to log
		$this->db->flush_cache();
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('kode_sasaran_kl',$kode);
		$this->db->set('log','UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_sasaran_kl_log');
		
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
	public function DeleteOnDb($tahun, $kode_sasaran_kl){
		$this->db->flush_cache();
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_sasaran_kl', $kode_sasaran_kl);
		$result = $this->db->delete('tbl_sasaran_kl'); 
		
		# insert to log
		// $this->db->flush_cache();
		// $this->db->set('kode_sasaran_kl',$id);
		// $this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		// $result = $this->db->insert('tbl_sasaran_kl_log');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Update to : ".$errMess." (".$errNo.")"); 
		//return
		
		if($result){
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function copy($data,& $error) {
		//query insert data	
		$result = false;		
		
		try {
			$sql = "insert into tbl_sasaran_kl(tahun, kode_kl, kode_sasaran_kl,deskripsi,  
	log_insert) select ".$data['tahun_tujuan'].", kode_kl, kode_sasaran_kl, deskripsi, '".$this->session->userdata('user_id').';'.date('Y-m-d H:i:s')."'"
			." from tbl_sasaran_kl "
			." where tahun = ".$data['tahun']
			." and kode_kl = '".$data['kode_kl']."'";
		//
			//var_dump($sql);
			$result = $this->db->query($sql);
			
		}
		catch(Exception $e){
			$errNo   = $this->db->_error_number();
			$errMess = $e->getMessage();//$this->db->_error_message();
			$error = $errMess;
			log_message("error", "Problem Inserting to : ".$errMess." (".$errNo.")"); 
		}
		
		//var_dump();die;
		//$result = $this->db->insert('tbl_sasaran_eselon1');
		
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function getListSasaranKL($objectId="", $data="",$required=true){
		//chan 12.08.12 tambah parameter $required coz ada inputan yg boleh tanpa field ini
		$this->db->flush_cache();
		$this->db->select('kode_sasaran_kl,deskripsi');
		$this->db->from('tbl_sasaran_kl');
		$this->db->order_by('kode_sasaran_kl');
		$tahun = "-1";
		if ($data!=""){
			$tahun = isset($data['tahun'])?$data['tahun']:'-1';
		}
			$this->db->where('tahun',$tahun);
		$que = $this->db->get();
		
		/*
		$out = '<select name="kode_sasaran_kl" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_kl.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		*/
		
		//chan 
		if ($data!=""){
			$id = isset($data['id'])?$data['id']:'0';
			$deskripsi = isset($data['deskripsi'])?$data['deskripsi']:'-- Pilih --';
		} else {
			$id = '0';
			$deskripsi = '-- Pilih --';
		}
		
		$out = '<div id="tcContainer"><input id="kode_sasaran_kl'.$objectId.'" name="kode_sasaran_kl" type="hidden" class="h_code" value="'.$id.'">';
		$out .= '<textarea id="txtkode_sasaran_kl'.$objectId.'" name="txtkode_sasaran_kl'.$objectId.'" class="textdown" required="'.$required.'" readonly>'.$deskripsi.'</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0" onclick="setSasaran'.$objectId.'(\'\')">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran'.$objectId.'(\''.$r->kode_sasaran_kl.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Kementerian ini belum tersedia.";
		}
		echo $out;
	}
	
	public function getDeskripsiSasaranKL($kode_sasaran_kl){
		$this->db->flush_cache();
		$this->db->select('deskripsi');
		$this->db->from('tbl_sasaran_kl');
		$this->db->where('kode_sasaran_kl', $kode_sasaran_kl);
		
		$result = $this->db->get();
		
		if(isset($result->row()->deskripsi)){
			return $result->row()->deskripsi;
		}else{
			return '';
		}
	}

	public function importData($data){
		//query insert data
		$this->db->flush_cache();
		
		
		try {
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('kode_kl',			$data['kode_kl']);
			$this->db->set('kode_sasaran_kl',	$data['kode_sasaran_kl']);
			$this->db->set('deskripsi',			$data['deskripsi']);		
			
			$result = $this->db->insert('tbl_sasaran_kl');
			//var_dump($result);die;
			if (!$result){
				throw new Exception("Import Data Gagal");
			}
		}
		catch(Exception $e){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			$error = $errMess;
			//var_dump($errMess);die;
			log_message("error", "Problem import Inserting to : ".$errMess." (".$errNo.")"); 
		}
		
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	
	public function getListFilterTahun($objectId,$withSemua=true){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_sasaran_kl');
		
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
		if ($withSemua)
			$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
}
?>
