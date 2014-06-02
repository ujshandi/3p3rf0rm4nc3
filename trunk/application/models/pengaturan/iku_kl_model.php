<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Iku_kl_model extends CI_Model
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
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_kl';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			/* if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_eselon1.kode_e1",$file1);
			} */
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_iku_kl.tahun",$filtahun);
			}
			if($filkey != '' && $filkey != '-1' && $filkey != null) {
				$this->db->like("deskripsi",$filkey);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("tbl_iku_kl.tahun, tbl_iku_kl.kode_kl, tbl_iku_kl.kode_iku_kl, tbl_iku_kl.deskripsi, tbl_iku_kl.satuan, tbl_iku_kl.kode_sasaran_kl,tbl_sasaran_kl.deskripsi as deskripsi_sasaran_kl",false);
			$this->db->from('tbl_iku_kl');
			//$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_iku_kl.kode_e1','left' );
			$this->db->join('tbl_sasaran_kl', 'tbl_sasaran_kl.kode_sasaran_kl = tbl_iku_kl.kode_sasaran_kl and tbl_iku_kl.tahun=tbl_sasaran_kl.tahun','left' );
			//chan 
			if ($purpose==2)  //buat pdf
				$this->db->order_by("tbl_iku_kl.tahun,tbl_iku_kl.kode_iku_kl ASC");
			else
				$this->db->order_by("tbl_iku_kl.kode_kl ASC,tbl_iku_kl.kode_iku_kl ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['satuan']=$row->satuan;
				//$response->rows[$i]['kode_e1']=$row->kode_e1;
				//$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['deskripsi_sasaran_kl']=$row->deskripsi_sasaran_kl;
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				unset($row->kode_kl);
				//unset($row->nama_e1);
				unset($row->kode_sasaran_kl);
				unset($row->deskripsi_sasaran_kl);
				//============================================================
				
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null) 
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_iku_kl'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_iku_kl'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
					
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['kode_iku_kl']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['satuan']='';
				//$response->rows[$count]['kode_e1']='';
				//$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['tahun']='';
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
			$colHeaders = array("Tahun","Kode IKU","Deskripsi IKU","Satuan");		
			//var_dump($query->result());die;
			to_excel($query,"IKUKementerian",$colHeaders);
		}
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($file1=null,$filtahun=null,$filkey=null){
		/* if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("tbl_eselon1.kode_e1",$file1);
		} */
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_iku_kl.tahun",$filtahun);
			}
		if($filkey != '' && $filkey != '-1' && $filkey != null) {
			$this->db->like("deskripsi",$filkey);
		}
		$this->db->select("tbl_iku_kl.tahun, tbl_iku_kl.kode_kl, tbl_iku_kl.kode_iku_kl, tbl_iku_kl.deskripsi, tbl_iku_kl.satuan",false);
		$this->db->from('tbl_iku_kl');
		$this->db->join('tbl_sasaran_kl', 'tbl_sasaran_kl.kode_sasaran_kl = tbl_iku_kl.kode_sasaran_kl and tbl_iku_kl.tahun=tbl_sasaran_kl.tahun','left' );
		//$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_iku_kl.kode_e1','left' );
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null,$tahun=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_iku_kl',$kode); //buat validasi
		if ($tahun!=null)//utk update
			$this->db->where('tahun',$tahun); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_iku_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function existInRKT($tahun, $kode_iku_kl){
		$this->db->flush_cache();
		
		$this->db->select('*');
		$this->db->from('tbl_rkt_kl');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_iku_kl', $kode_iku_kl);
		
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('kode_iku_kl',$data['kode_iku_kl']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		//$this->db->set('kode_e1',$data['kode_e1']);
		//$this->db->set('kode_e1',(($data['kode_e1']=="")||($data['kode_e1']==null)||($data['kode_e1']=="-1")?null:$data['kode_e1']));
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_iku_kl');
		
		# insert to log
		$this->db->flush_cache();
		$this->db->set('kode_iku_kl',$data['kode_iku_kl']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		//$this->db->set('kode_e1',$data['kode_e1']);
		//$this->db->set('kode_e1',(($data['kode_e1']=="")||($data['kode_e1']==null)||($data['kode_e1']=="-1")?null:$data['kode_e1']));
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
		$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_iku_kl_log');
		
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
	public function UpdateOnDb($data, $kode,$tahun) {
		
		$this->db->where('kode_iku_kl',$kode);
		$this->db->where('tahun',$tahun);
		
		$this->db->set('kode_iku_kl',$data['kode_iku_kl']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
//		$this->db->set('kode_e1',$data['kode_e1']);
//$this->db->set('kode_e1',(($data['kode_e1']=="")||($data['kode_e1']==null)||($data['kode_e1']=="-1")?null:$data['kode_e1']));
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_iku_kl');
		
		# insert to log
		$this->db->flush_cache();
		$this->db->set('kode_iku_kl',$kode);
		$this->db->set('tahun',$tahun);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
		//$this->db->set('kode_e1',$data['kode_e1']);
	//	$this->db->set('kode_e1',(($data['kode_e1']=="")||($data['kode_e1']==null)||($data['kode_e1']=="-1")?null:$data['kode_e1']));
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_iku_kl_log');
		
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
	public function DeleteOnDb($tahun, $kode_iku_kl){
		$this->db->flush_cache();
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_iku_kl', $kode_iku_kl);
		$result = $this->db->delete('tbl_iku_kl');
		
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
			$sql = "insert into tbl_iku_kl(tahun,kode_kl,  kode_iku_kl, deskripsi, satuan,kode_sasaran_kl, log_insert) select ".$data['tahun_tujuan'].", kode_kl,  kode_iku_kl, deskripsi, satuan,kode_sasaran_kl,  '".$this->session->userdata('user_id').';'.date('Y-m-d H:i:s')."'"
			." from tbl_iku_kl"
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
	
	public function getListTahun($objectId,$withAll=true){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_iku_kl');
		
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
		if ($withAll)
			$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListIKU_KL($objectId="", $data="",$required=true){
		
		$this->db->flush_cache();
		$this->db->select('kode_iku_kl, deskripsi');
		$this->db->from('tbl_iku_kl');
		$tahun = "-1";
		if ($data!=""){
			$tahun = isset($data['tahun'])?$data['tahun']:'-1';
		}
		$this->db->where('tahun',$tahun);
		$this->db->order_by('kode_iku_kl');
		
		$que = $this->db->get();
		
		/*
		$out = '<select name="kode_iku_kl'.$objectId.'">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_iku_kl.'">'.$r->deskripsi.'</option>';
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
		
		$out = '<div id="tcContainer"><input id="kode_iku_kl'.$objectId.'" name="kode_iku_kl" type="hidden" class="h_code" value="0">';
		$out .= '<textarea name="txtkode_iku_kl'.$objectId.'" id="txtkode_iku_kl'.$objectId.'" class="textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0" onclick="setIku'.$objectId.'(\'\')">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setIku'.$objectId.'(\''.$r->kode_iku_kl.'\')">['.$r->kode_iku_kl.'] '.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data IKU untuk tingkat Eselon 1 ini belum tersedia.";
		}
		
		echo $out;
	}
	
	public function getSatuan($id){
		$this->db->flush_cache();
		$this->db->select('satuan');
		$this->db->from('tbl_iku_kl');
		$this->db->where('kode_iku_kl', $id);
		$result = $this->db->get();
		
		if(isset($result->row()->satuan)){
			return $result->row()->satuan;
		}else{
			return '';
		}
		
	}
	
	public function importData($data){
		//query insert data
		$this->db->flush_cache();
		
		$this->db->set('kode_kl',			$data['kode_kl']);
		$this->db->set('tahun',				$data['tahun']);
		$this->db->set('kode_iku_kl',		$data['kode_iku_kl']);		
		$this->db->set('deskripsi',			$data['deskripsi']);		
		$this->db->set('satuan',			$data['satuan']);		
		//$this->db->set('kode_e1',			$data['kode_e1']);		
		
		$result = $this->db->insert('tbl_iku_kl');
		
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
