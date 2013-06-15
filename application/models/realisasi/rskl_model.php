<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/
  
class rskl_model extends CI_Model
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
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_pk_kl.tahun",$filtahun);
			}
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("tbl_kinerja_kl.id_kinerja_kl, tbl_kinerja_kl.tahun, tbl_kinerja_kl.triwulan, tbl_kinerja_kl.kode_kl, tbl_kinerja_kl.kode_sasaran_kl, tbl_kinerja_kl.kode_iku_kl, tbl_kinerja_kl.realisasi,tbl_kinerja_kl.realisasi_persen, tbl_iku_kl.satuan, tbl_pk_kl.penetapan, tbl_kl.nama_kl, tbl_sasaran_kl.deskripsi AS deskripsi_sasaran_kl, tbl_iku_kl.deskripsi AS deskripsi_iku_kl");
			$this->db->from('tbl_kinerja_kl');
			$this->db->join('tbl_pk_kl', 'tbl_pk_kl.kode_iku_kl = tbl_kinerja_kl.kode_iku_kl and tbl_pk_kl.tahun = tbl_kinerja_kl.tahun and tbl_pk_kl.kode_kl = tbl_kinerja_kl.kode_kl');
			$this->db->join('tbl_iku_kl', 'tbl_iku_kl.kode_iku_kl = tbl_kinerja_kl.kode_iku_kl and tbl_iku_kl.tahun = tbl_kinerja_kl.tahun');
			$this->db->join('tbl_kl', 'tbl_kl.kode_kl = tbl_kinerja_kl.kode_kl');
			$this->db->join('tbl_sasaran_kl','tbl_sasaran_kl.kode_sasaran_kl = tbl_kinerja_kl.kode_sasaran_kl and tbl_sasaran_kl.tahun = tbl_kinerja_kl.tahun');
			$this->db->order_by("tbl_kinerja_kl.tahun DESC, triwulan ASC, kode_sasaran_kl ASC, tbl_kinerja_kl.kode_iku_kl ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_kinerja_kl']=$row->id_kinerja_kl;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['triwulan']=$this->utility->getBulanValue($row->triwulan-1);
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['nama_kl']=$row->nama_kl;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['deskripsi_sasaran_kl']=$row->deskripsi_sasaran_kl;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['deskripsi_iku_kl']=$row->deskripsi_iku_kl;
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
				$response->rows[$i]['realisasi_persen']=$this->utility->cekNumericFmt($row->realisasi_persen);
				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$count]['id_kinerja_kl']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['triwulan']='';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['kode_iku_kl']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['realisasi']='';
				$response->rows[$count]['realisasi_persen']='';
				$response->rows[$count]['nama_kl']='';
				$response->rows[$count]['deskripsi_iku_kl']='';
				$response->rows[$count]['deskripsi_sasaran_kl']='';
				
		}
		
		return json_encode($response);
		
	}
	
	public function GetRecordCount($filtahun=""){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("tbl_pk_kl.tahun",$filtahun);
		}
		$this->db->select("tbl_kinerja_kl.id_kinerja_kl, tbl_kinerja_kl.tahun, tbl_kinerja_kl.triwulan, tbl_kinerja_kl.kode_kl, tbl_kinerja_kl.kode_sasaran_kl, tbl_kinerja_kl.kode_iku_kl, tbl_kinerja_kl.realisasi, tbl_iku_kl.satuan, tbl_pk_kl.penetapan, tbl_kl.nama_kl, tbl_sasaran_kl.deskripsi AS deskripsi_sasaran_kl, tbl_iku_kl.deskripsi AS deskripsi_iku_kl");
		$this->db->from('tbl_kinerja_kl');
		$this->db->join('tbl_pk_kl', 'tbl_pk_kl.kode_iku_kl = tbl_kinerja_kl.kode_iku_kl and tbl_pk_kl.tahun = tbl_kinerja_kl.tahun and tbl_pk_kl.kode_kl = tbl_kinerja_kl.kode_kl');
		$this->db->join('tbl_iku_kl', 'tbl_iku_kl.kode_iku_kl = tbl_kinerja_kl.kode_iku_kl and tbl_iku_kl.tahun = tbl_kinerja_kl.tahun');
		$this->db->join('tbl_kl', 'tbl_kl.kode_kl = tbl_kinerja_kl.kode_kl');
		$this->db->join('tbl_sasaran_kl','tbl_sasaran_kl.kode_sasaran_kl = tbl_kinerja_kl.kode_sasaran_kl');

		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	// combobox
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_pk_kl');
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
		$this->db->from('tbl_kinerja_kl');
		
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
		
		/*
		$out  = '<select id="kode_sasaran_kl'.$objectId.'" name="kode_sasaran_kl" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true" style="width:750px;">';
		$out .= '<option value="0">-- Pilih --</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_kl.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		
		echo $out;
		*/
		
		$out = '<div id="tcContainer"><input id="kode_sasaran_kl'.$objectId.'" name="kode_sasaran_kl" type="hidden" class="h_code" value="0">';
		$out .= '<textarea id="txtkode_sasaran_kl'.$objectId.'" name="txtkode_sasaran_kl'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran'.$objectId.'(\''.$r->kode_sasaran_kl.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Eselon 2 untuk tingkat Eselon ini belum tersedia.";
		}
		
		echo $out;
		
	}
	
	public function getDetail($tahun, $triwulan, $kode_kl, $kode_sasaran_kl, $objectId){
		
		$this->db->flush_cache();
		$this->db->select('tbl_pk_kl.kode_iku_kl, tbl_iku_kl.deskripsi, tbl_iku_kl.satuan, tbl_pk_kl.penetapan');
		$this->db->from('tbl_pk_kl');
		$this->db->join('tbl_iku_kl','tbl_pk_kl.kode_iku_kl = tbl_iku_kl.kode_iku_kl and tbl_pk_kl.tahun = tbl_iku_kl.tahun');
		$this->db->where('tbl_pk_kl.tahun', $tahun);
		$this->db->where('tbl_pk_kl.kode_kl', $kode_kl);
		$this->db->where('tbl_pk_kl.kode_sasaran_kl', $kode_sasaran_kl);
		
		$query = $this->db->get();
		
		$out = '';
		$i = 0;
		
		$row = $query->result();
		$leng = $query->num_rows();
		$akhir = $leng - 1;
		
		for($i=0; $i<$leng; $i++){
		
			$capaian = $this->getCapaian($tahun, ($triwulan-1), $kode_sasaran_kl, $row[$i]->kode_iku_kl);
			
			$out .= '<fieldset class="sectionwrap">
								<div class="fitem">
								  <label style="width:150px">Indikator Kerja Utama :</label>
								  <input type="hidden" name=detail['.$i.'][kode_iku_kl] value="'.$row[$i]->kode_iku_kl.'">
								  '.$row[$i]->deskripsi.'
								</div>
								<div class="fitem">
								  <label style="width:150px">Satuan :</label>
								  '.$row[$i]->satuan.'
								</div>
								<div class="fitem">
								  <label style="width:150px">Target :</label>
								  '.$this->utility->cekNumericFmt($row[$i]->penetapan).'
								</div>
								<div class="fitem">
								  <label style="width:150px">Capaian s.d. Bulan Lalu :</label>
								  <input type="hidden" name=detail['.$i.'][capaian] value="'.$capaian[0].'">
								  <label style="min-width:25px">'.$this->utility->cekNumericFmt($capaian[0]).'</label>&nbsp;&nbsp;&nbsp;&nbsp;
								  <label style="text-align:right; width:10px">('.$this->utility->cekNumericFmt($capaian[1]).'%)</label>
								</div>
								<div class="fitem">
								  <label style="width:150px">Capaian Bulan Ini :</label>
								  <input name=detail['.$i.'][realisasi] value="" size="15">								  
								</div>
								<div class="fitem">
								  <label style="width:150px">Persentase Capaian :</label>
								  <input name=detail['.$i.'][realisasi_persen] value="" size="8">
								</div>';
								
			//if($i == $akhir){
				$out .='<br><div class="fitem">';
				$out .= '<label style="width:150px"></label><input type="button" onclick="saveData'.$objectId.'()" value="Simpan" />';
				$out .='</div>';
			//}
			
			$out .=  $this->getPendukung($tahun, $triwulan, $kode_sasaran_kl, $row[$i]->kode_iku_kl);
			
			$out .=				'</fieldset>';
		}
		
		return $out;
	}
	
	private function getCapaian($tahun, $triwulan, $kode_sasaran_kl, $kode_iku_kl){
		$q = '';
		$q .= ' SELECT tbl_kinerja_kl.id_kinerja_kl, tbl_kinerja_kl.tahun, tbl_kinerja_kl.triwulan, tbl_kinerja_kl.kode_kl, tbl_kinerja_kl.kode_sasaran_kl, tbl_kinerja_kl.kode_iku_kl, tbl_kinerja_kl.realisasi, tbl_pk_kl.penetapan';
		$q .= ' FROM `tbl_kinerja_kl` ';
		$q .= ' left join tbl_pk_kl on tbl_kinerja_kl.kode_sasaran_kl = tbl_pk_kl.kode_sasaran_kl and tbl_kinerja_kl.kode_iku_kl = tbl_pk_kl.kode_iku_kl and tbl_kinerja_kl.tahun = tbl_pk_kl.tahun';
		$q .= " WHERE tbl_kinerja_kl.tahun = '$tahun' AND";
		$q .= " tbl_kinerja_kl.triwulan = '$triwulan' AND";
		$q .= " tbl_kinerja_kl.kode_sasaran_kl = '$kode_sasaran_kl' AND";
		$q .= " tbl_kinerja_kl.kode_iku_kl = '$kode_iku_kl'";
		
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
	
	private function getPendukung($tahun, $triwulan, $kode_sasaran_kl="", $kode_iku_kl=""){
		$out2 = '';
		$i = 1;
		
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kinerja_eselon1 a');
		$this->db->join('tbl_sasaran_eselon1 b', 'b.kode_sasaran_e1 = a.kode_sasaran_e1 and b.tahun = a.tahun');
		$this->db->join('tbl_iku_eselon1 c', 'c.kode_iku_e1 = a.kode_iku_e1 and c.tahun = a.tahun');
		$this->db->join('tbl_pk_eselon1 d', 'd.kode_iku_e1 = a.kode_iku_e1 and d.tahun = a.tahun');
		$this->db->join('tbl_eselon1 e', 'e.kode_e1 = a.kode_e1');
		$this->db->where('b.kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('c.kode_iku_kl', $kode_iku_kl);
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.triwulan', $triwulan);
		
		$query = $this->db->get();
		
		$out2 .= '<br>Data IKU Eselon I Tertaut ke IKU s.d. Bulan ini: ';
		$out2 .= '<br><table border="1" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" style="height:10px;">
						  <tr>
							<td width="4%" height="23" bgcolor="#F5F5F5" >No</td>
							<td width="42%" bgcolor="#F5F5F5" >IKU Eselon I</td>
							<td width="13%" bgcolor="#F5F5F5" >Satuan</td>
							<td width="12%" bgcolor="#F5F5F5" >Target</td>
							<td width="10%" bgcolor="#F5F5F5" >Realisasi</td>
							<td width="10%" bgcolor="#F5F5F5" >Realisasi (%)</td>
							<td width="19%" bgcolor="#F5F5F5" >Nama Eselon I</td>
						  </tr>';
		
		foreach($query->result() as $r){
			$out2 .= '	  <tr>
							<td>'.$i.'</td>
							<td>'.$r->deskripsi.'</td>
							<td>'.$r->satuan.'</td>
							<td>'.$this->utility->cekNumericFmt($r->penetapan).'</td>
							<td>'.$this->utility->cekNumericFmt($r->realisasi).'</td>
							<td>'.$this->utility->cekNumericFmt($r->realisasi_persen).'</td>
							<td>'.$r->nama_e1.'</td>
						  </tr>';
			$i++;
		}
		
		//chan
		if ($i==1){
			$out2 .= '	  <tr>
							<td colspan="7">Data IKU Eselon I Tertaut ke IKU s.d. Bulan ini Tidak Ada. </td>
							</tr>';
		}
			$out2 .= '</table>';
			
		return $out2;
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as iku_kl');
		$this->db->from('tbl_kinerja_kl a');
		$this->db->join('tbl_sasaran_kl b', 'b.kode_sasaran_kl = a.kode_sasaran_kl');
		$this->db->join('tbl_iku_kl c', 'c.kode_iku_kl = a.kode_iku_kl and c.tahun = a.tahun');
		$this->db->join('tbl_kl d', 'd.kode_kl = a.kode_kl');
		$this->db->join('tbl_pk_kl e', 'e.kode_iku_kl = a.kode_iku_kl and e.tahun = a.tahun');
		$this->db->where('a.id_kinerja_kl', $id);
		
		return $this->db->get()->row();
	}
		
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			//query insert data		
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',$data['triwulan']);
			$this->db->set('kode_kl',$data['kode_kl']);
			$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
			
			$this->db->set('kode_iku_kl',$dt['kode_iku_kl']);
			// $this->db->set('target',$data['target']);
			// $this->db->set('satuan',$data['satuan']);
			$this->db->set('realisasi',$dt['realisasi']);
			$this->db->set('realisasi_persen',$dt['realisasi_persen']);
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			
			$result = $this->db->insert('tbl_kinerja_kl');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',$data['triwulan']);
			$this->db->set('kode_kl',$data['kode_kl']);
			$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
			$this->db->set('kode_iku_kl',$dt['kode_iku_kl']);
			$this->db->set('realisasi',$dt['realisasi']);
			$this->db->set('realisasi_persen',$dt['realisasi_persen']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_kl_log');
			
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
		$this->db->where('id_kinerja_kl', $data['id_kinerja_kl']);
		$this->db->set('realisasi', $data['realisasi']);
		$this->db->set('realisasi_persen', $data['realisasi_persen']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->update('tbl_kinerja_kl', $data);

		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_kinerja_kl");
		$this->db->where('id_kinerja_kl', $data['id_kinerja_kl']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_kl',			$qt->row()->kode_kl);
			$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
			$this->db->set('kode_iku_kl',		$qt->row()->kode_iku_kl);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('realisasi_persen',			$qt->row()->realisasi_persen);
			$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_kl_log');
		
		
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
		$this->db->from("tbl_kinerja_kl");
		$this->db->where('id_kinerja_kl', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_kl',			$qt->row()->kode_kl);
			$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
			$this->db->set('kode_iku_kl',		$qt->row()->kode_iku_kl);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			$this->db->set('realisasi_persen',			$qt->row()->realisasi_persen);
			$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_kl_log');
		
		$this->db->flush_cache();
		$this->db->where('id_kinerja_kl', $id);
		$result = $this->db->delete('tbl_kinerja_kl');
		
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
	
	public function data_exist($tahun, $triwulan, $kode_kl, $kode_sasaran_kl, $kode_iku_kl){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kinerja_kl');
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
