<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Penetapaneselon2_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($filtahun=null, $file1=null, $file2=null,$filstatus=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun, $file1, $file2);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_pk_eselon2.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_pk_eselon2.tahun",$filtahun);
			}	
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_eselon2.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("tbl_pk_eselon2.kode_e2",$file2);
			}
			if ($filstatus!=null){
				$this->db->where("tbl_pk_eselon2.status",$filstatus);
			}

			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("tbl_pk_eselon2.*, tbl_ikk.deskripsi as deskripsi_iku_e2,tbl_ikk.satuan,tbl_sasaran_eselon2.deskripsi as deskripsi_sasaran_e2,tbl_eselon2.nama_e2",false);
			$this->db->from('tbl_pk_eselon2');
			$this->db->join('tbl_ikk', 'tbl_ikk.kode_ikk = tbl_pk_eselon2.kode_ikk and tbl_ikk.tahun = tbl_pk_eselon2.tahun');
			$this->db->join('tbl_sasaran_eselon2','tbl_sasaran_eselon2.kode_sasaran_e2 = tbl_pk_eselon2.kode_sasaran_e2 and tbl_sasaran_eselon2.tahun = tbl_pk_eselon2.tahun', 'left');
			$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_sasaran_eselon2.kode_sasaran_e1 and tbl_sasaran_eselon1.tahun = tbl_sasaran_eselon2.tahun', 'left');
			$this->db->join('tbl_eselon2', 'tbl_eselon2.kode_e2 = tbl_pk_eselon2.kode_e2', 'left');

			$this->db->order_by("tbl_pk_eselon2.tahun DESC, tbl_pk_eselon2.kode_sasaran_e2 ASC, tbl_pk_eselon2.kode_ikk ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_pk_e2']=$row->id_pk_e2;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['kode_ikk']=$row->kode_ikk;
				$response->rows[$i]['deskripsi_iku_e2']=$row->deskripsi_iku_e2;
				$response->rows[$i]['deskripsi_sasaran_e2']=$row->deskripsi_sasaran_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
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
				$response->rows[$count]['id_pk_e2']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['nama_e2']='';
				$response->rows[$count]['kode_sasaran_e2']='';
				$response->rows[$count]['kode_ikk']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['penetapan']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['deskripsi_iku_e2']='';
				$response->rows[$count]['deskripsi_sasaran_e2']='';
				$response->rows[$count]['nama_e2']='';
		}
		
		return json_encode($response);
		
	}
	
	
	public function GetRecordCount($filtahun=null, $file1, $file2,$filstatus=null){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tbl_pk_eselon2.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_eselon2.kode_e1",$file1);
		}
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("tbl_pk_eselon2.kode_e2",$file2);
		}
		if ($filstatus!=null){
			$this->db->where("tbl_pk_eselon2.status",$filstatus);
		}
		$this->db->select("tbl_pk_eselon2.*, tbl_ikk.deskripsi as deskripsi_iku_e2,tbl_ikk.satuan,tbl_sasaran_eselon2.deskripsi as deskripsi_sasaran_e2,tbl_eselon2.nama_e2",false);		$this->db->from('tbl_pk_eselon2');
		$this->db->join('tbl_ikk', 'tbl_ikk.kode_ikk = tbl_pk_eselon2.kode_ikk and tbl_ikk.tahun = tbl_pk_eselon2.tahun');
		$this->db->join('tbl_sasaran_eselon2','tbl_sasaran_eselon2.kode_sasaran_e2 = tbl_pk_eselon2.kode_sasaran_e2 and tbl_sasaran_eselon2.tahun = tbl_pk_eselon2.tahun');
		$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_sasaran_eselon2.kode_sasaran_e1 and tbl_sasaran_eselon1.tahun = tbl_sasaran_eselon2.tahun', 'left');
		$this->db->join('tbl_eselon2', 'tbl_eselon2.kode_e2 = tbl_pk_eselon2.kode_e2', 'left');
		return $this->db->count_all_results();
		$this->db->free_result();
	}	
	
	
	public function getDetail($tahun, $kode_e2, $kode_sasaran_e2){
		$out = '';
		$i = 1;
		
		# header table
		$header = '	<tr>
						<th bgcolor="#F4F4F4" width="10px">No.</th>
						<th width="100%" bgcolor="#F4F4F4">Indikator Kerja Kegiatan</th>
						<th bgcolor="#F4F4F4" width="100">Target (RKT)</th>
						<th bgcolor="#F4F4F4" width="100">Target (PK)</th>
						<th bgcolor="#F4F4F4">Satuan</th>
					</tr>';
		
		# Ambil Data dari PK
		# -------------------------------------------------------------------------------------
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pk_eselon2 a');
		$this->db->join('tbl_ikk b','a.kode_ikk = b.kode_ikk and a.tahun = b.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e2', $kode_e2);
		$this->db->where('a.kode_sasaran_e2', $kode_sasaran_e2);
		//$this->db->where('a.status !=', '1');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$out .= '<tr>';
					$out .= '<td>'.$i.'<input type="hidden" name="detail['.$i.'][id_pk_e2]" value="'.$row->id_pk_e2.'"></td>';
					$out .= '<td>';
						$out .= '<input type="hidden" name="detail['.$i.'][kode_ikk]" value="'.$row->kode_ikk.'" >';
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
		$this->db->from('tbl_rkt_eselon2 a');
		$this->db->join('tbl_ikk b','a.kode_ikk = b.kode_ikk and a.tahun = b.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e2', $kode_e2);
		$this->db->where('a.kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->where('a.status !=', '1');
		
		$query = $this->db->get();
		
		foreach($query->result() as $row){
			$out .= '<tr>';
				$out .= '<td>'.$i.'<input type="hidden" name="detail['.$i.'][id_pk_e2]" value="0"></td>';
				$out .= '<td>';
					$out .= '<input type="hidden" name=detail['.$i.'][kode_ikk] value="'.$row->kode_ikk.'" >';
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
			return $out .= 'Data RKT Eselon 2 belum tersedia.';
		
		return $header.$out;
		
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as ikk');
		$this->db->from('tbl_pk_eselon2 a');
		$this->db->join('tbl_sasaran_eselon2 b', 'b.kode_sasaran_e2 = a.kode_sasaran_e2');
		$this->db->join('tbl_ikk c', 'c.kode_ikk = a.kode_ikk and c.tahun = a.tahun');
		$this->db->join('tbl_eselon2 d', 'd.kode_e2 = a.kode_e2');
		$this->db->join('tbl_eselon1 e', 'e.kode_e1 = d.kode_e1');
		$this->db->where('a.id_pk_e2', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			
			# jika id_pk_e2 != 0 maka update
			if($dt['id_pk_e2'] != '0'){
				// update target penetapan di tabel PK
				$this->db->flush_cache();
				$this->db->set('penetapan', $dt['penetapan']);
				$this->db->set('log_update', 	$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$this->db->where('id_pk_e2', $dt['id_pk_e2']);
				$this->db->update('tbl_pk_eselon2');
				
			}else{
				//query insert data ke PK
				$this->db->flush_cache();
				$this->db->set('tahun',$data['tahun']);
				$this->db->set('kode_e2',$data['kode_e2']);
				$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
				$this->db->set('kode_ikk',$dt['kode_ikk']);
				$this->db->set('target',$dt['target']);
				$this->db->set('penetapan',$dt['penetapan']);
				$this->db->set('status','0');
				$this->db->set('log_insert', 	$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$result = $this->db->insert('tbl_pk_eselon2');
				
				// update status tabel RKT
				$this->db->flush_cache();
				$this->db->set('status', '1');
				$this->db->where('tahun', $data['tahun']);
				$this->db->where('kode_e2', $data['kode_e2']);
				$this->db->where('kode_sasaran_e2', $data['kode_sasaran_e2']);
				$this->db->where('kode_ikk', $dt['kode_ikk']);
				$this->db->update('tbl_rkt_eselon2');
				
				# insert to log
				$this->db->flush_cache();
				$this->db->set('tahun',$data['tahun']);
				$this->db->set('kode_e2',$data['kode_e2']);
				$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
				$this->db->set('kode_ikk',$dt['kode_ikk']);
				$this->db->set('target',$dt['target']);
				$this->db->set('penetapan',$dt['penetapan']);
				$this->db->set('status','0');
				$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$result = $this->db->insert('tbl_pk_eselon2_log');
				
			}
			
		}
		
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	
	public function UpdateOnDb($data){
		$this->db->flush_cache();
		$this->db->where('id_pk_e2', $data['id_pk_e2']);
		$this->db->set('penetapan', $data['penetapan']);
		$result = $this->db->update('tbl_pk_eselon2', $data);
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_pk_eselon2");
		$this->db->where('id_pk_e2', $data['id_pk_e2']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('kode_e2',			$qt->row()->kode_e2);
			$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
			$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
			$this->db->set('target',			$qt->row()->target);
			$this->db->set('penetapan',			$qt->row()->penetapan);
			$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pk_eselon2_log');
		
		
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
		$this->db->from("tbl_pk_eselon2");
		$this->db->where('id_pk_e2', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('kode_e2',			$qt->row()->kode_e2);
			$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
			$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
			$this->db->set('target',			$qt->row()->target);
			$this->db->set('penetapan',			$qt->row()->penetapan);
			$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pk_eselon2_log');
			
			//ubah status rkt
		$this->db->flush_cache();
				$this->db->set('status', '0');
				$this->db->where('tahun', $qt->row()->tahun);
				$this->db->where('kode_e2',$qt->row()->kode_e2);
				$this->db->where('kode_sasaran_e2', $qt->row()->kode_sasaran_e2);
				$this->db->where('kode_ikk', $qt->row()->kode_ikk);
				$this->db->update('tbl_rkt_eselon2');
		
		$this->db->flush_cache();
		$this->db->where('id_pk_e2', $id);
		$result = $this->db->delete('tbl_pk_eselon2'); 
		
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
		$this->db->from('tbl_pk_eselon2');
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
	
	public function getListTahun($objectId=''){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_pk_eselon2');
		$e2 = $this->session->userdata('unit_kerja_e2');
		if (($e2!="-1")&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
			//$value = $e1;
		}
		$this->db->group_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select id="tahun'.$objectId.'" name="tahun'.$objectId.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Kegiatan PK belum tersedia.";
		}
		
		$out .= '</select>';
		
		echo $out;
	}
}
?>
