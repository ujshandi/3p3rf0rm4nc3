<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/
  
class pengukurankl_model extends CI_Model
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
		
		$count = $this->GetRecordCount();
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  

		$i=0;
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			$this->db->order_by('a.'.$sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("*, b.satuan, a.tahun as tahun2, b.deskripsi AS deskripsi_iku_kl, c.deskripsi AS deskripsi_sasaran_kl");
			$this->db->from('tbl_pengukuran_kl a');
			$this->db->join('tbl_iku_kl b', 'b.kode_iku_kl = a.kode_iku_kl and b.tahun = a.tahun');
			$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl');
			$query = $this->db->get();
			
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_pengukuran_kl']=$row->id_pengukuran_kl;
				$response->rows[$i]['tahun']=$row->tahun2;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['deskripsi_sasaran_kl']=$row->deskripsi_sasaran_kl;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['deskripsi_iku_kl']=$row->deskripsi_iku_kl;
				if(is_numeric($row->realisasi)){
					if(strpos($row->realisasi, '.') || strpos($row->realisasi, ',')){
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 4, ',', '.');
					}else{
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['realisasi'] = $row->realisasi;
				}		
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['persen']=$row->persen;
				$response->rows[$i]['opini']=$row->opini;
				$response->rows[$i]['persetujuan']=$row->persetujuan=='1'?'Ya':'Tidak';
				

				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$i]['id_pengukuran_kl']='';
				$response->rows[$i]['tahun']='';
				$response->rows[$i]['kode_sasaran_kl']='';
				$response->rows[$i]['deskripsi_sasaran_kl']='';
				$response->rows[$i]['kode_iku_kl']='';
				$response->rows[$i]['deskripsi_iku_kl']='';
				$response->rows[$i]['realisasi']='';
				$response->rows[$i]['satuan']='';
				$response->rows[$i]['persen']='';
				$response->rows[$i]['opini']='';
				$response->rows[$i]['persetujuan']='';
		}
		
		return json_encode($response);
		
	}
	
	public function GetRecordCount(){
		$this->db->select("*, b.satuan, a.tahun as tahun2, b.deskripsi AS deskripsi_iku_kl, c.deskripsi AS deskripsi_sasaran_kl");
		$this->db->from('tbl_pengukuran_kl a');
		$this->db->join('tbl_iku_kl b', 'b.kode_iku_kl = a.kode_iku_kl and b.tahun = a.tahun');
		$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl');
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	// combobox
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_kinerja_kl');
		$this->db->group_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select id="tahun'.$objectId.'" name="tahun" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_pengukuran_kl');
		
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

	public function getListKementerian($objectId){
		
		$this->db->flush_cache();
		$this->db->select('kode_kl, nama_kl');
		$this->db->from('tbl_kl');
		$this->db->order_by('kode_kl');
		
		$que = $this->db->get();
		
		$out = '<select id="kode_kl'.$objectId.'" name="kode_kl" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_kl.'">'.$r->nama_kl.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListSasaranKl($objectId){
		
		$this->db->flush_cache();
		$this->db->select('kode_sasaran_kl, deskripsi');
		$this->db->from('tbl_sasaran_kl');
		$this->db->order_by('kode_sasaran_kl');
		
		$que = $this->db->get();
		
		
		$out  = '<select id="kode_sasaran_kl'.$objectId.'" name="kode_sasaran_kl" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true" style="width:750px;">';
		$out .= '<option value="0">-- Pilih --</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_kl.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
		
		/*
		$out = '<input id="kode_sasaran_kl'.$objectId.'" name="kode_sasaran_kl" type="hidden" class="h_code" value="0">';
		$out .= '<textarea id="txtkode_sasaran_kl'.$objectId.'" name="txtkode_sasaran_kl'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran'.$objectId.'(\''.$r->kode_sasaran_kl.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul>';
		
		echo $out;
		*/
	}
	
	public function getDetail($tahun, $kode_kl, $kode_sasaran_kl, $objectId){
		
		// get triwulan terakhir
		$TA = $this->getTriwulanTerakhir($tahun, $kode_kl, $kode_sasaran_kl);
		$statusTA = 'Data Bulan Ke-'.$TA;//$TA<4?'Data belum sampai ke triwulan 4':'';
		
		$this->db->flush_cache();
		$this->db->select('c.deskripsi, c.satuan, b.penetapan, a.realisasi, a.kode_iku_kl');
		$this->db->from('tbl_kinerja_kl a');
		$this->db->join('tbl_pk_kl b','b.tahun = a.tahun AND b.kode_kl = a.kode_kl AND b.kode_sasaran_kl = a.kode_sasaran_kl AND b.kode_iku_kl = a.kode_iku_kl');
		$this->db->join('tbl_iku_kl c', 'c.kode_iku_kl = a.kode_iku_kl and c.tahun = a.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_kl', $kode_kl);
		$this->db->where('a.kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('a.triwulan', $TA);
		
		$query = $this->db->get();
		
		$out = '';
		$i = 0;
		
		$row = $query->result();
		$leng = $query->num_rows();
		$akhir = $leng - 1;
		
		if($leng > 0){
			$out .= '<input name="triwulan" type="hidden" value="'.$TA.'" />';
			for($i=0; $i<$leng; $i++){
			
				$realisasi = $this->getRealisasiLalu(($tahun-1), $kode_kl, $kode_sasaran_kl, $row[$i]->kode_iku_kl);
				
				if ($row[$i]->penetapan != 0) {
					# jika iku/ikk exception
					$exc = $this->isException($tahun, $row[$i]->kode_iku_kl);
					if($exc){
						$_rencana = $row[$i]->penetapan;
						$_realisasi = $row[$i]->realisasi;
						$persentase = round((2 * $_rencana - $_realisasi) / $_rencana * 100, 2);
					}else{
						$persentase = round(($row[$i]->realisasi/$row[$i]->penetapan)*100, 2);
					}
					
				} else {
					$persentase = 0;
				}
				
				$target = ($row[$i]->penetapan!='')?$row[$i]->penetapan:'Data Belum Ditetapkan';
				
				$out .= '<fieldset class="sectionwrap">
									<div class="fitem">
									  <label style="width:170px">Indikator Kerja Utama :</label>
									  <input type="hidden" name="detail['.$i.'][kode_iku_kl]" value="'.$row[$i]->kode_iku_kl.'">
									  '.$row[$i]->deskripsi.'
									</div>
									<div class="fitem">
									  <label style="width:170px">Satuan :</label>
									  '.$row[$i]->satuan.'
									</div>
									<div class="fitem">
									  <label style="width:170px">Target :</label>
									  '.$target.'
									</div>
									<div class="fitem">
									  <label style="width:170px">Realisasi Tahun Sekarang :</label>
									  <input type="hidden" name="detail['.$i.'][realisasi]" value="'.$row[$i]->realisasi.'" size="15">
									  <input type="hidden" name="detail['.$i.'][persen]" value="'.$persentase.'" size="15">
									  '.$row[$i]->realisasi.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  '.$persentase.'&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  '.$statusTA.'
									</div>
									<div class="fitem">
									  <label style="width:170px">Realisasi Tahun Lalu :</label>
									  '.$realisasi[0].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  '.$realisasi[1].'&nbsp;%
									</div>
									<div class="fitem">
									  <label style="width:170px">Opini :</label>
									  <textarea name="detail['.$i.'][opini]" cols="85" class="easyui-validatebox" ></textarea>
									</div>
									<div class="fitem">
									  <label style="width:170px">Persetujuan :</label>
									  <input type="radio" name="detail['.$i.'][persetujuan]" value="1" checked="checked"/>&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input type="radio" name="detail['.$i.'][persetujuan]" value="0" />&nbsp;Tidak&nbsp;&nbsp;
									</div>';
									
				//if($i == $akhir){
					$out .='<br><div class="fitem">';
					$out .= '<label style="width:170px"></label><input type="button" onclick="saveData'.$objectId.'()" value="Simpan" />';
					$out .='</div>';
				//}
				
				//$out .=  $this->getPendukung($kode_sasaran_kl, $row[$i]->kode_iku_kl);
				
				$out .=				'</fieldset>';
			}
		}else{
			//Data realisasi belum tersedia
			$out = '';
		}
		
		
		
		return $out;
	}
	
	// ambil triwulan terakhir dari realisasi
	public function getTriwulanTerakhir($tahun, $kode_kl, $kode_sasaran_kl){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kinerja_kl');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_kl', $kode_kl);
		$this->db->where('kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->order_by('triwulan', 'desc');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->triwulan;
		}else{
			return 0;
		}
		
	}
	
	public function getRealisasiLalu($tahun, $kode_kl, $kode_sasaran_kl, $kode_iku_kl){
		$ret[0]='';
		$ret[1]='';
		
		$this->db->flush_cache();
		/*
		$this->db->select('c.deskripsi, c.satuan, b.penetapan, a.realisasi, a.kode_iku_kl');
		$this->db->from('tbl_kinerja_kl a');
		$this->db->join('tbl_pk_kl b','b.tahun = a.tahun AND b.kode_kl = a.kode_kl AND b.kode_sasaran_kl = a.kode_sasaran_kl AND b.kode_iku_kl = a.kode_iku_kl');
		$this->db->join('tbl_iku_kl c', 'c.kode_iku_kl = a.kode_iku_kl');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_kl', $kode_kl);
		$this->db->where('a.kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('a.kode_iku_kl', $kode_iku_kl);
		*/
		$this->db->select('*');
		$this->db->from('tbl_pengukuran_kl a');
		//$this->db->join('tbl_pk_kl b','b.kode_kl = a.kode_kl AND b.kode_sasaran_kl = a.kode_sasaran_kl AND b.kode_iku_kl = a.kode_iku_kl');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_kl', $kode_kl);
		$this->db->where('a.kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('a.kode_iku_kl', $kode_iku_kl);
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0){
			$ret[0] = $q->row()->realisasi;
			//$ret[1] = round(($ret[0]/$q->row()->penetapan)*100, 2);
			$ret[1] = $q->row()->persen;
		}else{
			$ret[0] = '0';
			$ret[1] = '0';
		}
		
		return $ret;
	}
	
	public function isException($tahun, $kode_iku_kl){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_exception_iku_kl');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_iku_kl', $kode_iku_kl);
		
		$q = $this->db->get();
		
		return ($q->num_rows() > 0?TRUE:FALSE);
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as iku_kl, a.realisasi');
		$this->db->from('tbl_pengukuran_kl a');
		$this->db->join('tbl_sasaran_kl b', 'b.kode_sasaran_kl = a.kode_sasaran_kl');
		$this->db->join('tbl_iku_kl c', 'c.kode_iku_kl = a.kode_iku_kl and c.tahun = a.tahun');
		$this->db->join('tbl_kl d', 'd.kode_kl = a.kode_kl');
		// $this->db->join('tbl_kinerja_kl e', 'e.kode_iku_kl = a.kode_iku_kl and e.tahun = a.tahun');
		// TS
		$this->db->join('tbl_pk_kl e', 'e.kode_iku_kl = a.kode_iku_kl and e.tahun = a.tahun');
		$this->db->where('a.id_pengukuran_kl', $id);
		
		return $this->db->get()->row();
	}
		
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
				//query insert data		
				$this->db->set('tahun',				$data['tahun']);
				$this->db->set('triwulan',			$data['triwulan']);
				$this->db->set('kode_kl',			$data['kode_kl']);
				$this->db->set('kode_sasaran_kl',	$data['kode_sasaran_kl']);
				
				$this->db->set('kode_iku_kl',		$dt['kode_iku_kl']);
				$this->db->set('realisasi',			$dt['realisasi']);
				$this->db->set('persen',			$dt['persen']);
				$this->db->set('opini',				$dt['opini']);
				$this->db->set('persetujuan',		$dt['persetujuan']);
				$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				
				$result = $this->db->insert('tbl_pengukuran_kl');
				
				# insert to log
				$this->db->flush_cache();
				$this->db->set('tahun',				$data['tahun']);
				$this->db->set('triwulan',			$data['triwulan']);
				$this->db->set('kode_kl',			$data['kode_kl']);
				$this->db->set('kode_sasaran_kl',	$data['kode_sasaran_kl']);
				$this->db->set('kode_iku_kl',		$dt['kode_iku_kl']);
				$this->db->set('realisasi',			$dt['realisasi']);
				$this->db->set('persen',			$dt['persen']);
				$this->db->set('opini',				$dt['opini']);
				$this->db->set('persetujuan',		$dt['persetujuan']);
				$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
				$result = $this->db->insert('tbl_pengukuran_kl_log');
				
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
	
	public function UpdateOnDb($data){
		$this->db->flush_cache();
		$this->db->where('id_pengukuran_kl', $data['id_pengukuran_kl']);
		$this->db->set('opini', $data['opini']);
		$this->db->set('persetujuan', $data['persetujuan']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->update('tbl_pengukuran_kl', $data); 
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_pengukuran_kl");
		$this->db->where('id_pengukuran_kl', $data['id_pengukuran_kl']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_kl',			$qt->row()->kode_kl);
			$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
			$this->db->set('kode_iku_kl',		$qt->row()->kode_iku_kl);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('persen',			$qt->row()->persen);
			$this->db->set('opini',				$qt->row()->opini);
			$this->db->set('persetujuan',		$qt->row()->persetujuan);
			$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_kl_log');
		
		
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
		$this->db->from("tbl_pengukuran_kl");
		$this->db->where('id_pengukuran_kl', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_kl',			$qt->row()->kode_kl);
			$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
			$this->db->set('kode_iku_kl',		$qt->row()->kode_iku_kl);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('persen',			$qt->row()->persen);
			$this->db->set('opini',				$qt->row()->opini);
			$this->db->set('persetujuan',		$qt->row()->persetujuan);
			$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_kl_log');
		
		$this->db->flush_cache();
		$this->db->where('id_pengukuran_kl', $id);
		$result = $this->db->delete('tbl_pengukuran_kl'); 
		
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

	public function data_exist($tahun, $triwulan, $kode_kl, $kode_sasaran_kl, $kode_iku_kl){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pengukuran_kl');
		$this->db->where('tahun', $tahun);
		$this->db->where('triwulan', $triwulan);
		$this->db->where('kode_kl', $kode_kl);
		$this->db->where('kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('kode_iku_kl', $kode_iku_kl);
		
		$que = $this->db->get();
		
		if ($que->num_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>
