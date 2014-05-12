<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class pengukuraneselon2_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($filtahun=null, $file1=null, $file2=null,$filbulan=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun,$file1, $file2,$filbulan);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
			if($filbulan!= '' && $filbulan!= '-1' && $filbulan!= null) {
				$this->db->where("a.triwulan",$filbulan);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("e.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("a.kode_e2",$file2);
			}
			$this->db->order_by('a.'.$sort." ".$order );
			$this->db->limit($limit,$offset);
			
			$this->db->select("*, b.satuan, a.tahun as tahun2, b.deskripsi AS deskripsi_ikk, c.deskripsi AS deskripsi_sasaran_e2");
			$this->db->from('tbl_pengukuran_eselon2 a');
			$this->db->join('tbl_ikk b', 'b.kode_ikk = a.kode_ikk and b.tahun = a.tahun');
			$this->db->join('tbl_sasaran_eselon2 c','c.kode_sasaran_e2 = a.kode_sasaran_e2 and c.tahun=a.tahun', 'left');
			$this->db->join('tbl_sasaran_eselon1 d', 'd.kode_sasaran_e1 = c.kode_sasaran_e1 and d.tahun=a.tahun', 'left');
			$this->db->join('tbl_eselon2 e', 'e.kode_e2 = a.kode_e2', 'left');		
			$this->db->order_by("a.tahun DESC, a.kode_sasaran_e2 ASC, a.kode_ikk ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_pengukuran_e2']=$row->id_pengukuran_e2;
				$response->rows[$i]['tahun']=$row->tahun2;
				$response->rows[$i]['triwulan']=$this->utility->getBulanValue($row->triwulan-1);
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['kode_ikk']=$row->kode_ikk;
				$response->rows[$i]['deskripsi_sasaran_e2']=$row->deskripsi_sasaran_e2;
				$response->rows[$i]['deskripsi_ikk']=$row->deskripsi_ikk;
				/* if(is_numeric($row->realisasi)){
					if(strpos($row->realisasi, '.') || strpos($row->realisasi, ',')){
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 4, ',', '.');
					}else{
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['realisasi'] = $row->realisasi;
				}		 */
				$response->rows[$i]['realisasi'] = $this->utility->cekNumericFmt($row->realisasi);
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['persen']=$row->persen;
				$response->rows[$i]['opini']=$row->opini;
				$response->rows[$i]['persetujuan']=$row->persetujuan=='1'?'Ya':'Tidak';

				$i++;
			} 
			
			$query->free_result();
		}else {				
				$response->rows[0]['id_pengukuran_e2']='';
				$response->rows[0]['tahun']='';
				$response->rows[0]['triwulan']='';
				$response->rows[0]['kode_sasaran_e2']='';
				$response->rows[0]['kode_ikk']='';
				$response->rows[0]['realisasi']='';
				$response->rows[0]['satuan']='';
				$response->rows[0]['persen']='';
				$response->rows[0]['opini']='';
				$response->rows[0]['persetujuan']='';
		}
		
		return json_encode($response);
		
	}
	
	
	public function GetRecordCount($filtahun,$file1, $file2,$filbulan){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}
		if($filbulan!= '' && $filbulan!= '-1' && $filbulan!= null) {
			$this->db->where("a.triwulan",$filbulan);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("e.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("a.kode_e2",$file2);
			}
		
		$this->db->select("*, b.satuan, a.tahun as tahun2, b.deskripsi AS deskripsi_ikk, c.deskripsi AS deskripsi_sasaran_e2");
		$this->db->from('tbl_pengukuran_eselon2 a');
		$this->db->join('tbl_ikk b', 'b.kode_ikk = a.kode_ikk and b.tahun = a.tahun');
		$this->db->join('tbl_sasaran_eselon2 c','c.kode_sasaran_e2 = a.kode_sasaran_e2 and a.tahun=c.tahun', 'left');
		$this->db->join('tbl_sasaran_eselon1 d', 'd.kode_sasaran_e1 = c.kode_sasaran_e1 and d.tahun=a.tahun', 'left');
		$this->db->join('tbl_eselon2 e', 'e.kode_e2 = a.kode_e2', 'left');		
		
		$this->db->order_by("a.tahun DESC, a.kode_sasaran_e2 ASC, a.kode_ikk ASC");
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
		// combobox
	public function getListTahun($objectId){
		
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
		
		$out = '<select id="tahun'.$objectId.'" name="tahun" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		$out .= '</select>';
		//chan
		if ($que->num_rows()==0){
			$out = 'Data PK belum tersedia.';
		}
		
		echo $out;
	}
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_pengukuran_eselon2');
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

	public function getListEselon2($objectId,$e1=-1){
		
		$this->db->flush_cache();
		$this->db->select('kode_e2, nama_e2');
		$this->db->from('tbl_eselon2');
		$this->db->order_by('kode_e2');
		
		$que = $this->db->get();
		
		//$out = '<select id="kode_e2'.$objectId.'" name="kode_e2" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		
		//chan-------------------------
		if ($this->session->userdata('unit_kerja_e2')!='-1'){
			$disable = true;
			$selectedIdx = $this->session->userdata('unit_kerja_e2');
		}else {
			$disable = false;
			$selectedIdx = "";
		}
		$out = '<select id="kode_e2'.$objectId.'" name="kode_e2" required="true" '.($disable?"disabled":"").'>';
		
		foreach($que->result() as $r){
			//$out .= '<option value="'.$r->kode_e2.'">'.$r->nama_e2.'</option>';
			$out .= '<option value="'.$r->kode_e2.'" '.($selectedIdx!=""?($this->session->userdata('unit_kerja_e2')==$r->kode_e2?"selected":""):"").'>'.$r->nama_e2.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListsatker($objectId){
		
		$this->db->flush_cache();
		$this->db->select('kode_e2, nama_satker');
		$this->db->from('tbl_satker');
		$this->db->order_by('kode_e2');
		
		$que = $this->db->get();
		
		$out = '<select id="kode_e2'.$objectId.'" name="kode_e2" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_e2.'">'.$r->nama_satker.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListSasaranE2($objectId,$kode_e2=-1){
		
		$this->db->flush_cache();
		$this->db->select('kode_sasaran_e2, deskripsi');
		$this->db->from('tbl_sasaran_eselon2');
		$this->db->order_by('kode_sasaran_e2');
		$this->db->where('kode_e2',$kode_e2);
		$que = $this->db->get();
		
	/*CHAN	$out = '<select id="kode_sasaran_e2'.$objectId.'" name="kode_sasaran_e2" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true" style="width:700px;">';
		$out .= '<option value="0">-- pilih --</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_e2.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		*/
		
		$out = '<input id="kode_sasaran_e2'.$objectId.'" name="kode_sasaran_e2" type="hidden" class="h_code" value="0">';
		$out .= '<textarea id="txtkode_sasaran_e2'.$objectId.'" name="txtkode_sasaran_e2'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setPKE2'.$objectId.'(\''.$r->kode_sasaran_e2.'\')">'.$r->kode_sasaran_e2.' : '.$r->deskripsi.'</li>';
		}
		$out .= '</ul>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Eselon 2 untuk tingkat Eselon ini belum tersedia.";
		}
		
		
		echo $out;
	}
	
	
	//public function getDetail($tahun, $kode_e2, $kode_sasaran_e2, $objectId){
	public function getDetail($tahun, $kode_e2, $kode_sasaran_e2, $objectId){
		
		// get triwulan terakhir
		$TA = $this->getTriwulanTerakhir($tahun, $kode_e2, $kode_sasaran_e2);
		$statusTA = 'Data Bulan Ke-'.$TA;//$TA<4?'Data belum sampai ke triwulan 4':'';
		
		$this->db->flush_cache();
		$this->db->select('c.deskripsi, c.satuan, b.penetapan, a.realisasi, a.kode_ikk');
		$this->db->from('tbl_kinerja_eselon2 a');
		$this->db->join('tbl_pk_eselon2 b','b.tahun = a.tahun AND b.kode_e2 = a.kode_e2 AND b.kode_sasaran_e2 = a.kode_sasaran_e2 AND b.kode_ikk = a.kode_ikk');
		$this->db->join('tbl_ikk c', 'c.kode_ikk = a.kode_ikk and c.tahun = a.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e2', $kode_e2);
		$this->db->where('a.kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->where('a.triwulan', $TA);
		
		$query = $this->db->get();
		
		$out = '';
		$i = 0;
		
		$row = $query->result();
		$leng = $query->num_rows();
		$akhir = $leng - 1;
		
	//jang naon?????	$out .= '<input name="triwulan" type="hidden" value="'.$TA.'" />';
		
		if($leng > 0){
			for($i=0; $i<$leng; $i++){
			
				$realisasi = $this->getRealisasiLalu(($tahun-1), $kode_e2, $kode_sasaran_e2, $row[$i]->kode_ikk);
				
				if ($row[$i]->penetapan != 0) {
					# jika iku/ikk exception
					$exc = $this->isException($tahun, $row[$i]->kode_ikk);
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
									  <label style="width:170px">Indikator Kinerja Kegiatan :</label>
									  <input type="hidden" name="detail['.$i.'][kode_ikk]" value="'.$row[$i]->kode_ikk.'">
									  <span style="display:block;margin-left: 170px;">'.$row[$i]->deskripsi.'</span>
									</div>
									<div class="fitem">
									  <label style="width:170px">Satuan :</label>
									  '.$row[$i]->satuan.'
									</div>
									<div class="fitem">
									  <label style="width:170px">Target :</label>
									  '.$this->utility->cekNumericFmt($target).'
									</div>
									<div class="fitem">
									  <label style="width:170px">Realisasi Tahun Sekarang :</label>
									  <input type="hidden" name="detail['.$i.'][realisasi]" value="'.$row[$i]->realisasi.'" size="15">
									  <input type="hidden" name="detail['.$i.'][persen]" value="'.$persentase.'" size="15">
									  '.$this->utility->cekNumericFmt($row[$i]->realisasi).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  '.$persentase.'&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  '.$statusTA.'
									</div>
									<div class="fitem">
									  <label style="width:170px">Realisasi Tahun Lalu :</label>
									  '.$this->utility->cekNumericFmt($realisasi[0]).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  '.$realisasi[1].'&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</div>
									<div class="fitem">
									  <label style="width:170px">Analisis :</label>
									  <textarea name="detail['.$i.'][opini]" cols="85" class="easyui-validatebox" ></textarea>
									</div>
									<div class="fitem">
									  <label style="width:170px">Persetujuan :</label>
									  <input type="radio" name="detail['.$i.'][persetujuan]" value="1" checked="checked"/>&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <input type="radio" name="detail['.$i.'][persetujuan]" value="0" />&nbsp;Tidak&nbsp;&nbsp;
									</div>';
									
				//if($i == $akhir){
					$out .='<br><div class="fitem">';
					$out .= '<label style="width:170px"></label><input type="button" onclick="saveData'.$objectId.'()" value="Save" /><label style="width:170px"></label><input type="button" onclick="cancel'.$objectId.'()" value="Cancel" />';
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
	public function getTriwulanTerakhir($tahun, $kode_e2, $kode_sasaran_e2){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kinerja_eselon2');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_e2', $kode_e2);
		$this->db->where('kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->order_by('triwulan', 'desc');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->row()->triwulan;
		}else{
			return 0;
		}
		
	}
	
	public function getRealisasiLalu($tahun, $kode_e2, $kode_sasaran_e2, $kode_ikk){
		$ret[0]='';
		$ret[1]='';
		
		$this->db->flush_cache();
		/*
		$this->db->select('c.deskripsi, c.satuan, b.penetapan, a.realisasi, a.kode_ikk');
		$this->db->from('tbl_kinerja_eselon2 a');
		$this->db->join('tbl_pk_eselon2 b','b.tahun = a.tahun AND b.kode_e2 = a.kode_e2 AND b.kode_sasaran_e2 = a.kode_sasaran_e2 AND b.kode_ikk = a.kode_ikk');
		$this->db->join('tbl_ikk c', 'c.kode_ikk = a.kode_ikk');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e2', $kode_e2);
		$this->db->where('a.kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->where('a.kode_ikk', $kode_ikk);
		*/
		$this->db->select('*');
		$this->db->from('tbl_pengukuran_eselon2 a');
		//$this->db->join('tbl_pk_eselon2 b','b.kode_e2 = a.kode_e2 AND b.kode_sasaran_e2 = a.kode_sasaran_e2 AND b.kode_ikk = a.kode_ikk');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e2', $kode_e2);
		$this->db->where('a.kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->where('a.kode_ikk', $kode_ikk);
		
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
	
	public function isException($tahun, $kode_ikk){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_exception_ikk');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_ikk', $kode_ikk);
		
		$q = $this->db->get();
		
		return ($q->num_rows() > 0?TRUE:FALSE);
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as ikk, a.realisasi, a.opini, a.persetujuan');
		$this->db->from('tbl_pengukuran_eselon2 a');
		$this->db->join('tbl_sasaran_eselon2 b', 'b.kode_sasaran_e2 = a.kode_sasaran_e2 and a.tahun=b.tahun');
		$this->db->join('tbl_ikk c', 'c.kode_ikk = a.kode_ikk and c.tahun = a.tahun');
		$this->db->join('tbl_eselon2 d', 'd.kode_e2 = a.kode_e2');
		$this->db->join('tbl_eselon1 e', 'e.kode_e1 = d.kode_e1');
		// TS
		$this->db->join('tbl_pk_eselon2 f', 'f.kode_ikk = a.kode_ikk and f.tahun = a.tahun');
		//$this->db->join('tbl_kinerja_eselon2 f', 'f.kode_ikk = a.kode_ikk and f.tahun = f.tahun', 'f.kode_ikk = a.kode_ikk and f.target = f.target');
		$this->db->where('a.id_pengukuran_e2', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			//query insert data		
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',			$data['triwulan']);
			$this->db->set('kode_e2',			$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
			
			$this->db->set('kode_ikk',$dt['kode_ikk']);
			$this->db->set('realisasi',$dt['realisasi']);
			$this->db->set('persen',$dt['persen']);
			$this->db->set('opini',$dt['opini']);
			$this->db->set('persetujuan',$dt['persetujuan']);
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			
			$result = $this->db->insert('tbl_pengukuran_eselon2');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',			$data['triwulan']);
			$this->db->set('kode_e2',			$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
			$this->db->set('kode_ikk',$dt['kode_ikk']);
			$this->db->set('realisasi',$dt['realisasi']);
			$this->db->set('persen',$dt['persen']);
			$this->db->set('opini',$dt['opini']);
			$this->db->set('persetujuan',$dt['persetujuan']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_eselon2_log');
			
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
		$this->db->where('id_pengukuran_e2', $data['id_pengukuran_e2']);
		$this->db->set('opini', $data['opini']);
		$this->db->set('persetujuan', $data['persetujuan']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->update('tbl_pengukuran_eselon2', $data); 
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_pengukuran_eselon2");
		$this->db->where('id_pengukuran_e2', $data['id_pengukuran_e2']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e2',			$qt->row()->kode_e2);
			$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
			$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('persen',			$qt->row()->persen);
			$this->db->set('opini',				$qt->row()->opini);
			$this->db->set('persetujuan',		$qt->row()->persetujuan);
			$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_eselon2_log');
		
		
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
		$this->db->from("tbl_pengukuran_eselon2");
		$this->db->where('id_pengukuran_e2', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e2',			$qt->row()->kode_e2);
			$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
			$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('persen',			$qt->row()->persen);
			$this->db->set('opini',				$qt->row()->opini);
			$this->db->set('persetujuan',		$qt->row()->persetujuan);
			$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_pengukuran_eselon2_log');
		
		$this->db->flush_cache();
		$this->db->where('id_pengukuran_e2', $id);
		$result = $this->db->delete('tbl_pengukuran_eselon2'); 
		
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
	
	public function data_exist($tahun, $triwulan, $kode_e2, $kode_sasaran_e2, $kode_ikk){
		//var_dump($tahun."=".$triwulan."=".$kode_e2."=".$kode_sasaran_e2."=".$kode_ikk);
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pengukuran_eselon2');
		$this->db->where('tahun', $tahun);
		$this->db->where('triwulan', $triwulan);
		$this->db->where('kode_e2', $kode_e2);
		$this->db->where('kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->where('kode_ikk', $kode_ikk);
		
		$que = $this->db->get();
		//var_dump($que);die;
		if ($que->num_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>
