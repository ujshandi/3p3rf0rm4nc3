<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/
  
class Checkpointkl_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($filtahun=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_pk_kl.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_pk_kl.tahun",$filtahun);
			}	
			
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("distinct tbl_pk_kl.*,tbl_iku_kl.deskripsi as deskripsi_iku_kl,tbl_iku_kl.satuan,tbl_sasaran_kl.deskripsi as deskripsi_sasaran_kl, tbl_kl.nama_kl",false);
			$this->db->from('tbl_pk_kl ');
			$this->db->join('tbl_iku_kl','tbl_iku_kl.kode_iku_kl = tbl_pk_kl.kode_iku_kl and tbl_iku_kl.tahun = tbl_pk_kl.tahun');
			$this->db->join('tbl_sasaran_kl','tbl_sasaran_kl.kode_sasaran_kl = tbl_pk_kl.kode_sasaran_kl');
			$this->db->join('tbl_kl', 'tbl_kl.kode_kl = tbl_pk_kl.kode_kl');
			$this->db->order_by("tbl_pk_kl.tahun DESC, kode_sasaran_kl ASC, tbl_pk_kl.kode_iku_kl ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_pk_kl']=$row->id_pk_kl;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['nama_kl']=$row->nama_kl;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['deskripsi_iku_kl']=$row->deskripsi_iku_kl;
				$response->rows[$i]['deskripsi_sasaran_kl']=$row->deskripsi_sasaran_kl;
/*
				if(is_numeric($row->target)){
					if(strpos($row->target, '.') || strpos($row->target, ',')){
						$response->rows[$i]['target'] = number_format($row->target, 4, ',', '.');
					}else{
						$response->rows[$i]['target'] = number_format($row->target, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['target'] = $row->target;
				}
*/
				$response->rows[$i]['target']=$this->utility->cekNumericFmt($row->target);
/*
				if(is_numeric($row->penetapan)){
					if(strpos($row->penetapan, '.') || strpos($row->penetapan, ',')){
						$response->rows[$i]['penetapan'] = number_format($row->penetapan, 4, ',', '.');
					}else{
						$response->rows[$i]['penetapan'] = number_format($row->penetapan, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['penetapan'] = $row->penetapan;
				}
*/
				$response->rows[$i]['penetapan']=$this->utility->cekNumericFmt($row->penetapan);
				$response->rows[$i]['satuan']=$row->satuan;
				$i++;
			} 
			$query->free_result();
		}else {
				$response->rows[$count]['id_pk_kl']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['kode_iku_kl']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['penetapan']='';
				$response->rows[$count]['nama_kl']='';
				$response->rows[$count]['deskripsi_iku_kl']='';
				$response->rows[$count]['deskripsi_sasaran_kl']='';
		}
		
		return json_encode($response);
	}
	
	public function easyGridDetail($id_pk){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		//$count = $this->GetRecordCount($filtahun);
		$response = new stdClass();
	//	$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'periode';  
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_pk_kl.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		$count = 0;
		//if ($count>0){
			//filter
			//if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_checkpoint_kl.id_pk_kl",$id_pk);
			//}	
			
			//$this->db->order_by($sort." ".$order );
		//	$this->db->limit($limit,$offset);
			$this->db->select("distinct tbl_checkpoint_kl.*",false);
			$this->db->from('tbl_checkpoint_kl ');
			
			$this->db->order_by("tbl_checkpoint_kl.periode DESC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_pk_kl']=$row->id_pk_kl;
				$response->rows[$i]['id_checkpoint_kl']=$row->id_checkpoint_kl;
				$response->rows[$i]['unit_kerja']=$row->unit_kerja;
				$response->rows[$i]['keterangan']=$row->keterangan;
				$response->rows[$i]['periode']=$row->periode;
				$response->rows[$i]['kriteria']=$row->kriteria;
				$response->rows[$i]['ukuran']=$row->ukuran;
				$response->rows[$i]['target']=$this->utility->cekNumericFmt($row->target);
				$response->rows[$i]['capaian']=$this->utility->cekNumericFmt($row->capaian);
				


				$i++;
			} 
			$query->free_result();
		 if ($i==0) {
				$response->rows[$count]['id_pk_kl']='';
				$response->rows[$count]['id_checkpoint_kl']='';
				$response->rows[$count]['periode']='';
				$response->rows[$count]['kriteria']='';
				$response->rows[$count]['ukuran']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['capaian']='';
				$response->rows[$count]['keterangan']='';
				
		}
		
		return json_encode($response);
	}
	
	
	public function GetRecordCount($filtahun=null){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tbl_pk_kl.tahun",$filtahun);
		}
		
		$this->db->select("distinct tbl_pk_kl.*,tbl_iku_kl.deskripsi as deskripsi_iku_kl,tbl_iku_kl.satuan,tbl_sasaran_kl.deskripsi as deskripsi_sasaran_kl, tbl_kl.nama_kl",false);
		$this->db->from('tbl_pk_kl ');
		$this->db->join('tbl_iku_kl','tbl_iku_kl.kode_iku_kl = tbl_pk_kl.kode_iku_kl and tbl_iku_kl.tahun = tbl_pk_kl.tahun');
		$this->db->join('tbl_sasaran_kl','tbl_sasaran_kl.kode_sasaran_kl = tbl_pk_kl.kode_sasaran_kl');
		$this->db->join('tbl_kl', 'tbl_kl.kode_kl = tbl_pk_kl.kode_kl');
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('tbl_pk_kl.*,tbl_checkpoint_kl.*,tbl_iku_kl.deskripsi as deskripsi_iku_kl,tbl_iku_kl.satuan,tbl_sasaran_kl.deskripsi as deskripsi_sasaran_kl, tbl_kl.nama_kl');
		$this->db->from('tbl_pk_kl ');
			$this->db->join('tbl_iku_kl','tbl_iku_kl.kode_iku_kl = tbl_pk_kl.kode_iku_kl and tbl_iku_kl.tahun = tbl_pk_kl.tahun');
			$this->db->join('tbl_sasaran_kl','tbl_sasaran_kl.kode_sasaran_kl = tbl_pk_kl.kode_sasaran_kl');
			$this->db->join('tbl_kl', 'tbl_kl.kode_kl = tbl_pk_kl.kode_kl');
			$this->db->join('tbl_checkpoint_kl', 'tbl_checkpoint_kl.id_pk_kl = tbl_pk_kl.id_pk_kl');
		$this->db->where('tbl_checkpoint_kl.id_checkpoint_kl', $id);
		
		return json_encode($this->db->get()->row());
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		//foreach($data['detail'] as $dt){
			
			# jika id_pk_kl != 0 maka update
