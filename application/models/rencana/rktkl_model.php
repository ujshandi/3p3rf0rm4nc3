<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Rktkl_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function easyGrid($filtahun=null, $purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($filtahun);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		$offset = ($page-1)*$limit;  
		
		if ($count>0){
			//filter
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("a.tahun",$filtahun);
			}			
			
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("a.id_rkt_kl, a.tahun, a.kode_kl, a.kode_iku_kl, a.kode_sasaran_kl, b.deskripsi, a.target, b.satuan, a.status",false);
			$this->db->select("c.deskripsi as deskripsi_sasaran_kl, b.deskripsi AS deskripsi_iku_kl, d.nama_kl",false);
			$this->db->from('tbl_rkt_kl a');
			$this->db->join('tbl_iku_kl b', 'b.kode_iku_kl = a.kode_iku_kl and b.tahun = a.tahun');
			$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl and c.tahun = a.tahun');
			$this->db->join('tbl_kl d', 'd.kode_kl = a.kode_kl');
			$this->db->order_by("a.tahun DESC, a.kode_sasaran_kl ASC, a.kode_iku_kl ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['id_rkt_kl']=$row->id_rkt_kl;
				$response->rows[$i]['tahun']= $row->tahun;
				$response->rows[$i]['kode_kl']= $row->kode_kl;
				$response->rows[$i]['nama_kl']= $row->nama_kl;
				$response->rows[$i]['kode_sasaran_kl']= $row->kode_sasaran_kl;
				$response->rows[$i]['deskripsi_sasaran_kl']= $row->deskripsi_sasaran_kl;
				$response->rows[$i]['deskripsi']= $row->deskripsi;
				$response->rows[$i]['kode_iku']= $row->kode_iku_kl;
				$response->rows[$i]['deskripsi_iku_kl']= $row->deskripsi_iku_kl;
/*
				if(is_numeric($row->target)){
					if(strpos($row->target, '.') || strpos($row->target, ',')){
						$response->rows[$i]['target'] = number_format($row->target, 2, ',', '.');
					}else{
						$response->rows[$i]['target'] = number_format($row->target, 0, ',', '.');
					}
					
				}else{
					$response->rows[$i]['target'] = $row->target;
				}
*/
				$response->rows[$i]['target']=$this->utility->cekNumericFmt($row->target);
				$response->rows[$i]['satuan']= $row->satuan;
				$response->rows[$i]['status']= $row->status;

				//utk kepentingan export excel ==========================
				// $row->keterangan = str_replace("<br>",", ",$response->rows[$i]['pejabat']);
				// $row->indikator_kinerja=$response->rows[$i]['indikator_kinerja'];
				//unset($row->id_rkt_kl);a.id_rkt_kl, a.tahun, a.kode_kl, a.kode_iku_kl
				unset($row->id_rkt_kl);
				unset($row->tahun);
				unset($row->kode_kl);
				unset($row->kode_iku_kl);
				unset($row->status);
				//============================================================
					
				//utk kepentingan export pdf===================
					$pdfdata[] = array($no,$response->rows[$i]['kode_sasaran_kl'],$response->rows[$i]['deskripsi'],$response->rows[$i]['target'],$response->rows[$i]['satuan']);
				//============================================================
					$i++;
			} 
			
			$response->lastNo = $no;
			//$query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['id_rkt_kl']='';
				$response->rows[$count]['tahun']='';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['nama_kl']='';
				$response->rows[$count]['kode_sasaran_kl']='';
				$response->rows[$count]['deskripsi_sasaran_kl']='';
				$response->rows[$count]['kode_iku']='';
				$response->rows[$count]['deskripsi_iku_kl']='';
				$response->rows[$count]['target']='';
				$response->rows[$count]['satuan']='';
				$response->rows[$count]['status']='';
				$response->lastNo = 0;
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Kode Sasaran","Indikator Kinerja Utama","Target","Satuan");		
			//var_dump($query->result());die;
			to_excel($query,"RKTKementerian",$colHeaders);
		}
		
	}
	
	public function GetRecordCount($filtahun=null){
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("a.tahun",$filtahun);
		}	
		
		$this->db->from('tbl_rkt_kl a');
			$this->db->join('tbl_iku_kl b', 'b.kode_iku_kl = a.kode_iku_kl and b.tahun = a.tahun');
			$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = a.kode_sasaran_kl and c.tahun = a.tahun');
			$this->db->join('tbl_kl d', 'd.kode_kl = a.kode_kl');
			
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	
	// combo box
	public function getListIKU_KL($objectId="", $data=""){
		// id dari tabel
		$kode_iku = isset($data['kode_iku'])?$data['kode_iku']:'0';
		$tahun = isset($data['tahun'])?$data['tahun']:'2012';
		$sasaran = isset($data['kode_sasaran_kl'])?$data['kode_sasaran_kl']:'-1';
		
		$id = isset($data['id'])?$data['id']:'0';
		$name = isset($data['name'])?$data['name']:'kode_iku_kl';
		$onclick = isset($data['onclick'])?$data['onclick']:'';
		
		
		$this->db->flush_cache();
		$this->db->select('kode_iku_kl, deskripsi');
		$this->db->from('tbl_iku_kl');
		$this->db->where('tahun', $tahun);
		//ditutup dulu bahas lebih lanjut 
		$this->db->where('kode_sasaran_kl', $sasaran);
		$this->db->order_by('kode_iku_kl');
		$que = $this->db->get();
		
		if($que->num_rows() > 0){
			
			/* $out = '<select id="'.$id.'" name="'.$name.'" onclick="'.$onclick.'" style=width:100%;>';
			$out .= '<option value="0">-- Pilih --</option>';
			foreach($que->result() as $r){
				if($r->kode_iku_kl == $kode_iku){
					$out .= '<option value="'.$r->kode_iku_kl.'" selected="selected">'.$r->deskripsi.'</option>';
				}else{
					$out .= '<option value="'.$r->kode_iku_kl.'">'.$r->deskripsi.'</option>';
				}
			}
			
			$out .= '</select>'; */
			$out = '<div id="tcContainer"><input id="'.$id.'" name="'.$name.'" type="hidden" class="h_code" value="0">';
			$out .= '<textarea name="txtkode_iku_kl'.$objectId.'" id="txtkode_iku_kl'.$objectId.'" class="textdown" required="true" readonly>-- Pilih --</textarea>';
			$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
			$out .= '<li value="0" onclick="setIku'.$objectId.'(\'\')">-- Pilih --</li>';
			
			foreach($que->result() as $r){
				$out .= '<li onclick="setIku'.$objectId.'(\''.$r->kode_iku_kl.'\')">'.$r->deskripsi.'</li>';
			}
			$out .= '</ul></div>';
			
			//chan
			if ($que->num_rows()==0){
				$out = "Data IKU untuk tingkat Eselon 1 ini belum tersedia.";
			}
			
			
		}else{
			$out = 'Tidak terdapat IKU pada tahun '.$tahun;
		}
		
		return $out;
	}
	
	public function getListIKU_KL_new($idx,$name,$objectId, $tahun, $sasaran){
		
		
		
		$this->db->flush_cache();
		$this->db->select('kode_iku_kl, deskripsi');
		$this->db->from('tbl_iku_kl');
		$this->db->where('tahun', $tahun);
		//ditutup dulu bahas lebih lanjut 
		$this->db->where('kode_sasaran_kl', $sasaran);
		$this->db->order_by('kode_iku_kl');
		$que = $this->db->get();
		
		if($que->num_rows() > 0){		
			$out = '<div id="tcContainer"><input id="kode_iku_kl'.$objectId.$idx.'" name="'.$name.'" type="hidden" class="h_code" value="0">';
			$out .= '<textarea name="txtkode_iku_kl'.$idx.'" id="txtkode_iku_kl'.$objectId.$idx.'" class="textdown" required="true" readonly>-- Pilih --</textarea>';
			$out .= '<ul id="drop'.$objectId.$idx.'" class="dropdown">';
			$out .= '<li value="0" onclick="setIku'.$objectId.'('.$idx.',\'\',\'\')">-- Pilih --</li>';
			
			foreach($que->result() as $r){
				$out .= '<li onclick="setIku'.$objectId.'('.$idx.',\''.$name.'\',\''.$r->kode_iku_kl.'\')">'.$r->deskripsi.'</li>';
			}
			$out .= '</ul></div>';
			
			//chan
			if ($que->num_rows()==0){
				$out = "Data IKU untuk tingkat Eselon 1 ini belum tersedia.";
			}
			
			
		}else{
			$out = 'Tidak terdapat IKU pada tahun '.$tahun;
		}
		
		return $out;
	}
	
	public function getIKU_kl($objectId, $kode_kl,$tahun,$sasaran){
		$outOld = '<tr>
					<td><input type="checkbox" name="chk'.$objectId.'[]"/></td>
					<td>1</td>
					<td>
						'.$this->rktkl_model->getListIKU_KL($objectId, array('id'=>'1', 'tahun' => $tahun ,'kode_sasaran_kl' => $sasaran , 'name'=>'detail[1][kode_iku_kl]', 'onclick'=>'javascript:getSatuan'.$objectId.'(this.value, this.id)')).'
					</td>
					<td>
						<input name="detail[1][target]" size="5">
					</td>
					<td>
						<input name="detail[1][satuan]" id="satuan1'.$objectId.'" type="text" value="" readonly="true">
					</td>
				</tr>';
		$data = $this->getDataExist($kode_kl,$tahun,$sasaran);
		$out ='';
		$i=1;
		if ($data->num_rows()>0) {
			
			foreach ($data->result() as $r){
				$out .= '<tr>'
					//<td><input type="checkbox" checked="checked" name="chk'.$objectId.'[]"/></td>
					.'<td>'.$i.'<input type="hidden" value="'.$r->id_rkt_kl.'" name="detail['.$i.'][id_rkt_kl]"></td>
					<td>'.$r->deskripsi.'<input type="hidden" name="detail['.$i.'][kode_iku_kl]" value="'.$r->kode_iku_kl.'">
					</td>
					<td>
						<input name="detail['.$i.'][target]" size="20" value="'.$this->utility->cekNumericFmt($r->target).'">
					</td>
					<td width="30px"><input name="detail['.$i.'][satuan]" id="satuan1'.$objectId.'" type="hidden" value="'.$r->satuan.'" readonly="true">
						'.$r->satuan.'
					</td>
				</tr>';		
				$i++;
			}
		}
		return $out;
	}
	
	private function getDataExist($kode_kl,$tahun,$kode_sasaran_kl){		
		
		$this->db->flush_cache();
		$this->db->select("a.id_rkt_kl, b.tahun, b.kode_kl, b.kode_iku_kl, b.kode_sasaran_kl, b.deskripsi, a.target, b.satuan, a.status",false);
			$this->db->select("c.deskripsi as deskripsi_sasaran_kl, b.deskripsi AS deskripsi_iku_kl, d.nama_kl",false);
			$this->db->from('tbl_iku_kl b');
			$this->db->join('tbl_sasaran_kl c', 'c.kode_sasaran_kl = b.kode_sasaran_kl and c.tahun = b.tahun');
			$this->db->join('tbl_kl d', 'd.kode_kl = b.kode_kl');
			$this->db->join('tbl_rkt_kl a', 'b.kode_iku_kl = a.kode_iku_kl and b.tahun = a.tahun','left');
			$this->db->order_by("b.tahun DESC, b.kode_sasaran_kl ASC, b.kode_iku_kl ASC");
		$this->db->where('c.kode_sasaran_kl', $kode_sasaran_kl);		
		$this->db->where('b.tahun', $tahun);		
		
		$query = $this->db->get();
		
			
		return $query;
	}
	
	public function getDataEdit($id){
		$this->db->flush_cache();
		$this->db->select('*, b.deskripsi as sasaran, c.deskripsi as iku_kl');
		$this->db->from('tbl_rkt_kl a');
		$this->db->join('tbl_sasaran_kl b', 'b.kode_sasaran_kl = a.kode_sasaran_kl');
		$this->db->join('tbl_iku_kl c', 'c.kode_iku_kl = a.kode_iku_kl and c.tahun = a.tahun');
		$this->db->join('tbl_kl d', 'd.kode_kl = a.kode_kl');
		$this->db->where('a.id_rkt_kl', $id);
		
		return $this->db->get()->row();
	}
	
	
	public function saveToDb($data){
		$this->db->trans_start();
		foreach($data['detail'] as $dt){
			$dt['tahun'] = $data['tahun'];
			$dt['kode_kl'] = $data['kode_kl'];
			$dt['kode_sasaran_kl'] = $data['kode_sasaran_kl'];
			if (($dt['id_rkt_kl']=="")||($dt['id_rkt_kl']==null)){				
				$this->InsertOnDB($dt);
			}
			else {
				$this->UpdateOnDb($dt);
			}
		}
		
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	
	
	public function InsertOnDB($data) {
		//$this->db->trans_start();
		$this->db->flush_cache();
		
		//foreach($data['detail'] as $dt){
			//query insert data		
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('kode_kl',			$data['kode_kl']);
			$this->db->set('kode_sasaran_kl',	$data['kode_sasaran_kl']);
			$this->db->set('kode_iku_kl',		$data['kode_iku_kl']);
			$this->db->set('target',			$data['target']);
			$this->db->set('status',			'0');
			$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			//$this->db->set('satuan',$data['satuan']);
			
			$result = $this->db->insert('tbl_rkt_kl');
			
			# insert to log
			/* $this->db->flush_cache();
			$this->db->set('tahun',				$data['tahun']);
			$this->db->set('kode_kl',			$data['kode_kl']);
			$this->db->set('kode_sasaran_kl',	$data['kode_sasaran_kl']);
			$this->db->set('kode_iku_kl',		$dt['kode_iku_kl']);
			$this->db->set('target',			$dt['target']);
			$this->db->set('status',			'0');
			$this->db->set('log',				'INSERT;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
			$this->db->insert('tbl_rkt_kl_log'); */
			
		//}
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
		
		//$this->db->trans_complete();
	    //return $this->db->trans_status();
	}
	
	public function UpdateOnDb($data){
		$this->db->flush_cache();
		
		
		# insert to log
		$this->db->flush_cache();
		$this->db->select("*");
		$this->db->from("tbl_rkt_kl");
		$this->db->where('id_rkt_kl', $data['id_rkt_kl']);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_kl',			$qt->row()->kode_kl);
		$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
		$this->db->set('kode_iku_kl', 		$qt->row()->kode_iku_kl);
		$this->db->set('target', 			$qt->row()->target);
		$this->db->set('log',				'UPDATE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$this->db->insert('tbl_rkt_kl_log');
		
		
		$this->db->flush_cache();
		$this->db->where('id_rkt_kl', $data['id_rkt_kl']);		
		$this->db->set('kode_iku_kl', $data['kode_iku_kl']);
		$this->db->set('target', $data['target']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->update('tbl_rkt_kl');
		
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
		$this->db->from("tbl_rkt_kl");
		$this->db->where('id_rkt_kl', $id);
		$qt = $this->db->get();
		
		$this->db->flush_cache();
		$this->db->set('tahun',				$qt->row()->tahun);
		$this->db->set('kode_kl',			$qt->row()->kode_kl);
		$this->db->set('kode_sasaran_kl',	$qt->row()->kode_sasaran_kl);
		$this->db->set('kode_iku_kl', 		$qt->row()->kode_iku_kl);
		$this->db->set('target', 			$qt->row()->target);
		$this->db->set('log',				'DELETE;'.$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		$this->db->insert('tbl_rkt_kl_log');
		
		# proses delete
		$this->db->flush_cache();
		$this->db->where('id_rkt_kl', $id);
		$result = $this->db->delete('tbl_rkt_kl'); 
		
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
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('tahun');
		$this->db->from('tbl_rkt_kl');
		$this->db->group_by('tahun');
		
		$que = $this->db->get();
		
		$out = '<select id="tahun'.$objectId.'" name="tahun'.$objectId.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->tahun.'">'.$r->tahun.'</option>';
		}
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data RKT belum tersedia.";
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getSatuan($id){
		$this->db->flush_cache();
		$this->db->select('satuan');
		$this->db->from('tbl_iku_kl');
		$this->db->where('kode_iku_kl', $id);
		$query = $this->db->get();
		
		return $query->row()->satuan;
		
	}

	public function data_exist($tahun, $kode_kl, $kode_sasaran_kl, $kode_iku_kl){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_rkt_kl');
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_kl', $kode_kl);
		//$this->db->where('kode_sasaran_kl', $kode_sasaran_kl);
		$this->db->where('kode_iku_kl', $kode_iku_kl);
		
		$que = $this->db->get();
		
		if ($que->num_rows()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function getListFilterTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_rkt_kl');
		
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
	
}
?>
