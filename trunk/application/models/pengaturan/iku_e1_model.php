<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Iku_e1_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
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
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("c.kode_e1",$file1);
			}
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			if($filkey != '' && $filkey != '-1' && $filkey != null) {
				$this->db->like("a.deskripsi",$filkey);
			}
			$this->db->select("a.tahun,a.kode_e1, a.kode_iku_e1, a.deskripsi, a.satuan, a.kode_iku_kl, b.deskripsi as deskripsi_ikukl, c.nama_e1, b.deskripsi AS kl_deskripsi,a.kode_sasaran_e1,s.deskripsi as deskripsi_sasaran_e1",false);
			$this->db->from('tbl_iku_eselon1 a left join tbl_iku_kl b on a.tahun=b.tahun and a.kode_iku_kl=b.kode_iku_kl',false);
			$this->db->join('tbl_eselon1 c', 'c.kode_e1 = a.kode_e1');
			$this->db->join('tbl_sasaran_eselon1 s', 's.kode_sasaran_e1 = a.kode_sasaran_e1 and s.tahun=a.tahun','left' );			
	//bug		$this->db->join('tbl_iku_kl d', 'd.kode_iku_kl = a.kode_iku_kl','left' );			
			$this->db->order_by("a.tahun,a.kode_e1 ASC, a.kode_iku_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				//$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['kode_iku_e1']=$row->kode_iku_e1;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['deskripsi_ikukl']=$row->deskripsi_ikukl;
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['kl_deskripsi']=$row->kl_deskripsi;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;
				$response->rows[$i]['deskripsi_sasaran_e1']=$row->deskripsi_sasaran_e1;
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
			//	unset($row->kode_e2);
				unset($row->deskripsi_ikukl);
				unset($row->nama_e1);
				unset($row->kl_deskripsi);
				unset($row->deskripsi_sasaran_e1);
				unset($row->kode_sasaran_e1);
				//============================================================
				
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null) 
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_kl']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_kl']);
					
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['nama_e1']='';
				//$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['kode_iku_e1']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['kode_iku_kl']='';
				$response->rows[$count]['kl_deskripsi']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_sasaran_e1']='';
				$response->rows[$count]['deskripsi_sasaran_e1']='';
				$response->lastNo = 0;	
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Tahun","Kode Eselon I","Kode IKU","Deskripsi IKU","Satuan","Kode IKU Kementerian Terkait");		
			//var_dump($query->result());die;
			to_excel($query,"IKUEselon1",$colHeaders);
		}
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($file1=null,$filtahun=null,$filkey=null){
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("c.kode_e1",$file1);
		}
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
		if($filkey != '' && $filkey != '-1' && $filkey != null) {
			$this->db->like("a.deskripsi",$filkey);
		}
		//$this->db->select("a.tahun,a.kode_e1, a.kode_iku_e1, a.deskripsi, a.satuan, a.kode_iku_kl,b.deskripsi as deskripsi_ikukl, b.nama_e1, c.deskripsi AS kl_deskripsi",false);
		$this->db->from('tbl_iku_eselon1 a left join tbl_iku_kl b on a.tahun=b.tahun and a.kode_iku_kl=b.kode_iku_kl',false);
		$this->db->join('tbl_eselon1 c', 'c.kode_e1 = a.kode_e1');
		//bug $this->db->join('tbl_iku_kl d', 'd.kode_iku_kl = a.kode_iku_kl','left' );			
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null,$tahun=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_iku_e1',$kode); //buat validasi
		if ($tahun!=null)//utk update
			$this->db->where('tahun',$tahun); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_iku_eselon1');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function existInRKT($tahun, $kode_iku_e1){
		$this->db->flush_cache();
		
		$this->db->select('*');
		$this->db->from('tbl_rkt_eselon1');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_iku_e1', $kode_iku_e1);
		
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('kode_e1',$data['kode_e1']);
		//$this->db->set('kode_e2',$data['kode_e2']);
		//$this->db->set('kode_iku_kl',$data['kode_iku_kl']);
	
		
		$this->db->set('kode_iku_kl',(($data['kode_iku_kl']=="")||($data['kode_iku_kl']==null)||($data['kode_iku_kl']=="-1")||($data['kode_iku_kl']=="0")?null:$data['kode_iku_kl']));
		$this->db->set('kode_iku_e1',$data['kode_iku_e1']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		try {
			$result = $this->db->insert('tbl_iku_eselon1');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('kode_e1',$data['kode_e1']);
			//$this->db->set('kode_e2',$data['kode_e2']);
			//$this->db->set('kode_iku_kl',$data['kode_iku_kl']);
			$this->db->set('kode_iku_kl',(($data['kode_iku_kl']=="")||($data['kode_iku_kl']==null)||($data['kode_iku_kl']=="-1")?null:$data['kode_iku_kl']));
			$this->db->set('kode_iku_e1',$data['kode_iku_e1']);
			$this->db->set('deskripsi',$data['deskripsi']);
			$this->db->set('satuan',$data['satuan']);
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_iku_eselon1_log');
			
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
	public function UpdateOnDb($data, $kode,$tahun) {
		
		$this->db->where('kode_iku_e1',$kode);
		$this->db->where('tahun',$tahun);
		
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_e1',$data['kode_e1']);
		//$this->db->set('kode_e2',$data['kode_e2']);
	$this->db->set('kode_iku_e1',$data['kode_iku_e1']);
		//$this->db->set('kode_iku_kl',$data['kode_iku_kl']);
		$this->db->set('kode_iku_kl',(($data['kode_iku_kl']=="")||($data['kode_iku_kl']==null)||($data['kode_iku_kl']=="-1")||($data['kode_iku_kl']=="0")?null:$data['kode_iku_kl']));
		//$this->db->set('kode_iku_e1',$data['kode_iku_e1']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_iku_eselon1');
		
		
		# insert to log
		$this->db->flush_cache();
		$this->db->set('kode_iku_e1',$kode);
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_e1',$data['kode_e1']);
		//$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('kode_iku_kl',(($data['kode_iku_kl']=="")||($data['kode_iku_kl']==null)||($data['kode_iku_kl']=="-1")?null:$data['kode_iku_kl']));
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_iku_eselon1_log');
		
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
	public function DeleteOnDb($tahun, $kode_iku_e1){
		$this->db->flush_cache();
		$this->db->where('kode_iku_e1', $kode_iku_e1);
		$this->db->where('tahun', $tahun);
		$result = $this->db->delete('tbl_iku_eselon1'); 
		
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
	
	
	function copy($data,& $error) {
		//query insert data	
		$result = false;		
		
		try {
			$sql = "insert into tbl_iku_eselon1(tahun, kode_e1, kode_iku_e1, kode_iku_kl, deskripsi, satuan, kode_sasaran_e1, log_insert) select ".$data['tahun_tujuan'].", kode_e1, kode_iku_e1, kode_iku_kl, deskripsi, satuan, kode_sasaran_e1,  '".$this->session->userdata('user_id').';'.date('Y-m-d H:i:s')."'"
			." from tbl_iku_eselon1"
			." where tahun = ".$data['tahun']
			." and kode_e1 = '".$data['kode_e1']."'";
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
	
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_iku_eselon1');
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
	
	public function getSatuan($id){
		$this->db->flush_cache();
		$this->db->select('satuan');
		$this->db->from('tbl_iku_eselon1');
		$this->db->where('kode_iku_e1', $id);
		$query = $this->db->get();
		
		return $query->row()->satuan;
		
	}
	
	public function getListIKU_E1($objectId="", $e1="",$tahun = "-1"){
		
		$this->db->flush_cache();
		$this->db->select('kode_iku_e1,deskripsi');
		$this->db->from('tbl_iku_eselon1');
		$this->db->where('kode_e1', $e1);
		$this->db->order_by('kode_iku_e1');
		
		$this->db->where('tahun',$tahun);
		$que = $this->db->get();
		/*
		$out = '<select name="kode_iku_e1'.$objectId.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_iku_e1.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		*/
		
		$out = '<div id="tcContainer"><input id="kode_iku_e1'.$objectId.'" name="kode_iku_e1" type="hidden" class="h_code" value="0">';
		$out .= '<textarea name="txtkode_iku_e1'.$objectId.'" id="txtkode_iku_e1'.$objectId.'" class="textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0"  onclick="setIku'.$objectId.'(\'\')">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setIku'.$objectId.'(\''.$r->kode_iku_e1.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data IKU untuk tingkat Eselon I ini belum tersedia.";
		}
		
		echo $out;
	}
	
	public function getDeskripsiIKU($id){
		$this->db->flush_cache();
		$this->db->select('deskripsi');
		$this->db->from('tbl_iku_kl');
		$this->db->where('kode_iku_kl', $id);
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
		
		$this->db->set('kode_e1',			$data['kode_e1']);
		$this->db->set('tahun',				$data['tahun']);
		$this->db->set('kode_iku_e1',		$data['kode_iku_e1']);		
		$this->db->set('kode_iku_kl',		$data['kode_iku_kl']);		
		$this->db->set('deskripsi',			$data['deskripsi']);		
		$this->db->set('satuan',			$data['satuan']);		
		//$this->db->set('kode_e2',			$data['kode_e2']);		
		//var_dump($data['kode_e2']);die;
		$result = $this->db->insert('tbl_iku_eselon1');
		
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
	
}
?>
