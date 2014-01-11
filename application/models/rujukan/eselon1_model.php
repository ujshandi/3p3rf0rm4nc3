<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Eselon1_model extends CI_Model
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
	public function easyGrid($purpose=1,$file1=null){
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount();
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$offset);
			$e1 = $this->session->userdata('unit_kerja_e1');
			if (($e1!=-1)&&($e1!=null)){
				$this->db->where('kode_e1',$e1);
				//$value = $e1;
			}
			if ($purpose==4){
				$this->db->where('kode_e1',$file1);
			}
			
			$this->db->select("kode_e1 as \"kode_e1\", tbl_eselon1.kode_kl as \"kode_kl\", nama_e1 as \"nama_e1\", tbl_eselon1.singkatan as \"singkatan\", nama_dirjen as \"nama_dirjen\", nip as \"nip\", pangkat as \"pangkat\", gol as \"gol\", tbl_kl.nama_kl",false);
			$this->db->from('tbl_eselon1');
			$this->db->join('tbl_kl', 'tbl_kl.kode_kl = tbl_eselon1.kode_kl');
			$this->db->order_by("tbl_eselon1.kode_e1 ASC, tbl_eselon1.nama_e1 ASC");
			$query = $this->db->get();
			
			$i=0;
			foreach ($query->result() as $row)
			{
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['kode_kl']=$row->kode_kl;
				$response->rows[$i]['nama_kl']=$row->nama_kl;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['singkatan']=$row->singkatan;
				$response->rows[$i]['nama_dirjen']=$row->nama_dirjen;
				$response->rows[$i]['nip']=$row->nip;
				$response->rows[$i]['pangkat']=$row->pangkat;
				$response->rows[$i]['gol']=$row->gol;
				

				//$pdfdata[] = array($i+1,$response->rows[$i]['kode_e1'],$response->rows[$i]['kode_kl'],$response->rows[$i]['nama_e1'],$response->rows[$i]['singkatan'],$response->rows[$i]['nama_dirjen'],$response->rows[$i]['nip'],$response->rows[$i]['pangkat'],$response->rows[$i]['gol']);
				$pdfdata[] = array($i+1,$response->rows[$i]['kode_e1'],$response->rows[$i]['nama_e1'],$response->rows[$i]['singkatan'],$response->rows[$i]['nama_dirjen'],$response->rows[$i]['nip'],$response->rows[$i]['pangkat'],$response->rows[$i]['gol']);
				unset($row->nama_kl);
				
				$i++;
			} 
			
			//$query->free_result();
		}else {
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['kode_kl']='';
				$response->rows[$count]['nama_kl']='';
				$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['singkatan']='';
				$response->rows[$count]['nama_dirjen']='';
				$response->rows[$count]['nip']='';
				$response->rows[$count]['pangkat']='';
				$response->rows[$count]['gol']='';
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			$colHeaders = array("Kode E1","Kode KL","Nama","Singkatan","Nama Pimpinan","NIP","Pangkat","Golongan");
		//	$query =$this->db->list_fields('tbl_eselon1');
			//$query->list_fields();
		//	var_dump($query);die;
			to_excel($query,"Eselon1",$colHeaders);
		}
		else if ($purpose==4) { //WEB SERVICE
			return $response;
		}
	
	}
	
	public function isExistKode($kode=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_e1',$kode); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_eselon1');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function isSaveDelete($kode){	
		
		$this->db->where('kode_e1',$kode); //buat validasi		
		$this->db->select('*');
		$this->db->from('tbl_program_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		$isSave = ($rs==0);
		if ($isSave){
			$this->db->flush_cache();
			$this->db->where('kode_e1',$kode); //buat validasi		
			$this->db->select('*');
			$this->db->from('tbl_sasaran_eselon1');
							
			$query = $this->db->get();
			$rs = $query->num_rows() ;		
			$query->free_result();
			$isSave = ($rs==0);
			if ($isSave){
				$this->db->flush_cache();
				$this->db->where('kode_e1',$kode); //buat validasi		
				$this->db->select('*');
				$this->db->from('tbl_iku_eselon1');
								
				$query = $this->db->get();
				$rs = $query->num_rows() ;		
				$query->free_result();
				$isSave = ($rs==0);
			}
		}
		return $isSave;
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('nama_e1',$data['nama_e1']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_dirjen',$data['nama_dirjen']);
		$this->db->set('nip',$data['nip']);
		$this->db->set('pangkat',$data['pangkat']);
		$this->db->set('gol',$data['gol']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_eselon1');
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

	//update data
	public function UpdateOnDb($data, $kode) {
		
		$this->db->where('kode_e1',$kode);
		
		$this->db->set('kode_kl',$data['kode_kl']);
		$this->db->set('nama_e1',$data['nama_e1']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_dirjen',$data['nama_dirjen']);
		$this->db->set('nip',$data['nip']);
		$this->db->set('pangkat',$data['pangkat']);
		$this->db->set('gol',$data['gol']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_eselon1');
		
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		//var_dump($errMess);die;
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	//hapus data
	public function DeleteOnDb($id){
		$this->db->flush_cache();
		$this->db->where('kode_e1', $id);
		$result = $this->db->delete('tbl_eselon1'); 
		
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
	
	//jumlah data record buat paging
	public function GetRecordCount(){
		$e1 = $this->session->userdata('unit_kerja_e1');
		if (($e1!=-1)&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			//$value = $e1;
		}
		$query=$this->db->from('tbl_eselon1');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function getListEselon1($objectId="", $data="",$required="true"){
		//chan 
		$e1 = $this->session->userdata('unit_kerja_e1');
		
		$name = isset($data['name'])?$data['name']:'kode_e1';
		$value = isset($data['value'])?$data['value']:'0';
		
		$this->db->flush_cache();
		$this->db->select('kode_e1,nama_e1');
		$this->db->from('tbl_eselon1');
		if (($e1!=-1)&&($e1!=null)){
			$this->db->where('kode_e1',$e1);
			$value = $e1;
		}
		
			if (FILTER_E1_LOCKING) $this->db->where('kode_e1 in ('.FILTER_E1_LIST.')');
		$this->db->order_by('kode_e1');
		
		$que = $this->db->get();
		
		$out = '<select name="kode_e1" id="kode_e1'.$objectId.'" class="easyui-validatebox" required="'.$required.'">';
		
		foreach($que->result() as $r){
			if($value == $r->kode_e1){
				$out .= '<option value="'.$r->kode_e1.'" Selected="selected">'.$r->nama_e1.'</option>';
			}else{
				$out .= '<option value="'.$r->kode_e1.'">'.$r->nama_e1.'</option>';
			}
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListFilterEselon1($objectId,$unit_kerja_E1,$plusSemua=true){
		
		$this->db->flush_cache();
		$this->db->select('kode_e1, nama_e1',false);
		$this->db->from('tbl_eselon1');
		if ($unit_kerja_E1 != "-1")
			$this->db->where("kode_e1",$unit_kerja_E1);
		$this->db->order_by('kode_e1');
		//if (FILTER_E1_LOCKING) $this->db->where('kode_e1 in ('.FILTER_E1_LIST.')');
		$que = $this->db->get();
		//var_dump($unit_kerja_E1);die;
		if ($unit_kerja_E1 == "-1"){
			$out = '<select name="filter_e1'.$objectId.'" id="filter_e1'.$objectId.'" >';
			if ($plusSemua)
				$out .= '<option value="-1">Semua</option>';
			foreach($que->result() as $r){
				$out .= '<option value="'.$r->kode_e1.'">'.$r->nama_e1.'</option>';
			}
			
			$out .= '</select>';
		}
		else {
			if ($que->num_rows()>0){
				$out = '<label style="width:auto;height:15px;vertical-align:top">'.$que->row()->nama_e1.'</label>';
			}
			else
				$out = '<label style="width:auto;height:15px;vertical-align:top">Unit Kerja Eselon 1 belum diset</label>';
		}
		
		echo $out;
	}
	
	
	
	public function getNamaE1($id){
		$this->db->flush_cache();
		$this->db->select('nama_e1');
		$this->db->from('tbl_eselon1');
		$this->db->where('kode_e1', $id);
		$query = $this->db->get();
		
		return $query->row()->nama_e1;
		
	}
	
}
?>
