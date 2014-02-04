<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Eselon2_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	public function easyGrid($file1=null, $file2=null, $purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;  
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1, $file2);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_eselon2.kode_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			$this->db->order_by($sort." ".$order );
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("tbl_eselon2.*, tbl_eselon1.nama_e1",false);
			if(($file2 != '-1')&&($file2 != null)){
				$this->db->where("tbl_eselon2.kode_e2",$file2);
			}else if(($file1 != '-1')&&($file1 != null)){
				$this->db->where("tbl_eselon2.kode_e1",$file1);
			}
			$this->db->from('tbl_eselon2');
			$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_eselon2.kode_e1');
			$this->db->order_by("tbl_eselon2.kode_e1 ASC, tbl_eselon2.kode_e2 ASC, tbl_eselon2.nama_e2 ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_e2']=$row->kode_e2;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['nama_e2']=$row->nama_e2;
				$response->rows[$i]['singkatan']=$row->singkatan;
				$response->rows[$i]['nama_direktur']=$row->nama_direktur;
				$response->rows[$i]['nip']=$row->nip;
				$response->rows[$i]['pangkat']=$row->pangkat;
				$response->rows[$i]['gol']=$row->gol;
				
				//utk kepentingan export excel ==============================
				unset($row->nama_e1);
				if($file1 != '' && $file1 != '-1' && $file1 != null){
					unset($row->kode_e1);
					$colHeaders = array("Kode E2","Nama","Singkatan","Nama Pimpinan","NIP","Pangkat","Golongan");
				}
				else {$colHeaders = array("Kode E2","Kode E1","Nama","Singkatan","Nama Pimpinan","NIP","Pangkat","Golongan");}
					
				//===========================================================
					
				//utk kepentingan export pdf=================================
				if($file1 != '' && $file1 != '-1' && $file1 != null){
					$pdfdata[] = array($response->rows[$i]['no'],
										$response->rows[$i]['kode_e2'],
										$response->rows[$i]['nama_e2'],
										$response->rows[$i]['singkatan'],
										$response->rows[$i]['nama_direktur'],
										$response->rows[$i]['nip'],
										$response->rows[$i]['pangkat'],
										$response->rows[$i]['gol']);
				}
				else{
					$pdfdata[] = array($response->rows[$i]['no'],
										$response->rows[$i]['kode_e2'],
										$response->rows[$i]['kode_e1'],
										$response->rows[$i]['nama_e2'],
										$response->rows[$i]['singkatan'],
										$response->rows[$i]['nama_direktur'],
										$response->rows[$i]['nip'],
										$response->rows[$i]['pangkat'],
										$response->rows[$i]['gol']);
				}
				
				//===========================================================
				$i++;
			} 
			
			$response->lastNo = $no;
			//$query->free_result();
		}else {
				$response->rows[$count]['no']= "";
				$response->rows[$count]['kode_e2']='';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['nama_e2']='';
				$response->rows[$count]['singkatan']='';
				$response->rows[$count]['nama_direktur']='';
				$response->rows[$count]['nip']='';
				$response->rows[$count]['pangkat']='';
				$response->rows[$count]['gol']='';
				$response->lastNo = 0;
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
		//	$query =$this->db->list_fields('tbl_eselon1');
			//$query->list_fields();
		//	var_dump($query);die;
			to_excel($query,"Eselon2",$colHeaders);
		}
		else if ($purpose==4) { //WEB SERVICE
			return $response;
		}
	
	}
	
	//jumlah data record buat paging
	public function GetRecordCount($file1=null, $file2=null){
		if(($file2 != '-1')&&($file2 != null)){
				$this->db->where("kode_e2",$file2);
			}else if(($file1 != '-1')&&($file1 != null)){
				$this->db->where("kode_e1",$file1);
			}
		$query=$this->db->from('tbl_eselon2');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function isExistKode($kode=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_e2',$kode); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_eselon2');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	public function isSaveDelete($kode){	
		
		$this->db->where('kode_e2',$kode); //buat validasi		
		$this->db->select('*');
		$this->db->from('tbl_kegiatan_kl');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		$isSave = ($rs==0);
		if ($isSave){
			$this->db->flush_cache();
			$this->db->where('kode_e2',$kode); //buat validasi		
			$this->db->select('*');
			$this->db->from('tbl_sasaran_eselon2');
							
			$query = $this->db->get();
			$rs = $query->num_rows() ;		
			$query->free_result();
			$isSave = ($rs==0);
			if ($isSave){
				$this->db->flush_cache();
				$this->db->where('kode_e2',$kode); //buat validasi		
				$this->db->select('*');
				$this->db->from('tbl_ikk');
								
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
		$this->db->set('kode_e2',$data['kode_e2']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('nama_e2',$data['nama_e2']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_direktur',$data['nama_direktur']);
		$this->db->set('nip',$data['nip']);
		$this->db->set('pangkat',$data['pangkat']);
		$this->db->set('gol',$data['gol']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_eselon2');
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
		
		$this->db->where('kode_e2',$kode);
		
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('nama_e2',$data['nama_e2']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_direktur',$data['nama_direktur']);
		$this->db->set('nip',$data['nip']);
		$this->db->set('pangkat',$data['pangkat']);
		$this->db->set('gol',$data['gol']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_eselon2');
		
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
		$this->db->where('kode_e2', $id);
		$result = $this->db->delete('tbl_eselon2'); 
		
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
	
	// combobox
	//public function getListEselon2($objectId="",$e1="-1"){
	public function getListEselon2($objectId="", $data=""){
		
		//chan 
		$e2 = $this->session->userdata('unit_kerja_e2');
		
		$name = isset($data['name'])?$data['name']:'kode_e2';
		$value = isset($data['value'])?$data['value']:'';
		$e1 = isset($data['e1'])?$data['e1']:'-1';
		
		$this->db->flush_cache();
		$this->db->select('kode_e2,nama_e2');
		$this->db->from('tbl_eselon2');
		$this->db->order_by('kode_e2');
		//var_dump($e1);
		if ($e1!="-1")
			$this->db->where('kode_e1',$e1);
		
		if (($e2!=-1)&&($e2!=null)){
			$this->db->where('kode_e2',$e2);
			$value = $e2;
		}
		
		$que = $this->db->get();
		
		$out = '<select name="kode_e2" id="kode_e2'.$objectId.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			if($value == $r->kode_e2){
				$out .= '<option value="'.$r->kode_e2.'" selected="selected">'.$r->nama_e2.'</option>';
			}else{
				$out .= '<option value="'.$r->kode_e2.'">'.$r->nama_e2.'</option>';
			}
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
	public function getListFilterEselon2($objectId,$e1=-1,$unit_kerja_E2=-1,$withAll=true){
		
		$this->db->flush_cache();
		$this->db->select('kode_e2, nama_e2',false);
		$this->db->from('tbl_eselon2');
		if (($unit_kerja_E2 != "-1")&&($unit_kerja_E2 != null)&&($unit_kerja_E2 != ""))
			$this->db->where("kode_e2",$unit_kerja_E2);
			
		//$this->db->where("kode_e1",$unit_kerja_E2);
		//var_dump($e1);
		//if ($e1 != "-1")
		$this->db->where("kode_e1",$e1);
		$this->db->order_by('kode_e2');
		
		$que = $this->db->get();
		
		if (($unit_kerja_E2 == "-1")||($unit_kerja_E2 == "")){
			$out = '<select name="filter_e2'.$objectId.'" id="filter_e2'.$objectId.'" >';
			if ($withAll)
				$out .= '<option value="-1">Semua</option>';
			foreach($que->result() as $r){
				$out .= '<option value="'.$r->kode_e2.'">'.$r->nama_e2.'</option>';
			}
			
			$out .= '</select>';
		}
		else {
			if ($que->num_rows()>0){
				$out = '<label style="width:auto;height:15px;vertical-align:top">'.$que->row()->nama_e2.'</label>';
			}
			else
				$out = '<label style="width:auto;height:15px;vertical-align:top">Unit Kerja Eselon 2 belum diset</label>';
		}
		
		echo $out;
	}
	
	public function getNamaE2($id){
		$this->db->flush_cache();
		$this->db->select('nama_e2');
		$this->db->from('tbl_eselon2');
		$this->db->where('kode_e2', $id);
		//var_dump($id);die;
		$query = $this->db->get();
		
		return $query->row()->nama_e2;
		
	}
	
}
?>
