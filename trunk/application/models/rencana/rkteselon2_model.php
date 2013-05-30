<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rkteselon2_model extends CI_Model
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
	public function easyGrid($filtahun=null, $file1=null, $file2=null, $purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun, $file1, $file2);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc'; 
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}	
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("e.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("a.kode_e2",$file2);
			}
			
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("*, a.tahun AS tahun2, a.kode_e2 as rkt_kode_e2",false);
			$this->db->select("c.deskripsi AS deskripsi_sasaran_e2, b.deskripsi AS deskripsi_ikk, e.nama_e2", false);
			$this->db->from('tbl_rkt_eselon2 a');
			$this->db->join('tbl_ikk b','b.kode_ikk = a.kode_ikk and b.tahun = a.tahun', 'left');
			$this->db->join('tbl_sasaran_eselon2 c','c.kode_sasaran_e2 = a.kode_sasaran_e2', 'left');
			$this->db->join('tbl_sasaran_eselon1 d', 'd.kode_sasaran_e1 = c.kode_sasaran_e1', 'left');
			$this->db->join('tbl_eselon2 e', 'e.kode_e2 = a.kode_e2', 'left');
			
			$this->db->order_by("a.tahun DESC, a.kode_sasaran_e2 ASC, a.kode_ikk ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['id_rkt_e2']=$row->id_rkt_e2;
				$response->rows[$i]['tahun']=$row->tahun2;
				$response->rows[$i]['kode_e2']=$row->rkt_kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['deskripsi_sasaran_e2']=$row->deskripsi_sasaran_e2;
				$response->rows[$i]['kode_ikk']=$row->kode_ikk;
				$response->rows[$i]['deskripsi_ikk']=$row->deskripsi_ikk;
				$response->rows[$i]['deskripsi']=$row->deskripsi;
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
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['status']= $row->status;
				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				if($file2 == '' || $file2 == '-1' || $file2 == null)
					unset($row->kode_e2);
				unset($row->id_rkt_e2); 
				unset($row->tahun);
				unset($row->kode_ikk);
				unset($row->status);
					
				//============================================================
					
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					if($file2 != '' && $file2 != '-1' && $file2 != null)
						$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
					else
						$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
				else
					$pdfdata[] = array($no,$response->rows[$i]['kode_e2'],$response->rows[$i]['kode_sasaran_e2'],$response->rows[$i]['deskripsi'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
				//============================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['id_rkt_e2']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['nama_e2']='';
				$response->rows[$count]['kode_sasaran_e2']='';
				$response->rows[$count]['deskripsi_sasaran_e2']='';
				$response->rows[$count]['kode_ikk']='';
				$response->rows[$count]['deskripsi_ikk']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['status']='';
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
					$colHeaders = array("Kode Sasaran","Indikator Kinerja Kegiatan","Satuan","Status");
				else
					$colHeaders = array("Kode Eselon II","Kode Sasaran","Indikator Kinerja Kegiatan","Satuan","Status");
			else
				$colHeaders = array("Kode Eselon II","Kode Sasaran","Indikator Kinerja Kegiatan","Satuan","Status");
					
		//	var_dump($query->result());die;
			to_excel($query,"SasaranEselon2",$colHeaders);
		}
	}
	
	public function GetRecordCount($filtahun=null, $file1, $file2){
		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("a.tahun",$filtahun);
		}	
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("e.kode_e1",$file1);
		}
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("a.kode_e2",$file2);
		}
		
		$this->db->select("*, a.kode_e2 as rkt_kode_e2",false);
		$this->db->from('tbl_rkt_eselon2 a');
		$this->db->join('tbl_ikk b','b.kode_ikk = a.kode_ikk and b.tahun = a.tahun', 'left');
		$this->db->join('tbl_sasaran_eselon2 c','c.kode_sasaran_e2 = a.kode_sasaran_e2', 'left');
		$this->db->join('tbl_sasaran_eselon1 d', 'd.kode_sasaran_e1 = c.kode_sasaran_e1', 'left');
		$this->db->join('tbl_eselon2 e', 'e.kode_e2 = a.kode_e2', 'left');	
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	// combobox
	public function getListIKK($objectId="",$data=""){
		// id dari tabel
		$kode_ikk = isset($data['kode_ikk'])?$data['kode_ikk']:'0';
		$tahun = isset($data['tahun'])?$data['tahun']:'2012';
		
		$id = isset($data['id'])?$data['id']:'0';
		$name = isset($data['name'])?$data['name']:'';
		$onchange = isset($data['onchange'])?$data['onchange']:'';
		
		$this->db->flush_cache();
		$this->db->select('kode_ikk, deskripsi, satuan');
		$this->db->from('tbl_ikk');
		$this->db->where('tahun', $tahun);
		$this->db->order_by('kode_ikk');
		// jika data berdasarkan Eselon 2
		if(isset($data['kode_e2'])){
			$this->db->where('kode_e2', $data['kode_e2']);
		}
		
		$que = $this->db->get();
		
		if($que->num_rows() > 0){
			$out = '<select id="'.$id.'" name="'.$name.'" onchange="'.$onchange.'" style=width:100%;>';
			$out .= '<option value="0">-- Pilih --</option>';
			foreach($que->result() as $r){
				if($r->kode_ikk == $kode_ikk){
					$out .= '<option value="'.$r->kode_ikk.'" selected="selected">'.$r->deskripsi.'</option>';
				}else{
					$out .= '<option value="'.$r->kode_ikk.'">'.$r->deskripsi.'</option>';
				}
			}
			$out .= '</select>';
		}else{
			$out = 'Tidak terdapat IKK pada tahun '.$tahun;
		}
		
		return $out;
	}
	
	public function getIKK($objectId, $kode, $tahun){
		$out = '';
		$data['kode_e2'] = $kode;
		$data['tahun'] = $tahun;
		$data['id'] = '1';
		$data['name'] = 'detail[1][kode_ikk]';
		$data['onchange'] = 'javascript:getSatuan'.$objectId.'(this.value, this.id)';
		
		$out = '<tr>
					<td><input type="checkbox" name="chk'.$objectId.'[]"/></td>
					<td>1</td>
					<td>'.
						$this->getListIKK($objectId, $data)
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
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, d.deskripsi as ikk ');
		$this->db->from('tbl_rkt_eselon2 a');
		$this->db->join('tbl_sasaran_eselon2 b', 'b.kode_sasaran_e2 = a.kode_sasaran_e2');
		$this->db->join('tbl_eselon2 c', 'c.kode_e2 = a.kode_e2');
		$this->db->join('tbl_ikk d', 'd.kode_ikk = a.kode_ikk and d.tahun = a.tahun');
		$this->db->join('tbl_eselon1 e', 'e.kode_e1 = c.kode_e1');
		$this->db->where('a.id_rkt_e2', $id);
		
		return $this->db->get()->row();
	}
	
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('kode_e2',$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
			$this->db->set('kode_ikk',$dt['kode_ikk']);
			$this->db->set('target',$dt['target']);
			//$this->db->set('satuan',$dt['satuan']);
			$this->db->set('status', '0');
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			
			$this->db->insert('tbl_rkt_eselon2');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('kode_e2',$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
			$this->db->set('kode_ikk',$dt['kode_ikk']);
			$this->db->set('target',$dt['target']);
			$this->db->set('status', '0');
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$this->db->insert('tbl_rkt_eselon2_log');
			
		}
		
		
		/*
		try {
			$result = $this->db->insert('tbl_rkt_eselon2');
		}
		catch(Exception $e){
			$errNo   = $this->db->_error_number();
			$errMess = $e->getMessage();//$this->db->_error_message();
			$error = $errMess;
			log_message("error", "Problem Inserting to : ".$errMess." (".$errNo.")"); 
		}*/
		
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	
	
	public function UpdateOnDb($data){
		$this->db->flush_cache();
		$this->db->where('id_rkt_e2', 	$data['id_rkt_e2']);
		
		$this->db->set('kode_ikk', 	$data['kode_ikk']);
		$this->db->set('target', 	$data['target']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->update('tbl_rkt_eselon2');
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_rkt_eselon2");
		$this->db->where('id_rkt_e2', 	$data['id_rkt_e2']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_e2',			$qt->row()->kode_e2);
		$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
		$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
		$this->db->set('target',			$qt->row()->target);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$this->db->insert('tbl_rkt_eselon2_log');
		
		
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
	
	public function DeleteOnDb($id){
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_rkt_eselon2");
		$this->db->where('id_rkt_e2', 	$id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_e2',			$qt->row()->kode_e2);
		$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
		$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
		$this->db->set('target',			$qt->row()->target);
		$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$this->db->insert('tbl_rkt_eselon2_log');
		
		$this->db->flush_cache();
		$this->db->where('id_rkt_e2', $id);
		$result = $this->db->delete('tbl_rkt_eselon2');

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
	
	public function GetRecordCountTindak($register_id){
				
		$this->db->from('trs_rwj_tindakan d');
		$this->db->where('d.daftar_rwj_id', $register_id);
			
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function getSatuan($id){
		$this->db->flush_cache();
		$this->db->select('satuan');
		$this->db->from('tbl_ikk');
		$this->db->where('kode_ikk', $id);
		$query = $this->db->get();
		
		return $query->row()->satuan;
		
	}
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_rkt_eselon2');
		$this->db->group_by('tahun');
		$e2 = $this->session->userdata('unit_kerja_e2');
		if (($e2!="-1")&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
			//$value = $e1;
		}
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
		
		//echo $out;
		return $out;
		
	}
	
	public function data_exist($tahun, $kode_e2, $kode_sasaran_e2, $kode_ikk){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_rkt_eselon2');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_e2', $kode_e2);
		$this->db->where('kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->where('kode_ikk', $kode_ikk);
		
		$que = $this->db->get();
		
		if ($que->num_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_rkt_eselon2');
		$e2 = $this->session->userdata('unit_kerja_e2');
		if (($e2!="-1")&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
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
