<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rkteselon1_model extends CI_Model
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
	public function easyGrid($filtahun=null,$file1=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun,$file1);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}	
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("a.kode_e1",$file1);
			}
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select('a.id_rkt_e1, a.tahun, a.kode_iku_e1, a.kode_e1 as rkt_kode_e1, a.kode_sasaran_e1 AS kode_sasaran_e12, b.deskripsi, a.target, b.satuan, a.status');
			$this->db->select("c.deskripsi as deskripsi_sasaran_e1, b.deskripsi AS deskripsi_iku_e1, d.nama_e1");
			$this->db->from('tbl_rkt_eselon1 a');
			$this->db->join('tbl_iku_eselon1 b', 'b.kode_iku_e1 = a.kode_iku_e1 and b.tahun = a.tahun');
			$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1 and c.tahun = a.tahun');
			$this->db->join('tbl_eselon1 d', 'd.kode_e1 = a.kode_e1');
			$this->db->order_by("a.tahun DESC, a.kode_sasaran_e1 ASC, a.kode_iku_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['id_rkt_e1']=$row->id_rkt_e1;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_e1']=$row->rkt_kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e12;
				$response->rows[$i]['deskripsi_sasaran_e1']=$row->deskripsi_sasaran_e1;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
				$response->rows[$i]['kode_iku']=$row->kode_iku_e1;
				$response->rows[$i]['deskripsi_iku_e1']=$row->deskripsi_iku_e1;
				if(is_numeric($row->target)){
					if(strpos($row->target, '.') || strpos($row->target, ',')){
						$response->rows[$i]['target'] = number_format($row->target, 4, ',', '.');
					}else{
						$response->rows[$i]['target'] = number_format($row->target, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['target'] = $row->target;
				}
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['status']= $row->status;
				
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file1 == '-1'){unset($row->rkt_kode_e1);}
				unset($row->id_rkt_e1);
				unset($row->tahun);
				unset($row->status);
				unset($row->kode_iku_e1);
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_sasaran_e1'],$response->rows[$i]['deskripsi'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['id_rkt_kl']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['kode_sasaran_e1']='';
				$response->rows[$count]['deskripsi_sasaran_e1']='';
				$response->rows[$count]['kode_iku']='';
				$response->rows[$count]['deskripsi_iku_e1']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
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
				$colHeaders = array("Kode Sasaran","Indikator Kinerja Utama","Target","Satuan");
			else
				$colHeaders = array("Kode Eselon I","Kode Sasaran","Indikator Kinerja Utama","Target","Satuan");	
			//	var_dump($query->result());die;
			to_excel($query,"SasaranEselon1",$colHeaders);
		}
	}
	
	public function GetRecordCount($filtahun=null,$file1){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("a.tahun",$filtahun);
		}	
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("a.kode_e1",$file1);
		}		
		$this->db->from('tbl_rkt_eselon1 a');
		$this->db->join('tbl_iku_eselon1 b', 'b.kode_iku_e1 = a.kode_iku_e1 and b.tahun = a.tahun');
		$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1');
		$this->db->join('tbl_eselon1 d', 'd.kode_e1 = a.kode_e1');
		$this->db->order_by("a.tahun DESC, a.kode_sasaran_e1 ASC, a.kode_iku_e1 ASC");
			
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as iku_e1');
		$this->db->from('tbl_rkt_eselon1 a');
		$this->db->join('tbl_sasaran_eselon1 b', 'b.kode_sasaran_e1 = a.kode_sasaran_e1');
		$this->db->join('tbl_iku_eselon1 c', 'c.kode_iku_e1 = a.kode_iku_e1 and c.tahun = a.tahun');
		$this->db->join('tbl_eselon1 d', 'd.kode_e1 = a.kode_e1');
		$this->db->where('a.id_rkt_e1', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('kode_e1',			$data['kode_e1']);
			$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);
			$this->db->set('kode_iku_e1',		$dt['kode_iku_e1']);
			$this->db->set('target',			$dt['target']);
			//$this->db->set('satuan',			$dt['satuan']);
			$this->db->set('status',			'0');
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			
			$this->db->insert('tbl_rkt_eselon1');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('kode_e1',			$data['kode_e1']);
			$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);
			$this->db->set('kode_iku_e1',		$dt['kode_iku_e1']);
			$this->db->set('target',			$dt['target']);
			$this->db->set('status',			'0');
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$this->db->insert('tbl_rkt_eselon1_log');
			
		}
		/*
		//query insert data		
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
		$this->db->set('kode_iku_e1',$data['kode_iku']);
		$this->db->set('target',$data['target']);
		try {
			$result = $this->db->insert('tbl_rkt_eselon1');
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
		*/
		
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	

	
	public function getListIKU_E1($objectId="", $data=""){
		// id dari tabel
		$kode_iku = isset($data['kode_iku'])?$data['kode_iku']:'0';
		$tahun = isset($data['tahun'])?$data['tahun']:'2012';
		
		$id = isset($data['id'])?$data['id']:'1';
		$name = isset($data['name'])?$data['name']:'';
		$onclick = isset($data['onclick'])?$data['onclick']:'';
		
		
		$this->db->flush_cache();
		$this->db->select('kode_iku_e1,deskripsi');
		$this->db->from('tbl_iku_eselon1');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('kode_iku_e1');
		// jika data berdasarkan Eselon 1
		if(isset($data['kode_e1'])){
			$this->db->where('kode_e1', $data['kode_e1']);
		}
		
		$que = $this->db->get();
		
		if($que->num_rows() > 0){
			$out = '<select id="'.$id.'" name="'.$name.'" onclick="'.$onclick.'" style=width:100%;>';
			$out .= '<option value="0">-- Pilih --</option>';
			foreach($que->result() as $r){
				if($r->kode_iku_e1 == $kode_iku){
					$out .= '<option value="'.$r->kode_iku_e1.'" selected="selected">'.$r->deskripsi.'</option>';
				}else{
					$out .= '<option value="'.$r->kode_iku_e1.'">'.$r->deskripsi.'</option>';
				}
			}
			$out .= '</select>';
		}else{
			$out = 'Tidak terdapat IKU pada tahun '.$tahun;
		}
		
		return $out;
	}
	
	public function getIKU_e1($objectId, $kode, $tahun){
		$out = '';
		$data['kode_e1'] = $kode;
		$data['tahun'] = $tahun;
		$data['id'] = '1';
		$data['name'] = 'detail[1][kode_iku]';
		$data['onclick'] = 'javascript:getSatuan'.$objectId.'(this.value, this.id)';
		$data['name'] = 'detail[1][kode_iku_e1]';
		
		$out = '<tr>
					<td><input type="checkbox" name="chk'.$objectId.'[]"/></td>
					<td>1</td>
					<td>'.
						$this->getListIKU_E1($objectId, $data)
					.'</td>
					<td>
						<input name="detail[1][target]" size="5" />
					</td>
					<td>
						<input name="detail[1][satuan]" id="satuan1'.$objectId.'" type="text" value="" readonly="true" />
					</td>
				</tr>
			';
		
		return $out;
	}
	
	public function UpdateOnDb($data){
		$this->db->flush_cache();
		$this->db->where('id_rkt_e1', $data['id_rkt_e1']);
		
		$this->db->set('kode_iku_e1', $data['kode_iku_e1']);
		$this->db->set('target', $data['target']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->update('tbl_rkt_eselon1');
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_rkt_eselon1");
		$this->db->where('id_rkt_e1', $data['id_rkt_e1']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_e1',			$qt->row()->kode_e1);
		$this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
		$this->db->set('kode_iku_e1',		$qt->row()->kode_iku_e1);
		$this->db->set('target',			$qt->row()->target);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$this->db->insert('tbl_rkt_eselon1_log');
		
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
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_rkt_eselon1");
		$this->db->where('id_rkt_e1', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_e1',			$qt->row()->kode_e1);
		$this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
		$this->db->set('kode_iku_e1',		$qt->row()->kode_iku_e1);
		$this->db->set('target',			$qt->row()->target);
		$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$this->db->insert('tbl_rkt_eselon1_log');
		
		$this->db->flush_cache();
		$this->db->where('id_rkt_e1', $id);
		$result = $this->db->delete('tbl_rkt_eselon1'); 
		
		
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
	
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$e1 = $this->session->userdata('unit_kerja_e1');
		if (($e1!="-1")&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			//$value = $e1;
		}
		$this->db->from('tbl_rkt_eselon1');
		$this->db->group_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select id="tahun'.$objectId.'" name="tahun" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data RKT belum tersedia.";
		}
		
		echo $out;
	}
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_rkt_eselon1');
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
	
	public function data_exist($tahun, $kode_e1, $kode_sasaran_e1, $kode_iku_e1){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_rkt_eselon1');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_e1', $kode_e1);
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->where('kode_iku_e1', $kode_iku_e1);
		
		$que = $this->db->get();
		
		if ($que->num_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}

	
?>
