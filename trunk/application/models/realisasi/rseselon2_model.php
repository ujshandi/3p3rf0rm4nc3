<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class rseselon2_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($filtahun=null, $file1=null, $file2=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1, $file2);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_pk_eselon2.tahun",$filtahun);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_eselon2.kode_e1",$file1);
			}
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("tbl_kinerja_eselon2.kode_e2",$file2);
			}
			
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("tbl_kinerja_eselon2.id_kinerja_e2, tbl_kinerja_eselon2.tahun, tbl_kinerja_eselon2.triwulan, tbl_kinerja_eselon2.kode_e2, tbl_kinerja_eselon2.kode_sasaran_e2, tbl_kinerja_eselon2.kode_ikk, tbl_pk_eselon2.penetapan, tbl_ikk.satuan, tbl_kinerja_eselon2.realisasi, tbl_eselon2.nama_e2, tbl_sasaran_eselon2.deskripsi AS deskripsi_sasaran_e2, tbl_ikk.deskripsi AS deskripsi_ikk");
			$this->db->from('tbl_kinerja_eselon2');
			$this->db->join('tbl_pk_eselon2', 'tbl_kinerja_eselon2.kode_ikk = tbl_pk_eselon2.kode_ikk');
			$this->db->join('tbl_ikk', 'tbl_ikk.kode_ikk = tbl_kinerja_eselon2.kode_ikk and tbl_ikk.tahun = tbl_kinerja_eselon2.tahun');
			$this->db->join('tbl_sasaran_eselon2','tbl_sasaran_eselon2.kode_sasaran_e2 = tbl_kinerja_eselon2.kode_sasaran_e2 and tbl_sasaran_eselon2.tahun = tbl_kinerja_eselon2.tahun', 'left');
			$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_sasaran_eselon2.kode_sasaran_e1 and tbl_sasaran_eselon1.tahun = tbl_sasaran_eselon2.tahun', 'left');
			$this->db->join('tbl_eselon2', 'tbl_eselon2.kode_e2 = tbl_kinerja_eselon2.kode_e2', 'left');
			$this->db->order_by("tbl_kinerja_eselon2.tahun DESC, triwulan ASC, kode_sasaran_e2 ASC, tbl_kinerja_eselon2.kode_ikk ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_kinerja_e2']=$row->id_kinerja_e2;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['triwulan']=$this->utility->getBulanValue($row->triwulan-1);
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['kode_sasaran_e2']=$row->kode_sasaran_e2;
				$response->rows[$i]['deskripsi_sasaran_e2']=$row->deskripsi_sasaran_e2;
				$response->rows[$i]['kode_ikk']=$row->kode_ikk;
				$response->rows[$i]['deskripsi_ikk']=$row->deskripsi_ikk;
/*
				if(is_numeric($row->penetapan)){
					if(strpos($row->penetapan, '.') || strpos($row->penetapan, ',')){
						$response->rows[$i]['target'] = number_format($row->penetapan, 4, ',', '.');
					}else{
						$response->rows[$i]['target'] = number_format($row->penetapan, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['target'] = $row->penetapan;
				}
*/
				$response->rows[$i]['target']=$this->utility->cekNumericFmt($row->penetapan);
				$response->rows[$i]['satuan']=$row->satuan;
/*
				if(is_numeric($row->realisasi)){
					if(strpos($row->realisasi, '.') || strpos($row->realisasi, ',')){
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 4, ',', '.');
					}else{
						$response->rows[$i]['realisasi'] = number_format($row->realisasi, 0, ',', '.');
					}
				}else{
					$response->rows[$i]['realisasi'] = $row->realisasi;
				}						
*/
				$response->rows[$i]['realisasi']=$this->utility->cekNumericFmt($row->realisasi);
				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$count]['id_kinerja_e2']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['triwulan']='';
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['nama_e2']='';
				$response->rows[$count]['kode_sasaran_e2']='';
				$response->rows[$count]['deskripsi_sasaran_e2']='';
				$response->rows[$count]['kode_ikk']='';
				$response->rows[$count]['deskripsi_ikk']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['realisasi']='';
				
		}
		
		return json_encode($response);
		
	}
	
	
	public function GetRecordCount($file1, $file2){
	if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("tbl_eselon2.kode_e1",$file1);
		}
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("tbl_pk_eselon2.kode_e2",$file2);
		}
		
		$this->db->select("tbl_kinerja_eselon2.id_kinerja_e2, tbl_kinerja_eselon2.tahun, tbl_kinerja_eselon2.triwulan, tbl_kinerja_eselon2.kode_e2, tbl_kinerja_eselon2.kode_sasaran_e2, tbl_kinerja_eselon2.kode_ikk, tbl_pk_eselon2.penetapan, tbl_ikk.satuan, tbl_kinerja_eselon2.realisasi, tbl_eselon2.nama_e2, tbl_sasaran_eselon2.deskripsi AS deskripsi_sasaran_e2, tbl_ikk.deskripsi AS deskripsi_ikk");
			$this->db->from('tbl_kinerja_eselon2');
			$this->db->join('tbl_pk_eselon2', 'tbl_kinerja_eselon2.kode_ikk = tbl_pk_eselon2.kode_ikk');
			$this->db->join('tbl_ikk', 'tbl_ikk.kode_ikk = tbl_kinerja_eselon2.kode_ikk and tbl_ikk.tahun = tbl_kinerja_eselon2.tahun');
			$this->db->join('tbl_sasaran_eselon2','tbl_sasaran_eselon2.kode_sasaran_e2 = tbl_kinerja_eselon2.kode_sasaran_e2 and tbl_sasaran_eselon2.tahun = tbl_kinerja_eselon2.tahun', 'left');
			$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_sasaran_eselon2.kode_sasaran_e1 and tbl_sasaran_eselon1.tahun = tbl_sasaran_eselon2.tahun', 'left');
			$this->db->join('tbl_eselon2', 'tbl_eselon2.kode_e2 = tbl_kinerja_eselon2.kode_e2', 'left');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
		// combobox
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_pk_eselon2');
		$this->db->group_by('tahun');
		$e2 = $this->session->userdata('unit_kerja_e2');
		if (($e2!="-1")&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
			//$value = $e1;
		}
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

	public function getListEselon2($objectId,$e1=-1){
		
		$this->db->flush_cache();
		$this->db->select('kode_e2, nama_e2');
		$this->db->from('tbl_eselon2');
		$this->db->order_by('kode_e2');
		
		$que = $this->db->get();
		
		$out = '<select id="kode_e2'.$objectId.'" name="kode_e2" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		
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
		
		$out = '<div id="tcContainer"><input id="kode_sasaran_e2'.$objectId.'" name="kode_sasaran_e2" type="hidden" class="h_code" value="0">';
		$out .= '<textarea id="txtkode_sasaran_e2'.$objectId.'" name="txtkode_sasaran_e2'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setPKE2'.$objectId.'(\''.$r->kode_sasaran_e2.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Eselon 2 untuk tingkat Eselon ini belum tersedia.";
		}
		
		
		echo $out;
	}
	
	//public function getDetail($tahun, $kode_e2, $kode_sasaran_e2, $objectId){
	public function getDetail($tahun, $triwulan, $kode_e2, $kode_sasaran_e2, $objectId){
		$this->db->flush_cache();
		$this->db->select('tbl_pk_eselon2.tahun, tbl_pk_eselon2.kode_e2, tbl_pk_eselon2.kode_sasaran_e2, tbl_pk_eselon2.kode_ikk, tbl_ikk.satuan, tbl_pk_eselon2.penetapan, tbl_ikk.deskripsi');
		$this->db->from('tbl_pk_eselon2');
		$this->db->join('tbl_ikk','tbl_pk_eselon2.kode_ikk = tbl_ikk.kode_ikk and tbl_pk_eselon2.tahun = tbl_ikk.tahun');
		$this->db->where('tbl_pk_eselon2.tahun', $tahun);
		$this->db->where('tbl_pk_eselon2.kode_e2', $kode_e2);
		$this->db->where('tbl_pk_eselon2.kode_sasaran_e2', $kode_sasaran_e2);
		
		$query = $this->db->get();
		
		$out = '';
		$i = 0;
		
		$row = $query->result();
		$leng = $query->num_rows();
		$akhir = $leng - 1;
		
		for($i=0; $i<$leng; $i++){
			
			$capaian = $this->getCapaian($tahun, ($triwulan-1), $kode_sasaran_e2, $row[$i]->kode_ikk);
			
			$out .= '<fieldset class="sectionwrap">
								<div class="fitem">
								  <label style="width:150px">Indikator Kinerja Kegiatan :</label>
								  <input type="hidden" name=detail['.$i.'][kode_ikk] value="'.$row[$i]->kode_ikk.'">
								  '.$row[$i]->deskripsi.'
								</div>
								<div class="fitem">
								  <label style="width:150px">Satuan :</label>
								  '.$row[$i]->satuan.'
								</div>
								<div class="fitem">
								  <label style="width:150px">Target :</label>
								  '.$row[$i]->penetapan.'
								</div>
								<div class="fitem">
								  <label style="width:150px">Capaian s.d. Bulan Lalu :</label>
								  <input type="hidden" name=detail['.$i.'][capaian] value="'.$capaian[0].'">
								  <label style="min-width:25px">'.$capaian[0].'</label>&nbsp;&nbsp;&nbsp;&nbsp;
								  <label style="text-align:right; width:10px">('.round($capaian[1], 2).'%)</label>
								</div>
								<div class="fitem">
								  <label style="width:150px">Realisasi Bulan Ini :</label>
								  <input name=detail['.$i.'][realisasi] value="" size="15">
								</div>';
			//if($i == $akhir){
				$out .='<br><div class="fitem">';
				$out .= '<label style="width:150px"></label><input type="button" onclick="saveData'.$objectId.'()" value="Simpan" />';
				$out .='</div>';
			//}
			
			//$out .=  $this->getPendukung($tahun, $kode_e2, $kode_sasaran_e2, $row[$i]->kode_ikk);
			
			$out .=				'</fieldset>';
		}
		
		return $out;
	}
	
	private function getCapaian($tahun, $triwulan, $kode_sasaran_e2, $kode_ikk){
		$q = '';
		$q .= ' SELECT tbl_kinerja_eselon2.id_kinerja_e2, tbl_kinerja_eselon2.tahun, tbl_kinerja_eselon2.triwulan, tbl_kinerja_eselon2.kode_e2, tbl_kinerja_eselon2.kode_sasaran_e2, tbl_kinerja_eselon2.kode_ikk, tbl_kinerja_eselon2.realisasi, tbl_pk_eselon2.penetapan';
		$q .= ' FROM `tbl_kinerja_eselon2` ';
		$q .= ' left join tbl_pk_eselon2 on tbl_kinerja_eselon2.kode_sasaran_e2 = tbl_pk_eselon2.kode_sasaran_e2 and tbl_kinerja_eselon2.kode_ikk = tbl_pk_eselon2.kode_ikk and tbl_kinerja_eselon2.tahun = tbl_pk_eselon2.tahun';
		$q .= " WHERE tbl_kinerja_eselon2.tahun = '$tahun' AND";
		$q .= " tbl_kinerja_eselon2.triwulan = '$triwulan' AND";
		$q .= " tbl_kinerja_eselon2.kode_sasaran_e2 = '$kode_sasaran_e2' AND";
		$q .= " tbl_kinerja_eselon2.kode_ikk = '$kode_ikk'";
		
		$result = $this->db->query($q);
		
		$dt[0] = 0;
		$dt[1] = 0;
		
		if ($result->num_rows() > 0){
			$dt[0] = $result->row()->realisasi;
			$dt[1] = ($dt[0]/$result->row()->penetapan)*100;
		}else{
			$dt[0] = 0;
			$dt[1] = 0;
		}
		
		return $dt;
	}
	
	private function getPendukung($tahun, $kode_e2, $kode_sasaran_e2, $kode_ikk){
		$out2 = '';
		$i = 1;
		
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pk_eselon2 a');
		$this->db->join('tbl_masterpk_eselon2 b', 'b.kode_e2 = a.kode_e2');
		$this->db->join('tbl_subkegiatan_kl c', 'c.kode_kegiatan = b.kode_kegiatan');
		$this->db->join('tbl_realisasi_subkegiatan d', 'd.kode_subkegiatan = c.kode_subkegiatan');
		$this->db->join('tbl_satker e', 'e.kode_satker = c.kode_satker');
		//$this->db->join('', '');
		//$this->db->where('', $);
		$this->db->where('a.kode_e2', $kode_e2);
		$this->db->where('a.kode_sasaran_e2', $kode_sasaran_e2);
		$this->db->where('a.kode_ikk', $kode_ikk);
		
		
		$query = $this->db->get();
		
		$out2 .= '<br>Data Sub-Kegiatan Tertaut ke IKK s.d. Bulan ini: ';
		$out2 .= '<br><table border="1" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" style="height:10px;">
					<tr>
						<td width="4%" height="23" bgcolor="#F5F5F5" >No</td>
						<td width="36%" bgcolor="#F5F5F5" >Nama Sub-Kegiatan</td>
						<td width="6%" bgcolor="#F5F5F5" >Volume</td>
						<td width="8%" bgcolor="#F5F5F5" >Satuan</td>
						<td width="10%" bgcolor="#F5F5F5" >Total (Rp)</td>
						<td width="6%" bgcolor="#F5F5F5" >Realisasi</td>
						<td width="10%" bgcolor="#F5F5F5" >Serapan (Rp)</td>
						<td width="20%" bgcolor="#F5F5F5" >Nama Satker</td>
					</tr>';
		
		foreach($query->result() as $r){
			$out2 .= '	<tr>
							<td>'.$i.'</td>
							<td>'.$r->nama_subkegiatan.'</td>
							<td>'.$r->volume.'</td>
							<td>'.$r->satuan.'</td>
							<td>'.$r->total.'</td>
							<td>'.$r->realisasi_volume.'</td>
							<td>'.$r->realisasi_rp.'</td>
							<td>'.$r->nama_satker.'</td>
						</tr>';
			$i++;
		}
		//chan
		if ($i==1){
			$out2 .= '	<tr>
							<td colspan="6">Data Sub-Kegiatan Tertaut ke IKK s.d. Bulan ini Tidak Ada. </td>
						</tr>';
		}
			$out2 .= '</table>';
			
		return $out2;
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as ikk');
		$this->db->from('tbl_kinerja_eselon2 a');
		$this->db->join('tbl_sasaran_eselon2 b', 'b.kode_sasaran_e2 = a.kode_sasaran_e2');
		$this->db->join('tbl_ikk c', 'c.kode_ikk = a.kode_ikk and c.tahun = a.tahun');
		$this->db->join('tbl_eselon2 d', 'd.kode_e2 = a.kode_e2');
		$this->db->join('tbl_eselon1 e', 'e.kode_e1 = d.kode_e1');
		$this->db->join('tbl_pk_eselon2 f', 'f.kode_ikk = a.kode_ikk and f.tahun = f.tahun');
		$this->db->where('a.id_kinerja_e2', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			//query insert data		
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',$data['triwulan']);
			$this->db->set('kode_e2',$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
			
			$this->db->set('kode_ikk',$dt['kode_ikk']);
			// $this->db->set('target',$data['target']);
			// $this->db->set('satuan',$data['satuan']);
			$this->db->set('realisasi',$dt['realisasi']);
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			
			$result = $this->db->insert('tbl_kinerja_eselon2');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',$data['triwulan']);
			$this->db->set('kode_e2',$data['kode_e2']);
			$this->db->set('kode_sasaran_e2',$data['kode_sasaran_e2']);
			$this->db->set('kode_ikk',$dt['kode_ikk']);
			$this->db->set('realisasi',$dt['realisasi']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_eselon2_log');
			
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
		$this->db->where('id_kinerja_e2', $data['id_kinerja_e2']);
		$this->db->set('realisasi', $data['realisasi']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->update('tbl_kinerja_eselon2', $data);
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_kinerja_eselon2");
		$this->db->where('id_kinerja_e2', $data['id_kinerja_e2']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e2',			$qt->row()->kode_e2);
			$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
			$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_eselon2_log');
		
		
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
		$this->db->from("tbl_kinerja_eselon2");
		$this->db->where('id_kinerja_e2', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e2',			$qt->row()->kode_e2);
			$this->db->set('kode_sasaran_e2',	$qt->row()->kode_sasaran_e2);
			$this->db->set('kode_ikk',			$qt->row()->kode_ikk);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_eselon2_log');
		
		$this->db->flush_cache();
		$this->db->where('id_kinerja_e2', $id);
		$result = $this->db->delete('tbl_kinerja_eselon2');
		
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
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kinerja_eselon2');
		$this->db->where('tahun', $tahun);
		$this->db->where('triwulan', $triwulan);
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
	
}
?>
