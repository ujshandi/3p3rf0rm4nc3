<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/
  
class Pengesahan_penetapaneselon2_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function getDetail($tahun, $kode_e2, $objectId){
		$out = '';
		$i = 1;
		
		# ambil jumlah sasaran di tabel sasaran
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_sasaran_eselon2');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_e2', $kode_e2);
		$q = $this->db->get();
		$jml_sasaran = $q->num_rows();   // jumlah sasaran
		
		# ambil jumlah sasaran di tabel penetapan
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_pk_eselon2 a');
		$this->db->join('tbl_sasaran_eselon2 b', 'a.kode_sasaran_e2 = b.kode_sasaran_e2 and a.tahun = b.tahun');
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_e2', $kode_e2);
		$this->db->group_by('a.kode_sasaran_e2');
		$q = $this->db->get();
		$jml_sasaran_pk = $q->num_rows();   // jumlah sasaran
		
		# jika data sasaran lengkap
		if($jml_sasaran == $jml_sasaran_pk && $jml_sasaran_pk>0){
		//if(true){
			
			# baca sasaran per baris
			$baris = 1;
			foreach($q->result() as $r){
				$out .= '<fieldset class="sectionwrap">';
				$out .= '	<div class="fitem">';
				$out .= '		<label style="width:110px">Sasaran Ke-'.$baris.' :</label><span style="display:block;margin-left: 110px;">'.$r->deskripsi.'</span>';
				$out .= '	</div>';
				
				# ambil ikk berdasarkan kode sasaran dan tahun
				$this->db->flush_cache();
				$this->db->select('*');
				$this->db->from('tbl_pk_eselon2 a');
				$this->db->join('tbl_ikk b', 'a.kode_ikk = b.kode_ikk and a.tahun = b.tahun');
				$this->db->where('a.tahun', $tahun);
				$this->db->where('a.kode_e2', $kode_e2);
				$this->db->where('a.kode_sasaran_e2', $r->kode_sasaran_e2);
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
									<input name="detail['.$i.'][id_pk_e2]" value="'.$row->id_pk_e2.'" type="hidden" />
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
			$kode_kegiatan='';
			$nama_kegiatan='nama_kegiatan';
			$id_masterpk_kl='';
			
			$this->db->flush_cache();
			$this->db->select('*');
			$this->db->from('tbl_masterpk_eselon2 a');
			$this->db->join('tbl_kegiatan_kl b', 'b.kode_kegiatan = a.kode_kegiatan and b.tahun = a.tahun');
			$this->db->where('a.tahun', $tahun);
			$this->db->where('a.kode_e2', $kode_e2);
			$que = $this->db->get();
			
			$out .= '<fieldset class="sectionwrap">';
			if($que->num_rows() > 0){
				$out .= '	<div class="fitem">';
				$out .= '		<label style="width:150px">Nama Kegiatan :</label>'.$que->row()->nama_kegiatan;
				$out .= '	</div>';
				$out .= '	<div class="fitem">';
				$out .= '		<label style="width:150px">Total Anggaran (Rp.) :</label>'.(number_format($que->row()->total, 0, ',', '.'));
				$out .= '	</div>';
			}else{
				# ambil kegiatan di tbl kegiatan
				$this->db->flush_cache();
				$this->db->select('*');
				$this->db->from('tbl_kegiatan_kl a');
				$this->db->where('a.tahun', $tahun);
				$this->db->where('a.kode_e2', $kode_e2);
				$qu = $this->db->get();
				
				$out .= '	<div class="fitem">';
				$out .= '		<label style="width:150px">Nama Kegiatan :</label>';
				$out .= '		<select name="kode_kegiatan" class="easyui-validatebox" required="true">';
				$out .= '			<option value="'.$qu->row()->kode_kegiatan.'">'.$qu->row()->nama_kegiatan.'</option>';
				$out .= '		</select>';
				$out .= '	</div>';
				$out .= '	<div class="fitem">';
				$out .= '		<label style="width:150px">Total Anggaran (Rp.) :</label>'.(number_format($qu->row()->total, 0, ',', '.'));
				$out .= '	</div>';
			}
			
			$out .= '	<br>';
			$out .= '	<div class="fitem">';
			$out .= '<label style="width:150px">&nbsp;</label><input type="button" onclick="cancel'.$objectId.'()" value="Keluar" />';
			$out .= '&nbsp;&nbsp;&nbsp;';
			$out .= ($isApproved == TRUE?'':'<input type="button" onclick="saveData'.$objectId.'()" value="Simpan" />');
			$out .= '	</div>';
			$out .= '</fieldset>';
			
		}else{
			$out = '';
			//$out = $jml_sasaran.'/'.$jml_sasaran_pk;
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
	
	public function UpdateDataPK($id_pk_e2, $penetapan, $status){
		$this->db->flush_cache();
		$this->db->set('penetapan', $penetapan);
		$this->db->set('status', $status);
		$this->db->where('id_pk_e2', $id_pk_e2);
		
		$result = $this->db->update('tbl_pk_eselon2'); 
		
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
	
	public function InsertDataMasterPK($tahun, $kode_e2, $kode_kegiatan){
		$this->db->flush_cache();
		$this->db->set('tahun', $tahun);
		$this->db->set('kode_e2', $kode_e2);
		$this->db->set('kode_kegiatan', $kode_kegiatan);
		
		$result = $this->db->insert('tbl_masterpk_eselon2'); 
		
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
	
	public function UpdateDataMasterPK($id_masterpk_e2, $kode_kegiatan){
		$this->db->flush_cache();
		//$this->db->set('tahun', $tahun);
		//$this->db->set('kode_e1', $kode_e1);
		$this->db->set('kode_kegiatan', $kode_kegiatan);
		
		$this->db->where('id_masterpk_e2', $id_masterpk_e2);
		
		$result = $this->db->update('tbl_masterpk_eselon1'); 
		
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