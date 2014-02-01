<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Sasaran_eselon2_model extends CI_Model
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
	public function easyGrid($file1=null, $file2=null,$filtahun=null,$filkey=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1, $file2, $filtahun, $filkey);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_sasaran_eselon2.tahun",$filtahun);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_eselon2.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("tbl_sasaran_eselon2.kode_e2",$file2);
			}
			if($filkey != '' && $filkey != '-1' && $filkey != null) {
				$this->db->like("tbl_sasaran_eselon2.deskripsi",$filkey);
			}
			
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("tbl_eselon2.kode_e1, tbl_sasaran_eselon2.kode_e2, tbl_eselon2.nama_e2, tbl_sasaran_eselon2.tahun, tbl_sasaran_eselon2.kode_sasaran_e2, tbl_sasaran_eselon2.deskripsi as e2_deskripsi,tbl_sasaran_eselon2.kode_sasaran_e1, tbl_sasaran_eselon1.deskripsi as e1_deskripsi",false);
			$this->db->from('tbl_sasaran_eselon2');
			$this->db->join('tbl_eselon2', 'tbl_eselon2.kode_e2 = tbl_sasaran_eselon2.kode_e2');
			$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_sasaran_eselon2.kode_sasaran_e1 and tbl_sasaran_eselon1.tahun = tbl_sasaran_eselon2.tahun','left' );
			$this->db->order_by("tbl_sasaran_eselon2.kode_e2 ASC,tbl_sasaran_eselon2.kode_sasaran_e2 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_e1']=$row->kode_e1;		
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['deskripsi']=$row->e2_deskripsi;
				$response->rows[$i]['deskripsi_e1']=$this->getDeskripsiSasaran($row->kode_sasaran_e1);
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;		
				$response->rows[$i]['e1_deskripsi']=$row->e1_deskripsi;		
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					unset($row->kode_e1);
				if($file2 != '' && $file2 != '-1' && $file2 != null)
					unset($row->kode_e2);
					
					unset($row->nama_e2);
					unset($row->e1_deskripsi);
					
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					if($file2 != '' && $file2 != '-1' && $file2 != null)
						$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['kode_sasaran_e1']);
					else
						$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['kode_sasaran_e1']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['kode_sasaran_e1']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_sasaran_e2']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['kode_sasaran_e1']='';
				$response->rows[$count]['kode_e1']='';
				$response->lastNo = 0;
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Kode Eselon I Terkait","Kode Eselon 2","Tahun","Kode Sasaran","Deskripsi Sasaran","Kode Sasaran Eselon I");		
		//	var_dump($query->result());die;
			to_excel($query,"SasaranEselon2",$colHeaders);
		}
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($file1, $file2, $filtahun, $filkey){		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tbl_sasaran_eselon2.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_eselon2.kode_e1",$file1);
		}
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("tbl_sasaran_eselon2.kode_e2",$file2);
		}

		if($filkey != '' && $filkey != '-1' && $filkey != null) {
			$this->db->like("tbl_sasaran_eselon2.deskripsi",$filkey);
		}
		
		$this->db->select("tbl_eselon2.kode_e1, tbl_sasaran_eselon2.kode_e2, tbl_eselon2.nama_e2, tbl_sasaran_eselon2.kode_sasaran_e2, tbl_sasaran_eselon2.deskripsi as e2_deskripsi,tbl_sasaran_eselon2.kode_sasaran_e1, tbl_sasaran_eselon1.deskripsi as e1_deskripsi",false);
		$this->db->from('tbl_sasaran_eselon2');
		$this->db->join('tbl_eselon2', 'tbl_eselon2.kode_e2 = tbl_sasaran_eselon2.kode_e2');
		$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_sasaran_eselon2.kode_sasaran_e1 and tbl_sasaran_eselon1.tahun = tbl_sasaran_eselon2.tahun','left' );
		$this->db->order_by("tbl_sasaran_eselon2.kode_e2 ASC,tbl_sasaran_eselon2.kode_sasaran_e2 ASC");
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null,$tahun=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_sasaran_e2',$kode); //buat validasi
		if ($tahun!=null)//utk update
			$this->db->where('tahun',$tahun); //buat validasi
		$this->db->select('*');
		$this->db->from('tbl_sasaran_eselon2');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function existInRKT($tahun, $kode_sasaran_e2){
		$this->db->flush_cache();
		
		$this->db->select('*');
		$this->db->from('tbl_rkt_eselon2');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_sasaran_e2', $kode_sasaran_e2);
		
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
		$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
		$this->db->set('kode_sasaran_e1',(($data['kode_sasaran_e1']=="")||($data['kode_sasaran_e1']==null)||($data['kode_sasaran_e1']=="-1")?null:$data['kode_sasaran_e1']));
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		try {
			$result = $this->db->insert('tbl_sasaran_eselon2');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('kode_e2',			$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',	$data['kode_sasaran_e2']);
			$this->db->set('kode_sasaran_e1',	(($data['kode_sasaran_e1']=="")||($data['kode_sasaran_e1']==null)||($data['kode_sasaran_e1']=="-1")?null:$data['kode_sasaran_e1']));
			$this->db->set('deskripsi',			$data['deskripsi']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_sasaran_eselon2_log');
			
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
		
		$this->db->where('kode_sasaran_e2',$kode);
		$this->db->where('tahun',$tahun);
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
		$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('kode_sasaran_e1',(($data['kode_sasaran_e1']=="")||($data['kode_sasaran_e1']==null)||($data['kode_sasaran_e1']=="-1")?null:$data['kode_sasaran_e1']));
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_sasaran_eselon2');
		
		# insert to log
		$this->db->flush_cache();
		$this->db->set('tahun',				$data['tahun']);
		$this->db->set('kode_e2',			$data['kode_e2']);
		$this->db->set('kode_sasaran_e2',	$kode);
		$this->db->set('kode_sasaran_e1',	(($data['kode_sasaran_e1']=="")||($data['kode_sasaran_e1']==null)||($data['kode_sasaran_e1']=="-1")?null:$data['kode_sasaran_e1']));
		$this->db->set('deskripsi',			$data['deskripsi']);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_sasaran_eselon2_log');
		
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
	public function DeleteOnDb($tahun, $kode_sasaran_e2){
	
		$this->db->flush_cache();
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_sasaran_e2', $kode_sasaran_e2);
		$result = $this->db->delete('tbl_sasaran_eselon2'); 
		
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
	
	public function copy($data,& $error) {
		//query insert data	
		$result = false;		
		
		try {
			$sql = "insert into tbl_sasaran_eselon2(tahun, kode_e2, kode_sasaran_e2, deskripsi, kode_sasaran_e1, 
	log_insert) select ".$data['tahun_tujuan'].", kode_e2, kode_sasaran_e2, deskripsi, kode_sasaran_e1, '".$this->session->userdata('user_id').';'.date('Y-m-d H:i:s')."'"
			." from tbl_sasaran_eselon2 "
			." where tahun = ".$data['tahun']
			." and kode_e2 = '".$data['kode_e2']."'";
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
	
	public function getListSasaranE2($objectId="",$e2="-1",$data=""){
		
		$this->db->flush_cache();
		$this->db->select('kode_sasaran_e2, deskripsi');
		$this->db->from('tbl_sasaran_eselon2');
		$this->db->order_by('kode_sasaran_e2');
		$this->db->where('kode_e2',$e2);
		
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
		
		$out = '<div id="tcContainer"><input id="kode_sasaran_e2'.$objectId.'" name="kode_sasaran_e2" type="hidden" class="h_code" value="'.$kode.'">';
		$out .= '<textarea id="txtkode_sasaran_e2'.$objectId.'" name="txtkode_sasaran_e2'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>'.$deskripsi.'</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran'.$objectId.'(\''.$r->kode_sasaran_e2.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Eselon 2 untuk tingkat Eselon ini belum tersedia.";
		}
		
		/*
		$out = '<select name="kode_sasaran_e2" class="easyui-validatebox" required="true">';
		$out .= '<option value="0">-- Pilih Sasaran --</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_e2.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		*/
		
		echo $out;
	}
	
	public function getDeskripsiSasaran($kode_sasaran_e1){
		$this->db->flush_cache();
		$this->db->select('b.deskripsi');
		$this->db->from('tbl_sasaran_eselon2 a');
		$this->db->join('tbl_sasaran_eselon1 b', 'b.kode_sasaran_e1 = a.kode_sasaran_e1');
		$this->db->where('b.kode_sasaran_e1', $kode_sasaran_e1);
		
		$result = $this->db->get();
		
		if(isset($result->row()->deskripsi)){
			return $result->row()->deskripsi;
		}else{
			return '';
		}
	}

	public function getDeskripsiSasaranE2($kode_sasaran_e2, $tahun){
		$this->db->flush_cache();
		$this->db->select('deskripsi');
		$this->db->from('tbl_sasaran_eselon2');
		$this->db->where('kode_sasaran_e2', $kode_sasaran_e2);
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
		$this->db->set('kode_e2',			$data['kode_e2']);
		$this->db->set('kode_sasaran_e2',	$data['kode_sasaran_e2']);
		$this->db->set('deskripsi',			$data['deskripsi']);		
		//$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);		
		
		$result = $this->db->insert('tbl_sasaran_eselon2');
		
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
	
	public function getListFilterTahun($objectId,$withAll=true){
		$e2 = $this->session->userdata('unit_kerja_e2');
		if (($e2!="-1")&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
			//$value = $e1;
		}
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_sasaran_eselon2');
		
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
	
}
?>
