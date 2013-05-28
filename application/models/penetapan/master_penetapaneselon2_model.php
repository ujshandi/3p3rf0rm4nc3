<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/
  
class Master_penetapaneselon2_model extends CI_Model
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
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_masterpk_eselon2.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1)*$limit;
		
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where('tbl_masterpk_eselon2.tahun', $filtahun);
			}	
			
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit, $offset);
			$this->db->select("distinct *, tbl_masterpk_eselon2.tahun as tahune2", false);
			$this->db->from('tbl_masterpk_eselon2');
			$this->db->join('tbl_kegiatan_kl', 'tbl_kegiatan_kl.kode_kegiatan = tbl_masterpk_eselon2.kode_kegiatan and tbl_kegiatan_kl.tahun = tbl_masterpk_eselon2.tahun');
			$this->db->order_by('tbl_masterpk_eselon2.tahun DESC');
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_masterpk_e2']=$row->id_masterpk_e2;
				$response->rows[$i]['tahun']=$row->tahune2;
				$response->rows[$i]['kode_kegiatan']=$row->kode_kegiatan;
				$response->rows[$i]['nama_kegiatan']=$row->nama_kegiatan;
				$response->rows[$i]['kode_program']=$row->kode_program;
				if(is_numeric($row->total)){
					if(strpos($row->total, '.') || strpos($row->total, ',')){
						$response->rows[$i]['total'] = number_format($row->total, 4, ',', '.');
					}else{
						$response->rows[$i]['total'] = number_format($row->total, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['total'] = $row->total;
				}
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$i++;
			} 
			$query->free_result();
		}else {
				$response->rows[$count]['id_masterpk_e2']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_kegiatan']='';
				$response->rows[$count]['nama_kegiatan']='';
				$response->rows[$count]['kode_program']='';
				$response->rows[$count]['total']='';
				$response->rows[$count]['kode_e2']='';
		}
		
		return json_encode($response);
	}
	
	
	public function GetRecordCount($filtahun=null){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tbl_masterpk_eselon1.tahun",$filtahun);
		}
		
		$this->db->select("distinct *, tbl_masterpk_eselon2.tahun as tahune2", false);
		$this->db->from('tbl_masterpk_eselon2');
		$this->db->join('tbl_kegiatan_kl', 'tbl_kegiatan_kl.kode_kegiatan = tbl_masterpk_eselon2.kode_kegiatan and tbl_kegiatan_kl.tahun = tbl_masterpk_eselon2.tahun');
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	/*public function getDetail($tahun, $kode_kl, $kode_sasaran_kl){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_rkt_kl');
		$this->db->join('tbl_iku_kl','tbl_rkt_kl.kode_iku_kl = tbl_iku_kl.kode_iku_kl and tbl_rkt_kl.tahun = tbl_iku_kl.tahun');
		$this->db->where('tbl_rkt_kl.tahun', $tahun);
		$this->db->where('tbl_rkt_kl.kode_kl', $kode_kl);
		$this->db->where('tbl_rkt_kl.kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('tbl_rkt_kl.status !=', '1');
		
		$query = $this->db->get();
		
		$out = '';
		$i = 1;
		
		foreach($query->result() as $row){
			$out .= '<tr>';
				$out .= '<td>'.$i.'</td>';
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
				
				$out .= '<td>';
					$out .= '<input name=detail['.$i.'][approve] type="checkbox" checked="checked">';
				$out .= '</td>';
				
			$out .= '</tr>';
			
			$i++;
		}
		
		//chan 
		if ($out=="")
			$out .= '<tr><td colspan="5">Data RKT Kementerian belum tersedia.</td></tr>';
				
		return $out;
	}*/
	
	public function InsertOnDB($data) {
		$this->db->flush_cache();
		$this->db->trans_start();
		
		//foreach($data['detail'] as $dt){
			
			//if(isset($data['approve'])){
				
				//query insert data	
				$this->db->set('tahun', $data['tahun']);
				$this->db->set('kode_e2', $data['kode_e2']);
				$this->db->set('kode_kegiatan', $data['kode_kegiatan']);
				
				$result = $this->db->insert('tbl_masterpk_eselon2');
				
				/* update status tabel PK
				$this->db->flush_cache();
				$this->db->set('status', '1');
				$this->db->where('tahun', $data['tahun']);
				$this->db->where('kode_kl', $data['kode_kl']);
				$this->db->where('kode_sasaran_kl', $data['kode_sasaran_kl']);
				$this->db->where('kode_iku_kl', $dt['kode_iku_kl']);
				$this->db->update('tbl_rkt_kl');*/
				
			//}
		//}
		
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	
	public function UpdateOnDb($data, $kode){
		$this->db->flush_cache();
		$this->db->where('id_masterpk_e2', $kode);
		
		$result = $this->db->update('tbl_masterpk_eselon2', $data); 
		
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
		$this->db->flush_cache();
		$this->db->where('id_masterpk_e2', $id);
		$result = $this->db->delete('tbl_masterpk_eselon2'); 
		
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
		$this->db->from('tbl_masterpk_eselon2');
		
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
	
	public function dataCheck($data){
		$this->db->select("*", false);
		$this->db->from('tbl_masterpk_eselon2');
		$this->db->where('kode_e2', $data['kode_e2'])->where('tahun', $data['tahun']);
		$query = $this->db->get();
		
		if ($query->num_rows()==0){
			return false;
		}else{
			return true;
		}
	}
}
?>
