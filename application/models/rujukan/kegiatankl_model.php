<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Kegiatankl_model extends CI_Model
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
	public function easyGrid($file1=null, $file2=null, $filtahun=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1,$file2,$filtahun);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tahun';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($file2 != '' && $file2 != '-1' && $file2 != null) {
				$this->db->where("kl.kode_e2",$file2);
			}
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("e2.kode_e1",$file1);
			}
			if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
				$this->db->where("kl.tahun",$filtahun);
			}
			
			if (($purpose==2)||($purpose==3))
				$this->db->order_by("kl.kode_e2,kl.kode_program, kl.kode_kegiatan");
			else
				$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("distinct kl.*, e2.nama_e2, pr.nama_program",false);
			$this->db->from('tbl_kegiatan_kl kl left join tbl_eselon2 e2 on kl.kode_e2 = e2.kode_e2',false);
			$this->db->join('tbl_program_kl pr','pr.kode_program = kl.kode_program and pr.tahun=kl.tahun');
			//$this->db->join('tbl_kegiatan','tbl_kegiatan.kode_kegiatan = tbl_kegiatan_kl.kode_kegiatan');
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				//$response->rows[$i]['id_rkt_kl']=$row->id_rkt_kl;
				//$response->rows[$i]['id_kegiatan_kl']	=$row->id_kegiatan_kl;
				$response->rows[$i]['kode_e2']			=$row->kode_e2;
				$response->rows[$i]['nama_e2']			=$row->nama_e2;
				$response->rows[$i]['tahun']			=$row->tahun;
				$response->rows[$i]['kode_program']		=$row->kode_program;
				$response->rows[$i]['nama_program']		=$row->nama_program;
				$response->rows[$i]['kode_kegiatan']	=$row->kode_kegiatan;
				$response->rows[$i]['nama_kegiatan']	=$row->nama_kegiatan;
				$response->rows[$i]['total']			=number_format( $row->total, 0, ',', '.');;

				//utk kepentingan export excel ============================
				unset($row->nama_e2);
				unset($row->nama_program);
				//unset($row->id_kegiatan_kl);
				if($file2 != '' && $file2 != '-1' && $file2 != null){
					unset($row->kode_e2);
					//tambahkan header kolom
					$colHeaders = array("Tahun","Kode Kegiatan","Nama Kegiatan","Kode Program","Total");		
				}
				else{
					$colHeaders = array("Tahun","Kode Kegiatan","Nama Kegiatan","Kode Program","Total","Kode E2");		
				}
				//=========================================================
					
				//utk kepentingan export pdf===============================
				if($file2 != '' && $file2 != '-1' && $file2 != null){
					$pdfdata[] = array($no,
									   $response->rows[$i]['tahun'],
									   $response->rows[$i]['kode_program'],
									   $response->rows[$i]['kode_kegiatan'],
									   $response->rows[$i]['nama_kegiatan'],
									   $response->rows[$i]['total']);
				}
				else{
					$pdfdata[] = array($no,
									   $response->rows[$i]['tahun'],
									   $response->rows[$i]['kode_program'],
									   $response->rows[$i]['kode_kegiatan'],
									   $response->rows[$i]['nama_kegiatan'],
									   $response->rows[$i]['total'],
									   $response->rows[$i]['kode_e2']);
				}
				//=========================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				//$response->rows[$count]['id_kegiatan_kl']	="";
				$response->rows[$count]['kode_e2']			="";
				$response->rows[$count]['nama_e2']			="";
				$response->rows[$count]['tahun']			="";
				$response->rows[$count]['kode_program']		="";
				$response->rows[$count]['nama_program']		="";
				$response->rows[$count]['kode_kegiatan']	="";
				$response->rows[$count]['nama_kegiatan']	="";
				$response->rows[$count]['total']			="";
				$response->lastNo = 0;
				
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
		//	var_dump($query->result());die;
			to_excel($query,"Kegiatan",$colHeaders);
		}
		else if ($purpose==4) { //WEB SERVICE
			return $response;
		}
	}
	
	public function GetRecordCount($file1=null,$file2=null,$filtahun=null){
		if($file2 != '' && $file2 != '-1' && $file2 != null) {
			$this->db->where("kl.kode_e2",$file2);
		}
		
		if($filtahun != '' && $filtahun != '-1' && $filtahun != null) {
			$this->db->where("kl.tahun",$filtahun);
		}
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("e2.kode_e1",$file1);
		}
		$this->db->flush_cache();
		$this->db->select("distinct *",false);
		$this->db->from('tbl_kegiatan_kl kl left join tbl_eselon2 e2 on kl.kode_e2 = e2.kode_e2',false);
			$this->db->join('tbl_program_kl pr','pr.kode_program = kl.kode_program and pr.tahun=kl.tahun');
		//$this->db->join('tbl_kegiatan','tbl_kegiatan.kode_kegiatan = tbl_kegiatan_kl.kode_kegiatan');
		
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function GetKodee2($kode_program){
		$this->db->flush_cache();
		//$this->db->select("*",false);
		$this->db->select('tbl_program_kl.kode_e2');
		$this->db->from('tbl_program_kl');
		$this->db->where('kode_program', $kode_program);
		//$this->db->join('tbl_kegiatan','tbl_kegiatan.kode_kegiatan = tbl_kegiatan_kl.kode_kegiatan');
		
		return $this->db->get();
	}
	
	public function getDataEdit($tahun,$kode_kegiatan){
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_kegiatan_kl a');
		$this->db->join('tbl_eselon2 b', 'b.kode_e2 = a.kode_e2');
		//$this->db->where('a.id_kegiatan_kl', $id);
		$this->db->where('a.tahun', $tahun);
		$this->db->where('a.kode_kegiatan', $kode_kegiatan);
		
		return $this->db->get()->row();
	}
	
	public function isExist($tahun,$kode,$oldtahun=null,$oldkode=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_kegiatan',$kode); //buat validasi
		if ($tahun!=null)//utk update
			$this->db->where('tahun',$tahun); //buat validasi
		if ($oldtahun!=null)
			$this->db->where('tahun !=',$oldtahun); //buat validasi
		if ($oldkode!=null)//utk update
			$this->db->where('kode_kegiatan !=',$oldkode); //buat validasi	
		$this->db->select('*');
		$this->db->from('tbl_kegiatan_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function isSaveDelete($kode,$tahun){	
		
		$this->db->where('kode_kegiatan',$kode); //buat validasi		
		$this->db->where('tahun',$tahun); //buat validasi		
		$this->db->select('*');
		$this->db->from('tbl_masterpk_eselon2');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		$isSave = ($rs==0);
		
		return $isSave;
	}
	
	public function InsertOnDB_kegiatanKL($data){
		//query insert data		
		$this->db->set('tahun', $data['tahun']);
		$this->db->set('kode_program',$data['kode_program']);
		$this->db->set('kode_kegiatan',$data['kode_kegiatan']);
		$this->db->set('nama_kegiatan',$data['nama_kegiatan']);
		$this->db->set('total',$this->utility->ourDeFormatNumber2($data['total']));
		//$kd = $this->GetKodee2($data['kode_program']);
		//$this->db->set('kode_e2',$kd->row()->kode_e2);
		$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_kegiatan_kl');
		
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
	
	public function UpdateOnDB_kegiatanKL($data){
		//query update data
		$this->db->flush_cache();
		$this->db->set('tahun', $data['tahun']);
		$this->db->set('kode_program',$data['kode_program']);
		$this->db->set('kode_kegiatan',$data['kode_kegiatan']);
		$this->db->set('nama_kegiatan',$data['nama_kegiatan']);
		$this->db->set('total',$this->utility->ourDeFormatNumber2($data['total']));
		$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		//$this->db->where('id_kegiatan_kl', $data['id_kegiatan_kl']);
		$this->db->where('tahun', $data['tahun']);
		$this->db->where('kode_kegiatan', $data['kode_kegiatan']);
		
		$result = $this->db->update('tbl_kegiatan_kl');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Updating to : ".$errMess." (".$errNo.")"); 
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	//hapus data
	public function DeleteOnDb($tahun,$kode_kegiatan){
		$this->db->flush_cache();
		//$this->db->where('id_kegiatan_kl', $id);
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_kegiatan', $kode_kegiatan);
		$result = $this->db->delete('tbl_kegiatan_kl'); 
		
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
	
	public function getNamaKegiatan($tahun,$kode_kegiatan){
		$this->db->flush_cache();
		$this->db->select('nama_kegiatan');
		$this->db->from('tbl_kegiatan_kl');
		//$this->db->where('id_kegiatan_kl', $id_kegiatan_kl);
		$this->db->where('tahun', $tahun);
		$this->db->where('kode_kegiatan', $kode_kegiatan);
		
		return $this->db->get()->row()->nama_kegiatan;
	}
	
	public function getListKegiatan($objectId="",$e2="",$data=""){
		
		$this->db->flush_cache();
		$this->db->select('kode_kegiatan, nama_kegiatan');
		$this->db->from('tbl_kegiatan_kl');
		//$this->db->order_by('id_kegiatan_kl');
		$this->db->order_by('tahun,kode_kegiatan');
		if($e2!=''){$this->db->where('kode_e2',$e2);}
		$que = $this->db->get();
		
		$e2 = ($e2=='')?'-1':$e2;
		//chan
		if ($data!=""){
			$kode = (isset($data['kode_kegiatan']))||($data['kode_kegiatan']=='')?$data['kode_kegiatan']:'0';
			$nama = (isset($data['nama_kegiatan'])||($data['nama_kegiatan']==''))?$data['nama_kegiatan']:'-- Pilih --';
		}
		else {
			$kode = '0';
			$nama = '-- Pilih --';
		}
		
		$out = '<div id="tcContainer"><input id="kode_kegiatan'.$objectId.'" name="kode_kegiatan" type="hidden" class="h_code" value="'.$kode.'">';
		$out .= '<textarea id="txtkode_kegiatan'.$objectId.'" name="txtkode_kegiatan'.$objectId.'" class="easyui-validatebox textdown" required="true" readonly>'.$nama.'</textarea>';
		$out .= '<ul id="drop'.$objectId.'" class="dropdown">';
		$out .= '<li value="0">-- Pilih --</li>';
		
		foreach($que->result() as $r){
			$out .= '<li onclick="setIKK'.$objectId.'(\''.$r->kode_kegiatan.'\')">'.$r->nama_kegiatan.'</li>';
		}
		$out .= '</ul></div>';
		
		//chan
		if ($que->num_rows()==0){
			$out = "Data Kegiatan untuk tingkat Eselon ini belum tersedia.";
		}
		
		/*
		$out = '<select name="kode_sasaran_e2" class="easyui-validatebox" required="true">';
		$out .= '<option value="0">-- Pilih Sasaran --</option>';
		foreach($que->result() as $r){
			$out .= '<option value="'.$r->kode_sasaran_e2.'">'.$r->deskripsi.'</option>';
		}
		
		$out .= '</select>';
		*/
		
		echo $out;
	}	
	
	
	
	public function getListTahun($objectId){
		
		$this->db->flush_cache();
		$this->db->select('distinct tahun',false);
		$this->db->from('tbl_kegiatan_kl');
		
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
