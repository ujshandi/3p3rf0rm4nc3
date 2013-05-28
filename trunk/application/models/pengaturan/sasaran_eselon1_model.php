<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Sasaran_eselon1_model extends CI_Model
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
	public function easyGrid($file1=null,$filtahun=null,$filkey=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1,$filtahun,$filkey);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.kode_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("b.kode_e1",$file1);
			}
			if($filkey != '' && $filkey != '-1' && $filkey != null) {
				$this->db->like("a.deskripsi",$filkey);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.tahun, a.kode_e1, b.nama_e1, a.kode_sasaran_e1, a.deskripsi, a.kode_sasaran_kl, c.deskripsi AS deskripsi_sasaran_kl", false);
			$this->db->from('tbl_sasaran_eselon1 a');
			$this->db->join('tbl_eselon1 b', 'b.kode_e1 = a.kode_e1');
			$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl','left' );
			$this->db->order_by("a.kode_e1 ASC, a.kode_sasaran_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;	
				$response->rows[$i]['deskripsi_sasaran_kl']=$row->deskripsi_sasaran_kl;	
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					unset($row->kode_e1);
					unset($row->nama_e1);
					unset($row->deskripsi_sasaran_kl);
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['kode_sasaran_kl']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['kode_sasaran_kl']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['kode_sasaran_e1']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['deskripsi_sasaran_kl']='';
				$response->lastNo = 0;
		}
	
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			if($file1 != '' && $file1 != '-1' && $file1 != null)
				$colHeaders = array("Tahun", "Kode Sasaran","Deskripsi Sasaran","Kode Sasaran Kementerian");
			else
				$colHeaders = array("Tahun", "Kode Eselon I","Kode Sasaran","Deskripsi Sasaran","Kode Sasaran Kementerian");		
		//	var_dump($query->result());die;
			to_excel($query,"SasaranEselon1",$colHeaders);
		}
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($file1,$filtahun,$filkey){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("a.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("b.kode_e1",$file1);
		}
		if($filkey != '' && $filkey != '-1' && $filkey != null) {
			$this->db->like("a.deskripsi",$filkey);
		}
		$this->db->from('tbl_sasaran_eselon1 a');
		$this->db->join('tbl_eselon1 b', 'b.kode_e1 = a.kode_e1');
		$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl','left' );
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_sasaran_e1',$kode); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_sasaran_eselon1');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function existInRKT($tahun, $kode_sasaran_e1){
		$this->db->flush_cache();
		
		$this->db->select('*');
		$this->db->from('tbl_rkt_eselon1');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$result = false;
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
		$this->db->set('kode_sasaran_kl',(($data['kode_sasaran_kl']=="")||($data['kode_sasaran_kl']==null)||($data['kode_sasaran_kl']=="-1")?null:$data['kode_sasaran_kl']));
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		try {
			$result = $this->db->insert('tbl_sasaran_eselon1');
			
			# insert to tbl log
			$this->db->flush_cache();
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('kode_e1',			$data['kode_e1']);
			$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);
			$this->db->set('kode_sasaran_kl',	(($data['kode_sasaran_kl']=="")||($data['kode_sasaran_kl']==null)||($data['kode_sasaran_kl']=="-1")?null:$data['kode_sasaran_kl']));
			$this->db->set('deskripsi',			$data['deskripsi']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_sasaran_eselon1_log');
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

	//update data
	public function UpdateOnDb($data, $kode) {
		
		$this->db->where('kode_sasaran_e1',$kode);		
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('kode_sasaran_kl',(($data['kode_sasaran_kl']=="")||($data['kode_sasaran_kl']==null)||($data['kode_sasaran_kl']=="-1")?null:$data['kode_sasaran_kl']));
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_sasaran_eselon1');
		
		# insert to tbl log
		$this->db->flush_cache();
		$this->db->set('kode_sasaran_e1',$kode);
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('kode_sasaran_kl',(($data['kode_sasaran_kl']=="")||($data['kode_sasaran_kl']==null)||($data['kode_sasaran_kl']=="-1")?null:$data['kode_sasaran_kl']));
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_sasaran_eselon1_log');
		
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
	public function DeleteOnDb($tahun, $kode_sasaran_e1){
		
		# insert to log
		// $this->db->flush_cache();
		// $this->db->select("*");
		// $this->db->from("tbl_pengukuran_eselon2");
		// $this->db->where('id_pengukuran_e2', $id);
		// $qt = $this->db->get();
		
		// $this->db->flush_cache();
		// $this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
		// $this->db->set('tahun',				$qt->row()->tahun);
		// $this->db->set('kode_e1',			$qt->row()->kode_e1);
		// $this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
		// $this->db->set('deskripsi',			$qt->row()->deskripsi);
		// $this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		// $result = $this->db->insert('tbl_sasaran_eselon1_log');
		
		
		$this->db->flush_cache();
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		$result = $this->db->delete('tbl_sasaran_eselon1'); 
		
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
	
	public function getListSasaranE1($objectId="",$e1="-1", $data=""){
		
		$this->db->flush_cache();
		$this->db->select('kode_sasaran_e1,deskripsi');
		$this->db->from('tbl_sasaran_eselon1');
		$this->db->order_by('kode_sasaran_e1');
		$this->db->where('kode_e1',$e1);
		$tahun = "-1";
		if ($data!=""){
			$tahun = isset($data['tahun'])?$data['tahun']:'-1';
		}
			$this->db->where('tahun',$tahun);
		$que = $this->db->get();
		
		//chan 
		if ($data!=""){
			$kode = (isset($data['kode']))||($data['kode']=='')?$data['kode']:'0';
			$deskripsi = (isset($data['deskripsi'])||($data['deskripsi']==''))?$data['deskripsi']:'-- Pilih --';
		}
		else {
			$kode = '0';
			$deskripsi = '-- Pilih --';
		}
		$out = '<div id="tcContainer"><input id="kode_sasaran_e1'.$objectId.'" name="kode_sasaran_e1" type="hidden" class="h_code" value="'.$kode.'">';
		$out .= '<textarea name="txtkode_sasaran_e1'.$objectId.'" id="txtkode_sasaran_e1'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>'.$deskripsi.'</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0"  onclick="setSasaran'.$objectId.'(\'\')">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran'.$objectId.'(\''.$r->kode_sasaran_e1.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Eselon 1 untuk tingkat Eselon ini belum tersedia.";
		}
		
		echo $out;
	}
	
	public function getDeskripsiSasaran($kode_sasaran_e1){
		$this->db->flush_cache();
		$this->db->select('b.deskripsi');
		$this->db->from('tbl_sasaran_eselon1 a');
		$this->db->join('tbl_sasaran_kl b', 'b.kode_sasaran_kl = a.kode_sasaran_kl');
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		$result = $this->db->get();
		
		if(isset($result->row()->deskripsi)){
			return $result->row()->deskripsi;
		}else{
			return '';
		}
	}
	
	public function getDeskripsiSasaranE1($kode_sasaran_e1, $tahun){
		$this->db->flush_cache();
		$this->db->select('deskripsi');
		$this->db->from('tbl_sasaran_eselon1');
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->where('tahun',$tahun);
		
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
		
		$this->db->set('tahun',				$data['tahun']);
		$this->db->set('kode_e1',			$data['kode_e1']);
		$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);
		$this->db->set('deskripsi',			$data['deskripsi']);		
//chan		$this->db->set('kode_sasaran_kl',	$data['kode_sasaran_kl']);		
		
		$result = $this->db->insert('tbl_sasaran_eselon1');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem import Inserting to : ".$errMess." (".$errNo.")"); 
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_sasaran_eselon1');
		$e1 = $this->session->userdata('unit_kerja_e1');
		if (($e1!="-1")&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			//$value = $e1;
		}
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
		$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
}
?>
