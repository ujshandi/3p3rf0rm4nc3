<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/
  
class Penetapankl_model extends CI_Model
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
				if(is_numeric($row->target)){
					if(strpos($row->target, '.') || strpos($row->target, ',')){
						$response->rows[$i]['target'] = number_format($row->target, 4, ',', '.');
					}else{
						$response->rows[$i]['target'] = number_format($row->target, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['target'] = $row->target;
				}
				if(is_numeric($row->penetapan)){
					if(strpos($row->penetapan, '.') || strpos($row->penetapan, ',')){
						$response->rows[$i]['penetapan'] = number_format($row->penetapan, 4, ',', '.');
					}else{
						$response->rows[$i]['penetapan'] = number_format($row->penetapan, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['penetapan'] = $row->penetapan;
				}
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
	
	public function getDetail($tahun, $kode_kl, $kode_sasaran_kl){
		$out = '';
		$i = 1;
		
		# header table
		$header = '	<tr>
						<th bgcolor="#F4F4F4" width="10px">No.</th>
						<th width="100%" bgcolor="#F4F4F4">Indikator Kerja Utama</th>
						<th bgcolor="#F4F4F4" width="100">Target (RKT)</th>
						<th bgcolor="#F4F4F4" width="100">Target (PK)</th>
						<th bgcolor="#F4F4F4">Satuan</th>
					</tr>';
		
		# Ambil Data dari PK
		# -------------------------------------------------------------------------------------
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pk_kl a');
		$this->db->join('tbl_iku_kl b','a.kode_iku_kl = b.kode_iku_kl and a.tahun = b.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_kl', $kode_kl);
		$this->db->where('a.kode_sasaran_kl', $kode_sasaran_kl);
		//$this->db->where('a.status !=', '1');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$out .= '<tr>';
					$out .= '<td>'.$i.'<input type="hidden" name="detail['.$i.'][id_pk_kl]" value="'.$row->id_pk_kl.'"></td>';
					$out .= '<td>';
						$out .= '<input type="hidden" name="detail['.$i.'][kode_iku_kl]" value="'.$row->kode_iku_kl.'" >';
						$out .= $row->deskripsi;
					$out .= '</td>';
				
					$out .= '<td>';
						$out .= '<input name="detail['.$i.'][target]" value="'.$row->target.'" readonly="readonly" size="15">';
					$out .= '</td>';
				
					$out .= '<td>';
						$out .= '<input name="detail['.$i.'][penetapan]" value="'.$row->penetapan.'" size="15" '.($row->status=='1'?'readonly="readonly"':'').'>';
					$out .= '</td>';
				
					$out .= '<td>';
						$out .= '<input name="detail['.$i.'][satuan]" value="'.$row->satuan.'" readonly="readonly">';
					$out .= '</td>';
					
				$out .= '</tr>';
				
				$i++;
			} // end foreach
		}
		
		# End Ambil Data dari PK
		# -------------------------------------------------------------------------------------
		
		
		# Ambil data dari RKT
		# -------------------------------------------------------------------------------------
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_rkt_kl a');
		$this->db->join('tbl_iku_kl b','a.kode_iku_kl = b.kode_iku_kl and a.tahun = b.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_kl', $kode_kl);
		$this->db->where('a.kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('a.status !=', '1');
		
		$query = $this->db->get();
		
		foreach($query->result() as $row){
			$out .= '<tr>';
				$out .= '<td>'.$i.'<input type="hidden" name="detail['.$i.'][id_pk_kl]" value="0"></td>';
				$out .= '<td>';
					$out .= '<input type="hidden" name=detail['.$i.'][kode_iku_kl] value="'.$row->kode_iku_kl.'" >';
					$out .= $row->deskripsi;
				$out .= '</td>';
			
				$out .= '<td>';
					$out .= '<input name=detail['.$i.'][target] value="'.$row->target.'" readonly="readonly" size="15">';
				$out .= '</td>';
			
				$out .= '<td>';
					$out .= '<input name=detail['.$i.'][penetapan] value="" size="15">';
				$out .= '</td>';
			
				$out .= '<td>';
					$out .= '<input name=detail['.$i.'][satuan] value="'.$row->satuan.'" readonly="readonly">';
				$out .= '</td>';
				
			$out .= '</tr>';
			
			$i++;
		}
		# End Ambil data dari RKT
		# -------------------------------------------------------------------------------------
		
		//chan 
		if ($out=="")
			return $out .= 'Data RKT Kementerian belum tersedia.';
				
		return $header.$out;
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as iku_kl');
		$this->db->from('tbl_pk_kl a');
		$this->db->join('tbl_sasaran_kl b', 'b.kode_sasaran_kl = a.kode_sasaran_kl');
		$this->db->join('tbl_iku_kl c', 'c.kode_iku_kl = a.kode_iku_kl and c.tahun = a.tahun');
		$this->db->join('tbl_kl d', 'd.kode_kl = a.kode_kl');
		$this->db->where('a.id_pk_kl', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			
			# jika id_pk_kl != 0 maka update
			if($dt['id_pk_kl'] != '0'){
				// update target penetapan di tabel PK
				$this->db->flush_cache();
				$this->db->set('penetapan', 	$dt['penetapan']);
				$this->db->set('log_update', 	$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$this->db->where('id_pk_kl', 	$dt['id_pk_kl']);
				$this->db->update('tbl_pk_kl');
				
			}else{
				//query insert data ke PK
				$this->db->flush_cache();
				$this->db->set('tahun',$data['tahun']);
				$this->db->set('kode_kl',$data['kode_kl']);
				$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
				$this->db->set('kode_iku_kl',$dt['kode_iku_kl']);
				$this->db->set('target',$dt['target']);
				$this->db->set('penetapan',$dt['penetapan']);
				$this->db->set('status','0');
				$this->db->set('log_insert', 	$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$result = $this->db->insert('tbl_pk_kl');
				
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
				
			}
			
		}
	
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	}
	
	public function UpdateOnDb($data){
		$this->db->flush_cache();
		$this->db->where('id_pk_kl', $data['id_pk_kl']);
		$this->db->set('penetapan', $data['penetapan']);
		$result = $this->db->update('tbl_pk_kl', $data);
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_pk_kl");
		$this->db->where('id_pk_kl', $data['id_pk_kl']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_kl',			$qt->row()->kode_kl);
		$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
		$this->db->set('kode_iku_kl',		$qt->row()->kode_iku_kl);
		$this->db->set('target',			$qt->row()->target);
		$this->db->set('penetapan',			$qt->row()->penetapan);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_pk_kl_log');
		
		
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
		$this->db->from("tbl_pk_kl");
		$this->db->where('id_pk_kl', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_kl',			$qt->row()->kode_kl);
		$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
		$this->db->set('kode_iku_kl',		$qt->row()->kode_iku_kl);
		$this->db->set('target',			$qt->row()->target);
		$this->db->set('penetapan',			$qt->row()->penetapan);
		$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->insert('tbl_pk_kl_log');
		
		// proses
		$this->db->flush_cache();
		$this->db->where('id_pk_kl', $id);
		$result = $this->db->delete('tbl_pk_kl');
		
		
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