/*
			if($dt['id_pk_kl'] != '0'){
				// update target penetapan di tabel PK
				$this->db->flush_cache();
				$this->db->set('penetapan', 	$dt['penetapan']);
				$this->db->set('log_update', 	$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$this->db->where('id_pk_kl', 	$dt['id_pk_kl']);
				$this->db->update('tbl_pk_kl');
				
			}else{
*/
				//query insert data ke checkpoint				$this->db->flush_cache();
				$this->db->set('id_pk_kl',$data['id_pk_kl']);
				$this->db->set('unit_kerja',$data['unit_kerja']);
				$this->db->set('periode',$data['periode']);
				$this->db->set('kriteria',$data['kriteria']);
				$this->db->set('ukuran',$data['ukuran']);
				$this->db->set('target',$data['target']);
				$this->db->set('keterangan',$data['keterangan']);
				if ($data['purpose']=='Capaian')
					$this->db->set('capaian',$data['capaian']);
				$this->db->set('log_insert', 	$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$result = $this->db->insert('tbl_checkpoint_kl');
				
/*
				// update status tabel RKT
				$this->db->flush_cache();
				$this->db->set('status', '1');
				$this->db->where('tahun', $data['tahun']);
				$this->db->where('kode_kl', $data['kode_kl']);
				$this->db->where('kode_sasaran_kl', $data['kode_sasaran_kl']);
				$this->db->where('kode_iku_kl', $dt['kode_iku_kl']);
				$this->db->update('tbl_rkt_kl');
				
				# insert to log
				$this->db->flush_cache();
				$this->db->set('tahun',$data['tahun']);
				$this->db->set('kode_kl',$data['kode_kl']);
				$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
				$this->db->set('kode_iku_kl',$dt['kode_iku_kl']);
				$this->db->set('target',$dt['target']);
				$this->db->set('penetapan',$dt['penetapan']);
				$this->db->set('status','0');
				$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$result = $this->db->insert('tbl_pk_kl_log');
*/
				
			//}
			
		//}
	
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	}
	
	public function UpdateOnDb($data){
		$this->db->flush_cache();
		$this->db->where('id_checkpoint_kl', $data['id_checkpoint_kl']);
		
			//$this->db->set('id_pk_kl',$data['id_pk_kl']);
				$this->db->set('unit_kerja',$data['unit_kerja']);
				$this->db->set('periode',$data['periode']);
				$this->db->set('kriteria',$data['kriteria']);
				$this->db->set('ukuran',$data['ukuran']);
				$this->db->set('target',$data['target']);
				$this->db->set('keterangan',$data['keterangan']);
				if ($data['purpose']=='Capaian')
					$this->db->set('capaian',$data['capaian']);
				$this->db->set('log_update', 	$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->update('tbl_checkpoint_kl');	
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
	
	//hapus data
	public function DeleteOnDb($id){
	
		
		// proses
		$this->db->flush_cache();
		$this->db->where('id_checkpoint_kl', $id);
		$result = $this->db->delete('tbl_checkpoint_kl');
		
		
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
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_pk_kl');
		
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
	
	public function getListTahun($objectId=""){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_pk_kl');
		$this->db->group_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select id="tahun'.$objectId.'" name="tahun'.$objectId.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		$out .= '</select>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Program PK belum tersedia.";
		}
		
		
		echo $out;
	}
}
?>
