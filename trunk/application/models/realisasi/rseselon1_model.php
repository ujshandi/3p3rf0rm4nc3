<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class rseselon1_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($filtahun=null,$file1=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("tbl_pk_eselon1.tahun",$filtahun);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_pk_eselon1.kode_e1",$file1);
			}
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("tbl_kinerja_eselon1.id_kinerja_e1, tbl_kinerja_eselon1.tahun, tbl_kinerja_eselon1.triwulan, tbl_kinerja_eselon1.kode_e1,tbl_kinerja_eselon1.kode_sasaran_e1,tbl_kinerja_eselon1.kode_iku_e1,tbl_iku_eselon1.satuan,tbl_pk_eselon1.penetapan,tbl_kinerja_eselon1.realisasi,tbl_kinerja_eselon1.realisasi_persen,tbl_kinerja_eselon1.keterangan,tbl_kinerja_eselon1.action_plan, tbl_eselon1.nama_e1, tbl_sasaran_eselon1.deskripsi AS deskripsi_sasaran_e1, tbl_iku_eselon1.deskripsi AS deskripsi_iku_e1");
			$this->db->from('tbl_pk_eselon1');
			$this->db->join('tbl_kinerja_eselon1', 'tbl_kinerja_eselon1.kode_iku_e1 = tbl_pk_eselon1.kode_iku_e1 and tbl_kinerja_eselon1.tahun = tbl_pk_eselon1.tahun');
			$this->db->join('tbl_iku_eselon1', 'tbl_iku_eselon1.kode_iku_e1 = tbl_kinerja_eselon1.kode_iku_e1 and tbl_iku_eselon1.tahun = tbl_kinerja_eselon1.tahun');
			$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_kinerja_eselon1.kode_sasaran_e1 and tbl_sasaran_eselon1.tahun = tbl_kinerja_eselon1.tahun');
			$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_kinerja_eselon1.kode_e1 ');
			$this->db->order_by("tbl_kinerja_eselon1.tahun DESC, triwulan ASC, kode_sasaran_e1 ASC, tbl_kinerja_eselon1.kode_iku_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['id_kinerja_e1']=$row->id_kinerja_e1;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['triwulan']=$this->utility->getBulanValue($row->triwulan-1);
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['kode_sasaran_e1']=$row->kode_sasaran_e1;
				$response->rows[$i]['deskripsi_sasaran_e1']=$row->deskripsi_sasaran_e1;
				$response->rows[$i]['kode_iku_e1']=$row->kode_iku_e1;
				$response->rows[$i]['deskripsi_iku_e1']=$row->deskripsi_iku_e1;
				
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
				//$response->rows[$i]['realisasi_persen']=$this->utility->cekNumericFmt($row->realisasi_persen);
				$response->rows[$i]['keterangan']=$row->keterangan;
				$response->rows[$i]['action_plan']=$row->action_plan;
				$i++;
			} 
			
			$query->free_result();
		}else {
				$response->rows[$count]['id_kinerja_e1']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['triwulan']='';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['kode_sasaran_e1']='';
				$response->rows[$count]['deskripsi_sasaran_e1']='';
				$response->rows[$count]['kode_iku_e1']='';
				$response->rows[$count]['deskripsi_iku_e1']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['realisasi']='';
				$response->rows[$count]['realisasi_persen']='';
				$response->rows[$count]['keterangan']='';
				$response->rows[$count]['action_plan']='';
				
		}
		
		return json_encode($response);
		
	}
	
	
	public function GetRecordCount($file1){
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("tbl_pk_eselon1.kode_e1",$file1);
		}
		$this->db->select("tbl_kinerja_eselon1.id_kinerja_e1, tbl_kinerja_eselon1.tahun, tbl_kinerja_eselon1.triwulan, tbl_kinerja_eselon1.kode_e1,tbl_kinerja_eselon1.kode_sasaran_e1,tbl_kinerja_eselon1.kode_iku_e1,tbl_iku_eselon1.satuan,tbl_pk_eselon1.penetapan,tbl_kinerja_eselon1.realisasi, tbl_eselon1.nama_e1, tbl_sasaran_eselon1.deskripsi AS deskripsi_sasaran_e1, tbl_iku_eselon1.deskripsi AS deskripsi_iku_e1");
		$this->db->from('tbl_pk_eselon1');
		$this->db->join('tbl_kinerja_eselon1', 'tbl_kinerja_eselon1.kode_iku_e1 = tbl_pk_eselon1.kode_iku_e1');
		$this->db->join('tbl_iku_eselon1', 'tbl_iku_eselon1.kode_iku_e1 = tbl_kinerja_eselon1.kode_iku_e1 and tbl_iku_eselon1.tahun = tbl_kinerja_eselon1.tahun');
		$this->db->join('tbl_sasaran_eselon1', 'tbl_sasaran_eselon1.kode_sasaran_e1 = tbl_kinerja_eselon1.kode_sasaran_e1 ');
		$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_kinerja_eselon1.kode_e1 ');
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}

		// combobox
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_pk_eselon1');
		$this->db->group_by('tahun');
		$e1 = $this->session->userdata('unit_kerja_e1');
		if (($e1!="-1")&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			//$value = $e1;
		}
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
		$this->db->from('tbl_kinerja_eselon1');
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
		
		$out = '<select id="kode_e1'.$objectId.'" name="kode_e1" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
		$out = '<select id="kode_e1'.$objectId.'" name="kode_e1" class="easyui-validatebox" required="true">';
		$out = '<select id="kode_e1'.$objectId.'" name="kode_e1" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true">';
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
		
		/*
		$out = '<select id="kode_sasaran_e1'.$objectId.'" name="kode_sasaran_e1" onchange="getDetail'.$objectId.'()" class="easyui-validatebox" required="true" style="width:700px;">';
		$out .= '<option value="0">-- pilih --</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_e1.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		*/
		
		$out = '<div id="tcContainer"><input id="kode_sasaran_e1'.$objectId.'" name="kode_sasaran_e1" type="hidden" class="h_code" value="0">';
		$out .= '<textarea id="txtkode_sasaran_e1'.$objectId.'" name="txtkode_sasaran_e1'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setPKE1'.$objectId.'(\''.$r->kode_sasaran_e1.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Sasaran Eselon 2 untuk tingkat Eselon ini belum tersedia.";
		}
		
		echo $out;
	}
	
	//public function getDetail($tahun, $kode_e1, $kode_sasaran_e1, $objectId){
	public function getDetail($tahun, $triwulan, $kode_e1, $kode_sasaran_e1, $objectId){
		
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pk_eselon1');
		$this->db->join('tbl_iku_eselon1','tbl_pk_eselon1.kode_iku_e1 = tbl_iku_eselon1.kode_iku_e1 and tbl_pk_eselon1.tahun = tbl_iku_eselon1.tahun');
		$this->db->where('tbl_pk_eselon1.tahun', $tahun);
		$this->db->where('tbl_pk_eselon1.kode_e1', $kode_e1);
		$this->db->where('tbl_pk_eselon1.kode_sasaran_e1', $kode_sasaran_e1);
		
		$query = $this->db->get();
		
		$out = '';
		$i = 0;
		
		$row = $query->result();
		$leng = $query->num_rows();
		$akhir = $leng - 1;
		
		for($i=0; $i<$leng; $i++){
			
			$capaian = $this->getCapaian($tahun, ($triwulan-1), $kode_sasaran_e1, $row[$i]->kode_iku_e1);
			
			$out .= '<fieldset class="sectionwrap">
								<div class="fitem">
								  <label style="width:150px">Indikator Kerja Utama :</label>
								  <input type="hidden" name=detail['.$i.'][kode_iku_e1] value="'.$row[$i]->kode_iku_e1.'">
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
								  <label style="text-align:right; width:10px">('.$this->utility->cekNumericFmt(round($capaian[1], 2)).'%)</label>
								</div>
								<div class="fitem">
								  <label style="width:150px">Capaian Bulan Ini :</label>
								  <input name=detail['.$i.'][realisasi] value="" size="15">
								</div>
								<div class="fitem">
								  <label style="width:150px">Keterangan :</label>
								  <textarea name=detail['.$i.'][keterangan] cols="60"></textarea>
								</div>
								<div class="fitem">
								  <label style="width:150px">Rencana Aksi :</label>
								  <textarea name=detail['.$i.'][action_plan] cols="60"></textarea>
								</div>
								<!--<div class="fitem">
								  <label style="width:150px">Persentase Capaian :</label>
								  <input name=detail['.$i.'][realisasi_persen] value="" size="15">
								</div>-->';
			// dibuka dl request p.Toto 2013.08.16
			if($i == $akhir){
				$out .='<br><div class="fitem">';
				$out .= '<label style="width:150px"></label><input type="button" onclick="saveData'.$objectId.'()" value="Simpan" />';
				$out .='</div>';
			}
			
		//ditutup coz data eselon 2 semua di hide	$out .=  $this->getPendukung($tahun, $triwulan, $kode_sasaran_e1, $row[$i]->kode_iku_e1);
			
			$out .=				'</fieldset>';
		}
		
		return $out;
	}
	
	private function getCapaian($tahun, $triwulan, $kode_sasaran_e1, $kode_iku_e1){
		$q = '';
		$q .= ' SELECT tbl_kinerja_eselon1.id_kinerja_e1, tbl_kinerja_eselon1.tahun, tbl_kinerja_eselon1.triwulan, tbl_kinerja_eselon1.kode_e1, tbl_kinerja_eselon1.kode_sasaran_e1, tbl_kinerja_eselon1.kode_iku_e1, tbl_kinerja_eselon1.realisasi,tbl_kinerja_eselon1.realisasi_persen,tbl_kinerja_eselon1.keterangan,tbl_kinerja_eselon1.action_plan, tbl_pk_eselon1.penetapan';
		$q .= ' FROM `tbl_kinerja_eselon1` ';
		$q .= ' left join tbl_pk_eselon1 on tbl_kinerja_eselon1.kode_sasaran_e1 = tbl_pk_eselon1.kode_sasaran_e1 and tbl_kinerja_eselon1.kode_iku_e1 = tbl_pk_eselon1.kode_iku_e1 and tbl_kinerja_eselon1.tahun = tbl_pk_eselon1.tahun';
		$q .= " WHERE tbl_kinerja_eselon1.tahun = '$tahun' AND";
		$q .= " tbl_kinerja_eselon1.triwulan = '$triwulan' AND";
		$q .= " tbl_kinerja_eselon1.kode_sasaran_e1 = '$kode_sasaran_e1' AND";
		$q .= " tbl_kinerja_eselon1.kode_iku_e1 = '$kode_iku_e1'";
		
		$result = $this->db->query($q);
		
		$dt[0] = 0;
		$dt[1] = 0;
		
		if ($result->num_rows() > 0){
			$dt[0] = $result->row()->realisasi;
			if (is_numeric($result->row()->penetapan)){
				if ($result->row()->penetapan>0)
					$dt[1] = ($dt[0]/$result->row()->penetapan)*100;
			}	
			else {
				$dt[1] = 0;
			}
		}else{
			$dt[0] = 0;
			$dt[1] = 0;
		}
		
		return $dt;
	}
	
	private function getPendukung($tahun, $triwulan, $kode_sasaran_e1="", $kode_iku_e1=""){
		$out2 = '';
		$i = 1;
		
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kinerja_eselon2 a');
		$this->db->join('tbl_sasaran_eselon2 b', 'b.kode_sasaran_e2 = a.kode_sasaran_e2 and b.tahun = a.tahun');
		$this->db->join('tbl_ikk c', 'c.kode_ikk = a.kode_ikk and c.tahun = a.tahun');
		$this->db->join('tbl_pk_eselon2 d', 'd.kode_ikk = a.kode_ikk and d.tahun = a.tahun');
		$this->db->join('tbl_eselon2 e', 'e.kode_e2 = a.kode_e2');
		$this->db->where('b.kode_sasaran_e1', $kode_sasaran_e1);
		$this->db->where('c.kode_iku_e1', $kode_iku_e1);
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.triwulan', $triwulan);
		
		$query = $this->db->get();
		
		$out2 .= '<br>Data IKK Eselon II Tertaut ke IKU s.d. Bulan ini: ';
		$out2 .= '<br><table border="1" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" style="height:10px;">
						  <tr>
							<td width="4%" height="23" bgcolor="#F5F5F5" >No</td>
							<td width="42%" bgcolor="#F5F5F5" >IKK</td>
							<td width="13%" bgcolor="#F5F5F5" >Satuan</td>
							<td width="12%" bgcolor="#F5F5F5" >Target</td>
							<td width="10%" bgcolor="#F5F5F5" >Realisasi</td>
							<td width="10%" bgcolor="#F5F5F5" >Realisasi(%)</td>
							<td width="19%" bgcolor="#F5F5F5" >Nama Eselon I</td>
						  </tr>';
		
		foreach($query->result() as $r){
			$out2 .= '	  <tr>
							<td>'.$i.'</td>
							<td>'.$r->deskripsi.'</td>
							<td>'.$r->satuan.'</td>
							<td>'.$this->utility->cekNumericFmt($r->penetapan).'</td>
							<td>'.$this->utility->cekNumericFmt($r->realisasi).'</td>
							
							<td>'.$r->keterangan.'</td>
							<td>'.$r->nama_e2.'</td>
						  </tr>';
			$i++;
		}
		//chan
		if ($i==1){
			$out2 .= '	  <tr>
							<td colspan="7">Data IKK Eselon II Tertaut ke IKU s.d. Bulan ini Tidak Ada. </td>
							</tr>';
		}
			$out2 .= '</table>';
			
		return $out2;
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as iku_e1');
		$this->db->from('tbl_kinerja_eselon1 a');
		$this->db->join('tbl_sasaran_eselon1 b', 'b.kode_sasaran_e1 = a.kode_sasaran_e1');
		$this->db->join('tbl_iku_eselon1 c', 'c.kode_iku_e1 = a.kode_iku_e1 and c.tahun = a.tahun');
		$this->db->join('tbl_eselon1 d', 'd.kode_e1 = a.kode_e1');
		$this->db->join('tbl_pk_eselon1 e', 'e.kode_iku_e1 = a.kode_iku_e1 and e.tahun = e.tahun');
		$this->db->where('a.id_kinerja_e1', $id);
		
		return $this->db->get()->row();
	}
	
	public function InsertOnDB($data) {
		$this->db->trans_start();
		
		foreach($data['detail'] as $dt){
			//query insert data		
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',$data['triwulan']);
			$this->db->set('kode_e1',$data['kode_e1']);
			$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
			
			$this->db->set('kode_iku_e1',$dt['kode_iku_e1']);
			// $this->db->set('target',$data['target']);
			// $this->db->set('satuan',$data['satuan']);
			$this->db->set('realisasi',$dt['realisasi']);
			//$this->db->set('realisasi_persen',$dt['realisasi_persen']);
			$this->db->set('keterangan',$dt['keterangan']);
			$this->db->set('action_plan',$dt['action_plan']);
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			
			$result = $this->db->insert('tbl_kinerja_eselon1');
			
			# insert to log
			$this->db->flush_cache();
			$this->db->set('tahun',$data['tahun']);
			$this->db->set('triwulan',$data['triwulan']);
			$this->db->set('kode_e1',$data['kode_e1']);
			$this->db->set('kode_sasaran_e1',$data['kode_sasaran_e1']);
			$this->db->set('kode_iku_e1',$dt['kode_iku_e1']);
			$this->db->set('realisasi',$dt['realisasi']);
			//$this->db->set('realisasi_persen',$dt['realisasi_persen']);
			$this->db->set('keterangan',$dt['keterangan']);
			$this->db->set('action_plan',$dt['action_plan']);
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_eselon1_log');
			
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
		$this->db->where('id_kinerja_e1', $data['id_kinerja_e1']);
		$this->db->set('realisasi', $data['realisasi']);
		//$this->db->set('realisasi_persen', $data['realisasi_persen']);
		$this->db->set('keterangan', $data['keterangan']);
		$this->db->set('action_plan', $data['action_plan']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$result = $this->db->update('tbl_kinerja_eselon1', $data);
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_kinerja_eselon1");
		$this->db->where('id_kinerja_e1', $data['id_kinerja_e1']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e1',			$qt->row()->kode_e1);
			$this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
			$this->db->set('kode_iku_e1',		$qt->row()->kode_iku_e1);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			//$this->db->set('realisasi_persen',			$qt->row()->realisasi_persen);
			$this->db->set('keterangan',			$qt->row()->keterangan);
			$this->db->set('action_plan',			$qt->row()->action_plan);
			$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_eselon1_log');
		
		
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
		$this->db->from("tbl_kinerja_eselon1");
		$this->db->where('id_kinerja_e1', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
			$this->db->set('tahun',				$qt->row()->tahun);
			$this->db->set('triwulan',			$qt->row()->triwulan);
			$this->db->set('kode_e1',			$qt->row()->kode_e1);
			$this->db->set('kode_sasaran_e1',	$qt->row()->kode_sasaran_e1);
			$this->db->set('kode_iku_e1',		$qt->row()->kode_iku_e1);
			$this->db->set('realisasi',			$qt->row()->realisasi);
			//$this->db->set('realisasi_persen',			$qt->row()->realisasi_persen);
			$this->db->set('keterangan',			$qt->row()->keterangan);
			$this->db->set('action_plan',			$qt->row()->action_plan);
			$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$result = $this->db->insert('tbl_kinerja_eselon1_log');
		
		$this->db->flush_cache();
		$this->db->where('id_kinerja_e1', $id);
		$result = $this->db->delete('tbl_kinerja_eselon1');
		
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
		$this->db->from('tbl_kinerja_eselon1');
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
