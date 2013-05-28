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
	
	public function easyGrid(){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount();
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$this->db->select("tbl_kinerja_kl.tahun, tbl_kinerja_kl.triwulan, tbl_kinerja_kl.kode_kl, tbl_kinerja_kl.kode_sasaran_kl, tbl_kinerja_kl.kode_iku_kl, tbl_kinerja_kl.realisasi, tbl_pk_kl.satuan, tbl_pk_kl.penetapan");
			$this->db->from('tbl_kinerja_kl');
			$this->db->join('tbl_pk_kl', 'tbl_kinerja_kl.kode_iku_kl = tbl_pk_kl.kode_iku_kl');
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				//$response->rows[$i]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$i]['tahun']=$row->tahun;
				$response->rows[$i]['triwulan']=$row->triwulan;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['kode_sasaran_kl']=$row->kode_sasaran_kl;
				$response->rows[$i]['kode_iku_kl']=$row->kode_iku_kl;
				$response->rows[$i]['penetapan']=$row->penetapan;
				$response->rows[$i]['satuan']=$row->satuan;
				$response->rows[$i]['realisasi']=$row->realisasi;

				$i++;
			} 
			
			$query->free_result();
		}else {
				//$response->rows[$count]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['triwulan']='';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['kode_iku_kl']='';
				$response->rows[$count]['penetapan']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['realisasi']='';
				
		}
		
		return json_encode($response);
		
	}
	
	
	public function GetRecordCount(){
		$this->db->select("tbl_kinerja_kl.tahun, tbl_kinerja_kl.triwulan, tbl_kinerja_kl.kode_kl, tbl_kinerja_kl.kode_sasaran_kl, tbl_kinerja_kl.kode_iku_kl, tbl_kinerja_kl.realisasi, tbl_pk_kl.satuan, tbl_pk_kl.penetapan");
		$this->db->from('tbl_kinerja_kl');
		$this->db->join('tbl_pk_kl', 'tbl_kinerja_kl.kode_iku_kl = tbl_pk_kl.kode_iku_kl');
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function easyGridTindak(){
		
		$register_id = isset($_POST['register_id']) ? intval($_POST['register_id']) : 0;
		
		$count = $this->GetRecordCountTindak($register_id);
		$response->total = $count;
		if ($count>0){		
			$this->db->select('d.tindakan_rwj_id, d.tgl_tindak, d.tindak_id, 
				d.qty, d.tarif, d.amount, d.qty_2, d.amount_2, d.bayar_by_rs, d.bayar_by_pasien, 
				d.diskon, d.is_paket, d.induk, 
				d.tag, t.tindak_nama, t.tindak_kode, d.tarif_2, d.klas_id, d.cat_id, 
				tindakan_operator_rwj(d.tindakan_rwj_id) as qty_dok');
			$this->db->from('trs_rwj_tindakan d');
			$this->db->join('mst_tindakan t', 'd.tindak_id = t.tindak_id');
			$this->db->where('d.daftar_rwj_id', $register_id);
			$this->db->orderby('d.tgl_tindak');
			$this->db->limit($limit,$offset);
		
			$query = $this->db->get();
		
		  	$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['tindakan_rwj_id']=0;
				$response->rows[$i]['tgl_tindak']=$row->tgl_tindak;
				$response->rows[$i]['tindak_id']=$row->tindak_id;
				$response->rows[$i]['qty']=$row->qty;
				$response->rows[$i]['tarif']=$row->tarif;
				$response->rows[$i]['amount']=$row->amount;
				$response->rows[$i]['qty_2']=$row->qty_2;
				$response->rows[$i]['tarif_2']=$row->tarif_2;
				$response->rows[$i]['amount_2']=$row->amount_2;
				$response->rows[$i]['bayar_by_rs']=$row->bayar_by_rs;
				$response->rows[$i]['bayar_by_pasien']=$row->bayar_by_pasien;
				//$response->rows[$i]['diskon']=$row->diskon;
				$response->rows[$i]['is_paket']=$row->is_paket;
				$response->rows[$i]['induk']=$row->induk;
				//$response->rows[$i]['tag']=$row->tag;
				$response->rows[$i]['tindak_nama']=$row->tindak_nama;
				$response->rows[$i]['tindak_kode']=$row->tindak_kode;
				$response->rows[$i]['klas_id']=$row->klas_id;
				$response->rows[$i]['cat_id']=$row->cat_id;
				$response->rows[$i]['qty_dok']=$row->qty_dok;
				$response->rows[$i]['ba']=0;
				$response->rows[$i]['action']="";
				$response->rows[$i]['users_id']="";
				$response->rows[$i]['ref_by_rs']=0;
				$response->rows[$i]['ref_by_pasien']=0;
										
				$billing = $row->amount - $row->amount_2;
				if (($billing > 0) && ($row->tarif_2>0)) $billing = $billing - $row->bayar_by_rs; 
				elseif (($billing < 0) and ($row->tarif_2>0)) $billing = 0;
				
				$response->rows[$i]['ba']=$billing;
				$i++;
			}
								
			$query->free_result();
			
		} else {
			$response->rows[0]['tindakan_rwj_id']=0;
			$response->rows[0]['tgl_tindak']="";
			$response->rows[0]['tindak_id']=0;
			$response->rows[0]['qty']=0;
			$response->rows[0]['tarif']=0;
			$response->rows[0]['amount']=0;
			$response->rows[0]['qty_2']=0;
			$response->rows[0]['tarif_2']=0;
			$response->rows[0]['amount_2']=0;
			$response->rows[0]['bayar_by_rs']=0;
			$response->rows[0]['bayar_by_pasien']=0;
			//$response->rows[0]['diskon']=0;
			$response->rows[0]['is_paket']=0;
			$response->rows[0]['induk']=0;
			//$response->rows[0]['tag']=0;
			$response->rows[0]['tindak_nama']="";
			$response->rows[0]['tindak_kode']="";
			$response->rows[0]['klas_id']=0;
			$response->rows[0]['cat_id']=0;
			$response->rows[0]['qty_dok']=0;
			$response->rows[0]['ba']=0;
			$response->rows[0]['users_id']="";
			$response->rows[0]['ref_by_rs']=0;
			$response->rows[0]['ref_by_pasien']=0;
			$response->rows[0]['action']="";
		}	
			
		
		$footer[] = array('tindak_nama'=>'TOTAL', 'ba'=>5000, 'action'=>'-');
		//$footer[0]['name'] = 'total';
		//$footer[0]['ba'] = 2000;
			
		$response->footer = $footer;		
		return json_encode($response);
	}
	
	
	// combobox
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_pk_kl');
		$this->db->group_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select id="tahun'.$objectId.'" name="tahun" class="easyui-validatebox" required="true">';
		
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
		
		$out = '<select id="kode_kl'.$objectId.'" name="kode_kl" class="easyui-validatebox" required="true">';
		
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
		$out  = '<select id="kode_sasaran_kl'.$objectId.'" name="kode_sasaran_kl" onchange="getDetail()" class="easyui-validatebox" required="true">';
		$out .= '<option value="0">-- Pilih --</option>';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_kl.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		*/
		
		$out = '<input id="kode_sasaran_kl'.$objectId.'" name="kode_sasaran_kl" type="hidden" class="h_code" value="0">';
		$out .= '<textarea id="txtkode_sasaran_kl'.$objectId.'" name="txtkode_sasaran_kl'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>-- Pilih --</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setSasaran'.$objectId.'(\''.$r->kode_sasaran_kl.'\')">'.$r->deskripsi.'</li>';
		}
		$out .= '</ul>';
		
		echo $out;
	}
	
	public function getDetail($tahun, $kode_kl, $kode_sasaran_kl, $objectId){
		
		$this->db->flush_cache();
		$this->db->select('tbl_pk_kl.kode_iku_kl, tbl_iku_kl.deskripsi, tbl_pk_kl.satuan, tbl_pk_kl.penetapan');
		$this->db->from('tbl_pk_kl');
		$this->db->join('tbl_iku_kl','tbl_pk_kl.kode_iku_kl = tbl_iku_kl.kode_iku_kl');
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
								  '.$row[$i]->penetapan.'
								</div>
								<div class="fitem">
								  <label style="width:150px">Capaian s.d. Triwulan Lalu :</label>
								  <input name=detail['.$i.'][capaian] value="" size="15">&nbsp;&nbsp;&nbsp;
								  <input name=detail['.$i.'][persentase] value="" size="3">&nbsp;%
								</div>
								<div class="fitem">
								  <label style="width:150px">Realisasi Triwulan Ini :</label>
								  <input name=detail['.$i.'][realisasi] value="" size="15">
								</div>';
			if($i == $akhir){
				$out .='<br><div class="fitem">';
				$out .= '<label style="width:150px"></label><input type="button" onclick="saveData'.$objectId.'()" value="Simpan" />';
				$out .='</div>';
			}
			$out .=				'</fieldset>';
		}
		
		return $out;
	}
		
	public function InsertOnDB($data) {
		//query insert data		
		$this->db->set('tahun',$data['tahun']);
		$this->db->set('triwulan',$data['triwulan']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('kode_sasaran_kl',$data['kode_sasaran_kl']);
		
		$this->db->set('kode_iku_kl',$data['kode_iku_kl']);
		// $this->db->set('target',$data['target']);
		// $this->db->set('satuan',$data['satuan']);
		$this->db->set('realisasi',$data['realisasi']);
		
		$result = $this->db->insert('tbl_kinerja_kl');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Inserting to : ".$errMess." (".$errNo.")"); 
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	
	//hapus data
	public function DeleteOnDb($tindak_id, $unit_id, $klas_id) {
		$this->db->where('tindak_id',$tindak_id);
		$this->db->where('unit_id',$unit_id);
		$this->db->where('klas_id',$klas_id);
		
		$result = $this->db->delete('mst_tindakan_unit');
		
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

}
?>
