<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class Satker_model extends CI_Model
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
	public function easyGrid($file1=null,$purpose=1){
		$lastNo = isset($_POST['lastNo']) ? intval($_POST['lastNo']) : 0;
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;  
		$limit = isset($_POST['rows']) ? intval($_POST['rows']) : 10;  
		
		$count = $this->GetRecordCount($file1);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'tbl_satker.kode_e1';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
		$offset = ($page-1)*$limit;  
		$pdfdata = array();
		if ($count>0){
			if($file1 != '' && $file1 != '-1' && $file1 != null) {
				$this->db->where("tbl_satker.kode_e1",$file1);
			}
			$this->db->order_by($sort." ".$order);
			if($purpose==1){$this->db->limit($limit,$offset);}
			$this->db->select("tbl_satker.*, tbl_eselon1.nama_e1",false);
			$this->db->from('tbl_satker');
			$this->db->join('tbl_eselon1', 'tbl_eselon1.kode_e1 = tbl_satker.kode_e1');
			$this->db->order_by("tbl_satker.kode_e1 ASC, tbl_satker.kode_satker ASC");
			$query = $this->db->get();
			
			$i=0;
			$no =$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['kode_e1']=$row->kode_e1;
				$response->rows[$i]['nama_e1']=$row->nama_e1;
				$response->rows[$i]['kode_satker']=$row->kode_satker;
				$response->rows[$i]['nama_satker']=$row->nama_satker;
				$response->rows[$i]['singkatan']=$row->singkatan;
				$response->rows[$i]['nama_kasatker']=$row->nama_kasatker;
				
				//utk kepentingan export pdf===================
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					$pdfdata[] = array($no,
								   $response->rows[$i]['kode_satker'],
								   $response->rows[$i]['nama_satker'],
								   $response->rows[$i]['singkatan'],
								   $response->rows[$i]['nama_kasatker']);
				else
					$pdfdata[] = array($no,
								   $response->rows[$i]['kode_e1'],
								   $response->rows[$i]['kode_satker'],
								   $response->rows[$i]['nama_satker'],
								   $response->rows[$i]['singkatan'],
								   $response->rows[$i]['nama_kasatker']);
				//============================================================

				//utk kepentingan export excel ==========================
				unset($row->nama_e1);
				if($file1 != '' && $file1 != '-1' && $file1 != null)
					unset($row->kode_e1);
				//============================================================

				$i++;
			}
			$response->lastNo = $no;
			// $query->free_result();
		} else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['kode_e1']='';
				$response->rows[$count]['nama_e1']='';
				$response->rows[$count]['kode_satker']='';
				$response->rows[$count]['nama_satker']='';
				$response->rows[$count]['singkatan']='';
				$response->rows[$count]['nama_kasatker']='';
				$response->lastNo = 0;	
		}
		
		if ($purpose==1) //grid normal
			return json_encode($response);
		else if($purpose==2){//pdf
			return $pdfdata;
		}
		else if($purpose==3){//to excel
			//tambahkan header kolom
			if($file1 != '' && $file1 != '-1' && $file1 != null)
				$colHeaders = array("Kode Satuan Kerja","Nama Satuan Kerja","Singkatan","Nama Kepala Satuan Kerja");
			else
				$colHeaders = array("Kode Satuan Kerja","Kode Eselon I","Nama Satuan Kerja","Singkatan","Nama Kepala Satuan Kerja");
			//var_dump($query->result());die;
			to_excel($query,"SatuanKerja",$colHeaders);
		}
	}
	
	public function isExistKode($kode=null){	
		if ($kode!=null)//utk update
			$this->db->where('kode_satker',$kode); //buat validasi
		
		$this->db->select('*');
		$this->db->from('tbl_satker');
						
		$query = $this->db->get();
		$rs = $query->num_rows() ;		
		$query->free_result();
		return ($rs>0);
	}
	
	//insert data
	public function InsertOnDb($data,& $error) {
		//query insert data		
		$this->db->set('kode_satker',$data['kode_satker']);
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('nama_satker',$data['nama_satker']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_kasatker',$data['nama_kasatker']);
		$this->db->set('log_insert', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result = $this->db->insert('tbl_satker');
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
		
		$this->db->where('kode_satker',$kode);
		
		$this->db->set('kode_e1',$data['kode_e1']);
		$this->db->set('nama_satker',$data['nama_satker']);
		$this->db->set('singkatan',$data['singkatan']);
		$this->db->set('nama_kasatker',$data['nama_kasatker']);
		$this->db->set('log_update', 		$this->session->userdata('user_id').';'.date('Y-m-d H:i:s'));
		
		$result=$this->db->update('tbl_satker');
		
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
		$this->db->where('kode_satker', $id);
		$result = $this->db->delete('tbl_satker'); 
		
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
	public function GetRecordCount($file1){
		if($file1 != '' && $file1 != '-1' && $file1 != null) {
			$this->db->where("kode_e1",$file1);
		}
		
		$query=$this->db->from('tbl_satker');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	// combobox
	//public function getListEselon2($objectId="",$e1="-1"){
	public function getListSatker($objectId="", $data=""){
		
		$name = isset($data['name'])?$data['name']:'kode_satker';
		$value = isset($data['value'])?$data['value']:'';
		$e1 = isset($data['e1'])?$data['e1']:'-1';
		
		$this->db->flush_cache();
		$this->db->select('kode_satker,nama_satker');
		$this->db->from('tbl_satker');
		$this->db->order_by('kode_satker');
		//var_dump($e1);
		if ($e1!="-1")
			$this->db->where('kode_e1',$e1);
		
		
		$que = $this->db->get();
		
		$out = '<select name="kode_satker" id="kode_satker'.$objectId.'" class="easyui-validatebox" required="true">';
		
		foreach($que->result() as $r){
			if($value == $r->kode_satker){
				$out .= '<option value="'.$r->kode_satker.'" selected="selected">'.$r->nama_satker.'</option>';
			}else{
				$out .= '<option value="'.$r->kode_satker.'">'.$r->nama_satker.'</option>';
			}
		}
		
		$out .= '</select>';
		
		echo $out;
	}
	
}
?>
