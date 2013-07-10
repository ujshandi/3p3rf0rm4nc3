<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class pengukuraneselon1_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($filtahun=null, $file1=null){		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1);
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
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("a.kode_e1",$file1);
			}
			$this->db->order_by('a.'.$sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select('*, a.kode_e1 as pngukuran_kode_e1, b.kode_iku_e1, a.tahun as tahun2, b.deskripsi AS deskripsi_iku_e1, c.deskripsi AS deskripsi_sasaran_e1');
			$this->db->from('tbl_pengukuran_eselon1 a');
			$this->db->join('tbl_iku_eselon1 b', 'b.kode_iku_e1 = a.kode_iku_e1 and b.tahun = a.tahun');
			$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1 and a.tahun=c.tahun');
			$this->db->order_by("a.tahun DESC, a.kode_sasaran_e1 ASC, a.kode_iku_e1 ASC");
			$query = $this->db->get();
			
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_pengukuran_e1']=$row->id_pengukuran_e1;
				$response->rows[$i]['tahun']=$row->tahun2;
				$response->rows[$i]['kode_e1']=$row->pngukuran_kode_e1;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;
				$response->rows[$i]['deskripsi_sasaran_e1']=$row->deskripsi_sasaran_e1;
				$response->rows[$i]['kode_iku_e1']=$row->kode_iku_e1;
				$response->rows[$i]['deskripsi_iku_e1']=$row->deskripsi_iku_e1;
/*
				if(is_numeric($row->realisasi)){
					if(strpos($row->realisasi, '.') || strpos($row->realisasi, ',')){
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 4, ',', '.');
					}else{
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 0, ',', '.');
					}
				}else{
*/
					$response->rows[$i]['realisasi'] = $this->utility->cekNumericFmt($row->realisasi);
				//}		
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['persen']=$row->persen;
				$response->rows[$i]['opini']=$row->opini;
				$response->rows[$i]['persetujuan']=$row->persetujuan=='1'?'Ya':'Tidak';

				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[0]['id_pengukuran_e1']='';
				$response->rows[0]['tahun']='';
				$response->rows[0]['kode_e1']='';
				$response->rows[0]['kode_sasaran_e1']='';
				$response->rows[0]['deskripsi_sasaran_e1']='';
				$response->rows[0]['kode_iku_e1']='';
				$response->rows[0]['deskripsi_iku_e1']='';
				$response->rows[0]['realisasi']='';
				$response->rows[0]['satuan']='';
				$response->rows[0]['persen']='';
				$response->rows[0]['opini']='';
				$response->rows[0]['persetujuan']='';
		}
		
		return json_encode($response);
		
	}
	
	
	public function GetRecordCount($file1){
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("a.kode_e1",$file1);
		}
		$this->db->select('*, a.kode_e1 as pngukuran_kode_e1, b.kode_iku_e1, a.tahun as tahun2, b.deskripsi AS deskripsi_iku_e1, c.deskripsi AS deskripsi_sasaran_e1');
		$this->db->from('tbl_pengukuran_eselon1 a');
		$this->db->join('tbl_iku_eselon1 b', 'b.kode_iku_e1 = a.kode_iku_e1 and b.tahun = a.tahun');
		$this->db->join('tbl_sasaran_eselon1 c', 'c.kode_sasaran_e1 = a.kode_sasaran_e1');
		$this->db->order_by("a.tahun DESC, a.kode_sasaran_e1 ASC, a.kode_iku_e1 ASC");
			
		return $this->db->count_all_results();
		$this->db->free_result();
	}

		// combobox
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_kinerja_eselon1');
		$e1 = $this->session->userdata('unit_kerja_e1');
		if (($e1!="-1")&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			//$value = $e1;
		}
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
		$this->db->from('tbl_pengukuran_eselon1');
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

	public function getListEselon1($objectId){
		//chan 
		$e1 = $this->session->userdata('unit_kerja_e1');
		
		$this->db->flush_cache();
		$this->db->select('kode_e1, nama_e1');
		$this->db->from('tbl_eselon1');
		$this->db->order_by('kode_e1');
		if (($e1!=-1)&&($e1!=null))
			$this->db->where('kode_e1',$e1);
		$que = $this->db->get();
		
		/*
		$out = '<select id="kode_e1'.$objectId.'" name="kode_e1" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		$out = '<select id="kode_e1'.$objectId.'" name="kode_e1" class="easyui-validatebox" required="true">';
		$out = '<select id="kode_e1'.$objectId.'" name="kode_e1" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		*/
		//chan-------------------------
		if ($this->session->userdata('unit_kerja_e1')!='-1'){
			$disable = false;
			$selectedIdx = $this->session->userdata('unit_kerja_e1');
		}else {
			$disable = false;
			$selectedIdx = "";
		}
		
		$out = '<select id="kode_e1'.$objectId.'"  name="kode_e1" class="easyui-validatebox" required="true" '.($disable?"disabled":"").'>';
		//------------============
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_e1.'" '.($selectedIdx!=""?($this->session->userdata('unit_kerja_e1')==$r->kode_e1?"selected":""):"").'>'.$r->nama_e1.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	//chan : tambah $kode_e1
	public function getListSasaranE1($objectId,$kode_e1=-1){
		
		$this->db->flush_cache();
		$this->db->select('kode_sasaran_e1, deskripsi');
		$this->db->from('tbl_sasaran_eselon1');
		$this->db->where('kode_e1',$kode_e1);
		$this->db->order_by('kode_sasaran_e1');
		
		$que = $this->db->get();
		
		
		$out = '<select id="kode_sasaran_e1'.$objectId.'" name="kode_sasaran_e1" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true" style="width:700px;">';
		$out .= '<option value="0">-- pilih --</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_e1.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		
		/*
		$out = '<input id="kode_sasaran_e1'.$objectId.'" type="hidden" class="h_code" value="0">';
		$out .= '<textarea name="kode_sasaran_e1" class="easyui-validatebox textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran(\''.$r->kode_sasaran_e1.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul>';
		*/
		
		echo $out;
	}
	
	public function getDetail($tahun, $kode_e1, $kode_sasaran_e1, $objectId){
		
		// get triwulan terakhir
		$TA = $this->getTriwulanTerakhir($tahun, $kode_e1, $kode_sasaran_e1);
		$statusTA = 'Data Bulan Ke-'.$TA;//$TA<4?'Data belum sampai ke triwulan 4':'';
		
		$this->db->flush_cache();
		$this->db->select('c.deskripsi, c.satuan, b.penetapan, a.realisasi, a.kode_iku_e1');
		$this->db->from('tbl_kinerja_eselon1 a');
		$this->db->join('tbl_pk_eselon1 b','b.tahun = a.tahun AND b.kode_e1 = a.kode_e1 AND b.kode_sasaran_e1 = a.kode_sasaran_e1 AND b.kode_iku_e1 = a.kode_iku_e1');
		$this->db->join('tbl_iku_eselon1 c', 'c.kode_iku_e1 = a.kode_iku_e1 and c.tahun = a.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e1', $kode_e1);
		$this->db->where('a.kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->where('a.triwulan', $TA);
		
		$query = $this->db->get();
		
		$out = '';
		$i = 0;
		
		$row = $query->result();
		$leng = $query->num_rows();
		$akhir = $leng - 1;
		
		$out .= '<input name="triwulan" type="hidden" value="'.$TA.'" />';
		
		if($leng > 0){
			for($i=0; $i<$leng; $i++){
			
				$realisasi = $this->getRealisasiLalu(($tahun-1), $kode_e1, $kode_sasaran_e1, $row[$i]->kode_iku_e1);
				
				if ($row[$i]->penetapan != 0) {
					# jika iku/ikk exception
					$exc = $this->isException($tahun, $row[$i]->kode_iku_e1);
					if($exc){
						$_rencana = $row[$i]->penetapan;
						$_realisasi = $row[$i]->realisasi;
						$persentase = round((2 * $_rencana - $_realisasi) / $_rencana * 100, 2);
					}else{
						$persentase = round(($row[$i]->realisasi/$row[$i]->penetapan)*100, 2);
					}
					
				}else {
					$persentase = 0;
				}
				
				$target = ($row[$i]->penetapan!='')?$row[$i]->penetapan:'Data Belum Ditetapkan';
							
				$out .= '<fieldset class="sectionwrap">
							<div class="fitem">
								<label style="width:170px">Indikator Kerja Utama :</label>
								<input type="hidden" name="detail['.$i.'][kode_iku_e1]" value="'.$row[$i]->kode_iku_e1.'">
								<span style="display:block;margin-left: 170px;">'.$row[$i]->deskripsi.'</span>
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
			$out = '';
		}
		
		return $out;
		
	}
	
	// ambil triwulan terakhir dari realisasi
	public function getTriwulanTerakhir($tahun, $kode_e1, $kode_sasaran_e1){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kinerja_eselon1');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_e1', $kode_e1);
		$this->db->where('kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->order_by('triwulan', 'desc');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->triwulan;
		}else{
			return 0;
		}
		
	}
	
	public function getRealisasiLalu($tahun, $kode_e1, $kode_sasaran_e1, $kode_iku_e1){
		$ret[0]='';
		$ret[1]='';
		
		
		$this->db->flush_cache();
		/*
		$this->db->select('c.deskripsi, c.satuan, b.penetapan, a.realisasi, a.kode_iku_e1');
		$this->db->from('tbl_kinerja_eselon1 a');
		$this->db->join('tbl_pk_eselon1 b','b.tahun = a.tahun AND b.kode_e1 = a.kode_e1 AND b.kode_sasaran_e1 = a.kode_sasaran_e1 AND b.kode_iku_e1 = a.kode_iku_e1');
		$this->db->join('tbl_iku_eselon1 c', 'c.kode_iku_e1 = a.kode_iku_e1');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e1', $kode_e1);
		$this->db->where('a.kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->where('a.kode_iku_e1', $kode_iku_e1);
		*/
		$this->db->select('*');
		$this->db->from('tbl_pengukuran_eselon1 a');
		//$this->db->join('tbl_pk_eselon1 b','b.kode_e1 = a.kode_e1 AND b.kode_sasaran_e1 = a.kode_sasaran_e1 AND b.kode_iku_e1 = a.kode_iku_e1');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e1', $kode_e1);
		$this->db->where('a.kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->where('a.kode_iku_e1', $kode_iku_e1);
		
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
	
	public function isException($tahun, $kode_iku_e1){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_exception_iku_eselon1');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_iku_e1', $kode_iku_e1);
		
		$q = $this->db->get();
		
		return ($q->num_rows() > 0?TRUE:FALSE);
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as iku_e1, a.realisasi');
		$this->db->from('tbl_pengukuran_eselon1 a');
		$this->db->join('tbl_sasaran_eselon1 b', 'b.kode_sasaran_e1 = a.kode_sasaran_e1');
		$this->db->join('tbl_iku_eselon1 c', 'c.kode_iku_e1 = a.kode_iku_e1 and c.tahun = a.tahun');
		$this->db->join('tbl_eselon1 d', 'd.kode_e1 = a.kode_e1');
		// TS
		$this->db->join('tbl_pk_eselon1 e', 'e.kode_iku_e1 = a.kode_iku_e1 and e.tahun = e.tahun');
		//$this->db->join('tbl_kinerja_eselon1 e', 'e.kode_iku_e1 = a.kode_iku_e1 and e.tahun = e.tahun');
		$this->db->where('a.id_pengukuran_e1', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			//query insert data		
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('triwulan',			$data['triwulan']);
			$this->db->set('kode_e1',			$data['kode_e1']);
			$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);
			
			$this->db->set('kode_iku_e1',		$dt['kode_iku_e1']);
			$this->db->set('realisasi',			$dt['realisasi']);
			$this->db->set('persen',			$dt['persen']);
			$this->db->set('opini',				$dt['opini']);
			$this->db->set('persetujuan',		$dt['persetujuan']);
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			
			$result = $this->db->insert('tbl_pengukuran_eselon1');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('triwulan',			$data['triwulan']);
			$this->db->set('kode_e1',			$data['kode_e1']);
			$this->db->set('kode_sasaran_e1',	$data['kode_sasaran_e1']);
			$this->db->set('kode_iku_e1',		$dt['kode_iku_e1']);
			$this->db->set('realisasi',			$dt['realisasi']);
			$this->db->set('persen',			$dt['persen']);
			$this->db->set('opini',				$dt['opini']);
			$this->db->set('persetujuan',		$dt['persetujuan']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_eselon1_log');
			
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
		$this->db->where('id_pengukuran_e1', $data['id_pengukuran_e1']);
		$this->db->set('opini', $data['opini']);
		$this->db->set('persetujuan', $data['persetujuan']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->update('tbl_pengukuran_eselon1', $data); 
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_pengukuran_eselon1");
		$this->db->where('id_pengukuran_e1', $data['id_pengukuran_e1']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e1',			$qt->row()->kode_e1);
			$this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
			$this->db->set('kode_iku_e1',		$qt->row()->kode_iku_e1);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('persen',			$qt->row()->persen);
			$this->db->set('opini',				$qt->row()->opini);
			$this->db->set('persetujuan',		$qt->row()->persetujuan);
			$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_eselon1_log');
		
		
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
		$this->db->from("tbl_pengukuran_eselon1");
		$this->db->where('id_pengukuran_e1', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e1',			$qt->row()->kode_e1);
			$this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
			$this->db->set('kode_iku_e1',		$qt->row()->kode_iku_e1);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('persen',			$qt->row()->persen);
			$this->db->set('opini',				$qt->row()->opini);
			$this->db->set('persetujuan',		$qt->row()->persetujuan);
			$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_eselon1_log');
		
		$this->db->flush_cache();
		$this->db->where('id_pengukuran_e1', $id);
		$result = $this->db->delete('tbl_pengukuran_eselon1'); 
		
		
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
	
	public function data_exist($tahun, $triwulan, $kode_e1, $kode_sasaran_e1, $kode_iku_e1){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pengukuran_eselon1');
		$this->db->where('tahun', $tahun);
		$this->db->where('triwulan', $triwulan);
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
