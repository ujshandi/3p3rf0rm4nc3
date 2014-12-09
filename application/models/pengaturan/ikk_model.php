<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Ikk_model extends CI_Model
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
	public function easyGrid($file1=null, $file2=null,$filtahun=null,$filkey=null, $purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1, $file2, $filtahun,$filkey);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_e2';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		if ($purpose==4){ //request oleh e-anev
			$page = isset($_GET['iDisplayStart']) ? intval($_GET['iDisplayStart']) : 1;  
			$limit = isset($_GET['iDisplayLength']) ? intval($_GET['iDisplayLength']) : 10;  			
			$sortIdx = isset($_GET['iSortCol_0'])?intval($_GET['iSortCol_0']) :0;
			switch ($sortIdx){
				case 1 : $sort = 'a.tahun';
				default : $sort = 'a.kode_ikk';
			}
			$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : 'asc';  
		}
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($file2 != '-1' && $file2 != null){
			//$this->db->where("tbl_iku_eselon1.kode_iku_e1",$file1);
				$this->db->where("a.kode_e2",$file2);
			}
			if (($file1 != '-1')&&($file1 != null)){
				$this->db->where("c.kode_e1",$file1);
			}
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			if($filkey != '' && $filkey != '-1' && $filkey != null) {
				$this->db->like("a.deskripsi",$filkey);
			}
			//$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			if($purpose==4){$this->db->limit($limit,$page);}
			$this->db->select("a.tahun,a.kode_e2, a.kode_ikk, a.deskripsi, a.satuan, a.kode_iku_e1, c.kode_e1, b.nama_e2, d.deskripsi AS e1_deskripsi,a.kode_sasaran_e2,e.deskripsi as deskripsi_sasaran_e2",false);
			$this->db->from('tbl_ikk a');
			$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
			$this->db->join('tbl_eselon1 c', 'c.kode_e1 = b.kode_e1');
			$this->db->join('tbl_iku_eselon1 d', 'd.kode_iku_e1 = a.kode_iku_e1 and a.tahun=d.tahun','left');
			$this->db->join('tbl_sasaran_eselon2 e', 'e.kode_sasaran_e2 = a.kode_sasaran_e2 and e.tahun=a.tahun','left');
			$this->db->order_by("a.kode_e2 ASC, a.kode_ikk ASC");
			//$this->db->select("a.kode_e2, a.kode_ikk, b.kode_iku_e1, a.deskripsi, a.satuan",false);
			//$this->db->from('tbl_ikk a');
			//$this->db->join('tbl_iku_eselon1 b', 'b.kode_iku_e1 = a.kode_iku_e1');
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['kode_ikk']=$row->kode_ikk;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['deskripsi_e1']=$this->getDeskripsiIKU($row->kode_iku_e1);
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['kode_iku_e1']=$row->kode_iku_e1;
				$response->rows[$i]['e1_deskripsi']=$row->e1_deskripsi;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['deskripsi_sasaran_e2']=$row->deskripsi_sasaran_e2;
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					//unset($row->kode_e1);
				if($file2 != '' && $file2 != '-1' && $file2 != null)
					unset($row->kode_e2);
					unset($row->nama_e2);
					unset($row->e1_deskripsi);
					unset($row->deskripsi_sasaran_e2);
					unset($row->kode_sasaran_e2);
					
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					if($file2 != '' && $file2 != '-1' && $file2 != null)
						$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_e1']);
						//$pdfdata[] = array($no,$response->rows[$i]['kode_ikk'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
					else
						$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_e1']);
						//$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['tahun'],$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan'],$response->rows[$i]['kode_iku_e1']);
					//$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_ikk'],$response->rows[$i]['kode_iku_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['satuan']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['kode_ikk']='';
				$response->rows[$count]['kode_iku_e1']='';
				$response->rows[$count]['deskripsi']='';
				$response->rows[$count]['deskripsi_e1']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_sasaran_e2']='';
				$response->rows[$count]['deskripsi_sasaran_e2']='';
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
				if($file2 != '' && $file2 != '-1' && $file2 != null)
					$colHeaders = array("Tahun","Kode IKK","Deskripsi","Satuan");
					//$colHeaders = array("Kode IKK","Kode IKU Eselon 1","Deskripsi IKK","Satuan");
				else
					$colHeaders = array("Tahun","Kode Eselon II","Kode IKK","Deskripsi","Satuan");
					//$colHeaders = array("Kode Eselon 2","Kode IKK","Kode IKU Eselon 1","Deskripsi IKK","Satuan");
			else
				$colHeaders = array("Tahun","Kode Eselon II","Kode IKK","Deskripsi","Satuan");
				//$colHeaders = array("Kode Eselon 2","Kode IKK","Kode IKU Eselon 1`","Deskripsi IKK","Satuan");
					
		//	var_dump($query->result());die;
			to_excel($query,"IKK",$colHeaders);
		}else if ($purpose==4) { //WEB SERVICE
			return $response;
		}
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($file1, $file2,$filtahun,$filkey=null){
	
		if($file2 != '-1' && $file2 != null){
			//$this->db->where("tbl_iku_eselon1.kode_iku_e1",$file1);
			$this->db->where("a.kode_e2",$file2);
		}
		if (($file1 != '-1')&&($file1 != null)){
			$this->db->where("c.kode_e1",$file1);
		}
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
		if($filkey != '' && $filkey != '-1' && $filkey != null) {
			$this->db->like("a.deskripsi",$filkey);
		}
		$this->db->from('tbl_ikk a');
		$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
		$this->db->join('tbl_eselon1 c', 'c.kode_e1 = b.kode_e1');
		$this->db->join('tbl_iku_eselon1 d', 'd.kode_iku_e1 = a.kode_iku_e1  and a.tahun=d.tahun','left');

		//$this->db->select("*",false);
		//$this->db->from('tbl_ikk');
		//$this->db->join('tbl_iku_eselon1', 'tbl_iku_eselon1.kode_iku_e1 = tbl_ikk.kode_iku_e1');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null,$tahun=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_ikk',$kode); //buat validasi
		if ($tahun!=null)//utk update
			$this->db->where('tahun',$tahun); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_ikk');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function existInRKT($tahun, $kode_ikk){
		$this->db->flush_cache();
		
		$this->db->select('*');
		$this->db->from('tbl_rkt_eselon2');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_ikk', $kode_ikk);
		
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('kode_ikk',$data['kode_ikk']);
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('satuan',$data['satuan']);
		//$this->db->set('kode_iku_e1',$data['kode_iku_e1']);
		
		$this->db->set('kode_iku_e1',(($data['kode_iku_e1']=="")||($data['kode_iku_e1']==null)||($data['kode_iku_e1']=="-1")?null:$data['kode_iku_e1']));
		$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		try {
			$result = $this->db->insert('tbl_ikk');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('kode_ikk',$data['kode_ikk']);
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('deskripsi',$data['deskripsi']);
			$this->db->set('satuan',$data['satuan']);
			$this->db->set('kode_iku_e1',(($data['kode_iku_e1']=="")||($data['kode_iku_e1']==null)||($data['kode_iku_e1']=="-1")?null:$data['kode_iku_e1']));
			$this->db->set('kode_e2',$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_ikk_log');
			
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
		$this->db->where('kode_ikk',$kode);
		$this->db->where('tahun',$tahun);
		
		$this->db->set('tahun',$data['tahun']);
$this->db->set('kode_ikk',$data['kode_ikk']);
		$this->db->set('kode_e2',$data['kode_e2']);
		//$this->db->set('kode_iku_e1',$data['kode_iku_e1']);
		$this->db->set('kode_iku_e1',(($data['kode_iku_e1']=="")||($data['kode_iku_e1']==null)||($data['kode_iku_e1']=="-1")?null:$data['kode_iku_e1']));
		$this->db->set('deskripsi',$data['deskripsi']);		
		$this->db->set('satuan',$data['satuan']);		
		$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);		
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result=$this->db->update('tbl_ikk');
		
		
		# insert to log
		$this->db->flush_cache();
		$this->db->set('kode_ikk',$kode);
		$this->db->set('deskripsi',$data['deskripsi']);
		$this->db->set('tahun',$tahun);
		$this->db->set('satuan',$data['satuan']);
		$this->db->set('kode_iku_e1',(($data['kode_iku_e1']=="")||($data['kode_iku_e1']==null)||($data['kode_iku_e1']=="-1")?null:$data['kode_iku_e1']));
		$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_ikk_log');
		
		
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
	public function DeleteOnDb($tahun, $kode_ikk){
		$this->db->flush_cache();
		$this->db->where('kode_ikk', $kode_ikk);
		$this->db->where('tahun', $tahun);
		$result = $this->db->delete('tbl_ikk'); 
		
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
			$sql = "insert into tbl_ikk(tahun, kode_ikk, deskripsi, satuan, kode_iku_e1, kode_e2, kode_sasaran_e2, 
	log_insert) select ".$data['tahun_tujuan'].", kode_ikk, deskripsi, satuan, kode_iku_e1,kode_e2, kode_sasaran_e2,  '".$this->session->userdata('user_id').';'.date('Y-m-d H:i:s')."'"
			." from tbl_ikk"
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
	

	public function getListIKK($objectId=""){
		
		$this->db->flush_cache();
		$this->db->select('kode_ikk, deskripsi, satuan');
		$this->db->from('tbl_ikk');
		$this->db->order_by('kode_ikk');
		
		$que = $this->db->get();
		
		$out  = '<select id="1" name="detail[1][kode_ikk'.$objectId.']" onchange="getSatuan'.$objectId.'(this.value, this.id)">';
		$out .= '<option value="0">-- Pilih --</option>';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_ikk.'">['.$r->kode_ikk.'] '.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data IKK untuk tingkat Eselon ini belum tersedia.";
		}
		
		echo $out;
	}
	
	
	public function getListTahun($objectId,$withAll=true){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_ikk');
		$e2 = $this->session->userdata('unit_kerja_e2');
		if (($e2!=-1)&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
			//$value = $e1;
		}
		$this->db->order_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select name="filter_tahun'.$objectId.'" id="filter_tahun'.$objectId.'">';
		if ($withAll)
			$out .= '<option value="-1">Semua</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		if ($que->num_rows()==0){
			$out = 'Data IKK belum ada.';
		}
		
		echo $out;
	}
	
	public function getDeskripsiIKU($id){
		$this->db->flush_cache();
		$this->db->select('deskripsi');
		$this->db->from('tbl_iku_eselon1');
		$this->db->where('kode_iku_e1', $id);
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
		
		$this->db->set('tahun',			$data['tahun']);
		$this->db->set('kode_ikk',		$data['kode_ikk']);
		$this->db->set('deskripsi',		$data['deskripsi']);		
		$this->db->set('satuan',		$data['satuan']);		
		//chan $this->db->set('kode_iku_e1',	$data['kode_iku_e1']);		
		$this->db->set('kode_e2',		$data['kode_e2']);		
		
		$result = $this->db->insert('tbl_ikk');
		
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
