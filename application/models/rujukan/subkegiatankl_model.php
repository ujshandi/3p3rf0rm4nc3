<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Subkegiatankl_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($file1=null, $file2=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1,$file2);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
				if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("kl.kode_e2",$file2);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("e2.kode_e1",$file1);
		}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select('tbl_subkegiatan_kl.id_subkegiatan_kl, tbl_subkegiatan_kl.tahun, tbl_subkegiatan_kl.kode_subkegiatan, tbl_subkegiatan_kl.nama_subkegiatan, tbl_subkegiatan_kl.lokasi, tbl_subkegiatan_kl.volume, tbl_subkegiatan_kl.satuan, tbl_subkegiatan_kl.total, tbl_subkegiatan_kl.kode_kegiatan, tbl_subkegiatan_kl.kode_satker ');
			$this->db->from('tbl_subkegiatan_kl');
			$this->db->order_by("tbl_subkegiatan_kl.tahun DESC, tbl_subkegiatan_kl.kode_satker ASC, tbl_subkegiatan_kl.kode_kegiatan ASC, tbl_subkegiatan_kl.kode_subkegiatan ASC");
			//$this->db->from('tbl_subkegiatan_kl sbkl left join tbl_kegiatan_kl on sbkl.kode_kegiatan = kl.kode_kegiatan',false);
			//$this->db->join('tbl_kegiatan','tbl_kegiatan.kode_kegiatan = tbl_subkegiatan_kl.kode_kegiatan');
			
			
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				//$response->rows[$i]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$i]['id_subkegiatan_kl']	=$row->id_subkegiatan_kl;
				$response->rows[$i]['tahun']			=$row->tahun;
				$response->rows[$i]['kode_subkegiatan']	=$row->kode_subkegiatan;
				$response->rows[$i]['nama_subkegiatan']	=$row->nama_subkegiatan;
				$response->rows[$i]['lokasi']			=$row->lokasi;
				$response->rows[$i]['volume']			=$row->volume;
				$response->rows[$i]['satuan']			=$row->satuan;
				$response->rows[$i]['total']			=number_format( $row->total, 0, ',', '.');;
				$response->rows[$i]['kode_kegiatan']	=$row->kode_kegiatan;
				$response->rows[$i]['kode_satker']			=$row->kode_satker;

				//utk kepentingan export excel ============================
				unset($row->id_subkegiatan_kl);
				if($file2 != '' && $file2 != '-1' && $file2 != null){
					//unset($row->kode_e2);
					//tambahkan header kolom
					$colHeaders = array("Tahun","Kode Sub Kegiatan","Nama Sub Kegiatan","Lokasi","Volume","Satuan","Total","Kode kegiatan","Kode Satker");		
				}
				else{
					$colHeaders = array("Tahun","Kode Sub Kegiatan","Nama Sub Kegiatan","Lokasi","Volume","Satuan","Total","Kode kegiatan","Kode Satker");		
				}
				//=========================================================
					
				//utk kepentingan export pdf===============================
				if($file2 != '' && $file2 != '-1' && $file2 != null){
					$pdfdata[] = array($no,
									   $response->rows[$i]['tahun'],
									   $response->rows[$i]['kode_subkegiatan'],
									   $response->rows[$i]['nama_subkegiatan'],
									   $response->rows[$i]['lokasi'],
									   $response->rows[$i]['volume'],
									   $response->rows[$i]['satuan'],
									   $response->rows[$i]['total'],
									   $response->rows[$i]['kode_kegiatan'],
									   $response->rows[$i]['kode_satker']);
				}
				else{
					$pdfdata[] = array($no,
									   $response->rows[$i]['tahun'],
									   $response->rows[$i]['kode_subkegiatan'],
									   $response->rows[$i]['nama_subkegiatan'],
									   $response->rows[$i]['lokasi'],
									   $response->rows[$i]['volume'],
									   $response->rows[$i]['satuan'],
									   $response->rows[$i]['total'],
									   $response->rows[$i]['kode_kegiatan'],
									   $response->rows[$i]['kode_satker']);
				}
				//=========================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			//$query->free_result();
		}else {
				$response->rows[$count]['id_subkegiatan_kl']	="";
				$response->rows[$count]['tahun']			="";
				$response->rows[$count]['kode_subkegiatan']	="";
				$response->rows[$count]['nama_subkegiatan']	="";
				$response->rows[$count]['lokasi']			="";
				$response->rows[$count]['volume']			="";
				$response->rows[$count]['satuan']			="";
				$response->rows[$count]['total']			="";
				$response->rows[$count]['kode_kegiatan']	="";
				$response->rows[$count]['kode_satker']		="";
				$response->lastNo = 0;				
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
		//	var_dump($query->result());die;
			to_excel($query,"SubKegiatan",$colHeaders);
		}
	}
	
	public function GetRecordCount($file1=null,$file2=null){
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("kl.kode_e2",$file2);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("e2.kode_e1",$file1);
		}
		$this->db->flush_cache();
		$this->db->select("*",false);
		$this->db->from('tbl_subkegiatan_kl');
		//$this->db->from('tbl_subkegiatan_kl sbkl left join tbl_kegiatan_kl on sbkl.kode_kegiatan = kl.kode_kegiatan',false);
		//$this->db->join('tbl_kegiatan','tbl_kegiatan.kode_kegiatan = tbl_subkegiatan_kl.kode_kegiatan');
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function GetKodeE1($kode_program){
		$this->db->flush_cache();
		//$this->db->select("*",false);
		$this->db->select('tbl_program_kl.kode_e1');
		$this->db->from('tbl_program_kl');
		$this->db->where('kode_program', $kode_program);
		//$this->db->join('tbl_kegiatan','tbl_kegiatan.kode_kegiatan = tbl_subkegiatan_kl.kode_kegiatan');
		
		return $this->db->get();
	}
		
	
	// combobox
	
	
	/* public function InsertOnDB_kegiatan($data) {
		//query insert data		
		$this->db->set('kode_program', $data['kode_program']);
		$this->db->set('kode_kegiatan', $data['kode_kegiatan']);
		$this->db->set('nama_kegiatan',$data['nama_kegiatan']);
		
		$result = $this->db->insert('tbl_kegiatan');
		
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
	} */
	
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_subkegiatan_kl a');
		$this->db->join('tbl_satker b', 'b.kode_satker = a.kode_satker');
		$this->db->join('tbl_eselon1 c', 'c.kode_e1 = b.kode_e1');
		$this->db->join('tbl_kegiatan_kl d', 'd.kode_kegiatan = a.kode_kegiatan');
		$this->db->where('a.id_subkegiatan_kl', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data){
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			$this->db->set('tahun', 			$data['tahun']);
			$this->db->set('kode_kegiatan',		$data['kode_kegiatan']);
			$this->db->set('kode_satker',		$data['kode_satker']);
			
			$this->db->set('kode_subkegiatan',	$dt['kode_subkegiatan']);
			$this->db->set('nama_subkegiatan',	$dt['nama_subkegiatan']);
			$this->db->set('lokasi',			$dt['lokasi']);
			$this->db->set('volume',			$dt['volume']);
			$this->db->set('satuan',			$dt['satuan']);
			$this->db->set('total',				$dt['total']);
			
			$result = $this->db->insert('tbl_subkegiatan_kl');
			
		}
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Inserting to : ".$errMess." (".$errNo.")"); 
		
		//return
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	
	public function UpdateOnDB_subkegiatanKL($data){
		//query update data
		$this->db->flush_cache();
		$this->db->set('tahun', $data['tahun']);
		$this->db->set('kode_subkegiatan',$data['kode_subkegiatan']);
		$this->db->set('nama_subkegiatan',$data['nama_subkegiatan']);
		$this->db->set('lokasi',$data['lokasi']);
		$this->db->set('volume',$data['volume']);
		$this->db->set('satuan',$data['satuan']);
		$this->db->set('total',$data['total']);
		$this->db->set('kode_kegiatan',$data['kode_kegiatan']);
		$this->db->set('kode_satker',$data['kode_satker']);
		
		$this->db->where('id_subkegiatan_kl', $data['id_subkegiatan_kl']);
		
		$result = $this->db->update('tbl_subkegiatan_kl');
		
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
	public function DeleteOnDb($tindak_id, $unit_id, $klas_id) {
		$this->db->where('tindak_id',$tindak_id);
		$this->db->where('unit_id',$unit_id);
		$this->db->where('klas_id',$klas_id);
		
		$result = $this->db->delete('mst_tindakan_unit');
		
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	


}
?>
