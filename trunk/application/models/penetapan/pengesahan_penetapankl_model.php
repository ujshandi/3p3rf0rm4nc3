<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/
  
class Pengesahan_penetapankl_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function getDetail($tahun, $kode_kl, $objectId){
		$out = '';
		$i = 1;
		
		# ambil jumlah sasaran di tabel sasaran
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_sasaran_kl');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_kl', $kode_kl);
		$q = $this->db->get();
		$jml_sasaran = $q->num_rows();   // jumlah sasaran
		
		# ambil jumlah sasaran di tabel penetapan
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pk_kl a');
		$this->db->join('tbl_sasaran_kl b', 'a.kode_sasaran_kl = b.kode_sasaran_kl and a.tahun = b.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_kl', $kode_kl);
		$this->db->group_by('a.kode_sasaran_kl');
		$q = $this->db->get();
		$jml_sasaran_pk = $q->num_rows();   // jumlah sasaran
		
		# jika data sasaran lengkap
		if($jml_sasaran == $jml_sasaran_pk && $jml_sasaran_pk>0){
			
			# baca sasaran per baris
			$baris = 1;
			foreach($q->result() as $r){
				$out .= '<fieldset class="sectionwrap">';
				$out .= '	<div class="fitem">';
				$out .= '		<label style="width:110px">Sasaran Ke-'.$baris.' :</label><span style="display:block;margin-left: 110px;">'.$r->deskripsi.'</span>';
				$out .= '	</div>';
				
				# ambil iku berdasarkan kode sasaran dan tahun
				$this->db->flush_cache();
				$this->db->select('*');
				$this->db->from('tbl_pk_kl a');
				$this->db->join('tbl_iku_kl b', 'a.kode_iku_kl = b.kode_iku_kl and a.tahun = b.tahun');
				$this->db->where('a.tahun', $tahun);
				$this->db->where('a.kode_kl', $kode_kl);
				$this->db->where('a.kode_sasaran_kl', $r->kode_sasaran_kl);
				$que = $this->db->get();
				
				#  cek apakah sudah disahkan sebelumnya
				// jika sudah maka approve chekbox readonly
				$isApproved = $this->isApproved($que);
				
				$out .= '<table border="1" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" style="height:10px;">';
				$out .= '<tr>
							<td width="20px" bgcolor="#F5F5F5">No.</td>
							<td bgcolor="#F5F5F5">IKU</td>
							<td width="50px" bgcolor="#F5F5F5">Target (RKT)</td>
							<td width="50px" bgcolor="#F5F5F5">Target (PK)</td>
							<td width="100px" bgcolor="#F5F5F5">Satuan</td>
							<td width="30px" bgcolor="#F5F5F5">Pengesahan</td>
						 </tr>';
				$no=1;
				foreach($que->result() as $row){
					
					$out .= '<tr>';
					$out .= '	<td>'.$no.'
									<input name="detail['.$i.'][id_pk_kl]" value="'.$row->id_pk_kl.'" type="hidden" />
								</td>';
					$out .= '	<td>'.$row->deskripsi.'</td>';
					$out .= '	<td><input name="detail['.$i.'][target]" value="'.$row->target.'" size="15" readonly="true" /></td>';
					$out .= '	<td><input name="detail['.$i.'][penetapan]" value="'.$row->penetapan.'" size="15" '.($isApproved == TRUE?'readonly="true"':'').'/></td>';
					$out .= '	<td><input name="detail['.$i.'][satuan]" value="'.$row->satuan.'" size="20" readonly="true" /></td>';
					$out .= '	<td align="center" valign="middle">';
					$out .= '		    <input name="detail['.$i.'][approve]" type="checkbox" '.($row->status=='1'?'checked="checked"':'').' '.($isApproved == TRUE?'disabled="disabled"':'').'/>';
					$out .= '	</td>';
					$out .= '</tr>';
					
					$i++;
					$no++;
				}
				$out .= '</table>';
				
				$out .= '</fieldset>';
				
				$baris++;
			} // akhir baca per baris
			
			// page terakhir 
			// ambil program dari tbl_masterpk_kl
			$kode_program='';
			$id_masterpk_kl='';
			
			$this->db->flush_cache();
			$this->db->select('*');
			$this->db->from('tbl_masterpk_kl a');
			$this->db->join('tbl_program_kl b', 'b.kode_program = a.kode_program and b.tahun = a.tahun', 'left');
			$this->db->where('a.tahun', $tahun);
			$this->db->where('a.kode_kl', $kode_kl);
			$que = $this->db->get();
			
			$out .= '<fieldset class="sectionwrap">';
			$out .= '	<table border="1" width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" style="height:10px;">';
			$out .= '	<tr>
							<td width="10px" bgcolor="#F5F5F5">No.</td>
							<td width="300px"bgcolor="#F5F5F5">Nama Program</td>
							<td width="30px" bgcolor="#F5F5F5">Total Anggaran (Rp.)</td>
							'.($isApproved == TRUE?'':'<td width="30px" bgcolor="#F5F5F5" align="center" valign="middle">&nbsp;</td>').'
						</tr>';
			if($que->num_rows() > 0){ // berarti data sudah disahkan, dan tampilkan data masternya
				$no=1;
				foreach($que->result() as $r){
				$out .= '<tr>
							<td>'.$no.'</td>
							<td>'.$r->nama_program.'</td>
							<td align="right">'.(number_format($r->total, 0, ',', '.')).'</td>
						</tr>';
					$no++;
				}
			}else{
				# ambil program di tbl program kegiatan
				$this->db->flush_cache();
				$this->db->select('*');
				$this->db->from('tbl_program_kl a');
				$this->db->where('a.tahun', $tahun);
				//$this->db->where('a.kode_kl', $kode_kl);
				$qu = $this->db->get();
				
				$no=1;
				foreach($qu->result() as $r){
				$out .= '<tr>
							<input type="hidden" name=program['.$no.'][kode_program] value="'.$r->kode_program.'">
							<td>'.$no.'</td>
							<td>'.$r->nama_program.'</td>
							<td align="right">'.(number_format($r->total, 0, ',', '.')).'</td>
							<td align="center" valign="middle"><input type="checkbox" name=program['.$no.'][approve]/></td>
						</tr>';
					$no++;
				}
			}
			
			$out .= '	</table>';
			$out .= '	<br>';
			$out .= '	<div class="fitem">';
			$out .= '<input type="button" onclick="cancel'.$objectId.'()" value="Keluar" />';
			$out .= '&nbsp;&nbsp;&nbsp;';
			$out .= ($isApproved == TRUE?'':'<input type="button" onclick="saveData'.$objectId.'()" value="Simpan" />');
			$out .= '	</div>';
			$out .= '</fieldset>';
			
		}else{
			$out = '';
		}
		
		return $out;
	}
	
	function isApproved($query){
		foreach($query->result() as $r){
			if($r->status == '1'){
				return TRUE;
			}
		}
		return FALSE;
	}
	
	public function UpdateDataPK($id_pk_kl, $penetapan, $status){
		$this->db->flush_cache();
		$this->db->set('penetapan', $penetapan);
		$this->db->set('status', $status);
		$this->db->where('id_pk_kl', $id_pk_kl);
		
		$result = $this->db->update('tbl_pk_kl'); 
		
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
	
	public function InsertDataMasterPK($tahun, $kode_kl, $kode_program){
		$this->db->flush_cache();
		$this->db->set('tahun', $tahun);
		$this->db->set('kode_kl', $kode_kl);
		$this->db->set('kode_program', $kode_program);
		
		$result = $this->db->insert('tbl_masterpk_kl'); 
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Insert to : ".$errMess." (".$errNo.")"); 
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function UpdateDataMasterPK($id_masterpk_kl, $kode_program){
		$this->db->flush_cache();
		//$this->db->set('tahun', $tahun);
		//$this->db->set('kode_kl', $kode_kl);
		$this->db->set('kode_program', $kode_program);
		
		$this->db->where('id_masterpk_kl', $id_masterpk_kl);
		
		$result = $this->db->update('tbl_masterpk_kl'); 
		
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
	
}
?>